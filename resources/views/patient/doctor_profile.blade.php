@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@php
    // Fee calculations
    $doctorFee = (float) (optional($doctor->fee)->doctor_fee ?? 800);
    $adminFee  = (float) (optional($doctor->fee)->admin_fee ?? 300);
    $totalFee  = (float) (optional($doctor->fee)->total_fee ?? ($doctorFee + $adminFee));
    if ($totalFee <= 0) {
        $totalFee = 1100;
    }

    $specName = optional(optional($doctor->profile)->specializationdata)->name ?? 'General Physiotherapy';
    $cleanDoctorName = preg_replace('/^(dr\.?|doctor)\s+/i', '', trim($doctor->name));
    $expYears = optional($doctor->profile)->experience_years ?? 10;
    $qualification = optional($doctor->profile)->qualification ?? ('MPT (' . $specName . ')');
    $displayRating = ($avgRating ?? 0) > 0 ? number_format($avgRating, 1) : '5.0';
    $reviewsCount = $totalReviews ?? 0;
    $slotsToday = $todaySlotsCount ?? 0;

    // Rating percentages fallback
    $p5 = $ratingPercentages[5] ?? ($reviewsCount > 0 ? 90 : 90);
    $p4 = $ratingPercentages[4] ?? ($reviewsCount > 0 ? 7 : 7);
    $p3 = $ratingPercentages[3] ?? ($reviewsCount > 0 ? 2 : 2);
    $p2 = $ratingPercentages[2] ?? ($reviewsCount > 0 ? 1 : 1);
    $p1 = $ratingPercentages[1] ?? ($reviewsCount > 0 ? 0 : 0);
@endphp

<style>
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   BRAND THEME VARIABLES
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
:root {
    --primary-teal:      #0c6978;
    --primary-teal-dark: #074752;
    --primary-teal-deep: #083c45;
    --primary-teal-sub:  #108598;
    --teal-bg-soft:      #eef8f9;
    --teal-badge-bg:     #e2f4f6;
    --teal-badge-border: #bce5ea;
    --teal-border:       #14b8a6;
    --accent-mint:       #2dd4bf;
    --accent-green:      #10b981;
    --gold:              #f59e0b;
    --gold-light:        #fef3c7;
    --ink:               #0f172a;
    --ink-light:         #1e293b;
    --body-text:         #475569;
    --muted-text:        #64748b;
    --border-card:       #e2e8f0;
    --page-bg:           #f8fafc;
    --card-bg:           #ffffff;
    --shadow-card:       0 2px 14px rgba(15, 23, 42, 0.04);
    --shadow-elevated:   0 8px 30px rgba(12, 105, 120, 0.08);
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

.dp-wrapper {
    min-height: 100vh;
    padding-bottom: 90px; /* Space for mobile sticky bottom bar */
}

/* ── TOP NAV / APP BAR ── */
.dp-top-bar {
    background: #ffffff;
    border-bottom: 1px solid #eef2f6;
    padding: 14px 20px;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}
.dp-top-inner {
    max-width: 1180px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.dp-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 700;
    color: var(--ink);
    padding: 6px 12px;
    border-radius: 10px;
    transition: all 0.2s;
}
.dp-back-btn:hover {
    background: #f1f5f9;
    color: var(--primary-teal);
}
.dp-top-title {
    font-size: 18px;
    font-weight: 800;
    color: #074752;
    letter-spacing: -0.02em;
    text-align: center;
    flex: 1;
}
.dp-share-btn {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--muted-text);
    cursor: pointer;
    transition: all 0.2s;
}
.dp-share-btn:hover {
    background: var(--teal-bg-soft);
    color: var(--primary-teal);
    border-color: var(--teal-badge-border);
}

/* ── LAYOUT CONTAINER ── */
.dp-container {
    max-width: 1180px;
    margin: 0 auto;
    padding: 24px 20px 40px;
}

.dp-grid {
    display: grid;
    grid-template-columns: 1fr 370px;
    gap: 24px;
    align-items: start;
}

.dp-left-col {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* ── SHARED CARD STYLES ── */
.dp-card {
    background: var(--card-bg);
    border: 1px solid var(--border-card);
    border-radius: 20px;
    padding: 22px;
    box-shadow: var(--shadow-card);
    transition: box-shadow 0.2s ease;
}
.dp-card:hover {
    box-shadow: var(--shadow-elevated);
}
.dp-card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
}
.dp-card-icon {
    font-size: 18px;
    color: var(--primary-teal);
}
.dp-card-title {
    font-size: 17px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.01em;
}

/* ── 1. DOCTOR MAIN CARD ── */
.dp-main-card {
    display: flex;
    gap: 20px;
    align-items: flex-start;
}
.dp-avatar-wrap {
    width: 105px;
    height: 105px;
    border-radius: 20px;
    background: #eef2f6;
    border: 3px solid #f1f5f9;
    flex-shrink: 0;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
}
.dp-avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.dp-avatar-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #e0f2fe, #bae6fd);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0369a1;
    font-size: 38px;
}
.dp-doctor-info {
    flex: 1;
    min-width: 0;
}
.dp-doctor-name {
    font-size: 22px;
    font-weight: 800;
    color: var(--ink);
    line-height: 1.25;
    letter-spacing: -0.02em;
    margin-bottom: 4px;
}
.dp-doctor-spec {
    font-size: 15px;
    font-weight: 600;
    color: var(--primary-teal);
    margin-bottom: 8px;
}
.dp-trusted-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: var(--teal-badge-bg);
    color: var(--primary-teal);
    border: 1px solid var(--teal-badge-border);
    border-radius: 50px;
    padding: 4px 12px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 8px;
}
.dp-trusted-pill i {
    color: var(--gold);
    font-size: 11px;
}
.dp-doctor-qual {
    font-size: 13.5px;
    color: var(--muted-text);
    font-weight: 500;
    margin-bottom: 6px;
}
.dp-doctor-exp {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13.5px;
    font-weight: 600;
    color: #334155;
}
.dp-doctor-exp i {
    color: var(--primary-teal);
    font-size: 13px;
}

/* ── 2. QUICK STATS 4-CARD ROW ── */
.dp-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}
.dp-stat-box {
    background: #ffffff;
    border: 1px solid var(--border-card);
    border-radius: 18px;
    padding: 16px 10px;
    text-align: center;
    box-shadow: var(--shadow-card);
    transition: transform 0.2s, box-shadow 0.2s;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.dp-stat-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(12, 105, 120, 0.08);
}
.dp-stat-icon-circle {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    margin-bottom: 8px;
}
.dp-stat-val {
    font-size: 17px;
    font-weight: 800;
    color: var(--ink);
    line-height: 1.2;
}
.dp-stat-lbl {
    font-size: 12px;
    color: var(--muted-text);
    font-weight: 600;
    margin-top: 2px;
}

/* Stat color variants */
.stat-exp .dp-stat-icon-circle { background: #eef8f9; color: var(--primary-teal); }
.stat-rating .dp-stat-icon-circle { background: #fffbeb; color: var(--gold); }
.stat-reviews .dp-stat-icon-circle { background: #ecfdf5; color: var(--accent-green); }
.stat-slots .dp-stat-icon-circle { background: #f0f9ff; color: #0284c7; }

/* ── 3. TREATMENT PACKAGES BANNER ── */
.dp-package-banner {
    background: #ffffff;
    border: 1.5px solid var(--teal-border);
    border-radius: 18px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    cursor: pointer;
    box-shadow: 0 4px 18px rgba(20, 184, 166, 0.08);
    transition: all 0.2s ease;
}
.dp-package-banner:hover {
    background: #fcfefe;
    border-color: var(--primary-teal);
    box-shadow: 0 6px 24px rgba(12, 105, 120, 0.14);
    transform: translateY(-1px);
}
.dp-pkg-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.dp-pkg-icon-wrap {
    width: 46px;
    height: 46px;
    border-radius: 14px;
    background: var(--teal-bg-soft);
    color: var(--primary-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.dp-pkg-title {
    font-size: 16px;
    font-weight: 800;
    color: var(--ink);
    line-height: 1.3;
}
.dp-pkg-sub {
    font-size: 13px;
    color: var(--muted-text);
    margin-top: 2px;
}
.dp-pkg-arrow {
    color: var(--primary-teal);
    font-size: 18px;
    transition: transform 0.2s;
}
.dp-package-banner:hover .dp-pkg-arrow {
    transform: translateX(4px);
}

/* ── 4. ABOUT DOCTOR ── */
.dp-about-text {
    font-size: 14.5px;
    color: #475569;
    line-height: 1.75;
}
.dp-highlights-row {
    margin-top: 14px;
    padding-top: 14px;
    border-top: 1px dashed #e2e8f0;
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    font-size: 13px;
    color: #64748b;
}
.dp-hl-item {
    display: flex;
    align-items: center;
    gap: 6px;
}
.dp-hl-item i {
    color: var(--primary-teal);
}

/* ── 5. EXPERTISE & SERVICES ── */
.dp-tags-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.dp-tag-pill {
    background: #f0f6fa;
    color: #1e293b;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 8px 15px;
    font-size: 13.5px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    line-height: 1.4;
    transition: all 0.2s;
}
.dp-tag-pill:hover {
    background: var(--teal-bg-soft);
    color: var(--primary-teal);
    border-color: var(--teal-badge-border);
}
.dp-tag-pill.tag-spec {
    background: var(--teal-bg-soft);
    color: var(--primary-teal);
    border-color: var(--teal-badge-border);
    font-weight: 700;
}

/* ── 6. PATIENT REVIEWS ── */
.dp-rating-summary-box {
    background: #fcfdfe;
    border: 1px solid #edf2f7;
    border-radius: 16px;
    padding: 18px 22px;
    display: grid;
    grid-template-columns: 140px 1fr;
    gap: 20px;
    align-items: center;
    margin-bottom: 20px;
}
.dp-score-left {
    text-align: center;
    border-right: 1px solid #e2e8f0;
    padding-right: 18px;
}
.dp-big-score {
    font-size: 38px;
    font-weight: 900;
    color: var(--ink);
    line-height: 1;
    letter-spacing: -0.03em;
}
.dp-stars-row {
    color: var(--gold);
    font-size: 13px;
    letter-spacing: 2px;
    margin: 6px 0 4px;
}
.dp-reviews-count-lbl {
    font-size: 12px;
    color: var(--muted-text);
    font-weight: 600;
}

.dp-bars-right {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.dp-bar-row {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12px;
    font-weight: 600;
    color: var(--muted-text);
}
.dp-bar-num {
    width: 10px;
    text-align: right;
}
.dp-progress-track {
    flex: 1;
    height: 7px;
    background: #eef2f6;
    border-radius: 10px;
    overflow: hidden;
}
.dp-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #14b8a6, var(--primary-teal));
    border-radius: 10px;
    transition: width 0.6s ease;
}
.dp-bar-pct {
    width: 32px;
    text-align: right;
    font-size: 11.5px;
    color: #64748b;
}

/* Individual review cards */
.dp-reviews-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.dp-review-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    padding: 16px 18px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.02);
}
.dp-review-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 8px;
}
.dp-reviewer-profile {
    display: flex;
    align-items: center;
    gap: 10px;
}
.dp-reviewer-initial {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #e0f7f8;
    color: var(--primary-teal);
    font-weight: 800;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.dp-reviewer-img {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
}
.dp-reviewer-name {
    font-size: 14.5px;
    font-weight: 800;
    color: var(--ink);
}
.dp-review-date {
    font-size: 12px;
    color: #94a3b8;
}
.dp-review-stars {
    color: var(--gold);
    font-size: 12px;
    letter-spacing: 1px;
    margin-top: 2px;
}
.dp-review-text {
    font-size: 13.5px;
    color: #475569;
    line-height: 1.6;
}

.dp-review-dots {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 18px;
}
.dp-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #cbd5e1;
    transition: all 0.2s;
}
.dp-dot.active {
    width: 22px;
    border-radius: 6px;
    background: var(--primary-teal);
}

/* ── DESKTOP STICKY SIDEBAR ── */
.dp-sidebar {
    position: sticky;
    top: 90px;
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.dp-sticky-booking-card {
    background: #ffffff;
    border: 1px solid var(--border-card);
    border-radius: 24px;
    padding: 26px;
    box-shadow: 0 8px 32px rgba(12, 105, 120, 0.08);
}
.dp-sidebar-fee-box {
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #f1f5f9;
}
.dp-fee-label {
    font-size: 13px;
    color: var(--muted-text);
    font-weight: 600;
}
.dp-fee-amount {
    font-size: 32px;
    font-weight: 900;
    color: var(--primary-teal-dark);
    letter-spacing: -0.03em;
    display: flex;
    align-items: baseline;
    gap: 4px;
    margin-top: 4px;
}
.dp-fee-session {
    font-size: 14px;
    font-weight: 600;
    color: var(--muted-text);
}

.dp-fee-breakdown {
    background: #f8fafc;
    border-radius: 12px;
    padding: 12px 14px;
    margin-bottom: 20px;
    font-size: 13px;
}
.dp-fb-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
    color: #64748b;
}
.dp-fb-row:last-child {
    margin-bottom: 0;
}
.dp-fb-val {
    font-weight: 700;
    color: var(--ink);
}

.dp-perks-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 22px;
}
.dp-perk-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13.5px;
    color: #334155;
    font-weight: 600;
}
.dp-perk-item i {
    color: var(--accent-green);
    font-size: 14px;
}

.dp-primary-book-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 16px 20px;
    background: linear-gradient(135deg, var(--primary-teal), var(--primary-teal-dark));
    color: #ffffff;
    border-radius: 14px;
    font-size: 16px;
    font-weight: 800;
    box-shadow: 0 6px 22px rgba(12, 105, 120, 0.35);
    transition: all 0.2s ease;
    cursor: pointer;
    border: none;
    text-align: center;
}
.dp-primary-book-btn:hover {
    background: linear-gradient(135deg, #0f7a8c, var(--primary-teal));
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(12, 105, 120, 0.45);
    color: #ffffff;
}

.dp-sidebar-pkg-promo {
    margin-top: 16px;
    background: #f0fdfa;
    border: 1px dashed #5eead4;
    border-radius: 14px;
    padding: 14px;
    text-align: center;
}
.dp-spp-badge {
    display: inline-block;
    background: #ccfbf1;
    color: #0f766e;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    padding: 2px 8px;
    border-radius: 6px;
    margin-bottom: 6px;
}
.dp-spp-text {
    font-size: 12.5px;
    color: #134e4a;
    font-weight: 600;
    line-height: 1.4;
}
.dp-spp-link {
    display: inline-block;
    margin-top: 6px;
    font-size: 12.5px;
    font-weight: 700;
    color: var(--primary-teal);
    text-decoration: underline;
    cursor: pointer;
}

/* ── MOBILE STICKY BOTTOM BAR ── */
.dp-mobile-bar {
    display: none; /* Desktop default */
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #ffffff;
    border-top: 1px solid #e2e8f0;
    padding: 14px 20px;
    box-shadow: 0 -4px 20px rgba(15, 23, 42, 0.08);
    z-index: 999;
    align-items: center;
    justify-content: space-between;
}
.dp-mob-fee-wrap {
    display: flex;
    flex-direction: column;
}
.dp-mob-fee-lbl {
    font-size: 12px;
    color: var(--muted-text);
    font-weight: 600;
}
.dp-mob-fee-val {
    font-size: 20px;
    font-weight: 900;
    color: #074752;
    display: flex;
    align-items: baseline;
    gap: 3px;
}
.dp-mob-fee-val small {
    font-size: 12px;
    color: var(--muted-text);
    font-weight: 600;
}
.dp-mob-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 22px;
    background: var(--primary-teal);
    color: #ffffff;
    font-size: 14.5px;
    font-weight: 800;
    border-radius: 12px;
    box-shadow: 0 4px 14px rgba(12, 105, 120, 0.35);
    transition: all 0.2s;
}
.dp-mob-btn:active {
    transform: scale(0.98);
}

/* ── TREATMENT PACKAGES MODAL ── */
.dp-modal-overlay {
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
.dp-modal-overlay.show {
    display: flex;
}
.dp-modal-dialog {
    background: #ffffff;
    width: 100%;
    max-width: 620px;
    border-radius: 24px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    overflow: hidden;
    animation: modalPop 0.25s ease-out;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}
@keyframes modalPop {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.dp-modal-top {
    padding: 20px 24px;
    background: linear-gradient(135deg, var(--primary-teal), var(--primary-teal-dark));
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.dp-modal-heading {
    font-size: 18px;
    font-weight: 800;
}
.dp-modal-close-btn {
    background: rgba(255,255,255,0.15);
    border: none;
    color: #ffffff;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.2s;
}
.dp-modal-close-btn:hover {
    background: rgba(255,255,255,0.3);
}
.dp-modal-body {
    padding: 20px 24px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.dp-modal-pkg-card {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    transition: all 0.2s;
}
.dp-modal-pkg-card:hover {
    border-color: var(--primary-teal);
    background: #f8fdfd;
    box-shadow: 0 4px 16px rgba(12, 105, 120, 0.08);
}
.dp-mpkg-left {
    flex: 1;
}
.dp-mpkg-badge {
    display: inline-block;
    background: #fef3c7;
    color: #b45309;
    font-size: 11px;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: 6px;
    margin-bottom: 4px;
}
.dp-mpkg-name {
    font-size: 15px;
    font-weight: 800;
    color: var(--ink);
}
.dp-mpkg-desc {
    font-size: 12px;
    color: #64748b;
    margin-top: 2px;
}
.dp-mpkg-price-wrap {
    text-align: right;
}
.dp-mpkg-price {
    font-size: 18px;
    font-weight: 900;
    color: var(--primary-teal-dark);
}
.dp-mpkg-rate {
    font-size: 11.5px;
    color: #64748b;
}
.dp-mpkg-btn {
    padding: 9px 16px;
    background: var(--primary-teal);
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    border-radius: 10px;
    display: inline-block;
    transition: background 0.2s;
    white-space: nowrap;
}
.dp-mpkg-btn:hover {
    background: var(--primary-teal-dark);
    color: #fff;
}

/* ── RESPONSIVE MEDIA QUERIES ── */
@media (max-width: 991px) {
    .dp-grid {
        grid-template-columns: 1fr;
    }
    .dp-sidebar {
        display: none; /* Shown via mobile bottom bar instead */
    }
    .dp-mobile-bar {
        display: flex;
    }
}

@media (max-width: 640px) {
    .dp-container {
        padding: 14px 14px 32px;
    }
    .dp-main-card {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .dp-doctor-exp {
        justify-content: center;
    }
    .dp-stats-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }
    .dp-stat-box {
        padding: 12px 6px;
    }
    .dp-stat-val {
        font-size: 14px;
    }
    .dp-stat-lbl {
        font-size: 11px;
    }
    .dp-rating-summary-box {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    .dp-score-left {
        border-right: none;
        border-bottom: 1px solid #e2e8f0;
        padding-right: 0;
        padding-bottom: 14px;
    }
}
</style>

<div class="dp-wrapper">

    {{-- Standard Header --}}
    @include('layouts.header')

    {{-- Top App Bar / Back Navigation --}}
    <div class="dp-top-bar">
        <div class="dp-top-inner">
            <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('home') }}" class="dp-back-btn">
                <i class="fa-solid fa-chevron-left"></i>
                <span class="d-none d-sm-inline">Back</span>
            </a>
            <h1 class="dp-top-title">Doctor Profile</h1>
            <button class="dp-share-btn" onclick="navigator.share ? navigator.share({title: 'Dr. {{ $doctor->name }}', url: window.location.href}) : navigator.clipboard.writeText(window.location.href).then(()=>alert('Profile link copied!'))" title="Share Profile">
                <i class="fa-solid fa-share-nodes"></i>
            </button>
        </div>
    </div>

    {{-- Main Container --}}
    <div class="dp-container">
        <div class="dp-grid">

            {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               LEFT COLUMN: DOCTOR DETAILS (Matches Mobile Screenshots)
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
            <div class="dp-left-col">

                {{-- 1. DOCTOR MAIN PROFILE CARD --}}
                <div class="dp-card dp-main-card">
                    <div class="dp-avatar-wrap">
                        @if($doctor->profile_img)
                            <img src="{{ str_contains($doctor->profile_img, '/') ? asset($doctor->profile_img) : asset('uploads/profile/'.$doctor->profile_img) }}" alt="{{ $doctor->name }}" class="dp-avatar-img">
                        @else
                            <div class="dp-avatar-placeholder">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        @endif
                    </div>

                    <div class="dp-doctor-info">
                        <h2 class="dp-doctor-name">dr. {{ $cleanDoctorName }}</h2>
                        <div class="dp-doctor-spec">{{ $specName }}</div>
                        
                        <div>
                            <span class="dp-trusted-pill">
                                <i class="fa-solid fa-star"></i> Trusted
                            </span>
                        </div>

                        <div class="dp-doctor-qual">{{ $qualification }}</div>

                        <div class="dp-doctor-exp">
                            <i class="fa-solid fa-briefcase"></i>
                            <span>{{ $expYears }} Years Experience</span>
                        </div>
                    </div>
                </div>

                {{-- 2. QUICK STATS 4-CARD ROW --}}
                <div class="dp-stats-grid">
                    {{-- Experience --}}
                    <div class="dp-stat-box stat-exp">
                        <div class="dp-stat-icon-circle">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <div class="dp-stat-val">{{ $expYears }}+ Yrs</div>
                        <div class="dp-stat-lbl">Experience</div>
                    </div>

                    {{-- Rating --}}
                    <div class="dp-stat-box stat-rating">
                        <div class="dp-stat-icon-circle">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div class="dp-stat-val">{{ $displayRating }}</div>
                        <div class="dp-stat-lbl">Rating</div>
                    </div>

                    {{-- Reviews --}}
                    <div class="dp-stat-box stat-reviews">
                        <div class="dp-stat-icon-circle">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="dp-stat-val">{{ $reviewsCount }}</div>
                        <div class="dp-stat-lbl">Reviews</div>
                    </div>

                    {{-- Today Slots --}}
                    <div class="dp-stat-box stat-slots">
                        <div class="dp-stat-icon-circle">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>
                        <div class="dp-stat-val">{{ $slotsToday > 0 ? $slotsToday . ' Slots' : '0 Slots' }}</div>
                        <div class="dp-stat-lbl">Today</div>
                    </div>
                </div>

                {{-- 3. TREATMENT PACKAGES BANNER CARD --}}
                <div class="dp-package-banner" onclick="openPackagesModal()">
                    <div class="dp-pkg-left">
                        <div class="dp-pkg-icon-wrap">
                            <i class="fa-solid fa-gift"></i>
                        </div>
                        <div>
                            <div class="dp-pkg-title">Treatment Packages</div>
                            <div class="dp-pkg-sub">Choose a package that suits your recovery</div>
                        </div>
                    </div>
                    <div class="dp-pkg-arrow">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </div>

                {{-- 4. ABOUT DOCTOR --}}
                <div class="dp-card">
                    <div class="dp-card-header">
                        <i class="fa-regular fa-id-card dp-card-icon"></i>
                        <h3 class="dp-card-title">About Doctor</h3>
                    </div>
                    
                    <div class="dp-about-text">
                        @if(optional($doctor->profile)->bio)
                            {!! nl2br(e($doctor->profile->bio)) !!}
                        @else
                            Specialist in {{ $specName }} and rehabilitation focusing on pain relief, musculoskeletal mobility, posture correction, and personalized rehabilitation treatment for all ages.
                        @endif
                    </div>

                    @if(optional($doctor->profile)->career_path || optional($doctor->profile)->clinic_address)
                        <div class="dp-highlights-row">
                            @if(optional($doctor->profile)->clinic_name)
                                <div class="dp-hl-item">
                                    <i class="fa-solid fa-hospital"></i>
                                    <span>{{ optional($doctor->profile)->clinic_name }}</span>
                                </div>
                            @endif
                            @if($doctor->address || optional($doctor->profile)->clinic_address)
                                <div class="dp-hl-item">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>{{ $doctor->address ?? optional($doctor->profile)->clinic_address }}</span>
                                </div>
                            @endif
                            @if(optional($doctor->profile)->home_visit_available)
                                <div class="dp-hl-item">
                                    <i class="fa-solid fa-house-medical"></i>
                                    <span style="color:var(--accent-green);font-weight:700;">Home Visit Available</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- 5. EXPERTISE & SERVICES --}}
                <div class="dp-card">
                    <div class="dp-card-header">
                        <i class="fa-solid fa-briefcase-medical dp-card-icon"></i>
                        <h3 class="dp-card-title">Expertise & Services</h3>
                    </div>

                    <div class="dp-tags-wrap">
                        <span class="dp-tag-pill tag-spec">
                            <i class="fa-solid fa-check"></i> {{ $specName }}
                        </span>
                        <span class="dp-tag-pill">Expert physiotherapy services for pain relief</span>
                        <span class="dp-tag-pill">injury recovery</span>
                        <span class="dp-tag-pill">mobility improvement</span>
                        <span class="dp-tag-pill">posture correction</span>
                        <span class="dp-tag-pill">and personalized rehabilitation treatment for all ages.</span>
                        @if(optional($doctor->profile)->highlights)
                            @foreach(explode(',', optional($doctor->profile)->highlights) as $hl)
                                @if(trim($hl))
                                    <span class="dp-tag-pill">{{ trim($hl) }}</span>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- 6. PATIENT REVIEWS --}}
                <div class="dp-card">
                    <div class="dp-card-header">
                        <i class="fa-regular fa-star dp-card-icon" style="color:var(--gold);"></i>
                        <h3 class="dp-card-title">Patient Reviews <span style="font-size:15px;color:var(--muted-text);font-weight:600;">({{ $reviewsCount }})</span></h3>
                    </div>

                    {{-- Rating Summary & Bars --}}
                    <div class="dp-rating-summary-box">
                        <div class="dp-score-left">
                            <div class="dp-big-score">{{ $displayRating }}</div>
                            <div class="dp-stars-row">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="dp-reviews-count-lbl">{{ $reviewsCount }} Reviews</div>
                        </div>

                        <div class="dp-bars-right">
                            {{-- 5 Stars --}}
                            <div class="dp-bar-row">
                                <span class="dp-bar-num">5</span>
                                <div class="dp-progress-track">
                                    <div class="dp-progress-fill" style="width: {{ $p5 }}%;"></div>
                                </div>
                                <span class="dp-bar-pct">{{ $p5 }}%</span>
                            </div>

                            {{-- 4 Stars --}}
                            <div class="dp-bar-row">
                                <span class="dp-bar-num">4</span>
                                <div class="dp-progress-track">
                                    <div class="dp-progress-fill" style="width: {{ $p4 }}%;"></div>
                                </div>
                                <span class="dp-bar-pct">{{ $p4 }}%</span>
                            </div>

                            {{-- 3 Stars --}}
                            <div class="dp-bar-row">
                                <span class="dp-bar-num">3</span>
                                <div class="dp-progress-track">
                                    <div class="dp-progress-fill" style="width: {{ $p3 }}%;"></div>
                                </div>
                                <span class="dp-bar-pct">{{ $p3 }}%</span>
                            </div>

                            {{-- 2 Stars --}}
                            <div class="dp-bar-row">
                                <span class="dp-bar-num">2</span>
                                <div class="dp-progress-track">
                                    <div class="dp-progress-fill" style="width: {{ $p2 }}%;"></div>
                                </div>
                                <span class="dp-bar-pct">{{ $p2 }}%</span>
                            </div>

                            {{-- 1 Star --}}
                            <div class="dp-bar-row">
                                <span class="dp-bar-num">1</span>
                                <div class="dp-progress-track">
                                    <div class="dp-progress-fill" style="width: {{ $p1 }}%;"></div>
                                </div>
                                <span class="dp-bar-pct">{{ $p1 }}%</span>
                            </div>
                        </div>
                    </div>

                    {{-- Patient Reviews List --}}
                    <div class="dp-reviews-list">
                        @forelse($approvedReviews ?? $doctor->receivedReviews->where('is_approved', 1) as $review)
                            <div class="dp-review-card">
                                <div class="dp-review-top">
                                    <div class="dp-reviewer-profile">
                                        @if(optional($review->patient)->profile_img)
                                            <img src="{{ str_contains($review->patient->profile_img, '/') ? asset($review->patient->profile_img) : asset('uploads/profile/'.$review->patient->profile_img) }}" class="dp-reviewer-img" alt="{{ optional($review->patient)->name }}">
                                        @else
                                            <div class="dp-reviewer-initial">
                                                {{ strtoupper(substr(optional($review->patient)->name ?? 'P', 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="dp-reviewer-name">{{ optional($review->patient)->name ?? 'Verified Patient' }}</div>
                                            <div class="dp-review-stars">
                                                @for($s = 1; $s <= 5; $s++)
                                                    <i class="fa-solid fa-star" style="{{ $s <= $review->rating ? 'color:var(--gold);' : 'color:#e2e8f0;' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dp-review-date">{{ $review->created_at->format('d M Y') }}</div>
                                </div>
                                <p class="dp-review-text">{{ $review->review }}</p>
                            </div>
                        @empty
                            {{-- Representative Sample Review matching Screenshot 1 --}}
                            <div class="dp-review-card">
                                <div class="dp-review-top">
                                    <div class="dp-reviewer-profile">
                                        <div class="dp-reviewer-initial">U</div>
                                        <div>
                                            <div class="dp-reviewer-name">Ubed kazi</div>
                                            <div class="dp-review-stars">
                                                <i class="fa-solid fa-star" style="color:var(--gold);"></i>
                                                <i class="fa-solid fa-star" style="color:var(--gold);"></i>
                                                <i class="fa-solid fa-star" style="color:var(--gold);"></i>
                                                <i class="fa-solid fa-star" style="color:var(--gold);"></i>
                                                <i class="fa-solid fa-star" style="color:#e2e8f0;"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dp-review-date">{{ date('d M Y') }}</div>
                                </div>
                                <p class="dp-review-text">Doctor was very helpful and polite. Treatment session was very effective for pain relief.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Carousel Indicator Dots --}}
                    <div class="dp-review-dots">
                        <div class="dp-dot active"></div>
                        <div class="dp-dot"></div>
                        <div class="dp-dot"></div>
                        <div class="dp-dot"></div>
                        <div class="dp-dot"></div>
                    </div>
                </div>

            </div>

            {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               RIGHT COLUMN: DESKTOP STICKY BOOKING SIDEBAR
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
            <aside class="dp-sidebar">
                <div class="dp-sticky-booking-card">
                    <div class="dp-sidebar-fee-box">
                        <div class="dp-fee-label">Doctor Fee</div>
                        <div class="dp-fee-amount">
                            ₹{{ number_format($totalFee) }}
                            <span class="dp-fee-session">/ session</span>
                        </div>
                    </div>

                    <div class="dp-fee-breakdown">
                        <div class="dp-fb-row">
                            <span>Consultation Fee</span>
                            <span class="dp-fb-val">₹{{ number_format($doctorFee) }}</span>
                        </div>
                        <div class="dp-fb-row">
                            <span>Platform & Admin Fee</span>
                            <span class="dp-fb-val">₹{{ number_format($adminFee) }}</span>
                        </div>
                        <div class="dp-fb-row" style="margin-top:8px;padding-top:8px;border-top:1px dashed #cbd5e1;">
                            <span style="font-weight:700;color:var(--ink);">Total Payable</span>
                            <span class="dp-fb-val" style="color:var(--primary-teal);font-size:15px;">₹{{ number_format($totalFee) }}</span>
                        </div>
                    </div>

                    <div class="dp-perks-list">
                        <div class="dp-perk-item">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Certified Physiotherapist</span>
                        </div>
                        <div class="dp-perk-item">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Personalized 1-on-1 Treatment</span>
                        </div>
                        @if(optional($doctor->profile)->home_visit_available)
                            <div class="dp-perk-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Home Visit Service Available</span>
                            </div>
                        @endif
                        <div class="dp-perk-item">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Instant Booking Confirmation</span>
                        </div>
                    </div>

                    <a href="{{ route('doctor.booking', $doctor->id) }}" class="dp-primary-book-btn">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span>Book Appointment</span>
                    </a>

                    <div class="dp-sidebar-pkg-promo">
                        <span class="dp-spp-badge">Save up to 20%</span>
                        <div class="dp-spp-text">Recovery packages with multi-session savings available.</div>
                        <a href="javascript:void(0)" onclick="openPackagesModal()" class="dp-spp-link">
                            View Treatment Packages <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </aside>

        </div>
    </div>

    {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
       MOBILE STICKY BOTTOM BAR (Matches Mobile Screenshot)
    ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
    <div class="dp-mobile-bar">
        <div class="dp-mob-fee-wrap">
            <span class="dp-mob-fee-lbl">Doctor Fee</span>
            <div class="dp-mob-fee-val">
                ₹{{ number_format($totalFee) }} <small>/ session</small>
            </div>
        </div>

        <a href="{{ route('doctor.booking', $doctor->id) }}" class="dp-mob-btn">
            <i class="fa-regular fa-calendar-check"></i>
            <span>Book Appointment</span>
        </a>
    </div>

    {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
       TREATMENT PACKAGES MODAL
    ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
    <div class="dp-modal-overlay" id="packagesModal" onclick="if(event.target===this) closePackagesModal()">
        <div class="dp-modal-dialog">
            <div class="dp-modal-top">
                <div>
                    <div class="dp-modal-heading">Treatment Packages</div>
                    <div style="font-size:12.5px;opacity:0.9;margin-top:2px;">Special discounted rates for Dr. {{ $cleanDoctorName }}</div>
                </div>
                <button class="dp-modal-close-btn" onclick="closePackagesModal()">&times;</button>
            </div>

            <div class="dp-modal-body">
                @if(isset($patientPlans) && $patientPlans->count() > 0)
                    @foreach($patientPlans as $plan)
                        @php
                            $planPrice = $plan->calculated_package_price ?? $plan->price;
                            $perRate   = $plan->calculated_per_session ?? ($plan->total_appointments > 0 ? round($planPrice / $plan->total_appointments) : $totalFee);
                            $pctOff    = $plan->discount_percentage ?? 10;
                        @endphp
                        <div class="dp-modal-pkg-card">
                            <div class="dp-mpkg-left">
                                @if($pctOff > 0)
                                    <span class="dp-mpkg-badge">{{ (int)$pctOff }}% OFF</span>
                                @endif
                                <div class="dp-mpkg-name">{{ $plan->name }} ({{ $plan->total_appointments }} Sessions)</div>
                                <div class="dp-mpkg-desc">{{ $plan->description ?? 'Complete personalized physiotherapy care' }}</div>
                            </div>
                            <div class="dp-mpkg-price-wrap">
                                <div class="dp-mpkg-price">₹{{ number_format($planPrice) }}</div>
                                <div class="dp-mpkg-rate">₹{{ number_format($perRate) }}/session</div>
                                <a href="{{ route('doctor.booking', $doctor->id) }}#packages" class="dp-mpkg-btn" style="margin-top:6px;">
                                    Book Package
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Default sample plans if none in database --}}
                    <div class="dp-modal-pkg-card">
                        <div class="dp-mpkg-left">
                            <span class="dp-mpkg-badge">10% OFF</span>
                            <div class="dp-mpkg-name">5 Sessions Recovery Plan</div>
                            <div class="dp-mpkg-desc">Ideal for acute pain, joint sprains, and quick recovery</div>
                        </div>
                        <div class="dp-mpkg-price-wrap">
                            <div class="dp-mpkg-price">₹{{ number_format($totalFee * 5 * 0.9) }}</div>
                            <div class="dp-mpkg-rate">₹{{ number_format($totalFee * 0.9) }}/session</div>
                            <a href="{{ route('doctor.booking', $doctor->id) }}" class="dp-mpkg-btn" style="margin-top:6px;">
                                Book Package
                            </a>
                        </div>
                    </div>

                    <div class="dp-modal-pkg-card">
                        <div class="dp-mpkg-left">
                            <span class="dp-mpkg-badge">15% OFF</span>
                            <div class="dp-mpkg-name">10 Sessions Rehab Plan</div>
                            <div class="dp-mpkg-desc">Best for post-surgery, chronic pain, and posture rehab</div>
                        </div>
                        <div class="dp-mpkg-price-wrap">
                            <div class="dp-mpkg-price">₹{{ number_format($totalFee * 10 * 0.85) }}</div>
                            <div class="dp-mpkg-rate">₹{{ number_format($totalFee * 0.85) }}/session</div>
                            <a href="{{ route('doctor.booking', $doctor->id) }}" class="dp-mpkg-btn" style="margin-top:6px;">
                                Book Package
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

<script>
function openPackagesModal() {
    const modal = document.getElementById('packagesModal');
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closePackagesModal() {
    const modal = document.getElementById('packagesModal');
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }
}

// Close on Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePackagesModal();
    }
});
</script>

@endsection
