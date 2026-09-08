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
            }            // Generate Unique Plan Code (e.g. PLN-20260907-P11-9A8B)
            $uniquePlanId = PatientPlanSubscription::generateUniquePlanId($patientId);

            // Create Subscription
            $subscription = PatientPlanSubscription::create([
                'unique_plan_id'         => $uniquePlanId,
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
                'unique_plan_id'         => $subscription->unique_plan_id,
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
    | Supports: appointment_id, unique_plan_id, patient_id
    */
    public function checkPlanAppointmentCompleted(Request $request)
    {
        Log::info('[Check Plan Appointment] Incoming Request', [
            'method'    => $request->method(),
            'url'       => $request->fullUrl(),
            'payload'   => $request->all(),
            'auth_user' => Auth::id() ?? auth('api')->id(),
        ]);

        try {
            $appointmentId = $request->input('appointment_id');
            $uniquePlanId  = $request->input('unique_plan_id') ?? $request->input('subscription_id');
            $patientId     = $request->input('patient_id') ?? Auth::id() ?? auth('api')->id();

            $appointment   = null;
            $subscription  = null;

            // Scenario 1: Check by specific appointment_id
            if (!empty($appointmentId) && is_numeric($appointmentId)) {
                $appointment = Appointment::with(['plan', 'subscription.plan'])->find($appointmentId);

                if (!$appointment) {
                    Log::warning('[Check Plan Appointment] Appointment not found', ['appointment_id' => $appointmentId]);
                    $res = [
                        'success' => false,
                        'message' => "Appointment with ID {$appointmentId} not found.",
                    ];
                    Log::info('[Check Plan Appointment] Outgoing Response (404)', $res);
                    return response()->json($res, 404);
                }

                $patientId = $appointment->patient_id;

                if ($appointment->subscription) {
                    $subscription = $appointment->subscription;
                } elseif ($appointment->patient_plan_subscription_id) {
                    $subscription = PatientPlanSubscription::with('plan')->find($appointment->patient_plan_subscription_id);
                } elseif (!empty($appointment->unique_plan_id)) {
                    $subscription = PatientPlanSubscription::with('plan')->where('unique_plan_id', $appointment->unique_plan_id)->first();
                }

                Log::info('[Check Plan Appointment] Resolved from appointment_id', [
                    'appointment_id'               => $appointment->id,
                    'appointment_status'           => $appointment->status,
                    'patient_id'                   => $appointment->patient_id,
                    'patient_plan_subscription_id' => $appointment->patient_plan_subscription_id,
                    'unique_plan_id'               => $appointment->unique_plan_id,
                    'subscription_found'           => $subscription ? $subscription->id : null,
                ]);
            }

            // Scenario 2: Check by unique_plan_id or subscription_id
            if (!$subscription && !empty($uniquePlanId)) {
                $subscription = PatientPlanSubscription::with('plan')
                    ->where('unique_plan_id', $uniquePlanId)
                    ->orWhere('id', is_numeric($uniquePlanId) ? (int)$uniquePlanId : 0)
                    ->first();

                if ($subscription) {
                    $patientId = $subscription->patient_id;
                    Log::info('[Check Plan Appointment] Resolved from unique_plan_id/subscription_id', [
                        'unique_plan_id'  => $uniquePlanId,
                        'subscription_id' => $subscription->id,
                        'patient_id'      => $patientId,
                    ]);
                }
            }

            // Scenario 3: Fallback to latest subscription for patient_id
            if (!$subscription) {
                if (!$patientId) {
                    Log::warning('[Check Plan Appointment] Rejected: Missing identifier', ['payload' => $request->all()]);
                    $res = [
                        'success' => false,
                        'message' => 'Either appointment_id, unique_plan_id, or patient_id is required.',
                    ];
                    Log::info('[Check Plan Appointment] Outgoing Response (422)', $res);
                    return response()->json($res, 422);
                }

                $subscription = PatientPlanSubscription::with('plan')
                    ->where('patient_id', (int) $patientId)
                    ->where('status', 'active')
                    ->latest('id')
                    ->first()
                    ?? PatientPlanSubscription::with('plan')
                    ->where('patient_id', (int) $patientId)
                    ->latest('id')
                    ->first();

                if ($subscription) {
                    Log::info('[Check Plan Appointment] Resolved from patient_id latest subscription', [
                        'patient_id'      => $patientId,
                        'subscription_id' => $subscription->id,
                        'status'          => $subscription->status,
                        'unique_plan_id'  => $subscription->unique_plan_id,
                    ]);
                }
            }

            // If still no subscription found for patient
            if (!$subscription) {
                Log::info('[Check Plan Appointment] Patient has no subscription in database', ['patient_id' => $patientId]);
                $res = [
                    'success'               => true,
                    'patient_id'            => (int) $patientId,
                    'appointment_id'        => $appointment ? $appointment->id : null,
                    'has_plan'              => false,
                    'appointment_completed' => false,
                    'latest_plan'           => null,
                    'message'               => 'Patient has not purchased any plan',
                ];
                Log::info('[Check Plan Appointment] Outgoing Response (No Plan)', $res);
                return response()->json($res, 200);
            }

            // Check completion status for this unique subscription batch
            $today = Carbon::today()->format('Y-m-d');

            // 1. Specific appointment completion (if appointment was provided)
            $thisApptCompleted = $appointment ? ($appointment->status === 'completed') : false;

            // 2. Query all appointments linked to this subscription
            $linkedApptsQuery = Appointment::where(function ($q) use ($subscription) {
                $q->where('patient_plan_subscription_id', $subscription->id);
                if (!empty($subscription->unique_plan_id)) {
                    $q->orWhere('unique_plan_id', $subscription->unique_plan_id);
                }
            });

            // Check if any appointment under this unique plan purchase exists or is completed
            $hasLinkedAppointments   = (clone $linkedApptsQuery)->exists();
            $linkedAppointmentsCount = (clone $linkedApptsQuery)->count();
            $completedAppts          = (clone $linkedApptsQuery)->where('status', 'completed')->get(['id', 'time_slot_id', 'appointment_date', 'status']);
            $anyLinkedCompleted      = $completedAppts->isNotEmpty();

            if ($hasLinkedAppointments) {
                // When appointments are linked, they are the absolute ground truth.
                // If any linked appointment has status = 'completed', the plan appointment is completed.
                $appointmentCompleted = $anyLinkedCompleted;

                Log::info('[Check Plan Appointment] Evaluated via linked appointments', [
                    'subscription_id'             => $subscription->id,
                    'unique_plan_id'              => $subscription->unique_plan_id,
                    'total_linked_appointments'   => $linkedAppointmentsCount,
                    'completed_appointments'      => $completedAppts->toArray(),
                    'any_linked_completed'        => $anyLinkedCompleted,
                    'used_appointments'           => $subscription->used_appointments,
                    'this_appt_completed'         => $thisApptCompleted,
                    'final_appointment_completed' => $appointmentCompleted,
                ]);
            } else {
                // No appointments linked directly yet to this subscription
                if ($subscription->used_appointments > 0) {
                    $appointmentCompleted = true;
                    Log::info('[Check Plan Appointment] Evaluated via used_appointments counter', [
                        'subscription_id'   => $subscription->id,
                        'used_appointments' => $subscription->used_appointments,
                    ]);
                } elseif ($subscription->created_at && $subscription->start_date) {
                    // Fallback only for legacy untagged data, strictly created on or after this subscription was bought
                    $dateQuery = Appointment::where('patient_id', $subscription->patient_id)
                        ->where('status', 'completed')
                        ->where('created_at', '>=', $subscription->created_at)
                        ->where('appointment_date', '>=', Carbon::parse($subscription->start_date)->format('Y-m-d'))
                        ->where('appointment_date', '<=', $today);

                    if ($subscription->end_date) {
                        $dateQuery->where('appointment_date', '<=', Carbon::parse($subscription->end_date)->format('Y-m-d'));
                    }

                    $appointmentCompleted = $dateQuery->exists();
                    Log::info('[Check Plan Appointment] Evaluated via legacy date fallback', [
                        'subscription_id' => $subscription->id,
                        'matches_found'   => $appointmentCompleted,
                    ]);
                } else {
                    $appointmentCompleted = false;
                }
            }

            $responseData = [
                'success'                        => true,
                'patient_id'                     => (int) $subscription->patient_id,
                'appointment_id'                 => $appointment ? $appointment->id : null,
                'has_plan'                       => true,
                'unique_plan_id'                 => $subscription->unique_plan_id ?? ("PLN-" . $subscription->id),
                'subscription_id'                => $subscription->id,
                'this_appointment_completed'     => $thisApptCompleted,
                'appointment_completed'          => $appointmentCompleted,
                'latest_plan'                    => [
                    'unique_plan_id'         => $subscription->unique_plan_id ?? ("PLN-" . $subscription->id),
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
            ];

            Log::info('[Check Plan Appointment] Outgoing Response (Success)', [
                'appointment_completed'      => $appointmentCompleted,
                'this_appointment_completed' => $thisApptCompleted,
                'subscription_id'            => $subscription->id,
                'unique_plan_id'             => $subscription->unique_plan_id,
                'used_appointments'          => $subscription->used_appointments,
                'remaining_appointments'     => $subscription->remaining_appointments,
            ]);

            return response()->json($responseData, 200);

        } catch (\Exception $e) {
            Log::error('[Check Plan Appointment] Exception occurred', [
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
            ]);
            $this->logException($e, 'Check Plan Appointment Completed Error');
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}