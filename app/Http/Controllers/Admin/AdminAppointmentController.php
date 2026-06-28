<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentFee;
use App\Models\DoctorTimeSlot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminAppointmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Booking Form
    |--------------------------------------------------------------------------
    */
    public function create($patientId)
    {
        $patient = User::where('role', 'patient')
            ->findOrFail($patientId);

        $doctors = User::where('role', 'doctor')
            ->where('status', 'active')
            ->with('fee')
            ->get();

        return view(
            'admin.appointments.create',
            compact('patient', 'doctors')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Get Available Slots By Doctor and Date
    |--------------------------------------------------------------------------
    */
    public function getSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date'
        ]);

        $slots = DoctorTimeSlot::where('user_id', $request->doctor_id)
            ->whereHas('availabilityDate', function ($q) use ($request) {
                $q->whereDate(
                    'available_date',
                    $request->date
                );
            })
            ->where('is_booked', false)
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $slots
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Store Appointment By Admin
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'time_slot_id' => 'required|exists:doctor_time_slots,id',
            'problem_description' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            $patient = User::findOrFail($request->patient_id);

            $doctor = User::where('role', 'doctor')
                ->findOrFail($request->doctor_id);

            $slot = DoctorTimeSlot::with('availabilityDate')
                ->where('id', $request->time_slot_id)
                ->where('user_id', $doctor->id)
                ->lockForUpdate()
                ->first();

            if (!$slot) {
                return back()->with(
                    'error',
                    'Invalid slot selected.'
                );
            }

            if ($slot->is_booked) {
                return back()->with(
                    'error',
                    'Selected slot already booked.'
                );
            }

            $doctorFee = AppointmentFee::where(
                'doctor_id',
                $doctor->id
            )->value('doctor_fee') ?? 0;

            $appointment = Appointment::create([
                'doctor_id' => $doctor->id,
                'patient_id' => $patient->id,

                'time_slot_id' => $slot->id,

                'appointment_date' =>
                    $slot->availabilityDate->available_date,

                'start_time' => $slot->start_time,
                'end_time' => $slot->end_time,

                'status' => 'confirmed',

                'booking_for' => 'self',

                'patient_name' => $patient->name,

                'patient_age' => $patient->dob
                    ? Carbon::parse($patient->dob)->age
                    : null,

                'patient_gender' => $patient->gender,

                'problem_description' =>
                    $request->problem_description,

                'doctor_fee' => $doctorFee,

                'booked_by' => 'admin'
            ]);

            $slot->update([
                'is_booked' => true
            ]);

            DB::commit();

            return redirect()
                ->route('admin.appointments.index')
                ->with(
                    'success',
                    'Appointment booked successfully.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Appointment List
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $appointments = Appointment::with([
                'doctor',
                'patient',
                'timeSlot'
            ])
            ->latest()
            ->paginate(20);

        return view(
            'admin.appointments.index',
            compact('appointments')
        );
    }
}