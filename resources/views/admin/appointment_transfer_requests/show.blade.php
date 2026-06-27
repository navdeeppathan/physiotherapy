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
  --text:       #1A2B42;
  --text2:      #4A6080;
  --text3:      #8FA8C4;
  --green:      #16A96A;
  --green-bg:   #E8F8F2;
  --green-d:    #0E7A4D;
  --rose:       #E55A6B;
  --rose-bg:    #FDEEF0;
  --rose-d:     #C13050;
  --amber:      #D08020;
  --amber-bg:   #FEF5E7;
  --ease:       cubic-bezier(0.16,1,0.3,1);
}

.detail-page{
  padding:28px 28px 40px;
  font-family:'Inter',sans-serif;
  background:var(--bg);
  min-height:100vh;
}

/* breadcrumb */
.breadcrumb-row{
  display:flex;align-items:center;gap:6px;
  margin-bottom:16px;
}
.breadcrumb-row a{
  font-size:12.5px;font-weight:600;color:var(--blue);
  text-decoration:none;transition:opacity .2s;
}
.breadcrumb-row a:hover{ opacity:.75; }
.breadcrumb-sep{
  font-size:12px;color:var(--text3);
}
.breadcrumb-cur{
  font-size:12.5px;font-weight:600;color:var(--text3);
}

/* page head */
.page-head{
  display:flex;align-items:center;justify-content:space-between;
  margin-bottom:22px;flex-wrap:wrap;gap:12px;
}
.page-eyebrow{
  font-size:11px;font-weight:700;color:var(--blue);
  text-transform:uppercase;letter-spacing:.7px;margin-bottom:4px;
}
.page-title{
  font-size:22px;font-weight:700;color:var(--text);letter-spacing:-.3px;
}
.page-title span{ font-weight:300;color:var(--text2); }

/* layout */
.detail-grid{
  display:grid;
  grid-template-columns:320px 1fr;
  gap:20px;
  align-items:start;
}

@media(max-width:900px){
  .detail-grid{ grid-template-columns:1fr; }
  .detail-page{ padding:16px 14px 32px; }
}

/* shared card */
.panel{
  background:var(--white);border:1px solid var(--border);
  border-radius:16px;overflow:hidden;
  box-shadow:0 2px 8px rgba(45,125,210,.05),0 10px 32px rgba(26,91,168,.07);
  position:relative;
}
.panel::before{
  content:'';position:absolute;top:0;left:0;right:0;height:3px;
  background:linear-gradient(90deg,var(--blue-d),var(--blue-mid));
}
.panel-head{
  display:flex;align-items:center;gap:10px;
  padding:18px 22px 16px;border-bottom:1px solid var(--border);
}
.panel-icon{
  width:34px;height:34px;background:var(--blue-l);
  border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;
}
.panel-icon svg{
  width:17px;height:17px;fill:none;stroke:var(--blue);
  stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;
}
.panel-title{ font-size:14px;font-weight:700;color:var(--text); }
.panel-body{ padding:20px 22px; }

/* info rows */
.info-row{
  display:flex;flex-direction:column;gap:3px;
  padding:12px 0;border-bottom:1px solid #F0F6FD;
}
.info-row:last-child{ border-bottom:none;padding-bottom:0; }
.info-row:first-child{ padding-top:0; }
.info-label{
  font-size:10.5px;font-weight:700;color:var(--text3);
  text-transform:uppercase;letter-spacing:.5px;
}
.info-val{
  font-size:14px;font-weight:600;color:var(--text);
}
.info-val.reason{
  font-size:13px;font-weight:500;color:var(--text2);
  line-height:1.6;
}

/* badge */
.badge-pill{
  display:inline-flex;align-items:center;gap:5px;
  padding:4px 10px;border-radius:20px;
  font-size:11px;font-weight:700;letter-spacing:.2px;
  border:1px solid transparent;
}
.badge-pill::before{
  content:'';width:6px;height:6px;border-radius:50%;flex-shrink:0;
}
.bp-pending{ background:var(--amber-bg);color:var(--amber);border-color:rgba(208,128,32,.2); }
.bp-pending::before{ background:var(--amber); }
.bp-approved{ background:var(--green-bg);color:var(--green);border-color:rgba(22,169,106,.2); }
.bp-approved::before{ background:var(--green); }
.bp-rejected{ background:var(--rose-bg);color:var(--rose);border-color:rgba(229,90,107,.2); }
.bp-rejected::before{ background:var(--rose); }

/* right column stacks */
.right-col{
  display:flex;flex-direction:column;gap:20px;
}

/* appointments table */
.appt-table-wrap{ overflow-x:auto; }
table.appt-table{ width:100%;border-collapse:collapse; }
.appt-table thead tr{
  background:#F4F8FE;border-bottom:1.5px solid var(--border);
}
.appt-table thead th{
  padding:10px 14px;font-size:11px;font-weight:700;
  text-transform:uppercase;letter-spacing:.55px;
  color:var(--text3);white-space:nowrap;text-align:left;
}
.appt-table tbody tr{
  border-bottom:1px solid #F0F6FD;transition:background .15s;
}
.appt-table tbody tr:last-child{ border-bottom:none; }
.appt-table tbody tr:hover{ background:#F7FAFF; }
.appt-table tbody td{
  padding:12px 14px;font-size:13px;font-weight:500;
  color:var(--text);vertical-align:middle;
}
.cell-name{ font-weight:700;color:var(--text);font-size:13px; }
.cell-time{ font-size:11.5px;font-weight:500;color:var(--text3);margin-top:2px; }

/* inline select */
.doctor-select{
  width:100%;min-width:160px;
  background:var(--bg);border:1.5px solid var(--border);
  border-radius:8px;padding:8px 32px 8px 10px;
  font-family:'Inter',sans-serif;font-size:12.5px;font-weight:600;
  color:var(--text);outline:none;appearance:none;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238FA8C4' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
  background-repeat:no-repeat;background-position:right 10px center;
  transition:border-color .2s,box-shadow .2s;
}
.doctor-select:focus{
  border-color:var(--blue);
  box-shadow:0 0 0 3px rgba(45,125,210,.10);
  background-color:var(--white);
}

/* remark textarea */
.remark-label{
  display:block;font-size:11px;font-weight:700;color:var(--text3);
  text-transform:uppercase;letter-spacing:.5px;margin-bottom:7px;
}
.remark-input{
  width:100%;background:var(--bg);border:1.5px solid var(--border);
  border-radius:10px;padding:11px 14px;
  font-family:'Inter',sans-serif;font-size:13px;font-weight:500;
  color:var(--text);outline:none;resize:vertical;min-height:90px;
  transition:border-color .2s,box-shadow .2s;
}
.remark-input::placeholder{ color:var(--text3); }
.remark-input:focus{
  border-color:var(--blue);box-shadow:0 0 0 3px rgba(45,125,210,.10);
  background:var(--white);
}

/* action buttons */
.btn-approve{
  display:inline-flex;align-items:center;gap:7px;
  padding:11px 22px;border-radius:10px;border:none;cursor:pointer;
  font-family:'Inter',sans-serif;font-size:13.5px;font-weight:700;color:#fff;
  background:linear-gradient(135deg,var(--green-d),var(--green));
  box-shadow:0 4px 14px rgba(22,169,106,.28);
  transition:opacity .2s,transform .15s,box-shadow .2s;width:100%;
  justify-content:center;
}
.btn-approve:hover{
  opacity:.9;transform:translateY(-1px);
  box-shadow:0 7px 20px rgba(22,169,106,.36);
}
.btn-approve svg{
  width:16px;height:16px;fill:none;stroke:#fff;
  stroke-width:2;stroke-linecap:round;stroke-linejoin:round;
}

/* reject panel — rose top stripe */
.panel-reject::before{
  background:linear-gradient(90deg,var(--rose-d),var(--rose));
}
.panel-reject .panel-icon{
  background:var(--rose-bg);
}
.panel-reject .panel-icon svg{
  stroke:var(--rose);
}

.btn-reject{
  display:inline-flex;align-items:center;gap:7px;
  padding:11px 22px;border-radius:10px;border:none;cursor:pointer;
  font-family:'Inter',sans-serif;font-size:13.5px;font-weight:700;color:#fff;
  background:linear-gradient(135deg,var(--rose-d),var(--rose));
  box-shadow:0 4px 14px rgba(229,90,107,.28);
  transition:opacity .2s,transform .15s;width:100%;
  justify-content:center;
}
.btn-reject:hover{
  opacity:.9;transform:translateY(-1px);
  box-shadow:0 7px 20px rgba(229,90,107,.36);
}
.btn-reject svg{
  width:16px;height:16px;fill:none;stroke:#fff;
  stroke-width:2;stroke-linecap:round;stroke-linejoin:round;
}
</style>

<div class="detail-page">

  {{-- Breadcrumb --}}
  <div class="breadcrumb-row">
    <a href="{{ route('admin.appointment-transfer-requests.index') ?? '#' }}">Transfer Requests</a>
    <span class="breadcrumb-sep">›</span>
    <span class="breadcrumb-cur">Request Details</span>
  </div>

  {{-- Page Head --}}
  <div class="page-head">
    <div>
      <div class="page-eyebrow">Admin Panel</div>
      <div class="page-title">Transfer Request <span>Details</span></div>
    </div>
  </div>

  <div class="detail-grid">

    {{-- LEFT: Request Info --}}
    <div class="panel">
      <div class="panel-head">
        <div class="panel-icon">
          <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <div class="panel-title">Request Info</div>
      </div>
      <div class="panel-body">

        <div class="info-row">
          <span class="info-label">Doctor</span>
          <span class="info-val">{{ $requestData->doctor->name }}</span>
        </div>

        <div class="info-row">
          <span class="info-label">Transfer Period</span>
          <span class="info-val">{{ $requestData->from_date }} &nbsp;→&nbsp; {{ $requestData->to_date }}</span>
        </div>

        <div class="info-row">
          <span class="info-label">Reason</span>
          <span class="info-val reason">{{ $requestData->reason }}</span>
        </div>

        <div class="info-row">
          <span class="info-label">Status</span>
          <span class="info-val">
            @if($requestData->status == 'pending')
              <span class="badge-pill bp-pending">Pending</span>
            @elseif($requestData->status == 'approved')
              <span class="badge-pill bp-approved">Approved</span>
            @else
              <span class="badge-pill bp-rejected">{{ ucfirst($requestData->status) }}</span>
            @endif
          </span>
        </div>

      </div>
    </div>

    {{-- RIGHT COLUMN --}}
    <div class="right-col">

      {{-- Affected Appointments + Approve Form --}}
      <div class="panel">
        <div class="panel-head">
          <div class="panel-icon">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          </div>
          <div class="panel-title">Affected Appointments &amp; Transfer</div>
        </div>

        <form method="POST" action="{{ route('admin.appointment-transfer-requests.approve', $requestData->id) }}">
          @csrf

          <div class="appt-table-wrap">
            <table class="appt-table">
              <thead>
                <tr>
                  <th>Patient</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Transfer To</th>
                </tr>
              </thead>
              <tbody>
                @foreach($appointments as $appointment)
                <tr>
                  <td><div class="cell-name">{{ $appointment->patient_name }}</div></td>

                  <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</td>

                  <td>
                    <div>{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}</div>
                    <div class="cell-time">{{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}</div>
                  </td>

                  <td>
                    <select name="appointments[{{ $appointment->id }}]" class="doctor-select">
                      <option value="">Select Doctor</option>
                      @foreach($appointment->available_doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="panel-body" style="padding-top:18px;">
            <label class="remark-label">Admin Remark</label>
            <textarea name="admin_remark" class="remark-input" placeholder="Add a remark for this approval…"></textarea>

            <div style="margin-top:16px;">
              <button type="submit" class="btn-approve">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Approve &amp; Transfer
              </button>
            </div>
          </div>

        </form>
      </div>

      {{-- Reject Form --}}
      <div class="panel panel-reject">
        <div class="panel-head">
          <div class="panel-icon">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          </div>
          <div class="panel-title">Reject Request</div>
        </div>
        <div class="panel-body">
          <form method="POST" action="{{ route('admin.appointment-transfer-requests.reject', $requestData->id) }}">
            @csrf
            <label class="remark-label">Reason for Rejection</label>
            <textarea name="admin_remark" class="remark-input" placeholder="Explain why this request is being rejected…"></textarea>
            <div style="margin-top:16px;">
              <button type="submit" class="btn-reject">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Reject Request
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>{{-- /right-col --}}

  </div>{{-- /detail-grid --}}

</div>
@endsection