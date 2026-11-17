<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FirebaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminNotificationController extends Controller
{
    /**
     * Send push notification from admin panel to Doctors, Patients, or Specific Users
     * POST /admin/notifications/send
     */
    public function send(Request $request)
    {
        try {
            $request->validate([
                'title'      => 'required|string|max:150',
                'body'       => 'required|string|max:1000',
                'target'     => 'required|in:all_doctors,all_patients,all_users,specific_user,selected_users,direct_token',
                'fcm_token'  => 'nullable|required_if:target,direct_token|string',
                'user_id'    => 'nullable|required_if:target,specific_user|exists:users,id',
                'user_ids'   => 'nullable|required_if:target,selected_users|array',
                'user_ids.*' => 'exists:users,id',
                'type'       => 'nullable|string|max:50',
            ]);

            $target = $request->input('target');
            $title  = trim($request->input('title'));
            $body   = trim($request->input('body'));
            $type   = $request->input('type', 'admin_broadcast');

            $dataPayload = [
                'type'       => $type,
                'title'      => $title,
                'message'    => $body,
                'sent_by'    => 'admin',
                'timestamp'  => now()->toIso8601String(),
            ];

            // Direct FCM token test mode
            if ($target === 'direct_token') {
                $fcmToken = trim($request->input('fcm_token'));
                $result = FirebaseService::sendToToken($fcmToken, $title, $body, $dataPayload);

                if (!empty($result['success']) && !empty($result['response']['name'])) {
                    $googleMsgId = $result['response']['name'];
                    return response()->json([
                        'success'   => true,
                        'message'   => "Test notification successfully sent to device! (Google ID: {$googleMsgId})",
                        'token'     => substr($fcmToken, 0, 16) . '...',
                        'response'  => $result['response'] ?? null,
                    ]);
                } else {
                    $errorMsg = $result['error'] ?? 'Google FCM delivery failed.';
                    if (is_string($errorMsg)) {
                        $parsed = json_decode($errorMsg, true);
                        if (isset($parsed['error']['message'])) {
                            $errorMsg = $parsed['error']['message'];
                        }
                    }
                    return response()->json([
                        'success'   => false,
                        'message'   => "Google FCM Error: {$errorMsg}",
                        'raw_error' => $result['error'] ?? null,
                    ], 400);
                }
            }

            $userIds = [];

            switch ($target) {
                case 'all_doctors':
                    $userIds = User::where('role', 'doctor')
                        ->where('status', 'active')
                        ->pluck('id')
                        ->toArray();
                    $targetLabel = 'all active doctors';
                    break;

                case 'all_patients':
                    $userIds = User::where('role', 'patient')
                        ->where('status', 'active')
                        ->pluck('id')
                        ->toArray();
                    $targetLabel = 'all active patients';
                    break;

                case 'all_users':
                    $userIds = User::whereIn('role', ['doctor', 'patient'])
                        ->where('status', 'active')
                        ->pluck('id')
                        ->toArray();
                    $targetLabel = 'all doctors and patients';
                    break;

                case 'specific_user':
                    $userId = (int) $request->input('user_id');
                    $user = User::find($userId);
                    $userIds = $user ? [$user->id] : [];
                    $targetLabel = $user ? "{$user->name} (" . ucfirst($user->role) . ")" : "user #{$userId}";
                    break;

                case 'selected_users':
                    $userIds = array_map('intval', (array) $request->input('user_ids'));
                    $targetLabel = count($userIds) . ' selected user(s)';
                    break;
            }

            if (empty($userIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No eligible users found for the selected audience.'
                ], 422);
            }

            // Dispatch push notifications using FirebaseService
            $result = FirebaseService::sendToUsers($userIds, $title, $body, $dataPayload);

            $sentDevices = $result['sent'] ?? 0;
            $failedCount = $result['failed'] ?? 0;
            $totalUsers  = count($userIds);

            if ($sentDevices === 0) {
                $fcmStatus = FirebaseService::checkStatus();
                if (!$fcmStatus['configured']) {
                    $errorMessage = "Firebase credentials missing or invalid on server. storage/app/firebase-credentials.json not found.";
                } else {
                    $errorMessage = "0 mobile devices registered for {$targetLabel} ({$totalUsers} user(s)). Users have not logged into the mobile app to register their device tokens.";
                }

                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success'            => false,
                        'message'            => $errorMessage,
                        'target_users_count' => $totalUsers,
                        'sent_devices_count' => 0,
                        'failed_count'       => $failedCount,
                    ], 422);
                }

                return redirect()->back()->with('error', $errorMessage);
            }

            $message = "Notification dispatched to {$targetLabel} ({$totalUsers} user(s)). Delivered to {$sentDevices} device(s).";

            Log::info("Admin Push Notification: {$message} | Title: {$title}");

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'            => true,
                    'message'            => $message,
                    'target_users_count' => $totalUsers,
                    'sent_devices_count' => $sentDevices,
                    'failed_count'       => $failedCount,
                ]);
            }

            return redirect()->back()->with('success', $message);

        } catch (Exception $e) {
            Log::error("Admin Notification Send Error: " . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send notification: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to send notification: ' . $e->getMessage());
        }
    }

    /**
     * Test specific FCM token directly
     * POST /admin/notifications/test-token
     * POST /api/test-token-notification
     */
    public function testToken(Request $request)
    {
        try {
            $request->validate([
                'fcm_token' => 'required|string',
                'title'     => 'nullable|string|max:150',
                'body'      => 'nullable|string|max:500',
            ]);

            $title = $request->input('title', 'PhysioPii FCM Test 🔔');
            $body  = $request->input('body', 'This is a test notification from the PhysioPii Admin Panel to verify device token reception.');
            $token = trim($request->input('fcm_token'));

            $dataPayload = [
                'type'      => 'token_test',
                'timestamp' => now()->toIso8601String(),
                'title'     => $title,
                'body'      => $body,
            ];

            $result = FirebaseService::sendToToken($token, $title, $body, $dataPayload);

            if (!empty($result['success']) && !empty($result['response']['name'])) {
                $googleMsgId = $result['response']['name'];
                return response()->json([
                    'success'   => true,
                    'message'   => "Test notification successfully sent to device! (Google ID: {$googleMsgId})",
                    'token'     => substr($token, 0, 16) . '...',
                    'response'  => $result['response'] ?? null,
                ]);
            }

            $errorMsg = $result['error'] ?? 'Google FCM delivery failed.';
            if (is_string($errorMsg)) {
                $parsed = json_decode($errorMsg, true);
                if (isset($parsed['error']['message'])) {
                    $errorMsg = $parsed['error']['message'];
                }
            }

            return response()->json([
                'success'   => false,
                'message'   => "Google FCM Error: {$errorMsg}",
                'raw_error' => $result['error'] ?? null,
            ], 400);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error testing token: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check Firebase credentials status
     * GET /admin/notifications/status
     * GET /api/fcm-status
     */
    public function status()
    {
        return response()->json(FirebaseService::checkStatus());
    }

    /**
     * Save Firebase Service Account Credentials JSON to storage/app/firebase-credentials.json
     * POST /admin/notifications/save-credentials
     * POST /api/save-fcm-credentials
     */
    public function saveCredentials(Request $request)
    {
        try {
            $jsonContent = null;

            if ($request->hasFile('credentials_file')) {
                $file = $request->file('credentials_file');
                $jsonContent = file_get_contents($file->getRealPath());
            } elseif ($request->filled('credentials_json')) {
                $jsonContent = trim($request->input('credentials_json'));
            }

            if (!$jsonContent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please provide the service account JSON contents or upload the .json file.'
                ], 422);
            }

            $decoded = json_decode($jsonContent, true);
            if (!is_array($decoded)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid JSON format. Please verify the service account key from Google Firebase Console.'
                ], 422);
            }

            // Verify essential Google Service Account fields
            if (empty($decoded['private_key']) || empty($decoded['client_email']) || empty($decoded['project_id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing required Google Service Account fields (project_id, client_email, private_key).'
                ], 422);
            }

            $targetDir = storage_path('app');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $targetPath = storage_path('app/firebase-credentials.json');
            file_put_contents($targetPath, json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            // Clear any cached access token
            \Illuminate\Support\Facades\Cache::forget('fcm_google_access_token_' . md5($decoded['client_email']));

            // Validate immediately by authenticating with Google
            $status = FirebaseService::checkStatus();

            return response()->json([
                'success' => $status['configured'],
                'message' => $status['configured'] 
                    ? "Credentials saved! Successfully connected to Google Firebase project: {$decoded['project_id']}"
                    : "File saved, but Google authentication failed: {$status['message']}",
                'status'  => $status,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save credentials: ' . $e->getMessage()
            ], 500);
        }
    }
}
