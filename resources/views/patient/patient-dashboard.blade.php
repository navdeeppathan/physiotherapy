@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
/* ─────────────────────────────────────────────
   RESET & TOKENS
───────────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
    --primary:   #0ea5e9;
    --primary-d: #0284c7;
    --primary-l: #e0f2fe;
    --ink:       #0f172a;
    --body-c:    #334155;
    --muted:     #64748b;
    --border:    #e2e8f0;
    --bg:        #f1f5f9;
    --white:     #fff;
    --r-xl:      20px;
    --r-lg:      14px;
    --r:         10px;
    --shadow:    0 2px 16px rgba(0,0,0,.06);
}
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--body-c); }
a { text-decoration: none; color: inherit; }
ul { list-style: none; }

/* ─────────────────────────────────────────────
   PAGE SHELL
───────────────────────────────────────────── */
.pd-page { min-height: 100vh; display: flex; flex-direction: column; }

/* ─────────────────────────────────────────────
   MOBILE HEADER BAR (only visible < 768px)
───────────────────────────────────────────── */
.pd-mobile-topbar {
    display: none;
    background: linear-gradient(135deg, #0c4a6e, #0284c7);
    padding: 14px 16px;
    align-items: center;
    justify-content: space-between;
    position: sticky; top: 68px; z-index: 200;
}
.pd-mobile-user { display: flex; align-items: center; gap: 10px; }
.pd-mobile-avatar {
    width: 38px; height: 38px; border-radius: 50%;
    border: 2px solid rgba(255,255,255,.5);
    object-fit: cover;
}
.pd-mobile-avatar-ph {
    width: 38px; height: 38px; border-radius: 50%;
    background: rgba(255,255,255,.2);
    color: #fff; font-weight: 800; font-size: 14px;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid rgba(255,255,255,.4);
}
.pd-mobile-name { font-size: 14px; font-weight: 700; color: #fff; }
.pd-mobile-role { font-size: 11px; color: rgba(255,255,255,.6); }
.pd-menu-toggle {
    background: rgba(255,255,255,.15);
    border: none; border-radius: 9px;
    width: 38px; height: 38px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; cursor: pointer; font-size: 18px;
    transition: background .18s;
}
.pd-menu-toggle:hover { background: rgba(255,255,255,.25); }

/* ─────────────────────────────────────────────
   MOBILE SIDEBAR DRAWER
───────────────────────────────────────────── */
.pd-drawer-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    z-index: 9998;
    backdrop-filter: blur(2px);
}
.pd-drawer {
    position: fixed; top: 0; left: -300px;
    width: 280px; height: 100vh;
    background: var(--white);
    z-index: 9999;
    transition: left .28s cubic-bezier(.4,0,.2,1);
    overflow-y: auto;
    box-shadow: 4px 0 40px rgba(0,0,0,.18);
    display: flex; flex-direction: column;
}
.pd-drawer.open { left: 0; }
.pd-drawer-overlay.open { display: block; }

.pd-drawer-profile {
    background: linear-gradient(135deg, #0c4a6e, #0284c7);
    padding: 28px 20px 22px;
    position: relative;
}
.pd-drawer-close {
    position: absolute; top: 14px; right: 14px;
    background: rgba(255,255,255,.18); border: none;
    width: 30px; height: 30px; border-radius: 50%;
    color: #fff; font-size: 16px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
}
.pd-drawer-avatar {
    width: 68px; height: 68px; border-radius: 50%;
    border: 3px solid rgba(255,255,255,.5);
    object-fit: cover; margin-bottom: 12px;
}
.pd-drawer-avatar-ph {
    width: 68px; height: 68px; border-radius: 50%;
    background: rgba(255,255,255,.2);
    border: 3px solid rgba(255,255,255,.4);
    color: #fff; font-size: 24px; font-weight: 900;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 12px;
}
.pd-drawer-name { font-size: 17px; font-weight: 800; color: #fff; }
.pd-drawer-meta { font-size: 12px; color: rgba(255,255,255,.65); margin-top: 4px; }

.pd-drawer-nav { padding: 12px; flex: 1; }
.pd-drawer-nav-item {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 14px; border-radius: 11px;
    font-size: 14.5px; font-weight: 600; color: #475569;
    transition: all .15s; cursor: pointer;
    margin-bottom: 2px;
}
.pd-drawer-nav-item:hover { background: var(--primary-l); color: var(--primary); }
.pd-drawer-nav-item.active { background: linear-gradient(135deg,var(--primary),#38bdf8); color: #fff; }
.pd-drawer-nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
.pd-drawer-divider { height: 1px; background: var(--border); margin: 8px 0; }
.pd-drawer-logout-btn {
    width: 100%; display: flex; align-items: center; gap: 12px;
    padding: 12px 14px; border-radius: 11px;
    font-size: 14.5px; font-weight: 600; color: #ef4444;
    background: transparent; border: none; cursor: pointer;
    transition: all .15s; font-family: 'Plus Jakarta Sans', sans-serif;
    text-align: left;
}
.pd-drawer-logout-btn:hover { background: #fef2f2; color: #dc2626; }
.pd-drawer-logout-btn svg { width: 18px; height: 18px; }

/* ─────────────────────────────────────────────
   DESKTOP LAYOUT
───────────────────────────────────────────── */
.pd-body {
    max-width: 1320px;
    margin: 0 auto;
    padding: 28px 20px 48px;
    width: 100%;
    display: grid;
    grid-template-columns: 268px 1fr;
    gap: 22px;
    align-items: start;
}

/* ─────────────────────────────────────────────
   DESKTOP SIDEBAR
───────────────────────────────────────────── */
.pd-sidebar {
    position: sticky; top: 88px;
    display: flex; flex-direction: column; gap: 14px;
}

.pd-profile-card {
    background: linear-gradient(160deg, #0c4a6e, #0284c7);
    border-radius: var(--r-xl); padding: 26px 20px;
    color: #fff; position: relative; overflow: hidden;
    box-shadow: 0 14px 40px rgba(2,132,199,.28);
}
.pd-profile-card::before {
    content:''; position:absolute; right:-30px; top:-30px;
    width:140px; height:140px; border-radius:50%;
    background: rgba(255,255,255,.07);
}
.pd-avatar {
    width: 72px; height: 72px; border-radius: 50%;
    border: 3px solid rgba(255,255,255,.45);
    object-fit: cover; margin-bottom: 14px;
    position: relative; z-index: 1;
}
.pd-avatar-ph {
    width: 72px; height: 72px; border-radius: 50%;
    border: 3px solid rgba(255,255,255,.45);
    background: rgba(255,255,255,.2);
    color: #fff; font-size: 22px; font-weight: 900;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 14px; position: relative; z-index: 1;
}
.pd-profile-name { font-size: 17px; font-weight: 800; letter-spacing: -.02em; position:relative;z-index:1; }
.pd-profile-meta { display:flex; flex-direction:column; gap:5px; margin-top:10px; position:relative;z-index:1; }
.pd-profile-meta-item { display:flex; align-items:center; gap:7px; font-size:12px; color:rgba(255,255,255,.7); }
.pd-profile-meta-item svg { width:12px; height:12px; color:rgba(255,255,255,.5); flex-shrink:0; }

.pd-nav-card {
    background: var(--white); border-radius: var(--r-xl);
    padding: 8px; box-shadow: var(--shadow); border: 1px solid var(--border);
}
.pd-nav-item {
    display: flex; align-items: center; gap: 11px;
    padding: 10px 13px; border-radius: var(--r-lg);
    font-size: 13.5px; font-weight: 600; color: #64748b;
    transition: all .15s; cursor: pointer;
    text-decoration: none;
}
.pd-nav-item:hover { background: var(--primary-l); color: var(--primary); }
.pd-nav-item.active { background: linear-gradient(135deg,var(--primary),#38bdf8); color:#fff; box-shadow: 0 4px 12px rgba(14,165,233,.3); }
.pd-nav-item svg { width: 16px; height: 16px; flex-shrink: 0; }
.pd-nav-divider { height: 1px; background: #f1f5f9; margin: 5px 0; }
.pd-logout-form { width: 100%; }
.pd-logout-btn {
    width: 100%; display: flex; align-items: center; gap: 11px;
    padding: 10px 13px; border-radius: var(--r-lg);
    font-size: 13.5px; font-weight: 600; color: #ef4444;
    background: transparent; border: none; cursor: pointer;
    transition: all .15s; font-family: 'Plus Jakarta Sans', sans-serif;
}
.pd-logout-btn:hover { background: #fef2f2; color: #dc2626; }
.pd-logout-btn svg { width: 16px; height: 16px; }

/* ─────────────────────────────────────────────
   MAIN CONTENT
───────────────────────────────────────────── */
.pd-main { display: flex; flex-direction: column; gap: 18px; }

/* Page header */
.pd-page-header {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 10px;
}
.pd-page-title { font-size: 21px; font-weight: 900; color: var(--ink); letter-spacing: -.04em; }
.pd-page-sub { font-size: 13px; color: var(--muted); margin-top: 2px; }
.pd-date-chip {
    display: flex; align-items: center; gap: 6px;
    background: var(--white); border: 1px solid var(--border);
    border-radius: 9px; padding: 7px 13px;
    font-size: 12px; font-weight: 600; color: #475569;
}
.pd-date-chip svg { width: 13px; height: 13px; }

/* Stats */
.pd-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
.pd-stat {
    background: var(--white); border-radius: var(--r-xl);
    padding: 18px 16px; border: 1.5px solid var(--border);
    display: flex; align-items: center; gap: 14px;
    transition: all .18s; position: relative; overflow: hidden;
}
.pd-stat::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; border-radius:20px 20px 0 0; }
.pd-stat.blue::before  { background: linear-gradient(90deg,#0ea5e9,#38bdf8); }
.pd-stat.green::before { background: linear-gradient(90deg,#10b981,#34d399); }
.pd-stat.amber::before { background: linear-gradient(90deg,#f59e0b,#fbbf24); }
.pd-stat:hover { box-shadow: 0 8px 24px rgba(0,0,0,.08); transform: translateY(-2px); }
.pd-stat-icon { width: 44px; height: 44px; border-radius: 12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.pd-stat-icon.blue  { background:#e0f2fe; color:#0ea5e9; }
.pd-stat-icon.green { background:#d1fae5; color:#10b981; }
.pd-stat-icon.amber { background:#fef3c7; color:#f59e0b; }
.pd-stat-icon svg { width: 19px; height: 19px; }
.pd-stat-val { font-size: 24px; font-weight: 900; color: var(--ink); letter-spacing: -.04em; line-height: 1; }
.pd-stat-lbl { font-size: 12px; color: var(--muted); margin-top: 3px; }

/* Tab card */
.pd-card { background: var(--white); border-radius: var(--r-xl); border: 1.5px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
.pd-tabs {
    display: flex; border-bottom: 1px solid #f1f5f9;
    padding: 14px 16px 0; gap: 2px;
    overflow-x: auto; scrollbar-width: none; -webkit-overflow-scrolling: touch;
}
.pd-tabs::-webkit-scrollbar { display: none; }
.pd-tab {
    padding: 8px 14px; border-radius: 9px 9px 0 0;
    font-size: 13px; font-weight: 600; color: #94a3b8;
    cursor: pointer; border: none; background: transparent;
    transition: all .15s; white-space: nowrap;
    border-bottom: 2px solid transparent; margin-bottom: -1px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.pd-tab:hover { color: #475569; background: #f8fafc; }
.pd-tab.active { color: var(--primary); border-bottom-color: var(--primary); background: #f0f9ff; font-weight: 700; }

.pd-tab-content { display: none; }
.pd-tab-content.active { display: block; }

/* ─────────────────────────────────────────────
   TABLE (Desktop)
───────────────────────────────────────────── */
.pd-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
table.pd-table { width: 100%; border-collapse: collapse; font-size: 13px; }
table.pd-table th {
    padding: 10px 16px; text-align: left;
    font-size: 10.5px; font-weight: 700; color: #94a3b8;
    text-transform: uppercase; letter-spacing: .06em;
    background: #f8fafc; border-bottom: 1px solid #f1f5f9;
    white-space: nowrap;
}
table.pd-table td {
    padding: 13px 16px; color: var(--body-c);
    border-bottom: 1px solid #f8fafc; vertical-align: middle;
}
table.pd-table tr:last-child td { border-bottom: none; }
table.pd-table tr:hover td { background: #fafbff; }

.pd-doc-cell { display: flex; align-items: center; gap: 10px; }
.pd-doc-img { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #e0f2fe; flex-shrink: 0; }
.pd-doc-ph { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg,#0ea5e9,#38bdf8); color:#fff; font-size:12px; font-weight:800; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.pd-doc-name { font-weight: 700; color: var(--ink); font-size: 13px; }
.pd-doc-spec { font-size: 11px; color: #94a3b8; margin-top: 1px; }
.pd-date-main { font-weight: 600; color: var(--ink); font-size: 13px; }
.pd-date-time { font-size: 11.5px; color: var(--primary); margin-top: 1px; }

/* Status pills */
.pd-pill { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:700; }
.pd-pill-dot { width:5px; height:5px; border-radius:50%; }
.pd-pill.confirmed { background:#e0f2fe; color:#0369a1; } .pd-pill.confirmed .pd-pill-dot { background:#0ea5e9; }
.pd-pill.pending   { background:#fef3c7; color:#92400e; } .pd-pill.pending .pd-pill-dot { background:#f59e0b; }
.pd-pill.completed { background:#d1fae5; color:#065f46; } .pd-pill.completed .pd-pill-dot { background:#10b981; }
.pd-pill.cancelled { background:#fee2e2; color:#991b1b; } .pd-pill.cancelled .pd-pill-dot { background:#ef4444; }
.pd-pill.shifted   { background:#f3e8ff; color:#6b21a8; } .pd-pill.shifted .pd-pill-dot { background:#a855f7; }
.pd-pill.success   { background:#d1fae5; color:#065f46; } .pd-pill.success .pd-pill-dot { background:#10b981; }
.pd-pill.failed    { background:#fee2e2; color:#991b1b; } .pd-pill.failed .pd-pill-dot { background:#ef4444; }

.pd-view-btn { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; background:var(--primary-l); color:var(--primary); border-radius:8px; font-size:12px; font-weight:700; border:1px solid #bae6fd; transition:all .15s; white-space:nowrap; }
.pd-view-btn:hover { background:#e0f2fe; border-color:#7dd3fc; }
.pd-view-btn svg { width:12px; height:12px; }
.pd-inv { font-size:11.5px; font-weight:700; color:#94a3b8; font-family:monospace; background:#f1f5f9; padding:2px 7px; border-radius:5px; }

/* Empty state */
.pd-empty { text-align:center; padding:36px 16px; color:#94a3b8; }
.pd-empty svg { width:44px; height:44px; color:#cbd5e1; margin-bottom:10px; }
.pd-empty-title { font-size:14px; font-weight:700; color:#64748b; margin-bottom:3px; }
.pd-empty-sub { font-size:12.5px; }

/* Billing stats */
.pd-billing-stats { display:grid; grid-template-columns:1fr 1fr; gap:12px; padding:16px; }
.pd-billing-stat { background:#f8fafc; border:1px solid var(--border); border-radius:13px; padding:16px 18px; display:flex; align-items:center; gap:12px; }
.pd-billing-stat-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.pd-billing-stat-icon.green { background:#d1fae5; color:#10b981; }
.pd-billing-stat-icon.blue  { background:#e0f2fe; color:#0ea5e9; }
.pd-billing-stat-icon svg { width:17px; height:17px; }
.pd-billing-stat-val { font-size:20px; font-weight:900; color:var(--ink); letter-spacing:-.04em; }
.pd-billing-stat-lbl { font-size:11.5px; color:var(--muted); margin-top:2px; }

/* ─────────────────────────────────────────────
   MOBILE CARD VIEW (replaces table on small screens)
───────────────────────────────────────────── */
.pd-card-list { display: none; flex-direction: column; gap: 0; }
.pd-appt-card {
    padding: 14px 16px;
    border-bottom: 1px solid #f1f5f9;
    display: flex; flex-direction: column; gap: 10px;
}
.pd-appt-card:last-child { border-bottom: none; }

.pd-appt-card-top { display: flex; align-items: center; gap: 12px; }
.pd-appt-card-info { flex: 1; min-width: 0; }
.pd-appt-card-name { font-size: 14px; font-weight: 800; color: var(--ink); }
.pd-appt-card-spec { font-size: 12px; color: #94a3b8; margin-top: 2px; }

.pd-appt-card-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.pd-appt-card-field { background: #f8fafc; border-radius: 9px; padding: 8px 10px; }
.pd-appt-card-field-lbl { font-size: 10.5px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 3px; }
.pd-appt-card-field-val { font-size: 13px; font-weight: 600; color: var(--ink); }

.pd-appt-card-actions { display: flex; align-items: center; justify-content: space-between; }

/* Billing mobile card */
.pd-bill-card {
    padding: 14px 16px; border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; gap: 12px;
}
.pd-bill-card:last-child { border-bottom: none; }
.pd-bill-card-right { margin-left: auto; text-align: right; }
.pd-bill-amount { font-size: 15px; font-weight: 900; color: var(--ink); }
.pd-bill-date { font-size: 11.5px; color: var(--muted); margin-top: 2px; }

/* ─────────────────────────────────────────────
   RESPONSIVE BREAKPOINTS
───────────────────────────────────────────── */
@media (max-width: 1024px) {
    .pd-body { grid-template-columns: 240px 1fr; gap: 16px; }
}

@media (max-width: 768px) {
    /* Show mobile topbar, hide desktop sidebar */
    .pd-mobile-topbar { display: flex; }
    .pd-sidebar { display: none; }

    .pd-body {
        grid-template-columns: 1fr;
        padding: 12px 12px 40px;
        gap: 12px;
    }

    /* Stats: 3-column row on mobile */
    .pd-stats { grid-template-columns: repeat(3,1fr); gap: 8px; }
    .pd-stat { padding: 13px 10px; flex-direction: column; align-items: flex-start; gap: 8px; }
    .pd-stat-icon { width: 36px; height: 36px; border-radius: 10px; }
    .pd-stat-icon svg { width: 16px; height: 16px; }
    .pd-stat-val { font-size: 20px; }
    .pd-stat-lbl { font-size: 11px; }

    /* Page header */
    .pd-page-title { font-size: 18px; }
    .pd-date-chip { display: none; }

    /* Tabs: scrollable */
    .pd-tabs { padding: 12px 12px 0; }
    .pd-tab { font-size: 12.5px; padding: 7px 11px; }

    /* Hide table, show card list */
    .pd-table-wrap { display: none; }
    .pd-card-list { display: flex; }

    /* Billing stats: stack */
    .pd-billing-stats { grid-template-columns: 1fr 1fr; padding: 12px; gap: 8px; }
    .pd-billing-stat { padding: 12px 14px; }
    .pd-billing-stat-val { font-size: 17px; }
}

@media (max-width: 480px) {
    .pd-stats { grid-template-columns: repeat(3,1fr); gap: 6px; }
    .pd-stat { padding: 11px 8px; }
    .pd-stat-val { font-size: 18px; }
    .pd-stat-lbl { font-size: 10.5px; }
    .pd-billing-stats { grid-template-columns: 1fr; }
    .pd-appt-card-meta { grid-template-columns: 1fr 1fr; }
    .pd-body { padding: 10px 10px 36px; }
}
</style>

<div class="pd-page">

    @include('layouts.header')

    {{-- ── MOBILE TOP BAR ── --}}
    <div class="pd-mobile-topbar">
        <div class="pd-mobile-user">
            @if($patient->profile_img)
                <img src="{{ str_contains($patient->profile_img, '/') ? asset($patient->profile_img) : asset('uploads/profile/'.$patient->profile_img) }}" class="pd-mobile-avatar" alt="{{ Auth::user()->name }}">
            @else
                <div class="pd-mobile-avatar-ph">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
            @endif
            <div>
                <div class="pd-mobile-name">{{ Auth::user()->name }}</div>
                <div class="pd-mobile-role">Patient</div>
            </div>
        </div>
        <button class="pd-menu-toggle" id="pdMenuToggle" aria-label="Open menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>

    {{-- ── MOBILE DRAWER OVERLAY ── --}}
    <div class="pd-drawer-overlay" id="pdDrawerOverlay"></div>

    {{-- ── MOBILE DRAWER ── --}}
    <div class="pd-drawer" id="pdDrawer">
        <div class="pd-drawer-profile">
            <button class="pd-drawer-close" id="pdDrawerClose">&times;</button>
            @if($patient->profile_img)
                <img src="{{ str_contains($patient->profile_img, '/') ? asset($patient->profile_img) : asset('uploads/profile/'.$patient->profile_img) }}" class="pd-drawer-avatar" alt="{{ Auth::user()->name }}">
            @else
                <div class="pd-drawer-avatar-ph">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
            @endif
            <div class="pd-drawer-name">{{ Auth::user()->name }}</div>
            <div class="pd-drawer-meta">
                @if(Auth::user()->dob)
                    {{ \Carbon\Carbon::parse(Auth::user()->dob)->format('d M Y') }} &middot; {{ \Carbon\Carbon::parse(Auth::user()->dob)->age }}y
                @endif
            </div>
        </div>
        <nav class="pd-drawer-nav">
            <a href="{{ route('patient.dashboard') }}" class="pd-drawer-nav-item active">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="{{ route('patient.profile') }}" class="pd-drawer-nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Profile Settings
            </a>
            <a href="{{ route('patient.change.password') }}" class="pd-drawer-nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 11V7a5 5 0 0110 0v4"/></svg>
                Change Password
            </a>
            <div class="pd-drawer-divider"></div>
            <form action="{{ route('patient.logout') }}" method="GET">
                @csrf
                <button type="submit" class="pd-drawer-logout-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </nav>
    </div>

    {{-- ── MAIN GRID ── --}}
    <div class="pd-body">

        {{-- Desktop Sidebar --}}
        <aside class="pd-sidebar">
            <div class="pd-profile-card">
                @if($patient->profile_img)
                    <img src="{{ str_contains($patient->profile_img, '/') ? asset($patient->profile_img) : asset('uploads/profile/'.$patient->profile_img) }}" class="pd-avatar" alt="{{ Auth::user()->name }}">
                @else
                    <div class="pd-avatar-ph">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
                @endif
                <div class="pd-profile-name">{{ Auth::user()->name }}</div>
                <div class="pd-profile-meta">
                    @if(Auth::user()->dob)
                    <div class="pd-profile-meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ \Carbon\Carbon::parse(Auth::user()->dob)->format('d M Y') }} &middot; {{ \Carbon\Carbon::parse(Auth::user()->dob)->age }}y
                    </div>
                    @endif
                    @if(Auth::user()->city)
                    <div class="pd-profile-meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ Auth::user()->city }}{{ Auth::user()->state ? ', '.Auth::user()->state : '' }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="pd-nav-card">
                <a href="{{ route('patient.dashboard') }}" class="pd-nav-item active">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('patient.profile') }}" class="pd-nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Profile Settings
                </a>
                <a href="{{ route('patient.change.password') }}" class="pd-nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    Change Password
                </a>
                <div class="pd-nav-divider"></div>
                <form action="{{ route('patient.logout') }}" method="GET" class="pd-logout-form">
                    @csrf
                    <button type="submit" class="pd-logout-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <main class="pd-main">

            <div class="pd-page-header">
                <div>
                    <div class="pd-page-title">My Dashboard</div>
                    <div class="pd-page-sub">Track your appointments and health journey</div>
                </div>
                <div class="pd-date-chip">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ \Carbon\Carbon::now()->format('D, d M Y') }}
                </div>
            </div>

            {{-- Stats --}}
            <div class="pd-stats">
                <div class="pd-stat blue">
                    <div class="pd-stat-icon blue">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div>
                        <div class="pd-stat-val">{{ $appointments->count() }}</div>
                        <div class="pd-stat-lbl">Total Appts</div>
                    </div>
                </div>
                <div class="pd-stat green">
                    <div class="pd-stat-icon green">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="pd-stat-val">{{ $completedAppointments->count() }}</div>
                        <div class="pd-stat-lbl">Completed</div>
                    </div>
                </div>
                <div class="pd-stat amber">
                    <div class="pd-stat-icon amber">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="pd-stat-val">{{ $upcomingAppointments->count() }}</div>
                        <div class="pd-stat-lbl">Upcoming</div>
                    </div>
                </div>
            </div>

            {{-- Tab Card --}}
            <div class="pd-card">
                <div class="pd-tabs">
                    <button class="pd-tab active" onclick="switchTab('all',this)">All</button>
                    <button class="pd-tab" onclick="switchTab('upcoming',this)">Upcoming</button>
                    <button class="pd-tab" onclick="switchTab('completed',this)">Completed</button>
                    <button class="pd-tab" onclick="switchTab('shifted',this)">Shifted</button>
                    <button class="pd-tab" onclick="switchTab('cancelled',this)">Cancelled</button>
                    <button class="pd-tab" onclick="switchTab('billing',this)">Billing</button>
                </div>

                @php
                function buildRow($a) {
                    return [
                        'id'       => $a->id,
                        'imgSrc'   => $a->doctor->profile_img ? (str_contains($a->doctor->profile_img, '/') ? asset($a->doctor->profile_img) : asset('uploads/profile/'.$a->doctor->profile_img)) : null,
                        'docName'  => $a->doctor->name ?? '—',
                        'spec'     => optional($a->doctor->profile->specializationdata)->name ?? 'Doctor',
                        'date'     => $a->appointment_date->format('d M Y'),
                        'time'     => \Carbon\Carbon::parse($a->start_time)->format('h:i A'),
                        'booked'   => $a->created_at->format('d M Y'),
                        'fee'      => '₹'.number_format($a->doctor->fee->doctor_fee ?? 0, 2),
                        'followUp' => $a->appointment_date->isFuture() ? $a->appointment_date->copy()->addDays(7)->format('d M Y') : '—',
                        'status'   => $a->status,
                    ];
                }
                @endphp

                @foreach(['all'=>$appointments,'upcoming'=>$upcomingAppointments,'completed'=>$completedAppointments,'shifted'=>$shiftedAppointments,'cancelled'=>$cancelledAppointments] as $tabId => $collection)
                <div class="pd-tab-content {{ $tabId==='all' ? 'active' : '' }}" id="tab-{{ $tabId }}">

                    {{-- Desktop table --}}
                    <div class="pd-table-wrap">
                        <table class="pd-table">
                            <thead><tr>
                                <th>Doctor</th><th>Appt Date</th><th>Booked</th>
                                <th>Amount</th><th>Follow Up</th><th>Status</th><th></th>
                            </tr></thead>
                            <tbody>
                                @forelse($collection as $appt)
                                    @php $r = buildRow($appt); @endphp
                                    <tr>
                                        <td>
                                            <div class="pd-doc-cell">
                                                @if($r['imgSrc']) <img class="pd-doc-img" src="{{ $r['imgSrc'] }}" alt="Dr. {{ $r['docName'] }}">
                                                @else <div class="pd-doc-ph">{{ strtoupper(substr($r['docName'],0,2)) }}</div> @endif
                                                <div>
                                                    <div class="pd-doc-name">Dr. {{ $r['docName'] }}</div>
                                                    <div class="pd-doc-spec">{{ $r['spec'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><div class="pd-date-main">{{ $r['date'] }}</div><div class="pd-date-time">{{ $r['time'] }}</div></td>
                                        <td style="color:#64748b;font-size:12.5px">{{ $r['booked'] }}</td>
                                        <td style="font-weight:700;color:#0f172a">{{ $r['fee'] }}</td>
                                        <td style="color:#64748b;font-size:12.5px">{{ $r['followUp'] }}</td>
                                        <td><span class="pd-pill {{ $r['status'] }}"><span class="pd-pill-dot"></span>{{ ucfirst($r['status']) }}</span></td>
                                        <td><a href="{{ route('patient.appointments.show',$appt->id) }}" class="pd-view-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>View</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7"><div class="pd-empty"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><div class="pd-empty-title">No appointments</div><div class="pd-empty-sub">Nothing to show here yet.</div></div></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile card list --}}
                    <div class="pd-card-list">
                        @forelse($collection as $appt)
                            @php $r = buildRow($appt); @endphp
                            <div class="pd-appt-card">
                                <div class="pd-appt-card-top">
                                    @if($r['imgSrc']) <img class="pd-doc-img" src="{{ $r['imgSrc'] }}" alt="Dr. {{ $r['docName'] }}">
                                    @else <div class="pd-doc-ph">{{ strtoupper(substr($r['docName'],0,2)) }}</div> @endif
                                    <div class="pd-appt-card-info">
                                        <div class="pd-appt-card-name">Dr. {{ $r['docName'] }}</div>
                                        <div class="pd-appt-card-spec">{{ $r['spec'] }}</div>
                                    </div>
                                    <span class="pd-pill {{ $r['status'] }}" style="flex-shrink:0"><span class="pd-pill-dot"></span>{{ ucfirst($r['status']) }}</span>
                                </div>
                                <div class="pd-appt-card-meta">
                                    <div class="pd-appt-card-field">
                                        <div class="pd-appt-card-field-lbl">Date</div>
                                        <div class="pd-appt-card-field-val">{{ $r['date'] }}</div>
                                    </div>
                                    <div class="pd-appt-card-field">
                                        <div class="pd-appt-card-field-lbl">Time</div>
                                        <div class="pd-appt-card-field-val" style="color:#0ea5e9">{{ $r['time'] }}</div>
                                    </div>
                                    <div class="pd-appt-card-field">
                                        <div class="pd-appt-card-field-lbl">Amount</div>
                                        <div class="pd-appt-card-field-val">{{ $r['fee'] }}</div>
                                    </div>
                                    <div class="pd-appt-card-field">
                                        <div class="pd-appt-card-field-lbl">Booked On</div>
                                        <div class="pd-appt-card-field-val">{{ $r['booked'] }}</div>
                                    </div>
                                </div>
                                <div class="pd-appt-card-actions">
                                    <span style="font-size:11.5px;color:#94a3b8">Follow-up: {{ $r['followUp'] }}</span>
                                    <a href="{{ route('patient.appointments.show',$appt->id) }}" class="pd-view-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        View
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="pd-empty">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <div class="pd-empty-title">No appointments</div>
                                <div class="pd-empty-sub">Nothing to show here yet.</div>
                            </div>
                        @endforelse
                    </div>

                </div>
                @endforeach

                {{-- Billing tab --}}
                <div class="pd-tab-content" id="tab-billing">
                    <div class="pd-billing-stats">
                        <div class="pd-billing-stat">
                            <div class="pd-billing-stat-icon green"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></div>
                            <div>
                                <div class="pd-billing-stat-val">₹{{ number_format($totalPaymentAmount, 2) }}</div>
                                <div class="pd-billing-stat-lbl">Total Paid</div>
                            </div>
                        </div>
                        <div class="pd-billing-stat">
                            <div class="pd-billing-stat-icon blue"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14H5a1 1 0 01-1-1V4a1 1 0 011-1h11a1 1 0 011 1v1M9 14a1 1 0 001 1h9a1 1 0 001-1v-5a1 1 0 00-1-1h-9a1 1 0 00-1 1v5z"/></svg></div>
                            <div>
                                <div class="pd-billing-stat-val">{{ $payments->count() }}</div>
                                <div class="pd-billing-stat-lbl">Payments</div>
                            </div>
                        </div>
                    </div>

                    {{-- Desktop table --}}
                    <div class="pd-table-wrap">
                        <table class="pd-table">
                            <thead><tr><th>Invoice</th><th>Doctor</th><th>Amount</th><th>Paid On</th><th>Status</th></tr></thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    @php $pn = $payment->doctor->name ?? '—'; $pi = $payment->doctor->profile_img ? asset($payment->doctor->profile_img) : null; @endphp
                                    <tr>
                                        <td><span class="pd-inv">#INV-{{ str_pad($payment->id,5,'0',STR_PAD_LEFT) }}</span></td>
                                        <td>
                                            <div class="pd-doc-cell">
                                                @if($pi) <img class="pd-doc-img" src="{{ $pi }}" alt="Dr. {{ $pn }}">
                                                @else <div class="pd-doc-ph">{{ strtoupper(substr($pn,0,2)) }}</div> @endif
                                                <div>
                                                    <div class="pd-doc-name">Dr. {{ $pn }}</div>
                                                    <div class="pd-doc-spec">{{ optional($payment->doctor->profile->specializationdata)->name ?? 'Doctor' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="font-weight:700;color:#0f172a">₹{{ number_format($payment->amount,2) }}</td>
                                        <td style="color:#64748b;font-size:12.5px">{{ optional($payment->paid_at)->format('d M Y') ?? $payment->created_at->format('d M Y') }}</td>
                                        <td>@php $ps=$payment->status??'pending'; @endphp<span class="pd-pill {{ $ps }}"><span class="pd-pill-dot"></span>{{ ucfirst($ps) }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5"><div class="pd-empty"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14H5a1 1 0 01-1-1V4a1 1 0 011-1h11a1 1 0 011 1v1M9 14a1 1 0 001 1h9a1 1 0 001-1v-5a1 1 0 00-1-1h-9a1 1 0 00-1 1v5z"/></svg><div class="pd-empty-title">No billing history</div><div class="pd-empty-sub">Payments will appear here.</div></div></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile billing cards --}}
                    <div class="pd-card-list">
                        @forelse($payments as $payment)
                            @php $pn=$payment->doctor->name??'—'; $pi=$payment->doctor->profile_img?asset($payment->doctor->profile_img):null; $ps=$payment->status??'pending'; @endphp
                            <div class="pd-bill-card">
                                @if($pi) <img class="pd-doc-img" src="{{ $pi }}" alt="Dr. {{ $pn }}">
                                @else <div class="pd-doc-ph">{{ strtoupper(substr($pn,0,2)) }}</div> @endif
                                <div>
                                    <div class="pd-doc-name">Dr. {{ $pn }}</div>
                                    <div style="margin-top:3px"><span class="pd-pill {{ $ps }}"><span class="pd-pill-dot"></span>{{ ucfirst($ps) }}</span></div>
                                </div>
                                <div class="pd-bill-card-right">
                                    <div class="pd-bill-amount">₹{{ number_format($payment->amount,2) }}</div>
                                    <div class="pd-bill-date">{{ optional($payment->paid_at)->format('d M Y') ?? $payment->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="pd-empty"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14H5a1 1 0 01-1-1V4a1 1 0 011-1h11a1 1 0 011 1v1M9 14a1 1 0 001 1h9a1 1 0 001-1v-5a1 1 0 00-1-1h-9a1 1 0 00-1 1v5z"/></svg><div class="pd-empty-title">No billing history</div></div>
                        @endforelse
                    </div>
                </div>

            </div>{{-- /pd-card --}}
        </main>
    </div>
</div>

<script>
function switchTab(tabId, btn) {
    document.querySelectorAll('.pd-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.pd-tab-content').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-' + tabId).classList.add('active');
}

// Mobile drawer
(function(){
    const toggle  = document.getElementById('pdMenuToggle');
    const drawer  = document.getElementById('pdDrawer');
    const overlay = document.getElementById('pdDrawerOverlay');
    const close   = document.getElementById('pdDrawerClose');
    function open()  { drawer.classList.add('open'); overlay.classList.add('open'); document.body.style.overflow='hidden'; }
    function shut()  { drawer.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow=''; }
    if(toggle)  toggle.addEventListener('click', open);
    if(close)   close.addEventListener('click', shut);
    if(overlay) overlay.addEventListener('click', shut);
})();
</script>

@endsection