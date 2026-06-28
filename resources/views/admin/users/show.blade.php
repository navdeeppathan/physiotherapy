@extends('admin.layouts.admin')

@section('content')

<style>
    *, *::before, *::after { box-sizing: border-box; }

    .doctor-wrap {
        font-family: 'Inter', 'Poppins', sans-serif;
        padding: 0 0 40px;
    }

    /* ── PAGE HEADER ─────────────────────────────────── */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #64748b;
        text-decoration: none;
        transition: background 0.15s, box-shadow 0.15s;
        flex-shrink: 0;
    }

    .back-btn:hover {
        background: #f8fafc;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        color: #0f172a;
    }

    .page-header-left h1 {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 3px;
        letter-spacing: -0.03em;
    }

    .page-header-left p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    .header-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 12.5px;
        font-weight: 600;
    }

    .header-badge.approved  { background: #ECFDF5; border: 1px solid #A7F3D0; color: #065f46; }
    .header-badge.pending   { background: #FFFBEB; border: 1px solid #FDE68A; color: #92400e; }
    .header-badge.rejected  { background: #FFF1F2; border: 1px solid #FECDD3; color: #be123c; }

    /* ── GRID ────────────────────────────────────────── */
    .detail-grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .detail-grid { grid-template-columns: 1fr; }
    }

    /* ── CARD BASE ───────────────────────────────────── */
    .card {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .card:last-child { margin-bottom: 0; }

    .card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    .card-head-title {
        font-size: 13.5px;
        font-weight: 600;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-head-title svg { color: #94a3b8; }

    .card-body { padding: 20px; }

    /* ── PROFILE CARD ────────────────────────────────── */
    .profile-card-body {
        padding: 24px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e2e8f0;
        margin-bottom: 14px;
    }

    .profile-avatar-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #ECFDF5;
        color: #059669;
        font-size: 24px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        border: 3px solid #e2e8f0;
        flex-shrink: 0;
    }

    .profile-name {
        font-size: 17px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.02em;
        margin-bottom: 4px;
    }

    .profile-spec {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 14px;
    }

    .profile-badges {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 20px;
    }

    .role-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .role-badge.doctor  { background: #ECFDF5; color: #065f46; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .status-badge.active   { background: #ECFDF5; color: #065f46; }
    .status-badge.active::before   { background: #10b981; }
    .status-badge.inactive { background: #f1f5f9; color: #64748b; }
    .status-badge.inactive::before { background: #94a3b8; }
    .status-badge.blocked  { background: #FFF1F2; color: #be123c; }
    .status-badge.blocked::before  { background: #f43f5e; }

    .profile-divider {
        width: 100%;
        border: none;
        border-top: 1px solid #f1f5f9;
        margin: 0 0 18px;
    }

    /* ── INFO ROWS ───────────────────────────────────── */
    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 14px;
        text-align: left;
        width: 100%;
    }

    .info-row:last-child { margin-bottom: 0; }

    .info-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        flex-shrink: 0;
    }

    .info-label {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 1px;
    }

    .info-value {
        font-size: 13.5px;
        color: #0f172a;
        font-weight: 500;
    }

    /* ── KEY-VALUE GRID ──────────────────────────────── */
    .kv-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    @media (max-width: 600px) {
        .kv-grid { grid-template-columns: 1fr; }
    }

    .kv-item {}

    .kv-label {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
    }

    .kv-value {
        font-size: 13.5px;
        color: #0f172a;
        font-weight: 500;
    }

    .kv-value.muted { color: #cbd5e1; font-weight: 400; }

    /* ── AVAILABILITY PILLS ──────────────────────────── */
    .avail-days {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 4px;
    }

    .day-pill {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        background: #EFF6FF;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        text-transform: capitalize;
    }

    /* ── VISIT TYPE CHIPS ────────────────────────────── */
    .visit-chips {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .visit-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 500;
    }

    .visit-chip.home   { background: #ECFDF5; color: #059669; border: 1px solid #A7F3D0; }
    .visit-chip.clinic { background: #EFF6FF; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .visit-chip.none   { background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0; }

    /* ── RATING ──────────────────────────────────────── */
    .rating-row {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .star-filled { color: #f59e0b; }
    .star-empty  { color: #e2e8f0; }

    /* ── DOCUMENT ROWS ───────────────────────────────── */
    .doc-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f8fafc;
    }

    .doc-row:last-child { border-bottom: none; }

    .doc-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .doc-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .doc-icon.pdf    { background: #FFF1F2; }
    .doc-icon.image  { background: #ECFDF5; }
    .doc-icon.file   { background: #f1f5f9; }

    .doc-name {
        font-size: 13px;
        font-weight: 500;
        color: #0f172a;
        text-transform: capitalize;
    }

    .doc-type {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 1px;
    }

    .doc-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .doc-status.pending  { background: #FFFBEB; color: #92400e; }
    .doc-status.verified { background: #ECFDF5; color: #065f46; }
    .doc-status.rejected { background: #FFF1F2; color: #be123c; }

    .doc-view-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        background: #f8fafc;
        color: #334155;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        transition: background 0.15s;
        margin-left: 10px;
    }

    .doc-view-btn:hover { background: #e2e8f0; color: #0f172a; }

    /* ── BIO ─────────────────────────────────────────── */
    .bio-text {
        font-size: 13.5px;
        color: #475569;
        line-height: 1.65;
    }

    /* ── FEE HIGHLIGHT ───────────────────────────────── */
    .fee-highlight {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 18px;
    }

    .fee-highlight-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }

    .fee-highlight-value {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.03em;
    }

    /* ── NO-DATA ─────────────────────────────────────── */
    .no-data {
        text-align: center;
        padding: 24px 20px;
        color: #94a3b8;
        font-size: 13px;
    }
</style>

<div class="doctor-wrap">

    <!-- ── PAGE HEADER ── -->
    <div class="page-header">
        <div class="page-header-left">
            <a href="{{ route('admin.users.doctorsindex') }}" class="back-btn" title="Back to Users">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </a>
            <div>
                <h1>Doctor Profile</h1>
                <p>Full details for {{ $doctor->name }}</p>
            </div>
        </div>

        @php
            $approvalStatus = $doctor->profile->approval_status ?? 'pending';
        @endphp
        <span class="header-badge {{ $approvalStatus }}">
            @if($approvalStatus === 'approved')
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Approved
            @elseif($approvalStatus === 'rejected')
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Rejected
            @else
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Pending Approval
            @endif
        </span>
    </div>

    <!-- ── GRID ── -->
    <div class="detail-grid">

        <!-- LEFT COLUMN -->
        <div>

            <!-- Profile Card -->
            <div class="card">
                <div class="profile-card-body">

                    @if($doctor->profile_img)
                        <img src="{{ asset($doctor->profile_img) }}" alt="{{ $doctor->name }}" class="profile-avatar">
                    @else
                        <div class="profile-avatar-placeholder">
                            {{ strtoupper(substr($doctor->name, 0, 2)) }}
                        </div>
                    @endif

                    <div class="profile-name">{{ $doctor->name }}</div>
                    <div class="profile-spec">
                        {{ $doctor->profile->specialization ?? 'General Practitioner' }}
                       
                    </div>

                    <div class="profile-badges">
                        <span class="role-badge doctor">Doctor</span>
                        <span class="status-badge {{ $doctor->status ?? 'inactive' }}">
                            {{ ucfirst($doctor->status ?? 'Inactive') }}
                        </span>
                    </div>

                    <hr class="profile-divider">

                    <div class="info-row">
                        <div class="info-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </div>
                        <div>
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $doctor->email }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.36 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.27 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="info-label">Phone</div>
                            <div class="info-value">{{ $doctor->phone ?? '—' }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                        <div>
                            <div class="info-label">Date of Birth</div>
                            <div class="info-value">
                                {{ $doctor->dob ? \Carbon\Carbon::parse($doctor->dob)->format('d M, Y') : '—' }}
                            </div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <div>
                            <div class="info-label">Gender</div>
                            <div class="info-value">{{ ucfirst($doctor->gender ?? '—') }}</div>
                        </div>
                    </div>

                    @if($doctor->address || ($doctor->profile && $doctor->profile->clinic_address))
                    <div class="info-row">
                        <div class="info-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <div>
                            <div class="info-label">Address</div>
                            <div class="info-value">{{ $doctor->profile->clinic_address ?? $doctor->address ?? '—' }}</div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            <!-- Consultation Fee -->
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                        Consultation Fee
                    </div>
                </div>
                <div class="card-body">
                    @if($doctor->profile && $doctor->profile->consultation_fee)
                        <div class="fee-highlight">
                            <span class="fee-highlight-label">Doctor Fee</span>
                            <span class="fee-highlight-value">₹{{ number_format($doctor->profile->consultation_fee) }}</span>
                        </div>
                    @else
                        <div class="no-data">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 8px;">
                                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                            </svg>
                            No fee set yet
                        </div>
                    @endif
                </div>
            </div>

            <!-- Rating -->
            @if($doctor->profile && $doctor->profile->rating)
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                        Rating &amp; Reviews
                    </div>
                </div>
                <div class="card-body">
                    <div class="rating-row" style="margin-bottom:6px;">
                        @for($i = 1; $i <= 5; $i++)
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="{{ $i <= round($doctor->profile->rating) ? '#f59e0b' : 'none' }}" stroke="{{ $i <= round($doctor->profile->rating) ? '#f59e0b' : '#e2e8f0' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        @endfor
                        <span style="font-size:14px;font-weight:700;color:#0f172a;margin-left:4px;">{{ number_format($doctor->profile->rating, 1) }}</span>
                    </div>
                    <div style="font-size:12px;color:#94a3b8;">
                        Based on {{ $doctor->profile->total_reviews ?? 0 }} reviews
                    </div>
                </div>
            </div>
            @endif

        </div>

        <!-- RIGHT COLUMN -->
        <div>

            <!-- Professional Info -->
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                        </svg>
                        Professional Information
                    </div>
                </div>
                <div class="card-body">
                    <div class="kv-grid">

                        <div class="kv-item">
                            <div class="kv-label">Specialization</div>
                            <div class="kv-value">{{ $doctor->profile->specialization ?? '—' }}</div>
                        </div>

                        <div class="kv-item">
                            <div class="kv-label">Qualification</div>
                            <div class="kv-value">{{ $doctor->profile->qualification ?? '—' }}</div>
                        </div>

                        <div class="kv-item">
                            <div class="kv-label">Experience</div>
                            <div class="kv-value">
                                {{ $doctor->profile->experience_years ? $doctor->profile->experience_years . ' years' : '—' }}
                            </div>
                        </div>

                        <div class="kv-item">
                            <div class="kv-label">Experience Level</div>
                            <div class="kv-value">{{ ucfirst($doctor->profile->experience_level ?? '—') }}</div>
                        </div>

                        <div class="kv-item">
                            <div class="kv-label">Clinic Name</div>
                            <div class="kv-value">{{ $doctor->profile->clinic_name ?? '—' }}</div>
                        </div>

                        <div class="kv-item">
                            <div class="kv-label">City / State</div>
                            <div class="kv-value">
                                @php
                                    $city  = $doctor->profile->city  ?? $doctor->city  ?? null;
                                    $state = $doctor->profile->state ?? $doctor->state ?? null;
                                @endphp
                                {{ $city && $state ? $city.', '.$state : ($city ?? $state ?? '—') }}
                            </div>
                        </div>

                        <div class="kv-item">
                            <div class="kv-label">Pincode</div>
                            <div class="kv-value">{{ $doctor->profile->pincode ?? $doctor->pincode ?? '—' }}</div>
                        </div>

                        <div class="kv-item">
                            <div class="kv-label">Career Path</div>
                            <div class="kv-value">{{ $doctor->profile->career_path ?? '—' }}</div>
                        </div>

                    </div>

                    @if($doctor->profile->highlights)
                        <div style="margin-top:18px;">
                            <div class="kv-label" style="margin-bottom:6px;">Highlights</div>
                            <div class="kv-value">{{ $doctor->profile->highlights }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Bio -->
            @if($doctor->profile && $doctor->profile->bio)
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/>
                        </svg>
                        Bio
                    </div>
                </div>
                <div class="card-body">
                    <p class="bio-text">{{ $doctor->profile->bio }}</p>
                </div>
            </div>
            @endif

            <!-- Availability -->
            {{-- <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Availability
                    </div>
                </div>
                <div class="card-body">

                    <div class="kv-grid" style="margin-bottom:18px;">
                        <div class="kv-item">
                            <div class="kv-label">Start Time</div>
                            <div class="kv-value">
                                {{ $doctor->default_start_time ? \Carbon\Carbon::createFromFormat('H:i:s', $doctor->default_start_time)->format('h:i A') : '—' }}
                            </div>
                        </div>
                        <div class="kv-item">
                            <div class="kv-label">End Time</div>
                            <div class="kv-value">
                                {{ $doctor->default_end_time ? \Carbon\Carbon::createFromFormat('H:i:s', $doctor->default_end_time)->format('h:i A') : '—' }}
                            </div>
                        </div>
                    </div>

                    @php
                        $days = $doctor->default_available_days
                            ? json_decode($doctor->default_available_days, true)
                            : [];
                    @endphp

                    @if(count($days))
                        <div class="kv-label" style="margin-bottom:8px;">Available Days</div>
                        <div class="avail-days">
                            @foreach($days as $day)
                                <span class="day-pill">{{ $day }}</span>
                            @endforeach
                        </div>
                    @else
                        <div class="kv-label" style="margin-bottom:6px;">Available Days</div>
                        <div style="font-size:13px;color:#cbd5e1;">Not set</div>
                    @endif

                    <div style="margin-top:18px;">
                        <div class="kv-label" style="margin-bottom:8px;">Visit Types</div>
                        <div class="visit-chips">
                            @if($doctor->profile && $doctor->profile->home_visit_available)
                                <span class="visit-chip home">
                                    🏠 Home Visit
                                </span>
                            @endif
                            @if($doctor->profile && $doctor->profile->clinic_visit_available)
                                <span class="visit-chip clinic">
                                    🏥 Clinic Visit
                                </span>
                            @endif
                            @if(!($doctor->profile && ($doctor->profile->home_visit_available || $doctor->profile->clinic_visit_available)))
                                <span class="visit-chip none">Not specified</span>
                            @endif
                        </div>
                    </div>

                </div>
            </div> --}}

            <!-- Documents -->
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                        </svg>
                        Uploaded Documents
                    </div>
                    <span style="font-size:12px;color:#94a3b8;">{{ $doctor->documents->count() }} file(s)</span>
                </div>
                <div class="card-body" style="padding: 6px 20px 14px;">

                    @forelse($doctor->documents as $doc)
                        @php
                            $ext = strtolower(pathinfo($doc->document_path, PATHINFO_EXTENSION));
                            $isPdf = $ext === 'pdf';
                            $docTypeLabel = str_replace('_', ' ', $doc->document_type);
                        @endphp
                        <div class="doc-row">
                            <div class="doc-info">
                                <div class="doc-icon {{ $isPdf ? 'pdf' : 'image' }}">
                                    {{ $isPdf ? '📄' : '🖼️' }}
                                </div>
                                <div>
                                    <div class="doc-name">{{ $docTypeLabel }}</div>
                                    <div class="doc-type">{{ strtoupper($ext) }} file</div>
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                                <span class="doc-status {{ $doc->verification_status }}">
                                    {{ ucfirst($doc->verification_status) }}
                                </span>
                                <a href="{{ asset($doc->document_path) }}" target="_blank" class="doc-view-btn">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    View
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="no-data">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 8px;">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                            </svg>
                            No documents uploaded
                        </div>
                    @endforelse

                </div>
            </div>

        </div><!-- /right col -->

    </div><!-- /grid -->

</div>

@endsection