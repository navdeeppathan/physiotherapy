<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\AssessmentExercise;
use App\Models\AssessmentGoal;
use App\Models\AssessmentParameter;
use App\Models\PatientAssessment;
use App\Models\PatientSession;
use App\Models\Specializations;
use App\Models\MasterParameter;
use App\Models\Appointment;
use App\Models\PatientPlanSubscription;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssessmentController extends BaseApiController
{
    // ─────────────────────────────────────────────────────────
    // STEP 1: Conditions (from specializations table)
    // ─────────────────────────────────────────────────────────

    /**
     * GET /api/assessment/conditions
     * Returns specializations as selectable conditions for Step 1
     */
    public function conditions()
    {
        try {
            $conditions = Specializations::where('status', 'active')
                ->orderBy('name')
                ->get()
                ->map(fn($s) => [
                    'id'   => $s->id,
                    'name' => $s->name,
                    'icon' => $s->icon ? asset($s->icon) : null,
                    'description' => $s->description,
                ]);

            return $this->sendResponse($conditions, 'Conditions fetched successfully');

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────
    // STEP 2: Parameters master list
    // ─────────────────────────────────────────────────────────

    /**
     * GET /api/assessment/parameters
     * Returns the master list of trackable parameters for Step 2
     */
    public function parameters()
    {
        try {
            $dbParams = MasterParameter::where('status', 'active')
                ->orderBy('sort_order', 'asc')
                ->get();

            if ($dbParams->isNotEmpty()) {
                $parameters = $dbParams->map(function ($p) {
                    return [
                        'id'       => $p->id,
                        'key'      => $p->key,
                        'label'    => $p->label,
                        'unit'     => $p->unit,
                        'icon_key' => $p->icon_key ?? $p->key,
                        'icon_url' => $p->icon_url,
                        'icon'     => $p->icon_url,
                    ];
                });

                return $this->sendResponse($parameters, 'Parameters fetched successfully');
            }
        } catch (Exception $e) {
            // Fallback if table not migrated yet
        }

        $parameters = [
            [
                'key'      => 'pain_score',
                'label'    => 'Pain Score (0–10)',
                'unit'     => 'score',
                'icon_key' => 'pain_score',
                'icon_url' => url('assets/img/parameters/pain_score.svg'),
                'icon'     => url('assets/img/parameters/pain_score.svg'),
            ],
            [
                'key'      => 'lumbar_flexion',
                'label'    => 'Lumbar Flexion (°)',
                'unit'     => '°',
                'icon_key' => 'lumbar_flexion',
                'icon_url' => url('assets/img/parameters/lumbar_flexion.svg'),
                'icon'     => url('assets/img/parameters/lumbar_flexion.svg'),
            ],
            [
                'key'      => 'lumbar_extension',
                'label'    => 'Lumbar Extension (°)',
                'unit'     => '°',
                'icon_key' => 'lumbar_extension',
                'icon_url' => url('assets/img/parameters/lumbar_extension.svg'),
                'icon'     => url('assets/img/parameters/lumbar_extension.svg'),
            ],
            [
                'key'      => 'side_flexion_right',
                'label'    => 'Side Flexion Right (°)',
                'unit'     => '°',
                'icon_key' => 'side_flexion_right',
                'icon_url' => url('assets/img/parameters/side_flexion_right.svg'),
                'icon'     => url('assets/img/parameters/side_flexion_right.svg'),
            ],
            [
                'key'      => 'side_flexion_left',
                'label'    => 'Side Flexion Left (°)',
                'unit'     => '°',
                'icon_key' => 'side_flexion_left',
                'icon_url' => url('assets/img/parameters/side_flexion_left.svg'),
                'icon'     => url('assets/img/parameters/side_flexion_left.svg'),
            ],
            [
                'key'      => 'straight_leg_raise_r',
                'label'    => 'Straight Leg Raise (R)',
                'unit'     => '°',
                'icon_key' => 'straight_leg_raise_r',
                'icon_url' => url('assets/img/parameters/straight_leg_raise_r.svg'),
                'icon'     => url('assets/img/parameters/straight_leg_raise_r.svg'),
            ],
            [
                'key'      => 'straight_leg_raise_l',
                'label'    => 'Straight Leg Raise (L)',
                'unit'     => '°',
                'icon_key' => 'straight_leg_raise_l',
                'icon_url' => url('assets/img/parameters/straight_leg_raise_l.svg'),
                'icon'     => url('assets/img/parameters/straight_leg_raise_l.svg'),
            ],
            [
                'key'      => 'core_strength',
                'label'    => 'Core Strength',
                'unit'     => 'grade',
                'icon_key' => 'core_strength',
                'icon_url' => url('assets/img/parameters/core_strength.svg'),
                'icon'     => url('assets/img/parameters/core_strength.svg'),
            ],
            [
                'key'      => 'walking_tolerance',
                'label'    => 'Walking Tolerance (min)',
                'unit'     => 'min',
                'icon_key' => 'walking_tolerance',
                'icon_url' => url('assets/img/parameters/walking_tolerance.svg'),
                'icon'     => url('assets/img/parameters/walking_tolerance.svg'),
            ],
            [
                'key'      => 'sitting_tolerance',
                'label'    => 'Sitting Tolerance (min)',
                'unit'     => 'min',
                'icon_key' => 'sitting_tolerance',
                'icon_url' => url('assets/img/parameters/sitting_tolerance.svg'),
                'icon'     => url('assets/img/parameters/sitting_tolerance.svg'),
            ],
            [
                'key'      => 'standing_tolerance',
                'label'    => 'Standing Tolerance (min)',
                'unit'     => 'min',
                'icon_key' => 'standing_tolerance',
                'icon_url' => url('assets/img/parameters/standing_tolerance.svg'),
                'icon'     => url('assets/img/parameters/standing_tolerance.svg'),
            ],
            [
                'key'      => 'sleep_quality',
                'label'    => 'Sleep Quality',
                'unit'     => 'grade',
                'icon_key' => 'sleep_quality',
                'icon_url' => url('assets/img/parameters/sleep_quality.svg'),
                'icon'     => url('assets/img/parameters/sleep_quality.svg'),
            ],
            [
                'key'      => 'functional_disability',
                'label'    => 'Functional Disability (ODI%)',
                'unit'     => '%',
                'icon_key' => 'functional_disability',
                'icon_url' => url('assets/img/parameters/functional_disability.svg'),
                'icon'     => url('assets/img/parameters/functional_disability.svg'),
            ],
        ];

        return $this->sendResponse($parameters, 'Parameters fetched successfully');
    }

    // ─────────────────────────────────────────────────────────
    // Create Full Assessment (Steps 1–5 in one call)
    // ─────────────────────────────────────────────────────────

    /**
     * POST /api/assessment/create
     */
    public function create(Request $request)
    {
        try {
            $request->validate([
                'patient_id'            => 'required|exists:users,id',
                'specialization_id'     => 'required|exists:specializations,id',
                'assessment_date'       => 'required|date',
                'appointment_id'        => 'nullable|exists:appointments,id',
                'session_notes'         => 'nullable|string',
                'baseline_score'        => 'nullable',
                'parameters'            => 'required|array|min:1',
                'parameters.*.key'      => 'required|string',
                'parameters.*.label'    => 'nullable|string',
                'parameters.*.baseline_value' => 'nullable',
                'parameters.*.target_value'   => 'nullable',
                'parameters.*.current_value'  => 'nullable',
                'parameters.*.unit'           => 'nullable|string',
                'exercises'             => 'required|array|min:1',
                'exercises.*.exercise_id'     => 'required|exists:exercises,id',
                'exercises.*.sets'            => 'required|integer|min:1',
                'exercises.*.reps'            => 'required|integer|min:1',
                'goal_text'             => 'nullable|string',
                'goal_duration_weeks'   => 'nullable|integer|min:1',
                'total_sessions'        => 'nullable|integer|min:1',
                'expected_outcomes'     => 'nullable|array',
            ]);

            $doctor = Auth::user();

            DB::beginTransaction();

            // 1. Create assessment header
            $assessment = PatientAssessment::create([
                'doctor_id'          => $doctor->id,
                'patient_id'         => $request->patient_id,
                'specialization_id'  => $request->specialization_id,
                'baseline_score'     => $this->sanitizeNumericValue($request->baseline_score),
                'goal_text'          => $request->goal_text,
                'goal_duration_weeks'=> $request->goal_duration_weeks ?? 8,
                'total_sessions'     => $request->total_sessions ?? 1,
                'completed_sessions' => 1,
                'assessment_date'    => $request->assessment_date,
                'status'             => 'active',
            ]);

            // 2. Save parameters (Steps 2 + 3 + 5 — selected params, baseline, targets)
            foreach ($request->parameters as $idx => $param) {
                $bVal = $this->sanitizeNumericValue($param['baseline_value'] ?? null);
                $tVal = $this->sanitizeNumericValue($param['target_value'] ?? null);
                $cVal = array_key_exists('current_value', $param)
                    ? $this->sanitizeNumericValue($param['current_value'])
                    : $bVal;

                AssessmentParameter::create([
                    'assessment_id'   => $assessment->id,
                    'parameter_key'   => $param['key'],
                    'parameter_label' => $param['label'] ?? ucwords(str_replace('_', ' ', $param['key'])),
                    'unit'            => $param['unit'] ?? null,
                    'baseline_value'  => $bVal,
                    'current_value'   => $cVal,
                    'target_value'    => $tVal,
                    'sort_order'      => $idx,
                ]);
            }

            // 3. Save exercises (Step 4)
            foreach ($request->exercises as $idx => $ex) {
                AssessmentExercise::create([
                    'assessment_id' => $assessment->id,
                    'exercise_id'   => $ex['exercise_id'],
                    'sets'          => $ex['sets'],
                    'reps'          => $ex['reps'],
                    'duration'      => $ex['duration'] ?? null,
                    'sort_order'    => $ex['sort_order'] ?? $idx,
                ]);
            }

            // 4. Save expected outcome goals (Step 5 Final Goal)
            if ($request->filled('expected_outcomes')) {
                foreach ($request->expected_outcomes as $idx => $goalText) {
                    AssessmentGoal::create([
                        'assessment_id' => $assessment->id,
                        'goal_text'     => $goalText,
                        'sort_order'    => $idx,
                    ]);
                }
            }

            // 5. Update Target Appointment status to 'completed'
            $appointmentData = null;
            $appointment     = null;
            $targetDate      = $request->assessment_date ? Carbon::parse($request->assessment_date)->toDateString() : now()->toDateString();
            $appointmentId   = $request->input('appointment_id');

            if (!empty($appointmentId) && is_numeric($appointmentId) && $appointmentId > 0) {
                $appointment = Appointment::find($appointmentId);
            }

            // If appointment_id is null / not provided, find uncompleted appointment on or around assessment_date
            if (!$appointment) {
                $appointment = Appointment::where('patient_id', $request->patient_id)
                    ->whereIn('status', ['confirmed', 'pending'])
                    ->whereDate('appointment_date', $targetDate)
                    ->first();

                if (!$appointment) {
                    $appointment = Appointment::where('patient_id', $request->patient_id)
                        ->whereIn('status', ['confirmed', 'pending'])
                        ->orderBy('appointment_date', 'asc')
                        ->first();
                }

                if (!$appointment) {
                    $appointment = Appointment::where('patient_id', $request->patient_id)
                        ->whereDate('appointment_date', '<=', $targetDate)
                        ->where('status', '!=', 'cancelled')
                        ->orderBy('appointment_date', 'desc')
                        ->first();
                }
            }

            if ($appointment) {
                $prevStatus = $appointment->status;
                $appointment->update([
                    'status' => 'completed',
                ]);

                $appointmentData = [
                    'id'               => $appointment->id,
                    'status'           => 'completed',
                    'appointment_date' => Carbon::parse($appointment->appointment_date)->format('d M Y'),
                ];

                Log::info('[Assessment Create] Appointment marked as COMPLETED', [
                    'appointment_id'  => $appointment->id,
                    'patient_id'       => $appointment->patient_id,
                    'previous_status' => $prevStatus,
                    'new_status'      => 'completed',
                ]);

                // Update patient plan subscription counts if exists
                $subscription = null;
                if ($appointment->patient_plan_subscription_id) {
                    $subscription = PatientPlanSubscription::find($appointment->patient_plan_subscription_id);
                } elseif (!empty($appointment->unique_plan_id)) {
                    $subscription = PatientPlanSubscription::where('unique_plan_id', $appointment->unique_plan_id)->first();
                } else {
                    $subscription = PatientPlanSubscription::where('patient_id', $request->patient_id)
                        ->where('status', 'active')
                        ->latest('id')
                        ->first();
                }

                if ($subscription) {
                    $subscription->increment('used_appointments');
                    if ($subscription->remaining_appointments > 0) {
                        $subscription->decrement('remaining_appointments');
                    }
                }
            }

            // 6. Create Sessions directly from Patient's Real Appointments
            $planSubId = $appointment?->patient_plan_subscription_id ?? $request->input('patient_plan_subscription_id');
            if ($planSubId) {
                $patientAppointments = Appointment::where('patient_plan_subscription_id', $planSubId)
                    ->where('patient_id', $request->patient_id)
                    ->where('status', '!=', 'cancelled')
                    ->orderBy('appointment_date')
                    ->orderBy('start_time')
                    ->get();
            } else {
                $patientAppointments = Appointment::where('patient_id', $request->patient_id)
                    ->where('doctor_id', $doctor->id)
                    ->where('status', '!=', 'cancelled')
                    ->orderBy('appointment_date')
                    ->orderBy('start_time')
                    ->get();
            }

            if ($patientAppointments->isNotEmpty()) {
                foreach ($patientAppointments as $idx => $appt) {
                    $isTargetAssessment = ($appointment && $appt->id === $appointment->id);
                    $sessStatus = ($appt->status === 'completed' || $isTargetAssessment) ? 'completed' : 'scheduled';
                    $sessNotes  = $isTargetAssessment
                        ? ($request->session_notes ?? 'Initial assessment completed & treatment plan created.')
                        : ($sessStatus === 'completed' ? 'Appointment completed.' : null);

                    PatientSession::create([
                        'assessment_id'  => $assessment->id,
                        'doctor_id'      => $doctor->id,
                        'patient_id'     => $request->patient_id,
                        'session_date'   => $appt->appointment_date,
                        'session_time'   => $appt->start_time,
                        'session_number' => $idx + 1,
                        'status'         => $sessStatus,
                        'notes'          => $sessNotes,
                    ]);
                }
            } else {
                // Fallback if no appointment records found
                PatientSession::create([
                    'assessment_id'  => $assessment->id,
                    'doctor_id'      => $doctor->id,
                    'patient_id'     => $request->patient_id,
                    'session_date'   => $request->assessment_date ?? now()->toDateString(),
                    'session_time'   => now()->format('H:i:s'),
                    'session_number' => 1,
                    'status'         => 'completed',
                    'notes'          => $request->session_notes ?? 'Initial assessment completed & treatment plan created.',
                ]);
            }

            $completedSessionsCount = PatientSession::where('assessment_id', $assessment->id)->where('status', 'completed')->count();
            $totalSessionsCount     = PatientSession::where('assessment_id', $assessment->id)->count();
            $nextSession            = PatientSession::where('assessment_id', $assessment->id)
                ->where('status', 'scheduled')
                ->orderBy('session_date')
                ->first();

            $assessment->update([
                'completed_sessions' => $completedSessionsCount,
                'total_sessions'     => $totalSessionsCount,
                'next_session_date'  => $nextSession?->session_date,
            ]);

            DB::commit();

            $condition = Specializations::find($request->specialization_id);

            return $this->sendResponse([
                'assessment_id'          => $assessment->id,
                'patient_id'             => $assessment->patient_id,
                'condition'              => optional($condition)->name,
                'total_sessions'         => $assessment->total_sessions,
                'completed_sessions'     => 1,
                'goal_duration_weeks'    => $assessment->goal_duration_weeks,
                'appointment_completed'  => $appointmentData !== null,
                'completed_appointment'  => $appointmentData,
                'next_session'           => $nextSession
                    ? Carbon::parse($nextSession->session_date)->format('d M Y')
                    : null,
            ], 'Treatment plan created & appointment marked as completed successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => false, 'message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
            $this->logException($e, 'Assessment Create Error');
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────
    // Get Active Assessment for Patient (2nd / Follow-up Visits)
    // ─────────────────────────────────────────────────────────

    /**
     * GET /api/doctor/patient/{patient_id}/active-assessment
     * Doctor opens patient profile on appointment #2 to view current active assessment & progress
     */
    public function patientActiveAssessment($patient_id)
    {
        try {
            $patient = \App\Models\User::findOrFail($patient_id);

            $assessment = PatientAssessment::with([
                'condition',
                'doctor',
                'parameters',
                'exercises.exercise',
                'goals',
                'sessions',
            ])
            ->where('patient_id', $patient_id)
            ->where('status', 'active')
            ->latest('id')
            ->first();

            if (!$assessment) {
                return $this->sendResponse([
                    'has_assessment' => false,
                    'patient'        => [
                        'id'     => $patient->id,
                        'name'   => $patient->name,
                        'age'    => $patient->dob ? Carbon::parse($patient->dob)->age : null,
                        'gender' => $patient->gender ?? null,
                    ],
                ], 'No active assessment found for this patient');
            }

            $completedSessions = $assessment->sessions->where('status', 'completed')->count();
            $scheduledSessions = $assessment->sessions->where('status', 'scheduled')->sortBy('session_number');
            $nextSession       = $scheduledSessions->first();

            // Calculate parameter progress
            $totalProgressSum = 0;
            $progressCount    = 0;

            $parameters = $assessment->parameters->map(function ($p) use (&$totalProgressSum, &$progressCount) {
                $progressPct = $this->calculateProgressPct($p->baseline_value, $p->current_value, $p->target_value);
                if ($p->baseline_value !== null && $p->target_value !== null) {
                    $totalProgressSum += $progressPct;
                    $progressCount++;
                }

                return [
                    'id'             => $p->id,
                    'key'            => $p->parameter_key,
                    'label'          => $p->parameter_label,
                    'unit'           => $p->unit,
                    'baseline_value' => $p->baseline_value,
                    'current_value'  => $p->current_value ?? $p->baseline_value,
                    'target_value'   => $p->target_value,
                    'progress_pct'   => $progressPct,
                    'icon_url'       => url("assets/img/parameters/{$p->parameter_key}.svg"),
                ];
            });

            $overallProgress = $progressCount > 0 ? round($totalProgressSum / $progressCount, 1) : 0;

            $sessions = $assessment->sessions->sortBy('session_number')->values()->map(fn($s) => [
                'id'             => $s->id,
                'session_number' => $s->session_number,
                'session_date'   => Carbon::parse($s->session_date)->format('d M Y'),
                'session_time'   => $s->session_time ? Carbon::parse($s->session_time)->format('h:i A') : null,
                'status'         => $s->status,
                'notes'          => $s->notes,
            ]);

            return $this->sendResponse([
                'has_assessment'       => true,
                'assessment_id'        => $assessment->id,
                'status'               => $assessment->status,
                'assessment_date'      => $assessment->assessment_date?->format('d M Y'),
                'goal_text'            => $assessment->goal_text,
                'goal_duration_weeks'  => $assessment->goal_duration_weeks,
                'overall_progress_pct' => $overallProgress,
                'condition'            => [
                    'id'   => optional($assessment->condition)->id,
                    'name' => optional($assessment->condition)->name,
                ],
                'doctor'               => [
                    'id'   => optional($assessment->doctor)->id,
                    'name' => optional($assessment->doctor)->name,
                ],
                'patient'              => [
                    'id'     => $patient->id,
                    'name'   => $patient->name,
                    'age'    => $patient->dob ? Carbon::parse($patient->dob)->age : null,
                    'gender' => $patient->gender ?? null,
                ],
                'sessions_summary'     => [
                    'total_sessions'         => $assessment->total_sessions,
                    'completed_sessions'     => $completedSessions,
                    'remaining_sessions'     => max(0, $assessment->total_sessions - $completedSessions),
                    'current_session_number' => $nextSession ? $nextSession->session_number : $assessment->total_sessions,
                    'next_session_id'        => $nextSession ? $nextSession->id : null,
                    'next_session_date'      => $nextSession ? Carbon::parse($nextSession->session_date)->format('d M Y') : null,
                ],
                'parameters'           => $parameters,
                'exercises'            => $assessment->exercises->map(fn($ae) => [
                    'id'          => optional($ae->exercise)->id,
                    'name'        => optional($ae->exercise)->name,
                    'image'       => optional($ae->exercise)->image_url ?? (optional($ae->exercise)->image ? asset(optional($ae->exercise)->image) : null),
                    'sets'        => $ae->sets,
                    'reps'        => $ae->reps,
                    'duration'    => $ae->duration,
                    'sort_order'  => $ae->sort_order,
                ]),
                'expected_outcomes'    => $assessment->goals->pluck('goal_text'),
                'session_history'      => $sessions,
            ], 'Active assessment fetched successfully');

        } catch (Exception $e) {
            $this->logException($e, 'Patient Active Assessment Error');
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────
    // Get Assessment Summary / Detail
    // ─────────────────────────────────────────────────────────

    /**
     * GET /api/assessment/{id}
     * Full assessment detail including parameters, exercises, goals
     */
    public function show($id)
    {
        try {
            $assessment = PatientAssessment::with([
                'condition',
                'doctor',
                'patient',
                'parameters',
                'exercises.exercise',
                'goals',
                'sessions',
            ])->findOrFail($id);

            $completedSessions = $assessment->sessions->where('status', 'completed')->count();

            return $this->sendResponse([
                'assessment' => [
                    'id'                 => $assessment->id,
                    'status'             => $assessment->status,
                    'assessment_date'    => $assessment->assessment_date?->format('d M Y'),
                    'baseline_score'     => $assessment->baseline_score,
                    'goal_text'          => $assessment->goal_text,
                    'goal_duration'      => $assessment->goal_duration_weeks . ' Weeks',
                    'total_sessions'     => $assessment->total_sessions,
                    'completed_sessions' => $completedSessions,
                ],
                'condition' => [
                    'id'   => optional($assessment->condition)->id,
                    'name' => optional($assessment->condition)->name,
                ],
                'patient' => [
                    'id'   => optional($assessment->patient)->id,
                    'name' => optional($assessment->patient)->name,
                    'age'  => optional($assessment->patient)->dob
                        ? Carbon::parse(optional($assessment->patient)->dob)->age : null,
                ],
                'parameters' => $assessment->parameters->map(fn($p) => [
                    'id'             => $p->id,
                    'key'            => $p->parameter_key,
                    'label'          => $p->parameter_label,
                    'unit'           => $p->unit,
                    'baseline_value' => $p->baseline_value,
                    'current_value'  => $p->current_value ?? $p->baseline_value,
                    'target_value'   => $p->target_value,
                    'progress_pct'   => $this->calculateProgressPct($p->baseline_value, $p->current_value, $p->target_value),
                    'icon_url'       => url("assets/img/parameters/{$p->parameter_key}.svg"),
                ]),
                'exercises' => $assessment->exercises->map(fn($ae) => [
                    'id'          => optional($ae->exercise)->id,
                    'name'        => optional($ae->exercise)->name,
                    'image'       => optional($ae->exercise)->image_url ?? (optional($ae->exercise)->image ? asset(optional($ae->exercise)->image) : null),
                    'sets'        => $ae->sets,
                    'reps'        => $ae->reps,
                    'duration'    => $ae->duration,
                    'sort_order'  => $ae->sort_order,
                ]),
                'expected_outcomes' => $assessment->goals->pluck('goal_text'),
            ], 'Assessment detail fetched successfully');

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * PUT /api/assessment/{id}
     * Edit assessment (update parameters/exercises/goals)
     */
    public function update(Request $request, $id)
    {
        try {
            $doctor     = Auth::user();
            $assessment = PatientAssessment::where('doctor_id', $doctor->id)->findOrFail($id);

            DB::beginTransaction();

            $assessment->update([
                'specialization_id'  => $request->specialization_id ?? $assessment->specialization_id,
                'goal_text'          => $request->goal_text ?? $assessment->goal_text,
                'goal_duration_weeks'=> $request->goal_duration_weeks ?? $assessment->goal_duration_weeks,
                'total_sessions'     => $request->total_sessions ?? $assessment->total_sessions,
                'baseline_score'     => $request->baseline_score ?? $assessment->baseline_score,
            ]);

            if ($request->has('parameters')) {
                AssessmentParameter::where('assessment_id', $id)->delete();
                foreach ($request->parameters as $idx => $param) {
                    $bVal = $this->sanitizeNumericValue($param['baseline_value'] ?? null);
                    $tVal = $this->sanitizeNumericValue($param['target_value'] ?? null);
                    $cVal = array_key_exists('current_value', $param)
                        ? $this->sanitizeNumericValue($param['current_value'])
                        : $bVal;

                    AssessmentParameter::create([
                        'assessment_id'   => $id,
                        'parameter_key'   => $param['key'],
                        'parameter_label' => $param['label'] ?? ucwords(str_replace('_', ' ', $param['key'])),
                        'unit'            => $param['unit'] ?? null,
                        'baseline_value'  => $bVal,
                        'current_value'   => $cVal,
                        'target_value'    => $tVal,
                        'sort_order'      => $idx,
                    ]);
                }
            }

            if ($request->has('exercises')) {
                AssessmentExercise::where('assessment_id', $id)->delete();
                foreach ($request->exercises as $idx => $ex) {
                    AssessmentExercise::create([
                        'assessment_id' => $id,
                        'exercise_id'   => $ex['exercise_id'],
                        'sets'          => $ex['sets'],
                        'reps'          => $ex['reps'],
                        'duration'      => $ex['duration'] ?? null,
                        'sort_order'    => $ex['sort_order'] ?? $idx,
                    ]);
                }
            }

            if ($request->has('expected_outcomes')) {
                AssessmentGoal::where('assessment_id', $id)->delete();
                foreach ($request->expected_outcomes as $idx => $goalText) {
                    AssessmentGoal::create([
                        'assessment_id' => $id,
                        'goal_text'     => $goalText,
                        'sort_order'    => $idx,
                    ]);
                }
            }

            DB::commit();

            return $this->sendResponse(['assessment_id' => $id], 'Assessment updated successfully');

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────
    // Record Progress & Update Follow-up Data (Appointment #2+)
    // ─────────────────────────────────────────────────────────

    /**
     * POST /api/assessment/{id}/progress-update
     * POST /api/assessment/progress-update
     * POST /api/progress-update
     * Doctor updates assessment progress during 2nd / follow-up appointments & completes appointment
     */
    public function recordProgress(Request $request, $id = null)
    {
        Log::info('[Progress Update] API invoked', [
            'url_id'     => $id,
            'body'       => $request->all(),
            'query'      => $request->query(),
            'auth_user'  => Auth::id() ?? auth('api')->id(),
        ]);

        try {
            $doctor        = Auth::user();
            $appointmentId = $request->input('appointment_id') 
                          ?? $request->input('id') 
                          ?? $request->query('appointment_id');
            $assessmentId  = $request->input('assessment_id');
            $assessment    = null;
            $appointment   = null;

            // Check if $id passed in URL is an Appointment ID or Assessment ID
            if (!empty($id) && is_numeric($id)) {
                if ($request->is('*appointment/*/progress-update*')) {
                    // Explicitly from /appointment/{id}/progress-update route
                    $appointmentId = (int) $id;
                } elseif ($request->is('*assessment/*/progress-update*')) {
                    // Explicitly from /assessment/{id}/progress-update route
                    $assessmentId = (int) $id;
                } else {
                    $assessmentId = (int) $id;
                }
            }

            // 1. Resolve appointment if $appointmentId is present
            if (!empty($appointmentId)) {
                $appointment = Appointment::find($appointmentId);
                if ($appointment) {
                    Log::info('[Progress Update] Direct appointment matched by ID', [
                        'appointment_id' => $appointment->id,
                        'patient_id'     => $appointment->patient_id,
                        'status'         => $appointment->status,
                    ]);

                    // Resolve assessment from this appointment
                    $assessment = PatientAssessment::with(['parameters', 'sessions'])
                        ->where('patient_id', $appointment->patient_id)
                        ->where('status', 'active')
                        ->latest('id')
                        ->first();
                }
            }

            // 2. If assessment not found yet, try by $assessmentId
            if (!$assessment && !empty($assessmentId)) {
                $assessment = PatientAssessment::with(['parameters', 'sessions'])->find($assessmentId);
            }

            // 3. If still not found, try by patient_id
            if (!$assessment && $request->filled('patient_id')) {
                $assessment = PatientAssessment::with(['parameters', 'sessions'])
                    ->where('patient_id', $request->patient_id)
                    ->where('status', 'active')
                    ->latest('id')
                    ->first();
            }

            if (!$assessment) {
                Log::warning('[Progress Update] Assessment NOT FOUND', [
                    'url_id'         => $id,
                    'assessment_id'  => $assessmentId,
                    'appointment_id' => $appointmentId,
                    'patient_id'     => $request->input('patient_id'),
                ]);

                return response()->json([
                    'status'  => false,
                    'message' => 'Assessment not found. Please provide a valid assessment_id, appointment_id, or patient_id.'
                ], 404);
            }

            Log::info('[Progress Update] Assessment resolved', [
                'assessment_id' => $assessment->id,
                'patient_id'    => $assessment->patient_id,
                'target_appointment_id' => optional($appointment)->id,
            ]);

            DB::beginTransaction();

            $assessmentId = $assessment->id;

            // 1. Update Parameter Current / Target values
            if ($request->has('parameters') && is_array($request->parameters)) {
                foreach ($request->parameters as $paramData) {
                    $paramKey = $paramData['key'] ?? null;
                    if (!$paramKey) continue;

                    $param = AssessmentParameter::where('assessment_id', $assessmentId)
                        ->where('parameter_key', $paramKey)
                        ->first();

                    $cVal = array_key_exists('current_value', $paramData)
                        ? $this->sanitizeNumericValue($paramData['current_value'])
                        : null;
                    $tVal = array_key_exists('target_value', $paramData)
                        ? $this->sanitizeNumericValue($paramData['target_value'])
                        : null;
                    $bVal = array_key_exists('baseline_value', $paramData)
                        ? $this->sanitizeNumericValue($paramData['baseline_value'])
                        : null;

                    if ($param) {
                        $updateData = [];
                        if ($cVal !== null) $updateData['current_value'] = $cVal;
                        if ($tVal !== null) $updateData['target_value'] = $tVal;
                        if ($bVal !== null) $updateData['baseline_value'] = $bVal;

                        if (!empty($updateData)) {
                            $param->update($updateData);
                        }
                    } else {
                        // Create if parameter was newly added in follow-up
                        AssessmentParameter::create([
                            'assessment_id'   => $assessmentId,
                            'parameter_key'   => $paramKey,
                            'parameter_label' => $paramData['label'] ?? ucwords(str_replace('_', ' ', $paramKey)),
                            'unit'            => $paramData['unit'] ?? null,
                            'baseline_value'  => $bVal,
                            'current_value'   => $cVal ?? $bVal,
                            'target_value'    => $tVal,
                            'sort_order'      => 99,
                        ]);
                    }
                }
            }

            // 2. Update Exercises if doctor modified prescription
            if ($request->has('exercises') && is_array($request->exercises)) {
                AssessmentExercise::where('assessment_id', $assessmentId)->delete();
                foreach ($request->exercises as $idx => $ex) {
                    AssessmentExercise::create([
                        'assessment_id' => $assessmentId,
                        'exercise_id'   => $ex['exercise_id'],
                        'sets'          => $ex['sets'],
                        'reps'          => $ex['reps'],
                        'duration'      => $ex['duration'] ?? null,
                        'sort_order'    => $ex['sort_order'] ?? $idx,
                    ]);
                }
            }

            // 3. Update Goals / Outcomes if provided
            if ($request->has('expected_outcomes') && is_array($request->expected_outcomes)) {
                AssessmentGoal::where('assessment_id', $assessmentId)->delete();
                foreach ($request->expected_outcomes as $idx => $goalText) {
                    AssessmentGoal::create([
                        'assessment_id' => $assessmentId,
                        'goal_text'     => $goalText,
                        'sort_order'    => $idx,
                    ]);
                }
            }

            // 4. Update Header Fields if passed
            if ($request->filled('goal_text') || $request->filled('goal_duration_weeks') || $request->filled('total_sessions')) {
                $assessment->update([
                    'goal_text'           => $request->goal_text ?? $assessment->goal_text,
                    'goal_duration_weeks' => $request->goal_duration_weeks ?? $assessment->goal_duration_weeks,
                    'total_sessions'      => $request->total_sessions ?? $assessment->total_sessions,
                ]);
            }

            // 5. Mark Session & Appointment Completed (Same as assessment creation)
            $completedSessionData     = null;
            $completedAppointmentData = null;
            $markCompleted            = $request->boolean('mark_session_completed', true);

            if ($markCompleted) {
                // A. Session completion
                if ($request->filled('session_id')) {
                    $session = PatientSession::where('assessment_id', $assessmentId)->find($request->session_id);
                } else {
                    $session = PatientSession::where('assessment_id', $assessmentId)
                        ->where('status', 'scheduled')
                        ->orderBy('session_number')
                        ->first();
                }

                if ($session) {
                    $session->update([
                        'status'       => 'completed',
                        'session_date' => $request->session_date ?? now()->toDateString(),
                        'session_time' => $request->session_time ?? now()->format('H:i:s'),
                        'notes'        => $request->session_notes ?? $request->notes ?? $session->notes ?? 'Session progress updated.',
                    ]);

                    $completedSessionData = [
                        'session_id'     => $session->id,
                        'session_number' => $session->session_number,
                        'session_date'   => Carbon::parse($session->session_date)->format('d M Y'),
                        'notes'          => $session->notes,
                    ];

                    $completedSessionsCount = PatientSession::where('assessment_id', $assessmentId)->where('status', 'completed')->count();
                    $totalSessionsCount     = PatientSession::where('assessment_id', $assessmentId)->count();

                    $assessment->update([
                        'completed_sessions' => $completedSessionsCount,
                        'total_sessions'     => $totalSessionsCount,
                    ]);

                    // Set next scheduled session date
                    $nextScheduled = PatientSession::where('assessment_id', $assessmentId)
                        ->where('status', 'scheduled')
                        ->orderBy('session_number')
                        ->first();

                    if ($nextScheduled) {
                        $assessment->update(['next_session_date' => $nextScheduled->session_date]);
                    }

                    Log::info('[Progress Update] Session marked completed', [
                        'session_id'         => $session->id,
                        'session_number'     => $session->session_number,
                        'completed_sessions' => $completedSessionsCount,
                    ]);
                }

                // B. Appointment completion (resolve target appointment to complete)
                $explicitDate = $request->input('appointment_date') 
                             ?? $request->input('date') 
                             ?? $request->input('session_date');
                $targetDate   = $explicitDate ? Carbon::parse($explicitDate)->toDateString() : null;

                // Priority 1: Direct lookup by appointment_id (if passed in body, query, or route)
                if (!$appointment && !empty($appointmentId) && is_numeric($appointmentId) && $appointmentId > 0) {
                    $appointment = Appointment::find($appointmentId);
                    Log::info('[Progress Update] Matched directly by appointment_id', [
                        'appointment_id' => $appointmentId,
                        'found'          => (bool) $appointment,
                        'current_status' => optional($appointment)->status,
                    ]);
                }

                // Priority 2: Uncompleted appointment on explicit target date (if date provided in request)
                if (!$appointment && !empty($targetDate)) {
                    $appointment = Appointment::where('patient_id', $assessment->patient_id)
                        ->whereIn('status', ['confirmed', 'pending'])
                        ->whereDate('appointment_date', $targetDate)
                        ->orderBy('start_time')
                        ->first();
                }

                // Priority 3: Next uncompleted appointment strictly under the patient's active plan subscription
                if (!$appointment) {
                    $activeSub = PatientPlanSubscription::where('patient_id', $assessment->patient_id)
                        ->where('status', 'active')
                        ->latest('id')
                        ->first();

                    if ($activeSub) {
                        $appointment = Appointment::where(function ($q) use ($activeSub) {
                                $q->where('patient_plan_subscription_id', $activeSub->id);
                                if (!empty($activeSub->unique_plan_id)) {
                                    $q->orWhere('unique_plan_id', $activeSub->unique_plan_id);
                                }
                            })
                            ->whereIn('status', ['confirmed', 'pending'])
                            ->orderBy('appointment_date', 'asc')
                            ->orderBy('start_time', 'asc')
                            ->first();

                        if ($appointment) {
                            Log::info('[Progress Update] Resolved from active subscription', [
                                'subscription_id'  => $activeSub->id,
                                'unique_plan_id'   => $activeSub->unique_plan_id,
                                'appointment_id'   => $appointment->id,
                                'appointment_date' => $appointment->appointment_date,
                            ]);
                        }
                    }
                }

                // Priority 4: Today's uncompleted appointment
                if (!$appointment) {
                    $appointment = Appointment::where('patient_id', $assessment->patient_id)
                        ->whereIn('status', ['confirmed', 'pending'])
                        ->whereDate('appointment_date', now()->toDateString())
                        ->orderBy('start_time')
                        ->first();
                }

                // Priority 5: Nearest upcoming uncompleted appointment
                if (!$appointment) {
                    $appointment = Appointment::where('patient_id', $assessment->patient_id)
                        ->whereIn('status', ['confirmed', 'pending'])
                        ->orderBy('appointment_date', 'asc')
                        ->orderBy('start_time', 'asc')
                        ->first();
                }

                Log::info('[Progress Update] Auto-resolved appointment', [
                    'resolved_appointment_id' => optional($appointment)->id,
                    'patient_id'              => $assessment->patient_id,
                    'target_date'             => $targetDate ?? now()->toDateString(),
                    'status_before'           => optional($appointment)->status,
                ]);

                if ($appointment) {
                    $previousStatus = $appointment->status;
                    $appointment->update([
                        'status' => 'completed',
                    ]);

                    $completedAppointmentData = [
                        'id'               => $appointment->id,
                        'status'           => 'completed',
                        'previous_status'  => $previousStatus,
                        'appointment_date' => Carbon::parse($appointment->appointment_date)->format('d M Y'),
                    ];

                    Log::info('[Progress Update] SUCCESS: Appointment marked as COMPLETED', [
                        'appointment_id'   => $appointment->id,
                        'patient_id'        => $appointment->patient_id,
                        'previous_status'  => $previousStatus,
                        'new_status'       => 'completed',
                        'appointment_date' => $appointment->appointment_date,
                    ]);

                    // Update patient plan subscription counts if exists (using linked subscription first)
                    $subscription = null;
                    if ($appointment->patient_plan_subscription_id) {
                        $subscription = PatientPlanSubscription::find($appointment->patient_plan_subscription_id);
                    } elseif (!empty($appointment->unique_plan_id)) {
                        $subscription = PatientPlanSubscription::where('unique_plan_id', $appointment->unique_plan_id)->first();
                    } else {
                        $subscription = PatientPlanSubscription::where('patient_id', $assessment->patient_id)
                            ->where('status', 'active')
                            ->latest('id')
                            ->first();
                    }

                    if ($subscription) {
                        $subscription->increment('used_appointments');
                        if ($subscription->remaining_appointments > 0) {
                            $subscription->decrement('remaining_appointments');
                        }

                        Log::info('[Progress Update] Subscription updated', [
                            'subscription_id'        => $subscription->id,
                            'unique_plan_id'         => $subscription->unique_plan_id,
                            'used_appointments'      => $subscription->used_appointments,
                            'remaining_appointments' => $subscription->remaining_appointments,
                        ]);
                    }
                } else {
                    Log::warning('[Progress Update] WARNING: No appointment found to complete for patient', [
                        'patient_id' => $assessment->patient_id,
                        'target_date'=> $targetDate,
                    ]);
                }
            }

            DB::commit();

            // Refresh parameters for response
            $updatedParams = AssessmentParameter::where('assessment_id', $assessmentId)->orderBy('sort_order')->get();
            $totalProgressSum = 0;
            $progressCount    = 0;

            $paramsFormatted = $updatedParams->map(function ($p) use (&$totalProgressSum, &$progressCount) {
                $pct = $this->calculateProgressPct($p->baseline_value, $p->current_value, $p->target_value);
                if ($p->baseline_value !== null && $p->target_value !== null) {
                    $totalProgressSum += $pct;
                    $progressCount++;
                }

                return [
                    'key'            => $p->parameter_key,
                    'label'          => $p->parameter_label,
                    'unit'           => $p->unit,
                    'baseline_value' => $p->baseline_value,
                    'current_value'  => $p->current_value ?? $p->baseline_value,
                    'target_value'   => $p->target_value,
                    'progress_pct'   => $pct,
                ];
            });

            $overallImprovement = $progressCount > 0 ? round($totalProgressSum / $progressCount, 1) : 0;
            $completedCount     = PatientSession::where('assessment_id', $assessmentId)->where('status', 'completed')->count();

            Log::info('[Progress Update] Returning SUCCESS response', [
                'assessment_id'          => $assessmentId,
                'completed_sessions'     => $completedCount,
                'appointment_completed'  => $completedAppointmentData !== null,
                'completed_appointment'  => $completedAppointmentData,
            ]);

            return $this->sendResponse([
                'assessment_id'          => $assessmentId,
                'completed_session'      => $completedSessionData,
                'completed_sessions'     => $completedCount,
                'total_sessions'         => $assessment->total_sessions,
                'overall_progress_pct'   => $overallImprovement,
                'appointment_completed'  => $completedAppointmentData !== null,
                'completed_appointment'  => $completedAppointmentData,
                'parameters'             => $paramsFormatted,
            ], 'Assessment progress updated & appointment marked as completed successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('[Progress Update] Exception occurred', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->logException($e, 'Assessment Progress Update Error');
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────
    // Assessment Progress Report
    // ─────────────────────────────────────────────────────────

    /**
     * GET /api/assessment/{id}/progress-report
     * Complete Clinical Progress Report
     */
    public function progressReport($id)
    {
        try {
            $assessment = PatientAssessment::with([
                'condition',
                'doctor',
                'patient',
                'parameters',
                'exercises.exercise',
                'goals',
                'sessions',
            ])->findOrFail($id);

            $completedSessions = $assessment->sessions->where('status', 'completed')->count();
            $totalSessions     = $assessment->total_sessions;

            $totalProgressSum = 0;
            $progressCount    = 0;

            $parameters = $assessment->parameters->map(function ($p) use (&$totalProgressSum, &$progressCount) {
                $pct = $this->calculateProgressPct($p->baseline_value, $p->current_value, $p->target_value);
                if ($p->baseline_value !== null && $p->target_value !== null) {
                    $totalProgressSum += $pct;
                    $progressCount++;
                }

                return [
                    'key'            => $p->parameter_key,
                    'label'          => $p->parameter_label,
                    'unit'           => $p->unit,
                    'baseline_value' => $p->baseline_value,
                    'current_value'  => $p->current_value ?? $p->baseline_value,
                    'target_value'   => $p->target_value,
                    'progress_pct'   => $pct,
                    'icon_url'       => url("assets/img/parameters/{$p->parameter_key}.svg"),
                ];
            });

            $overallImprovement = $progressCount > 0 ? round($totalProgressSum / $progressCount, 1) : 0;

            $sessions = $assessment->sessions->sortBy('session_number')->values()->map(fn($s) => [
                'session_number' => $s->session_number,
                'session_date'   => Carbon::parse($s->session_date)->format('d M Y'),
                'session_time'   => $s->session_time ? Carbon::parse($s->session_time)->format('h:i A') : null,
                'status'         => $s->status,
                'notes'          => $s->notes,
            ]);

            return $this->sendResponse([
                'report_title'           => 'Physiotherapy Clinical Progress Report',
                'generated_at'           => now()->format('d M Y, h:i A'),
                'assessment_id'          => $assessment->id,
                'condition'              => optional($assessment->condition)->name,
                'doctor'                 => [
                    'name'           => optional($assessment->doctor)->name,
                    'specialization' => optional($assessment->condition)->name,
                ],
                'patient'                => [
                    'id'     => optional($assessment->patient)->id,
                    'name'   => optional($assessment->patient)->name,
                    'age'    => optional($assessment->patient)->dob ? Carbon::parse(optional($assessment->patient)->dob)->age : null,
                    'gender' => optional($assessment->patient)->gender,
                ],
                'summary'                => [
                    'total_sessions'     => $totalSessions,
                    'completed_sessions' => $completedSessions,
                    'remaining_sessions' => max(0, $totalSessions - $completedSessions),
                    'duration'           => $assessment->goal_duration_weeks . ' Weeks',
                    'overall_improvement'=> "+{$overallImprovement}%",
                    'overall_progress_pct'=> $overallImprovement,
                    'clinical_goal'      => $assessment->goal_text,
                ],
                'parameters_comparison'  => $parameters,
                'prescribed_exercises'   => $assessment->exercises->map(fn($ae) => [
                    'name'     => optional($ae->exercise)->name,
                    'image'    => optional($ae->exercise)->image_url ?? (optional($ae->exercise)->image ? asset(optional($ae->exercise)->image) : null),
                    'sets'     => $ae->sets,
                    'reps'     => $ae->reps,
                    'duration' => $ae->duration,
                ]),
                'expected_outcomes'      => $assessment->goals->pluck('goal_text'),
                'session_timeline'       => $sessions,
            ], 'Progress report generated successfully');

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────
    // Helper: Sanitize numeric or string parameter values
    // ─────────────────────────────────────────────────────────
    private function sanitizeNumericValue($value): ?float
    {
        if ($value === null || $value === '' || $value === 'null') {
            return null;
        }
        if (is_numeric($value)) {
            return (float) $value;
        }
        if (is_string($value) && preg_match('/[-+]?[0-9]*\.?[0-9]+/', $value, $matches)) {
            return (float) $matches[0];
        }
        return null;
    }

    // ─────────────────────────────────────────────────────────
    // Helper: Calculate Progress Percentage
    // ─────────────────────────────────────────────────────────
    private function calculateProgressPct($baseline, $current, $target): float
    {
        $base = $this->sanitizeNumericValue($baseline);
        $tgt  = $this->sanitizeNumericValue($target);
        $curr = $this->sanitizeNumericValue($current) ?? $base;

        if ($base === null || $tgt === null) {
            return 0.0;
        }

        $totalDelta = abs($tgt - $base);
        if ($totalDelta == 0) {
            return 100.0;
        }

        if ($tgt >= $base) {
            // Increasing metric (e.g. range of motion: 35 -> 75, current 55)
            $achieved = $curr - $base;
        } else {
            // Decreasing metric (e.g. pain score: 8 -> 2, current 5)
            $achieved = $base - $curr;
        }

        $pct = ($achieved / $totalDelta) * 100;
        return (float) round(max(0, min(100, $pct)), 1);
    }

    // ─────────────────────────────────────────────────────────
    // Patient Plan Overview Screen
    // ─────────────────────────────────────────────────────────

    /**
     * GET /api/assessment/{id}/overview
     * Plan Overview tab
     */
    public function overview($id)
    {
        try {
            $assessment = PatientAssessment::with([
                'condition',
                'exercises.exercise',
                'sessions',
            ])->findOrFail($id);

            $completedSessions = $assessment->sessions->where('status', 'completed')->count();
            $upcomingSessions  = $assessment->sessions->where('status', 'scheduled')->count();

            $nextSession = $assessment->sessions
                ->where('status', 'scheduled')
                ->sortBy('session_date')
                ->first();

            $todayExercises = $assessment->exercises->map(fn($ae) => [
                'exercise_id' => optional($ae->exercise)->id,
                'name'        => optional($ae->exercise)->name,
                'image'       => optional($ae->exercise)->image_url ?? (optional($ae->exercise)->image ? asset(optional($ae->exercise)->image) : null),
                'sets'        => $ae->sets,
                'reps'        => $ae->reps,
                'sort_order'  => $ae->sort_order,
            ]);

            return $this->sendResponse([
                'treatment_plan' => [
                    'condition'          => optional($assessment->condition)->name,
                    'goal_duration'      => $assessment->goal_duration_weeks . ' Weeks',
                    'total_sessions'     => $assessment->total_sessions,
                    'completed_sessions' => $completedSessions,
                    'upcoming_sessions'  => $upcomingSessions,
                    'next_session'       => $nextSession
                        ? Carbon::parse($nextSession->session_date)->format('d M Y') . ', ' .
                          ($nextSession->session_time ? Carbon::parse($nextSession->session_time)->format('h:i A') : '10:30 AM')
                        : null,
                ],
                'today_plan' => $todayExercises,
            ], 'Plan overview fetched successfully');

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * GET /api/assessment/{id}/progress
     * Progress tab — parameter progress comparison
     */
    public function progress($id)
    {
        try {
            $assessment = PatientAssessment::with(['parameters', 'sessions'])->findOrFail($id);

            $completedSessions = $assessment->sessions->where('status', 'completed')->count();
            $totalProgressSum  = 0;
            $progressCount     = 0;

            $parameters = $assessment->parameters->map(function ($p) use (&$totalProgressSum, &$progressCount) {
                $pct = $this->calculateProgressPct($p->baseline_value, $p->current_value, $p->target_value);
                if ($p->baseline_value !== null && $p->target_value !== null) {
                    $totalProgressSum += $pct;
                    $progressCount++;
                }

                return [
                    'key'            => $p->parameter_key,
                    'label'          => $p->parameter_label,
                    'unit'           => $p->unit,
                    'baseline_value' => $p->baseline_value,
                    'current_value'  => $p->current_value ?? $p->baseline_value,
                    'target_value'   => $p->target_value,
                    'progress_pct'   => $pct,
                    'icon_url'       => url("assets/img/parameters/{$p->parameter_key}.svg"),
                ];
            });

            $overallImprovement = $progressCount > 0 ? round($totalProgressSum / $progressCount, 1) : 0;

            return $this->sendResponse([
                'overall_progress_pct' => $overallImprovement,
                'completed_sessions'   => $completedSessions,
                'total_sessions'       => $assessment->total_sessions,
                'parameters'           => $parameters,
            ], 'Progress fetched successfully');

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * GET /api/assessment/{id}/history
     * History tab — all sessions list
     */
    public function history($id)
    {
        try {
            $assessment = PatientAssessment::findOrFail($id);

            $sessions = PatientSession::where('assessment_id', $id)
                ->orderBy('session_date')
                ->get()
                ->map(fn($s) => [
                    'id'             => $s->id,
                    'session_number' => $s->session_number,
                    'session_date'   => Carbon::parse($s->session_date)->format('d M Y'),
                    'session_time'   => $s->session_time
                        ? Carbon::parse($s->session_time)->format('h:i A') : null,
                    'status'         => $s->status,
                    'notes'          => $s->notes,
                ]);

            return $this->sendResponse($sessions, 'Session history fetched successfully');

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────
    // Session Actions
    // ─────────────────────────────────────────────────────────

    /**
     * POST /api/session/start
     */
    public function startSession(Request $request)
    {
        try {
            $request->validate([
                'assessment_id' => 'required|exists:patient_assessments,id',
                'session_date'  => 'nullable|date',
                'session_time'  => 'nullable|string',
            ]);

            $doctor     = Auth::user();
            $assessment = PatientAssessment::findOrFail($request->assessment_id);

            // Get next scheduled session
            $session = PatientSession::where('assessment_id', $request->assessment_id)
                ->where('status', 'scheduled')
                ->orderBy('session_number')
                ->first();

            if (!$session) {
                return response()->json(['status' => false, 'message' => 'No scheduled sessions remaining'], 400);
            }

            $session->update([
                'status'       => 'completed',
                'session_date' => $request->session_date ?? $session->session_date,
                'session_time' => $request->session_time,
                'notes'        => $request->notes,
            ]);

            // Update completed sessions on assessment with exact count
            $assessment->update([
                'completed_sessions' => PatientSession::where('assessment_id', $assessment->id)->where('status', 'completed')->count(),
                'total_sessions'     => PatientSession::where('assessment_id', $assessment->id)->count(),
            ]);

            return $this->sendResponse([
                'session_id'     => $session->id,
                'session_number' => $session->session_number,
                'status'         => 'completed',
            ], 'Session started and marked as completed');

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * PUT /api/session/{id}/complete
     */
    public function completeSession(Request $request, $id)
    {
        try {
            $session = PatientSession::findOrFail($id);
            $session->update([
                'status' => 'completed',
                'notes'  => $request->notes,
            ]);
            if ($session->assessment) {
                $session->assessment->update([
                    'completed_sessions' => PatientSession::where('assessment_id', $session->assessment_id)->where('status', 'completed')->count(),
                    'total_sessions'     => PatientSession::where('assessment_id', $session->assessment_id)->count(),
                ]);
            }

            return $this->sendResponse(['session_id' => $session->id], 'Session marked as completed');

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * GET /api/doctor/sessions/today
     * All scheduled sessions for today
     */
    public function todaySessions()
    {
        try {
            $doctor   = Auth::user();
            $today    = Carbon::today();
            $sessions = PatientSession::with(['assessment.condition', 'patient'])
                ->where('doctor_id', $doctor->id)
                ->whereDate('session_date', $today)
                ->orderBy('session_time')
                ->get()
                ->map(fn($s) => [
                    'id'             => $s->id,
                    'session_number' => $s->session_number,
                    'patient_id'     => $s->patient_id,
                    'patient_name'   => optional($s->patient)->name,
                    'condition'      => optional(optional($s->assessment)->condition)->name,
                    'session_time'   => $s->session_time ? Carbon::parse($s->session_time)->format('h:i A') : null,
                    'status'         => $s->status,
                    'assessment_id'  => $s->assessment_id,
                ]);

            return $this->sendResponse($sessions, "Today's sessions fetched successfully");

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
