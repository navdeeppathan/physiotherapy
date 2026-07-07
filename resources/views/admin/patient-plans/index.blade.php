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
  --amber:      #D08020;
  --amber-bg:   #FEF5E7;
  --teal:       #0891B2;
  --teal-bg:    #E0F5FA;
  --neutral-bg: #F2F5F8;
  --ease:       cubic-bezier(0.16,1,0.3,1);
}
*{ box-sizing:border-box; }

.plans-page{
  padding:28px 28px 48px;
  font-family:'Inter',sans-serif;
  background:var(--bg);
  min-height:100vh;
}

/* head */
.page-eyebrow{ font-size:11px;font-weight:700;color:var(--blue);text-transform:uppercase;letter-spacing:.7px;margin-bottom:4px; }
.page-title{ font-size:22px;font-weight:700;color:var(--text);letter-spacing:-.3px;margin-bottom:22px; }
.page-title span{ font-weight:300;color:var(--text2); }

/* alert */
.alert-success-bar{
  display:flex;align-items:center;gap:10px;
  background:var(--green-bg);border:1px solid rgba(22,169,106,.2);
  border-radius:10px;padding:11px 16px;margin-bottom:20px;
}
.alert-success-bar svg{ width:18px;height:18px;flex-shrink:0;fill:none;stroke:var(--green);stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }
.alert-success-bar span{ font-size:13px;font-weight:600;color:var(--green); }

/* panel */
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
.card-top{
  display:flex;align-items:center;gap:10px;
  padding:18px 24px 16px;border-bottom:1px solid var(--border);
}
.card-top-icon{
  width:34px;height:34px;background:var(--blue-l);
  border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;
}
.card-top-icon svg{ width:17px;height:17px;fill:none;stroke:var(--blue);stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round; }
.card-top-title{ font-size:14px;font-weight:700;color:var(--text); }
.card-top-right{ margin-left:auto; }

/* add plan btn */
.btn-add-plan{
  display:inline-flex;align-items:center;gap:6px;
  padding:8px 16px;border-radius:9px;
  font-family:'Inter',sans-serif;font-size:12.5px;font-weight:700;
  color:#fff;text-decoration:none;
  background:linear-gradient(135deg,var(--blue-d),var(--blue));
  box-shadow:0 3px 10px rgba(45,125,210,.25);
  transition:opacity .2s,transform .15s;
}
.btn-add-plan:hover{ opacity:.9;transform:translateY(-1px);color:#fff; }
.btn-add-plan svg{ width:13px;height:13px;fill:none;stroke:#fff;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round; }

/* table */
.table-wrap{ overflow-x:auto; }
table.plans-table{ width:100%;border-collapse:collapse; }
.plans-table thead tr{ background:#F4F8FE;border-bottom:1.5px solid var(--border); }
.plans-table thead th{
  padding:11px 16px;font-size:11px;font-weight:700;
  text-transform:uppercase;letter-spacing:.55px;
  color:var(--text3);white-space:nowrap;text-align:left;
}
.plans-table thead th:first-child{ width:48px;text-align:center; }
.plans-table tbody tr{ border-bottom:1px solid #F0F6FD;transition:background .15s; }
.plans-table tbody tr:last-child{ border-bottom:none; }
.plans-table tbody tr:hover{ background:#F7FAFF; }
.plans-table tbody td{ padding:14px 16px;font-size:13px;font-weight:500;color:var(--text);vertical-align:middle; }
.plans-table tbody td:first-child{ text-align:center;font-size:11.5px;font-weight:700;color:var(--text3); }

/* plan name cell */
.cell-plan-name{ font-weight:800;font-size:14px;color:var(--text); }

/* price */
.price-val{ font-size:16px;font-weight:800;color:var(--blue);line-height:1; }
.price-cur{ font-size:10.5px;font-weight:700;color:var(--text3);margin-bottom:2px; }

/* appts */
.appt-chip{
  display:inline-flex;align-items:center;gap:5px;
  padding:5px 10px;border-radius:8px;
  background:var(--blue-l);border:1px solid rgba(45,125,210,.18);
  font-size:12px;font-weight:700;color:var(--blue);
}
.appt-chip svg{ width:12px;height:12px;fill:none;stroke:var(--blue);stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }

/* duration badge */
.dur-badge{
  display:inline-flex;align-items:center;gap:5px;
  padding:4px 10px;border-radius:20px;
  background:var(--teal-bg);border:1px solid rgba(8,145,178,.2);
  font-size:11px;font-weight:700;color:var(--teal);
}
.dur-badge svg{ width:11px;height:11px;fill:none;stroke:var(--teal);stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }

/* status */
.badge-pill{
  display:inline-flex;align-items:center;gap:5px;
  padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;
  border:1px solid transparent;
}
.badge-pill::before{ content:'';width:6px;height:6px;border-radius:50%;flex-shrink:0; }
.bp-active{ background:var(--green-bg);color:var(--green);border-color:rgba(22,169,106,.2); }
.bp-active::before{ background:var(--green); }
.bp-inactive{ background:var(--rose-bg);color:var(--rose);border-color:rgba(229,90,107,.2); }
.bp-inactive::before{ background:var(--rose); }

/* action btns */
.action-btns{ display:flex;gap:6px;align-items:center; }
.btn-edit{
  display:inline-flex;align-items:center;gap:5px;
  padding:6px 12px;border-radius:7px;border:1.5px solid var(--border);
  font-family:'Inter',sans-serif;font-size:12px;font-weight:700;
  color:var(--blue);background:var(--blue-l);cursor:pointer;
  text-decoration:none;transition:background .15s,border-color .15s;
}
.btn-edit:hover{ background:#D4E8FA;border-color:var(--blue);color:var(--blue); }
.btn-edit svg{ width:13px;height:13px;fill:none;stroke:var(--blue);stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }
.btn-del{
  display:inline-flex;align-items:center;gap:5px;
  padding:6px 12px;border-radius:7px;border:1.5px solid rgba(229,90,107,.2);
  font-family:'Inter',sans-serif;font-size:12px;font-weight:700;
  color:var(--rose);background:var(--rose-bg);cursor:pointer;
  transition:background .15s,border-color .15s;
}
.btn-del:hover{ background:#FAD8DC;border-color:var(--rose); }
.btn-del svg{ width:13px;height:13px;fill:none;stroke:var(--rose);stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }

/* empty */
.empty-row td{ padding:52px 16px;text-align:center; }
.empty-icon{ width:50px;height:50px;background:var(--blue-l);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px; }
.empty-icon svg{ width:24px;height:24px;fill:none;stroke:var(--blue);stroke-width:1.6;stroke-linecap:round;stroke-linejoin:round; }
.empty-label{ font-size:14px;font-weight:700;color:var(--text2); }
.empty-sub{ font-size:12.5px;font-weight:500;color:var(--text3);margin-top:4px; }

/* pagination */
.pagination-wrap{ padding:16px 24px 20px;border-top:1px solid var(--border);background:#FAFCFF; }
.pagination-wrap .pagination{ margin:0;gap:4px; }
.pagination-wrap .page-link{ font-family:'Inter',sans-serif;font-size:12.5px;font-weight:600;color:var(--text2);border:1.5px solid var(--border);border-radius:8px !important;padding:6px 12px;background:var(--white);transition:all .2s; }
.pagination-wrap .page-link:hover{ background:var(--blue-l);border-color:var(--blue);color:var(--blue); }
.pagination-wrap .page-item.active .page-link{ background:linear-gradient(135deg,var(--blue-d),var(--blue));border-color:transparent;color:#fff;box-shadow:0 3px 10px rgba(45,125,210,.25); }
.pagination-wrap .page-item.disabled .page-link{ opacity:.45;cursor:not-allowed; }

@media(max-width:640px){ .plans-page{ padding:16px 14px 32px; } }
</style>

<div class="plans-page">

  <div class="page-eyebrow">Admin Panel</div>
  <div class="page-title">Patient <span>Plans</span></div>

  @if(session('success'))
    <div class="alert-success-bar">
      <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <div class="panel">

    <div class="card-top">
      <div class="card-top-icon">
        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
      </div>
      <div class="card-top-title">All Plans</div>
      <div class="card-top-right">
        <a href="{{ route('admin.patient-plans.create') }}" class="btn-add-plan">
          <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add Plan
        </a>
      </div>
    </div>

    <div class="table-wrap">
      <table class="plans-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Plan Name</th>
            <th>Original Price</th>
            <th>Discount</th>
            <th>Final Price</th>
            <th>Appointments</th>
            <th>Duration</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

          @forelse($plans as $key => $plan)
          <tr>

            <td>{{ $plans->firstItem() + $key }}</td>

            <td><div class="cell-plan-name">{{ $plan->name }}</div></td>

            {{-- <td>
              <div class="price-cur">{{ $plan->currency }}</div>
              <div class="price-val">{{ $plan->price }}</div>
            </td> --}}
            {{-- Original Price --}}
            <td>
                ₹{{ number_format($plan->original_price,2) }}
            </td>

            {{-- Discount --}}
            <td>
                @if($plan->discount_percentage > 0)

                    <span class="badge-pill bp-active">
                        {{ rtrim(rtrim($plan->discount_percentage,'0'),'.') }}%
                    </span>

                    <br>

                    <small class="text-danger">
                        -₹{{ number_format($plan->discount_amount,2) }}
                    </small>

                @else

                    <span class="text-muted">No Discount</span>

                @endif
            </td>

            {{-- Final Price --}}
            <td>
                <strong>₹{{ number_format($plan->price,2) }}</strong>
            </td>

            <td>
              <span class="appt-chip">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $plan->total_appointments }}
              </span>
            </td>

            <td>
              <span class="dur-badge">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ ucfirst(str_replace('_', ' ', $plan->duration)) }}
              </span>
            </td>

            <td>
              @if($plan->status == 'active')
                <span class="badge-pill bp-active">Active</span>
              @else
                <span class="badge-pill bp-inactive">Inactive</span>
              @endif
            </td>

            <td>
              <div class="action-btns">

                <a href="{{ route('admin.patient-plans.edit', $plan->id) }}" class="btn-edit">
                  <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                  Edit
                </a>

                <form action="{{ route('admin.patient-plans.destroy', $plan->id) }}"
                      method="POST" style="margin:0;"
                      onsubmit="return confirm('Delete this plan?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-del">
                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    Delete
                  </button>
                </form>

              </div>
            </td>

          </tr>
          @empty
          <tr class="empty-row">
            <td colspan="7">
              <div class="empty-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              </div>
              <div class="empty-label">No Plans Found</div>
              <div class="empty-sub">Create your first patient plan to get started.</div>
            </td>
          </tr>
          @endforelse

        </tbody>
      </table>
    </div>

    <div class="pagination-wrap">
      {{ $plans->links('pagination::bootstrap-5') }}
    </div>

  </div>
</div>

@endsection