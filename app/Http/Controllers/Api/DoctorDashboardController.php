<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class DoctorDashboardController extends BaseApiController
{
    /**
     * GET /api/doctor/dashboard
     * Dashboard stats + today's appointment list
     */
    public function index()
    {
        try {
            $doctor = Auth::user();
            $today  = Carbon::today();

            // ── Overview Stats ──────────────────────────────────────────────
            $upcoming  = Appointment::where('doctor_id', $doctor->id)
                ->whereIn('status', ['confirmed', 'pending'])
                ->whereDate('appointment_date', '>=', $today)
                ->count();

            $completed = Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'completed')
                ->count();

            $pending   = Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'pending')
                ->count();

            $cancelled = Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'cancelled')
                ->count();

            // ── Today's Appointments ─────────────────────────────────────────
            $todayAppointments = Appointment::with(['patient', 'timeSlot'])
                ->where('doctor_id', $doctor->id)
                ->whereDate('appointment_date', $today)
                ->whereIn('status', ['confirmed', 'pending'])
                ->orderBy('start_time', 'asc')
                ->get();

            $formatted = $todayAppointments->map(function ($appt) {
                $startTime = $appt->start_time
                    ? Carbon::parse($appt->start_time)->format('h:i A')
                    : ($appt->timeSlot ? Carbon::parse($appt->timeSlot->start_time)->format('h:i A') : 'N/A');

                // Check if this patient is new (first appointment with this doctor)
                $isNew = Appointment::where('doctor_id', $appt->doctor_id)
                    ->where('patient_id', $appt->patient_id)
                    ->where('status', 'completed')
                    ->doesntExist();

                return [
                    'id'               => $appt->id,
                    'time'             => $startTime,
                    'patient_id'       => $appt->patient_id,
                    'patient_name'     => $appt->patient_name ?? optional($appt->patient)->name,
                    'patient_age'      => $appt->patient_age,
                    'patient_gender'   => $appt->patient_gender,
                    'patient_img'      => optional($appt->patient)->profile_img
                        ? asset(optional($appt->patient)->profile_img) : null,
                    'condition'        => $appt->problem_description ?? 'General',
                    'status'           => $appt->status,
                    'is_new'           => $isNew,
                    'appointment_date' => $appt->appointment_date
                        ? Carbon::parse($appt->appointment_date)->format('d M Y') : null,
                ];
            });

            // ── Doctor profile image ─────────────────────────────────────────
            $profileImg = $doctor->profile_img
                ? (str_contains($doctor->profile_img, '/') ? asset($doctor->profile_img) : asset('uploads/profile/' . $doctor->profile_img))
                : null;

            return $this->sendResponse([
                'doctor' => [
                    'id'          => $doctor->id,
                    'name'        => $doctor->name,
                    'email'       => $doctor->email,
                    'phone'       => $doctor->phone,
                    'profile_img' => $profileImg,
                ],
                'overview' => [
                    'upcoming'  => $upcoming,
                    'completed' => $completed,
                    'pending'   => $pending,
                    'cancelled' => $cancelled,
                ],
                'today_appointments' => $formatted,
            ], 'Dashboard data fetched successfully');

        } catch (Exception $e) {
            $this->logException($e, 'Doctor Dashboard Error');
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/doctor/patient/{patient_id}
     * Patient details card + session stats for doctor view
     */
    public function patientDetail($patientId)
    {
        try {
            $doctor  = Auth::user();
            $patient = User::findOrFail($patientId);

            // Load active assessment for this patient with this doctor
            $assessment = \App\Models\PatientAssessment::with([
                'condition',
                'sessions',
                'exercises.exercise',
            ])
            ->where('doctor_id', $doctor->id)
            ->where('patient_id', $patientId)
            ->where('status', 'active')
            ->latest()
            ->first();

            // All appointments between this doctor & patient
            $totalAppointments     = Appointment::where('doctor_id', $doctor->id)->where('patient_id', $patientId)->count();
            $completedAppointments = Appointment::where('doctor_id', $doctor->id)->where('patient_id', $patientId)->where('status', 'completed')->count();
            $upcomingAppointments  = Appointment::where('doctor_id', $doctor->id)->where('patient_id', $patientId)->whereIn('status', ['confirmed','pending'])->whereDate('appointment_date','>=',Carbon::today())->count();

            $firstAppointment = Appointment::where('doctor_id', $doctor->id)->where('patient_id', $patientId)->oldest('appointment_date')->first();

            $profileImg = $patient->profile_img
                ? (str_contains($patient->profile_img, '/') ? asset($patient->profile_img) : asset('uploads/profile/' . $patient->profile_img))
                : null;

            // Session stats from assessment
            $totalSessions     = $assessment ? $assessment->total_sessions : 0;
            $completedSessions = $assessment ? $assessment->sessions()->where('status','completed')->count() : 0;
            $upcomingSessions  = $assessment ? $assessment->sessions()->where('status','scheduled')->count() : 0;
            $lastSession       = $assessment ? $assessment->sessions()->where('status','completed')->latest('session_date')->first() : null;

            return $this->sendResponse([
                'patient' => [
                    'id'          => $patient->id,
                    'name'        => $patient->name,
                    'age'         => $patient->dob ? Carbon::parse($patient->dob)->age : null,
                    'gender'      => $patient->gender,
                    'phone'       => $patient->phone,
                    'email'       => $patient->email,
                    'profile_img' => $profileImg,
                    'patient_code'=> 'PTE' . str_pad($patient->id, 5, '0', STR_PAD_LEFT),
                    'first_visit' => $firstAppointment ? Carbon::parse($firstAppointment->appointment_date)->format('d M Y') : null,
                    'referred_by' => 'Self',
                ],
                'assessment' => $assessment ? [
                    'id'              => $assessment->id,
                    'condition'       => optional($assessment->condition)->name,
                    'baseline_score'  => $assessment->baseline_score,
                    'status'          => $assessment->status,
                    'assessment_date' => $assessment->assessment_date ? Carbon::parse($assessment->assessment_date)->format('d M Y') : null,
                ] : null,
                'session_stats' => [
                    'total_sessions'     => $totalSessions,
                    'completed_sessions' => $completedSessions,
                    'upcoming_sessions'  => $upcomingSessions,
                    'last_session'       => $lastSession ? Carbon::parse($lastSession->session_date)->format('d M Y') : null,
                ],
                'appointment_stats' => [
                    'total'     => $totalAppointments,
                    'completed' => $completedAppointments,
                    'upcoming'  => $upcomingAppointments,
                ],
            ], 'Patient details fetched successfully');

        } catch (Exception $e) {
            $this->logException($e, 'Patient Detail Error');
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * GET /api/doctor/patient/{patient_id}/assessments
     * All assessments for this patient (Previous Records tab)
     */
    public function patientAssessments($patientId)
    {
        try {
            $doctor = Auth::user();

            $assessments = \App\Models\PatientAssessment::with(['condition'])
                ->where('doctor_id', $doctor->id)
                ->where('patient_id', $patientId)
                ->latest()
                ->get()
                ->map(function ($a) {
                    return [
                        'id'             => $a->id,
                        'condition'      => optional($a->condition)->name,
                        'status'         => $a->status,
                        'assessment_date'=> $a->assessment_date ? Carbon::parse($a->assessment_date)->format('d M Y') : null,
                        'total_sessions' => $a->total_sessions,
                        'completed'      => $a->completed_sessions,
                        'goal_duration'  => $a->goal_duration_weeks . ' Weeks',
                    ];
                });

            return $this->sendResponse($assessments, 'Patient assessments fetched successfully');

        } catch (Exception $e) {
            $this->logException($e, 'Patient Assessments Error');
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
