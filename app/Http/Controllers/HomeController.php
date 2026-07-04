<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Specializations;

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
}