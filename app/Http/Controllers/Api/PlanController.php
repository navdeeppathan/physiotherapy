<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends BaseApiController
{
    // 📌 Get all plans
    public function index()
    {
        try {
            $plans = Plan::all();

            return $this->sendResponse([
                'status' => true,
                'data' => $plans
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