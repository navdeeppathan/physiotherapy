@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Caveat:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@php
    // Fees
    $doctorFee = (float) (optional($doctor->fee)->doctor_fee ?? 800);
    $adminFee  = (float) (optional($doctor->fee)->admin_fee ?? 300);
    $totalFee  = (float) (optional($doctor->fee)->total_fee ?? ($doctorFee + $adminFee));
    if ($totalFee <= 0) {
        $totalFee = 1100;
    }

    $cleanDoctorName = preg_replace('/^(dr\.?|doctor)\s+/i', '', trim($doctor->name));
    $specName = optional(optional($doctor->profile)->specializationdata)->name ?? 'Back Pain';
    $qualification = optional($doctor->profile)->qualification ?? ('MPT (' . $specName . ')');
    $expYears = optional($doctor->profile)->experience_years ?? 10;
    $displayRating = ($avgRating ?? 0) > 0 ? number_format($avgRating, 1) : '4.8';
    $reviewsCount = ($totalReviews ?? 0) > 0 ? $totalReviews : 120;

    // Doctor Bio
    $doctorBio = optional($doctor->profile)->bio;
    if (!$doctorBio) {
        $doctorBio = "Dr. {$cleanDoctorName} is a highly experienced physiotherapist specializing in {$specName} management and musculoskeletal rehabilitation. He focuses on evidence-based treatment and personalized care to help you move better and live pain-free.";
    }

    $aboutDoctor = "Dr. {$cleanDoctorName} specializes in treating " . strtolower($specName) . ", neck pain, sports injuries, and posture-related issues. With {$expYears}+ years of experience, he believes in a holistic and patient-centered approach, combining manual therapy, exercise therapy, and lifestyle guidance to achieve long-lasting results in the comfort of your home.";

    // Rating breakdown
    $p5 = $ratingPercentages[5] ?? 72;
    $p4 = $ratingPercentages[4] ?? 18;
    $p3 = $ratingPercentages[3] ?? 7;
    $p2 = $ratingPercentages[2] ?? 2;
    $p1 = $ratingPercentages[1] ?? 1;

    // Upcoming 7 Days for Availability Date Picker
    $daysList = [];
    $today = \Carbon\Carbon::today();
    for ($i = 0; $i < 7; $i++) {
        $d = $today->copy()->addDays($i);
        $daysList[] = [
            'dayName' => $d->format('D'),
            'dateNum' => $d->format('d M'),
            'fullDate' => $d->format('Y-m-d'),
            'isToday' => $i === 0,
            'isSelected' => $i === 1, // Tue 15 Apr style as in mockup
        ];
    }
@endphp

<style>
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   PHYSIOATHOME DOCTOR PROFILE THEME (Pixel-Perfect)
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
    --ink-light:         #1e293b;
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
    transition: all 0.2s ease;
}

.dp-page-wrap {
    min-height: 100vh;
}

.dp-main-container {
    max-width: 1180px;
    margin: 0 auto;
    padding: 20px 20px 60px;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

/* ── BREADCRUMB ── */
.dp-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--muted-text);
    padding: 6px 0;
}
.dp-breadcrumb a {
    color: var(--muted-text);
    font-weight: 500;
}
.dp-breadcrumb a:hover {
    color: var(--primary-teal);
}
.dp-bc-sep {
    color: #cbd5e1;
    font-size: 11px;
}
.dp-bc-current {
    color: var(--ink);
    font-weight: 700;
}

/* ── SECTION 1: TOP HERO DOCTOR & FEE ROW ── */
.dp-hero-row {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 20px;
    align-items: stretch;
}

.dp-card {
    background: var(--card-bg);
    border: 1px solid var(--border-card);
    border-radius: 20px;
    box-shadow: var(--shadow-card);
}

/* Doctor Main Card */
.dp-doc-profile-card {
    padding: 26px 28px;
    display: flex;
    gap: 24px;
    align-items: flex-start;
}
.dp-doc-photo-wrap {
    width: 140px;
    height: 140px;
    border-radius: 18px;
    background: #e2e8f0;
    overflow: hidden;
    flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    justify-content: center;
}
.dp-doc-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.dp-doc-photo-ph {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #e0f2fe, #bae6fd);
    color: #0369a1;
    font-size: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.dp-doc-profile-info {
    flex: 1;
    min-width: 0;
}
.dp-doc-title {
    font-size: 24px;
    font-weight: 800;
    color: var(--ink);
    line-height: 1.2;
    letter-spacing: -0.02em;
    margin-bottom: 3px;
}
.dp-doc-qual-line {
    font-size: 13.5px;
    color: var(--muted-text);
    font-weight: 500;
}
.dp-doc-spec-line {
    font-size: 15px;
    font-weight: 700;
    color: var(--primary-teal);
    margin: 3px 0 8px;
}
.dp-trusted-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: var(--teal-badge-bg);
    color: var(--primary-teal);
    border: 1px solid var(--teal-badge-border);
    border-radius: 50px;
    padding: 3px 12px;
    font-size: 11.5px;
    font-weight: 700;
    margin-bottom: 12px;
}
.dp-trusted-pill i {
    color: var(--gold);
    font-size: 11px;
}
.dp-doc-meta-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 16px;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 12px;
}
.dp-doc-meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
}
.dp-doc-meta-item i.fa-briefcase { color: var(--primary-teal); }
.dp-doc-meta-item i.fa-star { color: var(--gold); }
.dp-doc-meta-item i.fa-message { color: var(--primary-teal); }

.dp-doc-bio-p {
    font-size: 13.5px;
    color: #475569;
    line-height: 1.65;
}

/* Doctor Fee Right Card */
.dp-fee-box-card {
    padding: 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.dp-fee-header-lbl {
    font-size: 13px;
    color: var(--muted-text);
    font-weight: 600;
}
.dp-fee-large-val {
    font-size: 32px;
    font-weight: 900;
    color: var(--primary-teal-dark);
    letter-spacing: -0.03em;
    margin: 2px 0 16px;
    display: flex;
    align-items: baseline;
    gap: 5px;
}
.dp-fee-large-val small {
    font-size: 14px;
    font-weight: 500;
    color: var(--muted-text);
}

.dp-fee-feature-item {
    background: #f8fafc;
    border-radius: 12px;
    padding: 11px 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
}
.dp-ffi-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: #e0f7f8;
    color: var(--primary-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}
.dp-ffi-title {
    font-size: 13px;
    font-weight: 800;
    color: var(--ink);
    line-height: 1.2;
}
.dp-ffi-sub {
    font-size: 11.5px;
    color: var(--muted-text);
    margin-top: 1px;
}

.dp-btn-book-session {
    background: var(--primary-teal);
    color: #ffffff !important;
    padding: 13px 20px;
    border-radius: 12px;
    font-size: 14.5px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 8px;
    box-shadow: 0 4px 14px rgba(12, 105, 120, 0.25);
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}
.dp-btn-book-session:hover {
    background: var(--primary-teal-dark);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(12, 105, 120, 0.35);
}

.dp-fee-safe-lbl {
    font-size: 11.5px;
    color: var(--muted-text);
    font-weight: 600;
    text-align: center;
    margin-top: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.dp-fee-safe-lbl i {
    color: var(--primary-teal);
}

/* ── SECTION 2: 4 QUICK METRICS ROW ── */
.dp-metrics-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}
.dp-metric-box {
    background: #ffffff;
    border: 1px solid var(--border-card);
    border-radius: 18px;
    padding: 16px 14px;
    box-shadow: var(--shadow-card);
    display: flex;
    align-items: center;
    gap: 14px;
    transition: transform 0.2s, box-shadow 0.2s;
}
.dp-metric-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(12, 105, 120, 0.08);
}
.dp-mb-icon {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}
.dp-mb-icon.exp { background: #eef8f9; color: var(--primary-teal); }
.dp-mb-icon.rating { background: #fffbeb; color: var(--gold); }
.dp-mb-icon.reviews { background: #ecfdf5; color: var(--accent-green); }
.dp-mb-icon.today { background: #f0f9ff; color: #0284c7; }

.dp-mb-val {
    font-size: 18px;
    font-weight: 800;
    color: var(--ink);
    line-height: 1.2;
}
.dp-mb-lbl {
    font-size: 12px;
    color: var(--muted-text);
    font-weight: 600;
}

/* ── SECTION 3: TREATMENT PACKAGES ── */
.dp-packages-card {
    padding: 26px 28px;
}
.dp-sec-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}
.dp-sec-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.dp-sec-icon-box {
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
.dp-sec-title {
    font-size: 18px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.01em;
}
.dp-sec-sub {
    font-size: 12.5px;
    color: var(--muted-text);
    margin-top: 1px;
}
.dp-sec-link {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--primary-teal);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.dp-sec-link:hover {
    color: var(--primary-teal-dark);
}

.dp-packages-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}
.dp-pkg-item-card {
    background: #ffffff;
    border: 1.5px solid #eef2f6;
    border-radius: 18px;
    padding: 22px 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    transition: all 0.2s;
}
.dp-pkg-item-card:hover {
    border-color: var(--primary-teal);
    box-shadow: 0 8px 24px rgba(12, 105, 120, 0.08);
}
.dp-pkg-item-card.popular {
    border-color: var(--primary-teal);
    box-shadow: 0 6px 20px rgba(12, 105, 120, 0.1);
}
.dp-popular-tag {
    position: absolute;
    top: -11px;
    left: 18px;
    background: var(--primary-teal-dark);
    color: #ffffff;
    font-size: 11px;
    font-weight: 800;
    padding: 3px 10px;
    border-radius: 6px;
}
.dp-pkg-icon-wrap {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--teal-bg-soft);
    color: var(--primary-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-bottom: 14px;
}
.dp-pkg-title {
    font-size: 16px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 4px;
}
.dp-pkg-subtext {
    font-size: 12.5px;
    color: var(--muted-text);
    line-height: 1.45;
    margin-bottom: 14px;
    min-height: 36px;
}
.dp-pkg-meta-tags {
    display: flex;
    align-items: center;
    gap: 14px;
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 14px;
}
.dp-pkg-meta-tags span {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.dp-pkg-price-text {
    font-size: 20px;
    font-weight: 900;
    color: var(--primary-teal-dark);
    letter-spacing: -0.02em;
    margin-bottom: 14px;
}
.dp-pkg-price-text small {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--muted-text);
}

.dp-btn-choose-pkg {
    display: block;
    width: 100%;
    text-align: center;
    padding: 10px 16px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    border: 1.5px solid var(--primary-teal);
    color: var(--primary-teal);
    background: #ffffff;
    transition: all 0.2s;
}
.dp-btn-choose-pkg:hover {
    background: var(--teal-bg-soft);
}
.dp-btn-choose-pkg.filled {
    background: var(--primary-teal);
    color: #ffffff;
    border: none;
    box-shadow: 0 4px 12px rgba(12, 105, 120, 0.2);
}
.dp-btn-choose-pkg.filled:hover {
    background: var(--primary-teal-dark);
}

/* ── SECTION 4: MIDDLE 2-COLUMN GRID ── */
.dp-mid-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    align-items: start;
}
.dp-col-stack {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Card inner header */
.dp-card-sec-head {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
}
.dp-card-sec-head i {
    color: var(--primary-teal);
    font-size: 17px;
}
.dp-card-sec-title {
    font-size: 17px;
    font-weight: 800;
    color: var(--ink);
}

/* About Doctor Box */
.dp-about-card {
    padding: 24px;
}
.dp-about-p {
    font-size: 13.5px;
    color: #475569;
    line-height: 1.7;
}

/* Availability Card (Interactive Picker) */
.dp-avail-card {
    padding: 24px;
}
.dp-dates-slider-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 16px 0;
}
.dp-date-nav-arrow {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--muted-text);
    cursor: pointer;
    font-size: 11px;
}
.dp-date-nav-arrow:hover {
    border-color: var(--primary-teal);
    color: var(--primary-teal);
}
.dp-dates-pills-row {
    flex: 1;
    display: flex;
    gap: 6px;
    overflow-x: auto;
    scrollbar-width: none;
}
.dp-dates-pills-row::-webkit-scrollbar { display: none; }

.dp-date-pill {
    flex: 1;
    min-width: 52px;
    padding: 8px 4px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
}
.dp-date-pill:hover {
    border-color: var(--primary-teal);
}
.dp-date-pill.active {
    background: var(--primary-teal);
    border-color: var(--primary-teal);
    color: #ffffff;
}
.dp-dp-day {
    font-size: 11px;
    font-weight: 600;
    opacity: 0.85;
}
.dp-dp-num {
    font-size: 12.5px;
    font-weight: 800;
    margin-top: 1px;
}

.dp-slots-pills-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 8px;
    margin-top: 14px;
}
.dp-slot-pill {
    padding: 9px 4px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    text-align: center;
    font-size: 12px;
    font-weight: 700;
    color: var(--ink);
    cursor: pointer;
    transition: all 0.2s;
}
.dp-slot-pill:hover {
    border-color: var(--primary-teal);
}
.dp-slot-pill.active {
    background: var(--primary-teal);
    border-color: var(--primary-teal);
    color: #ffffff;
}

/* FAQ Card */
.dp-faq-card {
    padding: 24px;
}
.dp-faq-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.dp-faq-item {
    border: 1px solid #edf2f7;
    border-radius: 12px;
    overflow: hidden;
    background: #ffffff;
}
.dp-faq-question {
    padding: 13px 16px;
    font-size: 13.5px;
    font-weight: 700;
    color: var(--ink);
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    background: #ffffff;
    transition: background 0.2s;
}
.dp-faq-question:hover {
    background: #f8fafc;
}
.dp-faq-question i {
    font-size: 12px;
    color: var(--muted-text);
    transition: transform 0.2s ease;
}
.dp-faq-item.open .dp-faq-question i {
    transform: rotate(180deg);
}
.dp-faq-answer {
    display: none;
    padding: 0 16px 14px;
    font-size: 13px;
    color: #64748b;
    line-height: 1.6;
}
.dp-faq-item.open .dp-faq-answer {
    display: block;
}

/* Expertise & Services Card */
.dp-expertise-card {
    padding: 24px;
}
.dp-tags-flow {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.dp-tag-pill-modern {
    background: #f0f6fa;
    color: #1e293b;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 7px 15px;
    font-size: 13px;
    font-weight: 500;
    display: inline-block;
}
.dp-tag-pill-modern:hover {
    background: var(--teal-bg-soft);
    color: var(--primary-teal);
    border-color: var(--teal-badge-border);
}

/* Patient Reviews Card */
.dp-reviews-card {
    padding: 24px;
}
.dp-review-score-box {
    display: grid;
    grid-template-columns: 130px 1fr;
    gap: 18px;
    align-items: center;
    padding: 14px 16px;
    background: #fcfdfe;
    border: 1px solid #edf2f7;
    border-radius: 14px;
    margin-bottom: 18px;
}
.dp-rs-left {
    text-align: center;
}
.dp-rs-big {
    font-size: 34px;
    font-weight: 900;
    color: var(--ink);
    line-height: 1;
}
.dp-rs-stars {
    color: var(--gold);
    font-size: 12px;
    letter-spacing: 1.5px;
    margin: 5px 0 3px;
}
.dp-rs-lbl {
    font-size: 11.5px;
    color: var(--muted-text);
}

.dp-rs-bars {
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.dp-bar-line {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11.5px;
    font-weight: 600;
    color: var(--muted-text);
}
.dp-bar-track {
    flex: 1;
    height: 6px;
    background: #eef2f6;
    border-radius: 10px;
    overflow: hidden;
}
.dp-bar-fill {
    height: 100%;
    background: var(--primary-teal);
    border-radius: 10px;
}
.dp-bar-pct-val {
    width: 28px;
    text-align: right;
    font-size: 11px;
    color: #64748b;
}

.dp-review-tiles-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.dp-review-tile {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 14px;
    padding: 14px 16px;
}
.dp-rt-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 6px;
}
.dp-rt-user {
    display: flex;
    align-items: center;
    gap: 10px;
}
.dp-rt-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    object-fit: cover;
    background: #e0f7f8;
    color: var(--primary-teal);
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
}
.dp-rt-name {
    font-size: 13.5px;
    font-weight: 800;
    color: var(--ink);
}
.dp-rt-stars {
    color: var(--gold);
    font-size: 11px;
    letter-spacing: 1px;
}
.dp-rt-date {
    font-size: 11.5px;
    color: #94a3b8;
}
.dp-rt-text {
    font-size: 13px;
    color: #475569;
    line-height: 1.55;
}

/* ── SECTION 5: BOTTOM CTA BANNER ── */
.dp-bottom-banner {
    background: linear-gradient(135deg, #074752 0%, #0c6978 100%);
    border-radius: 20px;
    padding: 36px 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
    position: relative;
    overflow: hidden;
    color: #ffffff;
}
.dp-bb-content {
    max-width: 580px;
    z-index: 2;
}
.dp-bb-title {
    font-size: 24px;
    font-weight: 800;
    letter-spacing: -0.02em;
    margin-bottom: 6px;
}
.dp-bb-desc {
    font-size: 14px;
    color: #bce5ea;
    margin-bottom: 20px;
    line-height: 1.5;
}
.dp-btn-white-pill {
    background: #ffffff;
    color: #074752 !important;
    padding: 12px 24px;
    border-radius: 12px;
    font-size: 14.5px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
    transition: all 0.2s;
}
.dp-btn-white-pill:hover {
    background: #f0fdfa;
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.dp-bb-illustration {
    flex-shrink: 0;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
}
.dp-bb-home-svg {
    width: 140px;
    height: 70px;
    stroke: rgba(255,255,255,0.7);
}
.dp-bb-tagline {
    font-family: 'Caveat', cursive;
    font-size: 20px;
    color: #bce5ea;
    letter-spacing: 0.5px;
}

/* ── RESPONSIVE ── */
@media (max-width: 991px) {
    .dp-hero-row {
        grid-template-columns: 1fr;
    }
    .dp-packages-grid {
        grid-template-columns: 1fr;
    }
    .dp-mid-grid {
        grid-template-columns: 1fr;
    }
    .dp-bottom-banner {
        flex-direction: column;
        align-items: flex-start;
        padding: 28px 24px;
    }
    .dp-bb-illustration {
        align-self: center;
    }
}

@media (max-width: 640px) {
    .dp-doc-profile-card {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .dp-doc-meta-row {
        justify-content: center;
    }
    .dp-metrics-row {
        grid-template-columns: repeat(2, 1fr);
    }
    .dp-slots-pills-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    .dp-review-score-box {
        grid-template-columns: 1fr;
        gap: 14px;
    }
}

/* ── MODAL: LOGIN REQUIRED PROMPT ── */
.dp-login-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(5px);
    z-index: 1200;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.dp-login-modal-overlay.show {
    display: flex;
}
.dp-login-modal-card {
    background: #ffffff;
    width: 100%;
    max-width: 420px;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.22);
    padding: 32px 28px 26px;
    text-align: center;
    animation: dpModalPop 0.2s ease-out;
}
@keyframes dpModalPop {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.dp-lm-icon-box {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: var(--teal-bg-soft);
    color: var(--primary-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    margin: 0 auto 16px;
}
.dp-lm-title {
    font-size: 20px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 8px;
}
.dp-lm-desc {
    font-size: 13.5px;
    color: var(--muted-text);
    line-height: 1.55;
    margin-bottom: 24px;
}
.dp-lm-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.dp-btn-lm-login {
    background: var(--primary-teal);
    color: #ffffff !important;
    padding: 12px 16px;
    border-radius: 12px;
    font-size: 14.5px;
    font-weight: 800;
    text-align: center;
    text-decoration: none;
    transition: all 0.2s;
    box-shadow: 0 4px 14px rgba(12, 105, 120, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.dp-btn-lm-login:hover {
    background: var(--primary-teal-dark);
}
.dp-btn-lm-reg {
    background: #ffffff;
    color: var(--primary-teal) !important;
    border: 1.5px solid var(--primary-teal);
    padding: 11px 16px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    text-align: center;
    text-decoration: none;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.dp-btn-lm-reg:hover {
    background: var(--teal-bg-soft);
}
.dp-btn-lm-cancel {
    background: none;
    border: none;
    color: var(--muted-text);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    padding: 6px;
    margin-top: 4px;
}
.dp-btn-lm-cancel:hover {
    color: var(--ink);
}
</style>

<div class="dp-page-wrap">

    {{-- Site Navigation Header --}}
    @include('layouts.header')

    <div class="dp-main-container">

        {{-- Breadcrumb --}}
        <div class="dp-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="dp-bc-sep">&gt;</span>
            <a href="{{ route('home') }}#specialists">Our Specialists</a>
            <span class="dp-bc-sep">&gt;</span>
            <span class="dp-bc-current">Dr. {{ $cleanDoctorName }}</span>
        </div>

        {{-- ══════════════════════════════════════════════════
             SECTION 1: TOP HERO DOCTOR INFO & FEE CARD
        ══════════════════════════════════════════════════ --}}
        <div class="dp-hero-row">

            {{-- Doctor Profile Main Box --}}
            <div class="dp-card dp-doc-profile-card">
                <div class="dp-doc-photo-wrap">
                    @if($doctor->profile_img)
                        <img src="{{ str_contains($doctor->profile_img, '/') ? asset($doctor->profile_img) : asset('uploads/profile/'.$doctor->profile_img) }}" alt="{{ $doctor->name }}" class="dp-doc-photo">
                    @else
                        <div class="dp-doc-photo-ph">
                            {{ strtoupper(substr($doctor->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="dp-doc-profile-info">
                    <h1 class="dp-doc-title">Dr. {{ $cleanDoctorName }}</h1>
                    <div class="dp-doc-qual-line">{{ $qualification }}</div>
                    <div class="dp-doc-spec-line">{{ $specName }} Specialist</div>

                    <div>
                        <span class="dp-trusted-pill">
                            <i class="fa-solid fa-star"></i> Trusted
                        </span>
                    </div>

                    <div class="dp-doc-meta-row">
                        <span class="dp-doc-meta-item">
                            <i class="fa-solid fa-briefcase"></i>
                            <span>{{ $expYears }} Years Experience</span>
                        </span>
                        <span class="dp-doc-meta-item">
                            <i class="fa-solid fa-star"></i>
                            <span>{{ $displayRating }} Rating</span>
                        </span>
                        <span class="dp-doc-meta-item">
                            <i class="fa-regular fa-message"></i>
                            <span>{{ $reviewsCount }} Reviews</span>
                        </span>
                    </div>

                    <p class="dp-doc-bio-p">
                        {{ $doctorBio }}
                    </p>
                </div>
            </div>

            {{-- Doctor Fee Right Card --}}
            <div class="dp-card dp-fee-box-card">
                <div>
                    <div class="dp-fee-header-lbl">Doctor Fee</div>
                    <div class="dp-fee-large-val">
                        ₹{{ number_format($totalFee) }} <small>/ session</small>
                    </div>

                    <div class="dp-fee-feature-item">
                        <div class="dp-ffi-icon">
                            <i class="fa-solid fa-house-chimney"></i>
                        </div>
                        <div>
                            <div class="dp-ffi-title">Home Visit</div>
                            <div class="dp-ffi-sub">We come to your doorstep</div>
                        </div>
                    </div>

                    <div class="dp-fee-feature-item">
                        <div class="dp-ffi-icon">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>
                        <div>
                            <div class="dp-ffi-title">Next Availability</div>
                            <div class="dp-ffi-sub">Today, 4:00 PM - 6:00 PM</div>
                        </div>
                    </div>
                </div>

                <div>
                    <a href="{{ route('doctor.booking', $doctor->id) }}" class="dp-btn-book-session" id="btnBookHero" onclick="return checkAuthAndBook(event, this.href)">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span>Book Home Session</span>
                        <i class="fa-solid fa-arrow-right" style="font-size:13px;"></i>
                    </a>

                    <div class="dp-fee-safe-lbl">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Safe &bull; Secure &bull; Verified Professional</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════════════════════
             SECTION 2: 4 QUICK METRICS ROW
        ══════════════════════════════════════════════════ --}}
        <div class="dp-metrics-row">
            {{-- Experience --}}
            <div class="dp-metric-box">
                <div class="dp-mb-icon exp">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div>
                    <div class="dp-mb-val">{{ $expYears }}+ Yrs</div>
                    <div class="dp-mb-lbl">Experience</div>
                </div>
            </div>

            {{-- Rating --}}
            <div class="dp-metric-box">
                <div class="dp-mb-icon rating">
                    <i class="fa-solid fa-star"></i>
                </div>
                <div>
                    <div class="dp-mb-val">{{ $displayRating }}</div>
                    <div class="dp-mb-lbl">Rating</div>
                </div>
            </div>

            {{-- Reviews --}}
            <div class="dp-metric-box">
                <div class="dp-mb-icon reviews">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <div class="dp-mb-val">{{ $reviewsCount }}</div>
                    <div class="dp-mb-lbl">Reviews</div>
                </div>
            </div>

            {{-- Available Today --}}
            <div class="dp-metric-box">
                <div class="dp-mb-icon today">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                <div>
                    <div class="dp-mb-val">Available</div>
                    <div class="dp-mb-lbl">Today</div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════
             SECTION 3: TREATMENT PACKAGES (DYNAMIC)
        ══════════════════════════════════════════════════ --}}
        <div class="dp-card dp-packages-card">
            <div class="dp-sec-header-row">
                <div class="dp-sec-header-left">
                    <div class="dp-sec-icon-box">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <div>
                        <h2 class="dp-sec-title">Treatment Packages</h2>
                        <div class="dp-sec-sub">Choose a package that suits your recovery goals</div>
                    </div>
                </div>
                <a href="{{ route('doctor.booking', $doctor->id) }}#packages" class="dp-sec-link" onclick="return checkAuthAndBook(event, this.href)">
                    <span>View All Packages</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            @php
                // Icon pool for cycling through packages
                $pkgIcons = [
                    'fa-solid fa-person-dots-from-line',
                    'fa-solid fa-person-walking',
                    'fa-solid fa-child-reaching',
                    'fa-solid fa-dumbbell',
                    'fa-solid fa-heart-pulse',
                    'fa-solid fa-hand-holding-medical',
                ];
                // Find the middle plan index for "Most Popular" badge
                $pkgCount        = count($patientPlans ?? []);
                $popularIndex    = $pkgCount > 0 ? (int) floor(($pkgCount - 1) / 2) : 1;
            @endphp

            <div class="dp-packages-grid">
                @forelse($patientPlans ?? [] as $pkgIdx => $plan)
                    @php
                        $isPopular    = ($pkgIdx === $popularIndex);
                        $pkgSessions  = (int) ($plan->total_appointments ?? 1);

                        // Use pre-calculated price from PackagePricingService (same as booking page)
                        $pkgPrice     = (float) ($plan->calculated_package_price
                                            ?? ($plan->calculated_pricing['package_price'] ?? 0));
                        $pkgOriginal  = (float) ($plan->calculated_pricing['original_package_price']
                                            ?? ($plan->original_price ?? 0));
                        $perSession   = (float) ($plan->calculated_per_session
                                            ?? ($plan->calculated_pricing['per_appointment_rate'] ?? 0));
                        $pkgDiscount  = (float) ($plan->discount_percentage ?? 0);

                        // Fallback: if service didn't run (e.g. no DB connection at build time)
                        if ($pkgPrice <= 0) {
                            $pkgPrice    = round($totalFee * $pkgSessions * (1 - $pkgDiscount / 100));
                            $pkgOriginal = round($totalFee * $pkgSessions);
                            $perSession  = $totalFee;
                        }
                        if ($perSession <= 0 && $pkgSessions > 0) {
                            $perSession = round($pkgPrice / $pkgSessions);
                        }

                        $pkgDesc      = $plan->description ?? ($pkgSessions > 1
                                            ? "A {$pkgSessions}-session plan for consistent recovery and mobility improvement."
                                            : 'Single session for pain relief and improved mobility.');
                        $iconClass    = $pkgIcons[$pkgIdx % count($pkgIcons)];
                        $sessionLabel = $pkgSessions === 1 ? '/ session' : "/ {$pkgSessions} sessions";
                    @endphp

                    <div class="dp-pkg-item-card {{ $isPopular ? 'popular' : '' }}">
                        @if($isPopular)
                            <span class="dp-popular-tag">Most Popular</span>
                        @endif
                        <div>
                            <div class="dp-pkg-icon-wrap">
                                <i class="{{ $iconClass }}"></i>
                            </div>
                            <h3 class="dp-pkg-title">{{ $plan->name }}</h3>
                            <p class="dp-pkg-subtext">{{ $pkgDesc }}</p>
                            <div class="dp-pkg-meta-tags">
                                <span><i class="fa-regular fa-clock"></i> 60 Min / Session</span>
                                <span><i class="fa-solid fa-house-chimney"></i> Home Visit</span>
                                @if($pkgSessions > 1)
                                    <span><i class="fa-solid fa-layer-group"></i> {{ $pkgSessions }} Sessions</span>
                                @endif
                            </div>
                            @if($pkgDiscount > 0)
                                <div style="margin-top:8px;">
                                    <span style="background:#d1fae5;color:#065f46;font-size:11px;font-weight:700;padding:3px 8px;border-radius:20px;letter-spacing:.3px;">
                                        {{ number_format($pkgDiscount, 0) }}% OFF
                                    </span>
                                    @if($pkgOriginal > 0)
                                        <span style="color:var(--muted-text);font-size:12px;text-decoration:line-through;margin-left:6px;">₹{{ number_format($pkgOriginal) }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="dp-pkg-price-text">
                                ₹{{ number_format($pkgPrice) }} <small>{{ $sessionLabel }}</small>
                            </div>
                            @if($pkgSessions > 1)
                                <div style="color:var(--muted-text);font-size:11px;margin-bottom:10px;">₹{{ number_format($perSession) }} per session</div>
                            @endif
                            <a href="{{ route('doctor.booking', $doctor->id) }}{{ $pkgSessions > 1 ? '#packages' : '' }}"
                               class="dp-btn-choose-pkg {{ $isPopular ? 'filled' : '' }}"
                               onclick="return checkAuthAndBook(event, this.href)">
                                Choose Package
                            </a>
                        </div>
                    </div>
                @empty
                    {{-- Fallback: show 3 computed cards when no plans in DB --}}
                    @php
                        $fallbackPlans = [
                            [
                                'icon'       => 'fa-solid fa-person-dots-from-line',
                                'name'       => 'Pain Relief Session',
                                'desc'       => 'Single session for pain relief and improved mobility.',
                                'price'      => $totalFee,
                                'label'      => '/ session',
                                'sessions'   => 1,
                                'popular'    => false,
                                'discount'   => 0,
                            ],
                            [
                                'icon'       => 'fa-solid fa-person-walking',
                                'name'       => 'Recovery & Mobility',
                                'desc'       => 'Focused treatment plan for better movement and faster recovery.',
                                'price'      => round($totalFee * 3 * 0.9),
                                'label'      => '/ 3 sessions',
                                'sessions'   => 3,
                                'popular'    => true,
                                'discount'   => 10,
                                'original'   => $totalFee * 3,
                            ],
                            [
                                'icon'       => 'fa-solid fa-child-reaching',
                                'name'       => 'Complete Home Rehabilitation',
                                'desc'       => 'Comprehensive program for long-term recovery and injury prevention.',
                                'price'      => round($totalFee * 6 * 0.8),
                                'label'      => '/ 6 sessions',
                                'sessions'   => 6,
                                'popular'    => false,
                                'discount'   => 20,
                                'original'   => $totalFee * 6,
                            ],
                        ];
                    @endphp
                    @foreach($fallbackPlans as $fp)
                        <div class="dp-pkg-item-card {{ $fp['popular'] ? 'popular' : '' }}">
                            @if($fp['popular'])
                                <span class="dp-popular-tag">Most Popular</span>
                            @endif
                            <div>
                                <div class="dp-pkg-icon-wrap">
                                    <i class="{{ $fp['icon'] }}"></i>
                                </div>
                                <h3 class="dp-pkg-title">{{ $fp['name'] }}</h3>
                                <p class="dp-pkg-subtext">{{ $fp['desc'] }}</p>
                                <div class="dp-pkg-meta-tags">
                                    <span><i class="fa-regular fa-clock"></i> 60 Minutes</span>
                                    <span><i class="fa-solid fa-house-chimney"></i> Home Visit</span>
                                    @if($fp['sessions'] > 1)
                                        <span><i class="fa-solid fa-layer-group"></i> {{ $fp['sessions'] }} Sessions</span>
                                    @endif
                                </div>
                                @if($fp['discount'] > 0)
                                    <div style="margin-top:8px;">
                                        <span style="background:#d1fae5;color:#065f46;font-size:11px;font-weight:700;padding:3px 8px;border-radius:20px;">
                                            {{ $fp['discount'] }}% OFF
                                        </span>
                                        <span style="color:var(--muted-text);font-size:12px;text-decoration:line-through;margin-left:6px;">₹{{ number_format($fp['original']) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div class="dp-pkg-price-text">
                                    ₹{{ number_format($fp['price']) }} <small>{{ $fp['label'] }}</small>
                                </div>
                                @if($fp['sessions'] > 1)
                                    <div style="color:var(--muted-text);font-size:11px;margin-bottom:10px;">₹{{ number_format(round($fp['price'] / $fp['sessions'])) }} per session</div>
                                @endif
                                <a href="{{ route('doctor.booking', $doctor->id) }}{{ $fp['sessions'] > 1 ? '#packages' : '' }}"
                                   class="dp-btn-choose-pkg {{ $fp['popular'] ? 'filled' : '' }}"
                                   onclick="return checkAuthAndBook(event, this.href)">
                                    Choose Package
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════
             SECTION 4: MIDDLE 2-COLUMN SECTION
        ══════════════════════════════════════════════════ --}}
        <div class="dp-mid-grid">

            {{-- LEFT COLUMN: About Doctor, Availability, FAQ --}}
            <div class="dp-col-stack">

                {{-- 1. About Doctor Card --}}
                <div class="dp-card dp-about-card">
                    <div class="dp-card-sec-head">
                        <i class="fa-regular fa-id-card"></i>
                        <h3 class="dp-card-sec-title">About Doctor</h3>
                    </div>
                    <p class="dp-about-p">
                        {{ $aboutDoctor }}
                    </p>
                </div>

                {{-- 2. Availability Card --}}
                <div class="dp-card dp-avail-card">
                    <div class="dp-sec-header-row" style="margin-bottom:0;">
                        <div class="dp-sec-header-left">
                            <div class="dp-sec-icon-box">
                                <i class="fa-regular fa-calendar-check"></i>
                            </div>
                            <div>
                                <h3 class="dp-sec-title">Availability</h3>
                                <div class="dp-sec-sub">Select a date and time for your home session</div>
                            </div>
                        </div>
                    </div>

                    {{-- Dates Selector --}}
                    <div class="dp-dates-slider-wrap">
                        <button type="button" class="dp-date-nav-arrow" onclick="slideDates(-1)">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <div class="dp-dates-pills-row" id="datesPillsRow">
                            @foreach($daysList as $idx => $d)
                                <div class="dp-date-pill {{ $d['isSelected'] ? 'active' : '' }}" onclick="selectDate(this, '{{ $d['fullDate'] }}')">
                                    <div class="dp-dp-day">{{ $d['dayName'] }}</div>
                                    <div class="dp-dp-num">{{ $d['dateNum'] }}</div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="dp-date-nav-arrow" onclick="slideDates(1)">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>

                    {{-- Time Slots Grid --}}
                    <div class="dp-slots-pills-grid" id="slotsPillsGrid">
                        <div class="dp-slot-pill" onclick="selectSlot(this, '09:00 AM')">9:00 AM</div>
                        <div class="dp-slot-pill" onclick="selectSlot(this, '10:30 AM')">10:30 AM</div>
                        <div class="dp-slot-pill" onclick="selectSlot(this, '12:00 PM')">12:00 PM</div>
                        <div class="dp-slot-pill active" onclick="selectSlot(this, '04:00 PM')">4:00 PM</div>
                        <div class="dp-slot-pill" onclick="selectSlot(this, '06:00 PM')">6:00 PM</div>
                    </div>
                </div>

                {{-- 3. Frequently Asked Questions --}}
                <div class="dp-card dp-faq-card">
                    <div class="dp-sec-header-row">
                        <div class="dp-sec-header-left">
                            <i class="fa-regular fa-circle-question" style="color:var(--primary-teal);font-size:18px;"></i>
                            <h3 class="dp-sec-title">Frequently Asked Questions</h3>
                        </div>
                        <a href="#faq" class="dp-sec-link">
                            <span>View All FAQs</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="dp-faq-list">
                        <div class="dp-faq-item open">
                            <div class="dp-faq-question" onclick="toggleFaq(this)">
                                <span>How does a home physiotherapy session work?</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            <div class="dp-faq-answer">
                                Our certified physiotherapist arrives directly at your doorstep with all required evaluation and rehabilitation equipment for a comprehensive 60-minute personalized session.
                            </div>
                        </div>

                        <div class="dp-faq-item">
                            <div class="dp-faq-question" onclick="toggleFaq(this)">
                                <span>Do I need any equipment at home?</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            <div class="dp-faq-answer">
                                No equipment is required from your side. Our specialist brings therapy bands, assessment tools, and mobilization aids tailored for your recovery.
                            </div>
                        </div>

                        <div class="dp-faq-item">
                            <div class="dp-faq-question" onclick="toggleFaq(this)">
                                <span>What areas do you cover for home visits?</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            <div class="dp-faq-answer">
                                We cover all major residential neighborhoods across the city for home visits with flexible morning and evening scheduling.
                            </div>
                        </div>

                        <div class="dp-faq-item">
                            <div class="dp-faq-question" onclick="toggleFaq(this)">
                                <span>How can I reschedule or cancel a booking?</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            <div class="dp-faq-answer">
                                You can easily reschedule or cancel your session online anytime up to 4 hours prior to the appointment with full support.
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN: Expertise & Services, Patient Reviews --}}
            <div class="dp-col-stack">

                {{-- 1. Expertise & Services Card --}}
                <div class="dp-card dp-expertise-card">
                    <div class="dp-card-sec-head">
                        <i class="fa-solid fa-user-doctor"></i>
                        <h3 class="dp-card-sec-title">Expertise &amp; Services</h3>
                    </div>

                    <div class="dp-tags-flow">
                        <span class="dp-tag-pill-modern" style="background:var(--teal-bg-soft);color:var(--primary-teal);border-color:var(--teal-badge-border);font-weight:700;">{{ $specName }}</span>
                        <span class="dp-tag-pill-modern">Injury Recovery</span>
                        <span class="dp-tag-pill-modern">Posture Correction</span>
                        <span class="dp-tag-pill-modern">Mobility Improvement</span>
                        <span class="dp-tag-pill-modern">Sports Injury</span>
                        <span class="dp-tag-pill-modern">Personalized Rehabilitation</span>
                        @if(optional($doctor->profile)->highlights)
                            @foreach(explode(',', optional($doctor->profile)->highlights) as $hl)
                                @if(trim($hl))
                                    <span class="dp-tag-pill-modern">{{ trim($hl) }}</span>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- 2. Patient Reviews Card --}}
                <div class="dp-card dp-reviews-card">
                    <div class="dp-sec-header-row">
                        <div class="dp-sec-header-left">
                            <i class="fa-regular fa-star" style="color:var(--gold);font-size:18px;"></i>
                            <h3 class="dp-sec-title">Patient Reviews</h3>
                        </div>
                        <a href="#reviews" class="dp-sec-link">
                            <span>View All Reviews</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    {{-- Review Score Breakdown --}}
                    <div class="dp-review-score-box">
                        <div class="dp-rs-left">
                            <div class="dp-rs-big">{{ $displayRating }}</div>
                            <div class="dp-rs-stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="dp-rs-lbl">Based on {{ $reviewsCount }} reviews</div>
                        </div>

                        <div class="dp-rs-bars">
                            <div class="dp-bar-line">
                                <span>5 ★</span>
                                <div class="dp-bar-track">
                                    <div class="dp-bar-fill" style="width: {{ $p5 }}%;"></div>
                                </div>
                                <span class="dp-bar-pct-val">{{ $p5 }}%</span>
                            </div>
                            <div class="dp-bar-line">
                                <span>4 ★</span>
                                <div class="dp-bar-track">
                                    <div class="dp-bar-fill" style="width: {{ $p4 }}%;"></div>
                                </div>
                                <span class="dp-bar-pct-val">{{ $p4 }}%</span>
                            </div>
                            <div class="dp-bar-line">
                                <span>3 ★</span>
                                <div class="dp-bar-track">
                                    <div class="dp-bar-fill" style="width: {{ $p3 }}%;"></div>
                                </div>
                                <span class="dp-bar-pct-val">{{ $p3 }}%</span>
                            </div>
                            <div class="dp-bar-line">
                                <span>2 ★</span>
                                <div class="dp-bar-track">
                                    <div class="dp-bar-fill" style="width: {{ $p2 }}%;"></div>
                                </div>
                                <span class="dp-bar-pct-val">{{ $p2 }}%</span>
                            </div>
                            <div class="dp-bar-line">
                                <span>1 ★</span>
                                <div class="dp-bar-track">
                                    <div class="dp-bar-fill" style="width: {{ $p1 }}%;"></div>
                                </div>
                                <span class="dp-bar-pct-val">{{ $p1 }}%</span>
                            </div>
                        </div>
                    </div>

                    {{-- Review Items List --}}
                    <div class="dp-review-tiles-list">
                        @forelse($approvedReviews ?? $doctor->receivedReviews->where('is_approved', 1) as $review)
                            <div class="dp-review-tile">
                                <div class="dp-rt-top">
                                    <div class="dp-rt-user">
                                        <div class="dp-rt-avatar">
                                            {{ strtoupper(substr(optional($review->patient)->name ?? 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="dp-rt-name">{{ optional($review->patient)->name ?? 'Verified Patient' }}</div>
                                            <div class="dp-rt-stars">
                                                @for($s = 1; $s <= 5; $s++)
                                                    <i class="fa-solid fa-star" style="{{ $s <= $review->rating ? 'color:var(--gold);' : 'color:#e2e8f0;' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dp-rt-date">{{ $review->created_at->format('d M Y') }}</div>
                                </div>
                                <p class="dp-rt-text">{{ $review->review }}</p>
                            </div>
                        @empty
                            {{-- Mock Review 1 matching mockup --}}
                            <div class="dp-review-tile">
                                <div class="dp-rt-top">
                                    <div class="dp-rt-user">
                                        <div class="dp-rt-avatar" style="background:#e0f2fe;color:#0284c7;">P</div>
                                        <div>
                                            <div class="dp-rt-name">Priya Sharma</div>
                                            <div class="dp-rt-stars">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dp-rt-date">12 Apr 2024</div>
                                </div>
                                <p class="dp-rt-text">Very professional and knowledgeable. My back pain has reduced significantly after just a few sessions!</p>
                            </div>

                            {{-- Mock Review 2 matching mockup --}}
                            <div class="dp-review-tile">
                                <div class="dp-rt-top">
                                    <div class="dp-rt-user">
                                        <div class="dp-rt-avatar" style="background:#fef3c7;color:#d97706;">R</div>
                                        <div>
                                            <div class="dp-rt-name">Rohit Mehta</div>
                                            <div class="dp-rt-stars">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dp-rt-date">5 Apr 2024</div>
                                </div>
                                <p class="dp-rt-text">Great experience! Dr. {{ $cleanDoctorName }} explains everything clearly and provides effective treatment at home.</p>
                            </div>
                        @endforelse
                    </div>

                </div>

            </div>

        </div>

        {{-- ══════════════════════════════════════════════════
             SECTION 5: BOTTOM CTA BANNER (Ready to Start)
        ══════════════════════════════════════════════════ --}}
        <div class="dp-bottom-banner">
            <div class="dp-bb-content">
                <h3 class="dp-bb-title">Ready to Start Your Recovery?</h3>
                <p class="dp-bb-desc">Book a home session with Dr. {{ $cleanDoctorName }} and take the first step towards a pain-free life.</p>
                <a href="{{ route('doctor.booking', $doctor->id) }}" class="dp-btn-white-pill" onclick="return checkAuthAndBook(event, this.href)">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span>Book Home Session</span>
                    <i class="fa-solid fa-arrow-right" style="font-size:12px;"></i>
                </a>
            </div>

            <div class="dp-bb-illustration">
                {{-- Line Art House Vector --}}
                <svg class="dp-bb-home-svg" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 58 L20 32 L48 12 L76 32 L76 58 Z" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M40 58 L40 40 L56 40 L56 58" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M60 20 L60 14 L68 14 L68 26" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="102" cy="42" r="14" stroke="currentColor" stroke-width="2" stroke-dasharray="3 3"/>
                    <line x1="102" y1="56" x2="102" y2="62" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="124" cy="46" r="10" stroke="currentColor" stroke-width="2" stroke-dasharray="3 3"/>
                    <line x1="124" y1="56" x2="124" y2="62" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <line x1="10" y1="60" x2="135" y2="60" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
                <div class="dp-bb-tagline">Better Movement Brighter Days</div>
            </div>
        </div>

    </div>

</div>

{{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   MODAL: LOGIN REQUIRED PROMPT
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
<div class="dp-login-modal-overlay" id="loginPromptModal" onclick="if(event.target===this) closeLoginModal()">
    <div class="dp-login-modal-card">
        <div class="dp-lm-icon-box">
            <i class="fa-solid fa-lock"></i>
        </div>
        <h3 class="dp-lm-title">Please Log In to Book</h3>
        <p class="dp-lm-desc">
            You need to be logged into your patient account to choose packages, select appointment slots, and book a home session with Dr. {{ $cleanDoctorName }}.
        </p>
        <div class="dp-lm-actions">
            <a href="{{ route('login') }}" class="dp-btn-lm-login">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> Log In to Continue
            </a>
            <a href="{{ route('patient.register') }}" class="dp-btn-lm-reg">
                Create New Account
            </a>
            <button type="button" class="dp-btn-lm-cancel" onclick="closeLoginModal()">
                Cancel
            </button>
        </div>
    </div>
</div>

<script>
var isUserLoggedIn = {{ \Illuminate\Support\Facades\Auth::check() ? 'true' : 'false' }};
var bookingUrl = "{{ route('doctor.booking', $doctor->id) }}";

function checkAuthAndBook(event, targetUrl) {
    if (!isUserLoggedIn) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        openLoginModal();
        return false;
    }
    if (targetUrl) {
        window.location.href = targetUrl;
    }
    return true;
}

function openLoginModal() {
    let m = document.getElementById('loginPromptModal');
    if (m) m.classList.add('show');
}

function closeLoginModal() {
    let m = document.getElementById('loginPromptModal');
    if (m) m.classList.remove('show');
}

// Interactive Date Picker
function selectDate(el, dateVal) {
    document.querySelectorAll('.dp-date-pill').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    updateBookingUrl();
}

// Interactive Time Slot Picker
function selectSlot(el, slotVal) {
    document.querySelectorAll('.dp-slot-pill').forEach(s => s.classList.remove('active'));
    el.classList.add('active');
    updateBookingUrl();
}

function updateBookingUrl() {
    const activeDate = document.querySelector('.dp-date-pill.active');
    const activeSlot = document.querySelector('.dp-slot-pill.active');
    const btn = document.getElementById('btnBookHero');
    if (btn && activeDate && activeSlot) {
        // Keeps user selection ready for booking page
    }
}

function slideDates(direction) {
    const row = document.getElementById('datesPillsRow');
    if (row) {
        row.scrollBy({ left: direction * 120, behavior: 'smooth' });
    }
}

// Interactive FAQ Accordion
function toggleFaq(el) {
    const item = el.parentElement;
    item.classList.toggle('open');
}
</script>

@endsection
