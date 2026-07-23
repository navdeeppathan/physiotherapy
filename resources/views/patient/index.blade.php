@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ── RESET & BASE ─────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
    --primary:   #0ea5e9;
    --primary-d: #0284c7;
    --primary-l: #e0f2fe;
    --ink:       #0f172a;
    --body:      #334155;
    --muted:     #64748b;
    --border:    #e2e8f0;
    --bg:        #f8fafc;
    --white:     #ffffff;
    --radius-xl: 24px;
    --radius-lg: 18px;
    --radius:    12px;
    --shadow-sm: 0 2px 10px rgba(0,0,0,.06);
    --shadow:    0 8px 32px rgba(0,0,0,.09);
    --shadow-lg: 0 20px 60px rgba(0,0,0,.12);
}
body { font-family: 'Plus Jakarta Sans', sans-serif; color: var(--body); background: var(--white); overflow-x: hidden; }
a { text-decoration: none; color: inherit; }
img { max-width: 100%; display: block; }
section { overflow: visible; }

/* ── CONTAINERS ── */
.hp-container { max-width: 1280px; margin: 0 auto; padding: 0 24px; }
.hp-section    { padding: 88px 0; }

/* ── SECTION LABELS ── */
.hp-badge {
    display: inline-flex; align-items: center; gap: 7px;
    background: var(--primary-l); color: var(--primary-d);
    border: 1px solid #bae6fd; border-radius: 50px;
    padding: 5px 14px; font-size: 11px; font-weight: 800;
    letter-spacing: .08em; text-transform: uppercase; margin-bottom: 16px;
}
.hp-badge-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--primary); }
.hp-section-heading { font-size: clamp(28px, 4vw, 42px); font-weight: 900; color: var(--ink); letter-spacing: -.04em; line-height: 1.15; }
.hp-section-sub     { font-size: 16px; color: var(--muted); margin-top: 10px; line-height: 1.7; max-width: 560px; }
.hp-section-sub.center { text-align: center; margin: 10px auto 0; }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   HERO
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.hp-hero {
    background: linear-gradient(160deg, #0c4a6e 0%, #0369a1 55%, #0ea5e9 100%);
    padding: 80px 0 0;
    position: relative;
    overflow: visible;
}
.hp-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='30'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
}
.hp-hero-grid {
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 60px;
    align-items: flex-end;
    position: relative; z-index: 1;
}
/* Left */
.hp-hero-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2);
    border-radius: 50px; padding: 6px 16px;
    font-size: 11.5px; font-weight: 700; color: rgba(255,255,255,.9);
    letter-spacing: .07em; text-transform: uppercase; margin-bottom: 22px;
}
.hp-hero-eyebrow-dot { width: 7px; height: 7px; border-radius: 50%; background: #34d399; animation: pulse 2s ease-in-out infinite; }
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.8)} }

.hp-hero-title {
    font-size: clamp(36px, 5.5vw, 66px);
    font-weight: 900;
    color: #fff;
    letter-spacing: -.05em;
    line-height: 1.05;
    margin-bottom: 20px;
}
.hp-hero-title span { color: #7dd3fc; }
.hp-hero-desc { font-size: 17px; color: rgba(255,255,255,.7); line-height: 1.75; margin-bottom: 36px; max-width: 520px; }

/* Search box */
.hp-search-box {
    background: rgba(255,255,255,.12);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 16px;
    padding: 8px 8px 8px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    max-width: 540px;
    margin-bottom: 24px;
    position: relative;
}
.hp-search-box svg { width: 18px; height: 18px; color: rgba(255,255,255,.6); flex-shrink: 0; }
.hp-search-input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    font-size: 15px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #fff;
    font-weight: 500;
}
.hp-search-input::placeholder { color: rgba(255,255,255,.55); }
.hp-search-btn {
    background: #fff;
    color: var(--primary-d);
    border: none;
    border-radius: 10px;
    padding: 11px 22px;
    font-size: 14px;
    font-weight: 800;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    transition: all .18s;
    white-space: nowrap;
    display: flex; align-items: center; gap: 6px;
}
.hp-search-btn:hover { background: #e0f2fe; }

#hp-doctor-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    left: 0; right: 0;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.22);
    overflow: hidden;
    z-index: 9999;
    display: none;
    border: 1.5px solid var(--border);
}
#hp-doctor-dropdown.open { display: block; }
#hp-doctor-dropdown a {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 18px;
    color: #0f172a !important;
    text-decoration: none;
    border-bottom: 1px solid #f1f5f9;
    transition: background .15s;
}
#hp-doctor-dropdown a:last-child { border-bottom: none; }
#hp-doctor-dropdown a:hover { background: #f0f9ff; }

.hp-hero-hints {
    display: flex; align-items: center; gap: 20px;
    flex-wrap: wrap;
}
.hp-hero-hint-item {
    display: flex; align-items: center; gap: 7px;
    font-size: 13px; color: rgba(255,255,255,.65); font-weight: 500;
}
.hp-hero-hint-item svg { width: 15px; height: 15px; color: #34d399; }

/* Right: Visual card stack */
.hp-hero-visual {
    display: flex;
    flex-direction: column;
    gap: 14px;
    padding-bottom: 0;
    align-self: flex-end;
}
.hp-hero-card {
    background: rgba(255,255,255,.12);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(255,255,255,.22);
    border-radius: var(--radius-lg);
    padding: 20px;
    color: #fff;
}
.hp-hero-card-title { font-size: 12px; color: rgba(255,255,255,.55); font-weight: 600; letter-spacing: .05em; text-transform: uppercase; margin-bottom: 14px; }
.hp-hero-doctor-row { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
.hp-hero-doc-av {
    width: 42px; height: 42px; border-radius: 50%;
    background: linear-gradient(135deg,#38bdf8,#0ea5e9);
    font-size: 15px; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.hp-hero-doc-name { font-size: 14px; font-weight: 700; }
.hp-hero-doc-spec { font-size: 12px; color: rgba(255,255,255,.6); margin-top: 2px; }
.hp-hero-slot {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(52,211,153,.2); border: 1px solid rgba(52,211,153,.35);
    border-radius: 8px; padding: 5px 12px;
    font-size: 12px; font-weight: 600; color: #6ee7b7;
}

.hp-hero-stat-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; margin-top: 4px; }
.hp-hero-stat-chip {
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 12px;
    padding: 12px 14px;
    text-align: center;
}
.hp-hero-stat-val { font-size: 20px; font-weight: 900; letter-spacing: -.03em; }
.hp-hero-stat-lbl { font-size: 10.5px; color: rgba(255,255,255,.5); margin-top: 3px; }

/* Stats bar */
.hp-stats-bar {
    background: var(--white);
    border-top: 1px solid rgba(255,255,255,.08);
    padding: 28px 0;
    position: relative; z-index: 2;
}
.hp-stats-bar-inner {
    max-width: 1280px; margin: 0 auto; padding: 0 24px;
    display: grid; grid-template-columns: repeat(4,1fr);
    gap: 24px;
}
.hp-stat-item { display: flex; align-items: center; gap: 16px; }
.hp-stat-icon-wrap {
    width: 48px; height: 48px; border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.hp-stat-icon-wrap.blue  { background: #e0f2fe; color: #0ea5e9; }
.hp-stat-icon-wrap.green { background: #d1fae5; color: #10b981; }
.hp-stat-icon-wrap.amber { background: #fef3c7; color: #f59e0b; }
.hp-stat-icon-wrap.rose  { background: #fee2e2; color: #ef4444; }
.hp-stat-icon-wrap i     { font-size: 18px; }
.hp-stat-val { font-size: 22px; font-weight: 900; color: var(--ink); letter-spacing: -.04em; }
.hp-stat-lbl { font-size: 13px; color: var(--muted); margin-top: 2px; }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   SPECIALISATIONS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.hp-spec { background: var(--bg); }
.hp-spec-head { text-align: center; margin-bottom: 48px; }
.hp-spec-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 16px;
}
.hp-spec-card {
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 26px 16px 20px;
    text-align: center;
    cursor: pointer;
    transition: all .22s;
    position: relative;
    overflow: hidden;
}
.hp-spec-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary), #38bdf8);
    transform: scaleX(0);
    transition: transform .22s;
    border-radius: 3px 3px 0 0;
}
.hp-spec-card:hover {
    border-color: #7dd3fc;
    box-shadow: 0 12px 32px rgba(14,165,233,.14);
    transform: translateY(-4px);
}
.hp-spec-card:hover::before { transform: scaleX(1); }
.hp-spec-icon-wrap { background: var(--primary-l); display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
    transition: background .22s;
}
.hp-spec-card:hover .hp-spec-icon-wrap { background: #bae6fd; }
.hp-spec-icon-wrap img { width: 32px; height: 32px; object-fit: contain; filter: none; }
.hp-spec-card:hover .hp-spec-icon-wrap img { filter: none; }
.hp-spec-name { font-size: 13px; font-weight: 700; color: var(--ink); line-height: 1.3; }

.hp-spec-viewall {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    border: none;
    color: #fff !important;
}
.hp-spec-viewall::before { display: none; }
.hp-spec-viewall .hp-spec-icon-wrap { background: rgba(255,255,255,.18); }
.hp-spec-viewall .hp-spec-icon-wrap i { font-size: 24px; color: #fff; }
.hp-spec-viewall .hp-spec-name { color: #fff; }
.hp-spec-viewall:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(14,165,233,.4); }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   DOCTORS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.hp-docs { background: var(--white); }
.hp-docs-head {
    display: flex; align-items: flex-end; justify-content: space-between;
    margin-bottom: 40px; flex-wrap: wrap; gap: 16px;
}
.hp-view-all-link {
    display: flex; align-items: center; gap: 6px;
    font-size: 14px; font-weight: 700; color: var(--primary);
    border: 1.5px solid #bae6fd;
    padding: 9px 18px; border-radius: 10px;
    transition: all .18s;
}
.hp-view-all-link:hover { background: var(--primary-l); border-color: #7dd3fc; }

.hp-doc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}
.hp-doc-card {
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-xl);
    overflow: hidden;
    transition: all .22s;
    position: relative;
}
.hp-doc-card:hover {
    box-shadow: var(--shadow-lg);
    border-color: #7dd3fc;
    transform: translateY(-5px);
}
/* colored top banner */
.hp-doc-banner {
    height: 88px;
    position: relative;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    padding: 0 16px 0;
}
.hp-doc-card.c0 .hp-doc-banner { background: linear-gradient(135deg,#0369a1,#0ea5e9); }
.hp-doc-card.c1 .hp-doc-banner { background: linear-gradient(135deg,#065f46,#10b981); }
.hp-doc-card.c2 .hp-doc-banner { background: linear-gradient(135deg,#6b21a8,#a855f7); }
.hp-doc-card.c3 .hp-doc-banner { background: linear-gradient(135deg,#92400e,#f59e0b); }

.hp-doc-photo {
    width: 76px; height: 76px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #fff;
    position: absolute;
    bottom: -20px; left: 20px;
    box-shadow: 0 4px 14px rgba(0,0,0,.15);
}
.hp-doc-photo-placeholder {
    width: 76px; height: 76px;
    border-radius: 50%;
    border: 3px solid #fff;
    position: absolute;
    bottom: -20px; left: 20px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; font-weight: 900; color: #fff;
    box-shadow: 0 4px 14px rgba(0,0,0,.15);
}
.hp-doc-card.c0 .hp-doc-photo-placeholder { background: linear-gradient(135deg,#0284c7,#38bdf8); }
.hp-doc-card.c1 .hp-doc-photo-placeholder { background: linear-gradient(135deg,#059669,#34d399); }
.hp-doc-card.c2 .hp-doc-photo-placeholder { background: linear-gradient(135deg,#7c3aed,#c084fc); }
.hp-doc-card.c3 .hp-doc-photo-placeholder { background: linear-gradient(135deg,#d97706,#fbbf24); }

.hp-doc-rating {
    background: rgba(255,255,255,.95);
    border-radius: 50px;
    padding: 4px 10px;
    font-size: 12px; font-weight: 800;
    color: var(--ink);
    display: flex; align-items: center; gap: 4px;
    align-self: flex-start; margin-top: 12px;
}
.hp-doc-rating i { color: #f59e0b; font-size: 11px; }

.hp-doc-body { padding: 28px 20px 20px; }
.hp-doc-name {
    font-size: 16px; font-weight: 800; color: var(--ink);
    display: flex; align-items: center; gap: 7px; margin-bottom: 4px;
}
.hp-doc-name a { color: inherit; }
.hp-doc-name a:hover { color: var(--primary); }
.hp-doc-verified { color: #0ea5e9; font-size: 14px; }
.hp-doc-spec { font-size: 13px; color: var(--primary-d); font-weight: 600; margin-bottom: 14px; }
.hp-doc-spec.c0 { color: #0284c7; } .hp-doc-spec.c1 { color: #059669; }
.hp-doc-spec.c2 { color: #7c3aed; } .hp-doc-spec.c3 { color: #d97706; }

.hp-doc-meta { display: flex; flex-direction: column; gap: 6px; margin-bottom: 18px; }
.hp-doc-meta li {
    display: flex; align-items: flex-start; gap: 8px;
    font-size: 12.5px; color: var(--muted); list-style: none;
}
.hp-doc-meta li i { font-size: 12px; color: var(--primary); margin-top: 2px; flex-shrink: 0; }

.hp-doc-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.hp-doc-btn-profile, .hp-doc-btn-book {
    padding: 9px 14px;
    border-radius: 10px;
    font-size: 13px; font-weight: 700;
    text-align: center;
    transition: all .18s;
    display: flex; align-items: center; justify-content: center; gap: 6px;
}
.hp-doc-btn-profile { background: var(--bg); color: var(--ink); border: 1.5px solid var(--border); }
.hp-doc-btn-profile:hover { background: #f1f5f9; border-color: #cbd5e1; }
.hp-doc-btn-book { background: linear-gradient(135deg,#0ea5e9,#38bdf8); color: #fff; border: none; box-shadow: 0 4px 12px rgba(14,165,233,.3); }
.hp-doc-btn-book:hover { background: linear-gradient(135deg,#0284c7,#0ea5e9); box-shadow: 0 6px 18px rgba(14,165,233,.4); transform: translateY(-1px); }
.hp-doc-btn-book.c1 { background: linear-gradient(135deg,#059669,#10b981); box-shadow: 0 4px 12px rgba(16,185,129,.3); }
.hp-doc-btn-book.c2 { background: linear-gradient(135deg,#7c3aed,#a855f7); box-shadow: 0 4px 12px rgba(139,92,246,.3); }
.hp-doc-btn-book.c3 { background: linear-gradient(135deg,#d97706,#f59e0b); box-shadow: 0 4px 12px rgba(245,158,11,.3); }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   HOW IT WORKS + WHY CHOOSE US (2-col)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.hp-how { background: var(--bg); }
.hp-how-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start; }

/* Steps */
.hp-step-list { display: flex; flex-direction: column; gap: 0; }
.hp-step {
    display: flex; gap: 20px;
    padding: 24px 0;
    border-bottom: 1px solid var(--border);
    position: relative;
}
.hp-step:last-child { border-bottom: none; }
.hp-step-left { display: flex; flex-direction: column; align-items: center; gap: 0; }
.hp-step-num {
    width: 44px; height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg,#0ea5e9,#38bdf8);
    color: #fff;
    font-size: 16px; font-weight: 900;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 6px 16px rgba(14,165,233,.35);
}
.hp-step-connector {
    width: 2px;
    flex: 1;
    background: linear-gradient(180deg, #7dd3fc, transparent);
    margin: 6px 0;
    min-height: 20px;
}
.hp-step:last-child .hp-step-connector { display: none; }
.hp-step-body { flex: 1; padding-top: 8px; }
.hp-step-title { font-size: 17px; font-weight: 800; color: var(--ink); margin-bottom: 7px; }
.hp-step-desc  { font-size: 14px; color: var(--muted); line-height: 1.7; }

/* Why grid */
.hp-why-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.hp-why-card {
    border-radius: var(--radius-lg);
    padding: 24px;
    transition: all .22s;
    border: 1.5px solid transparent;
}
.hp-why-card:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.hp-why-card.blue   { background: #eff6ff; border-color: #bfdbfe; }
.hp-why-card.green  { background: #f0fdf4; border-color: #bbf7d0; }
.hp-why-card.purple { background: #faf5ff; border-color: #e9d5ff; }
.hp-why-card.amber  { background: #fffbeb; border-color: #fde68a; }
.hp-why-icon {
    width: 48px; height: 48px; border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 14px; font-size: 20px;
}
.hp-why-card.blue   .hp-why-icon { background: #dbeafe; color: #2563eb; }
.hp-why-card.green  .hp-why-icon { background: #d1fae5; color: #059669; }
.hp-why-card.purple .hp-why-icon { background: #ede9fe; color: #7c3aed; }
.hp-why-card.amber  .hp-why-icon { background: #fef3c7; color: #d97706; }
.hp-why-title { font-size: 15px; font-weight: 800; color: var(--ink); margin-bottom: 6px; }
.hp-why-desc  { font-size: 13px; color: var(--muted); line-height: 1.65; }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   TESTIMONIALS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.hp-testi { background: var(--white); }
.hp-testi-head { text-align: center; margin-bottom: 48px; }
.hp-testi-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }

.hp-testi-card {
    background: var(--bg);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-xl);
    padding: 30px;
    transition: all .22s;
    position: relative;
}
.hp-testi-card:hover { box-shadow: var(--shadow); transform: translateY(-4px); border-color: #7dd3fc; }
.hp-testi-card.featured {
    background: linear-gradient(160deg, #0c4a6e, #0284c7);
    border-color: transparent;
    color: #fff;
}
.hp-testi-quote {
    font-size: 48px; line-height: .8; color: #e2e8f0; font-weight: 900;
    margin-bottom: 12px; font-family: Georgia, serif;
}
.hp-testi-card.featured .hp-testi-quote { color: rgba(255,255,255,.2); }
.hp-testi-stars { color: #f59e0b; font-size: 14px; letter-spacing: 2px; margin-bottom: 14px; }
.hp-testi-text { font-size: 15px; line-height: 1.75; color: var(--body); font-style: italic; margin-bottom: 24px; }
.hp-testi-card.featured .hp-testi-text { color: rgba(255,255,255,.85); }

.hp-testi-author { display: flex; align-items: center; gap: 14px; }
.hp-testi-av {
    width: 46px; height: 46px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; font-weight: 900; color: #fff; flex-shrink: 0;
}
.av-teal   { background: linear-gradient(135deg,#0ea5e9,#38bdf8); }
.av-purple { background: linear-gradient(135deg,#7c3aed,#a855f7); }
.av-green  { background: linear-gradient(135deg,#059669,#10b981); }
.hp-testi-name { font-size: 14px; font-weight: 800; color: var(--ink); }
.hp-testi-card.featured .hp-testi-name { color: #fff; }
.hp-testi-role { font-size: 12px; color: var(--muted); margin-top: 2px; }
.hp-testi-card.featured .hp-testi-role { color: rgba(255,255,255,.6); }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   CTA BANNER
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.hp-cta { background: var(--bg); padding: 0 0 88px; }
.hp-cta-inner {
    background: linear-gradient(135deg,#0c4a6e 0%,#0369a1 50%,#0ea5e9 100%);
    border-radius: var(--radius-xl);
    padding: 60px 56px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 32px;
    position: relative;
    overflow: hidden;
}
.hp-cta-inner::before {
    content:'';
    position:absolute; right:-60px; top:-60px;
    width:280px; height:280px; border-radius:50%;
    background:rgba(255,255,255,.06);
}
.hp-cta-inner::after {
    content:'';
    position:absolute; left:40px; bottom:-40px;
    width:160px; height:160px; border-radius:50%;
    background:rgba(56,189,248,.1);
}
.hp-cta-title { font-size: clamp(22px,3.5vw,36px); font-weight: 900; color: #fff; letter-spacing: -.04em; margin-bottom: 10px; }
.hp-cta-sub { font-size: 15px; color: rgba(255,255,255,.7); max-width: 480px; }
.hp-cta-actions { display: flex; gap: 12px; flex-shrink: 0; flex-wrap: wrap; position: relative; z-index: 1; }
.hp-cta-btn-primary {
    display: flex; align-items: center; gap: 8px;
    background: #fff; color: var(--primary-d);
    border-radius: 12px; padding: 14px 28px;
    font-size: 15px; font-weight: 800;
    transition: all .18s;
    box-shadow: 0 8px 24px rgba(0,0,0,.12);
}
.hp-cta-btn-primary:hover { background: #f0f9ff; transform: translateY(-2px); }
.hp-cta-btn-secondary {
    display: flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,.15);
    border: 1.5px solid rgba(255,255,255,.3);
    color: #fff; border-radius: 12px; padding: 14px 28px;
    font-size: 15px; font-weight: 700;
    transition: all .18s;
    backdrop-filter: blur(10px);
}
.hp-cta-btn-secondary:hover { background: rgba(255,255,255,.25); }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   FOOTER
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.hp-footer { background: #0c1a2e; color: rgba(255,255,255,.7); padding: 56px 0 28px; }
.hp-footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 48px; }
.hp-footer-logo { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
.hp-footer-logo img { height: 32px; }
.hp-footer-logo-name { font-size: 18px; font-weight: 900; color: #fff; }
.hp-footer-about { font-size: 14px; line-height: 1.8; }
.hp-footer-col-title { font-size: 12px; font-weight: 800; color: rgba(255,255,255,.5); letter-spacing: .08em; text-transform: uppercase; margin-bottom: 18px; }
.hp-footer-links { display: flex; flex-direction: column; gap: 10px; }
.hp-footer-links a { font-size: 14px; color: rgba(255,255,255,.6); transition: color .15s; }
.hp-footer-links a:hover { color: #38bdf8; }
.hp-footer-bottom { border-top: 1px solid rgba(255,255,255,.08); padding-top: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
.hp-footer-copy { font-size: 13px; }
.hp-footer-socials { display: flex; gap: 12px; }
.hp-footer-social {
    width: 36px; height: 36px; border-radius: 9px;
    background: rgba(255,255,255,.08);
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,.6); font-size: 15px;
    transition: all .18s;
}
.hp-footer-social:hover { background: rgba(14,165,233,.3); color: #38bdf8; }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   RESPONSIVE
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
@media (max-width: 1100px) {
    .hp-hero-grid { grid-template-columns: 1fr; }
    .hp-hero-visual { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .hp-testi-grid { grid-template-columns: 1fr 1fr; }
    .hp-footer-grid { grid-template-columns: 1fr 1fr; }
    .hp-stats-bar-inner { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 768px) {
    .hp-section { padding: 60px 0; }
    .hp-how-grid { grid-template-columns: 1fr; gap: 40px; }
    .hp-testi-grid { grid-template-columns: 1fr; }
    .hp-cta-inner { flex-direction: column; padding: 40px 28px; }
    .hp-doc-grid { grid-template-columns: repeat(auto-fill, minmax(240px,1fr)); }
    .hp-hero-visual { grid-template-columns: 1fr; }
}
@media (max-width: 560px) {
    .hp-container { padding: 0 16px; }
    .hp-spec-grid { grid-template-columns: repeat(3,1fr); }
    .hp-why-grid { grid-template-columns: 1fr; }
    .hp-footer-grid { grid-template-columns: 1fr; }
    .hp-stats-bar-inner { grid-template-columns: 1fr 1fr; }
    .hp-hero { padding: 48px 0 0; }
    .hp-hero-search { flex-wrap: wrap; }
}
</style>

<div class="main-wrapper">
@include('layouts.header')

{{-- ══════════════════════════════════════════════════
     HERO
══════════════════════════════════════════════════ --}}
<section class="hp-hero">
    <div class="hp-container">
        <div class="hp-hero-grid">

            {{-- LEFT --}}
            <div class="hp-hero-left">
                <div class="hp-hero-eyebrow">
                    <span class="hp-hero-eyebrow-dot"></span>
                    Trusted Home Physiotherapy
                </div>
                <h1 class="hp-hero-title">
                    Expert Physiotherapy<br>
                    <span>at Your Home</span>
                </h1>
                <p class="hp-hero-desc">
                    Book verified physiotherapists for personalised home care — anytime, anywhere across India.
                </p>

                {{-- Search --}}
                <div class="hp-search-box" style="position:relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="doctorSearch" class="hp-search-input" placeholder="Search doctor or specialisation…" autocomplete="off">
                    <button class="hp-search-btn" type="button">
                        <i class="fa-solid fa-arrow-right"></i> Search
                    </button>
                    <div id="hp-doctor-dropdown"></div>
                </div>

                <div class="hp-hero-hints">
                    <div class="hp-hero-hint-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        100+ Verified Experts
                    </div>
                    <div class="hp-hero-hint-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        5,000+ Happy Patients
                    </div>
                    <div class="hp-hero-hint-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        4.9★ Average Rating
                    </div>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="hp-hero-visual">
                <div class="hp-hero-card">
                    <div class="hp-hero-card-title">Upcoming Appointment</div>
                    <div class="hp-hero-doctor-row">
                        <div class="hp-hero-doc-av">N</div>
                        <div>
                            <div class="hp-hero-doc-name">Dr. Nikee Sharma</div>
                            <div class="hp-hero-doc-spec">Post Surgery · Orthopaedic</div>
                        </div>
                    </div>
                    <div class="hp-hero-slot">
                        <i class="fa-regular fa-clock" style="font-size:12px"></i>
                        Today, 3:00 PM — Confirmed
                    </div>
                </div>
                <div class="hp-hero-card">
                    <div class="hp-hero-card-title">Platform Highlights</div>
                    <div class="hp-hero-stat-row">
                        <div class="hp-hero-stat-chip">
                            <div class="hp-hero-stat-val">100+</div>
                            <div class="hp-hero-stat-lbl">Doctors</div>
                        </div>
                        <div class="hp-hero-stat-chip">
                            <div class="hp-hero-stat-val">5k+</div>
                            <div class="hp-hero-stat-lbl">Patients</div>
                        </div>
                        <div class="hp-hero-stat-chip">
                            <div class="hp-hero-stat-val">4.9★</div>
                            <div class="hp-hero-stat-lbl">Rating</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Stats bar --}}
    <div class="hp-stats-bar">
        <div class="hp-stats-bar-inner">
            <div class="hp-stat-item">
                <div class="hp-stat-icon-wrap blue"><i class="fa-solid fa-user-doctor"></i></div>
                <div><div class="hp-stat-val">100+</div><div class="hp-stat-lbl">Physiotherapists</div></div>
            </div>
            <div class="hp-stat-item">
                <div class="hp-stat-icon-wrap green"><i class="fa-solid fa-heart-pulse"></i></div>
                <div><div class="hp-stat-val">5,000+</div><div class="hp-stat-lbl">Happy Patients</div></div>
            </div>
            <div class="hp-stat-item">
                <div class="hp-stat-icon-wrap amber"><i class="fa-solid fa-star"></i></div>
                <div><div class="hp-stat-val">4.9★</div><div class="hp-stat-lbl">Average Rating</div></div>
            </div>
            <div class="hp-stat-item">
                <div class="hp-stat-icon-wrap rose"><i class="fa-solid fa-house-medical"></i></div>
                <div><div class="hp-stat-val">24×7</div><div class="hp-stat-lbl">Home Visit Support</div></div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     SPECIALISATIONS
══════════════════════════════════════════════════ --}}
<section class="hp-section hp-spec">
    <div class="hp-container">
        <div class="hp-spec-head">
            <div class="hp-badge"><span class="hp-badge-dot"></span> Browse by Category</div>
            <h2 class="hp-section-heading">Physiotherapy Specialities</h2>
            <p class="hp-section-sub center">Choose from trusted specialities and find the right expert for your recovery journey.</p>
        </div>

        <div class="hp-spec-grid">
            @foreach($specializations as $spec)
                <div class="hp-spec-card specialization-filter" data-id="{{ $spec->id }}" style="cursor:pointer">
                    <div class="hp-spec-icon-wrap">
                        <img src="{{ asset('images/specializations/'.$spec->icon) }}" alt="{{ $spec->name }}">
                    </div>
                    <div class="hp-spec-name">{{ $spec->name }}</div>
                </div>
            @endforeach

            <div class="hp-spec-card hp-spec-viewall">
                <div class="hp-spec-icon-wrap">
                    <i class="fa-solid fa-hospital-user"></i>
                </div>
                <div class="hp-spec-name">View All</div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     TOP DOCTORS
══════════════════════════════════════════════════ --}}
<section class="hp-section hp-docs">
    <div class="hp-container">
        <div class="hp-docs-head">
            <div>
                <div class="hp-badge"><span class="hp-badge-dot"></span> Our Team</div>
                <h2 class="hp-section-heading">Top Physiotherapists</h2>
                <p class="hp-section-sub">Verified, experienced specialists ready to visit your home.</p>
            </div>
            <a class="hp-view-all-link" href="#">
                View All Doctors <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="hp-doc-grid">
            @foreach($doctors as $doctor)
                @php
                    $c = $loop->iteration % 4;
                    $rating = round(optional($doctor->profile)->rating ?? 0, 1);
                    $hasImg = $doctor->profile_img;
                @endphp
                <div class="hp-doc-card c{{ $c }}">
                    <div class="hp-doc-banner">
                        <span class="hp-doc-rating"><i class="fa-solid fa-star"></i> {{ $rating }}</span>
                        @if($hasImg)
                            <img src="{{ str_contains($doctor->profile_img, '/') ? asset($doctor->profile_img) : asset('uploads/profile/'.$doctor->profile_img) }}" alt="{{ $doctor->name }}" class="hp-doc-photo">
                        @else
                            <div class="hp-doc-photo-placeholder">{{ strtoupper(substr($doctor->name,0,1)) }}</div>
                        @endif
                    </div>
                    <div class="hp-doc-body">
                        <div class="hp-doc-name">
                            <a href="{{ route('doctor.profile', $doctor->id) }}">{{ $doctor->name }}</a>
                            <i class="fa-solid fa-circle-check hp-doc-verified"></i>
                        </div>
                        <p class="hp-doc-spec c{{ $c }}">
                            {{ optional($doctor->profile)->qualification }}
                            @if(optional(optional($doctor->profile)->specializationdata)->name)
                                &middot; {{ optional($doctor->profile)->specializationdata->name }}
                            @endif
                        </p>
                        <ul class="hp-doc-meta">
                            <li>
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $doctor->address ?? optional($doctor->profile)->clinic_address ?? 'India' }}
                            </li>
                            <li>
                                <i class="fa-regular fa-clock"></i>
                                {{ optional($doctor->profile)->experience_years ?? 0 }} Years Experience
                            </li>
                        </ul>
                        <div class="hp-doc-actions">
                            <a href="{{ route('doctor.profile', $doctor->id) }}" class="hp-doc-btn-profile">Profile</a>
                            @auth
                                <a href="{{ route('doctor.booking', $doctor->id) }}" class="hp-doc-btn-book c{{ $c }}">Book Now</a>
                            @else
                                <a href="{{ route('login') }}" class="hp-doc-btn-book c{{ $c }}">Book Now</a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     HOW IT WORKS + WHY CHOOSE US (2-col)
══════════════════════════════════════════════════ --}}
<section class="hp-section hp-how">
    <div class="hp-container">
        <div class="hp-how-grid">

            {{-- HOW IT WORKS --}}
            <div>
                <div class="hp-badge"><span class="hp-badge-dot"></span> Simple Process</div>
                <h2 class="hp-section-heading" style="margin-bottom:8px">How It Works</h2>
                <p class="hp-section-sub" style="margin-bottom:36px">Get expert physiotherapy at home in 3 easy steps.</p>
                <div class="hp-step-list">
                    <div class="hp-step">
                        <div class="hp-step-left"><div class="hp-step-num">1</div><div class="hp-step-connector"></div></div>
                        <div class="hp-step-body">
                            <div class="hp-step-title">Search &amp; Select</div>
                            <div class="hp-step-desc">Find the right specialist by speciality, location, or doctor name using our smart search.</div>
                        </div>
                    </div>
                    <div class="hp-step">
                        <div class="hp-step-left"><div class="hp-step-num">2</div><div class="hp-step-connector"></div></div>
                        <div class="hp-step-body">
                            <div class="hp-step-title">Pick a Slot</div>
                            <div class="hp-step-desc">Choose your preferred date, time, and home address for the visit.</div>
                        </div>
                    </div>
                    <div class="hp-step">
                        <div class="hp-step-left"><div class="hp-step-num">3</div><div class="hp-step-connector"></div></div>
                        <div class="hp-step-body">
                            <div class="hp-step-title">Confirm &amp; Relax</div>
                            <div class="hp-step-desc">Confirm your booking — a verified therapist arrives at your door, ready to help.</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- WHY CHOOSE US --}}
            <div>
                <div class="hp-badge"><span class="hp-badge-dot"></span> Our Advantages</div>
                <h2 class="hp-section-heading" style="margin-bottom:8px">Why Choose Physiopii?</h2>
                <p class="hp-section-sub" style="margin-bottom:36px">Expert physiotherapy at your doorstep — professional, convenient, trusted.</p>
                <div class="hp-why-grid">
                    <div class="hp-why-card blue">
                        <div class="hp-why-icon"><i class="fa-solid fa-user-check"></i></div>
                        <div class="hp-why-title">Certified Experts</div>
                        <div class="hp-why-desc">All physiotherapists are verified, licensed and experienced professionals.</div>
                    </div>
                    <div class="hp-why-card green">
                        <div class="hp-why-icon"><i class="fa-solid fa-house-chimney-medical"></i></div>
                        <div class="hp-why-title">Home Visits</div>
                        <div class="hp-why-desc">Comfortable care at your doorstep — no travel, no stress, just recovery.</div>
                    </div>
                    <div class="hp-why-card purple">
                        <div class="hp-why-icon"><i class="fa-solid fa-heart-pulse"></i></div>
                        <div class="hp-why-title">Personalised Care</div>
                        <div class="hp-why-desc">Recovery plans designed specifically for your condition and goals.</div>
                    </div>
                    <div class="hp-why-card amber">
                        <div class="hp-why-icon"><i class="fa-solid fa-bolt"></i></div>
                        <div class="hp-why-title">Instant Booking</div>
                        <div class="hp-why-desc">Book appointments online in under 2 minutes, anytime, anywhere.</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     TESTIMONIALS
══════════════════════════════════════════════════ --}}
<section class="hp-section hp-testi">
    <div class="hp-container">
        <div class="hp-testi-head">
            <div class="hp-badge" style="justify-content:center;display:inline-flex"><span class="hp-badge-dot"></span> Patient Stories</div>
            <h2 class="hp-section-heading" style="text-align:center;margin-top:4px">What Our Patients Say</h2>
            <p class="hp-section-sub center">Trusted by thousands of patients across India.</p>
        </div>
        <div class="hp-testi-grid">
            <div class="hp-testi-card featured">
                <div class="hp-testi-quote">"</div>
                <div class="hp-testi-stars">★★★★★</div>
                <p class="hp-testi-text">Physiopii made my recovery so smooth. The therapist was punctual, professional, and genuinely caring. I didn't have to leave my home once!</p>
                <div class="hp-testi-author">
                    <div class="hp-testi-av av-teal">R</div>
                    <div>
                        <div class="hp-testi-name">Rahul Mehta</div>
                        <div class="hp-testi-role">Post Surgery · Mumbai</div>
                    </div>
                </div>
            </div>
            <div class="hp-testi-card">
                <div class="hp-testi-quote">"</div>
                <div class="hp-testi-stars">★★★★★</div>
                <p class="hp-testi-text">Excellent service! The physiotherapist was highly knowledgeable and gave a personalised plan that really worked for my knee pain after surgery.</p>
                <div class="hp-testi-author">
                    <div class="hp-testi-av av-purple">S</div>
                    <div>
                        <div class="hp-testi-name">Sneha Patel</div>
                        <div class="hp-testi-role">Orthopaedic · Ahmedabad</div>
                    </div>
                </div>
            </div>
            <div class="hp-testi-card">
                <div class="hp-testi-quote">"</div>
                <div class="hp-testi-stars">★★★★★</div>
                <p class="hp-testi-text">Booking was so easy and the doctor arrived on time. My father has seen great improvement in mobility. Highly recommend Physiopii to everyone!</p>
                <div class="hp-testi-author">
                    <div class="hp-testi-av av-green">A</div>
                    <div>
                        <div class="hp-testi-name">Amit Sharma</div>
                        <div class="hp-testi-role">Geriatric · Delhi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     CTA BANNER
══════════════════════════════════════════════════ --}}
<section class="hp-cta">
    <div class="hp-container">
        <div class="hp-cta-inner">
            <div style="position:relative;z-index:1">
                <h2 class="hp-cta-title">Ready to book your first session?</h2>
                <p class="hp-cta-sub">Join thousands of patients who trust Physiopii for world-class physiotherapy at home.</p>
            </div>
            <div class="hp-cta-actions">
                <a href="{{ route('patient.register') }}" class="hp-cta-btn-primary">
                    <i class="fa-solid fa-calendar-check"></i> Book Now — It's Free
                </a>
                <a href="{{ route('login') }}" class="hp-cta-btn-secondary">
                    <i class="fa-solid fa-right-to-bracket"></i> Sign In
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     FOOTER
══════════════════════════════════════════════════ --}}
<footer class="hp-footer">
    <div class="hp-container">
        <div class="hp-footer-grid">
            <div>
                <div class="hp-footer-logo">
                    <img src="{{ asset('logo.png') }}" alt="Physiopii">
                    <span class="hp-footer-logo-name">Physiopii</span>
                </div>
                <p class="hp-footer-about">Expert physiotherapy at your doorstep. We connect patients with verified physiotherapists for convenient home-visit care across India.</p>
            </div>
            <div>
                <div class="hp-footer-col-title">For Patients</div>
                <div class="hp-footer-links">
                    <a href="#">Search Doctors</a>
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('patient.register') }}">Register</a>
                    <a href="#">Patient Dashboard</a>
                </div>
            </div>
            <div>
                <div class="hp-footer-col-title">Company</div>
                <div class="hp-footer-links">
                    <a href="#">About Us</a>
                    <a href="#">How It Works</a>
                    <a href="#">Specialities</a>
                    <a href="#">Contact</a>
                </div>
            </div>
            <div>
                <div class="hp-footer-col-title">Contact</div>
                <div class="hp-footer-links">
                    <a href="tel:+13153695943"><i class="fa-solid fa-phone" style="margin-right:6px"></i>+1 315 369 5943</a>
                    <a href="mailto:info@physiopii.com"><i class="fa-solid fa-envelope" style="margin-right:6px"></i>info@physiopii.com</a>
                    <a href="#"><i class="fa-solid fa-location-dot" style="margin-right:6px"></i>India</a>
                </div>
            </div>
        </div>
        <div class="hp-footer-bottom">
            <div class="hp-footer-copy">© {{ date('Y') }} Physiopii. All rights reserved.</div>
            <div class="hp-footer-socials">
                <a href="#" class="hp-footer-social"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hp-footer-social"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hp-footer-social"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hp-footer-social"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
</footer>

</div>{{-- /main-wrapper --}}

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