@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ──────────────────────────────────────────────────
   RESET & DESIGN SYSTEM TOKENS
────────────────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
    --primary:      #007788;
    --primary-dark: #005566;
    --primary-light:#e6f4f6;
    --primary-soft: #f0f9fa;
    --accent-teal:  #0ea5e9;
    --ink:          #0f172a;
    --body:         #334155;
    --muted:        #64748b;
    --border:       #e2e8f0;
    --bg:           #f8fafc;
    --white:        #ffffff;
    --green:        #10b981;
    --green-bg:     #d1fae5;
    --green-text:   #065f46;
    --radius-xl:    24px;
    --radius-lg:    18px;
    --radius:       12px;
    --shadow-sm:    0 2px 10px rgba(0,0,0,0.04);
    --shadow:       0 8px 30px rgba(0,0,0,0.06);
}

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--body);
    background: var(--bg);
    overflow-x: hidden;
    padding-bottom: 80px; /* Space for mobile nav */
}
a { text-decoration: none; color: inherit; }
img { max-width: 100%; display: block; }

/* ── CONTAINERS ── */
.hp-container { max-width: 1240px; margin: 0 auto; padding: 0 20px; }
.hp-section   { padding: 36px 0; }

/* ── HEADER OVERRIDE / CUSTOM MOBILE TOP BAR ── */
.hp-top-header {
    background: var(--white);
    border-bottom: 1px solid var(--border);
    position: sticky; top: 0; z-index: 1000;
    box-shadow: 0 2px 12px rgba(0,0,0,0.03);
}
.hp-top-header-inner {
    display: flex; align-items: center; justify-content: space-between;
    height: 68px; padding: 0 20px; max-width: 1240px; margin: 0 auto;
}
.hp-brand { display: flex; align-items: center; gap: 12px; }
.hp-burger-btn {
    background: none; border: none; font-size: 22px; color: var(--ink);
    cursor: pointer; display: flex; align-items: center; justify-content: center;
}
.hp-logo-img { height: 38px; width: auto; object-fit: contain; }

.hp-header-actions { display: flex; align-items: center; gap: 14px; }
.hp-icon-btn {
    width: 42px; height: 42px; border-radius: 50%;
    background: var(--bg); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--ink); font-size: 18px; position: relative;
    transition: all 0.2s;
}
.hp-icon-btn:hover { background: var(--primary-light); color: var(--primary); }
.hp-icon-badge {
    position: absolute; top: 2px; right: 2px;
    background: #ef4444; color: #fff; border-radius: 50%;
    width: 18px; height: 18px; font-size: 10px; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid #fff;
}
.hp-user-avatar {
    width: 42px; height: 42px; border-radius: 50%; object-fit: cover;
    border: 2px solid var(--primary-light);
}
.hp-user-avatar-ph {
    width: 42px; height: 42px; border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--accent-teal));
    color: #fff; font-size: 16px; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
}

/* ──────────────────────────────────────────────────
   HERO GREETING & ILLUSTRATION CARD
────────────────────────────────────────────────── */
.hp-hero-box {
    display: grid; grid-template-columns: 1fr 440px;
    gap: 28px; align-items: center; margin-top: 24px;
}
.hp-greeting-sub { font-size: 15px; font-weight: 700; color: #d97706; display: flex; align-items: center; gap: 6px; }
.hp-greeting-title {
    font-size: clamp(26px, 4vw, 36px); font-weight: 900;
    color: var(--ink); letter-spacing: -0.04em; margin: 6px 0 10px;
    line-height: 1.2;
}
.hp-greeting-desc { font-size: 15px; color: var(--muted); line-height: 1.6; max-width: 520px; }

/* Hero Right Feature Banner */
.hp-hero-card {
    background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
    border: 1.5px solid #bbf7d0; border-radius: var(--radius-xl);
    padding: 22px 24px; display: flex; align-items: center; gap: 20px;
    box-shadow: 0 10px 30px rgba(16,185,129,0.08);
}
.hp-hero-card-img {
    width: 140px; height: 110px; object-fit: contain; flex-shrink: 0;
}
.hp-hero-card-badge {
    font-size: 11px; font-weight: 800; color: var(--primary);
    text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px;
}
.hp-hero-card-heading {
    font-size: 17px; font-weight: 800; color: var(--ink); line-height: 1.25; margin-bottom: 10px;
}
.hp-hero-card-heading span { color: var(--primary); }
.hp-hero-checklist { display: flex; flex-direction: column; gap: 6px; }
.hp-hero-check-item { display: flex; align-items: center; gap: 8px; font-size: 12.5px; font-weight: 700; color: #065f46; }
.hp-hero-check-item i { color: var(--green); font-size: 14px; }

/* ──────────────────────────────────────────────────
   SEARCH & FILTER BAR
────────────────────────────────────────────────── */
.hp-search-container {
    display: flex; gap: 12px; margin-top: 24px; position: relative;
}
.hp-search-wrapper {
    flex: 1; position: relative; display: flex; align-items: center;
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: 16px; padding: 0 16px; box-shadow: var(--shadow-sm);
    transition: all 0.2s;
}
.hp-search-wrapper:focus-within { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(0,119,136,0.1); }
.hp-search-icon { color: var(--muted); font-size: 17px; margin-right: 12px; }
.hp-search-input {
    width: 100%; border: none; outline: none; background: transparent;
    font-size: 14.5px; font-weight: 500; font-family: inherit; color: var(--ink);
    padding: 16px 0;
}
.hp-search-input::placeholder { color: #94a3b8; }
.hp-mic-icon { color: var(--muted); font-size: 17px; cursor: pointer; padding: 8px; transition: color 0.2s; }
.hp-mic-icon:hover { color: var(--primary); }

.hp-filter-btn {
    display: flex; align-items: center; gap: 8px;
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: 16px; padding: 0 20px; font-size: 14.5px; font-weight: 800;
    color: var(--primary); cursor: pointer; transition: all 0.2s;
    box-shadow: var(--shadow-sm); white-space: nowrap;
}
.hp-filter-btn:hover { background: var(--primary-light); border-color: var(--primary); }

/* Search Dropdown */
#hp-doctor-dropdown {
    position: absolute; top: calc(100% + 8px); left: 0; right: 80px;
    background: var(--white); border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15); border: 1.5px solid var(--border);
    overflow: hidden; z-index: 9999; display: none;
}
#hp-doctor-dropdown.open { display: block; }
#hp-doctor-dropdown a {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 18px; color: var(--ink) !important; border-bottom: 1px solid var(--bg);
    transition: background 0.15s;
}
#hp-doctor-dropdown a:hover { background: var(--primary-soft); }

/* ──────────────────────────────────────────────────
   POPULAR CONDITIONS CAROUSEL
────────────────────────────────────────────────── */
.hp-section-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 16px;
}
.hp-section-title { font-size: 19px; font-weight: 900; color: var(--ink); letter-spacing: -0.03em; }
.hp-section-link { font-size: 13.5px; font-weight: 800; color: var(--primary); display: flex; align-items: center; gap: 4px; }
.hp-section-link:hover { text-decoration: underline; }

.hp-conditions-scroll {
    display: flex; gap: 14px; overflow-x: auto; scrollbar-width: none;
    padding-bottom: 8px; margin: 0 -20px; padding: 0 20px 8px;
    -webkit-overflow-scrolling: touch;
}
.hp-conditions-scroll::-webkit-scrollbar { display: none; }

.hp-condition-card {
    min-width: 105px; flex-shrink: 0; background: var(--white);
    border: 1.5px solid var(--border); border-radius: 16px;
    padding: 16px 12px; text-align: center; cursor: pointer;
    transition: all 0.2s; display: flex; flex-direction: column;
    align-items: center; gap: 10px;
}
.hp-condition-card:hover, .hp-condition-card.active {
    border-color: var(--primary); box-shadow: 0 6px 20px rgba(0,119,136,0.12);
    transform: translateY(-2px); background: var(--primary-soft);
}
.hp-condition-icon {
    width: 48px; height: 48px; border-radius: 14px;
    background: var(--primary-light); color: var(--primary);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; transition: all 0.2s;
}
.hp-condition-card:hover .hp-condition-icon {
    background: var(--primary); color: #fff;
}
.hp-condition-icon img { width: 28px; height: 28px; object-fit: contain; }
.hp-condition-name { font-size: 12.5px; font-weight: 800; color: var(--ink); line-height: 1.25; }

/* ──────────────────────────────────────────────────
   PROMO BANNER - BOOK A SESSION
────────────────────────────────────────────────── */
.hp-promo-banner {
    background: linear-gradient(135deg, #005566 0%, #007788 50%, #0ea5e9 100%);
    border-radius: var(--radius-xl); padding: 26px 28px; color: #fff;
    box-shadow: 0 12px 36px rgba(0,119,136,0.25); position: relative; overflow: hidden;
}
.hp-promo-banner::before {
    content: ''; position: absolute; right: -40px; top: -40px;
    width: 200px; height: 200px; border-radius: 50%; background: rgba(255,255,255,0.06);
}
.hp-promo-top {
    display: flex; align-items: center; justify-content: space-between;
    gap: 20px; flex-wrap: wrap; margin-bottom: 22px;
}
.hp-promo-left { display: flex; align-items: center; gap: 16px; }
.hp-promo-icon-bg {
    width: 56px; height: 56px; border-radius: 16px;
    background: rgba(255,255,255,0.18); backdrop-filter: blur(10px);
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; color: #fff; flex-shrink: 0;
}
.hp-promo-title { font-size: 20px; font-weight: 900; letter-spacing: -0.02em; margin-bottom: 2px; }
.hp-promo-subtitle { font-size: 13.5px; color: rgba(255,255,255,0.85); font-weight: 500; }

.hp-promo-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: #fff; color: var(--primary); font-size: 14.5px; font-weight: 900;
    padding: 12px 24px; border-radius: 12px; transition: all 0.2s;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
}
.hp-promo-btn:hover { background: var(--primary-soft); transform: translateY(-2px); }

.hp-promo-bottom {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;
    padding-top: 18px; border-top: 1px solid rgba(255,255,255,0.15);
}
.hp-promo-feature { display: flex; align-items: center; gap: 12px; }
.hp-promo-feat-icon {
    width: 38px; height: 38px; border-radius: 50%;
    background: rgba(255,255,255,0.12); display: flex; align-items: center;
    justify-content: center; font-size: 16px; flex-shrink: 0;
}
.hp-promo-feat-title { font-size: 13px; font-weight: 800; color: #fff; }
.hp-promo-feat-desc { font-size: 11px; color: rgba(255,255,255,0.75); margin-top: 1px; }

/* ──────────────────────────────────────────────────
   AVAILABLE NEARBY DOCTORS LIST
────────────────────────────────────────────────── */
.hp-doctors-grid { display: flex; flex-direction: column; gap: 16px; }

.hp-doc-card-row {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: var(--radius-xl); padding: 18px 20px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 20px; transition: all 0.2s; position: relative;
}
.hp-doc-card-row:hover {
    border-color: var(--accent-teal); box-shadow: var(--shadow);
    transform: translateY(-2px);
}

.hp-doc-left-info { display: flex; align-items: center; gap: 16px; flex: 1; min-width: 0; }
.hp-doc-avatar {
    width: 64px; height: 64px; border-radius: 50%; object-fit: cover;
    border: 2px solid var(--primary-light); flex-shrink: 0;
}
.hp-doc-avatar-ph {
    width: 64px; height: 64px; border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--accent-teal));
    color: #fff; font-size: 22px; font-weight: 900;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.hp-doc-details { flex: 1; min-width: 0; }
.hp-doc-name-row { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
.hp-doc-name { font-size: 16.5px; font-weight: 900; color: var(--ink); }
.hp-verified-icon { color: var(--green); font-size: 15px; }

.hp-doc-exp { font-size: 12.5px; color: var(--muted); font-weight: 600; margin: 2px 0 6px; }
.hp-doc-rating { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 800; color: #d97706; margin-bottom: 8px; }

.hp-doc-tags { display: flex; gap: 6px; flex-wrap: wrap; }
.hp-doc-tag {
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 6px; padding: 2px 8px; font-size: 11px;
    font-weight: 700; color: var(--muted);
}

.hp-doc-right-action {
    display: flex; flex-direction: column; align-items: flex-end;
    gap: 8px; flex-shrink: 0; text-align: right;
}
.hp-slots-badge {
    background: var(--green-bg); color: var(--green-text);
    border-radius: 50px; padding: 4px 12px; font-size: 11px; font-weight: 800;
}
.hp-doc-price { font-size: 17px; font-weight: 900; color: var(--ink); }
.hp-doc-price span { font-size: 12px; font-weight: 600; color: var(--muted); }
.hp-chevron-link {
    width: 32px; height: 32px; border-radius: 50%; background: var(--bg);
    display: flex; align-items: center; justify-content: center;
    color: var(--muted); font-size: 13px; transition: all 0.2s;
}
.hp-doc-card-row:hover .hp-chevron-link { background: var(--primary-light); color: var(--primary); }

/* ──────────────────────────────────────────────────
   HOW IT WORKS (5 STEPS)
────────────────────────────────────────────────── */
.hp-how-scroll {
    display: grid; grid-template-columns: repeat(5, 1fr); gap: 14px;
}
.hp-how-card {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: 16px; padding: 18px 14px; text-align: left;
    position: relative; transition: all 0.2s;
}
.hp-how-card:hover { border-color: var(--primary); transform: translateY(-2px); box-shadow: var(--shadow-sm); }
.hp-how-num {
    width: 28px; height: 28px; border-radius: 50%;
    background: var(--primary); color: #fff; font-size: 13px; font-weight: 900;
    display: flex; align-items: center; justify-content: center; margin-bottom: 12px;
}
.hp-how-icon { font-size: 22px; color: var(--primary); margin-bottom: 10px; }
.hp-how-title { font-size: 13.5px; font-weight: 800; color: var(--ink); margin-bottom: 4px; line-height: 1.3; }
.hp-how-desc { font-size: 11.5px; color: var(--muted); line-height: 1.45; }

/* ──────────────────────────────────────────────────
   WHY CHOOSE PHYSIOPII (5 CARDS)
────────────────────────────────────────────────── */
.hp-why-grid-5 {
    display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px;
}
.hp-why-pill {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: 14px; padding: 14px; display: flex; align-items: center;
    gap: 12px; transition: all 0.2s;
}
.hp-why-pill:hover { border-color: var(--primary); transform: translateY(-2px); box-shadow: var(--shadow-sm); }
.hp-why-pill-icon {
    width: 36px; height: 36px; border-radius: 10px; background: var(--primary-light);
    color: var(--primary); display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
}
.hp-why-pill-text { font-size: 12.5px; font-weight: 800; color: var(--ink); line-height: 1.25; }

/* ──────────────────────────────────────────────────
   BILLING & PAYMENTS WIDGET
────────────────────────────────────────────────── */
.hp-billing-card {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: var(--radius-xl); padding: 22px 24px; box-shadow: var(--shadow-sm);
}
.hp-billing-grid {
    display: grid; grid-template-columns: 1fr 1fr 1.4fr; gap: 16px; margin-top: 16px;
}
.hp-bill-box {
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 14px; padding: 16px; display: flex; flex-direction: column; justify-content: space-between;
}
.hp-bill-box.green { background: #f0fdf4; border-color: #bbf7d0; }
.hp-bill-box.blue  { background: #f0f9ff; border-color: #bae6fd; }

.hp-bill-lbl { font-size: 11.5px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em; }
.hp-bill-val { font-size: 22px; font-weight: 900; color: var(--ink); margin: 6px 0 2px; }
.hp-bill-status { font-size: 11.5px; font-weight: 800; color: var(--green); display: flex; align-items: center; gap: 4px; }

.hp-bill-last-row { display: flex; align-items: center; justify-content: space-between; }
.hp-download-btn {
    width: 36px; height: 36px; border-radius: 50%; background: var(--white);
    border: 1px solid var(--border); display: flex; align-items: center; justify-content: center;
    color: var(--muted); font-size: 14px; cursor: pointer; transition: all 0.2s;
}
.hp-download-btn:hover { background: var(--primary); color: #fff; border-color: var(--primary); }

/* ──────────────────────────────────────────────────
   NEED HELP? SUPPORT BANNER
────────────────────────────────────────────────── */
.hp-support-banner {
    background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
    border: 1.5px solid #bae6fd; border-radius: var(--radius-xl);
    padding: 24px 28px; display: flex; align-items: center; justify-content: space-between;
    gap: 20px; flex-wrap: wrap; margin-top: 10px;
}
.hp-support-left { display: flex; align-items: center; gap: 18px; }
.hp-support-av-wrap { position: relative; }
.hp-support-av { width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; }
.hp-support-dot { width: 12px; height: 12px; border-radius: 50%; background: var(--green); border: 2px solid #fff; position: absolute; bottom: 2px; right: 2px; }

.hp-support-title { font-size: 18px; font-weight: 900; color: #0c4a6e; margin-bottom: 6px; }
.hp-support-chips { display: flex; gap: 12px; flex-wrap: wrap; }
.hp-support-chip { font-size: 12px; font-weight: 700; color: #0284c7; display: flex; align-items: center; gap: 5px; }
.hp-support-chip i { font-size: 10px; color: var(--green); }

.hp-support-actions { display: flex; gap: 12px; }
.hp-call-btn {
    display: flex; align-items: center; gap: 8px;
    background: #007788; color: #fff; font-size: 14.5px; font-weight: 800;
    padding: 12px 22px; border-radius: 12px; transition: all 0.2s;
    box-shadow: 0 4px 14px rgba(0,119,136,0.25);
}
.hp-call-btn:hover { background: #005566; transform: translateY(-1px); }
.hp-chat-btn {
    display: flex; align-items: center; gap: 8px;
    background: #fff; color: #007788; border: 1.5px solid #007788;
    font-size: 14.5px; font-weight: 800; padding: 12px 20px; border-radius: 12px;
    transition: all 0.2s;
}
.hp-chat-btn:hover { background: var(--primary-light); }

/* ──────────────────────────────────────────────────
   FIXED MOBILE BOTTOM NAVIGATION
────────────────────────────────────────────────── */
.hp-mobile-nav {
    display: none;
    position: fixed; bottom: 0; left: 0; right: 0;
    background: var(--white); border-top: 1px solid var(--border);
    height: 66px; z-index: 9999; padding: 0 10px;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.06);
}
.hp-mobile-nav-inner {
    display: flex; align-items: center; justify-content: space-around;
    height: 100%; max-width: 500px; margin: 0 auto; position: relative;
}
.hp-nav-link {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 4px; font-size: 11px; font-weight: 700; color: var(--muted);
    width: 20%; height: 100%; transition: color 0.15s;
}
.hp-nav-link i { font-size: 18px; }
.hp-nav-link.active { color: var(--primary); }

.hp-nav-center-btn {
    position: absolute; top: -18px; left: 50%; transform: translateX(-50%);
    width: 52px; height: 52px; border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--accent-teal));
    color: #fff; display: flex; align-items: center; justify-content: center;
    font-size: 22px; box-shadow: 0 6px 18px rgba(0,119,136,0.35);
    border: 4px solid #fff; text-decoration: none;
}

/* ──────────────────────────────────────────────────
   RESPONSIVE MEDIA QUERIES
────────────────────────────────────────────────── */
@media (max-width: 1024px) {
    .hp-hero-box { grid-template-columns: 1fr; }
    .hp-hero-card { display: none; }
    .hp-how-scroll { grid-template-columns: repeat(3, 1fr); }
    .hp-why-grid-5 { grid-template-columns: repeat(3, 1fr); }
    .hp-billing-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 768px) {
    .hp-mobile-nav { display: block; }
    .hp-promo-bottom { grid-template-columns: 1fr; gap: 12px; }
    .hp-how-scroll { grid-template-columns: repeat(2, 1fr); }
    .hp-why-grid-5 { grid-template-columns: 1fr 1fr; }
    .hp-billing-grid { grid-template-columns: 1fr; }
    .hp-doc-card-row { flex-direction: column; align-items: flex-start; gap: 14px; }
    .hp-doc-right-action { width: 100%; flex-direction: row; justify-content: space-between; align-items: center; text-align: left; pt-2; border-top: 1px solid var(--bg); padding-top: 10px; }
    .hp-support-banner { flex-direction: column; align-items: flex-start; }
    .hp-support-actions { width: 100%; }
    .hp-call-btn, .hp-chat-btn { flex: 1; justify-content: center; }
    .hp-search-container { flex-direction: column; }
    .hp-filter-btn { justify-content: center; padding: 12px; }
    #hp-doctor-dropdown { right: 0; }
}

@media (max-width: 480px) {
    .hp-how-scroll { grid-template-columns: 1fr; }
    .hp-why-grid-5 { grid-template-columns: 1fr; }
    .hp-greeting-title { font-size: 22px; }
}
</style>

{{-- CUSTOM HEADER BAR MATCHING SCREENSHOT --}}
<div class="hp-top-header">
    <div class="hp-top-header-inner">
        <div class="hp-brand">
            <button class="hp-burger-btn" onclick="document.getElementById('ptMobileNav') ? document.getElementById('ptMobileNav').classList.toggle('open') : null">
                <i class="fa-solid fa-bars"></i>
            </button>
            <a href="/">
                <img src="{{ asset('logo.png') }}" alt="Physiopii" class="hp-logo-img">
            </a>
        </div>
        <div class="hp-header-actions">
            <a href="#" class="hp-icon-btn" title="Notifications">
                <i class="fa-regular fa-bell"></i>
                <span class="hp-icon-badge">3</span>
            </a>
            @auth
                <a href="{{ route('patient.dashboard') }}">
                    @if(Auth::user()->profile_img)
                        <img src="{{ str_contains(Auth::user()->profile_img, '/') ? asset(Auth::user()->profile_img) : asset('uploads/profile/'.Auth::user()->profile_img) }}" class="hp-user-avatar" alt="Profile">
                    @else
                        <div class="hp-user-avatar-ph">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    @endif
                </a>
            @else
                <a href="{{ route('login') }}" class="hp-icon-btn" title="Login">
                    <i class="fa-regular fa-user"></i>
                </a>
            @endauth
        </div>
    </div>
</div>

<div class="hp-container">

    {{-- 1. GREETING & HERO BANNER --}}
    <div class="hp-hero-box">
        <div>
            <div class="hp-greeting-sub">
                Hello {{ Auth::check() ? Auth::user()->name : 'Rahul' }} 👋
            </div>
            <h1 class="hp-greeting-title">
                How can we help you today?
            </h1>
            <p class="hp-greeting-desc">
                Find expert physiotherapists and book home visits with ease.
            </p>
        </div>

        <div class="hp-hero-card">
            <div>
                <div class="hp-hero-card-badge">Doorstep Service</div>
                <div class="hp-hero-card-heading">Expert Physiotherapy<br>at <span>Your Home</span></div>
                <div class="hp-hero-checklist">
                    <div class="hp-hero-check-item"><i class="fa-solid fa-circle-check"></i> Safe &amp; Hygienic</div>
                    <div class="hp-hero-check-item"><i class="fa-solid fa-circle-check"></i> Convenient</div>
                    <div class="hp-hero-check-item"><i class="fa-solid fa-circle-check"></i> Effective Care</div>
                </div>
            </div>
            <div style="font-size:56px;color:var(--primary);opacity:.8">
                <i class="fa-solid fa-house-medical"></i>
            </div>
        </div>
    </div>

    {{-- 2. SEARCH & FILTER BAR --}}
    <div class="hp-search-container">
        <div class="hp-search-wrapper">
            <i class="fa-solid fa-magnifying-glass hp-search-icon"></i>
            <input type="text" id="doctorSearch" class="hp-search-input" placeholder="Search for condition (e.g. back pain, knee pain, ACL rehab)" autocomplete="off">
            <i class="fa-solid fa-microphone hp-mic-icon" title="Voice Search"></i>
        </div>
        <button class="hp-filter-btn" type="button">
            <i class="fa-solid fa-sliders"></i> Filter
        </button>

        {{-- Live Search Dropdown --}}
        <div id="hp-doctor-dropdown"></div>
    </div>

    {{-- 3. POPULAR CONDITIONS CAROUSEL --}}
    <div class="hp-section">
        <div class="hp-section-header">
            <h2 class="hp-section-title">Popular Conditions</h2>
            <a href="#" class="hp-section-link">View all <i class="fa-solid fa-chevron-right" style="font-size:11px"></i></a>
        </div>

        <div class="hp-conditions-scroll">
            @php
                $popularItems = [
                    ['name' => 'Back Pain', 'icon' => 'fa-child-reaching'],
                    ['name' => 'Neck Pain', 'icon' => 'fa-user-nurse'],
                    ['name' => 'Knee Pain', 'icon' => 'fa-bone'],
                    ['name' => 'Shoulder Pain', 'icon' => 'fa-child'],
                    ['name' => 'Hip Pain', 'icon' => 'fa-person-walking'],
                    ['name' => 'ACL Rehab', 'icon' => 'fa-running'],
                    ['name' => 'Sciatica', 'icon' => 'fa-bolt'],
                    ['name' => 'Post Surgery', 'icon' => 'fa-hospital-user'],
                ];
            @endphp

            @foreach($specializations as $index => $spec)
                <div class="hp-condition-card specialization-filter" data-id="{{ $spec->id }}">
                    <div class="hp-condition-icon">
                        @if($spec->icon)
                            <img src="{{ asset('images/specializations/'.$spec->icon) }}" alt="{{ $spec->name }}">
                        @else
                            <i class="fa-solid {{ $popularItems[$index % count($popularItems)]['icon'] }}"></i>
                        @endif
                    </div>
                    <div class="hp-condition-name">{{ $spec->name }}</div>
                </div>
            @endforeach

            @if($specializations->isEmpty())
                @foreach($popularItems as $item)
                    <div class="hp-condition-card">
                        <div class="hp-condition-icon"><i class="fa-solid {{ $item['icon'] }}"></i></div>
                        <div class="hp-condition-name">{{ $item['name'] }}</div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- 4. PROMO BANNER - BOOK A SESSION --}}
    <div class="hp-promo-banner">
        <div class="hp-promo-top">
            <div class="hp-promo-left">
                <div class="hp-promo-icon-bg">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                <div>
                    <h3 class="hp-promo-title">Book a Session</h3>
                    <p class="hp-promo-subtitle">Quality care, at your comfort. Book a home visit now!</p>
                </div>
            </div>
            @auth
                <a href="#available-doctors" class="hp-promo-btn">
                    Book Now <i class="fa-solid fa-arrow-right"></i>
                </a>
            @else
                <a href="{{ route('patient.register') }}" class="hp-promo-btn">
                    Book Now <i class="fa-solid fa-arrow-right"></i>
                </a>
            @endauth
        </div>

        <div class="hp-promo-bottom">
            <div class="hp-promo-feature">
                <div class="hp-promo-feat-icon"><i class="fa-solid fa-user-check"></i></div>
                <div>
                    <div class="hp-promo-feat-title">Verified Experts</div>
                    <div class="hp-promo-feat-desc">Experienced &amp; trusted professionals</div>
                </div>
            </div>
            <div class="hp-promo-feature">
                <div class="hp-promo-feat-icon"><i class="fa-solid fa-tag"></i></div>
                <div>
                    <div class="hp-promo-feat-title">Affordable Care</div>
                    <div class="hp-promo-feat-desc">Transparent pricing with no hidden cost</div>
                </div>
            </div>
            <div class="hp-promo-feature">
                <div class="hp-promo-feat-icon"><i class="fa-solid fa-house-chimney-medical"></i></div>
                <div>
                    <div class="hp-promo-feat-title">At Your Home</div>
                    <div class="hp-promo-feat-desc">Comfort of home, better recovery</div>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. AVAILABLE NEARBY DOCTORS --}}
    <div class="hp-section" id="available-doctors">
        <div class="hp-section-header">
            <h2 class="hp-section-title">
                Available Nearby For <span style="color:var(--primary);cursor:pointer">Back Pain <i class="fa-solid fa-chevron-down" style="font-size:13px"></i></span>
            </h2>
            <a href="#" class="hp-section-link">View all <i class="fa-solid fa-chevron-right" style="font-size:11px"></i></a>
        </div>

        <div class="hp-doctors-grid">
            @foreach($doctors as $doctor)
                @php
                    $rating = round(optional($doctor->profile)->rating ?? 4.9, 1);
                    $reviewCount = rand(150, 350);
                    $slotsCount = rand(4, 8);
                    $price = $doctor->fee->doctor_fee ?? 700;
                    $specName = optional(optional($doctor->profile)->specializationdata)->name ?? 'Orthopedics';
                @endphp
                <div class="hp-doc-card-row">
                    <div class="hp-doc-left-info">
                        @if($doctor->profile_img)
                            <img src="{{ str_contains($doctor->profile_img, '/') ? asset($doctor->profile_img) : asset('uploads/profile/'.$doctor->profile_img) }}" alt="{{ $doctor->name }}" class="hp-doc-avatar">
                        @else
                            <div class="hp-doc-avatar-ph">{{ strtoupper(substr($doctor->name, 0, 1)) }}</div>
                        @endif
                        <div class="hp-doc-details">
                            <div class="hp-doc-name-row">
                                <a href="{{ route('doctor.profile', $doctor->id) }}" class="hp-doc-name">Dr. {{ $doctor->name }}</a>
                                <i class="fa-solid fa-circle-check hp-verified-icon"></i>
                            </div>
                            <div class="hp-doc-exp">
                                MPT ({{ $specName }}) &middot; {{ optional($doctor->profile)->experience_years ?? 8 }} Years Exp.
                            </div>
                            <div class="hp-doc-rating">
                                <i class="fa-solid fa-star"></i> {{ $rating }} ({{ $reviewCount }} reviews)
                            </div>
                            <div class="hp-doc-tags">
                                <span class="hp-doc-tag">Back Pain</span>
                                <span class="hp-doc-tag">Neck Pain</span>
                                <span class="hp-doc-tag">Sports Injury</span>
                                <span class="hp-doc-tag">+2 more</span>
                            </div>
                        </div>
                    </div>

                    <div class="hp-doc-right-action">
                        <div class="hp-slots-badge">{{ $slotsCount }} Slots Available</div>
                        <div class="hp-doc-price">₹{{ number_format($price, 0) }} <span>/ session</span></div>
                        <a href="{{ route('doctor.profile', $doctor->id) }}" class="hp-chevron-link">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- 6. HOW IT WORKS (5 STEPS) --}}
    <div class="hp-section">
        <div class="hp-section-header">
            <h2 class="hp-section-title">How it works?</h2>
        </div>

        <div class="hp-how-scroll">
            <div class="hp-how-card">
                <div class="hp-how-num">1</div>
                <div class="hp-how-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                <div class="hp-how-title">Search Condition</div>
                <div class="hp-how-desc">Search for your problem or choose from popular conditions</div>
            </div>
            <div class="hp-how-card">
                <div class="hp-how-num">2</div>
                <div class="hp-how-icon"><i class="fa-solid fa-user-doctor"></i></div>
                <div class="hp-how-title">Choose Your Physiotherapist</div>
                <div class="hp-how-desc">Select the best physiotherapist for your needs</div>
            </div>
            <div class="hp-how-card">
                <div class="hp-how-num">3</div>
                <div class="hp-how-icon"><i class="fa-solid fa-box-archive"></i></div>
                <div class="hp-how-title">Book Package</div>
                <div class="hp-how-desc">Choose the right package that suits your recovery</div>
            </div>
            <div class="hp-how-card">
                <div class="hp-how-num">4</div>
                <div class="hp-how-icon"><i class="fa-regular fa-calendar-days"></i></div>
                <div class="hp-how-title">Choose Date &amp; Time</div>
                <div class="hp-how-desc">Pick a convenient date and time for your session</div>
            </div>
            <div class="hp-how-card">
                <div class="hp-how-num">5</div>
                <div class="hp-how-icon"><i class="fa-solid fa-house-chimney-medical"></i></div>
                <div class="hp-how-title">Start Your Session at Home</div>
                <div class="hp-how-desc">Your physiotherapist will visit and start your care</div>
            </div>
        </div>
    </div>

    {{-- 7. WHY CHOOSE PHYSIOPII (5 PILLS) --}}
    <div class="hp-section">
        <div class="hp-section-header">
            <h2 class="hp-section-title">Why Choose PhysioPii?</h2>
        </div>

        <div class="hp-why-grid-5">
            <div class="hp-why-pill">
                <div class="hp-why-pill-icon"><i class="fa-solid fa-user-shield"></i></div>
                <div class="hp-why-pill-text">Verified &amp; Experienced Physiotherapists</div>
            </div>
            <div class="hp-why-pill">
                <div class="hp-why-pill-icon"><i class="fa-solid fa-heart-pulse"></i></div>
                <div class="hp-why-pill-text">Personalized Treatment</div>
            </div>
            <div class="hp-why-pill">
                <div class="hp-why-pill-icon"><i class="fa-solid fa-house-medical"></i></div>
                <div class="hp-why-pill-text">Home Visit Convenience</div>
            </div>
            <div class="hp-why-pill">
                <div class="hp-why-pill-icon"><i class="fa-solid fa-chart-line"></i></div>
                <div class="hp-why-pill-text">Track Progress Digitally</div>
            </div>
            <div class="hp-why-pill">
                <div class="hp-why-pill-icon"><i class="fa-solid fa-shield-cat"></i></div>
                <div class="hp-why-pill-text">Safe, Hygienic &amp; Trusted</div>
            </div>
        </div>
    </div>

    {{-- 8. BILLING & PAYMENTS SUMMARY --}}
    <div class="hp-section">
        <div class="hp-billing-card">
            <div class="hp-section-header" style="margin-bottom:4px">
                <div>
                    <h2 class="hp-section-title"><i class="fa-solid fa-receipt" style="color:var(--primary);margin-right:6px"></i> Billing &amp; Payments</h2>
                    <p style="font-size:12.5px;color:var(--muted)">Track your payments and invoices</p>
                </div>
                @auth
                    <a href="{{ route('patient.dashboard') }}" class="hp-section-link">View All <i class="fa-solid fa-chevron-right" style="font-size:11px"></i></a>
                @else
                    <a href="{{ route('login') }}" class="hp-section-link">View All <i class="fa-solid fa-chevron-right" style="font-size:11px"></i></a>
                @endauth
            </div>

            <div class="hp-billing-grid">
                <div class="hp-bill-box green">
                    <div class="hp-bill-lbl">Unpaid Amount</div>
                    <div class="hp-bill-val">₹0</div>
                    <div class="hp-bill-status"><i class="fa-solid fa-circle-check"></i> All clear!</div>
                </div>
                <div class="hp-bill-box blue">
                    <div class="hp-bill-lbl">Total Spent</div>
                    <div class="hp-bill-val">₹6,300</div>
                    <div style="font-size:11.5px;color:var(--muted)">Across 9 sessions</div>
                </div>
                <div class="hp-bill-box">
                    <div class="hp-bill-lbl">Last Payment</div>
                    <div class="hp-bill-last-row" style="margin-top:6px">
                        <div>
                            <div style="font-size:14.5px;font-weight:800;color:var(--ink)">02 May 2025 &middot; ₹1,400</div>
                            <div style="font-size:12px;color:var(--green);font-weight:700;margin-top:2px">UPI &middot; Paid</div>
                        </div>
                        <button class="hp-download-btn" title="Download Receipt">
                            <i class="fa-solid fa-download"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 9. NEED HELP? BANNER --}}
    <div class="hp-support-banner">
        <div class="hp-support-left">
            <div class="hp-support-av-wrap">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=200" alt="Support" class="hp-support-av">
                <span class="hp-support-dot"></span>
            </div>
            <div>
                <h3 class="hp-support-title">Need Help?</h3>
                <div style="font-size:13.5px;color:#0369a1;margin-bottom:8px;font-weight:600">Our care team is here for you 24x7</div>
                <div class="hp-support-chips">
                    <span class="hp-support-chip"><i class="fa-solid fa-bolt"></i> Quick Response</span>
                    <span class="hp-support-chip"><i class="fa-solid fa-circle-check"></i> Easy Booking</span>
                    <span class="hp-support-chip"><i class="fa-solid fa-graduation-cap"></i> Expert Guidance</span>
                </div>
            </div>
        </div>
        <div class="hp-support-actions">
            <a href="tel:+13153695943" class="hp-call-btn">
                <i class="fa-solid fa-phone"></i> Call Us
            </a>
            <a href="#" class="hp-chat-btn">
                <i class="fa-solid fa-comments"></i> Chat
            </a>
        </div>
    </div>

</div>

{{-- FIXED MOBILE BOTTOM NAVIGATION --}}
<div class="hp-mobile-nav">
    <div class="hp-mobile-nav-inner">
        <a href="/" class="hp-nav-link active">
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('patient.dashboard') }}" class="hp-nav-link">
            <i class="fa-regular fa-calendar-check"></i>
            <span>Bookings</span>
        </a>
        <a href="#available-doctors" class="hp-nav-center-btn" title="Book Now">
            <i class="fa-solid fa-plus"></i>
        </a>
        <a href="{{ route('patient.dashboard') }}" class="hp-nav-link">
            <i class="fa-regular fa-file-lines"></i>
            <span>Billing</span>
        </a>
        <a href="{{ Auth::check() ? route('patient.profile') : route('login') }}" class="hp-nav-link">
            <i class="fa-regular fa-user"></i>
            <span>Profile</span>
        </a>
    </div>
</div>

<script>
(function() {
    const input = document.getElementById('doctorSearch');
    const dropdown = document.getElementById('hp-doctor-dropdown');
    if (!input) return;

    let debounce;
    input.addEventListener('input', function() {
        clearTimeout(debounce);
        const q = this.value.trim();
        if (q.length < 2) { dropdown.innerHTML = ''; dropdown.classList.remove('open'); return; }
        debounce = setTimeout(() => {
            fetch(`/search-doctors?q=${encodeURIComponent(q)}`)
                .then(r => r.json())
                .then(data => {
                    if (!data.length) { dropdown.innerHTML = ''; dropdown.classList.remove('open'); return; }
                    dropdown.innerHTML = data.slice(0,6).map(d => {
                        const spec = (d.profile && d.profile.specializationdata && d.profile.specializationdata.name)
                            ? d.profile.specializationdata.name
                            : 'Physiotherapist';
                        const initial = d.name ? d.name.charAt(0).toUpperCase() : 'D';
                        return `<a href="/doctor/${d.id}">
                            <div style="display:flex;align-items:center;gap:12px">
                                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#0ea5e9,#38bdf8);color:#fff;font-size:14px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0">${initial}</div>
                                <div>
                                    <div style="font-size:14px;font-weight:800;color:#0f172a">Dr. ${d.name}</div>
                                    <div style="font-size:12px;color:#64748b;margin-top:1px">${spec}</div>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right" style="font-size:12px;color:#0ea5e9"></i>
                        </a>`;
                    }).join('');
                    dropdown.classList.add('open');
                }).catch(() => {});
        }, 280);
    });

    document.addEventListener('click', (e) => {
        if (!input.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove('open');
        }
    });
})();
</script>
@endsection