<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $doctors = User::with([
                'profile.specializationdata',
                'fee'
            ])
            ->where('role', 'doctor')
            ->where('status', 'active')
            ->latest()
            ->take(10)
            ->get();

        return view('patient.index', compact('doctors'));
    }
}