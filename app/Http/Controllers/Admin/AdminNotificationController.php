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
                'title'     => 'required|string|max:150',
                'body'      => 'required|string|max:1000',
                'target'    => 'required|in:all_doctors,all_patients,all_users,specific_user,selected_users',
                'user_id'   => 'nullable|required_if:target,specific_user|exists:users,id',
                'user_ids'  => 'nullable|required_if:target,selected_users|array',
                'user_ids.*'=> 'exists:users,id',
                'type'      => 'nullable|string|max:50',
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
}
