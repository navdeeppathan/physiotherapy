<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PatientPlan;
use App\Models\PatientPlanSubscription;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
            $patientId = $request->input('patient_id') ?? $request->input('user_id') ?? Auth::id() ?? auth('api')->id();
            $planId    = $request->input('patient_plan_id') ?? $request->input('plan_id') ?? $request->input('id');

            if (!$patientId) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Patient ID is required',
                ], 422);
            }

            if (!$planId) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Plan ID (patient_plan_id or plan_id) is required',
                ], 422);
            }

            $plan = PatientPlan::find($planId);
            if (!$plan) {
                return response()->json([
                    'status'  => false,
                    'message' => "Selected plan with ID {$planId} not found",
                ], 404);
            }

            // Calculate dates
            $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date) : Carbon::now();

            switch (strtolower((string) $plan->duration)) {
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

            // Create Subscription
            $subscription = PatientPlanSubscription::create([
                'patient_id'             => (int) $patientId,
                'patient_plan_id'        => $plan->id,
                'start_date'             => $startDate->toDateString(),
                'end_date'               => $endDate->toDateString(),
                'used_appointments'      => 0,
                'remaining_appointments' => (int) ($plan->total_appointments ?? 1),
                'payment_status'         => $request->payment_status ?? 'paid',
                'payment_method'         => $request->payment_method ?? 'Razorpay',
                'transaction_id'         => $request->transaction_id ?? ('TXN_' . strtoupper(uniqid())),
                'status'                 => 'active',
            ]);

            return $this->sendResponse([
                'subscription_id'        => $subscription->id,
                'patient_id'             => $subscription->patient_id,
                'patient_plan_id'        => $subscription->patient_plan_id,
                'plan_name'              => $plan->name,
                'start_date'             => $startDate->format('d M Y'),
                'end_date'               => $endDate->format('d M Y'),
                'total_appointments'     => (int) ($plan->total_appointments ?? 1),
                'used_appointments'      => 0,
                'remaining_appointments' => (int) ($plan->total_appointments ?? 1),
                'status'                 => $subscription->status,
                'payment_status'         => $subscription->payment_status,
                'data'                   => $subscription,
            ], 'Plan subscribed successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            $this->logException($e, 'Subscribe Plan Error');
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Check Plan Appointment Completed
    |--------------------------------------------------------------------------
    | POST/GET /api/patient/check-plan-appointment-completed
    */
    public function checkPlanAppointmentCompleted(Request $request)
    {
        try {
            $patientId = $request->patient_id ?? Auth::id() ?? auth('api')->id();

            if (!$patientId) {
                return response()->json([
                    'success' => false,
                    'message' => 'The patient_id field is required.',
                ], 422);
            }

            $patientId = (int) $patientId;
            $today     = Carbon::today()->format('Y-m-d');

            // 1. Find patient's latest plan subscription (with plan relationship)
            $subscription = PatientPlanSubscription::with('plan')
                ->where('patient_id', $patientId)
                ->latest('id')
                ->first();

            // 2. If no plan taken
            if (!$subscription) {
                return response()->json([
                    'success'               => true,
                    'patient_id'            => $patientId,
                    'has_plan'              => false,
                    'appointment_completed' => false,
                    'latest_plan'           => null,
                    'message'               => 'Patient has not purchased any plan',
                ], 200);
            }

            // 3. Check for at least one completed appointment under that plan up to current date
            $query = Appointment::where('patient_id', $patientId)
                ->where('status', 'completed')
                ->where('appointment_date', '<=', $today);

            if ($subscription->start_date) {
                $startDate = Carbon::parse($subscription->start_date)->format('Y-m-d');
                $query->where('appointment_date', '>=', $startDate);
            }

            if ($subscription->end_date) {
                $endDate = Carbon::parse($subscription->end_date)->format('Y-m-d');
                $query->where('appointment_date', '<=', min($today, $endDate));
            }

            // High performance exists() check or subscription usage check
            $hasCompletedAppointment = ($subscription->used_appointments > 0) || $query->exists();

            // 4. Return formatted response according to latest plan
            return response()->json([
                'success'               => true,
                'patient_id'            => $patientId,
                'has_plan'              => true,
                'appointment_completed' => $hasCompletedAppointment,
                'latest_plan'           => [
                    'subscription_id'        => $subscription->id,
                    'plan_id'                => $subscription->patient_plan_id,
                    'plan_name'              => optional($subscription->plan)->name,
                    'status'                 => $subscription->status,
                    'payment_status'         => $subscription->payment_status,
                    'start_date'             => $subscription->start_date ? Carbon::parse($subscription->start_date)->format('d M Y') : null,
                    'end_date'               => $subscription->end_date ? Carbon::parse($subscription->end_date)->format('d M Y') : null,
                    'total_appointments'     => optional($subscription->plan)->total_appointments ?? ($subscription->used_appointments + $subscription->remaining_appointments),
                    'used_appointments'      => (int) $subscription->used_appointments,
                    'remaining_appointments' => (int) $subscription->remaining_appointments,
                ],
            ], 200);

        } catch (\Exception $e) {
            $this->logException($e, 'Check Plan Appointment Completed Error');
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}