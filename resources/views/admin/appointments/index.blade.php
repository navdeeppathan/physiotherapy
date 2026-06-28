@extends('admin.layouts.admin')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
  :root{
    --bg:         #EEF4FB;
    --white:      #FFFFFF;
    --blue:       #2D7DD2;
    --blue-l:     #E8F1FB;
    --blue-d:     #1A5BA8;
    --blue-mid:   #4A9AE8;
    --border:     #D6E4F5;
    --border-f:   #2D7DD2;
    --text:       #1A2B42;
    --text2:      #4A6080;
    --text3:      #8FA8C4;
    --green:      #16A96A;
    --green-bg:   #E8F8F2;
    --amber:      #D08020;
    --amber-bg:   #FEF5E7;
    --rose:       #E55A6B;
    --rose-bg:    #FDEEF0;
    --info:       #2D7DD2;
    --info-bg:    #E8F1FB;
    --violet:     #7C5CCC;
    --violet-bg:  #F0ECFB;
    --ease:       cubic-bezier(0.16,1,0.3,1);
  }

  /* ── PAGE WRAPPER ── */
  .appt-page{
    padding: 28px 28px 40px;
    font-family:'Inter',sans-serif;
    background:var(--bg);
    min-height:100vh;
  }

  /* ── PAGE HEADING ── */
  .page-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:24px;
    flex-wrap:wrap;
    gap:12px;
  }

  .page-head-left{}

  .page-eyebrow{
    font-size:11px;
    font-weight:700;
    color:var(--blue);
    text-transform:uppercase;
    letter-spacing:0.7px;
    margin-bottom:4px;
  }

  .page-title{
    font-size:22px;
    font-weight:700;
    color:var(--text);
    letter-spacing:-0.3px;
  }

  .page-title span{
    font-weight:300;
    color:var(--text2);
  }

  /* ── MAIN CARD ── */
  .appt-card{
    background:var(--white);
    border:1px solid var(--border);
    border-radius:16px;
    overflow:hidden;
    box-shadow:
      0 2px 8px rgba(45,125,210,0.05),
      0 10px 32px rgba(26,91,168,0.07);
    position:relative;
  }

  /* blue top stripe */
  .appt-card::before{
    content:'';
    position:absolute;
    top:0;left:0;right:0;
    height:3px;
    background:linear-gradient(90deg,var(--blue-d),var(--blue-mid));
  }

  /* ── CARD HEADER ── */
  .card-top{
    display:flex;
    align-items:center;
    gap:10px;
    padding:20px 24px 18px;
    border-bottom:1px solid var(--border);
  }

  .card-top-icon{
    width:36px;height:36px;
    background:var(--blue-l);
    border-radius:9px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;
  }

  .card-top-icon svg{
    width:18px;height:18px;
    fill:none;
    stroke:var(--blue);
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
  }

  .card-top-title{
    font-size:15px;
    font-weight:700;
    color:var(--text);
  }

  .card-top-sub{
    font-size:12px;
    font-weight:500;
    color:var(--text3);
    margin-left:auto;
  }

  /* ── FILTER BAR ── */
  .filter-bar{
    display:flex;
    align-items:center;
    gap:10px;
    padding:18px 24px;
    border-bottom:1px solid var(--border);
    flex-wrap:wrap;
    background:#FAFCFF;
  }

  .filter-field{
    position:relative;
    flex:1;
    min-width:160px;
    max-width:260px;
  }

  .filter-field-icon{
    position:absolute;
    left:11px;top:50%;
    transform:translateY(-50%);
    width:16px;height:16px;
    pointer-events:none;
  }

  .filter-field-icon svg{
    width:16px;height:16px;
    fill:none;
    stroke:var(--text3);
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
  }

  .filter-field input,
  .filter-field select{
    width:100%;
    background:var(--white);
    border:1.5px solid var(--border);
    border-radius:9px;
    padding:9px 12px 9px 34px;
    font-family:'Inter',sans-serif;
    font-size:13px;
    font-weight:500;
    color:var(--text);
    outline:none;
    appearance:none;
    transition:border-color 0.2s var(--ease), box-shadow 0.2s var(--ease);
  }

  .filter-field input::placeholder{
    color:var(--text3);
  }

  .filter-field input:focus,
  .filter-field select:focus{
    border-color:var(--blue);
    box-shadow:0 0 0 3px rgba(45,125,210,0.10);
  }

  /* custom select arrow */
  .filter-field select{
    padding-right:32px;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238FA8C4' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat:no-repeat;
    background-position:right 10px center;
  }

  .btn-filter{
    background:linear-gradient(135deg,var(--blue-d),var(--blue));
    border:none;
    border-radius:9px;
    padding:9px 20px;
    font-family:'Inter',sans-serif;
    font-size:13px;
    font-weight:700;
    color:#fff;
    cursor:pointer;
    display:flex;
    align-items:center;
    gap:6px;
    white-space:nowrap;
    transition:opacity 0.2s, box-shadow 0.2s;
    box-shadow:0 3px 10px rgba(45,125,210,0.25);
  }

  .btn-filter:hover{
    opacity:0.9;
    box-shadow:0 5px 16px rgba(45,125,210,0.35);
  }

  .btn-filter svg{
    width:14px;height:14px;
    fill:none;
    stroke:#fff;
    stroke-width:2;
    stroke-linecap:round;
    stroke-linejoin:round;
  }

  /* ── TABLE ── */
  .table-wrap{
    overflow-x:auto;
    padding:0 0 2px;
  }

  table.appt-table{
    width:100%;
    border-collapse:collapse;
  }

  .appt-table thead tr{
    background:#F4F8FE;
    border-bottom:1.5px solid var(--border);
  }

  .appt-table thead th{
    padding:11px 16px;
    font-size:11px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:0.55px;
    color:var(--text3);
    white-space:nowrap;
    text-align:left;
  }

  .appt-table thead th:first-child{
    width:52px;
    text-align:center;
  }

  .appt-table tbody tr{
    border-bottom:1px solid #F0F6FD;
    transition:background 0.15s;
  }

  .appt-table tbody tr:last-child{
    border-bottom:none;
  }

  .appt-table tbody tr:hover{
    background:#F7FAFF;
  }

  .appt-table tbody td{
    padding:13px 16px;
    font-size:13.5px;
    font-weight:500;
    color:var(--text);
    vertical-align:middle;
  }

  .appt-table tbody td:first-child{
    text-align:center;
    font-size:12px;
    font-weight:700;
    color:var(--text3);
  }

  /* doctor/patient name */
  .cell-name{
    font-weight:700;
    color:var(--text);
    font-size:13.5px;
  }

  .cell-sub{
    font-size:11.5px;
    font-weight:500;
    color:var(--text3);
    margin-top:2px;
  }

  /* date / time */
  .cell-date{
    font-size:13px;
    font-weight:600;
    color:var(--text);
  }

  .cell-time{
    font-size:12px;
    font-weight:500;
    color:var(--text3);
    margin-top:2px;
  }

  /* ── BADGES ── */
  .badge-pill{
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:4px 10px;
    border-radius:20px;
    font-size:11px;
    font-weight:700;
    letter-spacing:0.2px;
    white-space:nowrap;
    border:1px solid transparent;
  }

  .badge-pill::before{
    content:'';
    width:6px;height:6px;
    border-radius:50%;
    flex-shrink:0;
  }

  /* status variants */
  .bp-approved{
    background:var(--green-bg);
    color:var(--green);
    border-color:rgba(22,169,106,0.2);
  }
  .bp-approved::before{ background:var(--green); }

  .bp-pending{
    background:var(--amber-bg);
    color:var(--amber);
    border-color:rgba(208,128,32,0.2);
  }
  .bp-pending::before{ background:var(--amber); }

  .bp-cancelled{
    background:var(--rose-bg);
    color:var(--rose);
    border-color:rgba(229,90,107,0.2);
  }
  .bp-cancelled::before{ background:var(--rose); }

  .bp-confirmed,
  .bp-info{
    background:var(--info-bg);
    color:var(--info);
    border-color:rgba(45,125,210,0.2);
  }
  .bp-confirmed::before,
  .bp-info::before{ background:var(--info); }

  .bp-completed{
    background:var(--violet-bg);
    color:var(--violet);
    border-color:rgba(124,92,204,0.2);
  }
  .bp-completed::before{ background:var(--violet); }

  .bp-default{
    background:#F4F6F9;
    color:var(--text2);
    border-color:var(--border);
  }
  .bp-default::before{ background:var(--text3); }

  /* payment */
  .bp-paid{
    background:var(--green-bg);
    color:var(--green);
    border-color:rgba(22,169,106,0.2);
  }
  .bp-paid::before{ background:var(--green); }

  .bp-unpaid{
    background:var(--rose-bg);
    color:var(--rose);
    border-color:rgba(229,90,107,0.2);
  }
  .bp-unpaid::before{ background:var(--rose); }

  /* ── EMPTY STATE ── */
  .empty-row td{
    padding:48px 16px;
    text-align:center;
  }

  .empty-icon{
    width:48px;height:48px;
    background:var(--blue-l);
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 auto 14px;
  }

  .empty-icon svg{
    width:24px;height:24px;
    fill:none;
    stroke:var(--blue);
    stroke-width:1.6;
    stroke-linecap:round;
    stroke-linejoin:round;
  }

  .empty-label{
    font-size:14px;
    font-weight:700;
    color:var(--text2);
  }

  .empty-sub{
    font-size:12.5px;
    font-weight:500;
    color:var(--text3);
    margin-top:4px;
  }

  /* ── PAGINATION ── */
  .pagination-wrap{
    padding:16px 24px 20px;
    border-top:1px solid var(--border);
    background:#FAFCFF;
  }

  /* override Bootstrap pagination to match theme */
  .pagination-wrap .pagination{
    margin:0;
    gap:4px;
  }

  .pagination-wrap .page-link{
    font-family:'Inter',sans-serif;
    font-size:12.5px;
    font-weight:600;
    color:var(--text2);
    border:1.5px solid var(--border);
    border-radius:8px !important;
    padding:6px 12px;
    background:var(--white);
    transition:all 0.2s;
  }

  .pagination-wrap .page-link:hover{
    background:var(--blue-l);
    border-color:var(--blue);
    color:var(--blue);
  }

  .pagination-wrap .page-item.active .page-link{
    background:linear-gradient(135deg,var(--blue-d),var(--blue));
    border-color:transparent;
    color:#fff;
    box-shadow:0 3px 10px rgba(45,125,210,0.25);
  }

  .pagination-wrap .page-item.disabled .page-link{
    opacity:0.45;
    cursor:not-allowed;
  }

  /* ── RESPONSIVE ── */
  @media(max-width:640px){
    .appt-page{ padding:16px 14px 32px; }
    .filter-field{ max-width:100%; }
    .card-top-sub{ display:none; }
  }
</style>

<div class="appt-page">

  {{-- PAGE HEADING --}}
  <div class="page-head">
    <div class="page-head-left">
      <div class="page-eyebrow">Admin Panel</div>
      <div class="page-title">All <span>Appointments</span></div>
    </div>
  </div>

  {{-- MAIN CARD --}}
  <div class="appt-card">

    {{-- Card Header --}}
    <div class="card-top">
      <div class="card-top-icon">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      </div>
      <div class="card-top-title">Appointments</div>
      <div class="card-top-sub">Manage &amp; review all patient appointments</div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" class="filter-bar">

      <div class="filter-field">
        <span class="filter-field-icon">
          <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </span>
        <input type="text" name="search"
               placeholder="Search patient name…"
               value="{{ request('search') }}">
      </div>

      <div class="filter-field">
        <span class="filter-field-icon">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </span>
        <select name="status">
          <option value="">All Status</option>
          <option value="pending"   {{ request('status')=='pending'   ? 'selected' : '' }}>Pending</option>
          <option value="approved"  {{ request('status')=='approved'  ? 'selected' : '' }}>Approved</option>
          <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Completed</option>
          <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
      </div>

      <div class="filter-field">
        <span class="filter-field-icon">
          <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </span>
        <select name="payment_status">
          <option value="">All Payment</option>
          <option value="paid"   {{ request('payment_status')=='paid'   ? 'selected' : '' }}>Paid</option>
          <option value="unpaid" {{ request('payment_status')=='unpaid' ? 'selected' : '' }}>Unpaid</option>
        </select>
      </div>

      <button type="submit" class="btn-filter">
        <svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
        Filter
      </button>

    </form>

    {{-- Table --}}
    <div class="table-wrap">
      <table class="appt-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Doctor</th>
            <th>Patient</th>
            <th>Date &amp; Time</th>
            <th>Status</th>
            <th>Payment</th>
          </tr>
        </thead>
        <tbody>
          @forelse($appointments as $key => $appointment)
          <tr>
            <td>{{ $appointments->firstItem() + $key }}</td>

            <td>
              <div class="cell-name">{{ $appointment->doctor->name ?? 'N/A' }}</div>
            </td>

            <td>
              <div class="cell-name">{{ $appointment->patient_name }}</div>
            </td>

            <td>
              <div class="cell-date">{{ date('d M Y', strtotime($appointment->appointment_date)) }}</div>
              <div class="cell-time">{{ $appointment->start_time }} – {{ $appointment->end_time }}</div>
            </td>

            <td>
              @if($appointment->status=='approved')
                <span class="badge-pill bp-approved">{{ ucfirst($appointment->status) }}</span>
              @elseif($appointment->status=='pending')
                <span class="badge-pill bp-pending">{{ ucfirst($appointment->status) }}</span>
              @elseif($appointment->status=='cancelled')
                <span class="badge-pill bp-cancelled">{{ ucfirst($appointment->status) }}</span>
              @elseif($appointment->status=='confirmed')
                <span class="badge-pill bp-confirmed">{{ ucfirst($appointment->status) }}</span>
              @elseif($appointment->status=='completed')
                <span class="badge-pill bp-completed">{{ ucfirst($appointment->status) }}</span>
              @else
                <span class="badge-pill bp-default">{{ ucfirst($appointment->status) }}</span>
              @endif
            </td>

            <td>
              <span class="badge-pill {{ $appointment->payment_status=='paid' ? 'bp-paid' : 'bp-unpaid' }}">
                {{ ucfirst($appointment->payment_status) }}
              </span>
            </td>

          </tr>
          @empty
          <tr class="empty-row">
            <td colspan="6">
              <div class="empty-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              </div>
              <div class="empty-label">No Appointments Found</div>
              <div class="empty-sub">Try adjusting your filters or check back later.</div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination-wrap">
      {{ $appointments->links('pagination::bootstrap-5') }}
    </div>

  </div>
</div>

@endsection