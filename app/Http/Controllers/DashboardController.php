<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalAppointments = Appointment::count();

        return view('admin.dashboard', compact('totalUsers', 'totalAppointments'));
    }
}