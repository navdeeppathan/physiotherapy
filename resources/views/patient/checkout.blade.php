@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f1f5f9; color: #334155; }

/* Breadcrumb */
.co-bc {
    background: linear-gradient(135deg, #0c4a6e, #0369a1);
    padding: 20px 0; position: relative;
}
.co-bc::after {
    content:''; position:absolute; inset:0;
    background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='20' cy='20' r='20'/%3E%3C/g%3E%3C/svg%3E") repeat;
}
.co-bc-inner { max-width: 1280px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; position: relative; z-index: 1; }
.co-bc-trail { display: flex; align-items: center; gap: 8px; font-size: 13px; color: rgba(255,255,255,.6); }
.co-bc-trail a { color: rgba(255,255,255,.7); font-weight: 600; text-decoration: none; }
.co-bc-title { font-size: 20px; font-weight: 800; color: #fff; letter-spacing: -.03em; }

/* Main Layout */
.co-body {
    max-width: 1280px; margin: 0 auto;
    padding: 32px 24px 56px;
    display: grid; grid-template-columns: 1fr 380px;
    gap: 28px; align-items: start;
}

/* Common Card */
.co-card {
    background: #fff; border-radius: 20px;
    border: 1.5px solid #e2e8f0; box-shadow: 0 2px 14px rgba(0,0,0,.04);
    overflow: hidden; margin-bottom: 20px;
}
.co-card:last-child { margin-bottom: 0; }

.co-card-header {
    padding: 20px 24px; border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
}
.co-card-title {
    font-size: 16px; font-weight: 800; color: #0f172a;
    display: flex; align-items: center; gap: 10px;
}
.co-card-title i { font-size: 15px; color: #0ea5e9; }
.co-card-body { padding: 24px; }

/* Plan Highlight Box */
.co-plan-box {
    background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
    border: 1.5px solid #bae6fd; border-radius: 16px;
    padding: 20px; display: flex; flex-direction: column; gap: 14px;
}
.co-plan-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; }
.co-plan-badge {
    display: inline-flex; align-items: center; gap: 5px;
    background: #0ea5e9; color: #fff; border-radius: 50px;
    padding: 3px 12px; font-size: 11px; font-weight: 800;
    text-transform: uppercase; letter-spacing: .05em;
}
.co-plan-name { font-size: 20px; font-weight: 800; color: #0c4a6e; margin-top: 6px; }
.co-plan-price { font-size: 24px; font-weight: 900; color: #0284c7; text-align: right; }
.co-plan-details { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 10px; padding-top: 10px; border-top: 1px dashed #7dd3fc; }
.co-plan-detail-item { font-size: 12.5px; color: #0369a1; font-weight: 600; display: flex; align-items: center; gap: 6px; }

/* Address Cards */
.co-add-btn {
    display: inline-flex; align-items: center; gap: 6px;
    background: #e0f2fe; color: #0ea5e9; border: 1px solid #bae6fd;
    padding: 7px 14px; border-radius: 10px; font-size: 13px; font-weight: 700;
    cursor: pointer; transition: all .15s; text-decoration: none;
}
.co-add-btn:hover { background: #0ea5e9; color: #fff; }

.co-addr-list { display: flex; flex-direction: column; gap: 12px; }
.co-addr-card {
    border: 2px solid #e2e8f0; border-radius: 14px;
    padding: 16px; transition: all .18s; cursor: pointer;
    display: flex; align-items: flex-start; gap: 14px; background: #fff;
}
.co-addr-card:hover { border-color: #7dd3fc; }
.co-addr-card.selected { border-color: #0ea5e9; background: #f0f9ff; box-shadow: 0 4px 14px rgba(14,165,233,.12); }
.co-addr-radio { margin-top: 3px; accent-color: #0ea5e9; width: 18px; height: 18px; cursor: pointer; flex-shrink: 0; }
.co-addr-content { flex: 1; }
.co-addr-title { font-size: 14.5px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px; }
.co-addr-default { background: #d1fae5; color: #065f46; border-radius: 6px; padding: 2px 7px; font-size: 11px; font-weight: 700; }
.co-addr-text { font-size: 13px; color: #64748b; margin-top: 4px; line-height: 1.5; }
.co-addr-actions { display: flex; gap: 6px; margin-top: 10px; }
.co-addr-act-btn {
    background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569;
    border-radius: 8px; padding: 5px 12px; font-size: 12px; font-weight: 700;
    cursor: pointer; transition: all .15s; font-family: 'Plus Jakarta Sans', sans-serif;
}
.co-addr-act-btn:hover { background: #e2e8f0; color: #0f172a; }
.co-addr-act-btn.delete { color: #dc2626; border-color: #fecaca; background: #fef2f2; }
.co-addr-act-btn.delete:hover { background: #fee2e2; }

/* Problem textarea */
.co-textarea {
    width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px;
    padding: 14px; font-size: 14px; font-family: 'Plus Jakarta Sans', sans-serif;
    color: #0f172a; background: #f8fafc; outline: none; transition: all .18s;
    min-height: 100px; resize: vertical;
}
.co-textarea:focus { border-color: #0ea5e9; background: #fff; box-shadow: 0 0 0 3px rgba(14,165,233,.12); }

/* Submit Button */
.co-submit-btn {
    width: 100%; padding: 16px;
    background: linear-gradient(135deg, #0ea5e9, #38bdf8);
    color: #fff; border: none; border-radius: 14px;
    font-size: 16px; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer; box-shadow: 0 8px 24px rgba(14,165,233,.35);
    transition: all .2s; display: flex; align-items: center; justify-content: center; gap: 10px;
}
.co-submit-btn:hover { background: linear-gradient(135deg, #0284c7, #0ea5e9); transform: translateY(-1px); box-shadow: 0 12px 32px rgba(14,165,233,.45); }
.co-submit-btn:disabled { opacity: .6; cursor: not-allowed; transform: none; box-shadow: none; }

/* Right Sidebar: Summary */
.co-sidebar { position: sticky; top: 88px; display: flex; flex-direction: column; gap: 18px; }

/* Doctor Summary Header */
.co-doc-summary { display: flex; align-items: center; gap: 12px; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9; }
.co-doc-av { width: 52px; height: 52px; border-radius: 50%; object-fit: cover; border: 2px solid #e0f2fe; flex-shrink: 0; }
.co-doc-ph { width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg,#0ea5e9,#38bdf8); color:#fff; font-size: 20px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.co-doc-name { font-size: 15px; font-weight: 800; color: #0f172a; }
.co-doc-loc { font-size: 12px; color: #64748b; margin-top: 2px; display: flex; align-items: center; gap: 4px; }

/* Slot Summary Items */
.co-slots-wrap { max-height: 260px; overflow-y: auto; padding-right: 4px; display: flex; flex-direction: column; gap: 8px; margin: 16px 0; }
.co-slot-item { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 14px; display: flex; justify-content: space-between; align-items: center; }
.co-slot-date { font-size: 13px; font-weight: 700; color: #0f172a; }
.co-slot-time { font-size: 12px; font-weight: 600; color: #0ea5e9; }

/* Total Breakdown */
.co-total-box { background: #f0f9ff; border-radius: 12px; padding: 14px 16px; display: flex; flex-direction: column; gap: 8px; }
.co-total-row { display: flex; justify-content: space-between; font-size: 13px; color: #475569; }
.co-total-row.grand { font-size: 16px; font-weight: 900; color: #0c4a6e; border-top: 1px solid #bae6fd; padding-top: 8px; margin-top: 4px; }

/* Security Badge */
.co-sec-box { display: flex; align-items: center; justify-content: center; gap: 16px; color: #94a3b8; font-size: 12px; padding-top: 4px; }
.co-sec-item { display: flex; align-items: center; gap: 5px; font-weight: 600; }

/* Modals z-index */
.modal-backdrop { z-index: 99998 !important; }
.modal           { z-index: 99999 !important; }
.cm-modal-dialog { max-width: 500px; }
.cm-modal-content { border: none; border-radius: 20px; overflow: hidden; box-shadow: 0 24px 80px rgba(0,0,0,.18); }
.cm-modal-header { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px; border-bottom: 1px solid #f1f5f9; }
.cm-modal-title { font-size: 18px; font-weight: 800; color: #0f172a; font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; }
.cm-close-btn { background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; font-size: 18px; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.cm-modal-body { padding: 24px; background: #fff; }

@media (max-width: 1024px) {
    .co-body { grid-template-columns: 1fr; }
    .co-sidebar { position: static; }
}
@media (max-width: 640px) {
    .co-body { padding: 16px 14px 40px; }
    .co-plan-details { grid-template-columns: 1fr; }
}
</style>

@php
    $finalPrice = ($plan->price > 0) ? $plan->price : ($plan->original_price ?? 0);
@endphp

<div class="main-wrapper">
@include('layouts.header')

<div class="co-bc">
    <div class="co-bc-inner">
        <div class="co-bc-trail">
            <a href="/">Home</a>
            <span style="color:rgba(255,255,255,.3)">/</span>
            <a href="{{ route('doctor.booking', $doctor->id) }}">Booking</a>
            <span style="color:rgba(255,255,255,.3)">/</span>
            <span>Checkout</span>
        </div>
        <div class="co-bc-title">Checkout &amp; Confirmation</div>
    </div>
</div>

<div class="co-body">

    {{-- LEFT COLUMN: FORM & ADDRESSES --}}
    <main>
        <form action="{{ route('doctor.book') }}" method="POST" id="checkoutForm">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
            @foreach($slots as $slot)
                <input type="hidden" name="slot_ids[]" value="{{ $slot->id }}">
            @endforeach
            <input type="hidden" name="doctor_fee" value="{{ $doctor->fee->doctor_fee ?? 0 }}">
            <input type="hidden" name="booking_for" value="self">
            <input type="hidden" name="address" id="selected_address">

            {{-- 1. Selected Plan Box --}}
            <div class="co-card">
                <div class="co-card-header">
                    <div class="co-card-title"><i class="fa-solid fa-cube"></i> Selected Plan Summary</div>
                </div>
                <div class="co-card-body">
                    <div class="co-plan-box">
                        <div class="co-plan-top">
                            <div>
                                <span class="co-plan-badge"><i class="fa-solid fa-circle-check"></i> Selected Package</span>
                                <div class="co-plan-name">{{ $plan->name }}</div>
                            </div>
                            <div>
                                <div class="co-plan-price">₹{{ number_format($finalPrice, 2) }}</div>
                            </div>
                        </div>

                        @if($plan->description)
                            <div style="font-size:13.5px;color:#475569;line-height:1.6">
                                {{ $plan->description }}
                            </div>
                        @endif

                        <div class="co-plan-details">
                            <div class="co-plan-detail-item">
                                <i class="fa-solid fa-calendar-check" style="color:#0ea5e9"></i>
                                {{ $plan->total_appointments }} Total Session(s)
                            </div>
                            @if($plan->duration)
                                <div class="co-plan-detail-item">
                                    <i class="fa-solid fa-clock" style="color:#0ea5e9"></i>
                                    Validity: {{ $plan->duration }}
                                </div>
                            @endif
                            <div class="co-plan-detail-item">
                                <i class="fa-solid fa-house-medical" style="color:#0ea5e9"></i>
                                Home Visit Included
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. Address Selection --}}
            @auth
                <div class="co-card">
                    <div class="co-card-header">
                        <div class="co-card-title"><i class="fa-solid fa-location-dot"></i> Select Visit Address</div>
                        <button type="button" class="co-add-btn" data-toggle="modal" data-target="#addressModal">
                            <i class="fa-solid fa-plus"></i> Add New
                        </button>
                    </div>
                    <div class="co-card-body">
                        @php $addresses = Auth::user()->addresses; @endphp
                        @if($addresses->count() > 0)
                            <div class="co-addr-list">
                                @foreach($addresses as $address)
                                    @php
                                        $fullAddr = "{$address->address}, {$address->city}, {$address->state}, {$address->country} - {$address->postal_code}";
                                    @endphp
                                    <div class="co-addr-card {{ $address->is_default ? 'selected' : '' }}" onclick="selectAddrCard(this)">
                                        <input type="radio" name="address_id" value="{{ $fullAddr }}" class="co-addr-radio" {{ $address->is_default ? 'checked' : '' }} onchange="updateSelectedAddress(this)">
                                        <div class="co-addr-content">
                                            <div class="co-addr-title">
                                                {{ $address->address }}
                                                @if($address->is_default)
                                                    <span class="co-addr-default">Default</span>
                                                @endif
                                            </div>
                                            <div class="co-addr-text">
                                                {{ $address->city }}, {{ $address->state }}, {{ $address->country }} - {{ $address->postal_code }}
                                            </div>
                                            <div class="co-addr-actions" onclick="event.stopPropagation()">
                                                <button type="button" class="co-addr-act-btn" data-toggle="modal" data-target="#editAddressModal{{ $address->id }}">
                                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                                </button>
                                                <button type="button" class="co-addr-act-btn delete" onclick="deleteAddress({{ $address->id }})">
                                                    <i class="fa-solid fa-trash"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div style="text-align:center;padding:24px;color:#94a3b8">
                                <i class="fa-solid fa-map-location-dot" style="font-size:36px;color:#cbd5e1;margin-bottom:10px;display:block"></i>
                                <p style="font-size:14px;font-weight:600;color:#64748b">No saved address found.</p>
                                <p style="font-size:12.5px;margin-top:4px;margin-bottom:14px">Please add a visit address to complete your booking.</p>
                                <button type="button" class="co-add-btn" data-toggle="modal" data-target="#addressModal">
                                    <i class="fa-solid fa-plus"></i> Add Visit Address
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endauth

            {{-- 3. Problem Description --}}
            <div class="co-card">
                <div class="co-card-header">
                    <div class="co-card-title"><i class="fa-solid fa-notes-medical"></i> Describe Your Problem (Optional)</div>
                </div>
                <div class="co-card-body">
                    <textarea name="problem_description" class="co-textarea" placeholder="Describe your symptoms, injury details, or specific care requirements for the physiotherapist…"></textarea>
                </div>
            </div>

            {{-- Submit Action --}}
            <div style="margin-top:24px">
                @auth
                    <button type="submit" class="co-submit-btn" id="confirmPayBtn">
                        <i class="fa-solid fa-lock"></i> Confirm &amp; Pay ₹{{ number_format($finalPrice, 2) }}
                    </button>
                @else
                    <div class="co-card" style="border-color:#bae6fd;background:#f0f9ff">
                        <div class="co-card-body" style="text-align:center;padding:30px">
                            <i class="fa-solid fa-lock" style="font-size:32px;color:#0ea5e9;margin-bottom:12px;display:block"></i>
                            <h4 style="font-size:17px;font-weight:800;color:#0c4a6e;margin-bottom:6px">Login Required to Continue</h4>
                            <p style="font-size:13.5px;color:#0369a1;margin-bottom:18px">Please sign in to complete your appointment booking and secure payment.</p>
                            <a href="{{ route('login') }}" class="co-submit-btn" style="display:inline-flex;width:auto;padding:12px 32px">
                                <i class="fa-solid fa-right-to-bracket"></i> Login to Continue
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </form>
    </main>

    {{-- RIGHT COLUMN: SIDEBAR SUMMARY --}}
    <aside class="co-sidebar">
        <div class="co-card">
            <div class="co-card-header">
                <div class="co-card-title"><i class="fa-solid fa-receipt"></i> Booking Summary</div>
            </div>
            <div class="co-card-body">
                {{-- Doctor Info --}}
                <div class="co-doc-summary">
                    @if($doctor->profile_img)
                        <img src="{{ str_contains($doctor->profile_img, '/') ? asset($doctor->profile_img) : asset('uploads/profile/'.$doctor->profile_img) }}" alt="{{ $doctor->name }}" class="co-doc-av">
                    @else
                        <div class="co-doc-ph">{{ strtoupper(substr($doctor->name,0,1)) }}</div>
                    @endif
                    <div>
                        <div class="co-doc-name">Dr. {{ $doctor->name }}</div>
                        <div class="co-doc-loc">
                            <i class="fa-solid fa-location-dot" style="color:#0ea5e9"></i>
                            {{ optional($doctor->profile)->clinic_address ?? 'India' }}
                        </div>
                    </div>
                </div>

                {{-- Slot List --}}
                <div style="margin-top:16px">
                    <div style="font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px">
                        Selected Appointments ({{ $slots->count() }})
                    </div>
                    <div class="co-slots-wrap">
                        @foreach($slots as $index => $slot)
                            <div class="co-slot-item">
                                <div>
                                    <div class="co-slot-date">Session {{ $index + 1 }}</div>
                                    <div style="font-size:11.5px;color:#64748b">
                                        {{ $slot->availabilityDate->available_date->format('D, d M Y') }}
                                    </div>
                                </div>
                                <div class="co-slot-time">
                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Price Breakdown --}}
                <div class="co-total-box">
                    <div class="co-total-row">
                        <span>Package ({{ $plan->name }})</span>
                        <span>₹{{ number_format($finalPrice, 2) }}</span>
                    </div>
                    <div class="co-total-row">
                        <span>Total Sessions</span>
                        <span>{{ $slots->count() }} Session(s)</span>
                    </div>
                    <div class="co-total-row grand">
                        <span>Total Amount</span>
                        <span>₹{{ number_format($finalPrice, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Trust & Safety Card --}}
        <div class="co-sec-box">
            <div class="co-sec-item"><i class="fa-solid fa-shield-halved" style="color:#10b981"></i> 256-bit Encrypted</div>
            <div class="co-sec-item"><i class="fa-solid fa-circle-check" style="color:#0ea5e9"></i> Certified Physio</div>
        </div>
    </aside>

</div>

</div>{{-- /main-wrapper --}}

{{-- ── ADD ADDRESS MODAL ── --}}
<div class="modal fade" id="addressModal" tabindex="-1" role="dialog">
    <div class="modal-dialog cm-modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content cm-modal-content">
            <div class="cm-modal-header">
                <div class="cm-modal-title"><i class="fa-solid fa-plus-circle" style="color:#0ea5e9;margin-right:8px"></i> Add New Address</div>
                <button type="button" class="cm-close-btn" data-dismiss="modal">&times;</button>
            </div>
            <div class="cm-modal-body">
                <form action="{{ route('user.address.store') }}" method="POST">
                    @csrf
                    <div style="margin-bottom:14px">
                        <label style="font-size:12.5px;font-weight:700;color:#475569;margin-bottom:5px;display:block">Street Address / House No.</label>
                        <input type="text" class="form-control" name="address" placeholder="e.g. Flat 302, Green Apartments" required style="border-radius:10px">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px">
                        <div>
                            <label style="font-size:12.5px;font-weight:700;color:#475569;margin-bottom:5px;display:block">City</label>
                            <input type="text" class="form-control" name="city" placeholder="City" required style="border-radius:10px">
                        </div>
                        <div>
                            <label style="font-size:12.5px;font-weight:700;color:#475569;margin-bottom:5px;display:block">State</label>
                            <input type="text" class="form-control" name="state" placeholder="State" required style="border-radius:10px">
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px">
                        <div>
                            <label style="font-size:12.5px;font-weight:700;color:#475569;margin-bottom:5px;display:block">Country</label>
                            <input type="text" class="form-control" name="country" value="India" required style="border-radius:10px">
                        </div>
                        <div>
                            <label style="font-size:12.5px;font-weight:700;color:#475569;margin-bottom:5px;display:block">Postal Code</label>
                            <input type="text" class="form-control" name="postal_code" placeholder="PIN Code" required style="border-radius:10px">
                        </div>
                    </div>
                    <div class="form-check" style="margin-bottom:20px">
                        <input class="form-check-input" type="checkbox" name="is_default" value="1" id="addDefault">
                        <label class="form-check-label" for="addDefault" style="font-size:13px;font-weight:600;color:#475569">Set as Default Address</label>
                    </div>
                    <button type="submit" class="co-submit-btn" style="padding:12px">
                        <i class="fa-solid fa-check"></i> Save Address
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── EDIT ADDRESS MODALS ── --}}
@auth
    @foreach(Auth::user()->addresses as $address)
        <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog cm-modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content cm-modal-content">
                    <div class="cm-modal-header">
                        <div class="cm-modal-title"><i class="fa-solid fa-pen-to-square" style="color:#0ea5e9;margin-right:8px"></i> Edit Address</div>
                        <button type="button" class="cm-close-btn" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="cm-modal-body">
                        <form action="{{ route('user.address.update', $address->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div style="margin-bottom:14px">
                                <label style="font-size:12.5px;font-weight:700;color:#475569;margin-bottom:5px;display:block">Address</label>
                                <input class="form-control" name="address" value="{{ $address->address }}" required style="border-radius:10px">
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px">
                                <div>
                                    <label style="font-size:12.5px;font-weight:700;color:#475569;margin-bottom:5px;display:block">City</label>
                                    <input class="form-control" name="city" value="{{ $address->city }}" required style="border-radius:10px">
                                </div>
                                <div>
                                    <label style="font-size:12.5px;font-weight:700;color:#475569;margin-bottom:5px;display:block">State</label>
                                    <input class="form-control" name="state" value="{{ $address->state }}" required style="border-radius:10px">
                                </div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px">
                                <div>
                                    <label style="font-size:12.5px;font-weight:700;color:#475569;margin-bottom:5px;display:block">Country</label>
                                    <input class="form-control" name="country" value="{{ $address->country }}" required style="border-radius:10px">
                                </div>
                                <div>
                                    <label style="font-size:12.5px;font-weight:700;color:#475569;margin-bottom:5px;display:block">Postal Code</label>
                                    <input class="form-control" name="postal_code" value="{{ $address->postal_code }}" required style="border-radius:10px">
                                </div>
                            </div>
                            <div class="form-check" style="margin-bottom:20px">
                                <input type="checkbox" class="form-check-input" name="is_default" value="1" id="editDefault{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }}>
                                <label class="form-check-label" for="editDefault{{ $address->id }}" style="font-size:13px;font-weight:600;color:#475569">Set as Default Address</label>
                            </div>
                            <button type="submit" class="co-submit-btn" style="padding:12px">
                                <i class="fa-solid fa-check"></i> Update Address
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hidden Delete Form --}}
        <form id="deleteAddrForm{{ $address->id }}" action="{{ route('user.address.destroy', $address->id) }}" method="POST" style="display:none">
            @csrf @method('DELETE')
        </form>
    @endforeach
@endauth

<script>
function selectAddrCard(cardEl) {
    document.querySelectorAll('.co-addr-card').forEach(c => c.classList.remove('selected'));
    cardEl.classList.add('selected');
    const radio = cardEl.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
        updateSelectedAddress(radio);
    }
}

function updateSelectedAddress(radioEl) {
    const hiddenInput = document.getElementById('selected_address');
    if (hiddenInput && radioEl.checked) {
        hiddenInput.value = radioEl.value;
    }
}

function deleteAddress(id) {
    if (confirm('Delete this address?')) {
        const form = document.getElementById('deleteAddrForm' + id);
        if (form) form.submit();
    }
}

window.addEventListener('DOMContentLoaded', function () {
    const checkedRadio = document.querySelector('input[name="address_id"]:checked');
    if (checkedRadio) {
        updateSelectedAddress(checkedRadio);
    }

    const form = document.getElementById('checkoutForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            const addr = document.getElementById('selected_address').value;
            if (!addr) {
                e.preventDefault();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Address Required',
                        text: 'Please select or add a visit address to continue.',
                        confirmButtonColor: '#0ea5e9'
                    });
                } else {
                    alert('Please select or add a visit address to continue.');
                }
            }
        });
    }
});
</script>

@endsection