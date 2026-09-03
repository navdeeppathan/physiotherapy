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
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                'parameters'            => 'required|array|min:1',
                'parameters.*.key'      => 'required|string',
                'parameters.*.label'    => 'required|string',
                'parameters.*.baseline_value' => 'nullable|numeric',
                'parameters.*.target_value'   => 'nullable|numeric',
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
                'baseline_score'     => $request->baseline_score,
                'goal_text'          => $request->goal_text,
                'goal_duration_weeks'=> $request->goal_duration_weeks ?? 8,
                'total_sessions'     => $request->total_sessions ?? 12,
                'completed_sessions' => 0,
                'assessment_date'    => $request->assessment_date,
                'status'             => 'active',
            ]);

            // 2. Save parameters (Steps 2 + 3 + 5 — selected params, baseline, targets)
            foreach ($request->parameters as $idx => $param) {
                AssessmentParameter::create([
                    'assessment_id'   => $assessment->id,
                    'parameter_key'   => $param['key'],
                    'parameter_label' => $param['label'],
                    'unit'            => $param['unit'] ?? null,
                    'baseline_value'  => $param['baseline_value'] ?? null,
                    'target_value'    => $param['target_value'] ?? null,
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

            // 5. Auto-generate sessions
            $sessionCount = $request->total_sessions ?? 12;
            $startDate    = Carbon::parse($request->assessment_date)->addDays(2);
            for ($i = 1; $i <= $sessionCount; $i++) {
                PatientSession::create([
                    'assessment_id'  => $assessment->id,
                    'doctor_id'      => $doctor->id,
                    'patient_id'     => $request->patient_id,
                    'session_date'   => $startDate->copy()->addDays(($i - 1) * 3),
                    'session_number' => $i,
                    'status'         => 'scheduled',
                ]);
            }

            // Update next_session_date
            $nextSession = PatientSession::where('assessment_id', $assessment->id)
                ->where('status', 'scheduled')
                ->orderBy('session_date')
                ->first();

            if ($nextSession) {
                $assessment->update(['next_session_date' => $nextSession->session_date]);
            }

            DB::commit();

            $condition = Specializations::find($request->specialization_id);

            return $this->sendResponse([
                'assessment_id'       => $assessment->id,
                'patient_id'          => $assessment->patient_id,
                'condition'           => optional($condition)->name,
                'total_sessions'      => $assessment->total_sessions,
                'goal_duration_weeks' => $assessment->goal_duration_weeks,
                'next_session'        => $nextSession
                    ? Carbon::parse($nextSession->session_date)->format('d M Y')
                    : null,
            ], 'Treatment plan created successfully!');

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
                    AssessmentParameter::create([
                        'assessment_id'   => $id,
                        'parameter_key'   => $param['key'],
                        'parameter_label' => $param['label'],
                        'unit'            => $param['unit'] ?? null,
                        'baseline_value'  => $param['baseline_value'] ?? null,
                        'current_value'   => $param['current_value'] ?? ($param['baseline_value'] ?? null),
                        'target_value'    => $param['target_value'] ?? null,
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
     * Doctor updates assessment progress during 2nd / follow-up appointments
     */
    public function recordProgress(Request $request, $id)
    {
        try {
            $doctor     = Auth::user();
            $assessment = PatientAssessment::with(['parameters', 'sessions'])->findOrFail($id);

            DB::beginTransaction();

            // 1. Update Parameter Current / Target values
            if ($request->has('parameters') && is_array($request->parameters)) {
                foreach ($request->parameters as $paramData) {
                    $paramKey = $paramData['key'] ?? null;
                    if (!$paramKey) continue;

                    $param = AssessmentParameter::where('assessment_id', $id)
                        ->where('parameter_key', $paramKey)
                        ->first();

                    if ($param) {
                        $param->update([
                            'current_value' => $paramData['current_value'] ?? $param->current_value,
                            'target_value'  => $paramData['target_value'] ?? $param->target_value,
                        ]);
                    } else {
                        // Create if parameter was newly added in follow-up
                        AssessmentParameter::create([
                            'assessment_id'   => $id,
                            'parameter_key'   => $paramKey,
                            'parameter_label' => $paramData['label'] ?? ucwords(str_replace('_', ' ', $paramKey)),
                            'unit'            => $paramData['unit'] ?? null,
                            'baseline_value'  => $paramData['baseline_value'] ?? null,
                            'current_value'   => $paramData['current_value'] ?? null,
                            'target_value'    => $paramData['target_value'] ?? null,
                            'sort_order'      => 99,
                        ]);
                    }
                }
            }

            // 2. Update Exercises if doctor modified prescription
            if ($request->has('exercises') && is_array($request->exercises)) {
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

            // 3. Update Goals / Outcomes if provided
            if ($request->has('expected_outcomes') && is_array($request->expected_outcomes)) {
                AssessmentGoal::where('assessment_id', $id)->delete();
                foreach ($request->expected_outcomes as $idx => $goalText) {
                    AssessmentGoal::create([
                        'assessment_id' => $id,
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

            // 5. Mark Session Completed (if requested or session_id given)
            $completedSessionData = null;
            $markCompleted        = $request->boolean('mark_session_completed', true);

            if ($markCompleted) {
                if ($request->filled('session_id')) {
                    $session = PatientSession::where('assessment_id', $id)->find($request->session_id);
                } else {
                    $session = PatientSession::where('assessment_id', $id)
                        ->where('status', 'scheduled')
                        ->orderBy('session_number')
                        ->first();
                }

                if ($session) {
                    $session->update([
                        'status'       => 'completed',
                        'session_date' => $request->session_date ?? now()->toDateString(),
                        'session_time' => $request->session_time ?? now()->format('H:i:s'),
                        'notes'        => $request->session_notes ?? $request->notes ?? $session->notes,
                    ]);

                    $completedSessionData = [
                        'session_id'     => $session->id,
                        'session_number' => $session->session_number,
                        'session_date'   => Carbon::parse($session->session_date)->format('d M Y'),
                        'notes'          => $session->notes,
                    ];

                    $assessment->increment('completed_sessions');

                    // Set next scheduled session date
                    $nextScheduled = PatientSession::where('assessment_id', $id)
                        ->where('status', 'scheduled')
                        ->orderBy('session_number')
                        ->first();

                    if ($nextScheduled) {
                        $assessment->update(['next_session_date' => $nextScheduled->session_date]);
                    }
                }
            }

            DB::commit();

            // Refresh parameters for response
            $updatedParams = AssessmentParameter::where('assessment_id', $id)->orderBy('sort_order')->get();
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
            $completedCount     = PatientSession::where('assessment_id', $id)->where('status', 'completed')->count();

            return $this->sendResponse([
                'assessment_id'          => $id,
                'completed_session'      => $completedSessionData,
                'completed_sessions'     => $completedCount,
                'total_sessions'         => $assessment->total_sessions,
                'overall_progress_pct'   => $overallImprovement,
                'parameters'             => $paramsFormatted,
            ], 'Assessment progress updated successfully!');

        } catch (Exception $e) {
            DB::rollBack();
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
    // Helper: Calculate Progress Percentage
    // ─────────────────────────────────────────────────────────
    private function calculateProgressPct($baseline, $current, $target): float
    {
        if ($baseline === null || $target === null) {
            return 0.0;
        }

        $currentVal = ($current !== null) ? $current : $baseline;
        $totalDelta = abs($target - $baseline);

        if ($totalDelta == 0) {
            return 100.0;
        }

        if ($target >= $baseline) {
            // Increasing metric (e.g. range of motion: 35 -> 75, current 55)
            $achieved = $currentVal - $baseline;
        } else {
            // Decreasing metric (e.g. pain score: 8 -> 2, current 5)
            $achieved = $baseline - $currentVal;
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

            // Increment completed sessions on assessment
            $assessment->increment('completed_sessions');

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
            $session->assessment->increment('completed_sessions');

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
