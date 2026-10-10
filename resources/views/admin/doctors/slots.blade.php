@extends('admin.layouts.admin')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root {
  --bg:         #EEF4FB;
  --white:      #FFFFFF;
  --blue:       #2563EB;
  --blue-l:     #EFF6FF;
  --border:     #E2E8F0;
  --text:       #0F172A;
  --text2:      #334155;
  --text3:      #64748B;
  --green:      #059669;
  --green-bg:   #ECFDF5;
  --rose:       #DC2626;
  --rose-bg:    #FEF2F2;
  --amber:      #D97706;
  --amber-bg:   #FFFBEB;
  --purple:     #7C3AED;
  --purple-bg:  #F5F3FF;
  --ease:       cubic-bezier(0.16,1,0.3,1);
}

.slots-wrap {
  padding: 24px 28px 48px;
  font-family: 'Inter', sans-serif;
  background: var(--bg);
  min-height: 100vh;
}

/* ── HEADER ── */
.slots-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 16px;
  margin-bottom: 24px;
}
.header-left {
  display: flex;
  align-items: center;
  gap: 14px;
}
.back-btn {
  width: 40px; height: 40px;
  border-radius: 10px;
  background: #fff;
  border: 1px solid var(--border);
  display: flex; align-items: center; justify-content: center;
  color: var(--text2);
  text-decoration: none;
  font-size: 15px;
  transition: all .15s ease;
}
.back-btn:hover {
  background: var(--blue-l);
  color: var(--blue);
  border-color: var(--blue);
}
.header-title-box h1 {
  font-size: 22px;
  font-weight: 800;
  color: var(--text);
  margin: 0;
  letter-spacing: -.3px;
}
.header-title-box p {
  font-size: 13px;
  color: var(--text3);
  margin: 3px 0 0;
}

/* Quick Doctor Selector */
.doctor-switcher-box {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #fff;
  border: 1px solid var(--border);
  padding: 8px 14px;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.doctor-switcher-label {
  font-size: 12px;
  font-weight: 700;
  color: var(--text3);
  text-transform: uppercase;
  letter-spacing: .5px;
  white-space: nowrap;
}
.doctor-select-dropdown {
  border: none;
  background: transparent;
  font-family: inherit;
  font-size: 13.5px;
  font-weight: 700;
  color: var(--blue);
  outline: none;
  cursor: pointer;
  max-width: 250px;
}

/* ── DOCTOR PROFILE BANNER CARD ── */
.doctor-info-card {
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 20px 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 20px;
  margin-bottom: 24px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}
.doctor-bio-row {
  display: flex;
  align-items: center;
  gap: 16px;
}
.doctor-avatar-circle {
  width: 58px; height: 58px;
  border-radius: 14px;
  background: var(--blue-l);
  color: var(--blue);
  display: flex; align-items: center; justify-content: center;
  font-weight: 800;
  font-size: 20px;
  overflow: hidden;
  border: 2px solid #DBEAFE;
}
.doctor-avatar-circle img {
  width: 100%; height: 100%; object-fit: cover;
}
.doctor-name-title {
  font-size: 17px;
  font-weight: 800;
  color: var(--text);
  margin: 0 0 4px;
}
.doctor-meta-line {
  display: flex;
  align-items: center;
  gap: 14px;
  font-size: 12.5px;
  color: var(--text3);
  flex-wrap: wrap;
}
.doctor-meta-line span {
  display: inline-flex;
  align-items: center;
  gap: 5px;
}

/* Stats Badges */
.slot-stats-row {
  display: flex;
  align-items: center;
  gap: 14px;
  flex-wrap: wrap;
}
.stat-pill {
  padding: 8px 16px;
  border-radius: 10px;
  font-size: 12.5px;
  display: flex;
  flex-direction: column;
  align-items: center;
  border: 1px solid var(--border);
  background: #F8FAFC;
}
.stat-pill .num {
  font-size: 17px;
  font-weight: 800;
  line-height: 1.1;
}
.stat-pill .lbl {
  font-size: 11px;
  font-weight: 600;
  color: var(--text3);
  text-transform: uppercase;
  letter-spacing: .4px;
  margin-top: 2px;
}

/* ── CREATION TOOLS (GRID 2 COLUMNS) ── */
.tools-grid {
  display: grid;
  grid-template-columns: 1.25fr 1fr;
  gap: 24px;
  margin-bottom: 28px;
}
@media(max-width: 950px) {
  .tools-grid { grid-template-columns: 1fr; }
}

.panel-card {
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}
.panel-header-bar {
  padding: 16px 22px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  gap: 10px;
  background: #FAFBFD;
}
.panel-icon-wrap {
  width: 34px; height: 34px;
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-size: 15px;
}
.panel-header-bar h3 {
  font-size: 14.5px;
  font-weight: 700;
  color: var(--text);
  margin: 0;
}
.panel-content {
  padding: 22px;
}

/* Form Styles */
.f-grid {
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  gap: 14px;
}
.col-12 { grid-column: span 12; }
.col-6  { grid-column: span 6; }
.col-4  { grid-column: span 4; }
.col-3  { grid-column: span 3; }

@media(max-width: 600px) {
  .col-6, .col-4, .col-3 { grid-column: span 12; }
}

.f-label {
  display: block;
  font-size: 11px;
  font-weight: 700;
  color: var(--text3);
  text-transform: uppercase;
  letter-spacing: .5px;
  margin-bottom: 6px;
}
.f-input, .f-select {
  width: 100%;
  background: #F8FAFC;
  border: 1.5px solid var(--border);
  border-radius: 9px;
  padding: 9px 12px;
  font-family: inherit;
  font-size: 13px;
  font-weight: 600;
  color: var(--text);
  outline: none;
  transition: all .15s ease;
}
.f-input:focus, .f-select:focus {
  border-color: var(--blue);
  background: #fff;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
}
.f-hint {
  font-size: 11px;
  color: var(--text3);
  margin-top: 4px;
}

.btn-submit-action {
  background: var(--blue);
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 9px;
  font-size: 13.5px;
  font-weight: 700;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all .15s ease;
  width: 100%;
}
.btn-submit-action:hover {
  background: #1d4ed8;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}

/* ── AGENDA / DATES LIST ── */
.agenda-section-title {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
  margin-bottom: 18px;
}
.agenda-title-left {
  font-size: 16px;
  font-weight: 800;
  color: var(--text);
  display: flex;
  align-items: center;
  gap: 10px;
}
.date-filter-form {
  display: flex;
  align-items: center;
  gap: 10px;
}

/* Date Group Card */
.date-slot-card {
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 16px;
  margin-bottom: 20px;
  overflow: hidden;
  box-shadow: 0 1px 4px rgba(0,0,0,0.03);
}
.date-slot-header {
  padding: 14px 20px;
  background: #FAFBFD;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 10px;
}
.date-title-wrap {
  display: flex;
  align-items: center;
  gap: 12px;
}
.date-badge-calendar {
  background: #EFF6FF;
  border: 1px solid #BFDBFE;
  color: var(--blue);
  padding: 6px 12px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  gap: 7px;
}
.date-slots-count {
  font-size: 12.5px;
  color: var(--text3);
  font-weight: 600;
}
.btn-clear-date {
  background: transparent;
  border: 1px solid #FECDD3;
  color: #BE123C;
  border-radius: 7px;
  padding: 5px 12px;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  transition: all .15s ease;
}
.btn-clear-date:hover {
  background: #FFF1F2;
}

/* Slots Grid inside date */
.slots-pill-grid {
  padding: 20px;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
  gap: 12px;
}

.slot-item-pill {
  border-radius: 12px;
  padding: 12px 14px;
  border: 1.5px solid var(--border);
  background: #fff;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
  transition: all .15s ease;
}
.slot-item-pill.available {
  border-color: #A7F3D0;
  background: #F0FDF4;
}
.slot-item-pill.booked {
  border-color: #FECDD3;
  background: #FFF1F2;
}
.slot-time-text {
  font-size: 13px;
  font-weight: 700;
  color: var(--text);
  line-height: 1.2;
}
.slot-status-tag {
  font-size: 10.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .4px;
  margin-top: 3px;
}
.slot-item-pill.available .slot-status-tag { color: var(--green); }
.slot-item-pill.booked .slot-status-tag { color: var(--rose); }

.slot-actions-group {
  display: flex;
  align-items: center;
  gap: 6px;
}
.slot-action-btn {
  width: 28px; height: 28px;
  border-radius: 7px;
  border: 1px solid var(--border);
  background: #fff;
  color: var(--text3);
  display: flex; align-items: center; justify-content: center;
  font-size: 12px;
  cursor: pointer;
  transition: all .15s ease;
  text-decoration: none;
}
.slot-action-btn:hover {
  background: #F1F5F9;
  color: var(--text);
}
.slot-action-btn.btn-del:hover {
  background: #FEE2E2;
  border-color: #FCA5A5;
  color: #DC2626;
}
.slot-action-btn.btn-toggle:hover {
  background: #FEF3C7;
  border-color: #FCD34D;
  color: #D97706;
}

.empty-state-card {
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 48px 24px;
  text-align: center;
  color: var(--text3);
}
.empty-icon {
  font-size: 40px;
  color: #CBD5E1;
  margin-bottom: 12px;
}
</style>

<div class="slots-wrap">

    {{-- Top Header --}}
    <div class="slots-header">
        <div class="header-left">
            <a href="{{ route('admin.users.doctorsindex') }}" class="back-btn" title="Back to Doctors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="header-title-box">
                <h1>Doctor Slot Management</h1>
                <p>Create, auto-generate, block, and manage time slots for Dr. {{ $doctor->name }}.</p>
            </div>
        </div>

        {{-- Quick Doctor Switcher --}}
        <div class="doctor-switcher-box">
            <span class="doctor-switcher-label"><i class="fa-solid fa-user-doctor"></i> Doctor:</span>
            <select class="doctor-select-dropdown" onchange="window.location.href = '{{ url('admin/doctors') }}/' + this.value + '/slots'">
                @foreach($allDoctors as $doc)
                    <option value="{{ $doc->id }}" {{ $doc->id === $doctor->id ? 'selected' : '' }}>
                        {{ $doc->name }} ({{ $doc->status == 'active' ? 'Active' : 'Inactive' }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div style="background:var(--green-bg); border:1px solid rgba(5,150,105,0.3); border-radius:12px; padding:13px 20px; color:var(--green); font-weight:600; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:var(--rose-bg); border:1px solid rgba(220,38,38,0.3); border-radius:12px; padding:13px 20px; color:var(--rose); font-weight:600; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    @if(session('warning'))
        <div style="background:var(--amber-bg); border:1px solid rgba(217,119,6,0.3); border-radius:12px; padding:13px 20px; color:var(--amber); font-weight:600; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-triangle-exclamation"></i>
            {{ session('warning') }}
        </div>
    @endif

    {{-- Doctor Profile Info Card --}}
    <div class="doctor-info-card">
        <div class="doctor-bio-row">
            <div class="doctor-avatar-circle">
                @if($doctor->profile_img)
                    <img src="{{ str_starts_with($doctor->profile_img, 'http') ? $doctor->profile_img : asset($doctor->profile_img) }}" alt="{{ $doctor->name }}">
                @else
                    {{ strtoupper(substr($doctor->name, 0, 2)) }}
                @endif
            </div>
            <div>
                <h2 class="doctor-name-title">Dr. {{ $doctor->name }}</h2>
                <div class="doctor-meta-line">
                    <span><i class="fa-solid fa-stethoscope"></i> {{ $doctor->profile && $doctor->profile->specializationdata ? $doctor->profile->specializationdata->name : 'Physiotherapy Specialist' }}</span>
                    <span><i class="fa-regular fa-envelope"></i> {{ $doctor->email }}</span>
                    <span><i class="fa-solid fa-phone"></i> {{ $doctor->phone ?? 'N/A' }}</span>
                    @if($doctor->fee)
                        <span style="color:#059669; font-weight:700;"><i class="fa-solid fa-indian-rupee-sign"></i> ₹{{ number_format($doctor->fee->getPerAppointmentTotal(), 0) }} / session</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="slot-stats-row">
            <div class="stat-pill">
                <span class="num" style="color:var(--text);">{{ $totalSlotsCount }}</span>
                <span class="lbl">Total Slots</span>
            </div>
            <div class="stat-pill" style="border-color:#A7F3D0; background:#F0FDF4;">
                <span class="num" style="color:var(--green);">{{ $availableSlotsCount }}</span>
                <span class="lbl" style="color:var(--green);">Available</span>
            </div>
            <div class="stat-pill" style="border-color:#FECDD3; background:#FFF1F2;">
                <span class="num" style="color:var(--rose);">{{ $bookedSlotsCount }}</span>
                <span class="lbl" style="color:var(--rose);">Booked</span>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════
         SLOT CREATION TOOLS (BULK & SINGLE)
    ══════════════════════════════════════════════════ --}}
    <div class="tools-grid">

        {{-- 1. BULK SLOT GENERATOR --}}
        <div class="panel-card">
            <div class="panel-header-bar">
                <div class="panel-icon-wrap" style="background:#F5F3FF; color:var(--purple);">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <h3>Bulk Slot Generator (Quick Multi-Day)</h3>
            </div>
            <div class="panel-content">
                <form action="{{ route('admin.doctors.slots.bulk-generate', $doctor->id) }}" method="POST">
                    @csrf
                    <div class="f-grid">
                        
                        {{-- Date range --}}
                        <div class="col-6">
                            <label class="f-label">Start Date *</label>
                            <input type="date" name="start_date" class="f-input" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="f-label">End Date (Optional)</label>
                            <input type="date" name="end_date" class="f-input" value="{{ date('Y-m-d', strtotime('+6 days')) }}" min="{{ date('Y-m-d') }}">
                            <div class="f-hint">Leave blank for single day.</div>
                        </div>

                        {{-- Shift timing --}}
                        <div class="col-4">
                            <label class="f-label">Shift Start *</label>
                            <input type="time" name="shift_start" class="f-input" value="09:00" required>
                        </div>
                        <div class="col-4">
                            <label class="f-label">Shift End *</label>
                            <input type="time" name="shift_end" class="f-input" value="18:00" required>
                        </div>
                        <div class="col-4">
                            <label class="f-label">Slot Duration *</label>
                            <select name="duration" class="f-select" required>
                                <option value="30">30 Minutes</option>
                                <option value="45">45 Minutes</option>
                                <option value="60" selected>60 Minutes (1 Hour)</option>
                                <option value="90">90 Minutes</option>
                                <option value="120">2 Hours</option>
                            </select>
                        </div>

                        {{-- Optional lunch break --}}
                        <div class="col-6">
                            <label class="f-label">Lunch Break Start (Optional)</label>
                            <input type="time" name="break_start" class="f-input" value="13:00">
                        </div>
                        <div class="col-6">
                            <label class="f-label">Lunch Break End (Optional)</label>
                            <input type="time" name="break_end" class="f-input" value="14:00">
                        </div>

                        <div class="col-12" style="display:flex; align-items:center; gap:8px; margin-top:2px;">
                            <input type="checkbox" name="skip_weekends" id="skipWeekends" value="1" style="width:16px; height:16px; cursor:pointer;" checked>
                            <label for="skipWeekends" style="font-size:12.5px; font-weight:600; color:var(--text2); cursor:pointer;">
                                Skip Weekends (Don't create slots on Saturday &amp; Sunday)
                            </label>
                        </div>

                        <div class="col-12" style="margin-top:6px;">
                            <button type="submit" class="btn-submit-action" style="background:linear-gradient(135deg, #7C3AED, #6D28D9);">
                                <i class="fa-solid fa-wand-magic-sparkles"></i> Generate Slots in Bulk
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- 2. QUICK SINGLE SLOT CREATOR --}}
        <div class="panel-card">
            <div class="panel-header-bar">
                <div class="panel-icon-wrap" style="background:#EFF6FF; color:var(--blue);">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <h3>Add Single Custom Slot</h3>
            </div>
            <div class="panel-content">
                <form action="{{ route('admin.doctors.slots.store', $doctor->id) }}" method="POST">
                    @csrf
                    <div class="f-grid">

                        <div class="col-12">
                            <label class="f-label">Date *</label>
                            <input type="date" name="date" class="f-input" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-6">
                            <label class="f-label">Start Time *</label>
                            <input type="time" name="start_time" class="f-input" value="10:00" required>
                        </div>

                        <div class="col-6">
                            <label class="f-label">End Time *</label>
                            <input type="time" name="end_time" class="f-input" value="11:00" required>
                        </div>

                        <div class="col-12" style="margin-top:14px;">
                            <button type="submit" class="btn-submit-action">
                                <i class="fa-solid fa-circle-plus"></i> Add Single Time Slot
                            </button>
                        </div>

                    </div>
                </form>

                <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px; padding:12px 14px; margin-top:20px; font-size:12px; color:var(--text3); line-height:1.5;">
                    <strong style="color:var(--text2); display:block; margin-bottom:4px;"><i class="fa-solid fa-circle-info" style="color:var(--blue);"></i> Help Note for Admin:</strong>
                    When you create slots here, they instantly become bookable by patients on the website and app. Patients can book home visits or clinic visits based on doctor profile settings.
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════
         AGENDA & EXISTING SLOTS BY DATE
    ══════════════════════════════════════════════════ --}}
    <div class="agenda-section-title">
        <div class="agenda-title-left">
            <i class="fa-regular fa-calendar-check" style="color:var(--blue);"></i>
            <span>Configured Availability &amp; Slots</span>
        </div>

        {{-- Filter Date Form --}}
        <form action="{{ route('admin.doctors.slots', $doctor->id) }}" method="GET" class="date-filter-form">
            <input type="date" name="date" class="f-input" style="width:160px; padding:6px 10px;" value="{{ $selectedDate ?? '' }}">
            <button type="submit" class="btn-submit-action" style="padding:7px 14px; font-size:12.5px; width:auto;">
                Filter Date
            </button>
            @if($selectedDate)
                <a href="{{ route('admin.doctors.slots', $doctor->id) }}" style="font-size:12.5px; color:var(--text3); text-decoration:none; padding:6px 8px;">
                    View All
                </a>
            @endif
        </form>
    </div>

    @forelse($availabilityDates as $avail)
        <div class="date-slot-card">
            <div class="date-slot-header">
                <div class="date-title-wrap">
                    <span class="date-badge-calendar">
                        <i class="fa-regular fa-calendar-days"></i>
                        {{ \Carbon\Carbon::parse($avail->available_date)->format('D, d M Y') }}
                    </span>
                    <span class="date-slots-count">
                        <strong>{{ $avail->timeSlots->count() }}</strong> slots
                        ({{ $avail->timeSlots->where('is_booked', false)->count() }} available)
                    </span>
                </div>

                {{-- Clear Unbooked Slots for this day --}}
                @if($avail->timeSlots->where('is_booked', false)->count() > 0)
                    <form action="{{ route('admin.doctors.slots.clear-date', $doctor->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all unbooked slots on {{ \Carbon\Carbon::parse($avail->available_date)->format('d M Y') }}?');">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="date" value="{{ \Carbon\Carbon::parse($avail->available_date)->format('Y-m-d') }}">
                        <button type="submit" class="btn-clear-date">
                            <i class="fa-solid fa-eraser"></i> Clear Unbooked Slots
                        </button>
                    </form>
                @endif
            </div>

            @if($avail->timeSlots->count() > 0)
                <div class="slots-pill-grid">
                    @foreach($avail->timeSlots as $slot)
                        <div class="slot-item-pill {{ $slot->is_booked ? 'booked' : 'available' }}">
                            <div>
                                <div class="slot-time-text">
                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                                </div>
                                <div class="slot-status-tag">
                                    @if($slot->is_booked)
                                        <i class="fa-solid fa-lock" style="font-size:9px;"></i> Booked / Blocked
                                    @else
                                        <i class="fa-solid fa-circle-check" style="font-size:9px;"></i> Available
                                    @endif
                                </div>
                            </div>

                            <div class="slot-actions-group">
                                {{-- Toggle Booked/Available --}}
                                <form action="{{ route('admin.doctors.slots.toggle-booked', $slot->id) }}" method="POST" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="slot-action-btn btn-toggle" title="{{ $slot->is_booked ? 'Make Available' : 'Block Slot' }}">
                                        @if($slot->is_booked)
                                            <i class="fa-solid fa-unlock"></i>
                                        @else
                                            <i class="fa-solid fa-lock"></i>
                                        @endif
                                    </button>
                                </form>

                                {{-- Delete Slot --}}
                                <form action="{{ route('admin.doctors.slots.destroy', $slot->id) }}" method="POST" onsubmit="return confirm('Delete this time slot?');" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="slot-action-btn btn-del" title="Delete Slot">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="padding:20px; text-align:center; color:var(--text3); font-size:13px;">
                    No slots generated for this date yet. Use the tools above to add slots.
                </div>
            @endif
        </div>
    @empty
        <div class="empty-state-card">
            <div class="empty-icon"><i class="fa-regular fa-calendar-xmark"></i></div>
            <h3 style="font-size:16px; font-weight:700; color:var(--text); margin:0 0 6px;">No Upcoming Slots Found for Dr. {{ $doctor->name }}</h3>
            <p style="font-size:13px; max-width:460px; margin:0 auto 18px;">
                This doctor doesn't have any time slots configured yet. Use the <strong>Bulk Slot Generator</strong> above to create their weekly schedule in 1 click!
            </p>
        </div>
    @endforelse

</div>

@endsection
