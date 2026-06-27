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
  --ease:       cubic-bezier(0.16,1,0.3,1);
}

.appt-page{
  padding:28px 28px 40px;
  font-family:'Inter',sans-serif;
  background:var(--bg);
  min-height:100vh;
}

.page-eyebrow{
  font-size:11px;font-weight:700;color:var(--blue);
  text-transform:uppercase;letter-spacing:.7px;margin-bottom:4px;
}
.page-title{
  font-size:22px;font-weight:700;color:var(--text);letter-spacing:-.3px;
}
.page-title span{ font-weight:300;color:var(--text2); }
.page-head{ display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px; }

/* card */
.appt-card{
  background:var(--white);border:1px solid var(--border);
  border-radius:16px;overflow:hidden;
  box-shadow:0 2px 8px rgba(45,125,210,.05),0 10px 32px rgba(26,91,168,.07);
  position:relative;
}
.appt-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:3px;
  background:linear-gradient(90deg,var(--blue-d),var(--blue-mid));
}

/* card top */
.card-top{
  display:flex;align-items:center;gap:10px;
  padding:20px 24px 18px;border-bottom:1px solid var(--border);
}
.card-top-icon{
  width:36px;height:36px;background:var(--blue-l);
  border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;
}
.card-top-icon svg{
  width:18px;height:18px;fill:none;stroke:var(--blue);
  stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;
}
.card-top-title{ font-size:15px;font-weight:700;color:var(--text); }
.card-top-sub{ font-size:12px;font-weight:500;color:var(--text3);margin-left:auto; }

/* filter bar */
.filter-bar{
  display:flex;align-items:center;gap:10px;
  padding:18px 24px;border-bottom:1px solid var(--border);
  flex-wrap:wrap;background:#FAFCFF;
}
.filter-field{
  position:relative;flex:1;min-width:160px;max-width:280px;
}
.filter-field-icon{
  position:absolute;left:11px;top:50%;transform:translateY(-50%);
  width:16px;height:16px;pointer-events:none;
}
.filter-field-icon svg{
  width:16px;height:16px;fill:none;stroke:var(--text3);
  stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;
}
.filter-field input,.filter-field select{
  width:100%;background:var(--white);border:1.5px solid var(--border);
  border-radius:9px;padding:9px 12px 9px 34px;
  font-family:'Inter',sans-serif;font-size:13px;font-weight:500;
  color:var(--text);outline:none;appearance:none;
  transition:border-color .2s var(--ease),box-shadow .2s var(--ease);
}
.filter-field input::placeholder{ color:var(--text3); }
.filter-field input:focus,.filter-field select:focus{
  border-color:var(--blue);box-shadow:0 0 0 3px rgba(45,125,210,.10);
}
.filter-field select{
  padding-right:32px;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238FA8C4' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
  background-repeat:no-repeat;background-position:right 10px center;
}
.btn-filter{
  background:linear-gradient(135deg,var(--blue-d),var(--blue));
  border:none;border-radius:9px;padding:9px 20px;
  font-family:'Inter',sans-serif;font-size:13px;font-weight:700;color:#fff;
  cursor:pointer;display:flex;align-items:center;gap:6px;white-space:nowrap;
  transition:opacity .2s,box-shadow .2s;
  box-shadow:0 3px 10px rgba(45,125,210,.25);
}
.btn-filter:hover{ opacity:.9;box-shadow:0 5px 16px rgba(45,125,210,.35); }
.btn-filter svg{
  width:14px;height:14px;fill:none;stroke:#fff;
  stroke-width:2;stroke-linecap:round;stroke-linejoin:round;
}

/* table */
.table-wrap{ overflow-x:auto;padding:0 0 2px; }
table.appt-table{ width:100%;border-collapse:collapse; }
.appt-table thead tr{
  background:#F4F8FE;border-bottom:1.5px solid var(--border);
}
.appt-table thead th{
  padding:11px 16px;font-size:11px;font-weight:700;
  text-transform:uppercase;letter-spacing:.55px;
  color:var(--text3);white-space:nowrap;text-align:left;
}
.appt-table thead th:first-child{ width:52px;text-align:center; }
.appt-table tbody tr{
  border-bottom:1px solid #F0F6FD;transition:background .15s;
}
.appt-table tbody tr:last-child{ border-bottom:none; }
.appt-table tbody tr:hover{ background:#F7FAFF; }
.appt-table tbody td{
  padding:13px 16px;font-size:13.5px;font-weight:500;
  color:var(--text);vertical-align:middle;
}
.appt-table tbody td:first-child{
  text-align:center;font-size:12px;font-weight:700;color:var(--text3);
}
.cell-name{ font-weight:700;color:var(--text);font-size:13.5px; }
.cell-date{ font-size:13px;font-weight:600;color:var(--text); }
.cell-sub{ font-size:11.5px;font-weight:500;color:var(--text3);margin-top:2px; }
.cell-reason{
  font-size:13px;font-weight:500;color:var(--text2);
  max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
}

/* badges */
.badge-pill{
  display:inline-flex;align-items:center;gap:5px;
  padding:4px 10px;border-radius:20px;
  font-size:11px;font-weight:700;letter-spacing:.2px;
  white-space:nowrap;border:1px solid transparent;
}
.badge-pill::before{
  content:'';width:6px;height:6px;border-radius:50%;flex-shrink:0;
}
.bp-approved{ background:var(--green-bg);color:var(--green);border-color:rgba(22,169,106,.2); }
.bp-approved::before{ background:var(--green); }
.bp-pending{ background:var(--amber-bg);color:var(--amber);border-color:rgba(208,128,32,.2); }
.bp-pending::before{ background:var(--amber); }
.bp-rejected{ background:var(--rose-bg);color:var(--rose);border-color:rgba(229,90,107,.2); }
.bp-rejected::before{ background:var(--rose); }

/* action buttons */
.btn-review{
  display:inline-flex;align-items:center;gap:5px;
  padding:6px 13px;border-radius:8px;
  font-family:'Inter',sans-serif;font-size:12px;font-weight:700;
  color:#fff;text-decoration:none;
  background:linear-gradient(135deg,var(--blue-d),var(--blue));
  box-shadow:0 2px 8px rgba(45,125,210,.25);
  transition:opacity .2s,transform .15s;border:none;cursor:pointer;
}
.btn-review svg{
  width:13px;height:13px;fill:none;stroke:#fff;
  stroke-width:2;stroke-linecap:round;stroke-linejoin:round;
}
.btn-review:hover{ opacity:.88;transform:translateY(-1px); }
.btn-closed{
  display:inline-flex;align-items:center;gap:5px;
  padding:6px 13px;border-radius:8px;
  font-family:'Inter',sans-serif;font-size:12px;font-weight:700;
  color:var(--text3);background:#F0F4F8;border:1.5px solid var(--border);
  cursor:not-allowed;opacity:.7;
}

/* empty */
.empty-row td{ padding:48px 16px;text-align:center; }
.empty-icon{
  width:48px;height:48px;background:var(--blue-l);
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
  color:var(--text2);border:1.5px solid var(--border);border-radius:8px !important;
  padding:6px 12px;background:var(--white);transition:all .2s;
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
  .appt-page{ padding:16px 14px 32px; }
  .filter-field{ max-width:100%; }
  .card-top-sub{ display:none; }
}
</style>

<div class="appt-page">

  <div class="page-head">
    <div>
      <div class="page-eyebrow">Admin Panel</div>
      <div class="page-title">Transfer <span>Requests</span></div>
    </div>
  </div>

  <div class="appt-card">

    <div class="card-top">
      <div class="card-top-icon">
        <svg viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
      </div>
      <div class="card-top-title">Appointment Transfer Requests</div>
      <div class="card-top-sub">Review &amp; act on doctor transfer requests</div>
    </div>

    <form method="GET" class="filter-bar">
      <div class="filter-field">
        <span class="filter-field-icon">
          <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </span>
        <input type="text" name="search" placeholder="Search doctor…" value="{{ request('search') }}">
      </div>

      <div class="filter-field">
        <span class="filter-field-icon">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </span>
        <select name="status">
          <option value="">All Status</option>
          <option value="pending"  {{ request('status')=='pending'  ? 'selected':'' }}>Pending</option>
          <option value="approved" {{ request('status')=='approved' ? 'selected':'' }}>Approved</option>
          <option value="rejected" {{ request('status')=='rejected' ? 'selected':'' }}>Rejected</option>
        </select>
      </div>

      <button type="submit" class="btn-filter">
        <svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
        Filter
      </button>
    </form>

    <div class="table-wrap">
      <table class="appt-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Doctor</th>
            <th>From</th>
            <th>To</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Requested On</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($requests as $key => $request)
          <tr>
            <td>{{ $requests->firstItem() + $key }}</td>

            <td><div class="cell-name">{{ $request->doctor->name ?? 'N/A' }}</div></td>

            <td><div class="cell-date">{{ \Carbon\Carbon::parse($request->from_date)->format('d M Y') }}</div></td>

            <td><div class="cell-date">{{ \Carbon\Carbon::parse($request->to_date)->format('d M Y') }}</div></td>

            <td><div class="cell-reason" title="{{ $request->reason }}">{{ $request->reason }}</div></td>

            <td>
              @if($request->status == 'approved')
                <span class="badge-pill bp-approved">{{ ucfirst($request->status) }}</span>
              @elseif($request->status == 'pending')
                <span class="badge-pill bp-pending">{{ ucfirst($request->status) }}</span>
              @else
                <span class="badge-pill bp-rejected">{{ ucfirst($request->status) }}</span>
              @endif
            </td>

            <td><div class="cell-date">{{ $request->created_at->format('d M Y') }}</div></td>

            <td>
              @if($request->status == 'pending')
                <a href="{{ route('admin.appointment-transfer-requests.show', $request->id) }}" class="btn-review">
                  <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                  Review
                </a>
              @else
                <span class="btn-closed">Closed</span>
              @endif
            </td>
          </tr>
          @empty
          <tr class="empty-row">
            <td colspan="8">
              <div class="empty-icon">
                <svg viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
              </div>
              <div class="empty-label">No Requests Found</div>
              <div class="empty-sub">Try adjusting your filters or check back later.</div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="pagination-wrap">
      {{ $requests->links('pagination::bootstrap-5') }}
    </div>

  </div>
</div>

@endsection