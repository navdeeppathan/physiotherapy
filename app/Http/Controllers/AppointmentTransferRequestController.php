<?php

namespace App\Http\Controllers;

use App\Models\AppointmentTransfer;
use App\Models\AppointmentTransferRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentTransferRequestController extends Controller
{
    public function index(Request $request)
    {
        $requests = AppointmentTransferRequest::with([
            'appointment',
            'currentDoctor',
            'requestedDoctor'
        ])
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
        $transferRequest = AppointmentTransferRequest::with([
            'appointment',
            'currentDoctor',
            'requestedDoctor'
        ])->findOrFail($id);

        $doctors = User::where('role', 'doctor')
            ->where('id', '!=', $transferRequest->current_doctor_id)
            ->get();

        return view(
            'admin.appointment_transfer_requests.show',
            compact('transferRequest', 'doctors')
        );
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'new_doctor_id' => 'required|exists:users,id'
        ]);

        $transferRequest = AppointmentTransferRequest::with('appointment')
            ->findOrFail($id);

        DB::transaction(function () use ($transferRequest, $request) {

            AppointmentTransfer::create([
                'appointment_id'       => $transferRequest->appointment_id,
                'old_doctor_id'        => $transferRequest->current_doctor_id,
                'new_doctor_id'        => $request->new_doctor_id,
                'transfer_request_id'  => $transferRequest->id,
                'transferred_by'       => Auth::id(),
                'remarks'              => $request->admin_remark,
            ]);

            $transferRequest->appointment->update([
                'doctor_id'      => $request->new_doctor_id,
                'is_transferred' => 1,
            ]);

            $transferRequest->update([
                'status'       => 'approved',
                'admin_id'     => Auth::id(),
                'admin_remark' => $request->admin_remark,
            ]);
        });

        return redirect()
            ->route('admin.appointment-transfer-requests.index')
            ->with('success', 'Appointment transferred successfully.');
    }

    public function reject(Request $request, $id)
    {
        $transferRequest = AppointmentTransferRequest::findOrFail($id);

        $transferRequest->update([
            'status'       => 'rejected',
            'admin_id'     => Auth::id(),
            'admin_remark' => $request->admin_remark,
        ]);

        return redirect()
            ->route('admin.appointment-transfer-requests.index')
            ->with('success', 'Request rejected successfully.');
    }
}