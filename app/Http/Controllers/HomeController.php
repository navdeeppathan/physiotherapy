<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Specializations;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $specializations = Specializations::where('status', 'active')->get();
        $doctors = User::whereHas('profile')
            ->with([
                'profile.specializationdata',
                'fee'
            ])
            ->where('role', 'doctor')
            ->where('status', 'active')
            ->latest()
            ->take(10)
            ->get();

            // dd($doctors);

        return view('patient.index', compact('doctors', 'specializations'));
    }



    public function searchDoctors(Request $request)
    {
        $keyword = trim($request->keyword ?? $request->q);

        if (!$keyword) {
            return response()->json([]);
        }

        $doctors = User::with(['profile.specializationdata'])
            ->where('role', 'doctor')
            ->whereHas('profile', function ($q) use ($keyword) {

                $q->whereHas('specializationdata', function ($qq) use ($keyword) {
                    $qq->where('name', 'LIKE', "%{$keyword}%");
                });

            })
            ->orWhere(function ($q) use ($keyword) {

                $q->where('role', 'doctor')
                    ->where('name', 'LIKE', "%{$keyword}%");

            })
            ->take(10)
            ->get();

        return response()->json($doctors);
    }

   

    public function doctorProfile($id)
    {
        $doctor = User::with([
            'profile.specializationdata',
            'receivedReviews.patient',
            'documents',
            'fee'
        ])->where('role', 'doctor')
        ->findOrFail($id);

        $approvedReviews = $doctor->receivedReviews()
            ->where('is_approved', 1)
            ->with('patient')
            ->latest()
            ->get();

        $totalReviews = $approvedReviews->count();
        $avgRating = $totalReviews > 0 ? round($approvedReviews->avg('rating'), 1) : 0;

        // Today's available slots count
        $todaySlotsCount = 0;
        try {
            if (class_exists(\App\Models\DoctorTimeSlot::class)) {
                $todaySlotsCount = \App\Models\DoctorTimeSlot::whereHas('availabilityDate', function($q) use ($doctor) {
                    $q->where('user_id', $doctor->id)
                      ->whereDate('available_date', \Carbon\Carbon::today());
                })->where('is_booked', false)->count();
            }
        } catch (\Throwable $e) {
            $todaySlotsCount = 0;
        }

        // Rating breakdown (percentages for 5, 4, 3, 2, 1 stars)
        $ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach ($approvedReviews as $rev) {
            $r = (int) $rev->rating;
            if ($r >= 1 && $r <= 5) {
                $ratingCounts[$r]++;
            }
        }
        $ratingPercentages = [];
        foreach ($ratingCounts as $star => $cnt) {
            $ratingPercentages[$star] = $totalReviews > 0 ? round(($cnt / $totalReviews) * 100) : 0;
        }

        // Active patient plans with pricing for this doctor
        $patientPlans = collect();
        try {
            if (class_exists(\App\Models\PatientPlan::class)) {
                $patientPlans = \App\Models\PatientPlan::where('status', 'active')->get();
                if (class_exists(\App\Services\PackagePricingService::class)) {
                    foreach ($patientPlans as $plan) {
                        $pricing = \App\Services\PackagePricingService::calculate($doctor, (int) $plan->total_appointments, $plan);
                        $plan->calculated_pricing       = $pricing;
                        $plan->calculated_package_price = $pricing['package_price'];
                        $plan->calculated_per_session   = $pricing['per_appointment_rate'];
                    }
                }
            }
        } catch (\Throwable $e) {
            $patientPlans = collect();
        }

        return view('patient.doctor_profile', compact(
            'doctor',
            'avgRating',
            'totalReviews',
            'approvedReviews',
            'todaySlotsCount',
            'ratingCounts',
            'ratingPercentages',
            'patientPlans'
        ));
    }

    /**
     * Privacy Policy Page
     */
    public function privacyPolicy()
    {
        return view('patient.privacy-policy');
    }
}