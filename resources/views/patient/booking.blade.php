@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f1f5f9; }

/* ── Fix Bootstrap 4 modal z-index stacking context (backdrop-filter conflict) ── */
.modal-backdrop { z-index: 99998 !important; }
.modal           { z-index: 99999 !important; }

/* Breadcrumb */
.bk-breadcrumb {
    background: linear-gradient(135deg, #0c4a6e, #0369a1);
    padding: 20px 0; position: relative;
}
.bk-breadcrumb::after { content:''; position:absolute; inset:0; background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='20' cy='20' r='20'/%3E%3C/g%3E%3C/svg%3E") repeat; }
.bk-bc-inner { max-width: 1280px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; position: relative; z-index: 1; }
.bk-bc-trail { display: flex; align-items: center; gap: 8px; font-size: 13px; color: rgba(255,255,255,.6); }
.bk-bc-trail a { color: rgba(255,255,255,.7); font-weight: 600; }
.bk-bc-title { font-size: 20px; font-weight: 800; color: #fff; letter-spacing: -.03em; }

/* Body grid */
.bk-body { max-width: 1280px; margin: 0 auto; padding: 32px 24px 56px; display: grid; grid-template-columns: 300px 1fr; gap: 24px; align-items: start; }

/* ── DOCTOR SIDEBAR ── */
.bk-doc-card {
    background: #fff; border-radius: 20px;
    border: 1.5px solid #e2e8f0; overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    position: sticky; top: 88px;
}
.bk-doc-banner { height: 72px; background: linear-gradient(135deg,#0369a1,#0ea5e9); position: relative; }
.bk-doc-av-wrap { position: absolute; bottom: -36px; left: 50%; transform: translateX(-50%); }
.bk-doc-av { width: 72px; height: 72px; border-radius: 50%; border: 3px solid #fff; object-fit: cover; box-shadow: 0 4px 14px rgba(0,0,0,.15); }
.bk-doc-av-placeholder { width: 72px; height: 72px; border-radius: 50%; border: 3px solid #fff; background: linear-gradient(135deg,#0ea5e9,#38bdf8); color: #fff; font-size: 22px; font-weight: 900; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(0,0,0,.15); }
.bk-doc-body { padding: 48px 20px 24px; text-align: center; }
.bk-doc-name { font-size: 16px; font-weight: 800; color: #0f172a; }
.bk-doc-spec { font-size: 12.5px; color: #0ea5e9; font-weight: 600; margin-top: 4px; }
.bk-doc-meta { display: flex; flex-direction: column; gap: 10px; margin-top: 18px; }
.bk-doc-meta-item { display: flex; align-items: center; gap: 10px; font-size: 13px; color: #475569; }
.bk-doc-meta-item i { width: 28px; height: 28px; background: #e0f2fe; color: #0ea5e9; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; }

/* ── BOOKING MAIN ── */
.bk-main { display: flex; flex-direction: column; gap: 20px; }

.bk-card { background: #fff; border-radius: 20px; border: 1.5px solid #e2e8f0; box-shadow: 0 2px 16px rgba(0,0,0,.04); overflow: hidden; }
.bk-card-header { padding: 20px 24px 0; }
.bk-card-title { font-size: 17px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px; }
.bk-card-title i { font-size: 16px; color: #0ea5e9; }
.bk-card-sub { font-size: 13px; color: #64748b; margin-top: 4px; }
.bk-card-body { padding: 20px 24px 24px; }

/* Date group */
.bk-date-group { margin-bottom: 28px; }
.bk-date-label {
    display: inline-flex; align-items: center; gap: 8px;
    background: #f0f9ff; color: #0369a1;
    border: 1px solid #bae6fd; border-radius: 10px;
    padding: 7px 16px; font-size: 13px; font-weight: 800;
    margin-bottom: 14px;
}
.bk-date-label i { font-size: 13px; }

/* Slot grid */
.bk-slot-grid { display: flex; flex-wrap: wrap; gap: 10px; }
.bk-slot {
    padding: 9px 16px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 13.5px; font-weight: 600; color: #334155;
    cursor: pointer; transition: all .18s;
    background: #f8fafc;
    display: flex; align-items: center; gap: 6px;
    user-select: none;
}
.bk-slot i { font-size: 12px; color: #94a3b8; }
.bk-slot:hover { border-color: #7dd3fc; background: #e0f2fe; color: #0369a1; }
.bk-slot.selected { background: linear-gradient(135deg,#0ea5e9,#38bdf8); border-color: transparent; color: #fff; box-shadow: 0 4px 12px rgba(14,165,233,.3); }
.bk-slot.selected i { color: rgba(255,255,255,.8); }
.bk-slot.booked { background: #f8fafc; border-color: #e2e8f0; color: #cbd5e1; cursor: not-allowed; opacity: .55; }
.bk-slot.booked:hover { border-color: #e2e8f0; background: #f8fafc; color: #cbd5e1; }

.bk-no-slots { color: #94a3b8; font-size: 14px; font-style: italic; padding: 8px 0; }

/* Selected counter */
.bk-selection-bar {
    background: #f0f9ff; border: 1.5px solid #bae6fd;
    border-radius: 14px; padding: 14px 20px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 12px; flex-wrap: wrap;
}
.bk-selection-count { font-size: 14px; font-weight: 700; color: #0369a1; }
.bk-selection-count span { font-size: 20px; font-weight: 900; color: #0ea5e9; }

/* Proceed btn */
.bk-proceed-btn {
    display: flex; align-items: center; justify-content: center; gap: 10px;
    width: 100%; padding: 16px;
    background: linear-gradient(135deg,#0ea5e9,#38bdf8);
    color: #fff; border: none; border-radius: 14px;
    font-size: 16px; font-weight: 800;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(14,165,233,.35);
    transition: all .2s;
}
.bk-proceed-btn:hover { background: linear-gradient(135deg,#0284c7,#0ea5e9); box-shadow: 0 12px 32px rgba(14,165,233,.45); transform: translateY(-1px); }

/* ── PLAN MODAL ── */
.pm-modal-dialog { max-width: 700px; }
.pm-modal-content { border: none; border-radius: 20px; overflow: hidden; box-shadow: 0 24px 80px rgba(0,0,0,.18); }
.pm-modal-header { display: flex; align-items: center; justify-content: space-between; padding: 22px 28px; border-bottom: 1px solid #f1f5f9; }
.pm-modal-title { font-size: 20px; font-weight: 800; color: #0f172a; letter-spacing: -.03em; font-family: 'Plus Jakarta Sans', sans-serif; }
.pm-close-btn { background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; font-size: 18px; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .15s; }
.pm-close-btn:hover { background: #e2e8f0; color: #0f172a; }
.pm-modal-body { padding: 24px 28px; background: #f8fafc; max-height: 65vh; overflow-y: auto; }
.pm-modal-footer { padding: 18px 28px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; }

.pm-plan-list { display: flex; flex-direction: column; gap: 14px; }
.pm-plan-card {
    display: flex; align-items: flex-start; gap: 16px;
    background: #fff; border: 2px solid #e2e8f0;
    border-radius: 16px; padding: 20px; cursor: pointer;
    transition: all .22s;
}
.pm-plan-card:hover { border-color: #7dd3fc; box-shadow: 0 8px 24px rgba(14,165,233,.1); }
.pm-plan-card.active { border-color: #0ea5e9; background: #f0f9ff; box-shadow: 0 8px 24px rgba(14,165,233,.18); }

.pm-radio { width: 22px; height: 22px; border-radius: 50%; border: 2px solid #d1d5db; position: relative; flex-shrink: 0; margin-top: 2px; transition: all .18s; }
.pm-plan-card.active .pm-radio { border-color: #0ea5e9; }
.pm-plan-card.active .pm-radio::after { content:''; position:absolute; width:11px; height:11px; background:#0ea5e9; border-radius:50%; left:50%; top:50%; transform:translate(-50%,-50%); }

.pm-plan-content { flex: 1; }
.pm-plan-top { display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 8px; flex-wrap: wrap; }
.pm-plan-name { font-size: 17px; font-weight: 800; color: #0f172a; font-family: 'Plus Jakarta Sans', sans-serif; }
.pm-plan-price { font-size: 22px; font-weight: 900; color: #0f172a; font-family: 'Plus Jakarta Sans', sans-serif; }
.pm-plan-bottom { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.pm-session-price { font-size: 13px; color: #64748b; }
.pm-discount-badge { background: #d1fae5; color: #065f46; border-radius: 8px; padding: 3px 10px; font-size: 12px; font-weight: 700; }
.pm-old-price { text-decoration: line-through; color: #94a3b8; font-size: 13px; }

.pm-continue-btn {
    display: flex; align-items: center; gap: 8px;
    background: linear-gradient(135deg,#0ea5e9,#38bdf8);
    color: #fff; border: none; border-radius: 12px;
    padding: 12px 28px; font-size: 15px; font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer; transition: all .18s;
    box-shadow: 0 6px 18px rgba(14,165,233,.3);
}
.pm-continue-btn:hover { background: linear-gradient(135deg,#0284c7,#0ea5e9); }

@media (max-width: 1024px) { .bk-body { grid-template-columns: 1fr; } .bk-doc-card { position: static; } }
@media (max-width: 560px) { .bk-body { padding: 16px 14px; } .bk-slot-grid { gap: 8px; } }
</style>

<div class="main-wrapper">
@include('layouts.header')

<div class="bk-breadcrumb">
    <div class="bk-bc-inner">
        <div class="bk-bc-trail">
            <a href="/">Home</a>
            <span style="color:rgba(255,255,255,.3)">/</span>
            <a href="{{ route('doctor.profile', $doctor->id) }}">Dr. {{ $doctor->name }}</a>
            <span style="color:rgba(255,255,255,.3)">/</span>
            <span>Book Appointment</span>
        </div>
        <div class="bk-bc-title">Book Appointment</div>
    </div>
</div>

<div class="bk-body">

    {{-- SIDEBAR --}}
    <aside>
        <div class="bk-doc-card">
            <div class="bk-doc-banner"></div>
            <div class="bk-doc-av-wrap">
                @if($doctor->profile_img)
                    <img src="{{ str_contains($doctor->profile_img, '/') ? asset($doctor->profile_img) : asset('uploads/profile/'.$doctor->profile_img) }}" alt="{{ $doctor->name }}" class="bk-doc-av">
                @else
                    <div class="bk-doc-av-placeholder">{{ strtoupper(substr($doctor->name,0,1)) }}</div>
                @endif
            </div>
            <div class="bk-doc-body">
                <div class="bk-doc-name">Dr. {{ $doctor->name }}</div>
                <div class="bk-doc-spec">{{ optional(optional($doctor->profile)->specializationdata)->name ?? 'Physiotherapist' }}{{ optional($doctor->profile)->qualification ? ', '.optional($doctor->profile)->qualification : '' }}</div>
                <div class="bk-doc-meta">
                    <div class="bk-doc-meta-item">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ optional($doctor->profile)->clinic_address ?? '—' }}
                    </div>
                    <div class="bk-doc-meta-item">
                        <i class="fa-regular fa-clock"></i>
                        {{ optional($doctor->profile)->experience_years ?? 0 }} Years Experience
                    </div>
                </div>
            </div>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="bk-main">

        {{-- Slot Selection --}}
        <div class="bk-card">
            <div class="bk-card-header">
                <div class="bk-card-title"><i class="fa-solid fa-calendar-days"></i> Select Appointment Slots</div>
                <div class="bk-card-sub">Choose one or more available time slots below. Click a slot to select or deselect it.</div>
            </div>
            <div class="bk-card-body">

                @if($doctor->availabilityDates->isEmpty())
                    <div style="text-align:center;padding:40px;color:#94a3b8">
                        <i class="fa-regular fa-calendar-xmark" style="font-size:40px;margin-bottom:14px;display:block;color:#cbd5e1"></i>
                        <p style="font-size:15px;font-weight:600;color:#64748b">No slots available at this time.</p>
                        <p style="font-size:13px;margin-top:6px">Please check back later or contact the clinic.</p>
                    </div>
                @else
                    @foreach($doctor->availabilityDates as $availability)
                        <div class="bk-date-group">
                            <div class="bk-date-label">
                                <i class="fa-regular fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($availability->available_date)->format('l, d M Y') }}
                            </div>
                            <div class="bk-slot-grid">
                                @forelse($availability->timeSlots as $slot)
                                    <div class="bk-slot {{ $slot->is_booked ? 'booked' : '' }}"
                                         data-slot-id="{{ $slot->id }}"
                                         @if($slot->is_booked) title="Already booked" @endif>
                                        <i class="fa-regular fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}
                                        @if($slot->is_booked)
                                            <i class="fa-solid fa-ban" style="color:#f87171;margin-left:2px;font-size:11px"></i>
                                        @endif
                                    </div>
                                @empty
                                    <span class="bk-no-slots">No slots for this date.</span>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>

        {{-- Selection summary + Proceed --}}
        <div class="bk-card">
            <div class="bk-card-body" style="padding-top:20px">
                <div class="bk-selection-bar" style="margin-bottom:16px">
                    <div class="bk-selection-count">
                        <span id="slotCount">0</span> slot(s) selected
                    </div>
                    <div style="font-size:13px;color:#64748b">Select slots, then choose a plan to proceed</div>
                </div>
                <input type="hidden" id="doctor_id" value="{{ $doctor->id }}">
                @auth
                    <button id="proceedPayment" class="bk-proceed-btn">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Proceed to Choose Plan
                    </button>
                @else
                    <a href="{{ route('login') }}" class="bk-proceed-btn" style="display:flex">
                        <i class="fa-solid fa-right-to-bracket"></i> Login to Continue
                    </a>
                @endauth
            </div>
        </div>

    </main>
</div>

</div>{{-- /main-wrapper --}}

{{-- ── PLAN MODAL (outside main-wrapper to avoid stacking context) ── --}}
<div class="modal fade" id="planModal" tabindex="-1" role="dialog" aria-labelledby="planModalTitle" aria-hidden="true">
    <div class="modal-dialog pm-modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content pm-modal-content">
            <div class="pm-modal-header">
                <div class="pm-modal-title" id="planModalTitle">Choose Your Plan</div>
                <button type="button" class="pm-close-btn" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="pm-modal-body">
                <div class="pm-plan-list">
                    @foreach($patientPlans as $plan)
                        @php $perSession = $plan->total_appointments > 0 ? $plan->price / $plan->total_appointments : 0; @endphp
                        <div class="pm-plan-card" data-id="{{ $plan->id }}" data-total="{{ $plan->total_appointments }}">
                            <div class="pm-radio"></div>
                            <div class="pm-plan-content">
                                <div class="pm-plan-top">
                                    <div class="pm-plan-name">{{ $plan->name }}</div>
                                    <div class="pm-plan-price">₹{{ number_format($plan->price,2) }}</div>
                                </div>
                                <div class="pm-plan-bottom">
                                    <span class="pm-session-price">₹{{ number_format($perSession,0) }} per session &middot; {{ $plan->total_appointments }} session(s)</span>
                                    @if($plan->discount_percentage > 0)
                                        <span class="pm-old-price">₹{{ number_format($plan->original_price,2) }}</span>
                                        <span class="pm-discount-badge">{{ rtrim(rtrim($plan->discount_percentage,'0'),'.') }}% Off</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="pm-modal-footer">
                <button type="button" class="pm-close-btn-text" data-dismiss="modal">Cancel</button>
                <button type="button" class="pm-continue-btn" id="continuePlan" style="display:none">
                    Continue <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.sj-swal { font-family: 'Plus Jakarta Sans', sans-serif !important; border-radius: 16px !important; }
.pm-close-btn-text { background: #f1f5f9; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 10px 20px; font-size: 14px; font-weight: 700; color: #64748b; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; transition: all .15s; }
.pm-close-btn-text:hover { background: #e2e8f0; }
</style>

<script>
window.addEventListener('DOMContentLoaded', function () {
    var selectedSlots = [];
    var selectedPlan  = null;

    /* ── Slot selection ── */
    $(document).on('click', '.bk-slot', function () {
        if ($(this).hasClass('booked')) return;
        var id = $(this).data('slot-id');
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            selectedSlots = selectedSlots.filter(function(x){ return x != id; });
        } else {
            $(this).addClass('selected');
            selectedSlots.push(id);
        }
        $('#slotCount').text(selectedSlots.length);
    });

    /* ── Proceed button ── */
    $('#proceedPayment').on('click', function () {
        if (selectedSlots.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Slot Selected',
                text: 'Please select at least one time slot to continue.',
                confirmButtonColor: '#0ea5e9',
                customClass: { popup: 'sj-swal' }
            });
            return;
        }
        /* Bootstrap 4 modal open */
        $('#planModal').modal('show');
    });

    /* ── Plan card selection ── */
    $(document).on('click', '.pm-plan-card', function () {
        $('.pm-plan-card').removeClass('active');
        $(this).addClass('active');
        selectedPlan = this;
        $('#continuePlan').css('display', 'inline-flex').show();
    });

    /* ── Continue / proceed to payment ── */
    $('#continuePlan').on('click', function () {
        if (!selectedPlan) return;
        var total = parseInt($(selectedPlan).data('total'));
        if (selectedSlots.length !== total) {
            Swal.fire({
                icon: 'info',
                title: 'Appointment Count Mismatch',
                html: '<p><strong>' + $(selectedPlan).find('.pm-plan-name').text() + '</strong> includes <strong>' + total + '</strong> appointment(s).</p>' +
                      '<p>You selected <strong>' + selectedSlots.length + '</strong>. Please select exactly <strong>' + total + '</strong> slot(s).</p>',
                confirmButtonColor: '#0ea5e9',
                customClass: { popup: 'sj-swal' }
            });
            return;
        }
        var doctorId = $('#doctor_id').val();
        var planId   = $(selectedPlan).data('id');
        window.location.href = "{{ route('doctor.payment') }}" +
            '?doctor_id=' + encodeURIComponent(doctorId) +
            '&plan_id='   + encodeURIComponent(planId) +
            '&slots='     + encodeURIComponent(selectedSlots.join(','));
    });
});
</script>

@endsection