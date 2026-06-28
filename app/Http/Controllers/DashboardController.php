<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\AppointmentFee;
use App\Models\DoctorProfile;
use App\Models\PatientPlanSubscription;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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



    public function appointments($id)
    {
        $doctor = User::where('role', 'doctor')->findOrFail($id);
    
        $appointments = Appointment::with(['patient', 'timeSlot'])
            ->where('doctor_id', $id)
            ->where('status', 'completed')
            ->latest('appointment_date')
            ->paginate(15);
    
        $completedCount = Appointment::where('doctor_id', $id)
            ->where('status', 'completed')
            ->count();

        $doctorFee = AppointmentFee::where('doctor_id', $id)
            ->value('doctor_fee') ?? 0;

        $totalAmount = $completedCount * $doctorFee;
    
        // Sum already paid to doctor
        $paidAmount = Payment::where('doctor_id', $id)
            ->where('status', 'success')
            ->sum('amount');
    
        $remainingAmount = max(0, $totalAmount - $paidAmount);
    
        // Count of unpaid completed appointments
        $unpaidCount = Appointment::where('doctor_id', $id)
            ->where('status', 'completed')
            ->where('doctor_payment_status', '!=', 'paid')
            ->count();
    
        return view('admin.doctors.payments', compact(
            'doctor',
            'appointments',
            'totalAmount',
            'paidAmount',
            'remainingAmount',
            'unpaidCount'
        ));
    }
 
    // ── 2. Pay doctor — mark appointments paid + create Payment record ────────────
 
    public function pay(Request $request, $id)
    {
        try {
            $doctor = User::where('role', 'doctor')->findOrFail($id);
    
            $request->validate([
                'appointment_ids'   => 'required|array|min:1',
                'appointment_ids.*' => 'integer|exists:appointments,id',
                
            ]);
    
            $appointmentIds = $request->appointment_ids;
    
            // Verify all belong to this doctor and are completed + unpaid
            $appointments = Appointment::where('doctor_id', $id)
                ->where('status', 'completed')
                ->where('doctor_payment_status', '!=', 'paid')
                ->whereIn('id', $appointmentIds)
                ->get();
    
            if ($appointments->isEmpty()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'No valid unpaid appointments found for this doctor.',
                ], 422);
            }
    
            DB::transaction(function () use ($appointments, $doctor) {

                // Doctor fee
                $doctorFee = AppointmentFee::where('doctor_id', $doctor->id)
                    ->value('doctor_fee');

                if (!$doctorFee) {
                    throw new \Exception('Doctor fee not found.');
                }

                foreach ($appointments as $appointment) {

                    // Mark appointment as paid
                    $appointment->update([
                        'doctor_payment_status' => 'paid'
                    ]);

                    // Create payment for this appointment
                    Payment::create([
                        'appointment_id' => $appointment->id,
                        'doctor_id'      => $doctor->id,
                        'amount'         => $doctorFee,
                        'currency'       => 'INR',
                        'payment_method' => 'admin_manual',
                        'transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
                        'status'         => 'success',
                        'paid_at'        => now(),
                    ]);
                }

            });

            $doctorFees = AppointmentFee::where('doctor_id', $doctor->id)
                    ->value('doctor_fee');

            $totalPaid = $appointments->count() * $doctorFees;

            return response()->json([
                'status'  => true,
                'message' => 'Successfully paid ₹' . number_format($totalPaid, 2) .
                            ' for ' . $appointments->count() . ' appointment(s).',
            ]);
    
            
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->validator->errors()->first(),
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}