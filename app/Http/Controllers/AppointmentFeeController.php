<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppointmentFee;
use App\Models\User;

class AppointmentFeeController extends Controller
{
    // ✅ Store / Update Fee
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'doctor_fee' => 'required|numeric|min:0',
            'admin_fee' => 'required|numeric|min:0',
        ]);

        $fee = AppointmentFee::updateOrCreate(
            ['doctor_id' => $request->doctor_id],
            [
                'doctor_fee' => $request->doctor_fee,
                'admin_fee' => $request->admin_fee,
                'total_fee' => $request->doctor_fee + $request->admin_fee
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Fee saved successfully',
            'data' => $fee
        ]);
    }

    // ✅ Get Fee (for edit popup)
    public function getFee($doctor_id)
    {
        $fee = AppointmentFee::where('doctor_id', $doctor_id)->first();

        return response()->json([
            'success' => true,
            'data' => $fee
        ]);
    }
}