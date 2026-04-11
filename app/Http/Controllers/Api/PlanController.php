<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;

class PlanController extends BaseApiController
{
    // 📌 Get all plans
    public function index()
    {
        try {
            $plans = Plan::all();
            $user = Auth::user();
            if(!$user) return $this->sendResponse(['status' => false, 'message' => 'You are not logged in'], 'You are not logged in');
            $userSubsciption = UserSubscription::where('user_id', $user->id)
            ->with('plan') // optional if you want plan details
            ->latest()->first();

            return $this->sendResponse([
                'status' => true,
                'data' => $plans,
                'user_subscription' => $userSubsciption
            ], 'Plans fetched successfully');

        } catch (\Exception $e) {
            $this->logException($e, 'Plan Index Error');
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 📌 Store new plan
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
                'price' => 'required|numeric',
                'billing_cycle' => 'required|in:free,monthly,yearly',
                'duration_days' => 'nullable|integer'
            ]);

            $plan = Plan::create($request->all());

            return $this->sendResponse([
                'data' => $plan
            ], 'Plan created successfully');

        } catch (\Exception $e) {
            $this->logException($e, 'Plan Store Error');
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 📌 Show single plan
    public function show($id)
    {
        try{
            $plan = Plan::find($id);

            if (!$plan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Plan not found'
                ], 404);
            }

            return $this->sendResponse([
                'data' => $plan
            ], 'Plan fetched successfully');
        } catch (\Exception $e) {
            $this->logException($e, 'Plan Show Error');
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 📌 Update plan
    public function update(Request $request, $id)
    {
        try {
            $plan = Plan::find($id);

            if (!$plan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Plan not found'
                ], 404);
            }

            $plan->update($request->all());

            return $this->sendResponse([
                'data' => $plan
            ], 'Plan updated successfully');
        } catch (\Exception $e) {
            $this->logException($e, 'Plan Update Error');
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 📌 Delete plan
    public function destroy($id)
    {
        try{
            $plan = Plan::find($id);

            if (!$plan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Plan not found'
                ], 404);
            }

            $plan->delete();

            return $this->sendResponse([
                'data' => $plan
            ], 'Plan deleted successfully');
        } catch (\Exception $e) {
            $this->logException($e, 'Plan Destroy Error');
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}