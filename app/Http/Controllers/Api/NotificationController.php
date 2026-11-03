<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserDevice;
use App\Services\FirebaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends BaseApiController
{
    /**
     * Register or update the device's FCM token for the authenticated user
     * 
     * Endpoint: POST /api/update-fcm-token
     */
    public function updateFcmToken(Request $request)
    {
        try {
            $request->validate([
                'fcm_token'    => 'required|string',
                'device_type'  => 'nullable|string|in:android,ios,web',
                'device_id'    => 'nullable|string|max:191',
                'device_model' => 'nullable|string|max:100',
                'app_version'  => 'nullable|string|max:50',
            ]);

            $user = Auth::user();

            if (!$user) {
                return $this->sendError('Unauthenticated', [], 401);
            }

            $deviceType  = strtolower($request->input('device_type', 'android'));
            $deviceId    = $request->input('device_id');
            $fcmToken    = trim($request->input('fcm_token'));
            $deviceModel = $request->input('device_model');
            $appVersion  = $request->input('app_version');

            // 1. Deactivate this FCM token from any other user (in case same device switched accounts)
            UserDevice::where('fcm_token', $fcmToken)
                ->where('user_id', '!=', $user->id)
                ->update(['is_active' => false]);

            // 2. Register or update device record
            if (!empty($deviceId)) {
                $device = UserDevice::updateOrCreate(
                    [
                        'user_id'   => $user->id,
                        'device_id' => $deviceId,
                    ],
                    [
                        'fcm_token'    => $fcmToken,
                        'device_type'  => $deviceType,
                        'device_model' => $deviceModel,
                        'app_version'  => $appVersion,
                        'is_active'    => true,
                        'last_used_at' => Carbon::now(),
                    ]
                );
            } else {
                $device = UserDevice::updateOrCreate(
                    [
                        'user_id'   => $user->id,
                        'fcm_token' => $fcmToken,
                    ],
                    [
                        'device_type'  => $deviceType,
                        'device_model' => $deviceModel,
                        'app_version'  => $appVersion,
                        'is_active'    => true,
                        'last_used_at' => Carbon::now(),
                    ]
                );
            }

            // 3. Keep fallback on users table updated
            try {
                $user->update(['fcm_token' => $fcmToken]);
            } catch (Exception $ignored) {
                // Column might not exist yet if migration hasn't run on server
            }

            return $this->sendResponse([
                'device_id'   => $device->device_id,
                'device_type' => $device->device_type,
                'is_active'   => (bool) $device->is_active,
                'updated_at'  => $device->updated_at->toIso8601String(),
            ], 'FCM token registered successfully');

        } catch (Exception $e) {
            $this->logException($e, 'Update FCM Token Error');
            return response()->json([
                'status'  => false,
                'message' => 'Failed to update FCM token',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove or deactivate an FCM token on user logout
     * 
     * Endpoint: POST /api/remove-fcm-token
     */
    public function removeFcmToken(Request $request)
    {
        try {
            $request->validate([
                'fcm_token' => 'nullable|string',
                'device_id' => 'nullable|string',
            ]);

            $user = Auth::user();

            if (!$user) {
                return $this->sendError('Unauthenticated', [], 401);
            }

            $query = UserDevice::where('user_id', $user->id);

            if ($request->filled('device_id')) {
                $query->where('device_id', $request->device_id);
            } elseif ($request->filled('fcm_token')) {
                $query->where('fcm_token', $request->fcm_token);
            }

            $query->update(['is_active' => false]);

            // Clear fallback if matches
            if ($request->filled('fcm_token') && $user->fcm_token === $request->fcm_token) {
                $user->update(['fcm_token' => null]);
            }

            return $this->sendResponse([], 'FCM token deactivated successfully');

        } catch (Exception $e) {
            $this->logException($e, 'Remove FCM Token Error');
            return response()->json([
                'status'  => false,
                'message' => 'Failed to remove FCM token',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send test push notification to authenticated user (convenient for mobile app dev testing)
     * 
     * Endpoint: POST /api/test-notification
     */
    public function testNotification(Request $request)
    {
        try {
            $user = Auth::user();

            $title = $request->input('title', 'Physiopii Notification Test 🩺');
            $body  = $request->input('body', 'Hello ' . $user->name . '! Push notifications are configured and working properly.');
            $data  = $request->input('data', [
                'type' => 'test_notification',
                'timestamp' => Carbon::now()->toIso8601String(),
                'user_id' => (string) $user->id,
                'role' => (string) $user->role,
            ]);

            $result = FirebaseService::sendToUser($user->id, $title, $body, (array)$data);

            return $this->sendResponse($result, 'Test notification triggered');

        } catch (Exception $e) {
            $this->logException($e, 'Test Notification Error');
            return response()->json([
                'status'  => false,
                'message' => 'Failed to send test notification',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
