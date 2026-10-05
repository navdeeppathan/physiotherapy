@extends('layouts.app')

@section('title', 'Kinora & PhysioPii — Expert Physiotherapy Care at Home & In-Clinic')
@section('meta_description', 'Book certified & experienced physiotherapists for home visits and clinic appointments. Personalized care for Back Pain, Knee Rehab, Sports Injuries, and Neurological Recovery.')
@section('meta_keywords', 'physiotherapy, home physiotherapy, physiotherapist near me, back pain relief, knee pain therapy, sports injury rehab, stroke recovery, best physio India')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   THEME PALETTE & CSS VARIABLES
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
:root {
    --brand-teal:       #0c6978;
    --brand-teal-hover: #08535f;
    --brand-teal-light: #e8f4f5;
    --brand-teal-soft:  #f0f8f8;
    --brand-mint-badge: #d8f0f0;
    --brand-dark-teal:  #0a3d46;
    --brand-forest-dark:#082d33;
    --brand-slate-deep: #09282e;
    
    --text-primary:     #09282e;
    --text-secondary:   #475569;
    --text-muted:       #64748b;
    --text-subtle:      #94a3b8;
    
    --card-border:      #e2ebec;
    --card-border-subtle:#edf2f4;
    --card-bg:          #ffffff;
    --page-bg:          #ffffff;
    --input-border:     #d7e6e8;
    
    --gold-star:        #f59e0b;
    --accent-emerald:   #10b981;
    
    --radius-sm:        8px;
    --radius-md:        12px;
    --radius-lg:        18px;
    --radius-xl:        24px;
    --radius-2xl:       32px;
    
    --shadow-subtle:    0 4px 18px rgba(9, 40, 46, 0.04);
    --shadow-card:      0 8px 30px rgba(9, 40, 46, 0.06);
    --shadow-elevated:  0 18px 45px rgba(12, 105, 120, 0.12);
    --shadow-floating:  0 20px 50px rgba(9, 40, 46, 0.14);
}

*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body, input, button, select, textarea, .kn-main-wrapper, h1, h2, h3, h4, h5, h6, p, a, span {
    font-family: -apple-system, BlinkMacSystemFont, sans-serif !important;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    color: var(--text-primary);
    background-color: var(--page-bg);
    line-height: 1.55;
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
}

a {
    text-decoration: none;
    color: inherit;
    transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
}

/* Container */
.kn-container {
    width: 100%;
    max-width: 1260px;
    margin-left: auto;
    margin-right: auto;
    padding-left: 24px;
    padding-right: 24px;
}

/* Badge / Pills */
.kn-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 11.5px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--brand-teal);
    margin-bottom: 12px;
}
.kn-eyebrow-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--brand-teal);
    display: inline-block;
}

.kn-pill-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--brand-mint-badge);
    color: var(--brand-teal);
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.02em;
}

/* Typography Headings */
.kn-section-header {
    text-align: center;
    max-width: 700px;
    margin: 0 auto 52px;
}
.kn-section-title {
    font-size: clamp(28px, 3.2vw, 38px);
    font-weight: 800;
    color: var(--text-primary);
    line-height: 1.22;
    letter-spacing: -0.03em;
    margin-bottom: 12px;
}
.kn-section-subtitle {
    font-size: 15.5px;
    color: var(--text-secondary);
    line-height: 1.6;
}

/* Buttons */
.kn-btn-primary {
    background: var(--brand-teal);
    color: #ffffff !important;
    padding: 13px 26px;
    border-radius: 10px;
    font-size: 14.5px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    border: 1.5px solid var(--brand-teal);
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(12, 105, 120, 0.22);
    transition: all 0.22s ease;
}
.kn-btn-primary:hover {
    background: var(--brand-teal-hover);
    border-color: var(--brand-teal-hover);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(12, 105, 120, 0.32);
}

.kn-btn-secondary {
    background: #ffffff;
    color: var(--text-primary) !important;
    padding: 13px 24px;
    border-radius: 10px;
    font-size: 14.5px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: 1.5px solid var(--card-border);
    cursor: pointer;
    box-shadow: var(--shadow-subtle);
    transition: all 0.22s ease;
}
.kn-btn-secondary:hover {
    background: var(--brand-teal-soft);
    border-color: var(--brand-teal);
    color: var(--brand-teal) !important;
    transform: translateY(-2px);
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   1. NAVBAR
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.kn-navbar-wrapper {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: #ffffff;
    border-bottom: 1px solid #edf2f5;
    transition: box-shadow 0.25s ease;
}
.kn-navbar-wrapper.scrolled {
    box-shadow: 0 4px 24px rgba(9, 40, 46, 0.08);
}
.kn-nav-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 74px;
}
.kn-brand-link {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}
.kn-brand-icon-box {
    width: 36px;
    height: 36px;
    background: var(--brand-teal);
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 17px;
    box-shadow: 0 4px 12px rgba(12, 105, 120, 0.28);
}
.kn-brand-text {
    font-size: 23px;
    font-weight: 900;
    color: var(--brand-teal);
    letter-spacing: -0.04em;
    display: flex;
    align-items: center;
}
.kn-brand-text span {
    color: #1e293b;
    font-weight: 800;
}

.kn-nav-menu {
    display: flex;
    align-items: center;
    gap: 32px;
    list-style: none;
}
.kn-nav-item a {
    font-size: 14.5px;
    font-weight: 600;
    color: #334155;
    position: relative;
    padding: 6px 0;
}
.kn-nav-item a:hover,
.kn-nav-item a.active {
    color: var(--brand-teal);
}
.kn-nav-item a.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 2.5px;
    background: var(--brand-teal);
    border-radius: 2px;
}

.kn-nav-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}
.kn-login-link {
    font-size: 14.5px;
    font-weight: 700;
    color: var(--text-primary);
    padding: 6px 10px;
}
.kn-login-link:hover {
    color: var(--brand-teal);
}
.kn-btn-nav-book {
    background: var(--brand-teal);
    color: #ffffff !important;
    padding: 10px 22px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    box-shadow: 0 4px 14px rgba(12, 105, 120, 0.2);
}
.kn-btn-nav-book:hover {
    background: var(--brand-teal-hover);
    transform: translateY(-1px);
}

.kn-mobile-toggle {
    display: none;
    background: transparent;
    border: none;
    color: var(--text-primary);
    font-size: 22px;
    cursor: pointer;
    padding: 6px;
}

/* Mobile Drawer */
.kn-mobile-drawer {
    display: none;
    position: fixed;
    top: 74px;
    left: 0;
    right: 0;
    bottom: 0;
    background: #ffffff;
    z-index: 999;
    padding: 24px;
    border-top: 1px solid #eef2f5;
    overflow-y: auto;
}
.kn-mobile-drawer.open {
    display: block;
}
.kn-mobile-menu-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 18px;
    margin-bottom: 28px;
}
.kn-mobile-menu-list a {
    font-size: 17px;
    font-weight: 700;
    color: var(--text-primary);
    display: block;
    padding: 8px 0;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   2. HERO SECTION & CAROUSEL (3 SLIDES)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.kn-hero-wrapper {
    background: #eef6f5;
    padding: 40px 0 35px;
    position: relative;
    overflow: hidden;
}

.kn-hero-carousel-container {
    position: relative;
    min-height: 480px;
}

.kn-hero-slide {
    display: none;
    grid-template-columns: 1.15fr 1fr;
    gap: 40px;
    align-items: center;
    opacity: 0;
    transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
    transform: translateX(15px);
}
.kn-hero-slide.active {
    display: grid;
    opacity: 1;
    transform: translateX(0);
}

/* Left Hero Content */
.kn-hero-content {
    padding-right: 15px;
}
.kn-hero-heading {
    font-size: clamp(34px, 4.3vw, 54px);
    font-weight: 900;
    color: var(--text-primary);
    line-height: 1.14;
    letter-spacing: -0.04em;
    margin-bottom: 18px;
}
.kn-hero-desc {
    font-size: 16px;
    color: var(--text-secondary);
    line-height: 1.62;
    margin-bottom: 28px;
    max-width: 530px;
}
.kn-hero-actions {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 26px;
}
.kn-hero-guarantee {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: var(--brand-teal);
}
.kn-hero-guarantee i {
    font-size: 14px;
}

/* Right Hero Visual & Badges */
.kn-hero-visual {
    position: relative;
    border-radius: var(--radius-2xl);
    overflow: visible;
}
.kn-hero-image-box {
    position: relative;
    border-radius: var(--radius-2xl);
    overflow: hidden;
    height: 420px;
    background: #cbd5e1;
    box-shadow: 0 20px 45px rgba(9, 40, 46, 0.12);
}
.kn-hero-image-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
    transition: transform 1.2s ease;
}
.kn-hero-slide.active .kn-hero-image-box img {
    transform: scale(1.02);
}

/* Top-Left Floating Badge */
.kn-floating-top-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: rgba(255, 255, 255, 0.94);
    backdrop-filter: blur(8px);
    padding: 7px 16px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 700;
    color: var(--text-primary);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    display: inline-flex;
    align-items: center;
    gap: 7px;
    z-index: 2;
}
.kn-floating-top-badge i {
    color: var(--brand-teal);
    font-size: 13px;
}

/* Bottom Floating Stats Overlay Card */
.kn-hero-stats-card {
    position: absolute;
    bottom: 18px;
    left: 18px;
    right: 18px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: var(--radius-lg);
    padding: 16px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 10px 30px rgba(9, 40, 46, 0.14);
    z-index: 2;
    border: 1px solid rgba(255, 255, 255, 0.6);
}
.kn-hero-stats-left h5 {
    font-size: 14.5px;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 2px;
}
.kn-hero-stats-left p {
    font-size: 12.5px;
    color: var(--text-muted);
    margin: 0;
}
.kn-hero-stats-right {
    text-align: right;
    border-left: 1px solid #e2e8f0;
    padding-left: 20px;
}
.kn-hero-stats-num {
    font-size: 20px;
    font-weight: 900;
    color: var(--brand-teal);
    line-height: 1.1;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 4px;
}
.kn-hero-stats-sub {
    font-size: 11px;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

/* Hero Controls at Bottom */
.kn-hero-controls {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 25px;
    padding-top: 10px;
}
.kn-carousel-progress {
    display: flex;
    align-items: center;
    gap: 12px;
}
.kn-dots-track {
    display: flex;
    align-items: center;
    gap: 8px;
}
.kn-dot-btn {
    height: 8px;
    width: 8px;
    border-radius: 50%;
    background: #bcdbdc;
    border: none;
    cursor: pointer;
    padding: 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.kn-dot-btn.active {
    width: 26px;
    border-radius: 8px;
    background: var(--brand-teal);
}
.kn-counter-text {
    font-size: 12.5px;
    font-weight: 800;
    color: var(--brand-teal);
    letter-spacing: 0.05em;
}

.kn-carousel-arrows {
    display: flex;
    align-items: center;
    gap: 10px;
}
.kn-arrow-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #ffffff;
    border: 1.5px solid #d0e4e5;
    color: var(--brand-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.04);
    transition: all 0.2s ease;
}
.kn-arrow-btn:hover {
    background: var(--brand-teal);
    border-color: var(--brand-teal);
    color: #ffffff;
    transform: translateY(-1px);
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   3. FLOATING SEARCH CARD & STATS ROW
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.kn-search-outer {
    position: relative;
    margin-top: -30px;
    z-index: 10;
}
.kn-search-card {
    background: #ffffff;
    border-radius: var(--radius-lg);
    border: 1px solid var(--card-border);
    box-shadow: var(--shadow-floating);
    padding: 24px 28px 22px;
}
.kn-search-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}
.kn-search-title {
    font-size: 16px;
    font-weight: 800;
    color: var(--text-primary);
}
.kn-search-tag {
    font-size: 13px;
    font-weight: 700;
    color: var(--brand-teal);
    background: var(--brand-teal-light);
    padding: 4px 12px;
    border-radius: 50px;
}

.kn-search-form {
    display: grid;
    grid-template-columns: 1.2fr 1.2fr 1.1fr 1fr auto;
    gap: 14px;
    align-items: flex-end;
}
.kn-form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.kn-form-label {
    font-size: 12px;
    font-weight: 800;
    color: var(--text-primary);
    letter-spacing: 0.02em;
}
.kn-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
    background: #f8fafb;
    border: 1.5px solid var(--input-border);
    border-radius: 10px;
    padding: 10px 14px;
    transition: border-color 0.2s, background 0.2s;
}
.kn-input-wrap:focus-within {
    border-color: var(--brand-teal);
    background: #ffffff;
}
.kn-input-wrap i {
    color: #94a3b8;
    font-size: 14px;
    margin-right: 10px;
    flex-shrink: 0;
}
.kn-input-wrap input,
.kn-input-wrap select {
    border: none;
    background: transparent;
    outline: none;
    width: 100%;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text-primary);
    font-family: inherit;
}
.kn-input-wrap select {
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
}
.kn-input-wrap input::placeholder {
    color: #94a3b8;
    font-weight: 500;
}
.kn-btn-search {
    background: var(--brand-teal);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    height: 44px;
    padding: 0 28px;
    font-size: 14.5px;
    font-weight: 800;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(12, 105, 120, 0.25);
}
.kn-btn-search:hover {
    background: var(--brand-teal-hover);
    transform: translateY(-1px);
}

/* Stats Counter Row */
.kn-stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    padding: 48px 0 60px;
    text-align: center;
}
.kn-stat-item {
    border-right: 1px solid #edf2f5;
    padding: 0 16px;
}
.kn-stat-item:last-child {
    border-right: none;
}
.kn-stat-number {
    font-size: clamp(30px, 3.5vw, 42px);
    font-weight: 900;
    color: var(--brand-teal);
    line-height: 1.1;
    margin-bottom: 6px;
    letter-spacing: -0.03em;
}
.kn-stat-label {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text-secondary);
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   4. SPECIALITIES SECTION ("The right expertise...")
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.kn-specialities-section {
    padding: 30px 0 80px;
    background: #ffffff;
}
.kn-spec-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}
.kn-spec-card {
    background: #ffffff;
    border: 1.5px solid var(--card-border);
    border-radius: var(--radius-lg);
    padding: 24px 22px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    overflow: hidden;
}
.kn-spec-card:hover {
    border-color: var(--brand-teal);
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(12, 105, 120, 0.08);
}
.kn-spec-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: var(--brand-teal-light);
    color: var(--brand-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 18px;
    transition: all 0.2s ease;
}
.kn-spec-card:hover .kn-spec-icon-box {
    background: var(--brand-teal);
    color: #ffffff;
}
.kn-spec-title {
    font-size: 17px;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 6px;
}
.kn-spec-desc {
    font-size: 13px;
    color: var(--text-secondary);
    line-height: 1.5;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   5. FEATURED DOCTORS ("Meet your recovery partners")
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.kn-doctors-section {
    padding: 80px 0;
    background: #fbfdfd;
    border-top: 1px solid #f0f5f6;
    border-bottom: 1px solid #f0f5f6;
}
.kn-section-header-flex {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 40px;
}
.kn-view-all-link {
    font-size: 14.5px;
    font-weight: 700;
    color: var(--brand-teal);
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding-bottom: 6px;
}
.kn-view-all-link:hover {
    color: var(--brand-teal-hover);
    transform: translateX(3px);
}

.kn-doctors-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}
.kn-doctor-card {
    background: #ffffff;
    border: 1.5px solid var(--card-border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-subtle);
    display: flex;
    flex-direction: column;
    transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
}
.kn-doctor-card:hover {
    border-color: #bcdadc;
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(9, 40, 46, 0.1);
}

.kn-doctor-media {
    position: relative;
    height: 250px;
    background: #e2e8f0;
    overflow: hidden;
}
.kn-doctor-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    transition: transform 0.8s ease;
}
.kn-doctor-card:hover .kn-doctor-media img {
    transform: scale(1.04);
}
.kn-doctor-rating-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    background: rgba(255, 255, 255, 0.94);
    backdrop-filter: blur(8px);
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 800;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 5px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
}
.kn-doctor-rating-badge i {
    color: var(--gold-star);
    font-size: 11px;
}

.kn-doctor-body {
    padding: 22px 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.kn-doctor-name {
    font-size: 18px;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 4px;
}
.kn-doctor-exp {
    font-size: 13px;
    color: var(--text-secondary);
    margin-bottom: 14px;
    font-weight: 500;
}
.kn-doctor-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 14px;
}
.kn-doctor-pill {
    background: var(--brand-teal-light);
    color: var(--brand-teal);
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 6px;
}
.kn-doctor-availabilities {
    display: flex;
    align-items: center;
    gap: 14px;
    font-size: 12px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 10px;
}
.kn-doctor-availabilities span {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.kn-doctor-availabilities i {
    color: var(--brand-teal);
    font-size: 12px;
}
.kn-doctor-location {
    font-size: 12.5px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 18px;
}

.kn-doctor-divider {
    height: 1px;
    background: #edf2f5;
    margin-top: auto;
    margin-bottom: 16px;
}

.kn-doctor-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.kn-doctor-fee-box {
    display: flex;
    flex-direction: column;
}
.kn-doctor-fee-amount {
    font-size: 19px;
    font-weight: 900;
    color: var(--text-primary);
    line-height: 1.1;
}
.kn-doctor-fee-period {
    font-size: 11px;
    font-weight: 600;
    color: var(--text-muted);
}
.kn-doctor-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}
.kn-btn-doc-profile {
    padding: 9px 14px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    background: #ffffff;
    color: var(--text-primary) !important;
    border: 1.5px solid #cbd5e1;
    transition: all 0.2s;
}
.kn-btn-doc-profile:hover {
    border-color: var(--brand-teal);
    color: var(--brand-teal) !important;
}
.kn-btn-doc-book {
    padding: 9px 16px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 800;
    background: var(--brand-teal);
    color: #ffffff !important;
    border: 1.5px solid var(--brand-teal);
    transition: all 0.2s;
}
.kn-btn-doc-book:hover {
    background: var(--brand-teal-hover);
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   6. VALUE PROPOSITION ("Expert care, without the extra steps")
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.kn-values-section {
    padding: 90px 0;
    background: #ffffff;
}
.kn-values-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
.kn-value-card {
    background: #ffffff;
    border: 1.5px solid var(--card-border);
    border-radius: var(--radius-lg);
    padding: 30px 26px;
    transition: all 0.25s ease;
}
.kn-value-card:hover {
    border-color: var(--brand-teal);
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(12, 105, 120, 0.08);
}
.kn-value-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: var(--brand-teal-light);
    color: var(--brand-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 20px;
}
.kn-value-title {
    font-size: 18px;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 8px;
}
.kn-value-desc {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.6;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   7. HOW IT WORKS ("Your appointment, in four easy steps")
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.kn-steps-section {
    padding: 85px 0 95px;
    background: #eef6f5;
}
.kn-steps-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 28px;
    position: relative;
}
.kn-step-card {
    background: transparent;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}
.kn-step-icon-wrap {
    position: relative;
    width: 58px;
    height: 58px;
    border-radius: 50%;
    background: #ffffff;
    border: 2px solid #bce2e5;
    color: var(--brand-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 22px;
    box-shadow: 0 6px 18px rgba(12, 105, 120, 0.1);
}
.kn-step-number-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: var(--brand-teal);
    color: #ffffff;
    font-size: 11px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #ffffff;
}
.kn-step-title {
    font-size: 18px;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 8px;
}
.kn-step-desc {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.58;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   8. SPLIT FEATURE ("Because moving well changes everything")
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.kn-split-section {
    padding: 90px 0;
    background: #ffffff;
}
.kn-split-grid {
    display: grid;
    grid-template-columns: 1fr 1.05fr;
    gap: 60px;
    align-items: center;
}
.kn-split-visual {
    position: relative;
}
.kn-split-img-box {
    border-radius: var(--radius-2xl);
    overflow: hidden;
    height: 460px;
    box-shadow: var(--shadow-elevated);
}
.kn-split-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.kn-split-badge-card {
    position: absolute;
    bottom: 22px;
    left: 22px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: var(--radius-md);
    padding: 14px 20px;
    box-shadow: var(--shadow-card);
    display: flex;
    align-items: center;
    gap: 14px;
    border: 1px solid rgba(255, 255, 255, 0.6);
}
.kn-split-badge-card i {
    font-size: 26px;
    color: var(--gold-star);
}
.kn-split-badge-card h6 {
    font-size: 15px;
    font-weight: 800;
    color: var(--text-primary);
    margin: 0;
}
.kn-split-badge-card p {
    font-size: 12px;
    color: var(--text-muted);
    margin: 0;
}

.kn-split-content {
    padding-left: 10px;
}
.kn-split-title {
    font-size: clamp(28px, 3.2vw, 40px);
    font-weight: 800;
    color: var(--text-primary);
    line-height: 1.2;
    letter-spacing: -0.03em;
    margin-bottom: 16px;
}
.kn-split-desc {
    font-size: 15.5px;
    color: var(--text-secondary);
    line-height: 1.65;
    margin-bottom: 24px;
}
.kn-split-bullets {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 32px;
}
.kn-split-bullet-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 14.5px;
    font-weight: 600;
    color: var(--text-primary);
}
.kn-split-bullet-item i {
    color: var(--brand-teal);
    font-size: 17px;
    margin-top: 2px;
    flex-shrink: 0;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   9. PRACTITIONER BANNER (Dark Teal Container)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.kn-banner-wrap {
    padding: 30px 0 90px;
}
.kn-practitioner-box {
    background: #08353d;
    border-radius: var(--radius-2xl);
    padding: 56px 60px;
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 40px;
    align-items: center;
    color: #ffffff;
    box-shadow: var(--shadow-floating);
    position: relative;
    overflow: hidden;
}
.kn-banner-eyebrow {
    color: #5ce1e6;
    font-size: 11.5px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 12px;
}
.kn-banner-title {
    font-size: clamp(26px, 2.9vw, 36px);
    font-weight: 800;
    line-height: 1.22;
    margin-bottom: 16px;
    letter-spacing: -0.03em;
}
.kn-banner-desc {
    font-size: 15px;
    color: #cfdfe2;
    line-height: 1.65;
    margin-bottom: 28px;
    max-width: 520px;
}
.kn-btn-white {
    background: #ffffff;
    color: #08353d !important;
    padding: 13px 26px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
}
.kn-btn-white:hover {
    background: #eef8f8;
    transform: translateY(-2px);
}
.kn-banner-img-box {
    border-radius: var(--radius-lg);
    overflow: hidden;
    height: 290px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}
.kn-banner-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   10. TESTIMONIALS SECTION ("Life feels better...")
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.kn-testimonials-section {
    padding: 85px 0 95px;
    background: #fbfdfd;
    border-top: 1px solid #f0f5f6;
    border-bottom: 1px solid #f0f5f6;
}
.kn-overall-rating-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--brand-teal-light);
    color: var(--brand-teal);
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 800;
    margin-top: 12px;
}
.kn-overall-rating-badge i {
    color: var(--gold-star);
}

.kn-reviews-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
    margin-top: 40px;
}
.kn-review-card {
    background: #ffffff;
    border: 1.5px solid var(--card-border);
    border-radius: var(--radius-lg);
    padding: 30px 26px;
    display: flex;
    flex-direction: column;
    box-shadow: var(--shadow-subtle);
    transition: all 0.24s ease;
}
.kn-review-card:hover {
    border-color: var(--brand-teal);
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(12, 105, 120, 0.08);
}
.kn-review-stars {
    display: flex;
    gap: 4px;
    color: var(--gold-star);
    font-size: 14px;
    margin-bottom: 16px;
}
.kn-review-quote {
    font-size: 14.5px;
    color: var(--text-primary);
    line-height: 1.62;
    margin-bottom: 24px;
    flex: 1;
}
.kn-reviewer-row {
    display: flex;
    align-items: center;
    gap: 12px;
    border-top: 1px solid #f1f5f9;
    padding-top: 16px;
}
.kn-reviewer-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    background: #e2e8f0;
}
.kn-reviewer-info h6 {
    font-size: 14.5px;
    font-weight: 800;
    color: var(--text-primary);
    margin: 0;
}
.kn-reviewer-info p {
    font-size: 12px;
    color: var(--brand-teal);
    font-weight: 600;
    margin: 0;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   11. FAQ ACCORDION + SUPPORT CARD
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.kn-faq-section {
    padding: 90px 0;
    background: #ffffff;
}
.kn-faq-layout {
    display: grid;
    grid-template-columns: 0.9fr 1.1fr;
    gap: 60px;
    align-items: flex-start;
}
.kn-support-box {
    background: #eef6f5;
    border-radius: var(--radius-lg);
    padding: 30px;
    margin-top: 32px;
    border: 1px solid #dceceb;
}
.kn-support-box-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: var(--brand-teal);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-bottom: 16px;
}
.kn-support-box h5 {
    font-size: 17px;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 8px;
}
.kn-support-box p {
    font-size: 13.5px;
    color: var(--text-secondary);
    line-height: 1.55;
    margin-bottom: 18px;
}

/* Accordion */
.kn-accordion {
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.kn-faq-item {
    border: 1.5px solid var(--card-border);
    border-radius: var(--radius-md);
    overflow: hidden;
    transition: border-color 0.2s;
}
.kn-faq-item.active {
    border-color: var(--brand-teal);
}
.kn-faq-trigger {
    width: 100%;
    padding: 20px 22px;
    background: #ffffff;
    border: none;
    outline: none;
    text-align: left;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
    transition: color 0.2s;
}
.kn-faq-trigger:hover {
    color: var(--brand-teal);
}
.kn-faq-icon {
    font-size: 14px;
    color: var(--brand-teal);
    transition: transform 0.25s ease;
    flex-shrink: 0;
}
.kn-faq-item.active .kn-faq-icon {
    transform: rotate(45deg);
}
.kn-faq-panel {
    display: none;
    padding: 0 22px 20px;
    font-size: 14.5px;
    color: var(--text-secondary);
    line-height: 1.62;
    background: #ffffff;
}
.kn-faq-item.active .kn-faq-panel {
    display: block;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   12. HEALTH ARTICLES / BLOG SECTION
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.kn-articles-section {
    padding: 85px 0 95px;
    background: #fbfdfd;
    border-top: 1px solid #f0f5f6;
}
.kn-articles-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}
.kn-article-card {
    background: #ffffff;
    border: 1.5px solid var(--card-border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: all 0.25s ease;
}
.kn-article-card:hover {
    border-color: var(--brand-teal);
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(12, 105, 120, 0.08);
}
.kn-article-img {
    height: 180px;
    background: #e2e8f0;
    overflow: hidden;
}
.kn-article-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.7s ease;
}
.kn-article-card:hover .kn-article-img img {
    transform: scale(1.05);
}
.kn-article-body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.kn-article-tag {
    font-size: 12px;
    font-weight: 700;
    color: var(--brand-teal);
    margin-bottom: 8px;
}
.kn-article-title {
    font-size: 15.5px;
    font-weight: 800;
    color: var(--text-primary);
    line-height: 1.35;
    margin-bottom: 16px;
    flex: 1;
}
.kn-article-link {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--brand-teal);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: auto;
}
.kn-article-card:hover .kn-article-link {
    transform: translateX(3px);
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   13. PRE-FOOTER CTA SECTION
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.kn-prefooter-cta-wrap {
    padding: 30px 0 90px;
    background: #ffffff;
}
.kn-prefooter-cta {
    background: #eef6f5;
    border-radius: var(--radius-2xl);
    padding: 56px 30px;
    text-align: center;
    border: 1px solid #dceceb;
}
.kn-cta-top-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #ffffff;
    color: var(--brand-teal);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    box-shadow: 0 4px 14px rgba(12, 105, 120, 0.12);
    margin-bottom: 18px;
}
.kn-cta-title {
    font-size: clamp(28px, 3.4vw, 42px);
    font-weight: 900;
    color: var(--text-primary);
    margin-bottom: 12px;
    letter-spacing: -0.03em;
}
.kn-cta-subtitle {
    font-size: 16px;
    color: var(--text-secondary);
    max-width: 580px;
    margin: 0 auto 28px;
}
.kn-cta-buttons {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 18px;
}
.kn-cta-note {
    font-size: 13px;
    color: var(--text-muted);
    font-weight: 500;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   14. MODERN DARK FOOTER
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.kn-footer {
    background: var(--brand-slate-deep);
    color: #e2e8f0;
    padding: 70px 0 35px;
    font-size: 14px;
}
.kn-footer-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr 1fr 1.2fr;
    gap: 40px;
    margin-bottom: 50px;
}
.kn-footer-brand-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 24px;
    font-weight: 900;
    color: #ffffff;
    margin-bottom: 16px;
}
.kn-footer-brand-icon {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: #0c6978;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}
.kn-footer-desc {
    color: #94a3b8;
    line-height: 1.65;
    font-size: 13.5px;
    max-width: 320px;
}

.kn-footer-col h6 {
    font-size: 15px;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 18px;
    letter-spacing: 0.02em;
}
.kn-footer-links {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 11px;
}
.kn-footer-links a {
    color: #94a3b8;
    font-size: 13.5px;
}
.kn-footer-links a:hover {
    color: #5ce1e6;
    transform: translateX(2px);
}

.kn-footer-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    color: #94a3b8;
    font-size: 13.5px;
    margin-bottom: 12px;
}
.kn-footer-contact-item i {
    color: #5ce1e6;
    margin-top: 3px;
}

.kn-footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    padding-top: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    font-size: 13px;
    color: #64748b;
}
.kn-footer-legal-links {
    display: flex;
    align-items: center;
    gap: 20px;
}
.kn-footer-legal-links a {
    color: #64748b;
}
.kn-footer-legal-links a:hover {
    color: #cbd5e1;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   RESPONSIVE MEDIA QUERIES (Pixel-Perfect Matching)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
@media (max-width: 1024px) {
    .kn-nav-menu {
        display: none;
    }
    .kn-mobile-toggle {
        display: block;
    }
    .kn-hero-slide {
        grid-template-columns: 1fr;
        gap: 32px;
    }
    .kn-hero-content {
        padding-right: 0;
    }
    .kn-search-form {
        grid-template-columns: 1fr 1fr;
    }
    .kn-search-form .kn-btn-search {
        grid-column: span 2;
    }
    .kn-spec-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .kn-doctors-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .kn-values-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .kn-steps-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .kn-split-grid {
        grid-template-columns: 1fr;
    }
    .kn-practitioner-box {
        grid-template-columns: 1fr;
        padding: 40px 30px;
    }
    .kn-reviews-grid {
        grid-template-columns: 1fr;
    }
    .kn-faq-layout {
        grid-template-columns: 1fr;
    }
    .kn-articles-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .kn-footer-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .kn-container {
        padding-left: 16px;
        padding-right: 16px;
    }
    .kn-hero-heading {
        font-size: 32px;
    }
    .kn-hero-image-box {
        height: 320px;
    }
    .kn-hero-stats-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    .kn-hero-stats-right {
        border-left: none;
        padding-left: 0;
        text-align: left;
    }
    .kn-search-card {
        padding: 18px 16px;
    }
    .kn-search-form {
        grid-template-columns: 1fr;
    }
    .kn-search-form .kn-btn-search {
        grid-column: span 1;
    }
    .kn-stats-row {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .kn-stat-item:nth-child(2) {
        border-right: none;
    }
    .kn-spec-grid {
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    .kn-spec-card {
        padding: 16px;
    }
    .kn-doctors-grid {
        grid-template-columns: 1fr;
    }
    .kn-values-grid {
        grid-template-columns: 1fr;
    }
    .kn-steps-grid {
        grid-template-columns: 1fr;
    }
    .kn-articles-grid {
        grid-template-columns: 1fr;
    }
    .kn-footer-grid {
        grid-template-columns: 1fr;
    }
    .kn-footer-bottom {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<div class="kn-main-wrapper">

    {{-- ══════════════════════════════════════════════════
         1. TOP STICKY NAVBAR
    ══════════════════════════════════════════════════ --}}
    <header class="kn-navbar-wrapper" id="navbar">
        <div class="kn-container">
            <div class="kn-nav-inner">
                
                {{-- Brand Logo --}}
                <a href="{{ route('home') }}" class="kn-brand-link">
                    <div class="kn-brand-icon-box">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <span class="kn-brand-text">kinora</span>
                </a>

                {{-- Desktop Nav Links --}}
                <ul class="kn-nav-menu">
                    <li class="kn-nav-item"><a href="{{ route('home') }}" class="active">Home</a></li>
                    <li class="kn-nav-item"><a href="{{ route('search.doctors') }}">Find Doctors</a></li>
                    <li class="kn-nav-item"><a href="#specialities">Specialities</a></li>
                    <li class="kn-nav-item"><a href="#how-it-works">How It Works</a></li>
                    <li class="kn-nav-item"><a href="#about">About Us</a></li>
                    <li class="kn-nav-item"><a href="#faq">FAQ</a></li>
                </ul>

                {{-- Right Nav Actions --}}
                <div class="kn-nav-actions">
                    @auth
                        @if(Auth::user()->role === 'patient')
                            <a href="{{ route('patient.dashboard') }}" class="kn-login-link">Dashboard</a>
                        @elseif(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.appointments.index') }}" class="kn-login-link">Admin</a>
                        @else
                            <a href="{{ route('login') }}" class="kn-login-link">Portal</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="kn-login-link">Login</a>
                    @endauth

                    <a href="{{ route('search.doctors') }}" class="kn-btn-nav-book">
                        Book Appointment
                    </a>

                    {{-- Mobile Hamburger --}}
                    <button class="kn-mobile-toggle" id="knMobileToggle" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>

            </div>
        </div>
    </header>

    {{-- Mobile Menu Drawer --}}
    <div class="kn-mobile-drawer" id="knMobileDrawer">
        <ul class="kn-mobile-menu-list">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('search.doctors') }}">Find Doctors</a></li>
            <li><a href="#specialities">Specialities</a></li>
            <li><a href="#how-it-works">How It Works</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#faq">FAQ</a></li>
            @auth
                <li><a href="{{ route('patient.dashboard') }}">My Dashboard</a></li>
                <li><a href="{{ route('patient.logout') }}">Logout</a></li>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('patient.register') }}">Register as Patient</a></li>
            @endauth
        </ul>
        <a href="{{ route('search.doctors') }}" class="kn-btn-primary" style="width: 100%;">
            Book Appointment
        </a>
    </div>

    {{-- ══════════════════════════════════════════════════
         2. HERO SECTION CAROUSEL (3 SLIDES)
    ══════════════════════════════════════════════════ --}}
    <section class="kn-hero-wrapper">
        <div class="kn-container">

            <div class="kn-hero-carousel-container" id="knHeroCarousel">

                {{-- SLIDE 1: Live pain-free, live better --}}
                <div class="kn-hero-slide active" data-slide-index="0">
                    <div class="kn-hero-content">
                        <div class="kn-eyebrow">
                            <span class="kn-eyebrow-dot"></span> Live pain-free, live better
                        </div>
                        <h1 class="kn-hero-heading">
                            Your next chapter starts with better movement.
                        </h1>
                        <p class="kn-hero-desc">
                            Find verified physiotherapists for in-clinic and online sessions. Personalised care, zero guesswork, recovery that actually lasts.
                        </p>
                        <div class="kn-hero-actions">
                            <a href="{{ route('search.doctors') }}" class="kn-btn-primary">
                                Find Physiotherapist <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 13px;"></i>
                            </a>
                            <a href="#search-bar" class="kn-btn-secondary">
                                Book Appointment
                            </a>
                        </div>
                        <div class="kn-hero-guarantee">
                            <i class="fa-regular fa-circle-check"></i>
                            <span>Verified experts · No booking fees · Your care, your choice</span>
                        </div>
                    </div>

                    <div class="kn-hero-visual">
                        <div class="kn-floating-top-badge">
                            <i class="fa-regular fa-heart"></i> Top rated care
                        </div>
                        <div class="kn-hero-image-box">
                            <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1200&q=80" alt="Physiotherapist guiding patient arm recovery">
                        </div>
                        <div class="kn-hero-stats-card">
                            <div class="kn-hero-stats-left">
                                <h5>Recovery built around your goals</h5>
                                <p>Real people. Expert hands.</p>
                            </div>
                            <div class="kn-hero-stats-right">
                                <div class="kn-hero-stats-num">
                                    <span>4.9</span> <i class="fa-solid fa-star" style="color: #f59e0b; font-size: 14px;"></i>
                                </div>
                                <div class="kn-hero-stats-sub">20k+ reviews</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SLIDE 2: Get back to what you love --}}
                <div class="kn-hero-slide" data-slide-index="1">
                    <div class="kn-hero-content">
                        <div class="kn-eyebrow">
                            <span class="kn-eyebrow-dot"></span> Get back to what you love
                        </div>
                        <h2 class="kn-hero-heading">
                            A stronger comeback. One step at a time.
                        </h2>
                        <p class="kn-hero-desc">
                            From your first pain-free walk to your next finish line, connect with sports and orthopedic specialists who put your goals first.
                        </p>
                        <div class="kn-hero-actions">
                            <a href="{{ route('search.doctors') }}" class="kn-btn-primary">
                                Find Physiotherapist <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 13px;"></i>
                            </a>
                            <a href="#search-bar" class="kn-btn-secondary">
                                Book Appointment
                            </a>
                        </div>
                        <div class="kn-hero-guarantee">
                            <i class="fa-regular fa-circle-check"></i>
                            <span>Verified experts · No booking fees · Your care, your choice</span>
                        </div>
                    </div>

                    <div class="kn-hero-visual">
                        <div class="kn-floating-top-badge">
                            <i class="fa-regular fa-heart"></i> Made for your comeback
                        </div>
                        <div class="kn-hero-image-box">
                            <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1200&q=80" alt="Athletic rehabilitation resistance training">
                        </div>
                        <div class="kn-hero-stats-card">
                            <div class="kn-hero-stats-left">
                                <h5>Recovery built around your goals</h5>
                                <p>Real people. Expert hands.</p>
                            </div>
                            <div class="kn-hero-stats-right">
                                <div class="kn-hero-stats-num">
                                    <span>500+</span>
                                </div>
                                <div class="kn-hero-stats-sub">verified specialists</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SLIDE 3: Expert care, wherever you are --}}
                <div class="kn-hero-slide" data-slide-index="2">
                    <div class="kn-hero-content">
                        <div class="kn-eyebrow">
                            <span class="kn-eyebrow-dot"></span> Expert care, wherever you are
                        </div>
                        <h2 class="kn-hero-heading">
                            Feel better. Without going out of your way.
                        </h2>
                        <p class="kn-hero-desc">
                            Choose in-clinic or online physiotherapy that fits your life. Book a verified specialist and start your personalised recovery from home.
                        </p>
                        <div class="kn-hero-actions">
                            <a href="{{ route('search.doctors') }}" class="kn-btn-primary">
                                Book Appointment <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 13px;"></i>
                            </a>
                            <a href="{{ route('search.doctors') }}" class="kn-btn-secondary">
                                Find Physiotherapist
                            </a>
                        </div>
                        <div class="kn-hero-guarantee">
                            <i class="fa-regular fa-circle-check"></i>
                            <span>Verified experts · No booking fees · Your care, your choice</span>
                        </div>
                    </div>

                    <div class="kn-hero-visual">
                        <div class="kn-floating-top-badge">
                            <i class="fa-regular fa-heart"></i> Care that fits your life
                        </div>
                        <div class="kn-hero-image-box">
                            <img src="https://images.unsplash.com/photo-1584432810601-6c7f27d2362b?auto=format&fit=crop&w=1200&q=80" alt="Home virtual video physiotherapy session">
                        </div>
                        <div class="kn-hero-stats-card">
                            <div class="kn-hero-stats-left">
                                <h5>Personalised support, at home</h5>
                                <p>Real people. Expert hands.</p>
                            </div>
                            <div class="kn-hero-stats-right">
                                <div class="kn-hero-stats-num">
                                    <span>24/7</span>
                                </div>
                                <div class="kn-hero-stats-sub">easy online booking</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Hero Slider Navigation Controls --}}
            <div class="kn-hero-controls">
                <div class="kn-carousel-progress">
                    <div class="kn-dots-track">
                        <button class="kn-dot-btn active" data-slide-to="0" aria-label="Slide 1"></button>
                        <button class="kn-dot-btn" data-slide-to="1" aria-label="Slide 2"></button>
                        <button class="kn-dot-btn" data-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="kn-counter-text" id="knSlideCounter">01 / 03</div>
                </div>

                <div class="kn-carousel-arrows">
                    <button class="kn-arrow-btn" id="knPrevBtn" aria-label="Previous slide">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <button class="kn-arrow-btn" id="knNextBtn" aria-label="Next slide">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         3. FLOATING APPOINTMENT SEARCH BAR & STATS ROW
    ══════════════════════════════════════════════════ --}}
    <section class="kn-search-outer" id="search-bar">
        <div class="kn-container">
            
            <div class="kn-search-card">
                <div class="kn-search-header-row">
                    <div class="kn-search-title">Find care that fits your schedule</div>
                    <div class="kn-search-tag">Instant appointment booking</div>
                </div>

                <form action="{{ route('search.doctors') }}" method="GET" class="kn-search-form">
                    {{-- 1. Location --}}
                    <div class="kn-form-group">
                        <label class="kn-form-label">Location</label>
                        <div class="kn-input-wrap">
                            <i class="fa-solid fa-location-dot"></i>
                            <input type="text" name="location" placeholder="e.g. London or postcode" value="{{ request('location') }}">
                        </div>
                    </div>

                    {{-- 2. Speciality (Dynamic from database) --}}
                    <div class="kn-form-group">
                        <label class="kn-form-label">Speciality</label>
                        <div class="kn-input-wrap">
                            <i class="fa-solid fa-stethoscope"></i>
                            <select name="specialization">
                                <option value="">All Specialities</option>
                                @foreach($specializations as $spec)
                                    <option value="{{ $spec->id }}" {{ request('specialization') == $spec->id ? 'selected' : '' }}>
                                        {{ $spec->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- 3. Visit Type --}}
                    <div class="kn-form-group">
                        <label class="kn-form-label">Visit type</label>
                        <div class="kn-input-wrap">
                            <i class="fa-solid fa-building"></i>
                            <select name="visit_type">
                                <option value="all">Clinic &amp; Home Visit</option>
                                <option value="clinic">In-Clinic Visit</option>
                                <option value="home">Home Visit</option>
                                <option value="online">Online Video Consult</option>
                            </select>
                        </div>
                    </div>

                    {{-- 4. Date --}}
                    <div class="kn-form-group">
                        <label class="kn-form-label">Date</label>
                        <div class="kn-input-wrap">
                            <i class="fa-regular fa-calendar-days"></i>
                            <input type="date" name="date" value="{{ request('date') ?? date('Y-m-d') }}">
                        </div>
                    </div>

                    {{-- Search Submit Button --}}
                    <button type="submit" class="kn-btn-search">
                        Search
                    </button>
                </form>
            </div>

            {{-- 4 Metric Stats Strip --}}
            <div class="kn-stats-row">
                <div class="kn-stat-item">
                    <div class="kn-stat-number">150+</div>
                    <div class="kn-stat-label">Verified Specialists</div>
                </div>
                <div class="kn-stat-item">
                    <div class="kn-stat-number">20,000+</div>
                    <div class="kn-stat-label">Patients Treated</div>
                </div>
                <div class="kn-stat-item">
                    <div class="kn-stat-number">4.9/5</div>
                    <div class="kn-stat-label">Average Patient Rating</div>
                </div>
                <div class="kn-stat-item">
                    <div class="kn-stat-number">40+</div>
                    <div class="kn-stat-label">Specialised Conditions</div>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         4. SPECIALITIES SECTION ("The right expertise...")
    ══════════════════════════════════════════════════ --}}
    <section class="kn-specialities-section" id="specialities">
        <div class="kn-container">

            <div class="kn-section-header">
                <div class="kn-eyebrow">
                    <span class="kn-eyebrow-dot"></span> Explore by condition
                </div>
                <h2 class="kn-section-title">
                    The right expertise. For your recovery.
                </h2>
                <p class="kn-section-subtitle">
                    Find clinicians specialized in your specific needs, from joint pain to neurological rehabilitation.
                </p>
            </div>

            <div class="kn-spec-grid">
                @php
                    // Pre-defined condition metadata matching the 8 mockup items
                    $specDefaults = [
                        [
                            'name' => 'Back Pain',
                            'icon' => 'fa-solid fa-bone',
                            'desc' => 'Lower back, sciatica & disc issues'
                        ],
                        [
                            'name' => 'Neck & Shoulder',
                            'icon' => 'fa-solid fa-person-arrow-up-from-line',
                            'desc' => 'Stiffness, frozen shoulder & rotator cuff'
                        ],
                        [
                            'name' => 'Knee & Hip',
                            'icon' => 'fa-solid fa-person-walking',
                            'desc' => 'Arthritis, meniscus & ligament rehab'
                        ],
                        [
                            'name' => 'Sports Injuries',
                            'icon' => 'fa-solid fa-person-running',
                            'desc' => 'Sprains, strains & return-to-sport'
                        ],
                        [
                            'name' => 'Post-Surgery',
                            'icon' => 'fa-solid fa-hospital-user',
                            'desc' => 'Joint replacement & surgical rehab'
                        ],
                        [
                            'name' => 'Neuro Rehab',
                            'icon' => 'fa-solid fa-brain',
                            'desc' => "Stroke, Parkinson's & nerve conditions"
                        ],
                        [
                            'name' => "Women's Health",
                            'icon' => 'fa-solid fa-venus',
                            'desc' => 'Prenatal, postpartum & pelvic floor'
                        ],
                        [
                            'name' => 'Geriatric Care',
                            'icon' => 'fa-solid fa-hands-holding-child',
                            'desc' => 'Mobility, balance & fall prevention'
                        ],
                    ];
                @endphp

                @if($specializations && $specializations->count() > 0)
                    {{-- Render dynamically from DB with fallback icons --}}
                    @foreach($specializations->take(8) as $index => $spec)
                        @php
                            $defaultItem = $specDefaults[$index % count($specDefaults)];
                            $iconClass = $defaultItem['icon'];
                            $desc = !empty($spec->description) ? Str::limit($spec->description, 45) : $defaultItem['desc'];
                        @endphp
                        <a href="{{ route('search.doctors', ['specialization' => $spec->id]) }}" class="kn-spec-card">
                            <div class="kn-spec-icon-box">
                                <i class="{{ $iconClass }}"></i>
                            </div>
                            <h3 class="kn-spec-title">{{ $spec->name }}</h3>
                            <p class="kn-spec-desc">{{ $desc }}</p>
                        </a>
                    @endforeach

                    {{-- If fewer than 8 in DB, render remaining default slots --}}
                    @for($i = $specializations->count(); $i < 8; $i++)
                        @php $item = $specDefaults[$i]; @endphp
                        <a href="{{ route('search.doctors', ['keyword' => $item['name']]) }}" class="kn-spec-card">
                            <div class="kn-spec-icon-box">
                                <i class="{{ $item['icon'] }}"></i>
                            </div>
                            <h3 class="kn-spec-title">{{ $item['name'] }}</h3>
                            <p class="kn-spec-desc">{{ $item['desc'] }}</p>
                        </a>
                    @endfor
                @else
                    {{-- Fallback matching exact mockup --}}
                    @foreach($specDefaults as $item)
                        <a href="{{ route('search.doctors', ['keyword' => $item['name']]) }}" class="kn-spec-card">
                            <div class="kn-spec-icon-box">
                                <i class="{{ $item['icon'] }}"></i>
                            </div>
                            <h3 class="kn-spec-title">{{ $item['name'] }}</h3>
                            <p class="kn-spec-desc">{{ $item['desc'] }}</p>
                        </a>
                    @endforeach
                @endif
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         5. FEATURED DOCTORS ("Meet your recovery partners")
    ══════════════════════════════════════════════════ --}}
    <section class="kn-doctors-section" id="specialists">
        <div class="kn-container">

            <div class="kn-section-header-flex">
                <div>
                    <div class="kn-eyebrow">
                        <span class="kn-eyebrow-dot"></span> Our specialists
                    </div>
                    <h2 class="kn-section-title" style="margin-bottom: 0;">
                        Meet your recovery partners
                    </h2>
                    <p class="kn-section-subtitle" style="margin-top: 8px;">
                        Trusted, qualified physiotherapists dedicated to getting you back to what you love.
                    </p>
                </div>
                <a href="{{ route('search.doctors') }}" class="kn-view-all-link">
                    View all specialists <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="kn-doctors-grid">
                @php
                    // Fallback doctor mockup details matching the screenshots
                    $defaultDoctorProfiles = [
                        [
                            'name' => 'Dr. Sarah Miller',
                            'role' => 'Lead Musculoskeletal Physiotherapist',
                            'exp' => '12 yrs exp',
                            'speciality' => 'Back Pain',
                            'tags' => ['Back Pain', 'Sports Injuries', 'Manual Therapy'],
                            'rating' => '4.9',
                            'reviews' => '124',
                            'fee' => '₹800',
                            'location' => 'Central Clinic & Home Visits',
                            'img' => 'https://images.unsplash.com/photo-1594824813637-2708307c0892?auto=format&fit=crop&w=600&q=80'
                        ],
                        [
                            'name' => 'Dr. James Wilson',
                            'role' => 'Senior Sports Rehabilitation Specialist',
                            'exp' => '9 yrs exp',
                            'speciality' => 'Sports Rehab',
                            'tags' => ['Knee Rehab', 'Post-Surgery', 'Return to Sport'],
                            'rating' => '4.9',
                            'reviews' => '98',
                            'fee' => '₹950',
                            'location' => 'West End Clinic & Home Visits',
                            'img' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=80'
                        ],
                        [
                            'name' => 'Dr. Priya Patel',
                            'role' => 'Neurological & Geriatric Rehabilitation',
                            'exp' => '11 yrs exp',
                            'speciality' => 'Neuro Rehab',
                            'tags' => ['Stroke Rehab', 'Balance & Gait', 'Home Visits'],
                            'rating' => '4.8',
                            'reviews' => '86',
                            'fee' => '₹900',
                            'location' => 'North Clinic & Home Visits',
                            'img' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=80'
                        ]
                    ];
                @endphp

                @if($doctors && $doctors->count() > 0)
                    {{-- 1. Render Real Database Doctors --}}
                    @foreach($doctors->take(3) as $idx => $doc)
                        @php
                            $docName = $doc->name ?? 'Specialist Doctor';
                            if (!str_starts_with(strtolower($docName), 'dr.')) {
                                $docName = 'Dr. ' . $docName;
                            }

                            // Image determination
                            $docImg = $defaultDoctorProfiles[$idx % 3]['img'];
                            if (!empty($doc->profile_img)) {
                                $docImg = asset($doc->profile_img);
                            } elseif (!empty($doc->profile->profile_img)) {
                                $docImg = asset($doc->profile->profile_img);
                            }

                            // Qualifications & Experience
                            $qual = $doc->profile->qualification ?? 'MPT - Physiotherapy';
                            $exp = ($doc->profile->experience_years ?? 8) . ' yrs exp';
                            $specName = $doc->profile->specializationdata->name ?? ($defaultDoctorProfiles[$idx % 3]['speciality']);

                            // Fee
                            $feeVal = '₹800';
                            if (!empty($doc->fee->doctor_fee)) {
                                $feeVal = '₹' . number_format($doc->fee->doctor_fee);
                            } elseif (!empty($doc->profile->consultation_fee)) {
                                $feeVal = '₹' . number_format($doc->profile->consultation_fee);
                            }

                            $locText = $doc->profile->clinic_address ?? ($doc->address ?? 'Central Clinic & Home Visits');
                            $cleanLoc = Str::limit($locText, 30);
                        @endphp

                        <div class="kn-doctor-card">
                            <div class="kn-doctor-media">
                                <img src="{{ $docImg }}" alt="{{ $docName }}" onerror="this.src='{{ $defaultDoctorProfiles[$idx % 3]['img'] }}';">
                                <div class="kn-doctor-rating-badge">
                                    <i class="fa-solid fa-star"></i> 4.9 ({{ 45 + ($doc->id * 7) }} reviews)
                                </div>
                            </div>
                            <div class="kn-doctor-body">
                                <h3 class="kn-doctor-name">{{ $docName }}</h3>
                                <div class="kn-doctor-exp">{{ $qual }} · {{ $exp }}</div>
                                
                                <div class="kn-doctor-tags">
                                    <span class="kn-doctor-pill">{{ $specName }}</span>
                                    <span class="kn-doctor-pill">Rehabilitation</span>
                                </div>

                                <div class="kn-doctor-availabilities">
                                    <span><i class="fa-solid fa-check"></i> In-Clinic</span>
                                    <span><i class="fa-solid fa-check"></i> Home Visit</span>
                                </div>

                                <div class="kn-doctor-location">
                                    <i class="fa-solid fa-location-dot"></i> {{ $cleanLoc }}
                                </div>

                                <div class="kn-doctor-divider"></div>

                                <div class="kn-doctor-footer">
                                    <div class="kn-doctor-fee-box">
                                        <div class="kn-doctor-fee-amount">{{ $feeVal }}</div>
                                        <div class="kn-doctor-fee-period">per session</div>
                                    </div>
                                    <div class="kn-doctor-actions">
                                        <a href="{{ route('doctor.profile', $doc->id) }}" class="kn-btn-doc-profile">
                                            View Profile
                                        </a>
                                        <a href="{{ route('doctor.booking', $doc->id) }}" class="kn-btn-doc-book">
                                            Book Appointment
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Fill up to 3 cards if fewer in DB --}}
                    @for($i = $doctors->count(); $i < 3; $i++)
                        @php $docDef = $defaultDoctorProfiles[$i]; @endphp
                        <div class="kn-doctor-card">
                            <div class="kn-doctor-media">
                                <img src="{{ $docDef['img'] }}" alt="{{ $docDef['name'] }}">
                                <div class="kn-doctor-rating-badge">
                                    <i class="fa-solid fa-star"></i> {{ $docDef['rating'] }} ({{ $docDef['reviews'] }} reviews)
                                </div>
                            </div>
                            <div class="kn-doctor-body">
                                <h3 class="kn-doctor-name">{{ $docDef['name'] }}</h3>
                                <div class="kn-doctor-exp">{{ $docDef['role'] }} · {{ $docDef['exp'] }}</div>
                                
                                <div class="kn-doctor-tags">
                                    @foreach($docDef['tags'] as $tag)
                                        <span class="kn-doctor-pill">{{ $tag }}</span>
                                    @endforeach
                                </div>

                                <div class="kn-doctor-availabilities">
                                    <span><i class="fa-solid fa-check"></i> In-Clinic</span>
                                    <span><i class="fa-solid fa-check"></i> Home Visit</span>
                                </div>

                                <div class="kn-doctor-location">
                                    <i class="fa-solid fa-location-dot"></i> {{ $docDef['location'] }}
                                </div>

                                <div class="kn-doctor-divider"></div>

                                <div class="kn-doctor-footer">
                                    <div class="kn-doctor-fee-box">
                                        <div class="kn-doctor-fee-amount">{{ $docDef['fee'] }}</div>
                                        <div class="kn-doctor-fee-period">per session</div>
                                    </div>
                                    <div class="kn-doctor-actions">
                                        <a href="{{ route('search.doctors') }}" class="kn-btn-doc-profile">
                                            View Profile
                                        </a>
                                        <a href="{{ route('search.doctors') }}" class="kn-btn-doc-book">
                                            Book Appointment
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor

                @else
                    {{-- 2. Fallback Cards matching Mockup --}}
                    @foreach($defaultDoctorProfiles as $docDef)
                        <div class="kn-doctor-card">
                            <div class="kn-doctor-media">
                                <img src="{{ $docDef['img'] }}" alt="{{ $docDef['name'] }}">
                                <div class="kn-doctor-rating-badge">
                                    <i class="fa-solid fa-star"></i> {{ $docDef['rating'] }} ({{ $docDef['reviews'] }} reviews)
                                </div>
                            </div>
                            <div class="kn-doctor-body">
                                <h3 class="kn-doctor-name">{{ $docDef['name'] }}</h3>
                                <div class="kn-doctor-exp">{{ $docDef['role'] }} · {{ $docDef['exp'] }}</div>
                                
                                <div class="kn-doctor-tags">
                                    @foreach($docDef['tags'] as $tag)
                                        <span class="kn-doctor-pill">{{ $tag }}</span>
                                    @endforeach
                                </div>

                                <div class="kn-doctor-availabilities">
                                    <span><i class="fa-solid fa-check"></i> In-Clinic</span>
                                    <span><i class="fa-solid fa-check"></i> Home Visit</span>
                                </div>

                                <div class="kn-doctor-location">
                                    <i class="fa-solid fa-location-dot"></i> {{ $docDef['location'] }}
                                </div>

                                <div class="kn-doctor-divider"></div>

                                <div class="kn-doctor-footer">
                                    <div class="kn-doctor-fee-box">
                                        <div class="kn-doctor-fee-amount">{{ $docDef['fee'] }}</div>
                                        <div class="kn-doctor-fee-period">per session</div>
                                    </div>
                                    <div class="kn-doctor-actions">
                                        <a href="{{ route('search.doctors') }}" class="kn-btn-doc-profile">
                                            View Profile
                                        </a>
                                        <a href="{{ route('search.doctors') }}" class="kn-btn-doc-book">
                                            Book Appointment
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         6. VALUE PROPOSITION ("Expert care, without the extra steps")
    ══════════════════════════════════════════════════ --}}
    <section class="kn-values-section">
        <div class="kn-container">

            <div class="kn-section-header">
                <div class="kn-eyebrow">
                    <span class="kn-eyebrow-dot"></span> Why choose us
                </div>
                <h2 class="kn-section-title">
                    Expert care, without the extra steps
                </h2>
                <p class="kn-section-subtitle">
                    We've removed the friction from finding and booking great physiotherapy care.
                </p>
            </div>

            <div class="kn-values-grid">
                {{-- Feature 1 --}}
                <div class="kn-value-card">
                    <div class="kn-value-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="kn-value-title">Vetted &amp; Verified Specialists</h3>
                    <p class="kn-value-desc">
                        Every physiotherapist is thoroughly screened, certified, and background checked before joining our network.
                    </p>
                </div>

                {{-- Feature 2 --}}
                <div class="kn-value-card">
                    <div class="kn-value-icon">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <h3 class="kn-value-title">Zero Wait Times</h3>
                    <p class="kn-value-desc">
                        Book in minutes. Same-day and next-day appointments are frequently available to start your recovery immediately.
                    </p>
                </div>

                {{-- Feature 3 --}}
                <div class="kn-value-card">
                    <div class="kn-value-icon">
                        <i class="fa-solid fa-house-medical"></i>
                    </div>
                    <h3 class="kn-value-title">In-Clinic or at Home</h3>
                    <p class="kn-value-desc">
                        Choose between visiting a modern clinic or having an expert clinician come directly to your living room.
                    </p>
                </div>

                {{-- Feature 4 --}}
                <div class="kn-value-card">
                    <div class="kn-value-icon">
                        <i class="fa-solid fa-clipboard-list"></i>
                    </div>
                    <h3 class="kn-value-title">Personalised Recovery Plans</h3>
                    <p class="kn-value-desc">
                        Tailored exercise and therapy programs built around your specific recovery goals, routine, and lifestyle.
                    </p>
                </div>

                {{-- Feature 5 --}}
                <div class="kn-value-card">
                    <div class="kn-value-icon">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <h3 class="kn-value-title">Transparent Pricing</h3>
                    <p class="kn-value-desc">
                        Clear upfront session fees with no surprise costs, hidden platform fees, or confusing medical billing.
                    </p>
                </div>

                {{-- Feature 6 --}}
                <div class="kn-value-card">
                    <div class="kn-value-icon">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="kn-value-title">Continuous Progress Tracking</h3>
                    <p class="kn-value-desc">
                        Digital outcome tracking so you and your clinician see measurable results session after session.
                    </p>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         7. HOW IT WORKS ("Your appointment, in four easy steps")
    ══════════════════════════════════════════════════ --}}
    <section class="kn-steps-section" id="how-it-works">
        <div class="kn-container">

            <div class="kn-section-header">
                <div class="kn-eyebrow">
                    <span class="kn-eyebrow-dot"></span> Simple process
                </div>
                <h2 class="kn-section-title">
                    Your appointment, in four easy steps
                </h2>
                <p class="kn-section-subtitle">
                    Getting back to full strength has never been this straightforward.
                </p>
            </div>

            <div class="kn-steps-grid">
                {{-- Step 1 --}}
                <div class="kn-step-card">
                    <div class="kn-step-icon-wrap">
                        <span class="kn-step-number-badge">1</span>
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h3 class="kn-step-title">Search</h3>
                    <p class="kn-step-desc">
                        Find specialists by condition, location, or preferred treatment type.
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="kn-step-card">
                    <div class="kn-step-icon-wrap">
                        <span class="kn-step-number-badge">2</span>
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <h3 class="kn-step-title">Select Clinician</h3>
                    <p class="kn-step-desc">
                        Compare profiles, reviews, qualifications, and upfront pricing.
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="kn-step-card">
                    <div class="kn-step-icon-wrap">
                        <span class="kn-step-number-badge">3</span>
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <h3 class="kn-step-title">Book Online</h3>
                    <p class="kn-step-desc">
                        Choose a time slot that fits your schedule with instant confirmation.
                    </p>
                </div>

                {{-- Step 4 --}}
                <div class="kn-step-card">
                    <div class="kn-step-icon-wrap">
                        <span class="kn-step-number-badge">4</span>
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <h3 class="kn-step-title">Begin Recovery</h3>
                    <p class="kn-step-desc">
                        Meet your physiotherapist in-clinic or at home and start feeling better.
                    </p>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         8. SPLIT FEATURE ("Because moving well changes everything")
    ══════════════════════════════════════════════════ --}}
    <section class="kn-split-section" id="about">
        <div class="kn-container">
            <div class="kn-split-grid">
                
                {{-- Left Image with Badge --}}
                <div class="kn-split-visual">
                    <div class="kn-split-img-box">
                        <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1000&q=80" alt="Physiotherapist consulting with patient">
                    </div>
                    <div class="kn-split-badge-card">
                        <i class="fa-solid fa-award"></i>
                        <div>
                            <h6>98% Patient Satisfaction</h6>
                            <p>Based on verified post-treatment reviews</p>
                        </div>
                    </div>
                </div>

                {{-- Right Mission Content --}}
                <div class="kn-split-content">
                    <div class="kn-eyebrow">
                        <span class="kn-eyebrow-dot"></span> Our mission
                    </div>
                    <h2 class="kn-split-title">
                        Because moving well changes everything
                    </h2>
                    <p class="kn-split-desc">
                        Pain doesn't just limit your movement — it shrinks your world. Our mission is to connect you with care that restores your freedom, independence, and joy in daily life.
                    </p>
                    
                    <ul class="kn-split-bullets">
                        <li class="kn-split-bullet-item">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Evidence-based clinical treatments that target the root cause, not just symptoms</span>
                        </li>
                        <li class="kn-split-bullet-item">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Dedicated one-on-one attention throughout your entire recovery journey</span>
                        </li>
                        <li class="kn-split-bullet-item">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Continuous guidance with tailored home exercises to prevent re-injury</span>
                        </li>
                    </ul>

                    <a href="{{ route('search.doctors') }}" class="kn-btn-primary">
                        Find Your Specialist <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         9. PRACTITIONER BANNER (Dark Teal Box)
    ══════════════════════════════════════════════════ --}}
    <section class="kn-banner-wrap">
        <div class="kn-container">
            <div class="kn-practitioner-box">
                <div>
                    <div class="kn-banner-eyebrow">For Practitioners</div>
                    <h2 class="kn-banner-title">
                        More time for your patients. More room for your practice.
                    </h2>
                    <p class="kn-banner-desc">
                        Join our network of elite physiotherapists. Grow your client base, manage appointments effortlessly, and keep 100% control over your schedule and rates.
                    </p>
                    <a href="{{ route('login') }}" class="kn-btn-white">
                        Join as a Physiotherapist <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="kn-banner-img-box">
                    <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=800&q=80" alt="Team of verified physiotherapists">
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         10. TESTIMONIALS SECTION ("Life feels better...")
    ══════════════════════════════════════════════════ --}}
    <section class="kn-testimonials-section">
        <div class="kn-container">

            <div class="kn-section-header">
                <div class="kn-eyebrow">
                    <span class="kn-eyebrow-dot"></span> Patient stories
                </div>
                <h2 class="kn-section-title">
                    Life feels better when you move better
                </h2>
                <p class="kn-section-subtitle">
                    See how personalised physiotherapy transformed everyday life for our patients.
                </p>
                <div class="kn-overall-rating-badge">
                    <i class="fa-solid fa-star"></i>
                    <span>4.9 / 5 Overall Patient Rating</span>
                </div>
            </div>

            <div class="kn-reviews-grid">
                {{-- Review 1 --}}
                <div class="kn-review-card">
                    <div class="kn-review-stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <p class="kn-review-quote">
                        "After months of persistent lower back pain, my therapist identified the root cause in session one. Within 4 weeks, I was back to running 5k completely pain-free."
                    </p>
                    <div class="kn-reviewer-row">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80" alt="Marcus Thorne" class="kn-reviewer-avatar">
                        <div class="kn-reviewer-info">
                            <h6>Marcus Thorne</h6>
                            <p>Recovered from Lumbar Disc Herniation</p>
                        </div>
                    </div>
                </div>

                {{-- Review 2 --}}
                <div class="kn-review-card">
                    <div class="kn-review-stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <p class="kn-review-quote">
                        "The convenience of home visits made all the difference for my post-knee surgery rehab. The exercises were clear and the progress tracking kept me motivated every day."
                    </p>
                    <div class="kn-reviewer-row">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=120&q=80" alt="Eleanor Vance" class="kn-reviewer-avatar">
                        <div class="kn-reviewer-info">
                            <h6>Eleanor Vance</h6>
                            <p>Total Knee Replacement Rehab</p>
                        </div>
                    </div>
                </div>

                {{-- Review 3 --}}
                <div class="kn-review-card">
                    <div class="kn-review-stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <p class="kn-review-quote">
                        "Booking was effortless and my therapist was exceptionally thorough. She explained every exercise and tailored everything to my busy work schedule."
                    </p>
                    <div class="kn-reviewer-row">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=120&q=80" alt="David Chen" class="kn-reviewer-avatar">
                        <div class="kn-reviewer-info">
                            <h6>David Chen</h6>
                            <p>Shoulder Impingement Recovery</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         11. FAQ ACCORDION + SUPPORT CARD
    ══════════════════════════════════════════════════ --}}
    <section class="kn-faq-section" id="faq">
        <div class="kn-container">
            <div class="kn-faq-layout">
                
                {{-- Left Text & Support Box --}}
                <div>
                    <div class="kn-eyebrow">
                        <span class="kn-eyebrow-dot"></span> FAQS
                    </div>
                    <h2 class="kn-section-title" style="text-align: left;">
                        A little clarity, a lot of confidence
                    </h2>
                    <p class="kn-section-subtitle" style="text-align: left;">
                        Got questions? We've got answers. If you can't find what you need, our care team is always here to help.
                    </p>

                    <div class="kn-support-box">
                        <div class="kn-support-box-icon">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <h5>Need help deciding?</h5>
                        <p>Our clinical care coordinators can help match you with the right specialist for your situation.</p>
                        <a href="tel:+918855088426" class="kn-btn-secondary" style="background: #ffffff; width: 100%;">
                            Contact Care Team
                        </a>
                    </div>
                </div>

                {{-- Right Interactive Accordion --}}
                <div class="kn-accordion">
                    {{-- FAQ 1 --}}
                    <div class="kn-faq-item active">
                        <button class="kn-faq-trigger" type="button">
                            <span>What should I expect during my first session?</span>
                            <i class="fa-solid fa-plus kn-faq-icon"></i>
                        </button>
                        <div class="kn-faq-panel">
                            Your physiotherapist will conduct a comprehensive clinical assessment of your movement, posture, pain triggers, and medical history. Together, you will design a personalized recovery roadmap and begin initial treatment or gentle corrective exercises.
                        </div>
                    </div>

                    {{-- FAQ 2 --}}
                    <div class="kn-faq-item">
                        <button class="kn-faq-trigger" type="button">
                            <span>Do I need a doctor's referral to book?</span>
                            <i class="fa-solid fa-plus kn-faq-icon"></i>
                        </button>
                        <div class="kn-faq-panel">
                            No referral is needed! You can self-refer and schedule an appointment directly with any licensed physiotherapist on our platform.
                        </div>
                    </div>

                    {{-- FAQ 3 --}}
                    <div class="kn-faq-item">
                        <button class="kn-faq-trigger" type="button">
                            <span>How do home visit appointments work?</span>
                            <i class="fa-solid fa-plus kn-faq-icon"></i>
                        </button>
                        <div class="kn-faq-panel">
                            Your physiotherapist will travel directly to your home with all required therapeutic equipment. All you need is a comfortable, well-lit space where you can comfortably move and sit or lie down.
                        </div>
                    </div>

                    {{-- FAQ 4 --}}
                    <div class="kn-faq-item">
                        <button class="kn-faq-trigger" type="button">
                            <span>Can I reschedule or cancel my appointment?</span>
                            <i class="fa-solid fa-plus kn-faq-icon"></i>
                        </button>
                        <div class="kn-faq-panel">
                            Yes. You can easily reschedule or cancel your session with full flexibility up to 24 hours prior to the scheduled appointment without any penalty.
                        </div>
                    </div>

                    {{-- FAQ 5 --}}
                    <div class="kn-faq-item">
                        <button class="kn-faq-trigger" type="button">
                            <span>Is physiotherapy covered by insurance?</span>
                            <i class="fa-solid fa-plus kn-faq-icon"></i>
                        </button>
                        <div class="kn-faq-panel">
                            Most private health insurance providers and medical reimbursement policies cover consultations and physical therapy provided by registered practitioners. An itemized invoice is provided instantly after each session.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         12. HEALTH ARTICLES ("Good advice for a healthier you")
    ══════════════════════════════════════════════════ --}}
    <section class="kn-articles-section">
        <div class="kn-container">

            <div class="kn-section-header-flex">
                <div>
                    <div class="kn-eyebrow">
                        <span class="kn-eyebrow-dot"></span> Health resources
                    </div>
                    <h2 class="kn-section-title" style="margin-bottom: 0;">
                        Good advice for a healthier you
                    </h2>
                    <p class="kn-section-subtitle" style="margin-top: 8px;">
                        Evidence-based guides, recovery tips, and wellness insights from our clinical experts.
                    </p>
                </div>
                <a href="{{ route('search.doctors') }}" class="kn-view-all-link">
                    Explore all articles <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="kn-articles-grid">
                {{-- Article 1 --}}
                <div class="kn-article-card">
                    <div class="kn-article-img">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=600&q=80" alt="Ergonomic desk workspace">
                    </div>
                    <div class="kn-article-body">
                        <div class="kn-article-tag">Ergonomics · 4 min read</div>
                        <h4 class="kn-article-title">Desk Posture and Neck Pain: 5 Simple Changes You Can Make Today</h4>
                        <a href="{{ route('search.doctors') }}" class="kn-article-link">
                            Read more <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i>
                        </a>
                    </div>
                </div>

                {{-- Article 2 --}}
                <div class="kn-article-card">
                    <div class="kn-article-img">
                        <img src="https://images.unsplash.com/photo-1552674605-db6ffd4facb5?auto=format&fit=crop&w=600&q=80" alt="Runner stretching hamstring">
                    </div>
                    <div class="kn-article-body">
                        <div class="kn-article-tag">Sports Rehab · 5 min read</div>
                        <h4 class="kn-article-title">When to Ice vs. Heat: The Complete Injury Recovery Guide</h4>
                        <a href="{{ route('search.doctors') }}" class="kn-article-link">
                            Read more <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i>
                        </a>
                    </div>
                </div>

                {{-- Article 3 --}}
                <div class="kn-article-card">
                    <div class="kn-article-img">
                        <img src="https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&w=600&q=80" alt="Physiotherapist assisting senior">
                    </div>
                    <div class="kn-article-body">
                        <div class="kn-article-tag">Joint Health · 6 min read</div>
                        <h4 class="kn-article-title">Managing Knee Osteoarthritis: Exercises That Actually Help</h4>
                        <a href="{{ route('search.doctors') }}" class="kn-article-link">
                            Read more <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i>
                        </a>
                    </div>
                </div>

                {{-- Article 4 --}}
                <div class="kn-article-card">
                    <div class="kn-article-img">
                        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80" alt="Two people walking outside">
                    </div>
                    <div class="kn-article-body">
                        <div class="kn-article-tag">Recovery · 4 min read</div>
                        <h4 class="kn-article-title">Walking for Spinal Health: Why Movement Is the Best Medicine</h4>
                        <a href="{{ route('search.doctors') }}" class="kn-article-link">
                            Read more <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         13. PRE-FOOTER CTA SECTION
    ══════════════════════════════════════════════════ --}}
    <section class="kn-prefooter-cta-wrap">
        <div class="kn-container">
            <div class="kn-prefooter-cta">
                <div class="kn-cta-top-icon">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
                <h2 class="kn-cta-title">Start Your Recovery Journey Today</h2>
                <p class="kn-cta-subtitle">
                    Connect with certified physiotherapists for in-clinic or at-home appointments.
                </p>
                <div class="kn-cta-buttons">
                    <a href="{{ route('search.doctors') }}" class="kn-btn-primary">
                        Book Appointment <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 13px;"></i>
                    </a>
                    <a href="{{ route('search.doctors') }}" class="kn-btn-secondary">
                        Find Specialists
                    </a>
                </div>
                <div class="kn-cta-note">
                    No referral needed · Free cancellation up to 24h before
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         14. MODERN DARK FOOTER
    ══════════════════════════════════════════════════ --}}
    <footer class="kn-footer">
        <div class="kn-container">

            <div class="kn-footer-grid">
                {{-- Col 1: Brand --}}
                <div>
                    <div class="kn-footer-brand-title">
                        <div class="kn-footer-brand-icon">
                            <i class="fa-solid fa-heart-pulse"></i>
                        </div>
                        <span>kinora</span>
                    </div>
                    <p class="kn-footer-desc">
                        Connecting you with certified physiotherapy specialists for comprehensive in-clinic and at-home rehabilitation.
                    </p>
                </div>

                {{-- Col 2: Specialties --}}
                <div class="kn-footer-col">
                    <h6>Specialities</h6>
                    <ul class="kn-footer-links">
                        <li><a href="{{ route('search.doctors', ['keyword' => 'Back Pain']) }}">Back Pain</a></li>
                        <li><a href="{{ route('search.doctors', ['keyword' => 'Knee']) }}">Knee Rehab</a></li>
                        <li><a href="{{ route('search.doctors', ['keyword' => 'Sports']) }}">Sports Injury</a></li>
                        <li><a href="{{ route('search.doctors', ['keyword' => 'Post-Surgery']) }}">Post-Surgery</a></li>
                        <li><a href="{{ route('search.doctors', ['keyword' => 'Neuro']) }}">Neuro Rehab</a></li>
                    </ul>
                </div>

                {{-- Col 3: Company --}}
                <div class="kn-footer-col">
                    <h6>Company</h6>
                    <ul class="kn-footer-links">
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="{{ route('search.doctors') }}">Specialists</a></li>
                        <li><a href="{{ route('login') }}">Careers</a></li>
                        <li><a href="mailto:contact@physiopii.in">Contact</a></li>
                    </ul>
                </div>

                {{-- Col 4: Patients --}}
                <div class="kn-footer-col">
                    <h6>Patients</h6>
                    <ul class="kn-footer-links">
                        <li><a href="{{ route('search.doctors') }}">Book Appointment</a></li>
                        <li><a href="{{ route('search.doctors', ['visit_type' => 'home']) }}">Home Visits</a></li>
                        <li><a href="{{ route('search.doctors', ['visit_type' => 'online']) }}">Online Consult</a></li>
                        <li><a href="#specialists">Patient Reviews</a></li>
                        <li><a href="#faq">FAQ</a></li>
                    </ul>
                </div>

                {{-- Col 5: Contact --}}
                <div class="kn-footer-col">
                    <h6>Contact</h6>
                    <div class="kn-footer-contact-item">
                        <i class="fa-regular fa-envelope"></i>
                        <a href="mailto:contact@physiopii.in" style="color: #94a3b8;">contact@physiopii.in</a>
                    </div>
                    <div class="kn-footer-contact-item">
                        <i class="fa-solid fa-phone"></i>
                        <a href="tel:+918855088426" style="color: #94a3b8;">+91 8855088426</a>
                    </div>
                    <div class="kn-footer-contact-item">
                        <i class="fa-regular fa-clock"></i>
                        <span>Mon - Sun: 8:00 AM - 8:00 PM</span>
                    </div>
                </div>
            </div>

            <div class="kn-footer-bottom">
                <div>&copy; {{ date('Y') }} Kinora / PhysioPii Healthcare. All rights reserved.</div>
                <div class="kn-footer-legal-links">
                    <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
                    <a href="{{ route('privacy.policy') }}">Terms of Service</a>
                    <a href="{{ route('privacy.policy') }}">Cookie Policy</a>
                    <a href="{{ url('/sitemap.xml') }}">Sitemap</a>
                </div>
            </div>

        </div>
    </footer>

</div>{{-- /kn-main-wrapper --}}

{{-- ══════════════════════════════════════════════════
     INTERACTIVE JAVASCRIPT: HERO CAROUSEL & ACCORDION
══════════════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Sticky Navbar shadow on scroll
    var navbar = document.getElementById('navbar');
    window.addEventListener('scroll', function () {
        if (window.scrollY > 20) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // 2. Mobile Drawer Toggle
    var mobileToggle = document.getElementById('knMobileToggle');
    var mobileDrawer = document.getElementById('knMobileDrawer');
    if (mobileToggle && mobileDrawer) {
        mobileToggle.addEventListener('click', function () {
            mobileDrawer.classList.toggle('open');
            var icon = mobileToggle.querySelector('i');
            if (mobileDrawer.classList.contains('open')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            } else {
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            }
        });

        // Close drawer on link click
        mobileDrawer.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                mobileDrawer.classList.remove('open');
                var icon = mobileToggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-xmark');
                    icon.classList.add('fa-bars');
                }
            });
        });
    }

    // 3. Hero Carousel Logic (3 Slides)
    var slides = document.querySelectorAll('.kn-hero-slide');
    var dotBtns = document.querySelectorAll('.kn-dot-btn');
    var counterText = document.getElementById('knSlideCounter');
    var prevBtn = document.getElementById('knPrevBtn');
    var nextBtn = document.getElementById('knNextBtn');
    var currentSlide = 0;
    var totalSlides = slides.length;
    var slideInterval = null;

    function showSlide(index) {
        if (index < 0) {
            currentSlide = totalSlides - 1;
        } else if (index >= totalSlides) {
            currentSlide = 0;
        } else {
            currentSlide = index;
        }

        slides.forEach(function (slide, i) {
            if (i === currentSlide) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });

        dotBtns.forEach(function (btn, i) {
            if (i === currentSlide) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        if (counterText) {
            var num = currentSlide + 1;
            counterText.textContent = (num < 10 ? '0' + num : num) + ' / 0' + totalSlides;
        }
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    function startAutoSlide() {
        stopAutoSlide();
        slideInterval = setInterval(nextSlide, 6000);
    }

    function stopAutoSlide() {
        if (slideInterval) {
            clearInterval(slideInterval);
            slideInterval = null;
        }
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function () {
            nextSlide();
            startAutoSlide();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function () {
            prevSlide();
            startAutoSlide();
        });
    }

    dotBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var targetIndex = parseInt(this.getAttribute('data-slide-to'), 10);
            showSlide(targetIndex);
            startAutoSlide();
        });
    });

    var carouselBox = document.getElementById('knHeroCarousel');
    if (carouselBox) {
        carouselBox.addEventListener('mouseenter', stopAutoSlide);
        carouselBox.addEventListener('mouseleave', startAutoSlide);

        // Touch Swipe Support
        var touchStartX = 0;
        var touchEndX = 0;
        carouselBox.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        carouselBox.addEventListener('touchend', function (e) {
            touchEndX = e.changedTouches[0].screenX;
            if (touchStartX - touchEndX > 50) {
                nextSlide();
                startAutoSlide();
            } else if (touchEndX - touchStartX > 50) {
                prevSlide();
                startAutoSlide();
            }
        }, { passive: true });
    }

    startAutoSlide();

    // 4. FAQ Accordion Toggle
    var faqItems = document.querySelectorAll('.kn-faq-item');
    faqItems.forEach(function (item) {
        var trigger = item.querySelector('.kn-faq-trigger');
        if (trigger) {
            trigger.addEventListener('click', function () {
                var wasActive = item.classList.contains('active');
                faqItems.forEach(function (other) {
                    other.classList.remove('active');
                });
                if (!wasActive) {
                    item.classList.add('active');
                }
            });
        }
    });

    // 5. Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            var targetId = this.getAttribute('href');
            if (targetId && targetId !== '#') {
                var targetElem = document.querySelector(targetId);
                if (targetElem) {
                    e.preventDefault();
                    targetElem.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
});
</script>
@endsection