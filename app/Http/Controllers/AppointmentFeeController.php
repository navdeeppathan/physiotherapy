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
            'admin_fee' => 'nullable|numeric|min:0',
            'admin_fee_type' => 'nullable|in:fixed,percentage',
        ]);

        $adminFeeType = $request->input('admin_fee_type', 'fixed');
        $adminFee = (float) $request->input('admin_fee', 0);
        $doctorFee = (float) $request->input('doctor_fee', 0);

        if ($doctorFee <= 0) {
            $doctorFee = 800.00;
        }
        if ($adminFee <= 0) {
            $adminFee = 300.00;
        }

        $effectiveAdminFee = ($adminFeeType === 'percentage')
            ? round(($doctorFee * $adminFee) / 100, 2)
            : $adminFee;

        $totalFee = round($doctorFee + $effectiveAdminFee, 2);

        $fee = AppointmentFee::updateOrCreate(
            ['doctor_id' => $request->doctor_id],
            [
                'doctor_fee' => $doctorFee,
                'admin_fee' => $adminFee,
                'admin_fee_type' => $adminFeeType,
                'total_fee' => $totalFee,
            ]
        );

        // Sync with DoctorProfile consultation_fee
        \App\Models\DoctorProfile::where('user_id', $request->doctor_id)->update([
            'consultation_fee' => $doctorFee
        ]);

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

        if (!$fee) {
            $profile = \App\Models\DoctorProfile::where('user_id', $doctor_id)->first();
            $docFee = ($profile && (float)$profile->consultation_fee > 0) ? (float)$profile->consultation_fee : 800.00;
            $fee = (object)[
                'doctor_id'      => (int) $doctor_id,
                'doctor_fee'     => $docFee,
                'admin_fee'      => 300.00,
                'admin_fee_type' => 'fixed',
                'total_fee'      => round($docFee + 300.00, 2),
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $fee
        ]);
    }
}