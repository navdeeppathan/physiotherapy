<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class UserSubscriptionController extends BaseApiController
{
    // 📌 Get all subscriptions
    public function index()
    {
        try {
            $data = UserSubscription::with('plan')->get();

            return $this->sendResponse([
                'status' => true,
                'data' => $data
            ], 'Subscriptions fetched successfully');
        } catch (\Exception $e) {
            $this->logException($e, 'Subscription Index Error');
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 📌 Get logged-in user subscription
    public function mySubscription(Request $request)
    {
        try {
            $subscription = UserSubscription::with('plan')
                ->where('user_id', $request->user()->id)
                ->where('status', 'active')
                ->first();

            return $this->sendResponse([
                'status' => true,
                'data' => $subscription
            ], 'My subscription fetched successfully');
        } catch (\Exception $e) {
            $this->logException($e, 'My Subscription Error');
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 📌 Assign plan to user (create subscription)
    public function store(Request $request)
    {
        try {
            $request->validate([
                'plan_id' => 'required|exists:plans,id'
            ]);

            $user = Auth::user();

            $plan = Plan::find($request->plan_id);

            // 🧠 Calculate end date
            $endDate = null;

            if ($plan->duration_days) {
                $endDate = now()->addDays($plan->duration_days);
            }

            // ❗ Expire old subscription
            UserSubscription::where('user_id', $user->id)
                ->where('status', 'active')
                ->update(['status' => 'expired']);

            $subscription = UserSubscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => $endDate,
                'status' => 'active'
            ]);

            return $this->sendResponse([
                'status' => true,
                'data' => $subscription
            ], 'Subscription created successfully');
        } catch (\Exception $e) {
            $this->logException($e, 'Subscription Store Error');
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 📌 Cancel subscription
    public function cancel(Request $request)
    {
        try {
            $user = Auth::user();

            $subscription = UserSubscription::where('user_id', $user->id)
                ->where('status', 'active')
                ->first();

            if (!$subscription) {
                return response()->json([
                    'status' => false,
                    'message' => 'No active subscription'
                ], 404);
            }

            $subscription->update([
                'status' => 'cancelled'
            ]);

            return $this->sendResponse([
                'status' => true,
                'data' => $subscription
            ], 'Subscription cancelled successfully');
        } catch (\Exception $e) {
            $this->logException($e, 'Subscription Cancel Error');
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 📌 Auto expire (cron job use)
    public function expireSubscriptions()
    {
        UserSubscription::where('status', 'active')
            ->whereNotNull('end_date')
            ->whereDate('end_date', '<', now())
            ->update(['status' => 'expired']);

        return response()->json([
            'status' => true,
            'message' => 'Expired subscriptions updated'
        ]);
    }
}