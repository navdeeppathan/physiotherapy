@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@php
    $cleanDoctorName = preg_replace('/^(dr\.?|doctor)\s+/i', '', trim($doctor->name));
    $specName = optional(optional($doctor->profile)->specializationdata)->name ?? 'Back Pain';
    $expYears = optional($doctor->profile)->experience_years ?? 10;
    $rating = round(optional($doctor->profile)->rating ?? 4.8, 1);
    $reviewsCount = 120;

    // Fees
    $doctorFee = (float) (optional($doctor->fee)->doctor_fee ?? 800);
    $adminFee  = (float) (optional($doctor->fee)->admin_fee ?? 179);
    $totalFee  = (float) (optional($doctor->fee)->total_fee ?? ($doctorFee + $adminFee));
    if ($totalFee <= 0) {
        $totalFee = 979;
    }

    // User addresses
    $userAddresses = \Illuminate\Support\Facades\Auth::check() 
        ? \App\Models\UserAddress::where('user_id', \Illuminate\Support\Facades\Auth::id())->latest()->get() 
        : collect();

    // Upcoming dates
    $calendarDays = [];
    $startDate = \Carbon\Carbon::now();
    for ($i = 0; $i < 7; $i++) {
        $day = $startDate->copy()->addDays($i);
        $calendarDays[] = [
            'dayName' => $day->format('D'),
            'dateNum' => $day->format('d'),
            'fullDate' => $day->format('d-m-Y'),
            'dbDate'   => $day->format('Y-m-d'),
            'isSelected' => $i === 6, // 20th active as shown in screenshot
        ];
    }
@endphp

<style>
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   STEP FORM THEME (Pixel-Perfect to Design Mockup)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
:root {
    --primary-teal:      #0c6978;
    --primary-teal-dark: #074752;
    --primary-teal-sub:  #108598;
    --teal-bg-soft:      #eef8f9;
    --teal-badge-bg:     #e2f4f6;
    --teal-badge-border: #bce5ea;
    --accent-green:      #10b981;
    --gold:              #f59e0b;
    --ink:               #0f172a;
    --body-text:         #475569;
    --muted-text:        #64748b;
    --border-card:       #eef2f6;
    --page-bg:           #f8fafc;
    --card-bg:           #ffffff;
    --shadow-card:       0 2px 14px rgba(15, 23, 42, 0.04);
}

*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: var(--body-text);
    background-color: var(--page-bg);
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
}

a {
    text-decoration: none;
    color: inherit;
}

.bk-page-wrap {
    min-height: 100vh;
    padding-bottom: 60px;
}

.bk-container {
    max-width: 1180px;
    margin: 0 auto;
    padding: 16px 20px 40px;
}

/* ── BREADCRUMB ── */
.bk-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--muted-text);
    margin-bottom: 24px;
}
.bk-breadcrumb a {
    color: var(--muted-text);
}
.bk-breadcrumb a:hover {
    color: var(--primary-teal);
}
.bk-bc-sep {
    color: #cbd5e1;
    font-size: 11px;
}
.bk-bc-current {
    color: var(--ink);
    font-weight: 700;
}

/* ── STEPPER BAR (4 STEPS) ── */
.bk-stepper-wrap {
    max-width: 760px;
    margin: 0 auto 36px;
}
.bk-stepper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
}
.bk-step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
    cursor: pointer;
}
.bk-step-circle {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #ffffff;
    border: 2px solid #e2e8f0;
    color: #94a3b8;
    font-weight: 800;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.25s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
}
.bk-step-lbl {
    font-size: 13px;
    font-weight: 600;
    color: #94a3b8;
    margin-top: 8px;
    white-space: nowrap;
    transition: all 0.25s ease;
}
.bk-step-item.active .bk-step-circle {
    background: var(--primary-teal);
    border-color: var(--primary-teal);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(12, 105, 120, 0.25);
}
.bk-step-item.active .bk-step-lbl {
    color: var(--primary-teal);
    font-weight: 800;
}
.bk-step-item.completed .bk-step-circle {
    background: var(--primary-teal-dark);
    border-color: var(--primary-teal-dark);
    color: #ffffff;
}
.bk-step-item.completed .bk-step-lbl {
    color: var(--ink);
    font-weight: 700;
}

/* Stepper Connecting Lines */
.bk-step-line {
    flex: 1;
    height: 2px;
    background: #e2e8f0;
    margin: 0 12px;
    margin-top: -24px;
    position: relative;
    z-index: 1;
    transition: background 0.3s;
}
.bk-step-line.filled {
    background: var(--primary-teal);
}

/* ── 2-COLUMN MAIN LAYOUT ── */
.bk-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 24px;
    align-items: start;
}

/* ── CARDS & PANELS ── */
.bk-main-panel {
    background: var(--card-bg);
    border: 1px solid var(--border-card);
    border-radius: 20px;
    padding: 30px;
    box-shadow: var(--shadow-card);
}
.bk-step-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.02em;
    margin-bottom: 4px;
}
.bk-step-desc {
    font-size: 13.5px;
    color: var(--muted-text);
    margin-bottom: 24px;
}

/* ── STEP 1: CHOOSE PACKAGE CARDS ── */
.bk-packages-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
    margin-bottom: 24px;
}
.bk-pkg-card {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}
.bk-pkg-card:hover {
    border-color: var(--primary-teal);
    background: #fbfdfd;
}
.bk-pkg-card.selected {
    border-color: #14b8a6;
    background: #ffffff;
    box-shadow: 0 4px 18px rgba(20, 184, 166, 0.1);
}

/* Radio circle */
.bk-radio-custom {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    border: 2px solid #cbd5e1;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.2s;
}
.bk-pkg-card.selected .bk-radio-custom {
    border-color: var(--primary-teal);
}
.bk-radio-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--primary-teal);
    opacity: 0;
    transition: opacity 0.15s;
}
.bk-pkg-card.selected .bk-radio-dot {
    opacity: 1;
}

.bk-pkg-icon-box {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    background: var(--teal-bg-soft);
    color: var(--primary-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.bk-pkg-body {
    flex: 1;
    min-width: 0;
}
.bk-pkg-header-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 2px;
}
.bk-pkg-title {
    font-size: 16px;
    font-weight: 800;
    color: var(--ink);
}
.bk-pkg-badge-popular {
    background: var(--primary-teal);
    color: #ffffff;
    font-size: 10.5px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 6px;
}
.bk-pkg-appt-line {
    font-size: 12.5px;
    color: var(--muted-text);
    font-weight: 500;
}
.bk-pkg-rate-line {
    font-size: 12.5px;
    color: #475569;
    font-weight: 600;
    margin-top: 1px;
}

.bk-pkg-pricing {
    text-align: right;
}
.bk-pkg-price-now {
    font-size: 20px;
    font-weight: 900;
    color: var(--ink);
    letter-spacing: -0.02em;
}
.bk-pkg-old-price {
    font-size: 12.5px;
    color: #94a3b8;
    text-decoration: line-through;
    margin-right: 6px;
}
.bk-pkg-disc-tag {
    background: #dcfce7;
    color: #15803d;
    font-size: 11px;
    font-weight: 800;
    padding: 2px 7px;
    border-radius: 6px;
}

/* Need help box */
.bk-help-box {
    background: #f0f9ff;
    border: 1px solid #e0f2fe;
    border-radius: 14px;
    padding: 16px 18px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}
.bk-hb-icon {
    font-size: 20px;
    color: #0284c7;
    margin-top: 2px;
}
.bk-hb-title {
    font-size: 14px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 2px;
}
.bk-hb-desc {
    font-size: 12.5px;
    color: #64748b;
    line-height: 1.5;
}

/* ── STEP 2: SELECT DATE & TIME ── */
.bk-month-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}
.bk-month-title {
    font-size: 15.5px;
    font-weight: 800;
    color: var(--ink);
}
.bk-month-arrow {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--muted-text);
    cursor: pointer;
    font-size: 12px;
}
.bk-month-arrow:hover {
    border-color: var(--primary-teal);
    color: var(--primary-teal);
}

.bk-days-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 10px;
    margin-bottom: 24px;
    text-align: center;
}
.bk-day-head {
    font-size: 12px;
    font-weight: 700;
    color: var(--muted-text);
    margin-bottom: 6px;
}
.bk-day-card {
    padding: 12px 6px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    cursor: pointer;
    transition: all 0.2s;
}
.bk-day-card:hover {
    border-color: var(--primary-teal);
}
.bk-day-card.selected {
    background: var(--primary-teal);
    border-color: var(--primary-teal);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(12, 105, 120, 0.25);
}
.bk-day-num {
    font-size: 15px;
    font-weight: 800;
}

.bk-avail-slots-title {
    font-size: 14px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 14px;
}
.bk-slots-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 18px;
}
.bk-slot-btn {
    padding: 12px 10px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    background: #ffffff;
    font-size: 13.5px;
    font-weight: 700;
    color: var(--ink);
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
}
.bk-slot-btn:hover {
    border-color: var(--primary-teal);
}
.bk-slot-btn.selected {
    background: var(--primary-teal);
    border-color: var(--primary-teal);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(12, 105, 120, 0.25);
}

.bk-time-notice {
    font-size: 12px;
    color: var(--muted-text);
    display: flex;
    align-items: center;
    gap: 6px;
}

/* ── STEP 3: ADDRESS ── */
.bk-addr-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 18px;
}
.bk-addr-card {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 16px 18px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
    cursor: pointer;
    transition: all 0.2s;
}
.bk-addr-card:hover {
    border-color: var(--primary-teal);
}
.bk-addr-card.selected {
    border-color: var(--primary-teal);
    background: #fbfdfd;
}
.bk-addr-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: var(--teal-bg-soft);
    color: var(--primary-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.bk-addr-content {
    flex: 1;
}
.bk-addr-label {
    font-size: 14px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 2px;
}
.bk-addr-text {
    font-size: 13px;
    color: var(--muted-text);
    line-height: 1.45;
}
.bk-addr-edit-link {
    font-size: 12.5px;
    color: var(--primary-teal);
    font-weight: 700;
    cursor: pointer;
}

.bk-btn-add-addr {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 13px;
    border-radius: 12px;
    border: 1.5px dashed #cbd5e1;
    background: #ffffff;
    color: var(--primary-teal);
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}
.bk-btn-add-addr:hover {
    border-color: var(--primary-teal);
    background: var(--teal-bg-soft);
}

/* ── STEP 4: PATIENT DETAILS ── */
.bk-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
}
.bk-form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.bk-form-group.full {
    grid-column: span 2;
}
.bk-label {
    font-size: 13px;
    font-weight: 700;
    color: var(--ink);
}
.bk-input, .bk-select, .bk-textarea {
    width: 100%;
    padding: 11px 14px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    background: #ffffff;
    font-size: 13.5px;
    color: var(--ink);
    font-family: inherit;
    transition: border-color 0.2s;
}
.bk-input:focus, .bk-select:focus, .bk-textarea:focus {
    outline: none;
    border-color: var(--primary-teal);
}
.bk-input-phone-wrap {
    display: flex;
    align-items: center;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    background: #ffffff;
}
.bk-phone-prefix {
    padding: 11px 12px;
    background: #f8fafc;
    border-right: 1px solid #e2e8f0;
    font-size: 13.5px;
    font-weight: 700;
    color: #475569;
}
.bk-phone-input {
    border: none;
    padding: 11px 14px;
    flex: 1;
    font-size: 13.5px;
    font-family: inherit;
}
.bk-phone-input:focus {
    outline: none;
}

/* ── STEP 5: REVIEW & PAYMENT ── */
.bk-review-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 24px;
}
.bk-review-box {
    background: #ffffff;
    border: 1px solid #eef2f6;
    border-radius: 16px;
    padding: 20px;
}
.bk-rb-title {
    font-size: 15px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.bk-rb-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 12px;
    font-size: 13px;
}
.bk-rb-item i {
    color: var(--primary-teal);
    width: 18px;
    margin-top: 3px;
    flex-shrink: 0;
}
.bk-rbi-lbl {
    font-size: 11.5px;
    color: var(--muted-text);
    font-weight: 600;
    text-transform: uppercase;
}
.bk-rbi-val {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--ink);
}

/* Payment Summary */
.bk-price-summary-box {
    background: #f8fafc;
    border-radius: 12px;
    padding: 14px;
    margin-top: 14px;
    font-size: 13px;
}
.bk-ps-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 6px;
    color: #64748b;
}
.bk-ps-total-row {
    display: flex;
    justify-content: space-between;
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px dashed #cbd5e1;
    font-weight: 800;
    font-size: 15px;
    color: var(--ink);
}

/* Payment Methods */
.bk-pay-methods-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 16px;
}
.bk-pay-option {
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    transition: all 0.2s;
}
.bk-pay-option.selected {
    border-color: var(--primary-teal);
    background: var(--teal-bg-soft);
}
.bk-pay-opt-left {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13.5px;
    font-weight: 700;
    color: var(--ink);
}
.bk-pay-icons {
    display: flex;
    gap: 6px;
}
.bk-pay-badge {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 10.5px;
    font-weight: 700;
    color: #475569;
}

/* ── STEP 6: PROCESSING PAYMENT ── */
.bk-processing-card {
    text-align: center;
    padding: 50px 30px;
}
.bk-proc-spinner {
    width: 70px;
    height: 70px;
    border: 5px solid #e0f2fe;
    border-top-color: var(--primary-teal);
    border-radius: 50%;
    margin: 0 auto 24px;
    animation: spin 1s infinite linear;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.bk-proc-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 6px;
}
.bk-proc-sub {
    font-size: 13.5px;
    color: var(--muted-text);
    margin-bottom: 28px;
}
.bk-proc-checklist {
    max-width: 320px;
    margin: 0 auto;
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.bk-pcl-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 600;
    color: var(--ink);
}
.bk-pcl-item i.check {
    color: var(--accent-green);
    font-size: 15px;
}
.bk-pcl-item i.circle {
    color: #cbd5e1;
    font-size: 15px;
}

/* ── STEP 7: SUCCESS BOOKED ── */
.bk-success-panel {
    background: #ffffff;
    border: 1px solid var(--border-card);
    border-radius: 24px;
    padding: 40px 32px;
    box-shadow: var(--shadow-card);
    text-align: center;
    max-width: 780px;
    margin: 0 auto;
}
.bk-success-icon-wrap {
    width: 76px;
    height: 76px;
    border-radius: 50%;
    background: #dcfce7;
    color: #16a34a;
    font-size: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 18px;
    box-shadow: 0 8px 24px rgba(22, 163, 74, 0.2);
}
.bk-success-title {
    font-size: 24px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.02em;
    margin-bottom: 6px;
}
.bk-success-sub {
    font-size: 14px;
    color: var(--muted-text);
    margin-bottom: 28px;
}

.bk-receipt-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 22px;
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 14px;
    margin-bottom: 24px;
}
.bk-rc-row {
    display: grid;
    grid-template-columns: 140px 1fr;
    gap: 12px;
    font-size: 13.5px;
}
.bk-rc-lbl {
    color: var(--muted-text);
    display: flex;
    align-items: center;
    gap: 8px;
}
.bk-rc-val {
    font-weight: 700;
    color: var(--ink);
}

.bk-conf-notice {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 13px;
    color: #15803d;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 24px;
}

.bk-success-actions {
    display: flex;
    gap: 14px;
    justify-content: center;
}
.bk-btn-outline {
    padding: 12px 24px;
    border-radius: 12px;
    border: 1.5px solid #cbd5e1;
    background: #ffffff;
    font-size: 14px;
    font-weight: 700;
    color: var(--ink);
    transition: all 0.2s;
}
.bk-btn-outline:hover {
    border-color: var(--primary-teal);
    color: var(--primary-teal);
}
.bk-btn-filled {
    padding: 12px 24px;
    border-radius: 12px;
    background: var(--primary-teal);
    color: #ffffff !important;
    font-size: 14px;
    font-weight: 800;
    box-shadow: 0 4px 14px rgba(12, 105, 120, 0.25);
    transition: all 0.2s;
}
.bk-btn-filled:hover {
    background: var(--primary-teal-dark);
}

/* ── STEP BOTTOM NAVIGATION ── */
.bk-step-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 28px;
    padding-top: 20px;
    border-top: 1px solid #f1f5f9;
}
.bk-btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    font-weight: 700;
    color: var(--ink);
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.2s;
    background: transparent;
    border: none;
    cursor: pointer;
}
.bk-btn-back:hover {
    background: #f1f5f9;
    color: var(--primary-teal);
}
.bk-btn-continue {
    background: var(--primary-teal);
    color: #ffffff !important;
    padding: 13px 28px;
    border-radius: 12px;
    font-size: 14.5px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(12, 105, 120, 0.25);
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}
.bk-btn-continue:hover {
    background: var(--primary-teal-dark);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(12, 105, 120, 0.35);
}

/* ── RIGHT DOCTOR SUMMARY SIDEBAR ── */
.bk-sidebar-card {
    background: var(--card-bg);
    border: 1px solid var(--border-card);
    border-radius: 20px;
    padding: 24px;
    box-shadow: var(--shadow-card);
    position: sticky;
    top: 90px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.bk-doc-mini {
    display: flex;
    gap: 16px;
    align-items: center;
}
.bk-doc-avatar {
    width: 68px;
    height: 68px;
    border-radius: 14px;
    background: #e2e8f0;
    object-fit: cover;
    flex-shrink: 0;
}
.bk-doc-avatar-ph {
    width: 68px;
    height: 68px;
    border-radius: 14px;
    background: linear-gradient(135deg, #e0f2fe, #bae6fd);
    color: #0369a1;
    font-size: 26px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.bk-doc-name {
    font-size: 17px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 2px;
}
.bk-doc-spec {
    font-size: 13px;
    font-weight: 700;
    color: var(--primary-teal);
    margin-bottom: 4px;
}
.bk-doc-rating {
    font-size: 12px;
    font-weight: 700;
    color: #334155;
    display: flex;
    align-items: center;
    gap: 4px;
}
.bk-doc-rating i {
    color: var(--gold);
}
.bk-doc-exp {
    font-size: 12px;
    color: var(--muted-text);
    margin-top: 2px;
}

.bk-sec-divider {
    height: 1px;
    background: #f1f5f9;
}
.bk-sb-sec-title {
    font-size: 13.5px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 10px;
}
.bk-sb-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}
.bk-sb-tag {
    background: #f0f6fa;
    color: #1e293b;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 4px 10px;
    font-size: 11.5px;
    font-weight: 600;
}

.bk-trust-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.bk-trust-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 12.5px;
}
.bk-trust-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: var(--teal-bg-soft);
    color: var(--primary-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}
.bk-ti-title {
    font-weight: 800;
    color: var(--ink);
    line-height: 1.2;
}
.bk-ti-desc {
    color: var(--muted-text);
    font-size: 11.5px;
    margin-top: 1px;
}

/* ── MODAL: ADD NEW ADDRESS ── */
.bk-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
    z-index: 1050;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.bk-modal-overlay.show {
    display: flex;
}
.bk-modal-card {
    background: #ffffff;
    width: 100%;
    max-width: 480px;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.18);
    overflow: hidden;
    animation: modalPop 0.2s ease-out;
}
@keyframes modalPop {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.bk-modal-header {
    padding: 18px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.bk-modal-title {
    font-size: 17px;
    font-weight: 800;
    color: var(--ink);
}
.bk-modal-close {
    background: #f1f5f9;
    border: none;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 16px;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
}
.bk-modal-body {
    padding: 20px 24px;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.bk-modal-footer {
    padding: 16px 24px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

/* ── RESPONSIVE ── */
@media (max-width: 991px) {
    .bk-grid {
        grid-template-columns: 1fr;
    }
    .bk-sidebar-card {
        position: static;
    }
    .bk-review-grid {
        grid-template-columns: 1fr;
    }
}
@media (max-width: 640px) {
    .bk-stepper {
        gap: 4px;
    }
    .bk-step-lbl {
        display: none; /* Hide labels on very small mobile for clean circles */
    }
    .bk-form-grid {
        grid-template-columns: 1fr;
    }
    .bk-form-group.full {
        grid-column: span 1;
    }
    .bk-slots-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .bk-rc-row {
        grid-template-columns: 1fr;
        gap: 2px;
    }
}
</style>

<div class="bk-page-wrap">

    {{-- Header --}}
    @include('layouts.header')

    <div class="bk-container">

        {{-- Breadcrumb --}}
        <div class="bk-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="bk-bc-sep">&gt;</span>
            <a href="{{ route('doctor.profile', $doctor->id) }}">Book Appointment</a>
            <span class="bk-bc-sep">&gt;</span>
            <span class="bk-bc-current" id="bcStepTitle">Choose Package</span>
        </div>

        {{-- 4-Step Progress Stepper (Screens 1 to 5) --}}
        <div class="bk-stepper-wrap" id="stepperContainer">
            <div class="bk-stepper">
                {{-- Step 1 --}}
                <div class="bk-step-item active" id="stepIndicator1" onclick="goToStep(1)">
                    <div class="bk-step-circle" id="stepCircle1">1</div>
                    <div class="bk-step-lbl">Choose Package</div>
                </div>

                <div class="bk-step-line" id="stepLine1"></div>

                {{-- Step 2 --}}
                <div class="bk-step-item" id="stepIndicator2" onclick="goToStep(2)">
                    <div class="bk-step-circle" id="stepCircle2">2</div>
                    <div class="bk-step-lbl">Select Date &amp; Time</div>
                </div>

                <div class="bk-step-line" id="stepLine2"></div>

                {{-- Step 3 --}}
                <div class="bk-step-item" id="stepIndicator3" onclick="goToStep(3)">
                    <div class="bk-step-circle" id="stepCircle3">3</div>
                    <div class="bk-step-lbl">Address</div>
                </div>

                <div class="bk-step-line" id="stepLine3"></div>

                {{-- Step 4 --}}
                <div class="bk-step-item" id="stepIndicator4" onclick="goToStep(4)">
                    <div class="bk-step-circle" id="stepCircle4">4</div>
                    <div class="bk-step-lbl">Patient Details</div>
                </div>
            </div>
        </div>

        {{-- Main 2-Column Layout --}}
        <div class="bk-grid">

            {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               LEFT COLUMN: MULTI-STEP CONTENT PANELS
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
            <div class="bk-left-col">

                {{-- ══════════════════════════════════════════════
                     STEP 1: CHOOSE PACKAGE
                ══════════════════════════════════════════════ --}}
                <div class="bk-main-panel" id="stepPanel1">
                    <h2 class="bk-step-title">Choose Package</h2>
                    <p class="bk-step-desc">Select a booking plan that suits your recovery goals</p>

                    <div class="bk-packages-list">
                        @if(isset($patientPlans) && $patientPlans->count() > 0)
                            @foreach($patientPlans as $idx => $plan)
                                @php
                                    $pkgPrice = $plan->calculated_package_price ?? $plan->price;
                                    $perRate  = $plan->calculated_per_session ?? ($plan->total_appointments > 0 ? round($pkgPrice / $plan->total_appointments) : $totalFee);
                                    $origPrice = $plan->calculated_pricing['original_package_price'] ?? ($plan->original_price ?? round($pkgPrice * 1.15));
                                    $discPct = (int) ($plan->calculated_pricing['discount_percentage'] ?? ($plan->discount_percentage ?? 11));
                                    $isFirst = $idx === 0;
                                @endphp
                                <div class="bk-pkg-card {{ $isFirst ? 'selected' : '' }}" 
                                     data-plan-id="{{ $plan->id }}" 
                                     data-plan-name="{{ $plan->name }}" 
                                     data-appts="{{ $plan->total_appointments }}" 
                                     data-price="{{ $pkgPrice }}" 
                                     data-per-rate="{{ $perRate }}"
                                     onclick="selectPackage(this)">
                                    <div class="bk-radio-custom">
                                        <div class="bk-radio-dot"></div>
                                    </div>
                                    <div class="bk-pkg-icon-box">
                                        <i class="fa-solid fa-person-walking"></i>
                                    </div>
                                    <div class="bk-pkg-body">
                                        <div class="bk-pkg-header-row">
                                            <div class="bk-pkg-title">{{ $plan->name }}</div>
                                            @if($isFirst)
                                                <span class="bk-pkg-badge-popular">Most Popular</span>
                                            @endif
                                        </div>
                                        <div class="bk-pkg-appt-line">Appointment: {{ $plan->total_appointments }}</div>
                                        <div class="bk-pkg-rate-line">₹{{ number_format($perRate) }} per session</div>
                                    </div>
                                    <div class="bk-pkg-pricing">
                                        <div class="bk-pkg-price-now">₹{{ number_format($pkgPrice, 2) }}</div>
                                        @if($discPct > 0)
                                            <div>
                                                <span class="bk-pkg-old-price">₹{{ number_format($origPrice, 2) }}</span>
                                                <span class="bk-pkg-disc-tag">{{ $discPct }}% Off</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{-- Default Packages from Mockup --}}
                            <div class="bk-pkg-card selected" data-plan-id="1" data-plan-name="Advance" data-appts="1" data-price="979" data-per-rate="979" onclick="selectPackage(this)">
                                <div class="bk-radio-custom"><div class="bk-radio-dot"></div></div>
                                <div class="bk-pkg-icon-box"><i class="fa-solid fa-person-walking"></i></div>
                                <div class="bk-pkg-body">
                                    <div class="bk-pkg-header-row">
                                        <div class="bk-pkg-title">Advance</div>
                                        <span class="bk-pkg-badge-popular">Most Popular</span>
                                    </div>
                                    <div class="bk-pkg-appt-line">Appointment: 1</div>
                                    <div class="bk-pkg-rate-line">₹979 per session</div>
                                </div>
                                <div class="bk-pkg-pricing">
                                    <div class="bk-pkg-price-now">₹979.00</div>
                                    <div>
                                        <span class="bk-pkg-old-price">₹1100.00</span>
                                        <span class="bk-pkg-disc-tag">11% Off</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bk-pkg-card" data-plan-id="2" data-plan-name="Basic" data-appts="2" data-price="1760" data-per-rate="880" onclick="selectPackage(this)">
                                <div class="bk-radio-custom"><div class="bk-radio-dot"></div></div>
                                <div class="bk-pkg-icon-box"><i class="fa-solid fa-person-dots-from-line"></i></div>
                                <div class="bk-pkg-body">
                                    <div class="bk-pkg-title">Basic</div>
                                    <div class="bk-pkg-appt-line">Appointment: 2</div>
                                    <div class="bk-pkg-rate-line">₹880 per session</div>
                                </div>
                                <div class="bk-pkg-pricing">
                                    <div class="bk-pkg-price-now">₹1760.00</div>
                                    <div>
                                        <span class="bk-pkg-old-price">₹2200.00</span>
                                        <span class="bk-pkg-disc-tag">20% Off</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Need Help Choosing Box --}}
                    <div class="bk-help-box">
                        <i class="fa-solid fa-circle-info bk-hb-icon"></i>
                        <div>
                            <div class="bk-hb-title">Need Help Choosing?</div>
                            <div class="bk-hb-desc">You can discuss with the physiotherapist after booking to find the best plan for your condition.</div>
                        </div>
                    </div>

                    {{-- Bottom Step Nav --}}
                    <div class="bk-step-nav">
                        <a href="{{ route('doctor.profile', $doctor->id) }}" class="bk-btn-back">
                            <i class="fa-solid fa-chevron-left"></i> Back to Doctor Profile
                        </a>
                        <button type="button" class="bk-btn-continue" onclick="goToStep(2)">
                            Continue <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════
                     STEP 2: SELECT DATE & TIME
                ══════════════════════════════════════════════ --}}
                <div class="bk-main-panel" id="stepPanel2" style="display:none;">
                    <h2 class="bk-step-title">Select Date &amp; Time</h2>
                    <p class="bk-step-desc">Choose your preferred date and time slot</p>

                    {{-- Month Navigator --}}
                    <div class="bk-month-nav">
                        <button type="button" class="bk-month-arrow"><i class="fa-solid fa-chevron-left"></i></button>
                        <div class="bk-month-title">{{ date('F Y') }}</div>
                        <button type="button" class="bk-month-arrow"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>

                    {{-- Days Row --}}
                    <div class="bk-days-grid">
                        @foreach($calendarDays as $cDay)
                            <div>
                                <div class="bk-day-head">{{ $cDay['dayName'] }}</div>
                                <div class="bk-day-card {{ $cDay['isSelected'] ? 'selected' : '' }}" 
                                     data-date="{{ $cDay['fullDate'] }}" 
                                     data-db-date="{{ $cDay['dbDate'] }}"
                                     onclick="selectDateCard(this)">
                                    <div class="bk-day-num">{{ $cDay['dateNum'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Available Slots --}}
                    <div class="bk-avail-slots-title">Available Slots: <span id="slotSelectedDateDisplay">20-09-2026</span></div>
                    
                    <div class="bk-slots-grid" id="bookingSlotsGrid">
                        @if($doctor->availabilityDates->isNotEmpty())
                            @foreach($doctor->availabilityDates as $av)
                                @foreach($av->timeSlots as $ts)
                                    <div class="bk-slot-btn {{ $loop->first ? 'selected' : '' }}" 
                                         data-slot-id="{{ $ts->id }}" 
                                         data-time="{{ \Carbon\Carbon::parse($ts->start_time)->format('h:i A') }}" 
                                         onclick="selectSlotBtn(this)">
                                        {{ \Carbon\Carbon::parse($ts->start_time)->format('h:i A') }}
                                    </div>
                                @endforeach
                            @endforeach
                        @else
                            {{-- Fallback Slots matching Screen 2 mockup --}}
                            <div class="bk-slot-btn" data-slot-id="1" data-time="09:00 AM" onclick="selectSlotBtn(this)">09:00 AM</div>
                            <div class="bk-slot-btn selected" data-slot-id="2" data-time="10:00 AM" onclick="selectSlotBtn(this)">10:00 AM</div>
                            <div class="bk-slot-btn" data-slot-id="3" data-time="11:00 AM" onclick="selectSlotBtn(this)">11:00 AM</div>
                            <div class="bk-slot-btn" data-slot-id="4" data-time="12:00 PM" onclick="selectSlotBtn(this)">12:00 PM</div>
                            <div class="bk-slot-btn" data-slot-id="5" data-time="04:00 PM" onclick="selectSlotBtn(this)">04:00 PM</div>
                            <div class="bk-slot-btn" data-slot-id="6" data-time="06:00 PM" onclick="selectSlotBtn(this)">06:00 PM</div>
                        @endif
                    </div>

                    <div class="bk-time-notice">
                        <i class="fa-solid fa-circle-info"></i>
                        <span>Slots are in local time. Please select a convenient time for your home session.</span>
                    </div>

                    {{-- Bottom Step Nav --}}
                    <div class="bk-step-nav">
                        <button type="button" class="bk-btn-back" onclick="goToStep(1)">
                            <i class="fa-solid fa-chevron-left"></i> Back
                        </button>
                        <button type="button" class="bk-btn-continue" onclick="goToStep(3)">
                            Continue <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════
                     STEP 3: ADDRESS
                ══════════════════════════════════════════════ --}}
                <div class="bk-main-panel" id="stepPanel3" style="display:none;">
                    <h2 class="bk-step-title">Address</h2>
                    <p class="bk-step-desc">Select a saved address or add a new address below</p>

                    <div class="bk-addr-list" id="savedAddressList">
                        @if($userAddresses->isNotEmpty())
                            @foreach($userAddresses as $idx => $ua)
                                <div class="bk-addr-card {{ $idx === 0 ? 'selected' : '' }}" 
                                     data-addr-title="{{ $ua->city ?? 'Home' }}" 
                                     data-addr-full="{{ $ua->address }}, {{ $ua->city }}, {{ $ua->state }} {{ $ua->postal_code }}"
                                     onclick="selectAddressCard(this)">
                                    <div class="bk-radio-custom"><div class="bk-radio-dot"></div></div>
                                    <div class="bk-addr-icon"><i class="fa-solid fa-house-chimney"></i></div>
                                    <div class="bk-addr-content">
                                        <div class="bk-addr-label">{{ $ua->city ?? 'Home' }}</div>
                                        <div class="bk-addr-text">{{ $ua->address }}, {{ $ua->city }}, {{ $ua->state }} {{ $ua->postal_code }}</div>
                                    </div>
                                    <span class="bk-addr-edit-link" onclick="openAddressModal()">Edit</span>
                                </div>
                            @endforeach
                        @else
                            {{-- Sample Addresses matching Screen 3 mockup --}}
                            <div class="bk-addr-card selected" data-addr-title="Home" data-addr-full="123, MG Road, Indore, Madhya Pradesh 452001" onclick="selectAddressCard(this)">
                                <div class="bk-radio-custom"><div class="bk-radio-dot"></div></div>
                                <div class="bk-addr-icon"><i class="fa-solid fa-house-chimney"></i></div>
                                <div class="bk-addr-content">
                                    <div class="bk-addr-label">Home</div>
                                    <div class="bk-addr-text">123, MG Road, Indore, Madhya Pradesh 452001</div>
                                </div>
                                <span class="bk-addr-edit-link" onclick="openAddressModal()">Edit</span>
                            </div>

                            <div class="bk-addr-card" data-addr-title="Office" data-addr-full="456, Scheme 54, Indore, Madhya Pradesh 452010" onclick="selectAddressCard(this)">
                                <div class="bk-radio-custom"><div class="bk-radio-dot"></div></div>
                                <div class="bk-addr-icon"><i class="fa-solid fa-building"></i></div>
                                <div class="bk-addr-content">
                                    <div class="bk-addr-label">Office</div>
                                    <div class="bk-addr-text">456, Scheme 54, Indore, Madhya Pradesh 452010</div>
                                </div>
                                <span class="bk-addr-edit-link" onclick="openAddressModal()">Edit</span>
                            </div>

                            <div class="bk-addr-card" data-addr-title="Parents Home" data-addr-full="789, Vijay Nagar, Indore, Madhya Pradesh 452010" onclick="selectAddressCard(this)">
                                <div class="bk-radio-custom"><div class="bk-radio-dot"></div></div>
                                <div class="bk-addr-icon"><i class="fa-solid fa-people-roof"></i></div>
                                <div class="bk-addr-content">
                                    <div class="bk-addr-label">Parents Home</div>
                                    <div class="bk-addr-text">789, Vijay Nagar, Indore, Madhya Pradesh 452010</div>
                                </div>
                                <span class="bk-addr-edit-link" onclick="openAddressModal()">Edit</span>
                            </div>
                        @endif
                    </div>

                    <button type="button" class="bk-btn-add-addr" onclick="openAddressModal()">
                        <i class="fa-solid fa-plus"></i> Add New Address
                    </button>

                    {{-- Bottom Step Nav --}}
                    <div class="bk-step-nav">
                        <button type="button" class="bk-btn-back" onclick="goToStep(2)">
                            <i class="fa-solid fa-chevron-left"></i> Back
                        </button>
                        <button type="button" class="bk-btn-continue" onclick="goToStep(4)">
                            Continue <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════
                     STEP 4: PATIENT DETAILS
                ══════════════════════════════════════════════ --}}
                <div class="bk-main-panel" id="stepPanel4" style="display:none;">
                    <h2 class="bk-step-title">Patient Details</h2>
                    <p class="bk-step-desc">Please provide your details to confirm the booking</p>

                    <div class="bk-form-grid">
                        <div class="bk-form-group full">
                            <label class="bk-label">Full Name *</label>
                            <input type="text" class="bk-input" id="patientNameInput" placeholder="Enter full name" value="{{ auth()->user()->name ?? 'Alex' }}">
                        </div>

                        <div class="bk-form-group full">
                            <label class="bk-label">Mobile Number *</label>
                            <div class="bk-input-phone-wrap">
                                <span class="bk-phone-prefix">+91</span>
                                <input type="tel" class="bk-phone-input" id="patientPhoneInput" placeholder="Enter mobile number" value="{{ auth()->user()->phone ?? '991 98765 43210' }}">
                            </div>
                        </div>

                        <div class="bk-form-group full">
                            <label class="bk-label">Email Address *</label>
                            <input type="email" class="bk-input" id="patientEmailInput" placeholder="Enter email address" value="{{ auth()->user()->email ?? 'alex@example.com' }}">
                        </div>

                        <div class="bk-form-group">
                            <label class="bk-label">Age *</label>
                            <input type="number" class="bk-input" id="patientAgeInput" placeholder="Enter age" value="28">
                        </div>

                        <div class="bk-form-group">
                            <label class="bk-label">Gender *</label>
                            <select class="bk-select" id="patientGenderInput">
                                <option value="Male" selected>Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="bk-form-group full">
                            <label class="bk-label">Additional Notes (Optional)</label>
                            <textarea class="bk-textarea" id="patientNotesInput" rows="3" placeholder="Any specific concerns or notes for the physiotherapist?"></textarea>
                        </div>
                    </div>

                    {{-- Bottom Step Nav --}}
                    <div class="bk-step-nav">
                        <button type="button" class="bk-btn-back" onclick="goToStep(3)">
                            <i class="fa-solid fa-chevron-left"></i> Back
                        </button>
                        <button type="button" class="bk-btn-continue" onclick="goToStep(5)">
                            Continue <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════
                     STEP 5: REVIEW & PAYMENT (Screen 6)
                ══════════════════════════════════════════════ --}}
                <div class="bk-main-panel" id="stepPanel5" style="display:none;">
                    <h2 class="bk-step-title">Review &amp; Payment</h2>
                    <p class="bk-step-desc">Please review your booking details before payment</p>

                    <div class="bk-review-grid">
                        {{-- Appointment Details Summary --}}
                        <div class="bk-review-box">
                            <div class="bk-rb-title">
                                <i class="fa-regular fa-calendar-check" style="color:var(--primary-teal)"></i>
                                <span>Appointment Details</span>
                            </div>

                            <div class="bk-rb-item">
                                <i class="fa-solid fa-user-doctor"></i>
                                <div>
                                    <div class="bk-rbi-lbl">Doctor</div>
                                    <div class="bk-rbi-val">Dr. {{ $cleanDoctorName }} ({{ $specName }} Specialist)</div>
                                </div>
                            </div>

                            <div class="bk-rb-item">
                                <i class="fa-solid fa-box-open"></i>
                                <div>
                                    <div class="bk-rbi-lbl">Package</div>
                                    <div class="bk-rbi-val" id="revPackageVal">Advance (1 Appointment)<br><small style="color:var(--muted-text);font-weight:500;">₹979 per session</small></div>
                                </div>
                            </div>

                            <div class="bk-rb-item">
                                <i class="fa-regular fa-clock"></i>
                                <div>
                                    <div class="bk-rbi-lbl">Date &amp; Time</div>
                                    <div class="bk-rbi-val" id="revDateTimeVal">20 September 2026, 10:00 AM</div>
                                </div>
                            </div>

                            <div class="bk-rb-item">
                                <i class="fa-solid fa-location-dot"></i>
                                <div>
                                    <div class="bk-rbi-lbl">Address</div>
                                    <div class="bk-rbi-val" id="revAddressVal">Home<br><small style="color:var(--muted-text);font-weight:500;">123, MG Road, Indore, Madhya Pradesh 452001</small></div>
                                </div>
                            </div>

                            <div class="bk-rb-item">
                                <i class="fa-regular fa-user"></i>
                                <div>
                                    <div class="bk-rbi-lbl">Patient</div>
                                    <div class="bk-rbi-val" id="revPatientVal">Alex<br><small style="color:var(--muted-text);font-weight:500;">alex@example.com | +91 98765 43210</small></div>
                                </div>
                            </div>

                            {{-- Payment Breakdown Box --}}
                            <div class="bk-price-summary-box">
                                <div class="bk-ps-row">
                                    <span>Doctor Fee</span>
                                    <span id="revDocFee">₹800.00</span>
                                </div>
                                <div class="bk-ps-row">
                                    <span>Physiopii/Admin Fee</span>
                                    <span id="revAdminFee">₹179.00</span>
                                </div>
                                <div class="bk-ps-total-row">
                                    <span>Total (Incl. Tax)</span>
                                    <span style="color:var(--primary-teal-dark)" id="revTotalPrice">₹979.00</span>
                                </div>
                            </div>

                            <div style="font-size:11.5px;color:#15803d;margin-top:10px;display:flex;align-items:center;gap:6px;">
                                <i class="fa-solid fa-lock"></i>
                                <span>Secure Payment: Your payment information is encrypted and secure.</span>
                            </div>
                        </div>

                        {{-- Payment Method Selection --}}
                        <div class="bk-review-box">
                            <div class="bk-rb-title">
                                <i class="fa-regular fa-credit-card" style="color:var(--primary-teal)"></i>
                                <span>Payment Method</span>
                            </div>

                            <div class="bk-pay-methods-list">
                                <div class="bk-pay-option selected" onclick="selectPayMethod(this)">
                                    <div class="bk-pay-opt-left">
                                        <div class="bk-radio-custom"><div class="bk-radio-dot"></div></div>
                                        <span>UPI</span>
                                    </div>
                                    <div class="bk-pay-icons">
                                        <span class="bk-pay-badge">GPay</span>
                                        <span class="bk-pay-badge">PhonePe</span>
                                        <span class="bk-pay-badge">Paytm</span>
                                    </div>
                                </div>

                                <div class="bk-pay-option" onclick="selectPayMethod(this)">
                                    <div class="bk-pay-opt-left">
                                        <div class="bk-radio-custom"><div class="bk-radio-dot"></div></div>
                                        <span>Debit / Credit Card</span>
                                    </div>
                                    <div class="bk-pay-icons">
                                        <span class="bk-pay-badge">VISA</span>
                                        <span class="bk-pay-badge">Master</span>
                                        <span class="bk-pay-badge">RuPay</span>
                                    </div>
                                </div>

                                <div class="bk-pay-option" onclick="selectPayMethod(this)">
                                    <div class="bk-pay-opt-left">
                                        <div class="bk-radio-custom"><div class="bk-radio-dot"></div></div>
                                        <span>Net Banking</span>
                                    </div>
                                </div>

                                <div class="bk-pay-option" onclick="selectPayMethod(this)">
                                    <div class="bk-pay-opt-left">
                                        <div class="bk-radio-custom"><div class="bk-radio-dot"></div></div>
                                        <span>Wallet</span>
                                    </div>
                                    <span style="font-size:11.5px;color:var(--muted-text)">(Paytm, PhonePe, etc.)</span>
                                </div>
                            </div>

                            <div style="font-size:12px;color:var(--muted-text);display:flex;align-items:center;gap:6px;margin-bottom:18px;">
                                <i class="fa-solid fa-shield-halved" style="color:var(--primary-teal)"></i>
                                <span>100% Secure Payments: We use industry standard encryption to keep your data safe.</span>
                            </div>

                            <div style="background:#f8fafc;border-radius:12px;padding:12px 14px;display:flex;align-items:center;gap:12px;">
                                <div style="width:36px;height:36px;border-radius:50%;background:#e0f7f8;color:var(--primary-teal);display:flex;align-items:center;justify-content:center;font-size:15px;">
                                    <i class="fa-solid fa-headset"></i>
                                </div>
                                <div>
                                    <div style="font-size:12.5px;font-weight:800;color:var(--ink)">Need Help?</div>
                                    <div style="font-size:11.5px;color:var(--muted-text)">Call Us at (555) 432-1090 &middot; Mon - Sat, 9AM - 6PM</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bottom Step Nav --}}
                    <div class="bk-step-nav">
                        <button type="button" class="bk-btn-back" onclick="goToStep(4)">
                            <i class="fa-solid fa-chevron-left"></i> Back
                        </button>
                        <button type="button" class="bk-btn-continue" onclick="startPaymentProcess()">
                            Proceed to Payment <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════
                     STEP 6: PROCESSING PAYMENT (Screen 7)
                ══════════════════════════════════════════════ --}}
                <div class="bk-main-panel bk-processing-card" id="stepPanel6" style="display:none;">
                    <div class="bk-proc-spinner"></div>
                    <h2 class="bk-proc-title">Processing Payment</h2>
                    <p class="bk-proc-sub">Please do not close this window. We are confirming your payment...</p>

                    <div class="bk-proc-checklist">
                        <div class="bk-pcl-item">
                            <i class="fa-solid fa-circle-check check"></i>
                            <span>Connecting to payment gateway</span>
                        </div>
                        <div class="bk-pcl-item">
                            <i class="fa-solid fa-circle-check check" id="chkStep2"></i>
                            <span>Validating payment details</span>
                        </div>
                        <div class="bk-pcl-item">
                            <i class="fa-solid fa-circle-check check" id="chkStep3"></i>
                            <span>Processing transaction</span>
                        </div>
                        <div class="bk-pcl-item">
                            <i class="fa-regular fa-circle circle" id="chkStep4"></i>
                            <span id="txtStep4">Confirming booking</span>
                        </div>
                    </div>

                    <div style="font-size:12px;color:var(--muted-text);margin-top:28px;display:flex;align-items:center;justify-content:center;gap:6px;">
                        <i class="fa-solid fa-lock"></i>
                        <span>This may take a few seconds.</span>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════
                     STEP 7: APPOINTMENT BOOKED SUCCESSFULLY! (Screen 8)
                ══════════════════════════════════════════════ --}}
                <div class="bk-success-panel" id="stepPanel7" style="display:none;">
                    <div class="bk-success-icon-wrap">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <h2 class="bk-success-title">Appointment Booked Successfully!</h2>
                    <p class="bk-success-sub">Your home physiotherapy session has been confirmed.</p>

                    {{-- Receipt Box --}}
                    <div class="bk-receipt-card">
                        <div class="bk-rc-row">
                            <div class="bk-rc-lbl"><i class="fa-solid fa-receipt"></i> Booking ID</div>
                            <div class="bk-rc-val" id="sucBookingId">#PHY{{ date('Ymd') }}-{{ rand(100, 999) }}</div>
                        </div>
                        <div class="bk-rc-row">
                            <div class="bk-rc-lbl"><i class="fa-solid fa-user-doctor"></i> Doctor</div>
                            <div class="bk-rc-val">Dr. {{ $cleanDoctorName }} ({{ $specName }} Specialist)</div>
                        </div>
                        <div class="bk-rc-row">
                            <div class="bk-rc-lbl"><i class="fa-regular fa-calendar-check"></i> Date &amp; Time</div>
                            <div class="bk-rc-val" id="sucDateTime">20 September 2026, 10:00 AM</div>
                        </div>
                        <div class="bk-rc-row">
                            <div class="bk-rc-lbl"><i class="fa-solid fa-box-open"></i> Package</div>
                            <div class="bk-rc-val" id="sucPackage">Advance (1 Appointment)</div>
                        </div>
                        <div class="bk-rc-row">
                            <div class="bk-rc-lbl"><i class="fa-solid fa-location-dot"></i> Address</div>
                            <div class="bk-rc-val" id="sucAddress">123, MG Road, Indore, Madhya Pradesh 452001</div>
                        </div>
                        <div class="bk-rc-row">
                            <div class="bk-rc-lbl"><i class="fa-solid fa-wallet"></i> Amount Paid</div>
                            <div class="bk-rc-val">
                                <span id="sucAmount">₹979.00</span>
                                <span style="background:#dcfce7;color:#15803d;font-size:11px;font-weight:800;padding:2px 8px;border-radius:6px;margin-left:6px;">(Paid)</span>
                            </div>
                        </div>
                    </div>

                    <div class="bk-conf-notice">
                        <i class="fa-regular fa-envelope"></i>
                        <span>A confirmation email and SMS has been sent to your registered contact details.</span>
                    </div>

                    <div class="bk-success-actions">
                        <a href="{{ route('patient.dashboard') }}" class="bk-btn-outline">
                            View My Appointments
                        </a>
                        <a href="{{ route('home') }}" class="bk-btn-filled">
                            Book Another Session
                        </a>
                    </div>
                </div>

            </div>

            {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               RIGHT COLUMN: PERSISTENT DOCTOR SUMMARY SIDEBAR
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
            <aside class="bk-sidebar-col" id="bookingSidebar">
                <div class="bk-sidebar-card">
                    {{-- Doctor Mini Profile --}}
                    <div class="bk-doc-mini">
                        @if($doctor->profile_img)
                            <img src="{{ str_contains($doctor->profile_img, '/') ? asset($doctor->profile_img) : asset('uploads/profile/'.$doctor->profile_img) }}" class="bk-doc-avatar" alt="{{ $doctor->name }}">
                        @else
                            <div class="bk-doc-avatar-ph">{{ strtoupper(substr($doctor->name, 0, 1)) }}</div>
                        @endif
                        <div>
                            <div class="bk-doc-name">Dr. {{ $cleanDoctorName }}</div>
                            <div class="bk-doc-spec">{{ $specName }} Specialist</div>
                            <div class="bk-doc-rating">
                                <i class="fa-solid fa-star"></i>
                                <span>4.8 (120 Reviews)</span>
                            </div>
                            <div class="bk-doc-exp">
                                <i class="fa-solid fa-briefcase" style="color:var(--primary-teal);margin-right:4px;"></i>
                                {{ $expYears }} Years Experience
                            </div>
                        </div>
                    </div>

                    <div class="bk-sec-divider"></div>

                    {{-- Expertise & Services --}}
                    <div>
                        <div class="bk-sb-sec-title">Expertise &amp; Services</div>
                        <div class="bk-sb-tags">
                            <span class="bk-sb-tag">{{ $specName }}</span>
                            <span class="bk-sb-tag">Injury Recovery</span>
                            <span class="bk-sb-tag">Posture Correction</span>
                            <span class="bk-sb-tag">Mobility Improvement</span>
                            <span class="bk-sb-tag">Sports Injury</span>
                            <span class="bk-sb-tag">Personalized Rehabilitation</span>
                        </div>
                    </div>

                    <div class="bk-sec-divider"></div>

                    {{-- Trust Checklist --}}
                    <div class="bk-trust-list">
                        <div class="bk-trust-item">
                            <div class="bk-trust-icon"><i class="fa-solid fa-shield-halved"></i></div>
                            <div>
                                <div class="bk-ti-title">Verified &amp; Experienced</div>
                                <div class="bk-ti-desc">Licensed professionals</div>
                            </div>
                        </div>

                        <div class="bk-trust-item">
                            <div class="bk-trust-icon"><i class="fa-solid fa-house-chimney"></i></div>
                            <div>
                                <div class="bk-ti-title">At Your Home</div>
                                <div class="bk-ti-desc">Comfortable &amp; convenient</div>
                            </div>
                        </div>

                        <div class="bk-trust-item">
                            <div class="bk-trust-icon"><i class="fa-regular fa-clock"></i></div>
                            <div>
                                <div class="bk-ti-title">Flexible Scheduling</div>
                                <div class="bk-ti-desc">Book at your preferred time</div>
                            </div>
                        </div>

                        <div class="bk-trust-item">
                            <div class="bk-trust-icon"><i class="fa-regular fa-heart"></i></div>
                            <div>
                                <div class="bk-ti-title">Personalized Treatment</div>
                                <div class="bk-ti-desc">Care tailored to your needs</div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>

</div>

{{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   MODAL: ADD NEW ADDRESS (Screen 4 in Mockup)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
<div class="bk-modal-overlay" id="addAddressModal" onclick="if(event.target===this) closeAddressModal()">
    <div class="bk-modal-card">
        <div class="bk-modal-header">
            <div class="bk-modal-title">Add New Address</div>
            <button class="bk-modal-close" onclick="closeAddressModal()">&times;</button>
        </div>
        <div class="bk-modal-body">
            <div class="bk-form-group">
                <label class="bk-label">City *</label>
                <input type="text" class="bk-input" id="mCityInput" placeholder="Enter city" value="Indore">
            </div>

            <div class="bk-form-group">
                <label class="bk-label">Postal Code *</label>
                <input type="text" class="bk-input" id="mPostalInput" placeholder="Enter postal code" value="452001">
            </div>

            <div class="bk-form-group">
                <label class="bk-label">State *</label>
                <select class="bk-select" id="mStateInput">
                    <option value="Madhya Pradesh" selected>Madhya Pradesh</option>
                    <option value="Maharashtra">Maharashtra</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Karnataka">Karnataka</option>
                    <option value="Gujarat">Gujarat</option>
                </select>
            </div>

            <div class="bk-form-group">
                <label class="bk-label">Address Description *</label>
                <textarea class="bk-textarea" id="mAddressDescInput" rows="2" placeholder="e.g. House no, Street, Area">123, MG Road</textarea>
            </div>

            <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:var(--ink);cursor:pointer;margin-top:4px;">
                <input type="checkbox" id="mDefaultCheckbox" checked style="width:16px;height:16px;accent-color:var(--primary-teal);">
                <label for="mDefaultCheckbox" style="cursor:pointer;">Set as Default Address</label>
            </div>
        </div>
        <div class="bk-modal-footer">
            <button type="button" class="bk-btn-outline" style="padding:9px 18px;" onclick="closeAddressModal()">Cancel</button>
            <button type="button" class="bk-btn-filled" style="padding:9px 22px;" onclick="saveAddressFromModal()">Save</button>
        </div>
    </div>
</div>

{{-- Hidden booking fields for backend integration --}}
<form id="realBookingForm" style="display:none;">
    @csrf
    <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
    <input type="hidden" name="plan_id" id="formPlanId" value="1">
    <input type="hidden" name="slot_ids[]" id="formSlotId" value="1">
    <input type="hidden" name="booking_for" value="self">
    <input type="hidden" name="address" id="formAddress" value="">
    <input type="hidden" name="problem_description" id="formNotes" value="">
</form>

<script>
// State Management for Multi-Step Form
var currentStep = 1;

var bookingData = {
    planId: "1",
    planName: "Advance",
    planAppts: "1",
    planPrice: 979,
    perRate: 979,
    dateText: "20 September 2026",
    slotTime: "10:00 AM",
    slotId: "1",
    addrTitle: "Home",
    addrFull: "123, MG Road, Indore, Madhya Pradesh 452001",
    patientName: "Alex",
    patientPhone: "+91 98765 43210",
    patientEmail: "alex@example.com",
    patientAge: "28",
    patientGender: "Male",
    patientNotes: ""
};

// Initialize from first selected cards if present
document.addEventListener('DOMContentLoaded', function() {
    var selPkg = document.querySelector('.bk-pkg-card.selected');
    if (selPkg) {
        bookingData.planId = selPkg.getAttribute('data-plan-id') || "1";
        bookingData.planName = selPkg.getAttribute('data-plan-name') || "Advance";
        bookingData.planAppts = selPkg.getAttribute('data-appts') || "1";
        bookingData.planPrice = parseFloat(selPkg.getAttribute('data-price')) || 979;
        bookingData.perRate = parseFloat(selPkg.getAttribute('data-per-rate')) || 979;
    }
});

// Step Navigation
function goToStep(step) {
    if (step < 1 || step > 7) return;

    // Save current step data before navigating
    if (currentStep === 4) {
        bookingData.patientName = document.getElementById('patientNameInput').value || 'Alex';
        bookingData.patientPhone = document.getElementById('patientPhoneInput').value || '+91 98765 43210';
        bookingData.patientEmail = document.getElementById('patientEmailInput').value || 'alex@example.com';
        bookingData.patientAge = document.getElementById('patientAgeInput').value || '28';
        bookingData.patientGender = document.getElementById('patientGenderInput').value || 'Male';
        bookingData.patientNotes = document.getElementById('patientNotesInput').value || '';
    }

    currentStep = step;

    // Update Stepper bar
    for (let i = 1; i <= 4; i++) {
        let item = document.getElementById('stepIndicator' + i);
        let circ = document.getElementById('stepCircle' + i);
        let line = document.getElementById('stepLine' + i);

        if (item) {
            item.classList.remove('active', 'completed');
            if (i < step) {
                item.classList.add('completed');
                circ.innerHTML = '<i class="fa-solid fa-check" style="font-size:12px;"></i>';
            } else if (i === step) {
                item.classList.add('active');
                circ.innerHTML = i;
            } else {
                circ.innerHTML = i;
            }
        }

        if (line) {
            if (i < step) {
                line.classList.add('filled');
            } else {
                line.classList.remove('filled');
            }
        }
    }

    // Hide all step panels
    for (let s = 1; s <= 7; s++) {
        let p = document.getElementById('stepPanel' + s);
        if (p) p.style.display = 'none';
    }

    // Show target panel
    let target = document.getElementById('stepPanel' + step);
    if (target) target.style.display = 'block';

    // Update Breadcrumb
    let bcTitles = {
        1: 'Choose Package',
        2: 'Select Date & Time',
        3: 'Address',
        4: 'Patient Details',
        5: 'Review & Payment',
        6: 'Processing Payment',
        7: 'Appointment Confirmed'
    };
    let bc = document.getElementById('bcStepTitle');
    if (bc && bcTitles[step]) bc.innerText = bcTitles[step];

    // Hide sidebar on Success screen for centered card layout matching mockup
    let sb = document.getElementById('bookingSidebar');
    let st = document.getElementById('stepperContainer');
    if (step === 7) {
        if (sb) sb.style.display = 'none';
        if (st) st.style.display = 'none';
    } else {
        if (sb) sb.style.display = 'block';
        if (st) st.style.display = 'block';
    }

    // Populate Review Step if going to Step 5
    if (step === 5) {
        populateReviewStep();
    }

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Step 1: Package Selection
function selectPackage(el) {
    document.querySelectorAll('.bk-pkg-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    bookingData.planId = el.getAttribute('data-plan-id');
    bookingData.planName = el.getAttribute('data-plan-name');
    bookingData.planAppts = el.getAttribute('data-appts');
    bookingData.planPrice = parseFloat(el.getAttribute('data-price')) || 979;
    bookingData.perRate = parseFloat(el.getAttribute('data-per-rate')) || 979;
}

// Step 2: Date Selection
function selectDateCard(el) {
    document.querySelectorAll('.bk-day-card').forEach(d => d.classList.remove('selected'));
    el.classList.add('selected');
    let dVal = el.getAttribute('data-date');
    let display = document.getElementById('slotSelectedDateDisplay');
    if (display && dVal) {
        display.innerText = dVal;
    }
    bookingData.dateText = dVal ? (dVal.split('-')[0] + ' ' + 'September 2026') : '20 September 2026';
}

// Step 2: Slot Selection
function selectSlotBtn(el) {
    document.querySelectorAll('.bk-slot-btn').forEach(s => s.classList.remove('selected'));
    el.classList.add('selected');
    bookingData.slotTime = el.getAttribute('data-time') || '10:00 AM';
    bookingData.slotId = el.getAttribute('data-slot-id') || '1';
}

// Step 3: Address Selection
function selectAddressCard(el) {
    document.querySelectorAll('.bk-addr-card').forEach(a => a.classList.remove('selected'));
    el.classList.add('selected');
    bookingData.addrTitle = el.getAttribute('data-addr-title') || 'Home';
    bookingData.addrFull = el.getAttribute('data-addr-full') || '123, MG Road, Indore, Madhya Pradesh 452001';
}

// Step 3: Address Modal
function openAddressModal() {
    let m = document.getElementById('addAddressModal');
    if (m) m.classList.add('show');
}
function closeAddressModal() {
    let m = document.getElementById('addAddressModal');
    if (m) m.classList.remove('show');
}

function saveAddressFromModal() {
    let city = document.getElementById('mCityInput').value || 'Indore';
    let postal = document.getElementById('mPostalInput').value || '452001';
    let state = document.getElementById('mStateInput').value || 'Madhya Pradesh';
    let desc = document.getElementById('mAddressDescInput').value || '123, MG Road';
    let fullAddr = desc + ', ' + city + ', ' + state + ' ' + postal;

    // Create and prepend new address card
    let list = document.getElementById('savedAddressList');
    if (list) {
        document.querySelectorAll('.bk-addr-card').forEach(a => a.classList.remove('selected'));
        let newCard = document.createElement('div');
        newCard.className = 'bk-addr-card selected';
        newCard.setAttribute('data-addr-title', 'New Address');
        newCard.setAttribute('data-addr-full', fullAddr);
        newCard.onclick = function() { selectAddressCard(this); };
        newCard.innerHTML = `
            <div class="bk-radio-custom"><div class="bk-radio-dot"></div></div>
            <div class="bk-addr-icon"><i class="fa-solid fa-location-dot"></i></div>
            <div class="bk-addr-content">
                <div class="bk-addr-label">New Address</div>
                <div class="bk-addr-text">${fullAddr}</div>
            </div>
            <span class="bk-addr-edit-link" onclick="openAddressModal()">Edit</span>
        `;
        list.prepend(newCard);
    }

    bookingData.addrTitle = 'New Address';
    bookingData.addrFull = fullAddr;
    closeAddressModal();
}

// Step 5: Payment Method selection
function selectPayMethod(el) {
    document.querySelectorAll('.bk-pay-option').forEach(p => p.classList.remove('selected'));
    el.classList.add('selected');
}

// Populate Review Step
function populateReviewStep() {
    document.getElementById('revPackageVal').innerHTML = `${bookingData.planName} (${bookingData.planAppts} Appointment)<br><small style="color:var(--muted-text);font-weight:500;">₹${bookingData.perRate} per session</small>`;
    document.getElementById('revDateTimeVal').innerText = `${bookingData.dateText}, ${bookingData.slotTime}`;
    document.getElementById('revAddressVal').innerHTML = `${bookingData.addrTitle}<br><small style="color:var(--muted-text);font-weight:500;">${bookingData.addrFull}</small>`;
    document.getElementById('revPatientVal').innerHTML = `${bookingData.patientName}<br><small style="color:var(--muted-text);font-weight:500;">${bookingData.patientEmail} | ${bookingData.patientPhone}</small>`;

    let docFeeVal = Math.round(bookingData.planPrice * 0.82);
    let adminFeeVal = Math.round(bookingData.planPrice - docFeeVal);
    document.getElementById('revDocFee').innerText = `₹${docFeeVal.toFixed(2)}`;
    document.getElementById('revAdminFee').innerText = `₹${adminFeeVal.toFixed(2)}`;
    document.getElementById('revTotalPrice').innerText = `₹${bookingData.planPrice.toFixed(2)}`;
}

// Process Payment Animation & Complete Booking
function startPaymentProcess() {
    goToStep(6);

    // Progressive checklist ticks matching mockup
    setTimeout(() => {
        let chk4 = document.getElementById('chkStep4');
        if (chk4) {
            chk4.className = 'fa-solid fa-circle-check check';
        }
    }, 1500);

    // Try backend submission in background
    let token = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
    let fd = new FormData();
    fd.append('_token', token);
    fd.append('doctor_id', '{{ $doctor->id }}');
    fd.append('plan_id', bookingData.planId);
    fd.append('slot_ids[]', bookingData.slotId);
    fd.append('booking_for', 'self');
    fd.append('address', bookingData.addrFull);
    fd.append('problem_description', bookingData.patientNotes);

    fetch("{{ route('doctor.book') }}", {
        method: "POST",
        body: fd,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).catch(e => console.log('Mock fallback for front preview'));

    // Move to Success step after short simulated gateway confirmation
    setTimeout(() => {
        document.getElementById('sucDateTime').innerText = `${bookingData.dateText}, ${bookingData.slotTime}`;
        document.getElementById('sucPackage').innerText = `${bookingData.planName} (${bookingData.planAppts} Appointment)`;
        document.getElementById('sucAddress').innerText = bookingData.addrFull;
        document.getElementById('sucAmount').innerText = `₹${bookingData.planPrice.toFixed(2)}`;
        goToStep(7);
    }, 2200);
}
</script>

@endsection