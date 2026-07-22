@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f1f5f9; }

/* Fix Bootstrap 4 modal stacking context from backdrop-filter navbar */
.modal-backdrop { z-index: 99998 !important; }
.modal           { z-index: 99999 !important; }

/* Breadcrumb */
.ad-bc {
    background: linear-gradient(135deg, #0c4a6e, #0369a1);
    padding: 20px 0; position: relative;
}
.ad-bc::after { content:''; position:absolute; inset:0; background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='20' cy='20' r='20'/%3E%3C/g%3E%3C/svg%3E") repeat; }
.ad-bc-inner { max-width: 1280px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; position: relative; z-index: 1; }
.ad-bc-trail { display: flex; align-items: center; gap: 8px; font-size: 13px; color: rgba(255,255,255,.6); }
.ad-bc-trail a { color: rgba(255,255,255,.7); font-weight: 600; }
.ad-back-btn {
    display: flex; align-items: center; gap: 7px;
    background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.25);
    color: #fff; border-radius: 10px; padding: 8px 16px;
    font-size: 13px; font-weight: 700;
    transition: all .18s;
}
.ad-back-btn:hover { background: rgba(255,255,255,.22); }

/* Body */
.ad-body { max-width: 1280px; margin: 0 auto; padding: 32px 24px 56px; display: grid; grid-template-columns: 300px 1fr; gap: 24px; align-items: start; }

/* ── LEFT CARD ── */
.ad-doc-card {
    background: #fff; border: 1.5px solid #e2e8f0; border-radius: 20px;
    overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.06);
    position: sticky; top: 88px;
    display: flex; flex-direction: column; gap: 0;
}
.ad-doc-banner { height: 72px; background: linear-gradient(135deg,#0369a1,#0ea5e9); position: relative; }
.ad-doc-av-wrap { position: absolute; bottom: -36px; left: 50%; transform: translateX(-50%); }
.ad-doc-av { width: 72px; height: 72px; border-radius: 50%; border: 3px solid #fff; object-fit: cover; box-shadow: 0 4px 14px rgba(0,0,0,.15); }
.ad-doc-av-ph { width: 72px; height: 72px; border-radius: 50%; border: 3px solid #fff; background: linear-gradient(135deg,#0ea5e9,#38bdf8); color: #fff; font-size: 22px; font-weight: 900; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(0,0,0,.15); }
.ad-doc-body { padding: 46px 20px 20px; text-align: center; }
.ad-doc-name { font-size: 16px; font-weight: 800; color: #0f172a; }
.ad-doc-spec { font-size: 13px; color: #0ea5e9; font-weight: 600; margin-top: 4px; }

.ad-divider { height: 1px; background: #f1f5f9; }

.ad-info-list { padding: 16px 20px; display: flex; flex-direction: column; gap: 10px; }
.ad-info-row { display: flex; align-items: center; gap: 10px; }
.ad-info-icon { width: 32px; height: 32px; border-radius: 9px; background: #e0f2fe; color: #0ea5e9; display: flex; align-items: center; justify-content: center; font-size: 12.5px; flex-shrink: 0; }
.ad-info-lbl { font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: .05em; }
.ad-info-val { font-size: 13.5px; color: #0f172a; font-weight: 600; margin-top: 1px; }

/* Status pill */
.ad-status {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 14px; border-radius: 50px; font-size: 13px; font-weight: 700;
}
.ad-status-dot { width: 7px; height: 7px; border-radius: 50%; }
.ad-status.confirmed { background: #e0f2fe; color: #0369a1; }
.ad-status.confirmed .ad-status-dot { background: #0ea5e9; }
.ad-status.pending   { background: #fef3c7; color: #92400e; }
.ad-status.pending .ad-status-dot { background: #f59e0b; }
.ad-status.completed { background: #d1fae5; color: #065f46; }
.ad-status.completed .ad-status-dot { background: #10b981; }
.ad-status.cancelled { background: #fee2e2; color: #991b1b; }
.ad-status.cancelled .ad-status-dot { background: #ef4444; }
.ad-status.shifted   { background: #f3e8ff; color: #6b21a8; }
.ad-status.shifted .ad-status-dot { background: #a855f7; }

/* Cancel button */
.ad-cancel-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 12px 16px;
    background: #fef2f2; color: #dc2626;
    border: 1.5px solid #fecaca; border-radius: 12px;
    font-size: 14px; font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer; transition: all .18s; margin: 16px 20px; width: calc(100% - 40px);
}
.ad-cancel-btn:hover { background: #fee2e2; border-color: #f87171; }

/* ── MAIN ── */
.ad-main { display: flex; flex-direction: column; gap: 18px; }

.ad-card { background: #fff; border: 1.5px solid #e2e8f0; border-radius: 18px; overflow: hidden; box-shadow: 0 2px 14px rgba(0,0,0,.04); }
.ad-card-header { padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 10px; }
.ad-card-title { font-size: 15px; font-weight: 800; color: #0f172a; }
.ad-card-icon { width: 34px; height: 34px; border-radius: 9px; background: #e0f2fe; color: #0ea5e9; display: flex; align-items: center; justify-content: center; font-size: 14px; }
.ad-card-body { padding: 20px 24px; }

.ad-info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
.ad-field-lbl { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 5px; }
.ad-field-val { font-size: 14.5px; font-weight: 600; color: #0f172a; }

/* Review card */
.ad-review-stars { color: #f59e0b; font-size: 16px; letter-spacing: 2px; margin-bottom: 10px; }
.ad-review-text { font-size: 14.5px; color: #475569; line-height: 1.75; font-style: italic; }

/* Cancellation card */
.ad-cancel-card { border-color: #fecaca; }
.ad-cancel-card .ad-card-header { background: #fef2f2; border-bottom-color: #fecaca; }
.ad-cancel-card .ad-card-icon { background: #fee2e2; color: #dc2626; }
.ad-cancel-card .ad-card-title { color: #dc2626; }

/* Cancel modal */
.cm-modal-dialog { max-width: 480px; }
.cm-modal-content { border: none; border-radius: 20px; overflow: hidden; box-shadow: 0 24px 80px rgba(0,0,0,.18); }
.cm-modal-header { display: flex; align-items: center; gap: 10px; padding: 20px 24px; border-bottom: 1px solid #f1f5f9; }
.cm-modal-icon { width: 40px; height: 40px; border-radius: 11px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 17px; }
.cm-modal-title { font-size: 18px; font-weight: 800; color: #0f172a; margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
.cm-close-btn { margin-left: auto; background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; font-size: 18px; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.cm-modal-body { padding: 22px 24px; }
.cm-label { font-size: 12.5px; font-weight: 700; color: #475569; margin-bottom: 7px; display: block; }
.cm-select, .cm-textarea {
    width: 100%; border: 1.5px solid #e2e8f0; border-radius: 11px;
    font-size: 14px; font-family: 'Plus Jakarta Sans', sans-serif;
    color: #0f172a; background: #f8fafc; outline: none;
    transition: border-color .18s, box-shadow .18s;
}
.cm-select { height: 46px; padding: 0 14px; appearance: none; cursor: pointer; }
.cm-textarea { padding: 12px 14px; resize: vertical; min-height: 90px; margin-top: 14px; display: none; }
.cm-select:focus, .cm-textarea:focus { border-color: #0ea5e9; background: #fff; box-shadow: 0 0 0 3px rgba(14,165,233,.1); }
.cm-modal-footer { padding: 16px 24px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 10px; }
.cm-cancel-btn { padding: 10px 20px; border-radius: 10px; border: 1.5px solid #e2e8f0; background: #fff; color: #334155; font-size: 14px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer; transition: all .15s; }
.cm-cancel-btn:hover { background: #f8fafc; }
.cm-confirm-btn { padding: 10px 22px; border-radius: 10px; background: #ef4444; color: #fff; font-size: 14px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; border: none; cursor: pointer; transition: all .15s; box-shadow: 0 4px 12px rgba(239,68,68,.3); }
.cm-confirm-btn:hover { background: #dc2626; }

@media (max-width: 1024px) { .ad-body { grid-template-columns: 1fr; } .ad-doc-card { position: static; } }
@media (max-width: 640px) { .ad-body { padding: 16px 14px 32px; } .ad-info-grid { grid-template-columns: 1fr; } }
</style>

<div class="main-wrapper">
@include('layouts.header')

<div class="ad-bc">
    <div class="ad-bc-inner">
        <div class="ad-bc-trail">
            <a href="/">Home</a>
            <span style="color:rgba(255,255,255,.3)">/</span>
            <a href="{{ route('patient.dashboard') }}">Dashboard</a>
            <span style="color:rgba(255,255,255,.3)">/</span>
            <span>Appointment Details</span>
        </div>
        <a href="{{ route('patient.dashboard') }}" class="ad-back-btn">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

<div class="ad-body">

    {{-- LEFT --}}
    <aside>
        <div class="ad-doc-card">
            <div class="ad-doc-banner"></div>
            <div class="ad-doc-av-wrap">
                @if($appointment->doctor->profile_img)
                    <img src="{{ asset('uploads/profile/'.$appointment->doctor->profile_img) }}" alt="{{ $appointment->doctor->name }}" class="ad-doc-av">
                @else
                    <div class="ad-doc-av-ph">{{ strtoupper(substr($appointment->doctor->name,0,1)) }}</div>
                @endif
            </div>
            <div class="ad-doc-body">
                <div class="ad-doc-name">Dr. {{ $appointment->doctor->name }}</div>
                <div class="ad-doc-spec">{{ optional($appointment->doctor->profile->specializationdata)->name }}</div>
            </div>

            <div class="ad-divider"></div>

            <div class="ad-info-list">
                <div class="ad-info-row">
                    <div class="ad-info-icon"><i class="fa-solid fa-phone"></i></div>
                    <div>
                        <div class="ad-info-lbl">Phone</div>
                        <div class="ad-info-val">{{ $appointment->doctor->phone }}</div>
                    </div>
                </div>
                <div class="ad-info-row">
                    <div class="ad-info-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div>
                        <div class="ad-info-lbl">Address</div>
                        <div class="ad-info-val">{{ optional($appointment->doctor->profile)->clinic_address ?? '—' }}</div>
                    </div>
                </div>
                <div class="ad-info-row">
                    <div class="ad-info-icon"><i class="fa-solid fa-circle-info"></i></div>
                    <div>
                        <div class="ad-info-lbl">Status</div>
                        @php $s = $appointment->status; @endphp
                        <div class="ad-status {{ $s }}" style="margin-top:4px;display:inline-flex">
                            <span class="ad-status-dot"></span>{{ ucfirst($s) }}
                        </div>
                    </div>
                </div>
            </div>

            @if($appointment->status !== 'cancelled')
                <div class="ad-divider"></div>
                <button class="ad-cancel-btn" data-toggle="modal" data-target="#cancelModal">
                    <i class="fa-solid fa-circle-xmark"></i> Cancel Appointment
                </button>
            @endif
        </div>
    </aside>

    {{-- RIGHT --}}
    <main class="ad-main">

        {{-- Appointment Info --}}
        <div class="ad-card">
            <div class="ad-card-header">
                <div class="ad-card-icon"><i class="fa-solid fa-calendar-check"></i></div>
                <div class="ad-card-title">Appointment Information</div>
            </div>
            <div class="ad-card-body">
                <div class="ad-info-grid">
                    <div>
                        <div class="ad-field-lbl">Appointment ID</div>
                        <div class="ad-field-val" style="font-family:monospace;color:#0ea5e9">#{{ $appointment->id }}</div>
                    </div>
                    <div>
                        <div class="ad-field-lbl">Status</div>
                        <div class="ad-field-val">
                            <span class="ad-status {{ $appointment->status }}">
                                <span class="ad-status-dot"></span>{{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="ad-field-lbl">Date</div>
                        <div class="ad-field-val">{{ $appointment->appointment_date->format('d M Y') }}</div>
                    </div>
                    <div>
                        <div class="ad-field-lbl">Time</div>
                        <div class="ad-field-val">
                            {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                            — {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                        </div>
                    </div>
                    <div>
                        <div class="ad-field-lbl">Booking For</div>
                        <div class="ad-field-val">{{ ucfirst($appointment->booking_for) }}</div>
                    </div>
                    <div>
                        <div class="ad-field-lbl">Payment Status</div>
                        <div class="ad-field-val">
                            <span class="ad-status completed">
                                <span class="ad-status-dot"></span>{{ ucfirst($appointment->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Personal Info --}}
        <div class="ad-card">
            <div class="ad-card-header">
                <div class="ad-card-icon"><i class="fa-solid fa-user"></i></div>
                <div class="ad-card-title">Personal Information</div>
            </div>
            <div class="ad-card-body">
                <div class="ad-info-grid">
                    <div>
                        <div class="ad-field-lbl">Name</div>
                        <div class="ad-field-val">{{ $appointment->patient_name }}</div>
                    </div>
                    <div>
                        <div class="ad-field-lbl">Age</div>
                        <div class="ad-field-val">{{ $appointment->patient_age }} yrs</div>
                    </div>
                    <div>
                        <div class="ad-field-lbl">Gender</div>
                        <div class="ad-field-val">{{ ucfirst($appointment->patient_gender) }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Problem Description --}}
        <div class="ad-card">
            <div class="ad-card-header">
                <div class="ad-card-icon"><i class="fa-solid fa-file-medical"></i></div>
                <div class="ad-card-title">Problem Description</div>
            </div>
            <div class="ad-card-body">
                <p class="ad-field-val" style="font-weight:500;color:#475569;line-height:1.8">
                    {{ $appointment->problem_description ?: 'No description provided.' }}
                </p>
            </div>
        </div>

        {{-- Address --}}
        <div class="ad-card">
            <div class="ad-card-header">
                <div class="ad-card-icon"><i class="fa-solid fa-location-dot"></i></div>
                <div class="ad-card-title">Visit Address</div>
            </div>
            <div class="ad-card-body">
                <p class="ad-field-val" style="font-weight:500;color:#475569">
                    {{ $appointment->patient_address ?: 'No address provided.' }}
                </p>
            </div>
        </div>

        {{-- Review --}}
        @if($appointment->review)
            <div class="ad-card">
                <div class="ad-card-header">
                    <div class="ad-card-icon" style="background:#fef3c7;color:#d97706"><i class="fa-solid fa-star"></i></div>
                    <div class="ad-card-title">Your Review</div>
                </div>
                <div class="ad-card-body">
                    <div class="ad-review-stars">{{ str_repeat('★',$appointment->review->rating) }}{{ str_repeat('☆',5-$appointment->review->rating) }}</div>
                    <p class="ad-review-text">{{ $appointment->review->review }}</p>
                </div>
            </div>
        @endif

        {{-- Cancellation --}}
        @if($appointment->cancellation)
            <div class="ad-card ad-cancel-card">
                <div class="ad-card-header">
                    <div class="ad-card-icon"><i class="fa-solid fa-circle-xmark"></i></div>
                    <div class="ad-card-title">Cancellation Details</div>
                </div>
                <div class="ad-card-body">
                    <div class="ad-info-grid">
                        <div>
                            <div class="ad-field-lbl">Reason</div>
                            <div class="ad-field-val">{{ optional($appointment->cancellation->reason)->title ?? 'Other' }}</div>
                        </div>
                        <div>
                            <div class="ad-field-lbl">Cancelled By</div>
                            <div class="ad-field-val">{{ ucfirst($appointment->cancellation->cancelled_by) }}</div>
                        </div>
                        @if($appointment->cancellation->custom_reason)
                            <div style="grid-column:span 2">
                                <div class="ad-field-lbl">Details</div>
                                <div class="ad-field-val" style="font-weight:500;color:#475569">{{ $appointment->cancellation->custom_reason }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    </main>
</div>

{{-- CANCEL MODAL --}}
@if($appointment->status !== 'cancelled')
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog cm-modal-dialog modal-dialog-centered">
        <div class="modal-content cm-modal-content">
            <form method="POST" action="{{ route('patient.appointment.cancel', $appointment->id) }}">
                @csrf
                <div class="cm-modal-header">
                    <div class="cm-modal-icon"><i class="fa-solid fa-circle-xmark"></i></div>
                    <h5 class="cm-modal-title">Cancel Appointment</h5>
                    <button type="button" class="cm-close-btn" data-dismiss="modal">&times;</button>
                </div>
                <div class="cm-modal-body">
                    <label class="cm-label" for="reason_id">Select a reason</label>
                    <select name="reason_id" id="reason_id" class="cm-select" required>
                        <option value="">Choose reason…</option>
                        @foreach($reasons as $reason)
                            <option value="{{ $reason->id }}" data-title="{{ strtolower($reason->title) }}">{{ $reason->title }}</option>
                        @endforeach
                    </select>
                    <textarea name="custom_reason" id="customReason" class="cm-textarea" placeholder="Please describe the reason…" rows="4"></textarea>
                </div>
                <div class="cm-modal-footer">
                    <button type="button" class="cm-cancel-btn" data-dismiss="modal">Keep Appointment</button>
                    <button type="submit" class="cm-confirm-btn"><i class="fa-solid fa-circle-xmark"></i> Confirm Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
</div>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script>
$(function(){
    $('#reason_id').change(function(){
        const text = $(this).find(':selected').text().trim().toLowerCase();
        if (text === 'other') { $('#customReason').slideDown(); }
        else { $('#customReason').slideUp(); $('textarea[name=custom_reason]').val(''); }
    });
});
</script>

@endsection