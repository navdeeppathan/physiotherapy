@extends('admin.layouts.admin')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

<style>
:root {
  --bg:           #F1F5F9;
  --white:        #FFFFFF;
  --blue:         #2563EB;
  --blue-l:       #EFF6FF;
  --blue-d:       #1D4ED8;
  --border:       #E2E8F0;
  --border-card:  #E2E8F0;
  --text:         #0F172A;
  --text2:        #334155;
  --text3:        #64748B;
  --green:        #059669;
  --green-bg:     #ECFDF5;
  --rose:         #DC2626;
  --rose-bg:      #FEF2F2;
  --amber:        #D97706;
  --amber-bg:     #FFFBEB;
  --purple:       #7C3AED;
  --purple-bg:    #F5F3FF;
  --cyan:         #0891B2;
  --cyan-bg:      #ECFEFF;
}

.report-wrap {
  padding: 24px 28px 60px;
  font-family: 'Inter', sans-serif;
  background: var(--bg);
  min-height: 100vh;
}

/* ── HEADER ── */
.report-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 22px;
  flex-wrap: wrap;
  gap: 16px;
}
.report-title-area h1 {
  font-size: 24px;
  font-weight: 800;
  color: var(--text);
  font-family: 'Nunito', sans-serif;
  margin: 0 0 4px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.report-title-area p {
  font-size: 13.5px;
  color: var(--text3);
  margin: 0;
}
.btn-export {
  background: #059669;
  color: #fff;
  border: none;
  padding: 10px 18px;
  border-radius: 10px;
  font-size: 13px;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  text-decoration: none;
  transition: all .2s;
  box-shadow: 0 2px 8px rgba(5,150,105,0.25);
}
.btn-export:hover {
  background: #047857;
  color: #fff;
  transform: translateY(-1px);
}

/* ── DATE FILTER BAR (PERSISTENT) ── */
.date-filter-box {
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 16px 20px;
  margin-bottom: 22px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.03);
  display: flex;
  flex-direction: column;
  gap: 14px;
}
.preset-pills-row {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}
.preset-pill {
  padding: 6px 14px;
  border-radius: 999px;
  font-size: 12.5px;
  font-weight: 600;
  color: var(--text2);
  background: #F8FAFC;
  border: 1px solid var(--border);
  text-decoration: none;
  transition: all .15s;
  white-space: nowrap;
}
.preset-pill:hover {
  background: var(--blue-l);
  border-color: #BFDBFE;
  color: var(--blue);
}
.preset-pill.active {
  background: var(--blue);
  color: #fff;
  border-color: var(--blue);
  box-shadow: 0 2px 8px rgba(37,99,235,0.28);
}
.custom-range-form {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
  padding-top: 10px;
  border-top: 1px solid #F1F5F9;
}
.custom-input-wrap {
  display: flex;
  align-items: center;
  gap: 8px;
}
.custom-input-wrap label {
  font-size: 12px;
  font-weight: 700;
  color: var(--text3);
  text-transform: uppercase;
  margin: 0;
}
.date-input {
  background: #F8FAFC;
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 7px 12px;
  font-size: 13px;
  font-weight: 600;
  color: var(--text);
  outline: none;
  min-width: 140px;
}
.date-input:focus {
  border-color: var(--blue);
  background: #fff;
}
.btn-apply-filter {
  background: var(--blue);
  color: #fff;
  border: none;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 12.5px;
  font-weight: 700;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all .2s;
}
.btn-apply-filter:hover {
  background: var(--blue-d);
}
.current-range-badge {
  margin-left: auto;
  font-size: 12px;
  font-weight: 700;
  color: var(--blue);
  background: var(--blue-l);
  border: 1px solid #BFDBFE;
  border-radius: 8px;
  padding: 6px 12px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

/* ── TAB NAVIGATION ── */
.report-tabs {
  display: flex;
  align-items: center;
  gap: 8px;
  border-bottom: 2px solid #E2E8F0;
  margin-bottom: 24px;
  overflow-x: auto;
  padding-bottom: 4px;
}
.report-tab-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 18px;
  border-radius: 12px 12px 0 0;
  font-size: 13.5px;
  font-weight: 700;
  color: var(--text3);
  text-decoration: none;
  transition: all .15s;
  white-space: nowrap;
  border-bottom: 3px solid transparent;
  margin-bottom: -6px;
}
.report-tab-btn:hover {
  color: var(--blue);
  background: rgba(255,255,255,0.7);
}
.report-tab-btn.active {
  color: var(--blue);
  background: #fff;
  border-bottom-color: var(--blue);
  box-shadow: 0 -2px 8px rgba(0,0,0,0.03);
}

/* ── STATS CARDS GRID ── */
.kpi-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}
.kpi-card {
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 18px 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.02);
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  position: relative;
  overflow: hidden;
  transition: transform .2s, box-shadow .2s;
}
.kpi-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(0,0,0,0.05);
}
.kpi-left {
  display: flex;
  flex-direction: column;
}
.kpi-label {
  font-size: 11.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .5px;
  color: var(--text3);
  margin-bottom: 6px;
}
.kpi-value {
  font-size: 24px;
  font-weight: 800;
  color: var(--text);
  font-family: 'Nunito', sans-serif;
  line-height: 1.1;
  margin-bottom: 4px;
}
.kpi-sub {
  font-size: 12px;
  font-weight: 600;
  color: var(--text3);
}
.kpi-icon-wrap {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

/* ── CONTENT PANELS & TABLES ── */
.panel-card {
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 16px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.03);
  margin-bottom: 24px;
  overflow: hidden;
}
.panel-head {
  padding: 18px 22px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
  background: #FAFBFD;
}
.panel-head-title {
  display: flex;
  align-items: center;
  gap: 10px;
}
.panel-head-title h3 {
  font-size: 15px;
  font-weight: 800;
  color: var(--text);
  margin: 0;
  font-family: 'Nunito', sans-serif;
}
.panel-body {
  padding: 22px;
}

/* ── FILTER TOOLBAR INSIDE TABS ── */
.filter-toolbar {
  background: #F8FAFC;
  border: 1px solid var(--border);
  border-radius: 12px;
  padding: 14px 18px;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}
.filter-select, .filter-input {
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 7px 12px;
  font-size: 13px;
  font-weight: 600;
  color: var(--text);
  outline: none;
  min-height: 38px;
}
.filter-select:focus, .filter-input:focus {
  border-color: var(--blue);
  box-shadow: 0 0 0 2px rgba(37,99,235,0.12);
}
.btn-filter-apply {
  background: var(--blue);
  color: #fff;
  border: none;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  min-height: 38px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}
.btn-filter-reset {
  background: #F1F5F9;
  color: var(--text2);
  border: 1px solid var(--border);
  padding: 8px 14px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 600;
  text-decoration: none;
  min-height: 38px;
  display: inline-flex;
  align-items: center;
}

/* ── DATA TABLES ── */
.data-table-wrap {
  width: 100%;
  overflow-x: auto;
}
.data-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}
.data-table th {
  background: #F8FAFC;
  padding: 12px 16px;
  font-size: 11.5px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: .5px;
  color: var(--text3);
  border-bottom: 1.5px solid var(--border);
  white-space: nowrap;
}
.data-table td {
  padding: 14px 16px;
  font-size: 13px;
  font-weight: 500;
  color: var(--text);
  border-bottom: 1px solid var(--border);
  vertical-align: middle;
}
.data-table tr:hover td {
  background: #FAFBFD;
}

/* ── STATUS BADGES ── */
.badge-status {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 4px 10px;
  border-radius: 999px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .2px;
  text-transform: capitalize;
  white-space: nowrap;
}
.badge-success { background: var(--green-bg); color: var(--green); border: 1px solid #A7F3D0; }
.badge-pending { background: var(--amber-bg); color: var(--amber); border: 1px solid #FDE68A; }
.badge-danger  { background: var(--rose-bg);  color: var(--rose);  border: 1px solid #FECDD3; }
.badge-blue    { background: var(--blue-l);   color: var(--blue);  border: 1px solid #BFDBFE; }
.badge-purple  { background: var(--purple-bg);color: var(--purple);border: 1px solid #DDD6FE; }

/* ── MINI PROGRESS BARS ── */
.progress-bar-bg {
  background: #E2E8F0;
  border-radius: 999px;
  height: 6px;
  width: 100%;
  overflow: hidden;
  margin-top: 5px;
}
.progress-bar-fill {
  height: 100%;
  border-radius: 999px;
  transition: width .3s ease;
}

/* ── EMPTY STATES ── */
.empty-data-box {
  padding: 40px 20px;
  text-align: center;
  color: var(--text3);
}
.empty-data-box svg {
  margin-bottom: 12px;
  stroke: #CBD5E1;
}

/* ── OVERVIEW 2-COLUMN SECTION ── */
.overview-grid-2 {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin-bottom: 24px;
}
@media (max-width: 992px) {
  .overview-grid-2 { grid-template-columns: 1fr; }
}

.sub-item-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px 0;
  border-bottom: 1px solid #F1F5F9;
}
.sub-item-row:last-child {
  border-bottom: none;
}
</style>

<div class="report-wrap">

    {{-- ══════════════════════════════════════════════════
         PAGE HEADER
    ══════════════════════════════════════════════════ --}}
    <div class="report-header">
        <div class="report-title-area">
            <h1>
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                </svg>
                Reports &amp; Platform Analytics
            </h1>
            <p>Unified business intelligence: payments, appointments, doctors, patients, and subscriptions taken.</p>
        </div>

        <div>
            <a href="{{ route('admin.reports.export', array_merge(request()->all(), ['tab' => $tab])) }}" class="btn-export">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Export Active Tab to CSV
            </a>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════
         DATE-WISE FILTER BAR
    ══════════════════════════════════════════════════ --}}
    <div class="date-filter-box">
        <div class="preset-pills-row">
            <span style="font-size:12px; font-weight:700; color:var(--text3); text-transform:uppercase; margin-right:4px;">Date Filter:</span>
            
            <a href="{{ route('admin.reports.index', array_merge(request()->except(['from_date', 'to_date', 'page']), ['tab' => $tab, 'range' => 'today'])) }}" 
               class="preset-pill {{ $range === 'today' ? 'active' : '' }}">Today</a>

            <a href="{{ route('admin.reports.index', array_merge(request()->except(['from_date', 'to_date', 'page']), ['tab' => $tab, 'range' => 'yesterday'])) }}" 
               class="preset-pill {{ $range === 'yesterday' ? 'active' : '' }}">Yesterday</a>

            <a href="{{ route('admin.reports.index', array_merge(request()->except(['from_date', 'to_date', 'page']), ['tab' => $tab, 'range' => 'last_7_days'])) }}" 
               class="preset-pill {{ $range === 'last_7_days' ? 'active' : '' }}">Last 7 Days</a>

            <a href="{{ route('admin.reports.index', array_merge(request()->except(['from_date', 'to_date', 'page']), ['tab' => $tab, 'range' => 'last_30_days'])) }}" 
               class="preset-pill {{ $range === 'last_30_days' ? 'active' : '' }}">Last 30 Days</a>

            <a href="{{ route('admin.reports.index', array_merge(request()->except(['from_date', 'to_date', 'page']), ['tab' => $tab, 'range' => 'this_month'])) }}" 
               class="preset-pill {{ $range === 'this_month' ? 'active' : '' }}">This Month</a>

            <a href="{{ route('admin.reports.index', array_merge(request()->except(['from_date', 'to_date', 'page']), ['tab' => $tab, 'range' => 'last_month'])) }}" 
               class="preset-pill {{ $range === 'last_month' ? 'active' : '' }}">Last Month</a>

            <a href="{{ route('admin.reports.index', array_merge(request()->except(['from_date', 'to_date', 'page']), ['tab' => $tab, 'range' => 'this_year'])) }}" 
               class="preset-pill {{ $range === 'this_year' ? 'active' : '' }}">This Year</a>

            <a href="{{ route('admin.reports.index', array_merge(request()->except(['from_date', 'to_date', 'page']), ['tab' => $tab, 'range' => 'all'])) }}" 
               class="preset-pill {{ $range === 'all' ? 'active' : '' }}">All Time</a>

            <span class="current-range-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Active: {{ $rangeLabel }}
            </span>
        </div>

        {{-- Custom Range Form --}}
        <form action="{{ route('admin.reports.index') }}" method="GET" class="custom-range-form">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="hidden" name="range" value="custom">

            <div class="custom-input-wrap">
                <label>From Date:</label>
                <input type="date" name="from_date" class="date-input" value="{{ $customFrom }}" required>
            </div>

            <div class="custom-input-wrap">
                <label>To Date:</label>
                <input type="date" name="to_date" class="date-input" value="{{ $customTo }}" required>
            </div>

            <button type="submit" class="btn-apply-filter">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Apply Custom Range
            </button>
        </form>
    </div>

    {{-- ══════════════════════════════════════════════════
         MULTI-TAB NAVIGATION
    ══════════════════════════════════════════════════ --}}
    <div class="report-tabs">
        <a href="{{ route('admin.reports.index', array_merge(request()->except(['page']), ['tab' => 'overview'])) }}" 
           class="report-tab-btn {{ $tab === 'overview' ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
            </svg>
            Overview (What's Going On)
        </a>

        <a href="{{ route('admin.reports.index', array_merge(request()->except(['page']), ['tab' => 'payments'])) }}" 
           class="report-tab-btn {{ $tab === 'payments' ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
            </svg>
            Payments &amp; Financials
        </a>

        <a href="{{ route('admin.reports.index', array_merge(request()->except(['page']), ['tab' => 'appointments'])) }}" 
           class="report-tab-btn {{ $tab === 'appointments' ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Appointments &amp; Bookings
        </a>

        <a href="{{ route('admin.reports.index', array_merge(request()->except(['page']), ['tab' => 'doctors'])) }}" 
           class="report-tab-btn {{ $tab === 'doctors' ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><polyline points="17 11 19 13 23 9"/>
            </svg>
            Doctors &amp; Capacity
        </a>

        <a href="{{ route('admin.reports.index', array_merge(request()->except(['page']), ['tab' => 'patients'])) }}" 
           class="report-tab-btn {{ $tab === 'patients' ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            Patients &amp; Growth
        </a>

        <a href="{{ route('admin.reports.index', array_merge(request()->except(['page']), ['tab' => 'subscriptions'])) }}" 
           class="report-tab-btn {{ $tab === 'subscriptions' ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
            Subscriptions Taken
        </a>
    </div>

    {{-- ══════════════════════════════════════════════════
         TAB 1: OVERVIEW ("WHAT'S GOING ON")
    ══════════════════════════════════════════════════ --}}
    @if($tab === 'overview')
        
        {{-- KPI Summary Cards --}}
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Gross Revenue</span>
                    <span class="kpi-value" style="color:#059669;">₹{{ number_format($totalRevenue, 2) }}</span>
                    <span class="kpi-sub">In selected period</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#ECFDF5; color:#059669;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Appointments</span>
                    <span class="kpi-value" style="color:var(--blue);">{{ number_format($totalAppointments) }}</span>
                    <span class="kpi-sub">{{ number_format($completedAppointments) }} Completed</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#EFF6FF; color:var(--blue);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Active Doctors</span>
                    <span class="kpi-value" style="color:var(--purple);">{{ number_format($activeDoctorsCount) }}</span>
                    <span class="kpi-sub">Of {{ number_format($totalDoctorsCount) }} Total Doctors</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#F5F3FF; color:var(--purple);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">New Patients</span>
                    <span class="kpi-value" style="color:#D97706;">{{ number_format($newPatientsCount) }}</span>
                    <span class="kpi-sub">{{ number_format($totalPatientsCount) }} Lifetime Total</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#FFFBEB; color:#D97706;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Subscriptions Sold</span>
                    <span class="kpi-value" style="color:#0891B2;">{{ number_format($subscriptionsSoldCount) }}</span>
                    <span class="kpi-sub">₹{{ number_format($subscriptionRevenue, 2) }} Volume</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#ECFEFF; color:#0891B2;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Doctor Payouts</span>
                    <span class="kpi-value" style="color:#E11D48;">₹{{ number_format($doctorPayoutsTotal, 2) }}</span>
                    <span class="kpi-sub">Settled by Admin</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#FFF1F2; color:#E11D48;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                </div>
            </div>
        </div>

        {{-- Visual Chart Section --}}
        <div class="panel-card">
            <div class="panel-head">
                <div class="panel-head-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                    <h3>Revenue &amp; Bookings Velocity ({{ $rangeLabel }})</h3>
                </div>
                <div style="font-size:12px; color:var(--text3); font-weight:600;">
                    Daily aggregated trends over selected period
                </div>
            </div>
            <div class="panel-body">
                <div style="position:relative; height:300px; width:100%;">
                    <canvas id="overviewChart"></canvas>
                </div>
            </div>
        </div>

        {{-- 2-Column Section: Status Breakdowns & Top Performers --}}
        <div class="overview-grid-2">
            
            {{-- Card 1: Appointment Statuses --}}
            <div class="panel-card">
                <div class="panel-head">
                    <div class="panel-head-title">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <h3>Appointment Status Breakdown</h3>
                    </div>
                    <span class="badge-status badge-blue">{{ number_format($totalAppointments) }} Total</span>
                </div>
                <div class="panel-body">
                    @php
                        $completedCnt = $appointmentStatuses['completed'] ?? 0;
                        $confirmedCnt = $appointmentStatuses['confirmed'] ?? 0;
                        $pendingCnt   = $appointmentStatuses['pending'] ?? 0;
                        $cancelledCnt = $appointmentStatuses['cancelled'] ?? 0;
                        $tAppts       = max(1, $totalAppointments);
                    @endphp

                    <div class="sub-item-row">
                        <div>
                            <strong style="color:#059669;">Completed Sessions</strong>
                            <div class="progress-bar-bg"><div class="progress-bar-fill" style="width:{{ ($completedCnt / $tAppts) * 100 }}%; background:#059669;"></div></div>
                        </div>
                        <span style="font-weight:700; color:var(--text);">{{ $completedCnt }} ({{ round(($completedCnt / $tAppts) * 100) }}%)</span>
                    </div>

                    <div class="sub-item-row">
                        <div>
                            <strong style="color:var(--blue);">Confirmed Upcoming</strong>
                            <div class="progress-bar-bg"><div class="progress-bar-fill" style="width:{{ ($confirmedCnt / $tAppts) * 100 }}%; background:var(--blue);"></div></div>
                        </div>
                        <span style="font-weight:700; color:var(--text);">{{ $confirmedCnt }} ({{ round(($confirmedCnt / $tAppts) * 100) }}%)</span>
                    </div>

                    <div class="sub-item-row">
                        <div>
                            <strong style="color:#D97706;">Pending Confirmation</strong>
                            <div class="progress-bar-bg"><div class="progress-bar-fill" style="width:{{ ($pendingCnt / $tAppts) * 100 }}%; background:#D97706;"></div></div>
                        </div>
                        <span style="font-weight:700; color:var(--text);">{{ $pendingCnt }} ({{ round(($pendingCnt / $tAppts) * 100) }}%)</span>
                    </div>

                    <div class="sub-item-row">
                        <div>
                            <strong style="color:#DC2626;">Cancelled / No Show</strong>
                            <div class="progress-bar-bg"><div class="progress-bar-fill" style="width:{{ ($cancelledCnt / $tAppts) * 100 }}%; background:#DC2626;"></div></div>
                        </div>
                        <span style="font-weight:700; color:var(--text);">{{ $cancelledCnt }} ({{ round(($cancelledCnt / $tAppts) * 100) }}%)</span>
                    </div>
                </div>
            </div>

            {{-- Card 2: Top Selling Packages --}}
            <div class="panel-card">
                <div class="panel-head">
                    <div class="panel-head-title">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--purple)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <h3>Popular Subscription Packages</h3>
                    </div>
                    <span class="badge-status badge-purple">{{ number_format($subscriptionsSoldCount) }} Sold</span>
                </div>
                <div class="panel-body">
                    @forelse($popularPlans as $planStat)
                        <div class="sub-item-row">
                            <div>
                                <strong style="color:var(--text);">{{ $planStat->plan->name ?? 'Custom Package' }}</strong>
                                <div style="font-size:11.5px; color:var(--text3);">₹{{ number_format($planStat->plan->price ?? 0, 2) }} per package</div>
                            </div>
                            <div style="text-align:right;">
                                <span class="badge-status badge-purple" style="font-size:12px;">{{ $planStat->total_sold }} Sold</span>
                                <div style="font-size:11.5px; color:#059669; font-weight:700;">₹{{ number_format($planStat->total_amount, 2) }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-data-box">No subscriptions recorded in this period.</div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Card 3: Top Performing Doctors --}}
        <div class="panel-card">
            <div class="panel-head">
                <div class="panel-head-title">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/></svg>
                    <h3>Top Performing Doctors (Completed Visits)</h3>
                </div>
                <a href="{{ route('admin.reports.index', ['tab' => 'doctors', 'range' => $range]) }}" style="font-size:12.5px; font-weight:700; color:var(--blue); text-decoration:none;">View All Doctors &rarr;</a>
            </div>
            <div class="data-table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Doctor Name</th>
                            <th>Specialization</th>
                            <th>Email &amp; Phone</th>
                            <th>Completed Appointments</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topDoctors as $doc)
                            <tr>
                                <td>
                                    <strong>Dr. {{ $doc->name }}</strong>
                                </td>
                                <td>
                                    <span class="badge-status badge-blue">
                                        {{ $doc->profile && $doc->profile->specializationdata ? $doc->profile->specializationdata->name : 'General Specialist' }}
                                    </span>
                                </td>
                                <td>
                                    <div>{{ $doc->email }}</div>
                                    <small style="color:var(--text3);">{{ $doc->phone ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <strong style="font-size:14px; color:#059669;">{{ $doc->completed_count }}</strong> visits
                                </td>
                                <td>
                                    <span class="badge-status {{ $doc->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($doc->status ?? 'active') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.doctors.slots', $doc->id) }}" class="btn-filter-apply" style="padding:4px 10px; font-size:11.5px; text-decoration:none;">
                                        Manage Slots
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-data-box">No doctor activity recorded for this period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    {{-- ══════════════════════════════════════════════════
         TAB 2: PAYMENTS & FINANCIALS
    ══════════════════════════════════════════════════ --}}
    @elseif($tab === 'payments')

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Gross Collected</span>
                    <span class="kpi-value" style="color:#059669;">₹{{ number_format($paymentsGross, 2) }}</span>
                    <span class="kpi-sub">Successful Payments</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#ECFDF5; color:#059669;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Successful Transactions</span>
                    <span class="kpi-value" style="color:var(--blue);">{{ number_format($successfulCount) }}</span>
                    <span class="kpi-sub">Of {{ number_format($paymentsCount) }} Total Attempts</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#EFF6FF; color:var(--blue);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Pending / In-Review</span>
                    <span class="kpi-value" style="color:#D97706;">{{ number_format($pendingCount) }}</span>
                    <span class="kpi-sub">{{ number_format($failedCount) }} Failed</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#FFFBEB; color:#D97706;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Doctor Payouts</span>
                    <span class="kpi-value" style="color:#E11D48;">₹{{ number_format($doctorPayoutTotal, 2) }}</span>
                    <span class="kpi-sub">Avg Order: ₹{{ number_format($avgTransaction, 2) }}</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#FFF1F2; color:#E11D48;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                </div>
            </div>
        </div>

        {{-- Filter Toolbar --}}
        <form action="{{ route('admin.reports.index') }}" method="GET" class="filter-toolbar">
            <input type="hidden" name="tab" value="payments">
            <input type="hidden" name="range" value="{{ $range }}">
            <input type="hidden" name="from_date" value="{{ $customFrom }}">
            <input type="hidden" name="to_date" value="{{ $customTo }}">

            <select name="payment_status" class="filter-select">
                <option value="">-- All Payment Statuses --</option>
                <option value="success" {{ request('payment_status') === 'success' ? 'selected' : '' }}>Success / Paid</option>
                <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
            </select>

            <select name="payment_method" class="filter-select">
                <option value="">-- All Payment Methods --</option>
                <option value="Manual" {{ request('payment_method') === 'Manual' ? 'selected' : '' }}>Manual / Online</option>
                <option value="admin_manual" {{ request('payment_method') === 'admin_manual' ? 'selected' : '' }}>Admin Doctor Payout</option>
                <option value="razorpay" {{ request('payment_method') === 'razorpay' ? 'selected' : '' }}>Razorpay</option>
            </select>

            <input type="text" name="search" class="filter-input" placeholder="Search by Txn ID, Patient, Doctor..." value="{{ request('search') }}" style="min-width:260px;">

            <button type="submit" class="btn-filter-apply">Filter Transactions</button>
            <a href="{{ route('admin.reports.index', ['tab' => 'payments', 'range' => $range, 'from_date' => $customFrom, 'to_date' => $customTo]) }}" class="btn-filter-reset">Reset</a>
        </form>

        {{-- Transactions Table --}}
        <div class="panel-card">
            <div class="data-table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Txn ID &amp; Date</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Category</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $p)
                            <tr>
                                <td>
                                    <div style="font-weight:700; font-family:monospace; color:var(--blue);">{{ $p->transaction_id ?? 'TXN-' . $p->id }}</div>
                                    <small style="color:var(--text3);">{{ $p->created_at ? $p->created_at->format('d M Y, h:i A') : 'N/A' }}</small>
                                </td>
                                <td>
                                    @if($p->patient)
                                        <strong>{{ $p->patient->name }}</strong>
                                        <div style="font-size:11.5px; color:var(--text3);">{{ $p->patient->phone ?? '' }}</div>
                                    @else
                                        <span style="color:var(--text3);">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->doctor)
                                        <strong>Dr. {{ $p->doctor->name }}</strong>
                                    @else
                                        <span style="color:var(--text3);">Platform / Any</span>
                                    @endif
                                </td>
                                <td>
                                    <strong style="font-size:14px; color:#059669;">₹{{ number_format($p->amount, 2) }}</strong>
                                </td>
                                <td>
                                    <span class="badge-status badge-blue">{{ strtoupper($p->payment_method ?? 'ONLINE') }}</span>
                                </td>
                                <td>
                                    @if($p->payment_method === 'admin_manual')
                                        <span class="badge-status badge-purple">Doctor Payout</span>
                                    @elseif($p->appointment_id)
                                        <span class="badge-status badge-blue">Appointment Visit</span>
                                    @else
                                        <span class="badge-status badge-success">Plan Subscription</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->status === 'success')
                                        <span class="badge-status badge-success">Paid</span>
                                    @elseif($p->status === 'pending')
                                        <span class="badge-status badge-pending">Pending</span>
                                    @else
                                        <span class="badge-status badge-danger">Failed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-data-box">No payment records found for the selected filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($payments->hasPages())
                <div style="padding:16px 20px; border-top:1px solid var(--border);">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>

    {{-- ══════════════════════════════════════════════════
         TAB 3: APPOINTMENTS & BOOKINGS
    ══════════════════════════════════════════════════ --}}
    @elseif($tab === 'appointments')

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Total Bookings</span>
                    <span class="kpi-value" style="color:var(--blue);">{{ number_format($totalAppointments) }}</span>
                    <span class="kpi-sub">In selected period</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#EFF6FF; color:var(--blue);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Completed Sessions</span>
                    <span class="kpi-value" style="color:#059669;">{{ number_format($completedAppointments) }}</span>
                    <span class="kpi-sub">{{ $completionRate }}% Completion Rate</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#ECFDF5; color:#059669;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Confirmed Upcoming</span>
                    <span class="kpi-value" style="color:var(--purple);">{{ number_format($confirmedAppointments) }}</span>
                    <span class="kpi-sub">{{ number_format($pendingAppointments) }} Awaiting Confirmation</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#F5F3FF; color:var(--purple);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Cancelled / No Show</span>
                    <span class="kpi-value" style="color:#DC2626;">{{ number_format($cancelledAppointments) }}</span>
                    <span class="kpi-sub">Total cancellations</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#FEF2F2; color:#DC2626;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </div>
            </div>
        </div>

        {{-- Filter Toolbar --}}
        <form action="{{ route('admin.reports.index') }}" method="GET" class="filter-toolbar">
            <input type="hidden" name="tab" value="appointments">
            <input type="hidden" name="range" value="{{ $range }}">
            <input type="hidden" name="from_date" value="{{ $customFrom }}">
            <input type="hidden" name="to_date" value="{{ $customTo }}">

            <select name="appointment_status" class="filter-select">
                <option value="">-- All Booking Statuses --</option>
                <option value="confirmed" {{ request('appointment_status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" {{ request('appointment_status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="pending" {{ request('appointment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="cancelled" {{ request('appointment_status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <select name="doctor_id" class="filter-select">
                <option value="">-- All Doctors --</option>
                @foreach($doctorsList as $doc)
                    <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>Dr. {{ $doc->name }}</option>
                @endforeach
            </select>

            <input type="text" name="search" class="filter-input" placeholder="Search by patient name, phone..." value="{{ request('search') }}" style="min-width:240px;">

            <button type="submit" class="btn-filter-apply">Filter Bookings</button>
            <a href="{{ route('admin.reports.index', ['tab' => 'appointments', 'range' => $range, 'from_date' => $customFrom, 'to_date' => $customTo]) }}" class="btn-filter-reset">Reset</a>
        </form>

        {{-- Appointments Table --}}
        <div class="panel-card">
            <div class="data-table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID &amp; Date</th>
                            <th>Time Slot</th>
                            <th>Patient Info</th>
                            <th>Doctor &amp; Speciality</th>
                            <th>Problem / Reason</th>
                            <th>Status</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appt)
                            <tr>
                                <td>
                                    <strong>#{{ $appt->id }}</strong>
                                    <div style="font-size:12px; font-weight:700; color:var(--blue);">
                                        {{ $appt->appointment_date ? $appt->appointment_date->format('D, d M Y') : 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-status badge-blue">
                                        {{ $appt->start_time ? $appt->start_time->format('h:i A') : 'N/A' }} - {{ $appt->end_time ? $appt->end_time->format('h:i A') : '' }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $appt->patient_name ?? ($appt->patient->name ?? 'Patient') }}</strong>
                                    <div style="font-size:11.5px; color:var(--text3);">
                                        {{ $appt->patient_gender ? ucfirst($appt->patient_gender) . ', ' : '' }}{{ $appt->patient_age ? $appt->patient_age . ' yrs' : '' }}
                                        @if($appt->patient && $appt->patient->phone)
                                            • {{ $appt->patient->phone }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <strong>Dr. {{ $appt->doctor->name ?? 'Doctor' }}</strong>
                                    <div style="font-size:11.5px; color:var(--text3);">
                                        {{ $appt->doctor && $appt->doctor->profile && $appt->doctor->profile->specializationdata ? $appt->doctor->profile->specializationdata->name : 'Physiotherapy' }}
                                    </div>
                                </td>
                                <td>
                                    <div style="max-width:240px; font-size:12px; color:var(--text2); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $appt->problem_description }}">
                                        {{ $appt->problem_description ?? 'Standard consultation' }}
                                    </div>
                                </td>
                                <td>
                                    @if($appt->status === 'completed')
                                        <span class="badge-status badge-success">Completed</span>
                                    @elseif($appt->status === 'confirmed')
                                        <span class="badge-status badge-blue">Confirmed</span>
                                    @elseif($appt->status === 'cancelled')
                                        <span class="badge-status badge-danger">Cancelled</span>
                                    @else
                                        <span class="badge-status badge-pending">{{ ucfirst($appt->status ?? 'pending') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-status {{ $appt->payment_status === 'paid' ? 'badge-success' : 'badge-pending' }}">
                                        {{ ucfirst($appt->payment_status ?? 'unpaid') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-data-box">No appointments found for the selected dates/criteria.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($appointments->hasPages())
                <div style="padding:16px 20px; border-top:1px solid var(--border);">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>

    {{-- ══════════════════════════════════════════════════
         TAB 4: DOCTORS & CAPACITY
    ══════════════════════════════════════════════════ --}}
    @elseif($tab === 'doctors')

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Total Doctors</span>
                    <span class="kpi-value" style="color:var(--text);">{{ number_format($totalDoctors) }}</span>
                    <span class="kpi-sub">{{ number_format($activeDoctors) }} Active On Platform</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#EFF6FF; color:var(--blue);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Slots Configured</span>
                    <span class="kpi-value" style="color:var(--purple);">{{ number_format($totalSlotsInPeriod) }}</span>
                    <span class="kpi-sub">In selected period</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#F5F3FF; color:var(--purple);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Slots Booked</span>
                    <span class="kpi-value" style="color:#059669;">{{ number_format($bookedSlotsInPeriod) }}</span>
                    <span class="kpi-sub">Booked by patients</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#ECFDF5; color:#059669;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Slot Utilization</span>
                    <span class="kpi-value" style="color:#D97706;">{{ $slotUtilizationRate }}%</span>
                    <span class="kpi-sub">Capacity filled rate</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#FFFBEB; color:#D97706;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>
        </div>

        {{-- Filter Toolbar --}}
        <form action="{{ route('admin.reports.index') }}" method="GET" class="filter-toolbar">
            <input type="hidden" name="tab" value="doctors">
            <input type="hidden" name="range" value="{{ $range }}">
            <input type="hidden" name="from_date" value="{{ $customFrom }}">
            <input type="hidden" name="to_date" value="{{ $customTo }}">

            <select name="doctor_status" class="filter-select">
                <option value="">-- All Statuses --</option>
                <option value="active" {{ request('doctor_status') === 'active' ? 'selected' : '' }}>Active Only</option>
                <option value="inactive" {{ request('doctor_status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
            </select>

            <select name="specialization_id" class="filter-select">
                <option value="">-- All Specializations --</option>
                @foreach($specializationsList as $spec)
                    <option value="{{ $spec->id }}" {{ request('specialization_id') == $spec->id ? 'selected' : '' }}>{{ $spec->name }}</option>
                @endforeach
            </select>

            <input type="text" name="search" class="filter-input" placeholder="Search doctor by name, email..." value="{{ request('search') }}" style="min-width:240px;">

            <button type="submit" class="btn-filter-apply">Filter Doctors</button>
            <a href="{{ route('admin.reports.index', ['tab' => 'doctors', 'range' => $range, 'from_date' => $customFrom, 'to_date' => $customTo]) }}" class="btn-filter-reset">Reset</a>
        </form>

        {{-- Doctors Performance Table --}}
        <div class="panel-card">
            <div class="data-table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Specialization</th>
                            <th>Period Slots</th>
                            <th>Booked Slots</th>
                            <th>Completed Visits</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctors as $d)
                            <tr>
                                <td>
                                    <strong>Dr. {{ $d->name }}</strong>
                                    <div style="font-size:11.5px; color:var(--text3);">{{ $d->email }} • {{ $d->phone ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <span class="badge-status badge-blue">
                                        {{ $d->profile && $d->profile->specializationdata ? $d->profile->specializationdata->name : 'General Specialist' }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $d->total_slots_period ?? 0 }}</strong> slots
                                </td>
                                <td>
                                    <strong style="color:var(--blue);">{{ $d->booked_slots_period ?? 0 }}</strong>
                                    @if(($d->total_slots_period ?? 0) > 0)
                                        <small style="color:var(--text3);">({{ round((($d->booked_slots_period ?? 0) / $d->total_slots_period) * 100) }}%)</small>
                                    @endif
                                </td>
                                <td>
                                    <strong style="color:#059669; font-size:14px;">{{ $d->completed_appointments_period ?? 0 }}</strong>
                                </td>
                                <td>
                                    <span class="badge-status {{ $d->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($d->status ?? 'active') }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex; gap:6px;">
                                        <a href="{{ route('admin.doctors.slots', $d->id) }}" class="btn-filter-apply" style="padding:4px 8px; font-size:11px; text-decoration:none;" title="Manage Doctor Slots">
                                            Slots
                                        </a>
                                        <a href="{{ route('admin.doctors.payments', $d->id) }}" class="btn-filter-reset" style="padding:4px 8px; font-size:11px; min-height:auto;" title="Doctor Payouts">
                                            Payout
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-data-box">No doctors matching criteria found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($doctors->hasPages())
                <div style="padding:16px 20px; border-top:1px solid var(--border);">
                    {{ $doctors->links() }}
                </div>
            @endif
        </div>

    {{-- ══════════════════════════════════════════════════
         TAB 5: PATIENTS & GROWTH
    ══════════════════════════════════════════════════ --}}
    @elseif($tab === 'patients')

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Lifetime Patients</span>
                    <span class="kpi-value" style="color:var(--text);">{{ number_format($totalPatients) }}</span>
                    <span class="kpi-sub">Total registered user base</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#EFF6FF; color:var(--blue);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">New Signups</span>
                    <span class="kpi-value" style="color:#059669;">{{ number_format($newPatientsInPeriod) }}</span>
                    <span class="kpi-sub">Joined in selected period</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#ECFDF5; color:#059669;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Patients With Bookings</span>
                    <span class="kpi-value" style="color:var(--purple);">{{ number_format($patientsWithAppointments) }}</span>
                    <span class="kpi-sub">Booked appointments in period</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#F5F3FF; color:var(--purple);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Subscribed Patients</span>
                    <span class="kpi-value" style="color:#0891B2;">{{ number_format($patientsWithActiveSubscriptions) }}</span>
                    <span class="kpi-sub">Active recurring care packages</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#ECFEFF; color:#0891B2;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
            </div>
        </div>

        {{-- Filter Toolbar --}}
        <form action="{{ route('admin.reports.index') }}" method="GET" class="filter-toolbar">
            <input type="hidden" name="tab" value="patients">
            <input type="hidden" name="range" value="{{ $range }}">
            <input type="hidden" name="from_date" value="{{ $customFrom }}">
            <input type="hidden" name="to_date" value="{{ $customTo }}">

            <input type="text" name="search" class="filter-input" placeholder="Search patient by name, phone, email, city..." value="{{ request('search') }}" style="min-width:300px;">

            <button type="submit" class="btn-filter-apply">Search Patients</button>
            <a href="{{ route('admin.reports.index', ['tab' => 'patients', 'range' => $range, 'from_date' => $customFrom, 'to_date' => $customTo]) }}" class="btn-filter-reset">Reset</a>
        </form>

        {{-- Patients Table --}}
        <div class="panel-card">
            <div class="data-table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Contact</th>
                            <th>Location</th>
                            <th>Registered On</th>
                            <th>Period Bookings</th>
                            <th>Lifetime Bookings</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $pt)
                            <tr>
                                <td>
                                    <strong>{{ $pt->name }}</strong>
                                </td>
                                <td>
                                    <div>{{ $pt->email }}</div>
                                    <small style="color:var(--text3);">{{ $pt->phone ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    {{ $pt->city ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ $pt->created_at ? $pt->created_at->format('d M Y') : 'N/A' }}
                                </td>
                                <td>
                                    <strong style="color:var(--blue); font-size:14px;">{{ $pt->appointments_in_period ?? 0 }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $pt->total_appointments_count ?? 0 }}</strong>
                                </td>
                                <td>
                                    <span class="badge-status {{ $pt->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($pt->status ?? 'active') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-data-box">No patient records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($patients->hasPages())
                <div style="padding:16px 20px; border-top:1px solid var(--border);">
                    {{ $patients->links() }}
                </div>
            @endif
        </div>

    {{-- ══════════════════════════════════════════════════
         TAB 6: SUBSCRIPTIONS TAKEN
    ══════════════════════════════════════════════════ --}}
    @elseif($tab === 'subscriptions')

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Subscriptions Taken</span>
                    <span class="kpi-value" style="color:var(--purple);">{{ number_format($totalSubscriptionsPeriod) }}</span>
                    <span class="kpi-sub">In selected period</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#F5F3FF; color:var(--purple);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Active Subscriptions</span>
                    <span class="kpi-value" style="color:#059669;">{{ number_format($activeSubscriptionsCount) }}</span>
                    <span class="kpi-sub">{{ number_format($expiredSubscriptionsCount) }} Expired/Completed</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#ECFDF5; color:#059669;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Subscription Revenue</span>
                    <span class="kpi-value" style="color:#059669;">₹{{ number_format($subscriptionRevenuePeriod, 2) }}</span>
                    <span class="kpi-sub">Paid packages volume</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#ECFDF5; color:#059669;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-left">
                    <span class="kpi-label">Session Utilization</span>
                    <span class="kpi-value" style="color:#D97706;">{{ $sessionUtilizationRate }}%</span>
                    <span class="kpi-sub">{{ number_format($totalAppointmentsUsed) }} of {{ number_format($totalAppointmentsAllotted) }} Sessions</span>
                </div>
                <div class="kpi-icon-wrap" style="background:#FFFBEB; color:#D97706;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>
        </div>

        {{-- Filter Toolbar --}}
        <form action="{{ route('admin.reports.index') }}" method="GET" class="filter-toolbar">
            <input type="hidden" name="tab" value="subscriptions">
            <input type="hidden" name="range" value="{{ $range }}">
            <input type="hidden" name="from_date" value="{{ $customFrom }}">
            <input type="hidden" name="to_date" value="{{ $customTo }}">

            <select name="subscription_status" class="filter-select">
                <option value="">-- All Subscription Statuses --</option>
                <option value="active" {{ request('subscription_status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="expired" {{ request('subscription_status') === 'expired' ? 'selected' : '' }}>Expired</option>
                <option value="completed" {{ request('subscription_status') === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>

            <select name="payment_status" class="filter-select">
                <option value="">-- All Payment Statuses --</option>
                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
            </select>

            <select name="patient_plan_id" class="filter-select">
                <option value="">-- All Packages / Plans --</option>
                @foreach($plansList as $pl)
                    <option value="{{ $pl->id }}" {{ request('patient_plan_id') == $pl->id ? 'selected' : '' }}>{{ $pl->name }} (₹{{ number_format($pl->price, 0) }})</option>
                @endforeach
            </select>

            <input type="text" name="search" class="filter-input" placeholder="Search by Unique Plan ID, Patient..." value="{{ request('search') }}" style="min-width:240px;">

            <button type="submit" class="btn-filter-apply">Filter Subscriptions</button>
            <a href="{{ route('admin.reports.index', ['tab' => 'subscriptions', 'range' => $range, 'from_date' => $customFrom, 'to_date' => $customTo]) }}" class="btn-filter-reset">Reset</a>
        </form>

        {{-- Subscriptions Table --}}
        <div class="panel-card">
            <div class="data-table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Unique Plan ID</th>
                            <th>Patient</th>
                            <th>Package Name</th>
                            <th>Doctor Assigned</th>
                            <th>Price</th>
                            <th>Sessions Progress</th>
                            <th>Validity Period</th>
                            <th>Payment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $sub)
                            <tr>
                                <td>
                                    <strong style="font-family:monospace; color:var(--purple); font-size:12.5px;">{{ $sub->unique_plan_id }}</strong>
                                    <div style="font-size:11px; color:var(--text3);">{{ $sub->created_at ? $sub->created_at->format('d M Y') : '' }}</div>
                                </td>
                                <td>
                                    <strong>{{ $sub->patient->name ?? 'Patient' }}</strong>
                                    <div style="font-size:11.5px; color:var(--text3);">{{ $sub->patient->phone ?? '' }}</div>
                                </td>
                                <td>
                                    <span class="badge-status badge-purple">
                                        {{ $sub->plan->name ?? 'Care Package' }}
                                    </span>
                                </td>
                                <td>
                                    @if($sub->doctor)
                                        <strong>Dr. {{ $sub->doctor->name }}</strong>
                                    @else
                                        <span style="color:var(--text3);">Any Available</span>
                                    @endif
                                </td>
                                <td>
                                    <strong style="color:#059669; font-size:14px;">₹{{ number_format($sub->package_price, 2) }}</strong>
                                </td>
                                <td>
                                    @php
                                        $allotted = max(1, $sub->package_appointments ?: ($sub->used_appointments + $sub->remaining_appointments));
                                        $used     = $sub->used_appointments ?? 0;
                                        $pct      = min(100, round(($used / $allotted) * 100));
                                    @endphp
                                    <div style="font-size:12px; font-weight:700;">
                                        {{ $used }} / {{ $allotted }} Used <small style="color:var(--text3);">({{ $sub->remaining_appointments }} left)</small>
                                    </div>
                                    <div class="progress-bar-bg" style="width:130px;">
                                        <div class="progress-bar-fill" style="width:{{ $pct }}%; background:var(--purple);"></div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size:12px;">
                                        {{ $sub->start_date ? $sub->start_date->format('d M Y') : 'N/A' }} &rarr; 
                                        {{ $sub->end_date ? $sub->end_date->format('d M Y') : 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-status {{ $sub->payment_status === 'paid' ? 'badge-success' : 'badge-pending' }}">
                                        {{ ucfirst($sub->payment_status ?? 'paid') }}
                                    </span>
                                </td>
                                <td>
                                    @if($sub->status === 'active')
                                        <span class="badge-status badge-success">Active</span>
                                    @elseif($sub->status === 'expired')
                                        <span class="badge-status badge-danger">Expired</span>
                                    @else
                                        <span class="badge-status badge-pending">{{ ucfirst($sub->status ?? 'active') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="empty-data-box">No subscriptions found matching the active filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($subscriptions->hasPages())
                <div style="padding:16px 20px; border-top:1px solid var(--border);">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>

    @endif

</div>

@if($tab === 'overview')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('overviewChart');
    if (!ctx) return;

    const chartLabels = {!! json_encode($chartLabels) !!};
    const chartRevenue = {!! json_encode($chartRevenue) !!};
    const chartAppointments = {!! json_encode($chartAppointments) !!};

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: 'Revenue (₹)',
                    data: chartRevenue,
                    borderColor: '#059669',
                    backgroundColor: 'rgba(5, 150, 105, 0.08)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.35,
                    yAxisID: 'yRevenue',
                    pointRadius: 3,
                    pointHoverRadius: 6
                },
                {
                    label: 'Appointments Booked',
                    data: chartAppointments,
                    borderColor: '#2563EB',
                    backgroundColor: 'rgba(37, 99, 235, 0.08)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.35,
                    yAxisID: 'yAppts',
                    pointRadius: 3,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        usePointStyle: true,
                        font: { family: 'Inter', size: 12, weight: '600' }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { family: 'Inter', size: 13, weight: '700' },
                    bodyFont: { family: 'Inter', size: 12 },
                    padding: 10,
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Inter', size: 11 } }
                },
                yRevenue: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    ticks: {
                        callback: function(value) { return '₹' + value; },
                        font: { family: 'Inter', size: 11 }
                    },
                    grid: { color: '#F1F5F9' }
                },
                yAppts: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    ticks: {
                        stepSize: 1,
                        font: { family: 'Inter', size: 11 }
                    },
                    grid: { drawOnChartArea: false }
                }
            }
        }
    });
});
</script>
@endif

@endsection
