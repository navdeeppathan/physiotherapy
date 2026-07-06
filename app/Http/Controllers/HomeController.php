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
        $keyword = trim($request->keyword);

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

    $avgRating = $doctor->receivedReviews()
        ->where('is_approved',1)
        ->avg('rating');

    $totalReviews = $doctor->receivedReviews()
        ->where('is_approved',1)
        ->count();

    return view('patient.doctor_profile', compact(
        'doctor',
        'avgRating',
        'totalReviews'
    ));
}
}