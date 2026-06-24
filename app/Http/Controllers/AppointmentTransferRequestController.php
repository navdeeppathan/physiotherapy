<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentTransfer;
use App\Models\AppointmentTransferRequest;
use App\Models\DoctorAvailabilityDate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentTransferRequestController extends Controller
{
     public function index(Request $request)
    {
        $requests = AppointmentTransferRequest::with('doctor')
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('doctor', function ($doctor) use ($request) {
                    $doctor->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->latest()
            ->paginate(10);

        return view(
            'admin.appointment_transfer_requests.index',
            compact('requests')
        );
    }

    public function show($id)
    {
        $requestData = AppointmentTransferRequest::with('doctor')
            ->findOrFail($id);

        $appointments = Appointment::with([
                'patient',
                'timeSlot'
            ])
            ->where('doctor_id', $requestData->doctor_id)
            ->whereBetween('appointment_date', [
                $requestData->from_date,
                $requestData->to_date
            ])
            ->whereIn('status', [
                'pending',
                'approved',
                'confirmed'
            ])
            ->get();

        foreach ($appointments as $appointment) {

            $slot = $appointment->timeSlot;

            $availableDoctors = User::where('role', 'doctor')
                ->where('id', '!=', $requestData->doctor_id)

                ->whereHas('timeSlots', function ($q) use ($appointment, $slot) {

                    $q->where('is_booked', 0)

                    ->whereTime('start_time', $slot->start_time)
                    ->whereTime('end_time', $slot->end_time)

                    ->whereHas('availabilityDate', function ($availability) use ($appointment) {

                        $availability
                            ->whereDate(
                                'available_date',
                                $appointment->appointment_date
                            )
                            ->where('is_available', 1);

                    });

                })

                ->get();

            $appointment->available_doctors = $availableDoctors;
        }

        return view(
            'admin.appointment_transfer_requests.show',
            compact(
                'requestData',
                'appointments'
            )
        );
    }


    public function approve(Request $request, $id)
    {
        $transferRequest = AppointmentTransferRequest::findOrFail($id);

        DB::transaction(function () use (
            $request,
            $transferRequest
        ) {

            foreach ($request->appointments as $appointmentId => $doctorId) {

                if (!$doctorId) {
                    continue;
                }

                $appointment = Appointment::findOrFail($appointmentId);

                AppointmentTransfer::create([
                    'transfer_request_id' => $transferRequest->id,
                    'appointment_id' => $appointment->id,
                    'old_doctor_id' => $appointment->doctor_id,
                    'new_doctor_id' => $doctorId,
                    'transferred_by' => Auth::id(),
                    'remarks' => 'Transferred by admin'
                ]);

                $appointment->update([
                    'doctor_id' => $doctorId,
                    'is_transferred' => 1
                ]);
            }

            $transferRequest->update([
                'status' => 'approved',
                'admin_id' => Auth::id(),
                'admin_remark' => $request->admin_remark
            ]);

            DoctorAvailabilityDate::where(
                'user_id',
                $transferRequest->doctor_id
            )
            ->whereBetween('available_date', [
                $transferRequest->from_date,
                $transferRequest->to_date
            ])
            ->update([
                'is_available' => 0
            ]);
        });

        return redirect()
            ->route('admin.appointment-transfer-requests.index')
            ->with(
                'success',
                'Appointments transferred successfully and doctor marked unavailable.'
            );
    }

    public function reject(Request $request, $id)
    {
        $transferRequest = AppointmentTransferRequest::findOrFail($id);

        $transferRequest->update([
            'status' => 'rejected',
            'admin_id' => Auth::id(),
            'admin_remark' => $request->admin_remark
        ]);

        return redirect()
            ->route('appointment-transfer-requests.index')
            ->with('success', 'Request rejected successfully.');
    }
}