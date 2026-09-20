@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* ─────────────────────────────────────────────
   DESIGN TOKENS & RESET (Premium Teal Theme)
───────────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
    --primary-teal:      #0c6978;
    --primary-teal-dark: #074752;
    --primary-teal-sub:  #108598;
    --primary-teal-hover:#095460;
    --teal-bg-soft:      #eef8f9;
    --teal-badge-bg:     #e2f4f6;
    --teal-badge-border: #bce5ea;
    --accent-mint:       #2dd4bf;

    --primary:           #0c6978;
    --primary-d:         #074752;
    --primary-l:         #eef8f9;
    --ink:               #0f172a;
    --ink-light:         #1e293b;
    --body-c:            #475569;
    --muted:             #64748b;
    --border:            #e2e8f0;
    --border-light:      #f1f5f9;
    --bg:                #f8fafc;
    --white:             #ffffff;

    --r-xl:              20px;
    --r-lg:              14px;
    --r:                 10px;
    --shadow-sm:         0 2px 8px rgba(15, 23, 42, 0.04);
    --shadow:            0 4px 20px rgba(12, 105, 120, 0.06), 0 1px 3px rgba(0, 0, 0, 0.03);
    --shadow-hover:      0 10px 30px rgba(12, 105, 120, 0.12), 0 2px 8px rgba(0, 0, 0, 0.04);
}
body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    color: var(--body-c);
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
}
a { text-decoration: none; color: inherit; }
ul { list-style: none; }

/* ─────────────────────────────────────────────
   PAGE SHELL
───────────────────────────────────────────── */
.pd-page { min-height: 100vh; display: flex; flex-direction: column; background: var(--bg); overflow-x: hidden; width: 100%; }

/* ─────────────────────────────────────────────
   MOBILE HEADER BAR (< 768px)
───────────────────────────────────────────── */
.pd-mobile-topbar {
    display: none;
    background: linear-gradient(135deg, var(--primary-teal-dark) 0%, var(--primary-teal) 100%);
    padding: 14px 18px;
    align-items: center;
    justify-content: space-between;
    position: sticky; top: 68px; z-index: 200;
    box-shadow: 0 4px 16px rgba(7, 71, 82, 0.18);
}
.pd-mobile-user { display: flex; align-items: center; gap: 12px; }
.pd-mobile-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    border: 2px solid rgba(255,255,255,.6);
    object-fit: cover;
}
.pd-mobile-avatar-ph {
    width: 40px; height: 40px; border-radius: 50%;
    background: rgba(255,255,255,.2);
    color: #fff; font-weight: 800; font-size: 15px;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid rgba(255,255,255,.5);
}
.pd-mobile-name { font-size: 14.5px; font-weight: 800; color: #fff; }
.pd-mobile-role { font-size: 11.5px; color: rgba(255,255,255,.75); font-weight: 500; }
.pd-menu-toggle {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px;
    width: 40px; height: 40px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; cursor: pointer; font-size: 18px;
    transition: all .2s;
}
.pd-menu-toggle:hover { background: rgba(255,255,255,.25); }

/* ─────────────────────────────────────────────
   MOBILE SIDEBAR DRAWER
───────────────────────────────────────────── */
.pd-drawer-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(15,23,42,.5);
    z-index: 9998;
    backdrop-filter: blur(4px);
}
.pd-drawer {
    position: fixed; top: 0; left: -300px;
    width: 290px; height: 100vh;
    background: var(--white);
    z-index: 9999;
    transition: left .3s cubic-bezier(.4,0,.2,1);
    overflow-y: auto;
    box-shadow: 6px 0 40px rgba(15,23,42,.2);
    display: flex; flex-direction: column;
}
.pd-drawer.open { left: 0; }
.pd-drawer-overlay.open { display: block; }

.pd-drawer-profile {
    background: linear-gradient(135deg, var(--primary-teal-dark) 0%, var(--primary-teal) 100%);
    padding: 30px 22px 24px;
    position: relative;
    overflow: hidden;
}
.pd-drawer-profile::after {
    content: ''; position: absolute; right: -25px; bottom: -25px;
    width: 120px; height: 120px; border-radius: 50%;
    background: radial-gradient(circle, rgba(45,212,191,0.2) 0%, transparent 70%);
}
.pd-drawer-close {
    position: absolute; top: 14px; right: 14px;
    background: rgba(255,255,255,.18); border: none;
    width: 32px; height: 32px; border-radius: 50%;
    color: #fff; font-size: 18px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s;
    z-index: 2;
}
.pd-drawer-close:hover { background: rgba(255,255,255,.3); }
.pd-drawer-avatar {
    width: 70px; height: 70px; border-radius: 50%;
    border: 3px solid rgba(255,255,255,.6);
    object-fit: cover; margin-bottom: 12px;
    position: relative; z-index: 1;
}
.pd-drawer-avatar-ph {
    width: 70px; height: 70px; border-radius: 50%;
    background: rgba(255,255,255,.2);
    border: 3px solid rgba(255,255,255,.5);
    color: #fff; font-size: 24px; font-weight: 900;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 12px; position: relative; z-index: 1;
}
.pd-drawer-name { font-size: 17.5px; font-weight: 800; color: #fff; position: relative; z-index: 1; }
.pd-drawer-meta { font-size: 12px; color: rgba(255,255,255,.75); margin-top: 4px; position: relative; z-index: 1; }

.pd-drawer-nav { padding: 14px 12px; flex: 1; }
.pd-drawer-nav-item {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 14px; border-radius: 12px;
    font-size: 14px; font-weight: 600; color: #475569;
    transition: all .18s; cursor: pointer;
    margin-bottom: 4px;
}
.pd-drawer-nav-item:hover { background: var(--teal-bg-soft); color: var(--primary-teal); }
.pd-drawer-nav-item.active {
    background: linear-gradient(135deg, var(--primary-teal) 0%, var(--primary-teal-sub) 100%);
    color: #fff;
    box-shadow: 0 4px 14px rgba(12, 105, 120, 0.28);
}
.pd-drawer-nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
.pd-drawer-divider { height: 1px; background: var(--border); margin: 10px 0; }
.pd-drawer-logout-btn {
    width: 100%; display: flex; align-items: center; gap: 12px;
    padding: 12px 14px; border-radius: 12px;
    font-size: 14px; font-weight: 600; color: #ef4444;
    background: transparent; border: none; cursor: pointer;
    transition: all .18s; font-family: 'Plus Jakarta Sans', sans-serif;
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
    padding: 32px 24px 56px;
    width: 100%;
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 26px;
    align-items: start;
}

/* ─────────────────────────────────────────────
   DESKTOP SIDEBAR
───────────────────────────────────────────── */
.pd-sidebar {
    position: sticky; top: 96px;
    display: flex; flex-direction: column; gap: 16px;
}

.pd-profile-card {
    background: linear-gradient(145deg, var(--primary-teal-dark) 0%, var(--primary-teal) 100%);
    border-radius: var(--r-xl); padding: 26px 22px;
    color: #fff; position: relative; overflow: hidden;
    box-shadow: 0 12px 36px rgba(7, 71, 82, 0.22);
    border: 1px solid rgba(255, 255, 255, 0.08);
}
.pd-profile-card::before {
    content: ''; position: absolute; right: -30px; top: -30px;
    width: 140px; height: 140px; border-radius: 50%;
    background: rgba(255, 255, 255, 0.06);
}
.pd-profile-card::after {
    content: ''; position: absolute; right: -20px; bottom: -20px;
    width: 110px; height: 110px; border-radius: 50%;
    background: radial-gradient(circle, rgba(45,212,191,0.18) 0%, transparent 70%);
    pointer-events: none;
}
.pd-avatar {
    width: 74px; height: 74px; border-radius: 50%;
    border: 3.5px solid rgba(255,255,255,.5);
    object-fit: cover; margin-bottom: 14px;
    position: relative; z-index: 1;
    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
}
.pd-avatar-ph {
    width: 74px; height: 74px; border-radius: 50%;
    border: 3.5px solid rgba(255,255,255,.5);
    background: rgba(255,255,255,.18);
    color: #fff; font-size: 24px; font-weight: 900;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 14px; position: relative; z-index: 1;
    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
}
.pd-profile-name {
    font-size: 18px; font-weight: 800; letter-spacing: -.02em;
    position: relative; z-index: 1; line-height: 1.3;
}
.pd-profile-badge {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
    border-radius: 20px; padding: 2px 9px; font-size: 11px; font-weight: 700;
    color: #e0f7f8; margin-top: 6px; position: relative; z-index: 1;
}
.pd-profile-meta { display: flex; flex-direction: column; gap: 6px; margin-top: 14px; position: relative; z-index: 1; }
.pd-profile-meta-item { display: flex; align-items: center; gap: 8px; font-size: 12.5px; color: rgba(255,255,255,.8); font-weight: 500; }
.pd-profile-meta-item svg { width: 13px; height: 13px; color: var(--accent-mint); flex-shrink: 0; }

.pd-nav-card {
    background: var(--white); border-radius: var(--r-xl);
    padding: 10px; box-shadow: var(--shadow); border: 1px solid var(--border);
}
.pd-nav-item {
    display: flex; align-items: center; gap: 12px;
    padding: 11px 15px; border-radius: var(--r-lg);
    font-size: 14px; font-weight: 600; color: #64748b;
    transition: all .18s ease; cursor: pointer;
    text-decoration: none; margin-bottom: 3px;
}
.pd-nav-item:hover { background: var(--teal-bg-soft); color: var(--primary-teal); }
.pd-nav-item.active {
    background: linear-gradient(135deg, var(--primary-teal) 0%, var(--primary-teal-sub) 100%);
    color: #fff;
    box-shadow: 0 4px 14px rgba(12, 105, 120, 0.28);
}
.pd-nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }
.pd-nav-divider { height: 1px; background: var(--border-light); margin: 6px 0; }
.pd-logout-form { width: 100%; }
.pd-logout-btn {
    width: 100%; display: flex; align-items: center; gap: 12px;
    padding: 11px 15px; border-radius: var(--r-lg);
    font-size: 14px; font-weight: 600; color: #ef4444;
    background: transparent; border: none; cursor: pointer;
    transition: all .18s ease; font-family: 'Plus Jakarta Sans', sans-serif;
}
.pd-logout-btn:hover { background: #fef2f2; color: #dc2626; }
.pd-logout-btn svg { width: 17px; height: 17px; }

/* ─────────────────────────────────────────────
   MAIN CONTENT
───────────────────────────────────────────── */
.pd-main { display: flex; flex-direction: column; gap: 20px; }

/* Page Header */
.pd-page-header {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px;
}
.pd-page-title { font-size: 23px; font-weight: 900; color: var(--ink); letter-spacing: -.03em; }
.pd-page-sub { font-size: 13.5px; color: var(--muted); margin-top: 3px; font-weight: 500; }
.pd-date-chip {
    display: flex; align-items: center; gap: 8px;
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: 11px; padding: 8px 15px;
    font-size: 12.5px; font-weight: 700; color: var(--primary-teal);
    box-shadow: var(--shadow-sm);
}
.pd-date-chip svg { width: 14px; height: 14px; }

/* ─────────────────────────────────────────────
   STAT CARDS (Modernized)
───────────────────────────────────────────── */
.pd-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.pd-stat {
    background: var(--white); border-radius: var(--r-xl);
    padding: 20px 18px; border: 1.5px solid var(--border);
    display: flex; align-items: center; gap: 16px;
    transition: all .22s cubic-bezier(.4,0,.2,1); position: relative; overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.pd-stat::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3.5px;
    border-radius: 20px 20px 0 0;
}
.pd-stat.teal::before  { background: linear-gradient(90deg, var(--primary-teal), var(--accent-mint)); }
.pd-stat.green::before { background: linear-gradient(90deg, #10b981, #34d399); }
.pd-stat.amber::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }

.pd-stat:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-3px);
    border-color: #cbd5e1;
}
.pd-stat-icon {
    width: 48px; height: 48px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.pd-stat-icon.teal  { background: var(--teal-bg-soft); color: var(--primary-teal); border: 1px solid var(--teal-badge-border); }
.pd-stat-icon.green { background: #ecfdf5; color: #10b981; border: 1px solid #a7f3d0; }
.pd-stat-icon.amber { background: #fffbeb; color: #f59e0b; border: 1px solid #fde68a; }
.pd-stat-icon svg { width: 21px; height: 21px; }
.pd-stat-val { font-size: 26px; font-weight: 900; color: var(--ink); letter-spacing: -.04em; line-height: 1; }
.pd-stat-lbl { font-size: 12.5px; color: var(--muted); margin-top: 4px; font-weight: 600; }

/* ─────────────────────────────────────────────
   TAB CARD & CONTROLS
───────────────────────────────────────────── */
.pd-card {
    background: var(--white); border-radius: var(--r-xl);
    border: 1.5px solid var(--border); box-shadow: var(--shadow);
    overflow: hidden;
}
.pd-tabs-bar {
    display: flex; border-bottom: 1.5px solid var(--border-light);
    padding: 12px 18px 0; gap: 4px;
    background: #fafcfe;
    overflow-x: auto; scrollbar-width: none; -webkit-overflow-scrolling: touch;
}
.pd-tabs-bar::-webkit-scrollbar { display: none; }
.pd-tab {
    padding: 10px 18px; border-radius: 10px 10px 0 0;
    font-size: 13.5px; font-weight: 600; color: #64748b;
    cursor: pointer; border: none; background: transparent;
    transition: all .18s ease; white-space: nowrap;
    border-bottom: 2.5px solid transparent; margin-bottom: -1.5px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    display: inline-flex; align-items: center; gap: 6px;
}
.pd-tab:hover { color: var(--primary-teal); background: rgba(12, 105, 120, 0.04); }
.pd-tab.active {
    color: var(--primary-teal);
    border-bottom-color: var(--primary-teal);
    background: var(--white);
    font-weight: 700;
    box-shadow: 0 -2px 8px rgba(12, 105, 120, 0.04);
}
.pd-tab-badge {
    display: inline-flex; align-items: center; justify-content: center;
    background: #f1f5f9; color: #64748b; font-size: 11px;
    padding: 1px 7px; border-radius: 10px; font-weight: 700;
}
.pd-tab.active .pd-tab-badge {
    background: var(--teal-bg-soft);
    color: var(--primary-teal);
}

.pd-tab-content { display: none; }
.pd-tab-content.active { display: block; }

/* ─────────────────────────────────────────────
   TABLE (Desktop)
───────────────────────────────────────────── */
.pd-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
table.pd-table { width: 100%; border-collapse: collapse; font-size: 13px; }
table.pd-table th {
    padding: 12px 18px; text-align: left;
    font-size: 11px; font-weight: 700; color: #64748b;
    text-transform: uppercase; letter-spacing: .06em;
    background: #f8fafc; border-bottom: 1.5px solid var(--border-light);
    white-space: nowrap;
}
table.pd-table td {
    padding: 14px 18px; color: var(--body-c);
    border-bottom: 1px solid var(--border-light); vertical-align: middle;
}
table.pd-table tr:last-child td { border-bottom: none; }
table.pd-table tr:hover td { background: #fbfdfd; }

.pd-doc-cell { display: flex; align-items: center; gap: 12px; }
.pd-doc-img {
    width: 40px; height: 40px; border-radius: 50%; object-fit: cover;
    border: 2px solid var(--teal-badge-border); flex-shrink: 0;
}
.pd-doc-ph {
    width: 40px; height: 40px; border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-teal), var(--primary-teal-sub));
    color: #fff; font-size: 13px; font-weight: 800;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(12,105,120,0.2);
}
.pd-doc-name { font-weight: 800; color: var(--ink); font-size: 13.5px; }
.pd-doc-spec { font-size: 11.5px; color: #64748b; margin-top: 2px; }
.pd-date-main { font-weight: 700; color: var(--ink); font-size: 13.5px; }
.pd-date-time { font-size: 12px; color: var(--primary-teal); margin-top: 2px; font-weight: 700; }

/* Status pills */
.pd-pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 11px; border-radius: 50px; font-size: 11.5px; font-weight: 700;
}
.pd-pill-dot { width: 6px; height: 6px; border-radius: 50%; }

.pd-pill.confirmed { background: var(--teal-badge-bg); color: var(--primary-teal-dark); border: 1px solid var(--teal-badge-border); }
.pd-pill.confirmed .pd-pill-dot { background: var(--primary-teal); }

.pd-pill.pending   { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
.pd-pill.pending .pd-pill-dot { background: #f59e0b; }

.pd-pill.completed { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
.pd-pill.completed .pd-pill-dot { background: #10b981; }

.pd-pill.cancelled { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
.pd-pill.cancelled .pd-pill-dot { background: #ef4444; }

.pd-pill.shifted   { background: #f5f3ff; color: #5b21b6; border: 1px solid #ddd6fe; }
.pd-pill.shifted .pd-pill-dot { background: #8b5cf6; }

.pd-pill.success   { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
.pd-pill.success .pd-pill-dot { background: #10b981; }

.pd-pill.failed    { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
.pd-pill.failed .pd-pill-dot { background: #ef4444; }

.pd-view-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 15px; background: var(--teal-bg-soft); color: var(--primary-teal);
    border-radius: 10px; font-size: 12.5px; font-weight: 700;
    border: 1.5px solid var(--teal-badge-border);
    transition: all .18s cubic-bezier(.4,0,.2,1); white-space: nowrap;
}
.pd-view-btn:hover {
    background: var(--primary-teal); color: #fff;
    border-color: var(--primary-teal);
    box-shadow: 0 4px 12px rgba(12, 105, 120, 0.28);
    transform: translateY(-1px);
}
.pd-view-btn svg { width: 13px; height: 13px; }
.pd-inv {
    font-size: 11.5px; font-weight: 700; color: var(--primary-teal-dark);
    font-family: monospace; background: var(--teal-bg-soft);
    border: 1px solid var(--teal-badge-border);
    padding: 3px 8px; border-radius: 6px;
}

/* Empty state */
.pd-empty { text-align: center; padding: 48px 20px; color: #94a3b8; }
.pd-empty svg { width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 12px; }
.pd-empty-title { font-size: 15px; font-weight: 800; color: #475569; margin-bottom: 4px; }
.pd-empty-sub { font-size: 13px; color: #94a3b8; }

/* Billing stats */
.pd-billing-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; padding: 20px 20px 10px; }
.pd-billing-stat {
    background: #f8fafc; border: 1.5px solid var(--border);
    border-radius: 14px; padding: 18px 20px;
    display: flex; align-items: center; gap: 14px;
}
.pd-billing-stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.pd-billing-stat-icon.green { background: #ecfdf5; color: #10b981; border: 1px solid #a7f3d0; }
.pd-billing-stat-icon.teal  { background: var(--teal-bg-soft); color: var(--primary-teal); border: 1px solid var(--teal-badge-border); }
.pd-billing-stat-icon svg { width: 19px; height: 19px; }
.pd-billing-stat-val { font-size: 22px; font-weight: 900; color: var(--ink); letter-spacing: -.03em; }
.pd-billing-stat-lbl { font-size: 12px; color: var(--muted); margin-top: 3px; font-weight: 600; }

/* ─────────────────────────────────────────────
   MOBILE CARD VIEW (< 768px)
───────────────────────────────────────────── */
.pd-card-list { display: none; flex-direction: column; gap: 0; }
.pd-appt-card {
    padding: 16px 18px;
    border-bottom: 1px solid var(--border-light);
    display: flex; flex-direction: column; gap: 12px;
}
.pd-appt-card:last-child { border-bottom: none; }

.pd-appt-card-top { display: flex; align-items: center; gap: 10px; }
.pd-appt-card-info { flex: 1; min-width: 0; }
.pd-appt-card-name { font-size: 14px; font-weight: 800; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.pd-appt-card-spec { font-size: 11.5px; color: #64748b; margin-top: 1px; }

.pd-appt-card-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; }
.pd-appt-card-field { background: #f8fafc; border: 1px solid var(--border-light); border-radius: 9px; padding: 7px 10px; min-width: 0; overflow: hidden; }
.pd-appt-card-field-lbl { font-size: 9.5px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .02em; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.pd-appt-card-field-val { font-size: 12.5px; font-weight: 700; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.pd-appt-card-actions { display: flex; align-items: center; justify-content: space-between; gap: 8px; }

/* Billing mobile card list */
.bp-card-list { display: none; flex-direction: column; gap: 0; }
.bp-txn-mobile-card {
    padding: 14px 16px;
    border-bottom: 1px solid var(--border-light);
    display: flex; flex-direction: column; gap: 10px;
}
.bp-txn-mobile-card:last-child { border-bottom: none; }
.bp-tmc-top { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
.bp-tmc-doc { display: flex; align-items: center; gap: 10px; min-width: 0; }
.bp-tmc-doc .bp-doc-name { font-size: 13.5px; font-weight: 800; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.bp-tmc-doc .bp-doc-spec { font-size: 11px; color: var(--muted); }
.bp-tmc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; }
.bp-tmc-field { background: #f8fafc; border: 1px solid var(--border-light); border-radius: 9px; padding: 7px 10px; min-width: 0; overflow: hidden; }
.bp-tmc-lbl { font-size: 9.5px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .02em; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.bp-tmc-val { font-size: 12px; font-weight: 700; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.bp-tmc-footer { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding-top: 2px; }
.bp-btn-view-invoice {
    display: inline-flex; align-items: center; justify-content: center; gap: 6px;
    padding: 8px 12px; border-radius: 8px;
    background: var(--teal-bg-soft); border: 1.5px solid var(--teal-badge-border);
    color: var(--primary-teal); font-size: 12px; font-weight: 700;
    cursor: pointer; transition: all 0.15s; width: 100%;
}
.bp-btn-view-invoice:hover { background: var(--primary-teal); color: #ffffff; border-color: var(--primary-teal); }

/* ─────────────────────────────────────────────
   RESPONSIVE BREAKPOINTS
───────────────────────────────────────────── */
@media (max-width: 1024px) {
    .pd-body { grid-template-columns: 250px 1fr; gap: 20px; }
}

@media (max-width: 768px) {
    .pd-mobile-topbar { display: flex; }
    .pd-sidebar { display: none; }

    .pd-body {
        grid-template-columns: 100%;
        padding: 12px 10px 44px;
        gap: 12px;
        width: 100%;
        box-sizing: border-box;
    }

    /* Stats on mobile */
    .pd-stats { grid-template-columns: repeat(3, 1fr); gap: 6px; }
    .pd-stat { padding: 10px 6px; flex-direction: column; align-items: flex-start; gap: 4px; border-radius: 12px; min-width: 0; }
    .pd-stat-icon { width: 32px; height: 32px; border-radius: 8px; }
    .pd-stat-icon svg { width: 15px; height: 15px; }
    .pd-stat-val { font-size: 17px; }
    .pd-stat-lbl { font-size: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    /* Page header */
    .pd-page-title { font-size: 18px; }
    .pd-date-chip { display: none; }

    /* Tabs */
    .pd-tabs-bar { padding: 8px 10px 0; gap: 2px; }
    .pd-tab { font-size: 12px; padding: 7px 10px; }

    /* Hide table, show card list */
    .pd-table-wrap { display: none !important; }
    .pd-card-list { display: flex !important; }
    .bp-table-wrap { display: none !important; }
    .bp-card-list { display: flex !important; }

    /* Billing stats */
    .pd-billing-stats { grid-template-columns: 1fr 1fr; padding: 12px; gap: 8px; }
    .pd-billing-stat { padding: 10px 12px; }
    .pd-billing-stat-val { font-size: 17px; }
}

@media (max-width: 480px) {
    .pd-stats { grid-template-columns: repeat(3, 1fr); gap: 4px; }
    .pd-stat { padding: 8px 5px; }
    .pd-stat-icon { width: 28px; height: 28px; border-radius: 6px; }
    .pd-stat-icon svg { width: 13px; height: 13px; }
    .pd-stat-val { font-size: 16px; }
    .pd-stat-lbl { font-size: 9px; }
    .pd-billing-stats { grid-template-columns: 1fr; }
    .pd-body { padding: 8px 6px 36px; }
}

/* ─────────────────────────────────────────────
   BILLING & PAYMENTS SECTION STYLES (bp-*)
───────────────────────────────────────────── */
.bp-top-bar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:22px;}
.bp-page-title{font-size:24px;font-weight:800;color:var(--ink);}
.bp-page-sub{font-size:13px;color:var(--muted);margin-top:2px;}
.bp-top-actions{display:flex;gap:10px;}
.bp-btn-back{display:flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9px;border:1.5px solid var(--border);background:#fff;color:var(--body-c);font-size:13px;font-weight:600;text-decoration:none;transition:all 0.15s;cursor:pointer;}
.bp-btn-back:hover{border-color:var(--primary-teal);color:var(--primary-teal);background:var(--teal-bg-soft);}
.bp-btn-refresh{display:flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9px;background:var(--teal-bg-soft);border:1.5px solid var(--teal-badge-border);color:var(--primary-teal);font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;transition:all 0.15s;}
.bp-btn-refresh:hover{background:var(--teal-badge-border);}

.bp-grid-2{display:grid;grid-template-columns:1fr 310px;gap:20px;align-items:start;}

.bp-card{background:#ffffff;border:1px solid var(--border);border-radius:var(--r-lg);box-shadow:var(--shadow);overflow:hidden;}
.bp-card-head{padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;}
.bp-card-head-icon{width:36px;height:36px;border-radius:9px;background:var(--teal-bg-soft);display:flex;align-items:center;justify-content:center;color:var(--primary-teal);font-size:15px;}
.bp-card-head h3{font-size:15px;font-weight:700;color:var(--ink);margin:0;}
.bp-card-body{padding:20px;}

.bp-overview-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.bp-ov-box{background:var(--teal-bg-soft);border:1px solid var(--teal-badge-border);border-radius:11px;padding:16px;}
.bp-ov-label{font-size:12px;color:var(--muted);font-weight:600;margin-bottom:4px;}
.bp-ov-val{font-size:22px;font-weight:800;color:var(--primary-teal);letter-spacing:-0.5px;}
.bp-ov-sub{font-size:11px;color:var(--muted);margin-top:3px;}
.bp-ov-box.pending{background:#fffbeb;border-color:#fde68a;}
.bp-ov-box.pending .bp-ov-val{color:#d97706;}

.bp-actions-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.bp-action-card{display:flex;align-items:center;gap:12px;padding:14px;background:var(--teal-bg-soft);border:1px solid var(--teal-badge-border);border-radius:11px;text-decoration:none;color:var(--ink);font-size:13px;font-weight:600;transition:all 0.15s;cursor:pointer;}
.bp-action-card:hover{background:var(--teal-badge-border);}
.bp-action-icon{width:36px;height:36px;border-radius:9px;background:var(--primary-teal);color:#fff;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;}
.bp-action-sub{font-size:11px;color:var(--muted);font-weight:400;margin-top:1px;}

.bp-table-wrap{overflow-x:auto;}
table.bp-table{width:100%;border-collapse:collapse;}
.bp-table thead tr{border-bottom:2px solid var(--teal-bg-soft);}
.bp-table thead th{padding:10px 14px;font-size:12px;font-weight:700;color:var(--muted);text-align:left;text-transform:uppercase;letter-spacing:.5px;}
.bp-table tbody tr{border-bottom:1px solid #f1f5f9;transition:background 0.12s;}
.bp-table tbody tr:hover{background:var(--teal-bg-soft);}
.bp-table td{padding:13px 14px;font-size:13px;color:var(--body-c);vertical-align:middle;}
.bp-doc-cell{display:flex;align-items:center;gap:10px;}
.bp-doc-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--primary-teal),var(--primary-teal-sub));display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700;flex-shrink:0;}
.bp-doc-name{font-size:13px;font-weight:700;color:var(--ink);}
.bp-doc-spec{font-size:11px;color:var(--muted);}
.bp-txn-id{font-size:11.5px;color:var(--muted);font-family:monospace;}
.bp-method-pill{display:inline-flex;align-items:center;gap:5px;font-size:11.5px;font-weight:600;padding:3px 9px;border-radius:20px;background:#f1f5f9;color:var(--body-c);}
.bp-status-pill{display:inline-block;padding:4px 11px;border-radius:20px;font-size:11.5px;font-weight:700;}
.bp-status-pill.paid{background:#d1fae5;color:#065f46;}
.bp-status-pill.pending{background:#fef3c7;color:#92400e;}
.bp-status-pill.failed{background:#fee2e2;color:#991b1b;}
.bp-tbl-btn{width:30px;height:30px;border-radius:8px;background:var(--teal-bg-soft);border:none;display:flex;align-items:center;justify-content:center;color:var(--primary-teal);cursor:pointer;transition:all 0.15s;text-decoration:none;}
.bp-tbl-btn:hover{background:var(--primary-teal);color:#fff;}

.bp-tbl-footer{padding:14px 20px;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;}
.bp-page-info{font-size:12.5px;color:var(--muted);font-weight:600;}
.bp-pagination{display:flex;gap:5px;align-items:center;}
.bp-pagination button,.bp-pagination a,.bp-pagination span{display:flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 6px;border-radius:8px;font-size:12.5px;font-weight:700;text-decoration:none;border:1.5px solid var(--border);color:var(--body-c);background:#fff;transition:all 0.15s;cursor:pointer;}
.bp-pagination button:hover:not(:disabled){border-color:var(--primary-teal);color:var(--primary-teal);background:var(--teal-bg-soft);}
.bp-pagination button.active,.bp-pagination span.active{background:var(--primary-teal);color:#fff;border-color:var(--primary-teal);}
.bp-pagination button:disabled{opacity:0.35;cursor:not-allowed;}

.bp-wallet-card{background:linear-gradient(145deg,var(--primary-teal),var(--primary-teal-sub));border-radius:var(--r-lg);padding:20px;color:#fff;margin-bottom:16px;}
.bp-wallet-head{display:flex;align-items:center;gap:10px;margin-bottom:14px;}
.bp-wallet-icon{width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:17px;}
.bp-wallet-title{font-size:14px;font-weight:700;opacity:.9;}
.bp-wallet-sub{font-size:11px;opacity:.7;}
.bp-wallet-bal-lbl{font-size:12px;opacity:.8;margin-bottom:4px;}
.bp-wallet-bal{font-size:32px;font-weight:800;letter-spacing:-1px;margin-bottom:16px;}
.bp-wallet-add{display:flex;align-items:center;justify-content:center;gap:6px;width:100%;padding:10px;border-radius:9px;background:rgba(255,255,255,0.18);border:1.5px solid rgba(255,255,255,0.35);color:#fff;font-size:13px;font-weight:700;cursor:pointer;transition:background 0.15s;}
.bp-wallet-add:hover{background:rgba(255,255,255,0.28);}
.bp-wallet-features{margin-top:14px;display:flex;flex-direction:column;gap:8px;}
.bp-wallet-feat{display:flex;align-items:center;gap:8px;font-size:12px;opacity:.85;}
.bp-assist-card{background:#ffffff;border:1px solid var(--border);border-radius:var(--r-lg);padding:18px;text-align:center;}
.bp-assist-icon{font-size:28px;color:var(--primary-teal);margin-bottom:8px;}
.bp-assist-title{font-size:14px;font-weight:700;color:var(--ink);margin-bottom:4px;}
.bp-assist-sub{font-size:12px;color:var(--muted);margin-bottom:12px;}
.bp-assist-btn{display:block;padding:9px;border-radius:9px;border:1.5px solid var(--primary-teal);color:var(--primary-teal);font-size:13px;font-weight:700;text-decoration:none;text-align:center;transition:all 0.15s;}
.bp-assist-btn:hover{background:var(--primary-teal);color:#fff;}

.bp-empty{padding:50px 20px;text-align:center;}
.bp-empty i{font-size:40px;color:var(--teal-badge-border);margin-bottom:12px;}
.bp-empty h4{font-size:16px;font-weight:700;color:var(--ink);margin-bottom:6px;}
.bp-empty p{font-size:13px;color:var(--muted);}

/* Modal */
.bp-modal-overlay{position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(5px);display:flex;align-items:center;justify-content:center;padding:20px;}
.bp-modal-overlay.hidden{display:none;}
.bp-modal{background:#ffffff;border-radius:20px;width:100%;max-width:640px;max-height:92vh;overflow-y:auto;box-shadow:0 25px 70px rgba(0,0,0,0.25);animation:modalIn .22s cubic-bezier(0.16, 1, 0.3, 1);scrollbar-width:thin;scrollbar-color:#cbd5e1 transparent;}
.bp-modal::-webkit-scrollbar{width:6px;}
.bp-modal::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:10px;}
@keyframes modalIn{from{transform:scale(.95) translateY(10px);opacity:0;}to{transform:scale(1) translateY(0);opacity:1;}}
.bp-modal-head{display:flex;align-items:center;justify-content:space-between;padding:18px 24px;border-bottom:1px solid var(--border);font-size:16px;font-weight:800;color:var(--ink);}
.bp-modal-close{width:32px;height:32px;border-radius:8px;background:#f1f5f9;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;color:var(--muted);transition:all .15s;}
.bp-modal-close:hover{background:#ef4444;color:#fff;}
.bp-modal-body{padding:24px 28px;}
.bp-inv-brand{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid #f1f5f9;}
.bp-inv-logo{height:40px;}
.bp-inv-num{font-size:11.5px;font-weight:700;color:var(--muted);text-align:right;}
.bp-inv-num span{display:block;font-size:14.5px;color:var(--ink);font-weight:800;letter-spacing:-0.2px;margin-top:2px;}
.bp-inv-parties{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;background:#f8fafc;border:1px solid #edf2f7;border-radius:12px;padding:14px 16px;}
.bp-inv-label{font-size:10.5px;text-transform:uppercase;letter-spacing:.6px;color:var(--muted);font-weight:700;}
.bp-inv-val{font-size:13.5px;font-weight:700;color:var(--ink);margin-top:2px;}
.bp-inv-sub-val{font-size:12px;color:var(--muted);margin-top:1px;}
.bp-inv-section-title{font-size:13px;font-weight:700;color:var(--ink);display:flex;align-items:center;gap:7px;margin-bottom:12px;padding-bottom:6px;border-bottom:1px solid var(--border);}
.bp-inv-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px 20px;margin-bottom:18px;}
.bp-inv-item{display:flex;justify-content:space-between;align-items:center;padding:7px 0;border-bottom:1px solid #f8fafc;font-size:13px;}
.bp-inv-item .lbl{color:var(--muted);font-size:12.5px;}
.bp-inv-item .val{font-weight:700;color:var(--ink);text-align:right;}
.bp-inv-table{width:100%;border-collapse:collapse;margin-bottom:14px;}
.bp-inv-table th{font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);font-weight:700;padding:8px 0;border-bottom:1.5px solid var(--border);text-align:left;}
.bp-inv-table td{padding:10px 0;font-size:13px;color:var(--ink);border-bottom:1px solid #f1f5f9;}
.bp-inv-total{display:flex;justify-content:space-between;padding:12px 0 6px;font-size:15px;font-weight:800;color:var(--ink);}
.bp-inv-paid-box{background:var(--teal-bg-soft);border:1px solid var(--teal-badge-border);border-radius:12px;padding:14px 18px;display:flex;justify-content:space-between;align-items:center;margin:16px 0;}
.bp-inv-paid-lbl{font-size:13.5px;font-weight:700;color:var(--primary-teal);}
.bp-inv-paid-sub{font-size:11.5px;color:var(--muted);margin-top:2px;}
.bp-inv-paid-amt{font-size:22px;font-weight:800;color:var(--primary-teal);}
.bp-inv-note{display:flex;align-items:flex-start;gap:8px;background:#f8fafc;border-radius:10px;padding:10px 14px;font-size:11.5px;color:var(--muted);line-height:1.5;margin-bottom:6px;}
.bp-modal-footer{display:flex;gap:12px;padding:14px 28px 24px;}
.bp-modal-btn{flex:1;padding:11px;border-radius:11px;font-size:13.5px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;border:1.5px solid var(--border);color:var(--body-c);background:#ffffff;transition:all .15s;text-decoration:none;}
.bp-modal-btn:hover{border-color:var(--primary-teal);color:var(--primary-teal);background:var(--teal-bg-soft);}
.bp-modal-btn.primary{background:var(--primary-teal);color:#fff;border-color:var(--primary-teal);}
.bp-modal-btn.primary:hover{background:var(--primary-teal-dark);}

@media(max-width:960px){.bp-grid-2{grid-template-columns:1fr;}}
@media(max-width:640px){
    .bp-top-bar{flex-direction:column;align-items:flex-start;gap:12px;}
    .bp-top-actions{width:100%;display:flex;justify-content:space-between;gap:8px;}
    .bp-top-actions .bp-btn-back, .bp-top-actions .bp-btn-refresh{flex:1;justify-content:center;}
    .bp-overview-grid{grid-template-columns:1fr;gap:10px;}
    .bp-actions-row{grid-template-columns:1fr;gap:10px;}
    .bp-inv-parties{grid-template-columns:1fr;gap:12px;padding:12px;}
    .bp-inv-grid{grid-template-columns:1fr;gap:8px;}
    .bp-modal{max-width:100%;margin:8px;max-height:94vh;border-radius:16px;}
    .bp-modal-head{padding:14px 16px;font-size:15px;}
    .bp-modal-body{padding:16px 14px;}
    .bp-modal-footer{flex-direction:column;padding:12px 14px 20px;gap:8px;}
    .bp-modal-btn{width:100%;justify-content:center;}
    .bp-tbl-footer{flex-direction:column;align-items:center;text-align:center;gap:10px;padding:12px 14px;}
    .bp-pagination{flex-wrap:wrap;justify-content:center;}
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
                <div class="pd-mobile-role">Patient Dashboard</div>
            </div>
        </div>
        <button class="pd-menu-toggle" id="pdMenuToggle" aria-label="Open menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
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
                    {{ \Carbon\Carbon::parse(Auth::user()->dob)->format('d M Y') }} &middot; {{ \Carbon\Carbon::parse(Auth::user()->dob)->age }} yrs
                @else
                    Patient Account
                @endif
            </div>
        </div>
        <nav class="pd-drawer-nav">
            <a href="#" onclick="switchSection('dashboard', document.getElementById('nav-dashboard')); closeMobileDrawer(); return false;" class="pd-drawer-nav-item active">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="#" onclick="switchSection('dashboard', document.getElementById('nav-appointments')); closeMobileDrawer(); return false;" class="pd-drawer-nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                My Appointments
            </a>
            <a href="{{ route('home') }}" class="pd-drawer-nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Doctors
            </a>
            <a href="{{ route('home') }}" class="pd-drawer-nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                Packages
            </a>
            <div class="pd-drawer-divider"></div>
            <a href="#" onclick="switchSection('billing', document.getElementById('nav-billing')); closeMobileDrawer(); return false;" class="pd-drawer-nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14H5a1 1 0 01-1-1V4a1 1 0 011-1h11a1 1 0 011 1v1M9 14a1 1 0 001 1h9a1 1 0 001-1v-5a1 1 0 00-1-1h-9a1 1 0 00-1 1v5z"/></svg>
                Billing &amp; Payments
            </a>
            <a href="{{ route('patient.profile') }}" class="pd-drawer-nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                My Documents
            </a>
            <div class="pd-drawer-divider"></div>
            <a href="{{ route('patient.profile') }}" class="pd-drawer-nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Settings
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

            {{-- Profile mini card --}}
            <div class="pd-nav-card" style="padding:16px 14px;display:flex;align-items:center;gap:12px;border-bottom:0;margin-bottom:0;">
                @if($patient->profile_img)
                    <img src="{{ str_contains($patient->profile_img, '/') ? asset($patient->profile_img) : asset('uploads/profile/'.$patient->profile_img) }}"
                         style="width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid var(--teal-badge-border);flex-shrink:0;" alt="{{ $patient->name }}">
                @else
                    <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--primary-teal),var(--primary-teal-sub));display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;font-weight:800;flex-shrink:0;">{{ strtoupper(substr($patient->name,0,1)) }}</div>
                @endif
                <div>
                    <div style="font-size:14px;font-weight:800;color:var(--ink);line-height:1.2;">{{ $patient->name }}</div>
                    <div style="font-size:12px;color:var(--muted);margin-top:2px;font-weight:500;">Patient</div>
                </div>
            </div>

            <div class="pd-nav-card">
                <a href="#" onclick="switchSection('dashboard',this);return false;" class="pd-nav-item active" id="nav-dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    Dashboard
                </a>
                <a href="#" onclick="switchSection('dashboard',this);return false;" class="pd-nav-item" id="nav-appointments">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    My Appointments
                </a>
                <a href="{{ route('home') }}" class="pd-nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Doctors
                </a>
                <a href="{{ route('home') }}" class="pd-nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                    Packages
                </a>
                <div class="pd-nav-divider"></div>
                <a href="#" onclick="switchSection('billing',this);return false;" class="pd-nav-item" id="nav-billing">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14H5a1 1 0 01-1-1V4a1 1 0 011-1h11a1 1 0 011 1v1M9 14a1 1 0 001 1h9a1 1 0 001-1v-5a1 1 0 00-1-1h-9a1 1 0 00-1 1v5z"/></svg>
                    Billing &amp; Payments
                </a>
                <a href="{{ route('patient.profile') }}" class="pd-nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    My Documents
                </a>
                <div class="pd-nav-divider"></div>
                <a href="{{ route('patient.profile') }}" class="pd-nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Settings
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

            {{-- Need Help box --}}
            <div class="pd-nav-card" style="padding:18px 16px;text-align:center;">
                <i class="fas fa-headset" style="font-size:22px;color:var(--primary-teal);margin-bottom:8px;display:block;"></i>
                <div style="font-size:13.5px;font-weight:800;color:var(--ink);margin-bottom:4px;">Need Help?</div>
                <div style="font-size:12px;color:var(--muted);margin-bottom:12px;">Our support team is here for you.</div>
                <a href="mailto:support@physiopii.com" style="display:block;padding:9px;border-radius:10px;background:var(--primary-teal);color:#fff;font-size:13px;font-weight:700;text-decoration:none;text-align:center;transition:background .15s;" onmouseover="this.style.background='#074752'" onmouseout="this.style.background='var(--primary-teal)'">Contact Support</a>
            </div>

        </aside>

        {{-- Main Content --}}
        <main class="pd-main">

            {{-- ═══════ SECTION: DASHBOARD ═══════ --}}
            <div id="sec-dashboard" class="pd-section" style="display:block;">

            <div class="pd-page-header">
                <div>
                    <div class="pd-page-title">My Dashboard</div>
                    <div class="pd-page-sub">Track your appointments and physiotherapy sessions</div>
                </div>
                <div class="pd-date-chip">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ \Carbon\Carbon::now()->format('D, d M Y') }}
                </div>
            </div>

            {{-- Stats --}}
            <div class="pd-stats">
                <div class="pd-stat teal">
                    <div class="pd-stat-icon teal">
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
                <div class="pd-tabs-bar">
                    <button class="pd-tab active" onclick="switchTab('all',this)">All <span class="pd-tab-badge">{{ $appointments->count() }}</span></button>
                    <button class="pd-tab" onclick="switchTab('upcoming',this)">Upcoming <span class="pd-tab-badge">{{ $upcomingAppointments->count() }}</span></button>
                    <button class="pd-tab" onclick="switchTab('completed',this)">Completed <span class="pd-tab-badge">{{ $completedAppointments->count() }}</span></button>
                    <button class="pd-tab" onclick="switchTab('shifted',this)">Shifted <span class="pd-tab-badge">{{ $shiftedAppointments->count() }}</span></button>
                    <button class="pd-tab" onclick="switchTab('cancelled',this)">Cancelled <span class="pd-tab-badge">{{ $cancelledAppointments->count() }}</span></button>
                    <button class="pd-tab" onclick="switchTab('billing',this)">Billing <span class="pd-tab-badge">{{ $payments->count() }}</span></button>
                </div>

                @php
                function buildRow($a) {
                    $rawName = $a->doctor->name ?? '';
                    $cleanName = preg_replace('/^(dr\.?|doctor)\s+/i', '', trim($rawName));
                    $displayDoc = $cleanName !== '' ? 'Dr. ' . $cleanName : '—';
                    return [
                        'id'       => $a->id,
                        'imgSrc'   => $a->doctor->profile_img ? (str_contains($a->doctor->profile_img, '/') ? asset($a->doctor->profile_img) : asset('uploads/profile/'.$a->doctor->profile_img)) : null,
                        'docName'  => $displayDoc,
                        'spec'     => optional(optional($a->doctor->profile)->specializationdata)->name ?? 'Physiotherapist',
                        'date'     => $a->appointment_date ? $a->appointment_date->format('d M Y') : '—',
                        'time'     => $a->start_time ? \Carbon\Carbon::parse($a->start_time)->format('h:i A') : '—',
                        'booked'   => $a->created_at ? $a->created_at->format('d M Y') : '—',
                        'fee'      => '₹'.number_format($a->doctor->fee->doctor_fee ?? 0, 2),
                        'followUp' => ($a->appointment_date && $a->appointment_date->isFuture()) ? $a->appointment_date->copy()->addDays(7)->format('d M Y') : '—',
                        'status'   => $a->status ?? 'pending',
                    ];
                }
                @endphp

                @foreach(['all'=>$appointments,'upcoming'=>$upcomingAppointments,'completed'=>$completedAppointments,'shifted'=>$shiftedAppointments,'cancelled'=>$cancelledAppointments] as $tabId => $collection)
                <div class="pd-tab-content {{ $tabId==='all' ? 'active' : '' }}" id="tab-{{ $tabId }}">

                    {{-- Desktop table --}}
                    <div class="pd-table-wrap">
                        <table class="pd-table">
                            <thead><tr>
                                <th>Doctor</th><th>Appt Date</th><th>Booked On</th>
                                <th>Amount</th><th>Follow Up</th><th>Status</th><th>Action</th>
                            </tr></thead>
                            <tbody>
                                @forelse($collection as $appt)
                                    @php $r = buildRow($appt); @endphp
                                    <tr>
                                        <td>
                                            <div class="pd-doc-cell">
                                                @if($r['imgSrc'])
                                                    <img class="pd-doc-img" src="{{ $r['imgSrc'] }}" alt="{{ $r['docName'] }}">
                                                @else
                                                    <div class="pd-doc-ph">{{ strtoupper(substr(preg_replace('/^Dr\.\s*/','',$r['docName']),0,2)) }}</div>
                                                @endif
                                                <div>
                                                    <div class="pd-doc-name">{{ $r['docName'] }}</div>
                                                    <div class="pd-doc-spec">{{ $r['spec'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pd-date-main">{{ $r['date'] }}</div>
                                            <div class="pd-date-time">{{ $r['time'] }}</div>
                                        </td>
                                        <td style="color:#64748b;font-size:12.5px">{{ $r['booked'] }}</td>
                                        <td style="font-weight:800;color:var(--ink)">{{ $r['fee'] }}</td>
                                        <td style="color:#64748b;font-size:12.5px">{{ $r['followUp'] }}</td>
                                        <td>
                                            <span class="pd-pill {{ $r['status'] }}">
                                                <span class="pd-pill-dot"></span>
                                                {{ ucfirst($r['status']) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('patient.appointments.show',$appt->id) }}" class="pd-view-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="pd-empty">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                <div class="pd-empty-title">No appointments found</div>
                                                <div class="pd-empty-sub">Your appointments for this category will appear here.</div>
                                            </div>
                                        </td>
                                    </tr>
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
                                    @if($r['imgSrc'])
                                        <img class="pd-doc-img" src="{{ $r['imgSrc'] }}" alt="{{ $r['docName'] }}">
                                    @else
                                        <div class="pd-doc-ph">{{ strtoupper(substr(preg_replace('/^Dr\.\s*/','',$r['docName']),0,2)) }}</div>
                                    @endif
                                    <div class="pd-appt-card-info">
                                        <div class="pd-appt-card-name">{{ $r['docName'] }}</div>
                                        <div class="pd-appt-card-spec">{{ $r['spec'] }}</div>
                                    </div>
                                    <span class="pd-pill {{ $r['status'] }}" style="flex-shrink:0">
                                        <span class="pd-pill-dot"></span>
                                        {{ ucfirst($r['status']) }}
                                    </span>
                                </div>
                                <div class="pd-appt-card-meta">
                                    <div class="pd-appt-card-field">
                                        <div class="pd-appt-card-field-lbl">Date</div>
                                        <div class="pd-appt-card-field-val">{{ $r['date'] }}</div>
                                    </div>
                                    <div class="pd-appt-card-field">
                                        <div class="pd-appt-card-field-lbl">Time</div>
                                        <div class="pd-appt-card-field-val" style="color:var(--primary-teal)">{{ $r['time'] }}</div>
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
                                    <span style="font-size:12px;color:#64748b">Follow-up: <b>{{ $r['followUp'] }}</b></span>
                                    <a href="{{ route('patient.appointments.show',$appt->id) }}" class="pd-view-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        View
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="pd-empty">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <div class="pd-empty-title">No appointments found</div>
                                <div class="pd-empty-sub">Your appointments for this category will appear here.</div>
                            </div>
                        @endforelse
                    </div>

                </div>
                @endforeach

                {{-- Billing Tab --}}
                <div class="pd-tab-content" id="tab-billing">
                    <div class="pd-billing-stats">
                        <div class="pd-billing-stat">
                            <div class="pd-billing-stat-icon green">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                            </div>
                            <div>
                                <div class="pd-billing-stat-val">₹{{ number_format($totalPaymentAmount, 2) }}</div>
                                <div class="pd-billing-stat-lbl">Total Paid</div>
                            </div>
                        </div>
                        <div class="pd-billing-stat">
                            <div class="pd-billing-stat-icon teal">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14H5a1 1 0 01-1-1V4a1 1 0 011-1h11a1 1 0 011 1v1M9 14a1 1 0 001 1h9a1 1 0 001-1v-5a1 1 0 00-1-1h-9a1 1 0 00-1 1v5z"/></svg>
                            </div>
                            <div>
                                <div class="pd-billing-stat-val">{{ $payments->count() }}</div>
                                <div class="pd-billing-stat-lbl">Total Invoices</div>
                            </div>
                        </div>
                    </div>

                    {{-- Desktop table --}}
                    <div class="pd-table-wrap">
                        <table class="pd-table">
                            <thead><tr><th>Invoice</th><th>Doctor</th><th>Amount</th><th>Paid On</th><th>Status</th></tr></thead>
                            <tbody>
                                @forelse($payments->take(5) as $payment)
                                    @php
                                        $rawPn = $payment->doctor->name ?? '';
                                        $cleanPn = preg_replace('/^(dr\.?|doctor)\s+/i', '', trim($rawPn));
                                        $pn = $cleanPn !== '' ? 'Dr. ' . $cleanPn : '—';
                                        $pi = $payment->doctor->profile_img ? (str_contains($payment->doctor->profile_img, '/') ? asset($payment->doctor->profile_img) : asset('uploads/profile/'.$payment->doctor->profile_img)) : null;
                                        $ps = $payment->status ?? 'pending';
                                        $psLabel = match(strtolower($ps)) { 'success','paid','completed'=>'Paid','failed','refunded'=>'Failed',default=>'Pending' };
                                        $psCls   = match(strtolower($ps)) { 'success','paid','completed'=>'success','failed','refunded'=>'cancelled',default=>'pending' };
                                        $invNo = '#INV-' . date('Y') . '-' . str_pad($payment->id, 5, '0', STR_PAD_LEFT);
                                        $planName = optional($payment->appointment)->plan->name ?? 'Single Session';
                                        $apptDate = optional(optional($payment->appointment)->appointment_date)->format('d M Y') ?? (optional($payment->paid_at)->format('d M Y') ?? '—');
                                        $apptTime = $payment->appointment && $payment->appointment->start_time ? \Carbon\Carbon::parse($payment->appointment->start_time)->format('h:i A') : (optional($payment->paid_at)->format('h:i A') ?? '—');
                                    @endphp
                                    <tr>
                                        <td>
                                            <a href="#" onclick="openInvoiceModal({
                                                invNo: '{{ $invNo }}',
                                                billTo: '{{ addslashes($patient->name) }}',
                                                billAddress: '{{ addslashes(trim(implode(', ', array_filter([$patient->address ?? null, $patient->city ?? null, $patient->state ?? null])))) }}',
                                                invDate: '{{ optional($payment->paid_at)->format('d M Y') ?? $payment->created_at->format('d M Y') }}',
                                                payDate: '{{ optional($payment->paid_at)->format('d M Y • h:i A') ?? $payment->created_at->format('d M Y • h:i A') }}',
                                                docName: '{{ addslashes($pn) }}',
                                                apptDate: '{{ $apptDate }}',
                                                apptTime: '{{ $apptTime }}',
                                                pkgName: '{{ addslashes($planName) }}',
                                                amount: '{{ number_format($payment->amount, 0) }}'
                                            }); return false;"
                                               style="font-family:monospace;font-size:12.5px;font-weight:700;color:var(--primary-teal);text-decoration:none;">
                                                #INV-{{ str_pad($payment->id,5,'0',STR_PAD_LEFT) }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="pd-doc-cell">
                                                @if($pi)
                                                    <img class="pd-doc-img" src="{{ $pi }}" alt="{{ $pn }}">
                                                @else
                                                    <div class="pd-doc-ph">{{ strtoupper(substr(preg_replace('/^Dr\.\s*/','', $pn),0,2)) }}</div>
                                                @endif
                                                <div>
                                                    <div class="pd-doc-name">{{ $pn }}</div>
                                                    <div class="pd-doc-spec">{{ optional(optional($payment->doctor->profile)->specializationdata)->name ?? 'Physiotherapist' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="font-weight:800;color:var(--ink)">₹{{ number_format($payment->amount,2) }}</td>
                                        <td style="color:#64748b;font-size:12.5px">{{ optional($payment->paid_at)->format('d M Y') ?? $payment->created_at->format('d M Y') }}</td>
                                        <td><span class="pd-pill {{ $psCls }}"><span class="pd-pill-dot"></span>{{ $psLabel }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="pd-empty">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14H5a1 1 0 01-1-1V4a1 1 0 011-1h11a1 1 0 011 1v1M9 14a1 1 0 001 1h9a1 1 0 001-1v-5a1 1 0 00-1-1h-9a1 1 0 00-1 1v5z"/></svg>
                                                <div class="pd-empty-title">No billing history</div>
                                                <div class="pd-empty-sub">Your payment invoices will appear here.</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile billing cards --}}
                    <div class="pd-card-list">
                        @forelse($payments as $payment)
                            @php
                                $rawPn = $payment->doctor->name ?? '';
                                $cleanPn = preg_replace('/^(dr\.?|doctor)\s+/i', '', trim($rawPn));
                                $pn = $cleanPn !== '' ? 'Dr. ' . $cleanPn : '—';
                                $pi = $payment->doctor->profile_img ? (str_contains($payment->doctor->profile_img, '/') ? asset($payment->doctor->profile_img) : asset('uploads/profile/'.$payment->doctor->profile_img)) : null;
                                $ps = $payment->status ?? 'pending';
                            @endphp
                            <div class="pd-bill-card">
                                @if($pi)
                                    <img class="pd-doc-img" src="{{ $pi }}" alt="{{ $pn }}">
                                @else
                                    <div class="pd-doc-ph">{{ strtoupper(substr(preg_replace('/^Dr\.\s*/','',$pn),0,2)) }}</div>
                                @endif
                                <div>
                                    <div class="pd-doc-name">{{ $pn }}</div>
                                    <div style="margin-top:3px"><span class="pd-pill {{ $ps }}"><span class="pd-pill-dot"></span>{{ ucfirst($ps) }}</span></div>
                                </div>
                                <div class="pd-bill-card-right">
                                    <div class="pd-bill-amount">₹{{ number_format($payment->amount,2) }}</div>
                                    <div class="pd-bill-date">{{ optional($payment->paid_at)->format('d M Y') ?? $payment->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="pd-empty">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14H5a1 1 0 01-1-1V4a1 1 0 011-1h11a1 1 0 011 1v1M9 14a1 1 0 001 1h9a1 1 0 001-1v-5a1 1 0 00-1-1h-9a1 1 0 00-1 1v5z"/></svg>
                                <div class="pd-empty-title">No billing history</div>
                            </div>
                        @endforelse
                    </div>

                    {{-- View All link --}}
                    <div style="padding:14px 20px;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                        <span style="font-size:12.5px;color:var(--muted-text);">
                            Showing {{ $payments->take(5)->count() }} of {{ $payments->count() }} records
                        </span>
                        <a href="#" onclick="switchSection('billing', document.getElementById('nav-billing')); return false;"
                           style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:9px;background:var(--primary-teal);color:#fff;font-size:13px;font-weight:700;text-decoration:none;transition:background 0.15s;"
                           onmouseover="this.style.background='#074752'" onmouseout="this.style.background='var(--primary-teal)'">
                            View Full Billing &amp; Payments
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

            </div>{{-- /pd-card --}}

            </div>{{-- /sec-dashboard --}}

            {{-- ═══════ SECTION: BILLING & PAYMENTS ═══════ --}}
            <div id="sec-billing" class="pd-section" style="display:none;">
                <div class="bp-top-bar">
                    <div>
                        <div class="bp-page-title">Billing &amp; Payments</div>
                        <div class="bp-page-sub">Manage your payments, invoices and wallet details</div>
                    </div>
                    <div class="bp-top-actions">
                        <a href="#" onclick="switchSection('dashboard', document.getElementById('nav-dashboard')); return false;" class="bp-btn-back">
                            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
                        </a>
                        <a href="#" onclick="window.location.reload(); return false;" class="bp-btn-refresh">
                            <i class="fa-solid fa-rotate-right"></i> Refresh
                        </a>
                    </div>
                </div>

                <div class="bp-grid-2">
                    {{-- LEFT COLUMN --}}
                    <div style="display:flex;flex-direction:column;gap:20px;min-width:0;">

                        {{-- Payment History Header Card --}}
                        <div class="bp-card">
                            <div class="bp-card-body" style="display:flex;align-items:center;gap:14px;">
                                <div style="width:52px;height:52px;border-radius:12px;background:var(--teal-bg-soft);display:flex;align-items:center;justify-content:center;font-size:22px;color:var(--primary-teal);flex-shrink:0;">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </div>
                                <div>
                                    <div style="font-size:17px;font-weight:800;color:var(--ink);">Payment History</div>
                                    <div style="font-size:12.5px;color:var(--muted);margin-top:2px;">Track your invoices, session payments and wallet details</div>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Overview --}}
                        <div class="bp-card">
                            <div class="bp-card-head">
                                <div class="bp-card-head-icon"><i class="fa-solid fa-chart-pie"></i></div>
                                <div><h3>Payment Overview</h3></div>
                            </div>
                            <div class="bp-card-body">
                                <div class="bp-overview-grid">
                                    <div class="bp-ov-box">
                                        <div class="bp-ov-label">Total Spent</div>
                                        <div class="bp-ov-val">₹{{ number_format($totalSpent, 0) }}</div>
                                        <div class="bp-ov-sub">Across {{ $totalSessions }} sessions</div>
                                    </div>
                                    <div class="bp-ov-box pending">
                                        <div class="bp-ov-label">Unpaid Amount</div>
                                        <div class="bp-ov-val">₹{{ number_format($unpaidAmount, 0) }}</div>
                                        <div class="bp-ov-sub">Pending payment</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Transaction History --}}
                        <div class="bp-card">
                            <div class="bp-card-head" style="justify-content:space-between;">
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div class="bp-card-head-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                                    <div><h3>Transaction History</h3></div>
                                </div>
                                <span style="font-size:12px;color:var(--muted);background:#f1f5f9;padding:5px 12px;border-radius:8px;border:1px solid var(--border);display:flex;align-items:center;gap:5px;">
                                    <i class="fa-solid fa-filter" style="color:var(--primary-teal);font-size:11px;"></i> {{ $payments->count() }} records
                                </span>
                            </div>

                            @if($payments->isEmpty())
                                <div class="bp-empty">
                                    <i class="fa-solid fa-receipt"></i>
                                    <h4>No Transactions Yet</h4>
                                    <p>Your payment history will appear here once you book an appointment.</p>
                                </div>
                            @else
                                <div class="bp-table-wrap">
                                    <table class="bp-table">
                                        <thead>
                                            <tr>
                                                <th>Doctor / Service</th>
                                                <th>Date &amp; Time</th>
                                                <th>Transaction ID</th>
                                                <th>Payment Method</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="bpTableBody">
                                            @foreach($payments as $pay)
                                                @php
                                                    $doc      = $pay->doctor;
                                                    $rawName  = $doc->name ?? 'Doctor';
                                                    $clean    = preg_replace('/^(dr\.?|doctor)\s+/i', '', trim($rawName));
                                                    $docName  = 'Dr. ' . $clean;
                                                    $specName = optional(optional(optional($doc)->profile)->specializationdata)->name ?? 'Physiotherapy';
                                                    $docInit  = strtoupper(substr($clean, 0, 1) ?: 'D');
                                                    $payDate  = $pay->paid_at ?? $pay->created_at;
                                                    $method   = strtoupper($pay->payment_method ?? 'UPI');
                                                    $statusCls = match(strtolower($pay->status ?? 'pending')) {
                                                        'success','paid','completed' => 'paid',
                                                        'failed','refunded'          => 'failed',
                                                        default                      => 'pending',
                                                    };
                                                    $statusLabel = match($statusCls) { 'paid'=>'Paid','failed'=>'Failed',default=>'Pending' };
                                                    $txnId = $pay->transaction_id ?? ('TXN'.str_pad($pay->id, 10,'0',STR_PAD_LEFT));
                                                    $invNo = '#INV-' . date('Y') . '-' . str_pad($pay->id, 5, '0', STR_PAD_LEFT);
                                                    $planName = optional($pay->appointment)->plan->name ?? 'Single Session';
                                                    $apptDate = optional(optional($pay->appointment)->appointment_date)->format('d M Y') ?? ($payDate?->format('d M Y') ?? '—');
                                                    $apptTime = $pay->appointment && $pay->appointment->start_time ? \Carbon\Carbon::parse($pay->appointment->start_time)->format('h:i A') : ($payDate?->format('h:i A') ?? '—');
                                                @endphp
                                                <tr class="bp-txn-row">
                                                    <td>
                                                        <div class="bp-doc-cell">
                                                            <div class="bp-doc-avatar">{{ $docInit }}</div>
                                                            <div>
                                                                <div class="bp-doc-name">{{ $docName }}</div>
                                                                <div class="bp-doc-spec">{{ $specName }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div style="font-size:12.5px;font-weight:600;color:var(--ink);">{{ $payDate?->format('d M Y') ?? '—' }}</div>
                                                        <div style="font-size:11px;color:var(--muted);">{{ $payDate?->format('h:i A') ?? '' }}</div>
                                                    </td>
                                                    <td><span class="bp-txn-id">{{ $txnId }}</span></td>
                                                    <td>
                                                        <span class="bp-method-pill">
                                                            <i class="fa-solid fa-mobile-screen-button" style="font-size:11px;color:var(--primary-teal);"></i>
                                                            {{ $method }}
                                                        </span>
                                                    </td>
                                                    <td><span class="bp-status-pill {{ $statusCls }}">{{ $statusLabel }}</span></td>
                                                    <td><div class="bp-amount-cell">₹{{ number_format($pay->amount, 0) }}</div></td>
                                                    <td>
                                                        <button type="button" class="bp-tbl-btn" title="View Invoice"
                                                                onclick="openInvoiceModal({
                                                                    invNo: '{{ $invNo }}',
                                                                    billTo: '{{ addslashes($patient->name) }}',
                                                                    billAddress: '{{ addslashes(trim(implode(', ', array_filter([$patient->address ?? null, $patient->city ?? null, $patient->state ?? null])))) }}',
                                                                    invDate: '{{ $payDate?->format('d M Y') ?? '—' }}',
                                                                    payDate: '{{ $payDate?->format('d M Y • h:i A') ?? '—' }}',
                                                                    docName: '{{ addslashes($docName) }}',
                                                                    apptDate: '{{ $apptDate }}',
                                                                    apptTime: '{{ $apptTime }}',
                                                                    pkgName: '{{ addslashes($planName) }}',
                                                                    amount: '{{ number_format($pay->amount, 0) }}'
                                                                })">
                                                            <i class="fa-solid fa-chevron-right" style="font-size:11px;"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Mobile Card List for Transactions --}}
                                <div class="bp-card-list" id="bpCardList">
                                    @foreach($payments as $pay)
                                        @php
                                            $doc      = $pay->doctor;
                                            $rawName  = $doc->name ?? 'Doctor';
                                            $clean    = preg_replace('/^(dr\.?|doctor)\s+/i', '', trim($rawName));
                                            $docName  = 'Dr. ' . $clean;
                                            $specName = optional(optional(optional($doc)->profile)->specializationdata)->name ?? 'Physiotherapy';
                                            $docInit  = strtoupper(substr($clean, 0, 1) ?: 'D');
                                            $payDate  = $pay->paid_at ?? $pay->created_at;
                                            $method   = strtoupper($pay->payment_method ?? 'UPI');
                                            $statusCls = match(strtolower($pay->status ?? 'pending')) {
                                                'success','paid','completed' => 'paid',
                                                'failed','refunded'          => 'failed',
                                                default                      => 'pending',
                                            };
                                            $statusLabel = match($statusCls) { 'paid'=>'Paid','failed'=>'Failed',default=>'Pending' };
                                            $txnId = $pay->transaction_id ?? ('TXN'.str_pad($pay->id, 10,'0',STR_PAD_LEFT));
                                            $invNo = '#INV-' . date('Y') . '-' . str_pad($pay->id, 5, '0', STR_PAD_LEFT);
                                            $planName = optional($pay->appointment)->plan->name ?? 'Single Session';
                                            $apptDate = optional(optional($pay->appointment)->appointment_date)->format('d M Y') ?? ($payDate?->format('d M Y') ?? '—');
                                            $apptTime = $pay->appointment && $pay->appointment->start_time ? \Carbon\Carbon::parse($pay->appointment->start_time)->format('h:i A') : ($payDate?->format('h:i A') ?? '—');
                                        @endphp
                                        <div class="bp-txn-mobile-card">
                                            <div class="bp-tmc-top">
                                                <div class="bp-tmc-doc">
                                                    <div class="bp-doc-avatar">{{ $docInit }}</div>
                                                    <div style="min-width:0;">
                                                        <div class="bp-doc-name">{{ $docName }}</div>
                                                        <div class="bp-doc-spec">{{ $specName }}</div>
                                                    </div>
                                                </div>
                                                <span class="bp-status-pill {{ $statusCls }}">{{ $statusLabel }}</span>
                                            </div>
                                            <div class="bp-tmc-grid">
                                                <div class="bp-tmc-field">
                                                    <div class="bp-tmc-lbl">Date &amp; Time</div>
                                                    <div class="bp-tmc-val">{{ $payDate?->format('d M Y') }} • {{ $payDate?->format('h:i A') }}</div>
                                                </div>
                                                <div class="bp-tmc-field">
                                                    <div class="bp-tmc-lbl">Amount</div>
                                                    <div class="bp-tmc-val" style="font-size:13.5px;font-weight:900;color:var(--primary-teal);">₹{{ number_format($pay->amount, 0) }}</div>
                                                </div>
                                                <div class="bp-tmc-field">
                                                    <div class="bp-tmc-lbl">Txn ID</div>
                                                    <div class="bp-tmc-val" style="font-family:monospace;font-size:11px;">{{ $txnId }}</div>
                                                </div>
                                                <div class="bp-tmc-field">
                                                    <div class="bp-tmc-lbl">Payment Method</div>
                                                    <div class="bp-tmc-val">
                                                        <span class="bp-method-pill" style="padding:2px 7px;font-size:10.5px;">
                                                            <i class="fa-solid fa-mobile-screen-button" style="font-size:10px;color:var(--primary-teal);"></i>
                                                            {{ $method }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bp-tmc-footer">
                                                <button type="button" class="bp-btn-view-invoice"
                                                        onclick="openInvoiceModal({
                                                            invNo: '{{ $invNo }}',
                                                            billTo: '{{ addslashes($patient->name) }}',
                                                            billAddress: '{{ addslashes(trim(implode(', ', array_filter([$patient->address ?? null, $patient->city ?? null, $patient->state ?? null])))) }}',
                                                            invDate: '{{ $payDate?->format('d M Y') ?? '—' }}',
                                                            payDate: '{{ $payDate?->format('d M Y • h:i A') ?? '—' }}',
                                                            docName: '{{ addslashes($docName) }}',
                                                            apptDate: '{{ $apptDate }}',
                                                            apptTime: '{{ $apptTime }}',
                                                            pkgName: '{{ addslashes($planName) }}',
                                                            amount: '{{ number_format($pay->amount, 0) }}'
                                                        })">
                                                    <i class="fa-solid fa-file-invoice" style="margin-right:4px;"></i> View &amp; Download Invoice
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="bp-tbl-footer" id="bpPaginationFooter">
                                    <div class="bp-page-info" id="bpPageInfo">Showing 1–6 of {{ $payments->count() }} transactions</div>
                                    <div class="bp-pagination" id="bpPaginationBtns"></div>
                                </div>
                            @endif
                        </div>

                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div style="display:flex;flex-direction:column;gap:16px;">
                        <div class="bp-wallet-card">
                            <div class="bp-wallet-head">
                                <div class="bp-wallet-icon"><i class="fa-solid fa-wallet"></i></div>
                                <div>
                                    <div class="bp-wallet-title">PhysioPii Wallet</div>
                                    <div class="bp-wallet-sub">Secure | Simple | Convenient</div>
                                </div>
                            </div>
                            <div class="bp-wallet-bal-lbl">Wallet Balance</div>
                            <div class="bp-wallet-bal">₹{{ number_format($totalSpent, 0) }}</div>
                            <button class="bp-wallet-add" type="button"><i class="fa-solid fa-plus"></i> Add Money</button>
                            <div class="bp-wallet-features">
                                <div class="bp-wallet-feat">
                                    <i class="fa-solid fa-shield-halved"></i>
                                    <div><strong style="font-size:12px;">Fast &amp; Secure Payments</strong><br><span style="font-size:10.5px;opacity:.7;">100% Encrypted</span></div>
                                </div>
                                <div class="bp-wallet-feat">
                                    <i class="fa-solid fa-rotate-left"></i>
                                    <div><strong style="font-size:12px;">Easy Refunds</strong><br><span style="font-size:10.5px;opacity:.7;">Hassle-free process</span></div>
                                </div>
                                <div class="bp-wallet-feat">
                                    <i class="fa-solid fa-bookmark"></i>
                                    <div><strong style="font-size:12px;">Use for Future Bookings</strong><br><span style="font-size:10.5px;opacity:.7;">Seamless experience</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="bp-assist-card">
                            <div class="bp-assist-icon"><i class="fa-solid fa-headset"></i></div>
                            <div class="bp-assist-title">Need Assistance?</div>
                            <div class="bp-assist-sub">Facing any issues with payments? Our support team is here to help.</div>
                            <a href="mailto:support@physiopii.com" class="bp-assist-btn">Contact Support</a>
                        </div>
                    </div>

                </div>
            </div>{{-- /sec-billing --}}

        </main>
    </div>
</div>

{{-- INVOICE MODAL (Populated via JS) --}}
<div class="bp-modal-overlay hidden" id="invoiceOverlay" onclick="if(event.target===this)closeInvoice()">
    <div class="bp-modal" onclick="event.stopPropagation()">
        <div class="bp-modal-head">
            <span>Transaction Invoice</span>
            <button type="button" class="bp-modal-close" onclick="closeInvoice()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="bp-modal-body">
            <div class="bp-inv-brand">
                <img src="{{ asset('logo.png') }}" alt="PhysioPii" class="bp-inv-logo">
                <div class="bp-inv-num">TAX INVOICE<span id="invModalNum">#INV-2026-00000</span></div>
            </div>
            <div class="bp-inv-parties">
                <div>
                    <div class="bp-inv-label">Bill To</div>
                    <div class="bp-inv-val" id="invModalBillTo">{{ $patient->name }}</div>
                    <div class="bp-inv-sub-val" id="invModalBillAddr">—</div>
                </div>
                <div style="text-align:right;">
                    <div class="bp-inv-label">Invoice Date</div>
                    <div class="bp-inv-val" id="invModalInvDate">—</div>
                    <div class="bp-inv-label" style="margin-top:8px;">Payment Date</div>
                    <div class="bp-inv-val" id="invModalPayDate">—</div>
                </div>
            </div>
            <div class="bp-inv-section-title"><i class="fa-solid fa-file-lines" style="color:var(--primary-teal);"></i> Invoice Details</div>
            <div class="bp-inv-grid">
                <div class="bp-inv-item"><span class="lbl">Doctor Name</span><span class="val" id="invModalDocName">—</span></div>
                <div class="bp-inv-item"><span class="lbl">Package</span><span class="val" id="invModalPkgName">Single Session</span></div>
                <div class="bp-inv-item"><span class="lbl">Appointment Date</span><span class="val" id="invModalApptDate">—</span></div>
                <div class="bp-inv-item"><span class="lbl">Start Time</span><span class="val" id="invModalApptTime">—</span></div>
            </div>

            <div class="bp-inv-section-title"><i class="fa-solid fa-list" style="color:var(--primary-teal);"></i> Description &amp; Amount</div>
            <table class="bp-inv-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th style="text-align:right;">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="invModalDesc">Session Fee</td>
                        <td style="text-align:right;font-weight:700;" id="invModalFee">₹0</td>
                    </tr>
                    <tr>
                        <td>Convenience Fee</td>
                        <td style="text-align:right;font-weight:700;">₹0</td>
                    </tr>
                </tbody>
            </table>

            <div class="bp-inv-total"><span>Total Amount</span><span id="invModalTotal">₹0</span></div>
            <div class="bp-inv-paid-box">
                <div>
                    <div class="bp-inv-paid-lbl">Amount Paid</div>
                    <div class="bp-inv-paid-sub">You have paid this amount.</div>
                </div>
                <div class="bp-inv-paid-amt" id="invModalPaidAmt">₹0</div>
            </div>
            <div class="bp-inv-note">
                <i class="fa-solid fa-circle-info" style="color:var(--primary-teal);margin-top:2px;flex-shrink:0;"></i>
                This is a computer generated invoice and does not require a physical signature.
            </div>
        </div>
        <div class="bp-modal-footer">
            <button type="button" class="bp-modal-btn" onclick="window.print()"><i class="fa-solid fa-download"></i> Download Invoice</button>
            <button type="button" class="bp-modal-btn primary" onclick="closeInvoice()"><i class="fa-solid fa-arrow-left"></i> Back to Billing</button>
        </div>
    </div>
</div>

<script>
// ── Section switching (sidebar nav) ──
function switchSection(sectionId, clickedItem) {
    document.querySelectorAll('.pd-section').forEach(s => s.style.display = 'none');
    document.querySelectorAll('.pd-nav-item').forEach(n => n.classList.remove('active'));
    document.querySelectorAll('.pd-drawer-nav-item').forEach(n => n.classList.remove('active'));

    const sec = document.getElementById('sec-' + sectionId);
    if (sec) sec.style.display = 'block';
    if (sectionId === 'billing') renderBpPagination();

    if (clickedItem) {
        clickedItem.classList.add('active');
        if (clickedItem.id === 'nav-appointments') {
            document.getElementById('nav-dashboard')?.classList.remove('active');
        }
    } else {
        if (sectionId === 'dashboard') {
            document.getElementById('nav-dashboard')?.classList.add('active');
        } else if (sectionId === 'billing') {
            document.getElementById('nav-billing')?.classList.add('active');
        }
    }
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ── Appointment tab switching ──
function switchTab(tabId, btn) {
    if (tabId === 'billing') {
        switchSection('billing', document.getElementById('nav-billing'));
        return;
    }
    document.querySelectorAll('.pd-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.pd-tab-content').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    const target = document.getElementById('tab-' + tabId);
    if(target) target.classList.add('active');
}

// ── Invoice Modal ──
function openInvoiceModal(data) {
    document.getElementById('invModalNum').textContent = data.invNo || '';
    document.getElementById('invModalBillTo').textContent = data.billTo || '';
    document.getElementById('invModalBillAddr').textContent = data.billAddress || '—';
    document.getElementById('invModalInvDate').textContent = data.invDate || '—';
    document.getElementById('invModalPayDate').textContent = data.payDate || '—';
    document.getElementById('invModalDocName').textContent = data.docName || '—';
    document.getElementById('invModalApptDate').textContent = data.apptDate || '—';
    document.getElementById('invModalApptTime').textContent = data.apptTime || '—';
    document.getElementById('invModalPkgName').textContent = data.pkgName || 'Single Session';
    document.getElementById('invModalDesc').textContent = data.pkgName || 'Session Fee';
    document.getElementById('invModalFee').textContent = '₹' + data.amount;
    document.getElementById('invModalTotal').textContent = '₹' + data.amount;
    document.getElementById('invModalPaidAmt').textContent = '₹' + data.amount;
    document.getElementById('invoiceOverlay').classList.remove('hidden');
}

function closeInvoice() {
    document.getElementById('invoiceOverlay').classList.add('hidden');
}

// ── Billing Table Pagination ──
const BP_PER_PAGE = 6;
let bpCurrentPage = 1;

function renderBpPagination() {
    const rows = document.querySelectorAll('#bpTableBody tr.bp-txn-row');
    const cards = document.querySelectorAll('#bpCardList .bp-txn-mobile-card');
    const totalItems = Math.max(rows.length, cards.length);
    if (totalItems === 0) return;

    const totalPages = Math.ceil(totalItems / BP_PER_PAGE);
    if (bpCurrentPage > totalPages) bpCurrentPage = totalPages;
    if (bpCurrentPage < 1) bpCurrentPage = 1;

    const start = (bpCurrentPage - 1) * BP_PER_PAGE;
    const end = start + BP_PER_PAGE;

    rows.forEach((row, idx) => {
        row.style.display = (idx >= start && idx < end) ? '' : 'none';
    });

    cards.forEach((card, idx) => {
        card.style.display = (idx >= start && idx < end) ? 'flex' : 'none';
    });

    const infoEl = document.getElementById('bpPageInfo');
    if (infoEl) {
        const showingStart = totalItems > 0 ? start + 1 : 0;
        const showingEnd = Math.min(end, totalItems);
        infoEl.textContent = `Showing ${showingStart}–${showingEnd} of ${totalItems} transactions`;
    }

    const btnsEl = document.getElementById('bpPaginationBtns');
    if (btnsEl) {
        if (totalPages <= 1) {
            btnsEl.innerHTML = '';
            return;
        }
        let html = '';
        html += `<button type="button" onclick="setBpPage(${bpCurrentPage - 1})" ${bpCurrentPage === 1 ? 'disabled' : ''} aria-label="Previous Page"><i class="fa-solid fa-chevron-left" style="font-size:11px;"></i></button>`;

        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= bpCurrentPage - 1 && i <= bpCurrentPage + 1)) {
                html += `<button type="button" onclick="setBpPage(${i})" class="${i === bpCurrentPage ? 'active' : ''}">${i}</button>`;
            } else if (i === bpCurrentPage - 2 || i === bpCurrentPage + 2) {
                html += `<span style="border:none;cursor:default;background:transparent;display:flex;align-items:center;justify-content:center;min-width:24px;">...</span>`;
            }
        }

        html += `<button type="button" onclick="setBpPage(${bpCurrentPage + 1})" ${bpCurrentPage === totalPages ? 'disabled' : ''} aria-label="Next Page"><i class="fa-solid fa-chevron-right" style="font-size:11px;"></i></button>`;
        btnsEl.innerHTML = html;
    }
}

function setBpPage(page) {
    bpCurrentPage = page;
    renderBpPagination();
}

// ── Mobile drawer ──
function closeMobileDrawer() {
    const drawer  = document.getElementById('pdDrawer');
    const overlay = document.getElementById('pdDrawerOverlay');
    if (drawer) drawer.classList.remove('open');
    if (overlay) overlay.classList.remove('open');
    document.body.style.overflow = '';
}

(function(){
    const toggle  = document.getElementById('pdMenuToggle');
    const drawer  = document.getElementById('pdDrawer');
    const overlay = document.getElementById('pdDrawerOverlay');
    const close   = document.getElementById('pdDrawerClose');
    function open()  { drawer.classList.add('open'); overlay.classList.add('open'); document.body.style.overflow='hidden'; }
    function shut()  { closeMobileDrawer(); }
    if(toggle)  toggle.addEventListener('click', open);
    if(close)   close.addEventListener('click', shut);
    if(overlay) overlay.addEventListener('click', shut);

    // Initial render of billing pagination
    renderBpPagination();
})();
</script>

@endsection