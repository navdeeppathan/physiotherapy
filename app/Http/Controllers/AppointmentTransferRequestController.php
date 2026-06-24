<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppointmentTransferRequest;
use Illuminate\Http\Request;

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
}