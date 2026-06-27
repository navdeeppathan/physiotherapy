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
  --amber:      #D08020;
  --amber-bg:   #FEF5E7;
  --rose:       #E55A6B;
  --rose-bg:    #FDEEF0;
  --neutral-bg: #F2F5F8;
  --violet:     #7C5CCC;
  --violet-bg:  #F0ECFB;
  --ease:       cubic-bezier(0.16,1,0.3,1);
}

*{ box-sizing:border-box; }

.subs-page{
  padding:28px 28px 48px;
  font-family:'Inter',sans-serif;
  background:var(--bg);
  min-height:100vh;
}

/* ── PAGE HEAD ── */
.page-eyebrow{
  font-size:11px;font-weight:700;color:var(--blue);
  text-transform:uppercase;letter-spacing:.7px;margin-bottom:4px;
}
.page-title{
  font-size:22px;font-weight:700;color:var(--text);
  letter-spacing:-.3px;margin-bottom:22px;
}
.page-title span{ font-weight:300;color:var(--text2); }

/* ── PANEL ── */
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

/* card top */
.card-top{
  display:flex;align-items:center;gap:10px;
  padding:18px 24px 16px;border-bottom:1px solid var(--border);
}
.card-top-icon{
  width:34px;height:34px;background:var(--blue-l);
  border-radius:9px;display:flex;align-items:center;
  justify-content:center;flex-shrink:0;
}
.card-top-icon svg{
  width:17px;height:17px;fill:none;stroke:var(--blue);
  stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;
}
.card-top-title{ font-size:14px;font-weight:700;color:var(--text); }
.card-top-sub{ font-size:12px;font-weight:500;color:var(--text3);margin-left:auto; }

/* ── TABLE ── */
.table-wrap{ overflow-x:auto; }

table.subs-table{ width:100%;border-collapse:collapse; }

.subs-table thead tr{
  background:#F4F8FE;border-bottom:1.5px solid var(--border);
}
.subs-table thead th{
  padding:11px 16px;font-size:11px;font-weight:700;
  text-transform:uppercase;letter-spacing:.55px;
  color:var(--text3);white-space:nowrap;text-align:left;
}
.subs-table thead th:first-child{ width:48px;text-align:center; }

.subs-table tbody tr{
  border-bottom:1px solid #F0F6FD;
  transition:background .15s;
}
.subs-table tbody tr:last-child{ border-bottom:none; }
.subs-table tbody tr:hover{ background:#F7FAFF; }

.subs-table tbody td{
  padding:14px 16px;font-size:13px;font-weight:500;
  color:var(--text);vertical-align:middle;
}
.subs-table tbody td:first-child{
  text-align:center;font-size:11.5px;font-weight:700;color:var(--text3);
}

/* patient cell */
.cell-avatar{
  display:flex;align-items:center;gap:10px;
}
.avatar-circle{
  width:34px;height:34px;border-radius:50%;
  background:linear-gradient(135deg,var(--blue-d),var(--blue-mid));
  display:flex;align-items:center;justify-content:center;
  font-size:12px;font-weight:800;color:#fff;
  flex-shrink:0;
}
.cell-name{ font-weight:700;color:var(--text);font-size:13.5px; }

/* plan cell */
.plan-chip{
  display:inline-flex;align-items:center;gap:5px;
  padding:5px 11px;border-radius:8px;
  background:var(--blue-l);border:1px solid rgba(45,125,210,.18);
  font-size:12px;font-weight:700;color:var(--blue);
}
.plan-chip svg{
  width:12px;height:12px;fill:none;stroke:var(--blue);
  stroke-width:2;stroke-linecap:round;stroke-linejoin:round;
}

/* date cells */
.cell-date{ font-size:13px;font-weight:600;color:var(--text); }
.cell-label{
  font-size:10px;font-weight:700;color:var(--text3);
  text-transform:uppercase;letter-spacing:.4px;margin-bottom:2px;
}

/* usage bar */
.usage-wrap{ min-width:100px; }
.usage-nums{
  display:flex;justify-content:space-between;
  font-size:11px;font-weight:700;color:var(--text3);
  margin-bottom:5px;
}
.usage-nums strong{ color:var(--text);font-weight:800; }
.usage-track{
  height:6px;border-radius:999px;
  background:rgba(45,125,210,.10);overflow:hidden;
}
.usage-bar{
  height:100%;border-radius:999px;
  background:linear-gradient(90deg,var(--blue-d),var(--blue-mid));
  transition:width 1s var(--ease);
}

/* remaining */
.remaining-num{
  font-size:18px;font-weight:800;color:var(--text);line-height:1;
}
.remaining-lbl{
  font-size:10.5px;font-weight:600;color:var(--text3);margin-top:2px;
}

/* badges */
.badge-pill{
  display:inline-flex;align-items:center;gap:5px;
  padding:4px 10px;border-radius:20px;
  font-size:11px;font-weight:700;letter-spacing:.2px;
  border:1px solid transparent;white-space:nowrap;
}
.badge-pill::before{
  content:'';width:6px;height:6px;border-radius:50%;flex-shrink:0;
}
.bp-paid,.bp-active{
  background:var(--green-bg);color:var(--green);
  border-color:rgba(22,169,106,.2);
}
.bp-paid::before,.bp-active::before{ background:var(--green); }

.bp-pending{
  background:var(--amber-bg);color:var(--amber);
  border-color:rgba(208,128,32,.2);
}
.bp-pending::before{ background:var(--amber); }

.bp-failed,.bp-cancelled{
  background:var(--rose-bg);color:var(--rose);
  border-color:rgba(229,90,107,.2);
}
.bp-failed::before,.bp-cancelled::before{ background:var(--rose); }

.bp-expired{
  background:var(--neutral-bg);color:var(--text3);
  border-color:var(--border);
}
.bp-expired::before{ background:var(--text3); }

/* empty */
.empty-row td{ padding:52px 16px;text-align:center; }
.empty-icon{
  width:50px;height:50px;background:var(--blue-l);
  border-radius:12px;display:flex;align-items:center;
  justify-content:center;margin:0 auto 14px;
}
.empty-icon svg{
  width:24px;height:24px;fill:none;stroke:var(--blue);
  stroke-width:1.6;stroke-linecap:round;stroke-linejoin:round;
}
.empty-label{ font-size:14px;font-weight:700;color:var(--text2); }
.empty-sub{ font-size:12.5px;font-weight:500;color:var(--text3);margin-top:4px; }

/* pagination */
.pagination-wrap{
  padding:16px 24px 20px;
  border-top:1px solid var(--border);background:#FAFCFF;
}
.pagination-wrap .pagination{ margin:0;gap:4px; }
.pagination-wrap .page-link{
  font-family:'Inter',sans-serif;font-size:12.5px;font-weight:600;
  color:var(--text2);border:1.5px solid var(--border);
  border-radius:8px !important;padding:6px 12px;
  background:var(--white);transition:all .2s;
}
.pagination-wrap .page-link:hover{
  background:var(--blue-l);border-color:var(--blue);color:var(--blue);
}
.pagination-wrap .page-item.active .page-link{
  background:linear-gradient(135deg,var(--blue-d),var(--blue));
  border-color:transparent;color:#fff;
  box-shadow:0 3px 10px rgba(45,125,210,.25);
}
.pagination-wrap .page-item.disabled .page-link{ opacity:.45;cursor:not-allowed; }

@media(max-width:640px){
  .subs-page{ padding:16px 14px 32px; }
  .card-top-sub{ display:none; }
}
</style>

<div class="subs-page">

  <div class="page-eyebrow">Admin Panel</div>
  <div class="page-title">Patient Plan <span>Subscriptions</span></div>

  <div class="panel">

    <div class="card-top">
      <div class="card-top-icon">
        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </div>
      <div class="card-top-title">All Subscriptions</div>
      <div class="card-top-sub">Patient plan usage &amp; payment overview</div>
    </div>

    <div class="table-wrap">
      <table class="subs-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Plan</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Usage</th>
            <th>Remaining</th>
            <th>Payment</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>

          @forelse($subscriptions as $key => $subscription)

          @php
            $used      = $subscription->used_appointments ?? 0;
            $remaining = $subscription->remaining_appointments ?? 0;
            $total     = $used + $remaining;
            $pct       = $total > 0 ? round(($used / $total) * 100) : 0;

            $initials  = collect(explode(' ', $subscription->patient->name ?? 'U'))
                           ->map(fn($w) => strtoupper(substr($w,0,1)))
                           ->take(2)->implode('');
          @endphp

          <tr>

            <td>{{ $subscriptions->firstItem() + $key }}</td>

            {{-- Patient --}}
            <td>
              <div class="cell-avatar">
                <div class="avatar-circle">{{ $initials }}</div>
                <div class="cell-name">{{ $subscription->patient->name ?? '-' }}</div>
              </div>
            </td>

            {{-- Plan --}}
            <td>
              <span class="plan-chip">
                <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                {{ $subscription->plan->name ?? '-' }}
              </span>
            </td>

            {{-- Start Date --}}
            <td>
              <div class="cell-label">From</div>
              <div class="cell-date">{{ $subscription->start_date }}</div>
            </td>

            {{-- End Date --}}
            <td>
              <div class="cell-label">Until</div>
              <div class="cell-date">{{ $subscription->end_date }}</div>
            </td>

            {{-- Usage bar --}}
            <td>
              <div class="usage-wrap">
                <div class="usage-nums">
                  <span>Used</span>
                  <strong>{{ $used }} / {{ $total }}</strong>
                </div>
                <div class="usage-track">
                  <div class="usage-bar" style="width:{{ $pct }}%"></div>
                </div>
              </div>
            </td>

            {{-- Remaining --}}
            <td>
              <div class="remaining-num">{{ $remaining }}</div>
              <div class="remaining-lbl">left</div>
            </td>

            {{-- Payment --}}
            <td>
              @if($subscription->payment_status == 'paid')
                <span class="badge-pill bp-paid">Paid</span>
              @elseif($subscription->payment_status == 'pending')
                <span class="badge-pill bp-pending">Pending</span>
              @else
                <span class="badge-pill bp-failed">{{ ucfirst($subscription->payment_status) }}</span>
              @endif
            </td>

            {{-- Status --}}
            <td>
              @if($subscription->status == 'active')
                <span class="badge-pill bp-active">Active</span>
              @elseif($subscription->status == 'expired')
                <span class="badge-pill bp-expired">Expired</span>
              @else
                <span class="badge-pill bp-cancelled">Cancelled</span>
              @endif
            </td>

          </tr>

          @empty
          <tr class="empty-row">
            <td colspan="9">
              <div class="empty-icon">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
              </div>
              <div class="empty-label">No Subscriptions Found</div>
              <div class="empty-sub">No patient plan subscriptions exist yet.</div>
            </td>
          </tr>
          @endforelse

        </tbody>
      </table>
    </div>

    <div class="pagination-wrap">
      {{ $subscriptions->links('pagination::bootstrap-5') }}
    </div>

  </div>
</div>

@endsection