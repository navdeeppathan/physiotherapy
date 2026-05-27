<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PatientPlan;
use App\Models\PatientPlanSubscription;
use Carbon\Carbon;

class PatientPlanController extends BaseApiController
{
    /*
    |--------------------------------------------------------------------------
    | Get All Patient Plans
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        try {

            $patient_id = $request->query('patient_id');

            $plans = PatientPlan::where('status', 'active')
                ->latest()
                ->get();

            $userSubscription = null;

            // ✅ Get patient active subscription
            if ($patient_id) {

                $userSubscription = PatientPlanSubscription::where('patient_id', $patient_id)
                    ->with('plan')
                    ->latest()
                    ->first();
            }

            return $this->sendResponse([
                'status' => true,
                'data' => $plans,
                'user_subscription' => $userSubscription
            ], 'Patient plans fetched successfully');

        } catch (\Exception $e) {

            $this->logException($e, 'Patient Plan Index Error');

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Subscribe Plan
    |--------------------------------------------------------------------------
    */

    public function subscribe(Request $request)
    {
        try {

            $request->validate([
                'patient_id' => 'required|exists:users,id',
                'patient_plan_id' => 'required|exists:patient_plans,id',
                'payment_method' => 'nullable|string',
                'transaction_id' => 'nullable|string',
            ]);

            $plan = PatientPlan::findOrFail($request->patient_plan_id);

            // ✅ Calculate End Date
            $startDate = Carbon::now();

            switch ($plan->duration) {

                case 'weekly':
                    $endDate = $startDate->copy()->addWeek();
                    break;

                case 'monthly':
                    $endDate = $startDate->copy()->addMonth();
                    break;

                case 'quarterly':
                    $endDate = $startDate->copy()->addMonths(3);
                    break;

                case 'half_yearly':
                    $endDate = $startDate->copy()->addMonths(6);
                    break;

                case 'yearly':
                    $endDate = $startDate->copy()->addYear();
                    break;

                default:
                    $endDate = $startDate->copy()->addMonth();
                    break;
            }

            // ✅ Create Subscription
            $subscription = PatientPlanSubscription::create([

                'patient_id' => $request->patient_id,
                'patient_plan_id' => $plan->id,

                'start_date' => $startDate,
                'end_date' => $endDate,

                'used_appointments' => 0,
                'remaining_appointments' => $plan->total_appointments,

                'payment_status' => 'paid',
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,

                'status' => 'active',
            ]);

            return $this->sendResponse([
                'status' => true,
                'data' => $subscription
            ], 'Plan subscribed successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            $this->logException($e, 'Subscribe Plan Error');

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}