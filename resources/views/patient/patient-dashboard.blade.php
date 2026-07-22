@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; }

    body { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; background: #f1f5f9; }

    /* ── PAGE LAYOUT ── */
    .pd-page { min-height: 100vh; display: flex; flex-direction: column; background: #f1f5f9; }

    .pd-body {
        max-width: 1320px;
        margin: 0 auto;
        padding: 32px 24px 48px;
        width: 100%;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 24px;
        align-items: start;
    }

    /* ── SIDEBAR ── */
    .pd-sidebar {
        position: sticky;
        top: 88px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* Profile Card */
    .pd-profile-card {
        background: linear-gradient(160deg, #0c4a6e, #0284c7);
        border-radius: 20px;
        padding: 28px 24px;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 16px 40px rgba(2,132,199,0.28);
    }
    .pd-profile-card::before {
        content: '';
        position: absolute;
        right: -30px; top: -30px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
    }

    .pd-avatar-wrap {
        width: 80px; height: 80px;
        border-radius: 50%;
        border: 3px solid rgba(255,255,255,0.4);
        overflow: hidden;
        margin-bottom: 16px;
        position: relative; z-index: 1;
    }
    .pd-avatar-wrap img { width: 100%; height: 100%; object-fit: cover; }

    .pd-profile-name {
        font-size: 18px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.02em;
        margin-bottom: 4px;
        position: relative; z-index: 1;
    }
    .pd-profile-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
        position: relative; z-index: 1;
        margin-top: 8px;
    }
    .pd-profile-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: rgba(255,255,255,0.7);
    }
    .pd-profile-meta-item svg { width: 13px; height: 13px; flex-shrink: 0; color: rgba(255,255,255,0.5); }

    /* Nav Card */
    .pd-nav-card {
        background: #fff;
        border-radius: 18px;
        padding: 10px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
    }

    .pd-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 14px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        transition: all 0.18s;
        cursor: pointer;
    }
    .pd-nav-item:hover { background: #f0f9ff; color: #0ea5e9; }
    .pd-nav-item.active { background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; box-shadow: 0 4px 14px rgba(14,165,233,0.3); }
    .pd-nav-item.active svg { color: #fff; }
    .pd-nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }
    .pd-nav-item.danger { color: #ef4444; }
    .pd-nav-item.danger:hover { background: #fef2f2; color: #dc2626; }

    .pd-nav-divider { height: 1px; background: #f1f5f9; margin: 6px 0; }

    /* Logout form */
    .pd-logout-form { width: 100%; }
    .pd-logout-btn {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 14px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #ef4444;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.18s;
    }
    .pd-logout-btn:hover { background: #fef2f2; color: #dc2626; }
    .pd-logout-btn svg { width: 17px; height: 17px; }

    /* ── MAIN CONTENT ── */
    .pd-main { display: flex; flex-direction: column; gap: 20px; }

    /* Page header */
    .pd-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 4px;
    }
    .pd-page-title { font-size: 22px; font-weight: 800; color: #0f172a; letter-spacing: -0.03em; margin: 0; }
    .pd-page-sub { font-size: 13.5px; color: #64748b; margin: 2px 0 0; }
    .pd-date-badge {
        display: flex;
        align-items: center;
        gap: 7px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 14px;
        font-size: 12.5px;
        font-weight: 600;
        color: #475569;
    }
    .pd-date-badge svg { width: 14px; height: 14px; }

    /* Stat row */
    .pd-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }

    .pd-stat {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e8edf2;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: box-shadow 0.18s, transform 0.18s;
        position: relative;
        overflow: hidden;
    }
    .pd-stat::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 16px 16px 0 0;
    }
    .pd-stat.blue::before  { background: linear-gradient(90deg, #0ea5e9, #38bdf8); }
    .pd-stat.green::before { background: linear-gradient(90deg, #10b981, #34d399); }
    .pd-stat.amber::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }

    .pd-stat:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.08); transform: translateY(-2px); }

    .pd-stat-icon {
        width: 46px; height: 46px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .pd-stat-icon.blue  { background: #e0f2fe; color: #0ea5e9; }
    .pd-stat-icon.green { background: #d1fae5; color: #10b981; }
    .pd-stat-icon.amber { background: #fef3c7; color: #f59e0b; }
    .pd-stat-icon svg { width: 20px; height: 20px; }

    .pd-stat-val { font-size: 26px; font-weight: 800; color: #0f172a; letter-spacing: -0.04em; line-height: 1; }
    .pd-stat-lbl { font-size: 12.5px; color: #64748b; margin-top: 4px; }

    /* Tab card */
    .pd-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 16px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    .pd-tabs {
        display: flex;
        border-bottom: 1px solid #f1f5f9;
        padding: 16px 20px 0;
        gap: 4px;
        overflow-x: auto;
        scrollbar-width: none;
    }
    .pd-tabs::-webkit-scrollbar { display: none; }

    .pd-tab {
        padding: 9px 16px;
        border-radius: 10px 10px 0 0;
        font-size: 13.5px;
        font-weight: 600;
        color: #94a3b8;
        cursor: pointer;
        border: none;
        background: transparent;
        transition: all 0.18s;
        white-space: nowrap;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
    }
    .pd-tab:hover { color: #475569; background: #f8fafc; }
    .pd-tab.active { color: #0ea5e9; border-bottom-color: #0ea5e9; background: #f0f9ff; font-weight: 700; }

    .pd-tab-content { display: none; }
    .pd-tab-content.active { display: block; }

    /* Table */
    .pd-table-wrap { overflow-x: auto; }
    table.pd-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    table.pd-table th {
        padding: 11px 20px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
    }
    table.pd-table td {
        padding: 14px 20px;
        color: #334155;
        border-bottom: 1px solid #f8fafc;
        vertical-align: middle;
    }
    table.pd-table tr:last-child td { border-bottom: none; }
    table.pd-table tr:hover td { background: #fafbff; }

    .pd-doc-cell { display: flex; align-items: center; gap: 12px; }
    .pd-doc-img {
        width: 38px; height: 38px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e0f2fe;
        flex-shrink: 0;
    }
    .pd-doc-img-placeholder {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .pd-doc-name { font-weight: 600; color: #0f172a; font-size: 13.5px; }
    .pd-doc-spec { font-size: 11.5px; color: #94a3b8; margin-top: 2px; }

    .pd-date-main { font-weight: 600; color: #0f172a; }
    .pd-date-time { font-size: 12px; color: #0ea5e9; margin-top: 2px; }

    /* Pills */
    .pd-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }
    .pd-pill-dot { width: 6px; height: 6px; border-radius: 50%; }
    .pd-pill.confirmed { background: #e0f2fe; color: #0369a1; }
    .pd-pill.confirmed .pd-pill-dot { background: #0ea5e9; }
    .pd-pill.pending   { background: #fef3c7; color: #92400e; }
    .pd-pill.pending .pd-pill-dot { background: #f59e0b; }
    .pd-pill.completed { background: #d1fae5; color: #065f46; }
    .pd-pill.completed .pd-pill-dot { background: #10b981; }
    .pd-pill.cancelled { background: #fee2e2; color: #991b1b; }
    .pd-pill.cancelled .pd-pill-dot { background: #ef4444; }
    .pd-pill.shifted   { background: #f3e8ff; color: #6b21a8; }
    .pd-pill.shifted .pd-pill-dot { background: #a855f7; }
    .pd-pill.success   { background: #d1fae5; color: #065f46; }
    .pd-pill.success .pd-pill-dot { background: #10b981; }
    .pd-pill.failed    { background: #fee2e2; color: #991b1b; }
    .pd-pill.failed .pd-pill-dot { background: #ef4444; }

    .pd-view-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        background: #f0f9ff;
        color: #0ea5e9;
        border-radius: 9px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.18s;
        border: 1px solid #bae6fd;
    }
    .pd-view-btn:hover { background: #e0f2fe; border-color: #7dd3fc; color: #0284c7; }
    .pd-view-btn svg { width: 13px; height: 13px; }

    .pd-empty {
        text-align: center;
        padding: 40px 20px;
        color: #94a3b8;
    }
    .pd-empty svg { width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 12px; }
    .pd-empty-title { font-size: 15px; font-weight: 600; color: #64748b; margin-bottom: 4px; }
    .pd-empty-sub { font-size: 13px; }

    /* Billing stats */
    .pd-billing-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; padding: 20px 20px 0; margin-bottom: 4px; }
    .pd-billing-stat {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .pd-billing-stat-icon {
        width: 42px; height: 42px;
        border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .pd-billing-stat-icon.green { background: #d1fae5; color: #10b981; }
    .pd-billing-stat-icon.blue  { background: #e0f2fe; color: #0ea5e9; }
    .pd-billing-stat-icon svg { width: 18px; height: 18px; }
    .pd-billing-stat-val { font-size: 22px; font-weight: 800; color: #0f172a; letter-spacing: -0.04em; }
    .pd-billing-stat-lbl { font-size: 12px; color: #64748b; margin-top: 3px; }

    /* Invoice number */
    .pd-inv { font-size: 12px; font-weight: 700; color: #94a3b8; font-family: monospace; background: #f1f5f9; padding: 3px 8px; border-radius: 6px; }

    /* Responsive */
    @media (max-width: 1024px) {
        .pd-body { grid-template-columns: 1fr; }
        .pd-sidebar { position: static; }
        .pd-stats { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 640px) {
        .pd-body { padding: 16px 14px 32px; }
        .pd-stats { grid-template-columns: 1fr; }
    }
</style>

<div class="pd-page">
    @include('layouts.header')

    <div class="pd-body">

        {{-- ── SIDEBAR ── --}}
        <aside class="pd-sidebar">

            {{-- Profile Card --}}
            <div class="pd-profile-card">
                <div class="pd-avatar-wrap">
                    <img src="{{ $patient->profile_img ? asset($patient->profile_img) : asset('assets/img/patients/patient.jpg') }}" alt="{{ $patient->name }}">
                </div>
                <div class="pd-profile-name">{{ Auth::user()->name }}</div>
                <div class="pd-profile-meta">
                    @if(Auth::user()->dob)
                    <div class="pd-profile-meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ \Carbon\Carbon::parse(Auth::user()->dob)->format('d M Y') }} &middot; {{ \Carbon\Carbon::parse(Auth::user()->dob)->age }}y
                    </div>
                    @endif
                    @if(Auth::user()->city)
                    <div class="pd-profile-meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ Auth::user()->city }}{{ Auth::user()->state ? ', '.Auth::user()->state : '' }}
                    </div>
                    @endif
                </div>
            </div>

            {{-- Nav Card --}}
            <div class="pd-nav-card">
                <a href="{{ route('patient.dashboard') }}" class="pd-nav-item active">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('patient.profile') }}" class="pd-nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Profile Settings
                </a>
                <a href="{{ route('patient.change.password') }}" class="pd-nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    Change Password
                </a>
                <div class="pd-nav-divider"></div>
                <form action="{{ route('patient.logout') }}" method="GET" class="pd-logout-form">
                    @csrf
                    <button type="submit" class="pd-logout-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>

        </aside>

        {{-- ── MAIN ── --}}
        <main class="pd-main">

            {{-- Page Header --}}
            <div class="pd-page-header">
                <div>
                    <h1 class="pd-page-title">My Dashboard</h1>
                    <p class="pd-page-sub">Track your appointments and health journey</p>
                </div>
                <div class="pd-date-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ \Carbon\Carbon::now()->format('D, d M Y') }}
                </div>
            </div>

            {{-- Stats Row --}}
            <div class="pd-stats">
                <div class="pd-stat blue">
                    <div class="pd-stat-icon blue">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div>
                        <div class="pd-stat-val">{{ $appointments->count() }}</div>
                        <div class="pd-stat-lbl">Total Appointments</div>
                    </div>
                </div>
                <div class="pd-stat green">
                    <div class="pd-stat-icon green">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="pd-stat-val">{{ $completedAppointments->count() }}</div>
                        <div class="pd-stat-lbl">Completed</div>
                    </div>
                </div>
                <div class="pd-stat amber">
                    <div class="pd-stat-icon amber">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="pd-stat-val">{{ $upcomingAppointments->count() }}</div>
                        <div class="pd-stat-lbl">Upcoming</div>
                    </div>
                </div>
            </div>

            {{-- Tab Card --}}
            <div class="pd-card">
                <div class="pd-tabs">
                    <button class="pd-tab active" onclick="switchTab('all', this)">All Appointments</button>
                    <button class="pd-tab" onclick="switchTab('upcoming', this)">Upcoming</button>
                    <button class="pd-tab" onclick="switchTab('completed', this)">Completed</button>
                    <button class="pd-tab" onclick="switchTab('shifted', this)">Shifted</button>
                    <button class="pd-tab" onclick="switchTab('cancelled', this)">Cancelled</button>
                    <button class="pd-tab" onclick="switchTab('billing', this)">Billing</button>
                </div>

                {{-- Helper macro for appointment table --}}
                @php
                    function apptRow($appointment) {
                        $status = $appointment->status;
                        $imgSrc = $appointment->doctor->profile_img
                            ? asset($appointment->doctor->profile_img)
                            : null;
                        $docName = $appointment->doctor->name ?? '—';
                        $spec = $appointment->doctor->profile->specializationdata->name ?? 'Doctor';
                        $apptDate = $appointment->appointment_date->format('d M Y');
                        $apptTime = \Carbon\Carbon::parse($appointment->start_time)->format('h:i A');
                        $bookDate = $appointment->created_at->format('d M Y');
                        $fee = '₹'.number_format($appointment->doctor->fee->doctor_fee ?? 0, 2);
                        $followUp = $appointment->appointment_date->isFuture()
                            ? $appointment->appointment_date->copy()->addDays(7)->format('d M Y')
                            : '—';
                        return compact('status','imgSrc','docName','spec','apptDate','apptTime','bookDate','fee','followUp');
                    }
                @endphp

                {{-- Macro: renders a table from a collection --}}
                @php
                    function renderApptTable($rows) { return $rows; }
                @endphp

                {{-- ALL --}}
                <div class="pd-tab-content active" id="tab-all">
                    <div class="pd-table-wrap">
                        <table class="pd-table">
                            <thead><tr><th>Doctor</th><th>Appt Date</th><th>Booked On</th><th>Amount</th><th>Follow Up</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                    @php $d = apptRow($appointment); @endphp
                                    <tr>
                                        <td>
                                            <div class="pd-doc-cell">
                                                @if($d['imgSrc'])
                                                    <img class="pd-doc-img" src="{{ $d['imgSrc'] }}" alt="Dr. {{ $d['docName'] }}">
                                                @else
                                                    <div class="pd-doc-img-placeholder">{{ strtoupper(substr($d['docName'],0,2)) }}</div>
                                                @endif
                                                <div>
                                                    <div class="pd-doc-name">Dr. {{ $d['docName'] }}</div>
                                                    <div class="pd-doc-spec">{{ $d['spec'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><div class="pd-date-main">{{ $d['apptDate'] }}</div><div class="pd-date-time">{{ $d['apptTime'] }}</div></td>
                                        <td style="color:#64748b">{{ $d['bookDate'] }}</td>
                                        <td style="font-weight:600;color:#0f172a">{{ $d['fee'] }}</td>
                                        <td style="color:#64748b;font-size:13px">{{ $d['followUp'] }}</td>
                                        <td><span class="pd-pill {{ $d['status'] }}"><span class="pd-pill-dot"></span>{{ ucfirst($d['status']) }}</span></td>
                                        <td><a href="{{ route('patient.appointments.show', $appointment->id) }}" class="pd-view-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>View</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7"><div class="pd-empty"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><div class="pd-empty-title">No appointments yet</div><div class="pd-empty-sub">Book your first session with a doctor to get started.</div></div></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- UPCOMING --}}
                <div class="pd-tab-content" id="tab-upcoming">
                    <div class="pd-table-wrap">
                        <table class="pd-table">
                            <thead><tr><th>Doctor</th><th>Appt Date</th><th>Booked On</th><th>Amount</th><th>Follow Up</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                @forelse($upcomingAppointments as $appointment)
                                    @php $d = apptRow($appointment); @endphp
                                    <tr>
                                        <td><div class="pd-doc-cell">@if($d['imgSrc'])<img class="pd-doc-img" src="{{ $d['imgSrc'] }}" alt="Dr. {{ $d['docName'] }}">@else<div class="pd-doc-img-placeholder">{{ strtoupper(substr($d['docName'],0,2)) }}</div>@endif<div><div class="pd-doc-name">Dr. {{ $d['docName'] }}</div><div class="pd-doc-spec">{{ $d['spec'] }}</div></div></div></td>
                                        <td><div class="pd-date-main">{{ $d['apptDate'] }}</div><div class="pd-date-time">{{ $d['apptTime'] }}</div></td>
                                        <td style="color:#64748b">{{ $d['bookDate'] }}</td>
                                        <td style="font-weight:600;color:#0f172a">{{ $d['fee'] }}</td>
                                        <td style="color:#64748b;font-size:13px">{{ $d['followUp'] }}</td>
                                        <td><span class="pd-pill {{ $d['status'] }}"><span class="pd-pill-dot"></span>{{ ucfirst($d['status']) }}</span></td>
                                        <td><a href="{{ route('patient.appointments.show', $appointment->id) }}" class="pd-view-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>View</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7"><div class="pd-empty"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><div class="pd-empty-title">No upcoming appointments</div><div class="pd-empty-sub">You have no upcoming sessions scheduled.</div></div></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- COMPLETED --}}
                <div class="pd-tab-content" id="tab-completed">
                    <div class="pd-table-wrap">
                        <table class="pd-table">
                            <thead><tr><th>Doctor</th><th>Appt Date</th><th>Booked On</th><th>Amount</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                @forelse($completedAppointments as $appointment)
                                    @php $d = apptRow($appointment); @endphp
                                    <tr>
                                        <td><div class="pd-doc-cell">@if($d['imgSrc'])<img class="pd-doc-img" src="{{ $d['imgSrc'] }}" alt="Dr. {{ $d['docName'] }}">@else<div class="pd-doc-img-placeholder">{{ strtoupper(substr($d['docName'],0,2)) }}</div>@endif<div><div class="pd-doc-name">Dr. {{ $d['docName'] }}</div><div class="pd-doc-spec">{{ $d['spec'] }}</div></div></div></td>
                                        <td><div class="pd-date-main">{{ $d['apptDate'] }}</div><div class="pd-date-time">{{ $d['apptTime'] }}</div></td>
                                        <td style="color:#64748b">{{ $d['bookDate'] }}</td>
                                        <td style="font-weight:600;color:#0f172a">{{ $d['fee'] }}</td>
                                        <td><span class="pd-pill completed"><span class="pd-pill-dot"></span>Completed</span></td>
                                        <td><a href="{{ route('patient.appointments.show', $appointment->id) }}" class="pd-view-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>View</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6"><div class="pd-empty"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><div class="pd-empty-title">No completed appointments</div><div class="pd-empty-sub">Completed sessions will appear here.</div></div></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- SHIFTED --}}
                <div class="pd-tab-content" id="tab-shifted">
                    <div class="pd-table-wrap">
                        <table class="pd-table">
                            <thead><tr><th>Doctor</th><th>Appt Date</th><th>Booked On</th><th>Amount</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                @forelse($shiftedAppointments as $appointment)
                                    @php $d = apptRow($appointment); @endphp
                                    <tr>
                                        <td><div class="pd-doc-cell">@if($d['imgSrc'])<img class="pd-doc-img" src="{{ $d['imgSrc'] }}" alt="Dr. {{ $d['docName'] }}">@else<div class="pd-doc-img-placeholder">{{ strtoupper(substr($d['docName'],0,2)) }}</div>@endif<div><div class="pd-doc-name">Dr. {{ $d['docName'] }}</div><div class="pd-doc-spec">{{ $d['spec'] }}</div></div></div></td>
                                        <td><div class="pd-date-main">{{ $d['apptDate'] }}</div><div class="pd-date-time">{{ $d['apptTime'] }}</div></td>
                                        <td style="color:#64748b">{{ $d['bookDate'] }}</td>
                                        <td style="font-weight:600;color:#0f172a">{{ $d['fee'] }}</td>
                                        <td><span class="pd-pill shifted"><span class="pd-pill-dot"></span>Shifted</span></td>
                                        <td><a href="{{ route('patient.appointments.show', $appointment->id) }}" class="pd-view-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>View</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6"><div class="pd-empty"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg><div class="pd-empty-title">No shifted appointments</div><div class="pd-empty-sub">Shifted sessions will appear here.</div></div></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- CANCELLED --}}
                <div class="pd-tab-content" id="tab-cancelled">
                    <div class="pd-table-wrap">
                        <table class="pd-table">
                            <thead><tr><th>Doctor</th><th>Appt Date</th><th>Booked On</th><th>Amount</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                @forelse($cancelledAppointments as $appointment)
                                    @php $d = apptRow($appointment); @endphp
                                    <tr>
                                        <td><div class="pd-doc-cell">@if($d['imgSrc'])<img class="pd-doc-img" src="{{ $d['imgSrc'] }}" alt="Dr. {{ $d['docName'] }}">@else<div class="pd-doc-img-placeholder">{{ strtoupper(substr($d['docName'],0,2)) }}</div>@endif<div><div class="pd-doc-name">Dr. {{ $d['docName'] }}</div><div class="pd-doc-spec">{{ $d['spec'] }}</div></div></div></td>
                                        <td><div class="pd-date-main">{{ $d['apptDate'] }}</div><div class="pd-date-time">{{ $d['apptTime'] }}</div></td>
                                        <td style="color:#64748b">{{ $d['bookDate'] }}</td>
                                        <td style="font-weight:600;color:#0f172a">{{ $d['fee'] }}</td>
                                        <td><span class="pd-pill cancelled"><span class="pd-pill-dot"></span>Cancelled</span></td>
                                        <td><a href="{{ route('patient.appointments.show', $appointment->id) }}" class="pd-view-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>View</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6"><div class="pd-empty"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><div class="pd-empty-title">No cancelled appointments</div><div class="pd-empty-sub">Great! You have no cancellations.</div></div></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- BILLING --}}
                <div class="pd-tab-content" id="tab-billing">
                    <div class="pd-billing-stats">
                        <div class="pd-billing-stat">
                            <div class="pd-billing-stat-icon green"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></div>
                            <div>
                                <div class="pd-billing-stat-val">₹{{ number_format($totalPaymentAmount, 2) }}</div>
                                <div class="pd-billing-stat-lbl">Total Amount Paid</div>
                            </div>
                        </div>
                        <div class="pd-billing-stat">
                            <div class="pd-billing-stat-icon blue"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14H5a1 1 0 01-1-1V4a1 1 0 011-1h11a1 1 0 011 1v1M9 14a1 1 0 001 1h9a1 1 0 001-1v-5a1 1 0 00-1-1h-9a1 1 0 00-1 1v5z"/></svg></div>
                            <div>
                                <div class="pd-billing-stat-val">{{ $payments->count() }}</div>
                                <div class="pd-billing-stat-lbl">Total Payments</div>
                            </div>
                        </div>
                    </div>
                    <div class="pd-table-wrap">
                        <table class="pd-table">
                            <thead><tr><th>Invoice</th><th>Doctor</th><th>Amount</th><th>Paid On</th><th>Status</th></tr></thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td><span class="pd-inv">#INV-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                                        <td>
                                            <div class="pd-doc-cell">
                                                @php $pImg = $payment->doctor->profile_img ? asset($payment->doctor->profile_img) : null; $pName = $payment->doctor->name ?? '—'; @endphp
                                                @if($pImg)<img class="pd-doc-img" src="{{ $pImg }}" alt="Dr. {{ $pName }}">@else<div class="pd-doc-img-placeholder">{{ strtoupper(substr($pName,0,2)) }}</div>@endif
                                                <div>
                                                    <div class="pd-doc-name">Dr. {{ $pName }}</div>
                                                    <div class="pd-doc-spec">{{ $payment->doctor->profile->specializationdata->name ?? 'Doctor' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="font-weight:700;color:#0f172a">₹{{ number_format($payment->amount, 2) }}</td>
                                        <td style="color:#64748b">{{ optional($payment->paid_at)->format('d M Y') ?? $payment->created_at->format('d M Y') }}</td>
                                        <td>
                                            @php $ps = $payment->status ?? 'pending'; @endphp
                                            <span class="pd-pill {{ $ps }}"><span class="pd-pill-dot"></span>{{ ucfirst($ps) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5"><div class="pd-empty"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14H5a1 1 0 01-1-1V4a1 1 0 011-1h11a1 1 0 011 1v1M9 14a1 1 0 001 1h9a1 1 0 001-1v-5a1 1 0 00-1-1h-9a1 1 0 00-1 1v5z"/></svg><div class="pd-empty-title">No billing history</div><div class="pd-empty-sub">Your payment records will appear here.</div></div></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div><!-- /pd-card -->
        </main>
    </div><!-- /pd-body -->
</div><!-- /pd-page -->

<script>
    function switchTab(tabId, btn) {
        document.querySelectorAll('.pd-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.pd-tab-content').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + tabId).classList.add('active');
    }
</script>

@endsection