@extends('admin.layouts.admin')

@section('content')

<style>
    *, *::before, *::after { box-sizing: border-box; }

    .db-wrap {
        font-family: 'Inter', 'Poppins', sans-serif;
        color: #0f172a;
        padding: 0 0 40px;
    }

    /* ── PAGE HEADER ──────────────────────────────────── */
    .db-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .db-header-left h1 {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 3px;
        letter-spacing: -0.03em;
    }

    .db-header-left p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    .db-date-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 12.5px;
        font-weight: 500;
        color: #475569;
    }

    .db-date-badge svg { flex-shrink: 0; }

    /* ── STAT CARDS ──────────────────────────────────── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 14px;
        padding: 20px 22px 18px;
        position: relative;
        overflow: hidden;
        transition: box-shadow 0.18s, transform 0.18s;
    }

    .stat-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transform: translateY(-1px);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 14px 14px 0 0;
    }

    .stat-card.blue::before  { background: #2563EB; }
    .stat-card.green::before { background: #10b981; }
    .stat-card.amber::before { background: #f59e0b; }
    .stat-card.rose::before  { background: #f43f5e; }

    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .stat-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon.blue  { background: #EFF6FF; color: #2563EB; }
    .stat-icon.green { background: #ECFDF5; color: #10b981; }
    .stat-icon.amber { background: #FFFBEB; color: #f59e0b; }
    .stat-icon.rose  { background: #FFF1F2; color: #f43f5e; }

    .stat-icon svg { width: 18px; height: 18px; }

    .stat-change {
        font-size: 11.5px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 20px;
    }

    .stat-change.positive {
        background: #ECFDF5;
        color: #059669;
    }

    .stat-change.negative {
        background: #FFF1F2;
        color: #e11d48;
    }

    .stat-change.neutral {
        background: #f1f5f9;
        color: #64748b;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.04em;
        line-height: 1;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 12.5px;
        color: #64748b;
        font-weight: 400;
    }

    /* ── APPOINTMENT STATUS ROW ──────────────────────── */
    .appt-status-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 24px;
    }

    .appt-chip {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 12px;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .appt-chip-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .appt-chip-dot.pending   { background: #f59e0b; }
    .appt-chip-dot.confirmed { background: #2563EB; }
    .appt-chip-dot.completed { background: #10b981; }
    .appt-chip-dot.cancelled { background: #f43f5e; }

    .appt-chip-info {}
    .appt-chip-val {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.03em;
        line-height: 1;
    }

    .appt-chip-lbl {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    /* ── BOTTOM GRID ─────────────────────────────────── */
    .db-bottom-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 20px;
    }

    /* ── CHART CARD ──────────────────────────────────── */
    .chart-card, .table-card, .sub-card {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 14px;
        overflow: hidden;
    }

    .card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 22px 14px;
        border-bottom: 1px solid #f1f5f9;
    }

    .card-head-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-head-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #EFF6FF;
        color: #2563EB;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-head-icon svg { width: 16px; height: 16px; }

    .card-head-title {
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
    }

    .card-head-sub {
        font-size: 12px;
        color: #94a3b8;
        margin: 1px 0 0;
    }

    .chart-wrap {
        padding: 18px 22px 20px;
        height: 220px;
        position: relative;
    }

    .chart-wrap canvas {
        max-height: 200px;
    }

    /* ── RECENT TABLE ────────────────────────────────── */
    .db-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .db-table th {
        padding: 10px 20px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
    }

    .db-table td {
        padding: 12px 20px;
        color: #334155;
        border-bottom: 1px solid #f8fafc;
        vertical-align: middle;
    }

    .db-table tr:last-child td {
        border-bottom: none;
    }

    .db-table tr:hover td {
        background: #fafbff;
    }

    .patient-name {
        font-weight: 500;
        color: #0f172a;
    }

    .doctor-name {
        color: #64748b;
        font-size: 12px;
    }

    /* Status pills */
    .pill {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .pill.pending   { background: #FFFBEB; color: #b45309; }
    .pill.confirmed { background: #EFF6FF; color: #1d4ed8; }
    .pill.completed { background: #ECFDF5; color: #065f46; }
    .pill.cancelled { background: #FFF1F2; color: #be123c; }

    /* ── SUBSCRIPTION CARD ───────────────────────────── */
    .sub-list { padding: 6px 0; }

    .sub-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.12s;
    }

    .sub-item:last-child { border-bottom: none; }
    .sub-item:hover { background: #fafbff; }

    .sub-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #EFF6FF;
        color: #2563EB;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .sub-info { flex: 1; min-width: 0; }

    .sub-patient-name {
        font-size: 13px;
        font-weight: 500;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sub-plan-name {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 1px;
    }

    .sub-status {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 20px;
        flex-shrink: 0;
    }

    .sub-status.active   { background: #ECFDF5; color: #065f46; }
    .sub-status.expired  { background: #f1f5f9; color: #64748b; }
    .sub-status.cancelled { background: #FFF1F2; color: #be123c; }

    /* ── TODAY CARD ──────────────────────────────────── */
    .today-card {
        background: #0A1628;
        border-radius: 14px;
        padding: 22px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        overflow: hidden;
    }

    .today-card::before {
        content: '';
        position: absolute;
        right: -20px; top: -20px;
        width: 140px; height: 140px;
        border-radius: 50%;
        background: rgba(37,99,235,0.15);
    }

    .today-card::after {
        content: '';
        position: absolute;
        right: 40px; bottom: -30px;
        width: 90px; height: 90px;
        border-radius: 50%;
        background: rgba(37,99,235,0.08);
    }

    .today-ecg {
        flex: 1;
        position: relative;
        z-index: 1;
    }

    .today-ecg svg { width: 100%; max-width: 200px; display: block; }

    .ecg-draw {
        stroke-dasharray: 300;
        stroke-dashoffset: 300;
        animation: ecgGo 2s ease-in-out 0.3s forwards;
    }

    @keyframes ecgGo { to { stroke-dashoffset: 0; } }

    .today-info { position: relative; z-index: 1; }

    .today-label {
        font-size: 11.5px;
        font-weight: 500;
        color: rgba(255,255,255,0.5);
        letter-spacing: 0.07em;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .today-value {
        font-size: 36px;
        font-weight: 700;
        color: #fff;
        letter-spacing: -0.04em;
        line-height: 1;
        margin-bottom: 4px;
    }

    .today-sub {
        font-size: 12.5px;
        color: rgba(255,255,255,0.45);
    }

    .today-right {
        display: flex;
        flex-direction: column;
        gap: 10px;
        position: relative;
        z-index: 1;
    }

    .today-mini {
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 10px 16px;
        text-align: center;
        min-width: 90px;
    }

    .today-mini-val {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        letter-spacing: -0.03em;
        line-height: 1;
    }

    .today-mini-lbl {
        font-size: 10.5px;
        color: rgba(255,255,255,0.4);
        margin-top: 3px;
    }

    /* ── RESPONSIVE ──────────────────────────────────── */
    @media (max-width: 1100px) {
        .stats-grid        { grid-template-columns: repeat(2, 1fr); }
        .appt-status-row   { grid-template-columns: repeat(2, 1fr); }
        .db-bottom-grid    { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .stats-grid        { grid-template-columns: 1fr; }
        .appt-status-row   { grid-template-columns: repeat(2, 1fr); }
        .today-card        { flex-direction: column; align-items: flex-start; }
        .today-right       { flex-direction: row; flex-wrap: wrap; }
    }
</style>

<div class="db-wrap">

    <!-- ── HEADER ── -->
    <div class="db-header">
        <div class="db-header-left">
            <h1>Dashboard</h1>
            <p>Welcome back! Here's what's happening with your platform today.</p>
        </div>
        <div class="db-date-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            {{ \Carbon\Carbon::now()->format('D, d M Y') }}
        </div>
    </div>

    <!-- ── TODAY SPOTLIGHT ── -->
    <div class="today-card">
        <div class="today-info">
            <div class="today-label">Today's appointments</div>
            <div class="today-value">{{ $todayAppointments }}</div>
            <div class="today-sub">Scheduled for {{ \Carbon\Carbon::today()->format('d M Y') }}</div>
        </div>

        <div class="today-ecg">
            <svg viewBox="0 0 200 50" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path class="ecg-draw"
                    d="M0 32 L20 32 L26 32 L32 10 L38 46 L44 32 L60 32
                       L66 32 L72 10 L78 46 L84 32 L105 32
                       L111 32 L117 10 L123 46 L129 32 L155 32
                       L161 32 L167 10 L173 46 L179 32 L200 32"
                    stroke="#3B82F6" stroke-width="1.4"
                    stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="today-right">
            <div class="today-mini">
                <div class="today-mini-val">{{ $totalDoctors }}</div>
                <div class="today-mini-lbl">Doctors</div>
            </div>
            <div class="today-mini">
                <div class="today-mini-val">{{ $activeSubscriptions }}</div>
                <div class="today-mini-lbl">Active plans</div>
            </div>
        </div>
    </div>

    <!-- ── MAIN STAT CARDS ── -->
    <div class="stats-grid">

        <div class="stat-card blue">
            <div class="stat-header">
                <div class="stat-icon blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                @if($userGrowth >= 0)
                    <span class="stat-change positive">↑ {{ abs($userGrowth) }}%</span>
                @else
                    <span class="stat-change negative">↓ {{ abs($userGrowth) }}%</span>
                @endif
            </div>
            <div class="stat-value">{{ number_format($totalUsers) }}</div>
            <div class="stat-label">Total Users</div>
        </div>

        <div class="stat-card green">
            <div class="stat-header">
                <div class="stat-icon green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                @if($apptGrowth >= 0)
                    <span class="stat-change positive">↑ {{ abs($apptGrowth) }}%</span>
                @else
                    <span class="stat-change negative">↓ {{ abs($apptGrowth) }}%</span>
                @endif
            </div>
            <div class="stat-value">{{ number_format($totalAppointments) }}</div>
            <div class="stat-label">Total Appointments</div>
        </div>

        <div class="stat-card amber">
            <div class="stat-header">
                <div class="stat-icon amber">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
                @if($revenueGrowth >= 0)
                    <span class="stat-change positive">↑ {{ abs($revenueGrowth) }}%</span>
                @else
                    <span class="stat-change negative">↓ {{ abs($revenueGrowth) }}%</span>
                @endif
            </div>
            <div class="stat-value">₹{{ number_format($totalRevenue, 0) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>

        <div class="stat-card rose">
            <div class="stat-header">
                <div class="stat-icon rose">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </div>
                <span class="stat-change neutral">{{ $activeSubscriptions }} active</span>
            </div>
            <div class="stat-value">{{ number_format($totalSubscriptions) }}</div>
            <div class="stat-label">Total Subscriptions</div>
        </div>

    </div>

    <!-- ── APPOINTMENT STATUS BREAKDOWN ── -->
    <div class="appt-status-row">
        <div class="appt-chip">
            <div class="appt-chip-dot pending"></div>
            <div class="appt-chip-info">
                <div class="appt-chip-val">{{ $pendingAppointments }}</div>
                <div class="appt-chip-lbl">Pending</div>
            </div>
        </div>
        <div class="appt-chip">
            <div class="appt-chip-dot confirmed"></div>
            <div class="appt-chip-info">
                <div class="appt-chip-val">{{ $confirmedAppointments }}</div>
                <div class="appt-chip-lbl">Confirmed</div>
            </div>
        </div>
        <div class="appt-chip">
            <div class="appt-chip-dot completed"></div>
            <div class="appt-chip-info">
                <div class="appt-chip-val">{{ $completedAppointments }}</div>
                <div class="appt-chip-lbl">Completed</div>
            </div>
        </div>
        <div class="appt-chip">
            <div class="appt-chip-dot cancelled"></div>
            <div class="appt-chip-info">
                <div class="appt-chip-val">{{ $cancelledAppointments }}</div>
                <div class="appt-chip-lbl">Cancelled</div>
            </div>
        </div>
    </div>

    <!-- ── CHART + SUBSCRIPTIONS ── -->
    <div class="db-bottom-grid">

        <!-- 7-Day Chart -->
        <div class="chart-card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="card-head-title">Appointment Trend</p>
                        <p class="card-head-sub">Last 7 days</p>
                    </div>
                </div>
            </div>
            <div class="chart-wrap">
                <canvas id="apptChart"></canvas>
            </div>
        </div>

        <!-- Recent Subscriptions -->
        <div class="sub-card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                    <div>
                        <p class="card-head-title">Recent Subscriptions</p>
                        <p class="card-head-sub">Latest plan activations</p>
                    </div>
                </div>
            </div>
            <div class="sub-list">
                @forelse($recentSubscriptions as $sub)
                    <div class="sub-item">
                        <div class="sub-avatar">
                            {{ strtoupper(substr($sub->patient->name ?? 'P', 0, 2)) }}
                        </div>
                        <div class="sub-info">
                            <div class="sub-patient-name">{{ $sub->patient->name ?? '—' }}</div>
                            <div class="sub-plan-name">{{ $sub->plan->name ?? '—' }}</div>
                        </div>
                        <span class="sub-status {{ $sub->status ?? 'active' }}">
                            {{ ucfirst($sub->status ?? 'active') }}
                        </span>
                    </div>
                @empty
                    <div style="padding: 24px 20px; text-align: center; color: #94a3b8; font-size: 13px;">
                        No subscriptions yet.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- ── RECENT APPOINTMENTS TABLE ── -->
    <div class="table-card" style="margin-top: 20px;">
        <div class="card-head">
            <div class="card-head-left">
                <div class="card-head-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div>
                    <p class="card-head-title">Recent Appointments</p>
                    <p class="card-head-sub">Last 6 bookings across all doctors</p>
                </div>
            </div>
            <a href="{{ route('admin.appointments.index') }}" style="font-size: 12.5px; color: #2563EB; font-weight: 500; text-decoration: none;">
                View all →
            </a>
        </div>
        <div style="overflow-x: auto;">
            <table class="db-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAppointments as $appt)
                        <tr>
                            <td>
                                <div class="patient-name">{{ $appt->patient_name ?? ($appt->patient->name ?? '—') }}</div>
                                @if($appt->patient_gender)
                                    <div class="doctor-name">{{ ucfirst($appt->patient_gender) }}{{ $appt->patient_age ? ', '.$appt->patient_age.'y' : '' }}</div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 500; color: #0f172a;">{{ $appt->doctor->name ?? '—' }}</div>
                            </td>
                            <td>{{ $appt->appointment_date ? \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y') : '—' }}</td>
                            <td style="color: #64748b;">
                                {{ $appt->start_time ? \Carbon\Carbon::parse($appt->start_time)->format('h:i A') : '—' }}
                            </td>
                            <td>
                                <span class="pill {{ $appt->status }}">{{ ucfirst($appt->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 28px; color: #94a3b8; font-size: 13px;">
                                No appointments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('apptChart').getContext('2d');

    const labels = @json($chartLabels);
    const data   = @json($chartData);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Appointments',
                data: data,
                borderColor: '#2563EB',
                backgroundColor: 'rgba(37,99,235,0.08)',
                borderWidth: 2,
                pointBackgroundColor: '#2563EB',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#94a3b8',
                    bodyColor: '#fff',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        title: items => items[0].label,
                        label: item => ' ' + item.raw + ' appointments'
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 11 },
                        color: '#94a3b8'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9', drawBorder: false },
                    ticks: {
                        font: { size: 11 },
                        color: '#94a3b8',
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

@endsection