<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentFee;
use App\Models\DoctorAvailabilityDate;
use App\Models\DoctorProfile;
use App\Models\DoctorTimeSlot;
use App\Models\PatientPlan;
use App\Models\PatientPlanSubscription;
use App\Models\Payment;
use App\Models\Specializations;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminReportController extends Controller
{
    /**
     * Unified Reports & Analytics Dashboard
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'overview');
        [$fromDate, $toDate, $range, $rangeLabel] = $this->parseDateFilter($request);

        // Fetch shared lookups for filters
        $doctorsList = User::where('role', 'doctor')->orderBy('name')->get(['id', 'name']);
        $specializationsList = Specializations::orderBy('name')->get(['id', 'name']);
        $plansList = PatientPlan::orderBy('name')->get(['id', 'name', 'price']);

        $data = [
            'tab'                 => $tab,
            'range'               => $range,
            'rangeLabel'          => $rangeLabel,
            'fromDate'            => $fromDate,
            'toDate'              => $toDate,
            'customFrom'          => $request->get('from_date', $fromDate->format('Y-m-d')),
            'customTo'            => $request->get('to_date', $toDate->format('Y-m-d')),
            'doctorsList'         => $doctorsList,
            'specializationsList' => $specializationsList,
            'plansList'           => $plansList,
        ];

        switch ($tab) {
            case 'payments':
                $data = array_merge($data, $this->getPaymentsReportData($request, $fromDate, $toDate));
                break;

            case 'appointments':
                $data = array_merge($data, $this->getAppointmentsReportData($request, $fromDate, $toDate));
                break;

            case 'doctors':
                $data = array_merge($data, $this->getDoctorsReportData($request, $fromDate, $toDate));
                break;

            case 'patients':
                $data = array_merge($data, $this->getPatientsReportData($request, $fromDate, $toDate));
                break;

            case 'subscriptions':
                $data = array_merge($data, $this->getSubscriptionsReportData($request, $fromDate, $toDate));
                break;

            case 'overview':
            default:
                $tab = 'overview';
                $data['tab'] = 'overview';
                $data = array_merge($data, $this->getOverviewReportData($request, $fromDate, $toDate));
                break;
        }

        return view('admin.reports.index', $data);
    }

    /**
     * Parse date presets or custom range
     */
    protected function parseDateFilter(Request $request): array
    {
        $range = $request->get('range', 'this_month');
        $customFrom = $request->get('from_date');
        $customTo = $request->get('to_date');

        switch ($range) {
            case 'today':
                $fromDate = Carbon::today()->startOfDay();
                $toDate   = Carbon::today()->endOfDay();
                $label    = 'Today (' . $fromDate->format('d M Y') . ')';
                break;

            case 'yesterday':
                $fromDate = Carbon::yesterday()->startOfDay();
                $toDate   = Carbon::yesterday()->endOfDay();
                $label    = 'Yesterday (' . $fromDate->format('d M Y') . ')';
                break;

            case 'last_7_days':
                $fromDate = Carbon::today()->subDays(6)->startOfDay();
                $toDate   = Carbon::today()->endOfDay();
                $label    = 'Last 7 Days (' . $fromDate->format('d M') . ' - ' . $toDate->format('d M Y') . ')';
                break;

            case 'last_30_days':
                $fromDate = Carbon::today()->subDays(29)->startOfDay();
                $toDate   = Carbon::today()->endOfDay();
                $label    = 'Last 30 Days (' . $fromDate->format('d M') . ' - ' . $toDate->format('d M Y') . ')';
                break;

            case 'this_month':
                $fromDate = Carbon::now()->startOfMonth()->startOfDay();
                $toDate   = Carbon::now()->endOfMonth()->endOfDay();
                $label    = 'This Month (' . $fromDate->format('M Y') . ')';
                break;

            case 'last_month':
                $fromDate = Carbon::now()->subMonth()->startOfMonth()->startOfDay();
                $toDate   = Carbon::now()->subMonth()->endOfMonth()->endOfDay();
                $label    = 'Last Month (' . $fromDate->format('M Y') . ')';
                break;

            case 'this_year':
                $fromDate = Carbon::now()->startOfYear()->startOfDay();
                $toDate   = Carbon::now()->endOfYear()->endOfDay();
                $label    = 'This Year (' . $fromDate->format('Y') . ')';
                break;

            case 'all':
                $fromDate = Carbon::create(2020, 1, 1)->startOfDay();
                $toDate   = Carbon::now()->addYear()->endOfDay();
                $label    = 'All Time';
                break;

            case 'custom':
            default:
                if (!empty($customFrom) && !empty($customTo)) {
                    $fromDate = Carbon::parse($customFrom)->startOfDay();
                    $toDate   = Carbon::parse($customTo)->endOfDay();
                    $label    = 'Custom (' . $fromDate->format('d M Y') . ' - ' . $toDate->format('d M Y') . ')';
                    $range    = 'custom';
                } else {
                    $range    = 'this_month';
                    $fromDate = Carbon::now()->startOfMonth()->startOfDay();
                    $toDate   = Carbon::now()->endOfMonth()->endOfDay();
                    $label    = 'This Month (' . $fromDate->format('M Y') . ')';
                }
                break;
        }

        return [$fromDate, $toDate, $range, $label];
    }

    /**
     * 1. Overview Tab Data
     */
    protected function getOverviewReportData(Request $request, Carbon $fromDate, Carbon $toDate): array
    {
        // High level numbers
        $totalRevenue = Payment::where('status', 'success')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->sum('amount');

        $totalAppointments = Appointment::whereBetween('created_at', [$fromDate, $toDate])->count();

        $completedAppointments = Appointment::where('status', 'completed')
            ->whereBetween('appointment_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')])
            ->count();

        $activeDoctorsCount = User::where('role', 'doctor')->where('status', 'active')->count();
        $totalDoctorsCount  = User::where('role', 'doctor')->count();

        $newPatientsCount   = User::where('role', 'patient')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->count();
        $totalPatientsCount = User::where('role', 'patient')->count();

        $subscriptionsSoldCount = PatientPlanSubscription::whereBetween('created_at', [$fromDate, $toDate])->count();
        $activeSubscriptionsCount = PatientPlanSubscription::where('status', 'active')->count();
        $subscriptionRevenue = PatientPlanSubscription::where('payment_status', 'paid')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->sum('package_price');

        $doctorPayoutsTotal = Payment::where('status', 'success')
            ->where('payment_method', 'admin_manual')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->sum('amount');

        // Status Breakdowns
        $appointmentStatuses = Appointment::whereBetween('created_at', [$fromDate, $toDate])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $paymentStatuses = Payment::whereBetween('created_at', [$fromDate, $toDate])
            ->select('status', DB::raw('count(*) as count'), DB::raw('sum(amount) as total'))
            ->groupBy('status')
            ->get();

        $popularPlans = PatientPlanSubscription::with('plan:id,name,price')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->select('patient_plan_id', DB::raw('count(*) as total_sold'), DB::raw('sum(package_price) as total_amount'))
            ->groupBy('patient_plan_id')
            ->orderByDesc('total_sold')
            ->limit(4)
            ->get();

        $topDoctors = User::where('role', 'doctor')
            ->with(['profile.specializationdata'])
            ->withCount([
                'doctorAppointments as completed_count' => function ($q) use ($fromDate, $toDate) {
                    $q->where('status', 'completed')
                      ->whereBetween('appointment_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);
                }
            ])
            ->orderByDesc('completed_count')
            ->limit(5)
            ->get();

        // Trend Chart Data (daily or weekly buckets)
        $diffDays = $fromDate->diffInDays($toDate);
        $chartLabels = [];
        $chartRevenue = [];
        $chartAppointments = [];

        if ($diffDays <= 35) {
            $cursor = $fromDate->copy();
            while ($cursor <= $toDate) {
                $dayStr = $cursor->format('Y-m-d');
                $chartLabels[] = $cursor->format('d M');

                $rev = Payment::where('status', 'success')
                    ->whereDate('created_at', $dayStr)
                    ->sum('amount');
                $chartRevenue[] = (float) $rev;

                $appts = Appointment::whereDate('appointment_date', $dayStr)->count();
                $chartAppointments[] = (int) $appts;

                $cursor->addDay();
            }
        } else {
            // Group by month
            $cursor = $fromDate->copy()->startOfMonth();
            while ($cursor <= $toDate) {
                $m = $cursor->month;
                $y = $cursor->year;
                $chartLabels[] = $cursor->format('M Y');

                $rev = Payment::where('status', 'success')
                    ->whereMonth('created_at', $m)
                    ->whereYear('created_at', $y)
                    ->sum('amount');
                $chartRevenue[] = (float) $rev;

                $appts = Appointment::whereMonth('appointment_date', $m)
                    ->whereYear('appointment_date', $y)
                    ->count();
                $chartAppointments[] = (int) $appts;

                $cursor->addMonth();
            }
        }

        // Recent Activity
        $recentPayments = Payment::with(['patient:id,name,phone', 'doctor:id,name'])
            ->where('status', 'success')
            ->latest()
            ->limit(5)
            ->get();

        $recentAppointments = Appointment::with(['patient:id,name', 'doctor:id,name'])
            ->latest()
            ->limit(5)
            ->get();

        $recentSubscriptions = PatientPlanSubscription::with(['patient:id,name,phone', 'plan:id,name'])
            ->latest()
            ->limit(5)
            ->get();

        return compact(
            'totalRevenue',
            'totalAppointments',
            'completedAppointments',
            'activeDoctorsCount',
            'totalDoctorsCount',
            'newPatientsCount',
            'totalPatientsCount',
            'subscriptionsSoldCount',
            'activeSubscriptionsCount',
            'subscriptionRevenue',
            'doctorPayoutsTotal',
            'appointmentStatuses',
            'paymentStatuses',
            'popularPlans',
            'topDoctors',
            'chartLabels',
            'chartRevenue',
            'chartAppointments',
            'recentPayments',
            'recentAppointments',
            'recentSubscriptions'
        );
    }

    /**
     * 2. Payments Tab Data
     */
    protected function getPaymentsReportData(Request $request, Carbon $fromDate, Carbon $toDate): array
    {
        $paymentsGross = Payment::where('status', 'success')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->sum('amount');

        $paymentsCount = Payment::whereBetween('created_at', [$fromDate, $toDate])->count();
        $successfulCount = Payment::where('status', 'success')->whereBetween('created_at', [$fromDate, $toDate])->count();
        $pendingCount = Payment::where('status', 'pending')->whereBetween('created_at', [$fromDate, $toDate])->count();
        $failedCount = Payment::where('status', 'failed')->whereBetween('created_at', [$fromDate, $toDate])->count();

        $doctorPayoutTotal = Payment::where('status', 'success')
            ->where('payment_method', 'admin_manual')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->sum('amount');

        $avgTransaction = $successfulCount > 0 ? round($paymentsGross / $successfulCount, 2) : 0;

        // Query
        $paymentsQuery = Payment::with(['patient', 'doctor', 'appointment'])
            ->whereBetween('created_at', [$fromDate, $toDate]);

        if ($request->filled('payment_status')) {
            $paymentsQuery->where('status', $request->payment_status);
        }
        if ($request->filled('payment_method')) {
            $paymentsQuery->where('payment_method', $request->payment_method);
        }
        if ($request->filled('search')) {
            $s = trim($request->search);
            $paymentsQuery->where(function ($q) use ($s) {
                $q->where('transaction_id', 'like', "%{$s}%")
                  ->orWhereHas('patient', function ($pq) use ($s) {
                      $pq->where('name', 'like', "%{$s}%")->orWhere('phone', 'like', "%{$s}%");
                  })
                  ->orWhereHas('doctor', function ($dq) use ($s) {
                      $dq->where('name', 'like', "%{$s}%");
                  });
            });
        }

        $payments = $paymentsQuery->latest()->paginate(15)->withQueryString();

        return compact(
            'paymentsGross',
            'paymentsCount',
            'successfulCount',
            'pendingCount',
            'failedCount',
            'doctorPayoutTotal',
            'avgTransaction',
            'payments'
        );
    }

    /**
     * 3. Appointments Tab Data
     */
    protected function getAppointmentsReportData(Request $request, Carbon $fromDate, Carbon $toDate): array
    {
        $baseQuery = Appointment::whereBetween('appointment_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);

        $totalAppointments     = (clone $baseQuery)->count();
        $completedAppointments = (clone $baseQuery)->where('status', 'completed')->count();
        $confirmedAppointments = (clone $baseQuery)->where('status', 'confirmed')->count();
        $pendingAppointments   = (clone $baseQuery)->where('status', 'pending')->count();
        $cancelledAppointments = (clone $baseQuery)->where('status', 'cancelled')->count();
        $completionRate        = $totalAppointments > 0 ? round(($completedAppointments / $totalAppointments) * 100, 1) : 0;

        // Filterable list
        $apptsQuery = Appointment::with(['doctor.profile.specializationdata', 'patient', 'timeSlot'])
            ->whereBetween('appointment_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);

        if ($request->filled('appointment_status')) {
            $apptsQuery->where('status', $request->appointment_status);
        }
        if ($request->filled('doctor_id')) {
            $apptsQuery->where('doctor_id', $request->doctor_id);
        }
        if ($request->filled('search')) {
            $s = trim($request->search);
            $apptsQuery->where(function ($q) use ($s) {
                $q->where('patient_name', 'like', "%{$s}%")
                  ->orWhereHas('patient', function ($pq) use ($s) {
                      $pq->where('name', 'like', "%{$s}%")->orWhere('phone', 'like', "%{$s}%");
                  })
                  ->orWhereHas('doctor', function ($dq) use ($s) {
                      $dq->where('name', 'like', "%{$s}%");
                  });
            });
        }

        $appointments = $apptsQuery->latest('appointment_date')->paginate(15)->withQueryString();

        return compact(
            'totalAppointments',
            'completedAppointments',
            'confirmedAppointments',
            'pendingAppointments',
            'cancelledAppointments',
            'completionRate',
            'appointments'
        );
    }

    /**
     * 4. Doctors Tab Data
     */
    protected function getDoctorsReportData(Request $request, Carbon $fromDate, Carbon $toDate): array
    {
        $totalDoctors = User::where('role', 'doctor')->count();
        $activeDoctors = User::where('role', 'doctor')->where('status', 'active')->count();

        // Slots in date range
        $totalSlotsInPeriod = DoctorTimeSlot::whereHas('availabilityDate', function ($q) use ($fromDate, $toDate) {
            $q->whereBetween('available_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);
        })->count();

        $bookedSlotsInPeriod = DoctorTimeSlot::where('is_booked', true)
            ->whereHas('availabilityDate', function ($q) use ($fromDate, $toDate) {
                $q->whereBetween('available_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);
            })->count();

        $slotUtilizationRate = $totalSlotsInPeriod > 0 ? round(($bookedSlotsInPeriod / $totalSlotsInPeriod) * 100, 1) : 0;

        // Doctors Query
        $doctorsQuery = User::where('role', 'doctor')->with(['profile.specializationdata', 'fee']);

        if ($request->filled('doctor_status')) {
            $doctorsQuery->where('status', $request->doctor_status);
        }
        if ($request->filled('specialization_id')) {
            $doctorsQuery->whereHas('profile', function ($q) use ($request) {
                $q->where('specialization', $request->specialization_id);
            });
        }
        if ($request->filled('search')) {
            $s = trim($request->search);
            $doctorsQuery->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%");
            });
        }

        $doctors = $doctorsQuery->withCount([
            'timeSlots as total_slots_period' => function ($q) use ($fromDate, $toDate) {
                $q->whereHas('availabilityDate', function ($dq) use ($fromDate, $toDate) {
                    $dq->whereBetween('available_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);
                });
            },
            'timeSlots as booked_slots_period' => function ($q) use ($fromDate, $toDate) {
                $q->where('is_booked', true)
                  ->whereHas('availabilityDate', function ($dq) use ($fromDate, $toDate) {
                      $dq->whereBetween('available_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);
                  });
            },
            'doctorAppointments as completed_appointments_period' => function ($q) use ($fromDate, $toDate) {
                $q->where('status', 'completed')
                  ->whereBetween('appointment_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);
            },
            'doctorAppointments as total_appointments_period' => function ($q) use ($fromDate, $toDate) {
                $q->whereBetween('appointment_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);
            }
        ])->paginate(15)->withQueryString();

        return compact(
            'totalDoctors',
            'activeDoctors',
            'totalSlotsInPeriod',
            'bookedSlotsInPeriod',
            'slotUtilizationRate',
            'doctors'
        );
    }

    /**
     * 5. Patients Tab Data
     */
    protected function getPatientsReportData(Request $request, Carbon $fromDate, Carbon $toDate): array
    {
        $totalPatients = User::where('role', 'patient')->count();
        $newPatientsInPeriod = User::where('role', 'patient')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->count();

        // Count of patients with at least 1 booking in date range
        $patientsWithAppointments = Appointment::whereBetween('appointment_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')])
            ->distinct('patient_id')
            ->count('patient_id');

        $patientsWithActiveSubscriptions = PatientPlanSubscription::where('status', 'active')
            ->distinct('patient_id')
            ->count('patient_id');

        $patientsQuery = User::where('role', 'patient');

        if ($request->filled('search')) {
            $s = trim($request->search);
            $patientsQuery->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%")
                  ->orWhere('city', 'like', "%{$s}%");
            });
        }

        $patients = $patientsQuery->withCount([
            'patientAppointments as appointments_in_period' => function ($q) use ($fromDate, $toDate) {
                $q->whereBetween('appointment_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);
            },
            'patientAppointments as total_appointments_count',
        ])->latest()->paginate(15)->withQueryString();

        return compact(
            'totalPatients',
            'newPatientsInPeriod',
            'patientsWithAppointments',
            'patientsWithActiveSubscriptions',
            'patients'
        );
    }

    /**
     * 6. Subscriptions Tab Data
     */
    protected function getSubscriptionsReportData(Request $request, Carbon $fromDate, Carbon $toDate): array
    {
        $totalSubscriptionsPeriod = PatientPlanSubscription::whereBetween('created_at', [$fromDate, $toDate])->count();
        $activeSubscriptionsCount = PatientPlanSubscription::where('status', 'active')->count();
        $expiredSubscriptionsCount = PatientPlanSubscription::whereIn('status', ['expired', 'completed'])->count();
        
        $subscriptionRevenuePeriod = PatientPlanSubscription::where('payment_status', 'paid')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->sum('package_price');

        $totalAppointmentsAllotted = PatientPlanSubscription::whereBetween('created_at', [$fromDate, $toDate])
            ->sum('package_appointments');

        $totalAppointmentsUsed = PatientPlanSubscription::whereBetween('created_at', [$fromDate, $toDate])
            ->sum('used_appointments');

        $sessionUtilizationRate = $totalAppointmentsAllotted > 0 
            ? round(($totalAppointmentsUsed / $totalAppointmentsAllotted) * 100, 1) 
            : 0;

        // Subscriptions query
        $subsQuery = PatientPlanSubscription::with(['patient', 'doctor', 'plan'])
            ->whereBetween('created_at', [$fromDate, $toDate]);

        if ($request->filled('subscription_status')) {
            $subsQuery->where('status', $request->subscription_status);
        }
        if ($request->filled('payment_status')) {
            $subsQuery->where('payment_status', $request->payment_status);
        }
        if ($request->filled('patient_plan_id')) {
            $subsQuery->where('patient_plan_id', $request->patient_plan_id);
        }
        if ($request->filled('search')) {
            $s = trim($request->search);
            $subsQuery->where(function ($q) use ($s) {
                $q->where('unique_plan_id', 'like', "%{$s}%")
                  ->orWhereHas('patient', function ($pq) use ($s) {
                      $pq->where('name', 'like', "%{$s}%")->orWhere('phone', 'like', "%{$s}%");
                  })
                  ->orWhereHas('plan', function ($plq) use ($s) {
                      $plq->where('name', 'like', "%{$s}%");
                  });
            });
        }

        $subscriptions = $subsQuery->latest()->paginate(15)->withQueryString();

        return compact(
            'totalSubscriptionsPeriod',
            'activeSubscriptionsCount',
            'expiredSubscriptionsCount',
            'subscriptionRevenuePeriod',
            'totalAppointmentsAllotted',
            'totalAppointmentsUsed',
            'sessionUtilizationRate',
            'subscriptions'
        );
    }

    /**
     * CSV Export Method for Current Tab and Active Date Filter
     */
    public function export(Request $request): StreamedResponse
    {
        $tab = $request->get('tab', 'overview');
        [$fromDate, $toDate, $range, $rangeLabel] = $this->parseDateFilter($request);

        $filename = "physiopii_report_{$tab}_" . date('Y-m-d_His') . ".csv";

        return response()->stream(function () use ($tab, $fromDate, $toDate, $request) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM for Microsoft Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            switch ($tab) {
                case 'payments':
                    fputcsv($handle, ['ID', 'Date & Time', 'Transaction ID', 'Patient Name', 'Patient Phone', 'Doctor Name', 'Amount (INR)', 'Payment Method', 'Status']);
                    
                    $payments = Payment::with(['patient', 'doctor'])
                        ->whereBetween('created_at', [$fromDate, $toDate])
                        ->latest()
                        ->get();

                    foreach ($payments as $p) {
                        fputcsv($handle, [
                            $p->id,
                            $p->created_at ? $p->created_at->format('Y-m-d H:i:s') : '',
                            $p->transaction_id ?? 'N/A',
                            $p->patient->name ?? 'Guest/Unknown',
                            $p->patient->phone ?? '',
                            $p->doctor->name ?? 'N/A',
                            number_format($p->amount, 2, '.', ''),
                            strtoupper($p->payment_method ?? 'N/A'),
                            ucfirst($p->status ?? 'pending'),
                        ]);
                    }
                    break;

                case 'appointments':
                    fputcsv($handle, ['ID', 'Appointment Date', 'Time Slot', 'Patient Name', 'Patient Phone', 'Gender', 'Age', 'Doctor Name', 'Specialization', 'Status', 'Payment Status']);
                    
                    $appts = Appointment::with(['patient', 'doctor.profile.specializationdata'])
                        ->whereBetween('appointment_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')])
                        ->latest('appointment_date')
                        ->get();

                    foreach ($appts as $a) {
                        $spec = $a->doctor && $a->doctor->profile && $a->doctor->profile->specializationdata 
                            ? $a->doctor->profile->specializationdata->name 
                            : 'General';

                        fputcsv($handle, [
                            $a->id,
                            $a->appointment_date ? $a->appointment_date->format('Y-m-d') : '',
                            ($a->start_time ? $a->start_time->format('H:i') : '') . ' - ' . ($a->end_time ? $a->end_time->format('H:i') : ''),
                            $a->patient_name ?? ($a->patient->name ?? 'N/A'),
                            $a->patient->phone ?? '',
                            $a->patient_gender ?? '',
                            $a->patient_age ?? '',
                            $a->doctor->name ?? 'N/A',
                            $spec,
                            ucfirst($a->status ?? 'pending'),
                            ucfirst($a->payment_status ?? 'unpaid'),
                        ]);
                    }
                    break;

                case 'doctors':
                    fputcsv($handle, ['Doctor ID', 'Doctor Name', 'Email', 'Phone', 'Specialization', 'Status', 'Slots in Period', 'Booked Slots', 'Completed Appointments']);
                    
                    $doctors = User::where('role', 'doctor')
                        ->with(['profile.specializationdata'])
                        ->withCount([
                            'timeSlots as total_slots_period' => function ($q) use ($fromDate, $toDate) {
                                $q->whereHas('availabilityDate', function ($dq) use ($fromDate, $toDate) {
                                    $dq->whereBetween('available_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);
                                });
                            },
                            'timeSlots as booked_slots_period' => function ($q) use ($fromDate, $toDate) {
                                $q->where('is_booked', true)
                                  ->whereHas('availabilityDate', function ($dq) use ($fromDate, $toDate) {
                                      $dq->whereBetween('available_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);
                                  });
                            },
                            'doctorAppointments as completed_appointments_period' => function ($q) use ($fromDate, $toDate) {
                                $q->where('status', 'completed')
                                  ->whereBetween('appointment_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);
                            }
                        ])
                        ->get();

                    foreach ($doctors as $d) {
                        $spec = $d->profile && $d->profile->specializationdata ? $d->profile->specializationdata->name : 'General';
                        fputcsv($handle, [
                            $d->id,
                            $d->name,
                            $d->email,
                            $d->phone,
                            $spec,
                            ucfirst($d->status ?? 'active'),
                            $d->total_slots_period ?? 0,
                            $d->booked_slots_period ?? 0,
                            $d->completed_appointments_period ?? 0,
                        ]);
                    }
                    break;

                case 'patients':
                    fputcsv($handle, ['Patient ID', 'Name', 'Email', 'Phone', 'City', 'Joined Date', 'Appointments in Period', 'Total Appointments']);
                    
                    $patients = User::where('role', 'patient')
                        ->withCount([
                            'patientAppointments as appointments_in_period' => function ($q) use ($fromDate, $toDate) {
                                $q->whereBetween('appointment_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);
                            },
                            'patientAppointments as total_appointments_count',
                        ])
                        ->latest()
                        ->get();

                    foreach ($patients as $pt) {
                        fputcsv($handle, [
                            $pt->id,
                            $pt->name,
                            $pt->email,
                            $pt->phone,
                            $pt->city ?? 'N/A',
                            $pt->created_at ? $pt->created_at->format('Y-m-d') : '',
                            $pt->appointments_in_period ?? 0,
                            $pt->total_appointments_count ?? 0,
                        ]);
                    }
                    break;

                case 'subscriptions':
                default:
                    fputcsv($handle, ['ID', 'Unique Plan ID', 'Patient Name', 'Patient Phone', 'Doctor Name', 'Package Name', 'Price (INR)', 'Total Sessions', 'Used Sessions', 'Remaining Sessions', 'Start Date', 'End Date', 'Payment Status', 'Subscription Status']);
                    
                    $subs = PatientPlanSubscription::with(['patient', 'doctor', 'plan'])
                        ->whereBetween('created_at', [$fromDate, $toDate])
                        ->latest()
                        ->get();

                    foreach ($subs as $s) {
                        fputcsv($handle, [
                            $s->id,
                            $s->unique_plan_id,
                            $s->patient->name ?? 'N/A',
                            $s->patient->phone ?? '',
                            $s->doctor->name ?? 'Any / Not assigned',
                            $s->plan->name ?? 'Custom Package',
                            number_format($s->package_price, 2, '.', ''),
                            $s->package_appointments,
                            $s->used_appointments,
                            $s->remaining_appointments,
                            $s->start_date ? $s->start_date->format('Y-m-d') : '',
                            $s->end_date ? $s->end_date->format('Y-m-d') : '',
                            ucfirst($s->payment_status ?? 'pending'),
                            ucfirst($s->status ?? 'active'),
                        ]);
                    }
                    break;
            }

            fclose($handle);
        }, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
