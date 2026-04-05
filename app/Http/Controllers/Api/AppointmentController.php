<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Appointment;
use App\Models\DoctorTimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AppointmentCancellation;
use Exception;

class AppointmentController extends BaseApiController
{

   public function adminIndex(Request $request)
    {
        $query = Appointment::with(['doctor', 'patient']);

        // 🔍 Search (patient name)
        if ($request->search) {
            $query->where('patient_name', 'like', '%' . $request->search . '%');
        }

        // 📌 Appointment Status Filter
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // 💳 Payment Status Filter
        if ($request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        $appointments = $query->latest()->paginate(10)->withQueryString();

        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Book Appointment (Patient)
     */
    
    public function book(Request $request)
    {
        try {

            $request->validate([
                'doctor_id'    => 'required|exists:users,id',
                'time_slot_id' => 'required|exists:doctor_time_slots,id',
                'booking_for'        => 'required|in:self,other',
                'patient_name'       => 'required|string|max:150',
                'patient_age'        => 'nullable|integer|min:0|max:120',
                'patient_gender'     => 'nullable|in:male,female,other',
                'problem_description'=> 'nullable|string'
            ]);

            $patient = Auth::user();

            if ($patient->role !== 'patient') {
                return $this->sendError('Only patients can book appointments', [], 403);
            }

            $slot = DoctorTimeSlot::where('id', $request->time_slot_id)
                    ->where('user_id', $request->doctor_id)
                    ->first();

            if (!$slot) {
                return $this->sendError('Invalid slot selected', [], 404);
            }

            if ($slot->is_booked) {
                return $this->sendError('Slot already booked', [], 400);
            }

            $appointment = Appointment::create([
                'doctor_id'       => $request->doctor_id,
                'patient_id'      => $patient->id,
                'time_slot_id'    => $slot->id,
                'appointment_date'=> $slot->availabilityDate->available_date,
                'start_time'      => $slot->start_time,
                'end_time'        => $slot->end_time,
                'status'          => 'pending',
                'booking_for'     => $request->booking_for,
                'patient_name'    => $request->patient_name,
                'patient_age'     => $request->patient_age,
                'patient_gender'  => $request->patient_gender,
                'problem_description' => $request->problem_description

            ]);

            // Mark slot as booked
            $slot->update(['is_booked' => true]);

            return $this->sendResponse($appointment, 'Appointment booked successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Appointment Booking Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Patient Appointment List
     */
    public function patientAppointments()
    {
        try {

            $patient = Auth::user();

            $appointments = Appointment::with(['doctor', 'timeSlot'])
                ->where('patient_id', $patient->id)
                ->orderBy('appointment_date', 'desc')
                ->get();

            return $this->sendResponse($appointments, 'Appointments fetched successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Patient Appointment List Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Doctor Appointment List
     */
    public function doctorAppointments()
    {
        try {

            $doctor = Auth::user();

            $appointments = Appointment::with(['patient', 'timeSlot'])
                ->where('doctor_id', $doctor->id)
                ->orderBy('appointment_date', 'desc')
                ->get();

            return $this->sendResponse($appointments, 'Appointments fetched successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Doctor Appointment List Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel Appointment
     */
    

    public function cancel(Request $request, $id)
    {
        try {

            $request->validate([
                'reason_id'     => 'nullable|exists:cancellation_reasons,id',
                'custom_reason' => 'nullable|string|max:500'
            ]);

            $user = Auth::user();

            if ($user->role !== 'patient' && $user->role !== 'doctor') {
                return $this->sendError('Unauthorized access', [], 403);
            }

            DB::beginTransaction();

            $appointment = Appointment::with('timeSlot')
                ->where('id', $id)
                ->where(function ($query) use ($user) {
                    $query->where('patient_id', $user->id)
                        ->orWhere('doctor_id', $user->id);
                })
                ->lockForUpdate()
                ->first();

            if (!$appointment) {
                DB::rollBack();
                return $this->sendError('Appointment not found', [], 404);
            }

            if ($appointment->status === 'cancelled') {
                DB::rollBack();
                return $this->sendError('Appointment already cancelled');
            }

            // Update appointment status
            $appointment->update([
                'status' => 'cancelled'
            ]);

            // Free the slot
            if ($appointment->timeSlot) {
                $appointment->timeSlot->update([
                    'is_booked' => false
                ]);
            }

            // Determine who cancelled
            $cancelledBy = $user->role; // doctor or patient

            // Store cancellation record
            AppointmentCancellation::create([
                'user_id'        => $user->id,
                'appointment_id' => $appointment->id,
                'reason_id'      => $request->reason_id,
                'custom_reason'  => $request->custom_reason,
                'cancelled_by'   => $cancelledBy
            ]);

            DB::commit();

            return $this->sendResponse([], 'Appointment cancelled successfully');

        } catch (Exception $e) {

            DB::rollBack();

            $this->logException($e, 'Appointment Cancel Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function handleAction(Request $request, $id)
    {
        try {
            $request->validate([
                'action' => 'required|in:accept,reject'
            ]);

            $doctor = Auth::user();

            if ($doctor->role !== 'doctor') {
                return $this->sendError('Only doctors can perform this action', [], 403);
            }

            $appointment = Appointment::where('id', $id)
                ->where('doctor_id', $doctor->id)
                ->first();

            if (!$appointment) {
                return $this->sendError('Appointment not found', [], 404);
            }

            if ($appointment->status !== 'completed') {
                return $this->sendError('Appointment already processed', [], 400);
            }

            if ($request->action === 'accept') {
                $appointment->update([
                    'status' => 'confirmed'
                ]);
            } else {
                $appointment->update([
                    'status' => 'cancelled'
                ]);

                // Free the slot again
                DoctorTimeSlot::where('id', $appointment->time_slot_id)
                    ->update(['is_booked' => false]);
            }

            return $this->sendResponse($appointment, 'Appointment ' . $request->action . 'ed successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Appointment Action Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}