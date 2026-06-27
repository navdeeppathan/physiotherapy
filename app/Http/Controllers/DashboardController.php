<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\PatientPlanSubscription;
use App\Models\Payment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // ── USERS ──────────────────────────────────────────────
        $totalUsers        = User::count();
        $totalDoctors      = User::where('role', 'doctor')->count();
        $totalPatients     = User::where('role', 'patient')->count();

        // New users this month vs last month (for % change)
        $usersThisMonth    = User::whereMonth('created_at', Carbon::now()->month)
                                 ->whereYear('created_at', Carbon::now()->year)
                                 ->count();
        $usersLastMonth    = User::whereMonth('created_at', Carbon::now()->subMonth()->month)
                                 ->whereYear('created_at', Carbon::now()->subMonth()->year)
                                 ->count();
        $userGrowth        = $usersLastMonth > 0
                                ? round((($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100, 1)
                                : 0;

        // ── APPOINTMENTS ───────────────────────────────────────
        $totalAppointments     = Appointment::count();
        $pendingAppointments   = Appointment::where('status', 'pending')->count();
        $confirmedAppointments = Appointment::where('status', 'confirmed')->count();
        $completedAppointments = Appointment::where('status', 'completed')->count();
        $cancelledAppointments = Appointment::where('status', 'cancelled')->count();
        $rescheduledCount      = Appointment::where('is_rescheduled', true)->count();

        // Today's appointments
        $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();

        // This month vs last month
        $apptThisMonth  = Appointment::whereMonth('created_at', Carbon::now()->month)
                                     ->whereYear('created_at', Carbon::now()->year)
                                     ->count();
        $apptLastMonth  = Appointment::whereMonth('created_at', Carbon::now()->subMonth()->month)
                                     ->whereYear('created_at', Carbon::now()->subMonth()->year)
                                     ->count();
        $apptGrowth     = $apptLastMonth > 0
                            ? round((($apptThisMonth - $apptLastMonth) / $apptLastMonth) * 100, 1)
                            : 0;

        // ── REVENUE ───────────────────────────────────────────
        $totalRevenue   = Payment::where('status', 'success')->sum('amount');
        $revenueThisMonth = Payment::where('status', 'success')
                                   ->whereMonth('created_at', Carbon::now()->month)
                                   ->whereYear('created_at', Carbon::now()->year)
                                   ->sum('amount');
        $revenueLastMonth = Payment::where('status', 'success')
                                   ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                                   ->whereYear('created_at', Carbon::now()->subMonth()->year)
                                   ->sum('amount');
        $revenueGrowth  = $revenueLastMonth > 0
                            ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 1)
                            : 0;

        // ── SUBSCRIPTIONS ──────────────────────────────────────
        $totalSubscriptions  = PatientPlanSubscription::count();
        $activeSubscriptions = PatientPlanSubscription::where('status', 'active')->count();

        // ── RECENT DATA ────────────────────────────────────────
        $recentAppointments = Appointment::with(['doctor:id,name', 'patient:id,name'])
                                ->latest()
                                ->limit(6)
                                ->get();

        $recentSubscriptions = PatientPlanSubscription::with(['patient:id,name', 'plan:id,name'])
                                ->latest()
                                ->limit(5)
                                ->get();

        // ── CHART: Last 7 days appointment trend ──────────────
        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $chartLabels[] = $day->format('D, d M');
            $chartData[]   = Appointment::whereDate('appointment_date', $day)->count();
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDoctors',
            'totalPatients',
            'userGrowth',
            'totalAppointments',
            'pendingAppointments',
            'confirmedAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'rescheduledCount',
            'todayAppointments',
            'apptGrowth',
            'totalRevenue',
            'revenueThisMonth',
            'revenueGrowth',
            'totalSubscriptions',
            'activeSubscriptions',
            'recentAppointments',
            'recentSubscriptions',
            'chartLabels',
            'chartData'
        ));
    }
}