<?php

namespace App\Services;

use App\Models\AppointmentFee;
use App\Models\PatientPlan;
use App\Models\User;

class PackagePricingService
{
    /**
     * Calculate complete package pricing breakdown based on doctor and package appointments.
     *
     * Formula: Package Price = (Doctor Fee + Physiopii/Admin Fee) * Package Appointments
     *
     * @param int|User|null $doctor Doctor ID or User model
     * @param int $appointmentsCount Number of package appointments
     * @param PatientPlan|int|null $plan Optional plan object or ID
     * @return array Pricing breakdown
     */
    public static function calculate($doctor, int $appointmentsCount = 1, $plan = null): array
    {
        $appointmentsCount = max(1, $appointmentsCount);

        // Resolve Doctor & Fee
        $doctorId = null;
        $feeRecord = null;
        if ($doctor instanceof User) {
            $doctorId = $doctor->id;
            $feeRecord = $doctor->relationLoaded('fee') ? $doctor->fee : AppointmentFee::where('doctor_id', $doctorId)->first();
        } elseif (is_numeric($doctor)) {
            $doctorId = (int) $doctor;
            if (class_exists(AppointmentFee::class)) {
                $feeRecord = AppointmentFee::where('doctor_id', $doctorId)->first();
            }
        }

        // Resolve Plan if provided
        if (is_numeric($plan) && class_exists(PatientPlan::class)) {
            $plan = PatientPlan::find($plan);
        }
        if ($plan instanceof PatientPlan && $appointmentsCount <= 1 && (int)($plan->total_appointments ?? 0) > 1) {
            $appointmentsCount = (int) $plan->total_appointments;
        }

        // Doctor Fee & Admin Fee values
        $doctorFee = $feeRecord ? (float) ($feeRecord->doctor_fee ?? 0) : 0.0;
        $adminFeeConfig = $feeRecord ? (float) ($feeRecord->admin_fee ?? 0) : 0.0;
        $adminFeeType = ($feeRecord && !empty($feeRecord->admin_fee_type)) 
            ? strtolower((string) $feeRecord->admin_fee_type) 
            : 'fixed';
        $fallbackPlanPrice = ($plan && isset($plan->price)) ? (float)$plan->price : 0.0;
        $discountPct = ($plan && isset($plan->discount_percentage)) ? (float)$plan->discount_percentage : 0.0;

        $result = self::calculateFromValues($doctorFee, $adminFeeConfig, $adminFeeType, $appointmentsCount, $discountPct, $fallbackPlanPrice);
        $result['doctor_id'] = $doctorId;

        return $result;
    }

    /**
     * Calculate package pricing breakdown from direct numeric values.
     */
    public static function calculateFromValues(
        float $doctorFee,
        float $adminFeeConfig,
        string $adminFeeType = 'fixed',
        int $appointmentsCount = 1,
        float $discountPercentage = 0.0,
        float $fallbackPlanPrice = 0.0
    ): array {
        $appointmentsCount = max(1, $appointmentsCount);
        $adminFeeType = in_array(strtolower($adminFeeType), ['percentage', 'percent', '%']) ? 'percentage' : 'fixed';

        // Calculate Admin Fee per appointment (Fixed or Percentage)
        if ($adminFeeType === 'percentage') {
            $adminFeePerAppt = round(($doctorFee * $adminFeeConfig) / 100, 2);
        } else {
            $adminFeePerAppt = round($adminFeeConfig, 2);
        }

        // Per appointment total rate = Doctor Fee + Admin Fee
        $perAppointmentRate = round($doctorFee + $adminFeePerAppt, 2);

        // If no doctor fee is configured and fallback plan price exists
        if ($perAppointmentRate <= 0 && $fallbackPlanPrice > 0) {
            $basePackagePrice = $fallbackPlanPrice;
            $perAppointmentRate = round($basePackagePrice / $appointmentsCount, 2);
            $doctorFee = $perAppointmentRate;
            $adminFeePerAppt = 0.0;
        } else {
            $basePackagePrice = round($perAppointmentRate * $appointmentsCount, 2);
        }

        // Handle Plan Discount if applicable
        $discountAmount = 0.0;
        if ($discountPercentage > 0) {
            $discountAmount = round(($basePackagePrice * $discountPercentage) / 100, 2);
            $finalPackagePrice = round($basePackagePrice - $discountAmount, 2);
        } else {
            $finalPackagePrice = $basePackagePrice;
        }

        // Calculate accounting totals
        $totalDoctorShare = round($doctorFee * $appointmentsCount, 2);
        $totalAdminShare  = round($adminFeePerAppt * $appointmentsCount, 2);

        return [
            'doctor_id'                 => null,
            'appointments_count'        => $appointmentsCount,
            'doctor_fee_per_appt'       => $doctorFee,
            'admin_fee_configured'      => $adminFeeConfig,
            'admin_fee_type'            => $adminFeeType,
            'admin_fee_per_appt'        => $adminFeePerAppt,
            'per_appointment_rate'      => $perAppointmentRate,
            'original_package_price'    => $basePackagePrice,
            'discount_percentage'       => $discountPercentage,
            'discount_amount'           => $discountAmount,
            'package_price'             => $finalPackagePrice,
            'customer_pays'             => $finalPackagePrice,
            'total_doctor_share'        => $totalDoctorShare,
            'total_admin_share'         => $totalAdminShare,
            'currency'                  => 'INR',
            'formatted' => [
                'doctor_fee'           => '₹' . number_format($doctorFee, 2),
                'admin_fee'            => '₹' . number_format($adminFeePerAppt, 2),
                'per_appointment_rate' => '₹' . number_format($perAppointmentRate, 2),
                'package_price'        => '₹' . number_format($finalPackagePrice, 2),
                'customer_pays'        => '₹' . number_format($finalPackagePrice, 2),
                'original_price'       => '₹' . number_format($basePackagePrice, 2),
            ],
        ];
    }
}