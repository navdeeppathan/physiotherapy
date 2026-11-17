<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class FirebaseService
{
    /**
     * Send push notification to a specific user by ID (all active registered devices)
     */
    public static function sendToUser($userId, string $title, string $body, array $data = []): array
    {
        $tokens = self::getUserTokens($userId);

        if (empty($tokens)) {
            Log::info("FirebaseService: No active FCM tokens found for User #{$userId}");
            return [
                'success' => false,
                'sent_count' => 0,
                'message' => 'No active device tokens found for user'
            ];
        }

        $sentCount = 0;
        $failedCount = 0;
        $invalidTokens = [];

        foreach ($tokens as $token) {
            $result = self::sendToToken($token, $title, $body, $data);
            if ($result['success']) {
                $sentCount++;
            } else {
                $failedCount++;
                if (!empty($result['invalid_token'])) {
                    $invalidTokens[] = $token;
                }
            }
        }

        // Clean up invalid or unregistered tokens automatically
        if (!empty($invalidTokens)) {
            UserDevice::whereIn('fcm_token', $invalidTokens)->update(['is_active' => false]);
            User::where('id', $userId)
                ->whereIn('fcm_token', $invalidTokens)
                ->update(['fcm_token' => null]);
        }

        return [
            'success' => $sentCount > 0,
            'sent_count' => $sentCount,
            'failed_count' => $failedCount
        ];
    }

    /**
     * Send push notification to multiple users
     */
    public static function sendToUsers(array $userIds, string $title, string $body, array $data = []): array
    {
        $summary = ['sent' => 0, 'failed' => 0];
        foreach (array_unique($userIds) as $userId) {
            $res = self::sendToUser($userId, $title, $body, $data);
            if ($res['success']) {
                $summary['sent'] += $res['sent_count'];
            } else {
                $summary['failed']++;
            }
        }
        return $summary;
    }

    /**
     * Send push notification directly to an FCM device token
     */
    public static function sendToToken(string $fcmToken, string $title, string $body, array $data = []): array
    {
        if (empty(trim($fcmToken))) {
            return ['success' => false, 'error' => 'Empty FCM token'];
        }

        // Convert all data payload values to strings (FCM Requirement)
        $stringData = [];
        foreach ($data as $k => $v) {
            $stringData[(string) $k] = is_array($v) || is_object($v) ? json_encode($v) : (string) $v;
        }

        // 1. Try FCM HTTP v1 (Modern OAuth2 via Service Account JSON)
        $serviceAccount = self::getServiceAccountConfig();
        if ($serviceAccount) {
            return self::sendViaHttpV1($serviceAccount, $fcmToken, $title, $body, $stringData);
        }

        // 2. Fallback to Legacy Server Key (if configured)
        $legacyKey = config('services.firebase.server_key');
        if (!empty($legacyKey)) {
            return self::sendViaLegacyKey($legacyKey, $fcmToken, $title, $body, $stringData);
        }

        // 3. Fallback: Missing credentials error (DO NOT silently return success)
        Log::error("[FCM Failed] Notification to Token: " . substr($fcmToken, 0, 16) . "... | Title: {$title} | Error: Firebase credentials missing on server.");
        return [
            'success'             => false,
            'simulated'           => false,
            'credentials_missing' => true,
            'error'               => 'Firebase credentials file missing on server (storage/app/firebase-credentials.json not found).'
        ];
    }

    /**
     * Send using Firebase Cloud Messaging HTTP v1 API
     */
    protected static function sendViaHttpV1(array $serviceAccount, string $fcmToken, string $title, string $body, array $data): array
    {
        try {
            $accessToken = self::getGoogleAccessToken($serviceAccount);
            if (!$accessToken) {
                return ['success' => false, 'error' => 'Failed to obtain Google OAuth2 access token'];
            }

            $projectId = $serviceAccount['project_id'] ?? config('services.firebase.project_id');
            $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

            $payload = [
                'message' => [
                    'token' => $fcmToken,
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                    ],
                    'data' => $data,
                    'android' => [
                        'priority' => 'HIGH',
                        'notification' => [
                            'sound' => 'default',
                            'channel_id' => 'high_importance_channel',
                            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        ]
                    ],
                    'apns' => [
                        'headers' => [
                            'apns-priority' => '10'
                        ],
                        'payload' => [
                            'aps' => [
                                'sound' => 'default',
                                'badge' => 1,
                                'content-available' => 1
                            ]
                        ]
                    ]
                ]
            ];

            $response = Http::withoutVerifying()
                ->timeout(10)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type'  => 'application/json',
                ])
                ->post($url, $payload);

            if ($response->successful()) {
                return ['success' => true, 'response' => $response->json()];
            }

            $respData = $response->json();
            $errorCode = $respData['error']['details'][0]['errorCode'] ?? ($respData['error']['status'] ?? '');
            $isInvalid = in_array($errorCode, ['UNREGISTERED', 'INVALID_ARGUMENT', 'NOT_FOUND']);

            Log::warning("FCM HTTP v1 Error: " . $response->body());
            return [
                'success' => false,
                'invalid_token' => $isInvalid,
                'error' => $response->body()
            ];

        } catch (Exception $e) {
            Log::error("FCM HTTP v1 Exception: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Send using Legacy FCM API
     */
    protected static function sendViaLegacyKey(string $serverKey, string $fcmToken, string $title, string $body, array $data): array
    {
        try {
            $response = Http::withoutVerifying()
                ->timeout(10)
                ->withHeaders([
                    'Authorization' => 'key=' . $serverKey,
                    'Content-Type'  => 'application/json',
                ])
                ->post('https://fcm.googleapis.com/fcm/send', [
                    'to' => $fcmToken,
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                        'sound' => 'default',
                    ],
                    'data'     => $data,
                    'priority' => 'high'
                ]);

            if ($response->successful()) {
                return ['success' => true, 'response' => $response->json()];
            }

            return ['success' => false, 'error' => $response->body()];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Obtain Google OAuth2 Access Token for HTTP v1 using Service Account JWT
     */
    protected static function getGoogleAccessToken(array $serviceAccount): ?string
    {
        $cacheKey = 'fcm_google_access_token_' . md5($serviceAccount['client_email']);
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $now = time();
            $header = json_encode(['alg' => 'RS256', 'typ' => 'JWT']);
            $claimSet = json_encode([
                'iss'   => $serviceAccount['client_email'],
                'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
                'aud'   => 'https://oauth2.googleapis.com/token',
                'exp'   => $now + 3600,
                'iat'   => $now,
            ]);

            $base64UrlHeader = self::base64UrlEncode($header);
            $base64UrlClaim  = self::base64UrlEncode($claimSet);
            $signatureInput  = $base64UrlHeader . '.' . $base64UrlClaim;

            $privateKey = $serviceAccount['private_key'];
            $binarySignature = '';

            $success = openssl_sign($signatureInput, $binarySignature, $privateKey, OPENSSL_ALGO_SHA256);
            if (!$success) {
                Log::error('FCM Service: OpenSSL failed to sign Google JWT assertion.');
                return null;
            }

            $jwt = $signatureInput . '.' . self::base64UrlEncode($binarySignature);

            $response = Http::withoutVerifying()
                ->asForm()
                ->post('https://oauth2.googleapis.com/token', [
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                    'assertion'  => $jwt,
                ]);

            if ($response->successful()) {
                $tokenData = $response->json();
                $accessToken = $tokenData['access_token'] ?? null;
                $expiresIn = (int) ($tokenData['expires_in'] ?? 3600);

                if ($accessToken) {
                    Cache::put($cacheKey, $accessToken, max(60, $expiresIn - 300));
                    return $accessToken;
                }
            }

            Log::error('FCM OAuth2 Exchange failed: ' . $response->body());
            return null;

        } catch (Exception $e) {
            Log::error('FCM OAuth2 Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Retrieve Service Account configuration from file or json string
     */
    protected static function getServiceAccountConfig(): ?array
    {
        $credPath = config('services.firebase.credentials_file');

        if (!empty($credPath) && file_exists($credPath)) {
            $json = json_decode(file_get_contents($credPath), true);
            if (is_array($json) && !empty($json['private_key']) && !empty($json['client_email'])) {
                return $json;
            }
        }

        // Support passing raw JSON string directly via environment variable
        $envJson = env('FIREBASE_SERVICE_ACCOUNT_JSON');
        if (!empty($envJson)) {
            $decoded = json_decode($envJson, true);
            if (is_array($decoded) && !empty($decoded['private_key']) && !empty($decoded['client_email'])) {
                return $decoded;
            }
        }

        return null;
    }

    /**
     * Collect all valid tokens for a user
     */
    protected static function getUserTokens($userId): array
    {
        $tokens = UserDevice::where('user_id', $userId)
            ->where('is_active', true)
            ->pluck('fcm_token')
            ->toArray();

        // Also check fallback token on users table
        $user = User::find($userId);
        if ($user && !empty($user->fcm_token) && !in_array($user->fcm_token, $tokens)) {
            $tokens[] = $user->fcm_token;
        }

        return array_values(array_unique(array_filter($tokens)));
    }

    /**
     * Diagnostic helper: Check whether Firebase credentials exist and work
     */
    public static function checkStatus(): array
    {
        $serviceAccount = self::getServiceAccountConfig();
        if (!$serviceAccount) {
            return [
                'configured' => false,
                'status'     => 'missing',
                'message'    => 'Firebase credentials file missing (storage/app/firebase-credentials.json not found).',
                'project_id' => config('services.firebase.project_id', 'physiopii'),
                'client_email' => null,
            ];
        }

        $token = self::getGoogleAccessToken($serviceAccount);
        if (!$token) {
            return [
                'configured' => false,
                'status'     => 'oauth_failed',
                'message'    => 'Credentials file found, but Google OAuth2 authentication failed. Check private key.',
                'project_id' => $serviceAccount['project_id'] ?? null,
                'client_email' => $serviceAccount['client_email'] ?? null,
            ];
        }

        return [
            'configured'   => true,
            'status'       => 'connected',
            'message'      => 'Successfully authenticated with Google FCM HTTP v1 API.',
            'project_id'   => $serviceAccount['project_id'] ?? null,
            'client_email' => $serviceAccount['client_email'] ?? null,
        ];
    }

    protected static function base64UrlEncode(string $data): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }
}
