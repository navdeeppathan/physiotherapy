@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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
}
a { text-decoration: none; color: inherit; }
ul { list-style: none; }

/* ─────────────────────────────────────────────
   PAGE SHELL
───────────────────────────────────────────── */
.pd-page { min-height: 100vh; display: flex; flex-direction: column; background: var(--bg); }

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

.pd-appt-card-top { display: flex; align-items: center; gap: 12px; }
.pd-appt-card-info { flex: 1; min-width: 0; }
.pd-appt-card-name { font-size: 14.5px; font-weight: 800; color: var(--ink); }
.pd-appt-card-spec { font-size: 12px; color: #64748b; margin-top: 2px; }

.pd-appt-card-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.pd-appt-card-field { background: #f8fafc; border: 1px solid var(--border-light); border-radius: 10px; padding: 9px 12px; }
.pd-appt-card-field-lbl { font-size: 10.5px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 3px; }
.pd-appt-card-field-val { font-size: 13px; font-weight: 700; color: var(--ink); }

.pd-appt-card-actions { display: flex; align-items: center; justify-content: space-between; }

/* Billing mobile card */
.pd-bill-card {
    padding: 15px 18px; border-bottom: 1px solid var(--border-light);
    display: flex; align-items: center; gap: 12px;
}
.pd-bill-card:last-child { border-bottom: none; }
.pd-bill-card-right { margin-left: auto; text-align: right; }
.pd-bill-amount { font-size: 15.5px; font-weight: 900; color: var(--ink); }
.pd-bill-date { font-size: 11.5px; color: var(--muted); margin-top: 2px; }

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
        grid-template-columns: 1fr;
        padding: 14px 14px 44px;
        gap: 14px;
    }

    /* Stats on mobile */
    .pd-stats { grid-template-columns: repeat(3,1fr); gap: 8px; }
    .pd-stat { padding: 14px 10px; flex-direction: column; align-items: flex-start; gap: 8px; border-radius: 16px; }
    .pd-stat-icon { width: 38px; height: 38px; border-radius: 11px; }
    .pd-stat-icon svg { width: 17px; height: 17px; }
    .pd-stat-val { font-size: 20px; }
    .pd-stat-lbl { font-size: 11px; }

    /* Page header */
    .pd-page-title { font-size: 19px; }
    .pd-date-chip { display: none; }

    /* Tabs */
    .pd-tabs-bar { padding: 10px 12px 0; }
    .pd-tab { font-size: 12.5px; padding: 8px 12px; }

    /* Hide table, show card list */
    .pd-table-wrap { display: none; }
    .pd-card-list { display: flex; }

    /* Billing stats */
    .pd-billing-stats { grid-template-columns: 1fr 1fr; padding: 14px; gap: 10px; }
    .pd-billing-stat { padding: 12px 14px; }
    .pd-billing-stat-val { font-size: 18px; }
}

@media (max-width: 480px) {
    .pd-stats { grid-template-columns: repeat(3,1fr); gap: 6px; }
    .pd-stat { padding: 12px 8px; }
    .pd-stat-val { font-size: 18px; }
    .pd-stat-lbl { font-size: 10px; }
    .pd-billing-stats { grid-template-columns: 1fr; }
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
                                    @endphp
                                    <tr>
                                        <td>
                                            <a href="{{ route('patient.billing.payments') }}?invoice={{ $payment->id }}"
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
                        <a href="{{ route('patient.billing.payments') }}"
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
                <div class="pd-page-header">
                    <div>
                        <div class="pd-page-title">Billing &amp; Payments</div>
                        <div class="pd-page-sub">Manage your payments, invoices and wallet details</div>
                    </div>
                    <div class="pd-date-chip">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14H5a1 1 0 01-1-1V4a1 1 0 011-1h11a1 1 0 011 1v1M9 14a1 1 0 001 1h9a1 1 0 001-1v-5a1 1 0 00-1-1h-9a1 1 0 00-1 1v5z"/></svg>
                        Payment Records
                    </div>
                </div>

                {{-- Overview Stats --}}
                <div class="pd-stats" style="grid-template-columns:1fr 1fr 1fr;">
                    <div class="pd-stat teal">
                        <div class="pd-stat-icon teal">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                        </div>
                        <div>
                            <div class="pd-stat-val">₹{{ number_format($totalPaymentAmount, 0) }}</div>
                            <div class="pd-stat-lbl">Total Paid</div>
                        </div>
                    </div>
                    <div class="pd-stat" style="--stat-accent:#f59e0b;--stat-bg:#fef3c7;--stat-border:#fde68a;">
                        <div class="pd-stat-icon" style="background:#fef3c7;border:1px solid #fde68a;color:#f59e0b;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="pd-stat-val" style="color:#d97706;">₹{{ number_format($unpaidAmount, 0) }}</div>
                            <div class="pd-stat-lbl">Unpaid</div>
                        </div>
                    </div>
                    <div class="pd-stat green">
                        <div class="pd-stat-icon green">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14H5a1 1 0 01-1-1V4a1 1 0 011-1h11a1 1 0 011 1v1M9 14a1 1 0 001 1h9a1 1 0 001-1v-5a1 1 0 00-1-1h-9a1 1 0 00-1 1v5z"/></svg>
                        </div>
                        <div>
                            <div class="pd-stat-val">{{ $payments->count() }}</div>
                            <div class="pd-stat-lbl">Total Invoices</div>
                        </div>
                    </div>
                </div>

                {{-- Transaction Table --}}
                <div class="pd-card">
                    <div class="pd-billing-stats" style="padding:0;display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid #f1f5f9;">
                        <div style="font-size:15px;font-weight:800;color:var(--ink);display:flex;align-items:center;gap:8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;color:var(--primary-teal);"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Transaction History
                        </div>
                        <span style="font-size:12px;color:var(--muted);background:#f1f5f9;padding:5px 12px;border-radius:8px;">{{ $payments->count() }} records</span>
                    </div>
                    <div class="pd-table-wrap">
                        <table class="pd-table">
                            <thead><tr><th>Invoice</th><th>Doctor</th><th>Amount</th><th>Paid On</th><th>Status</th></tr></thead>
                            <tbody>
                                @forelse($payments->take(10) as $payment)
                                    @php
                                        $rawPn = $payment->doctor->name ?? '';
                                        $cleanPn = preg_replace('/^(dr\.?|doctor)\s+/i', '', trim($rawPn));
                                        $pn = $cleanPn !== '' ? 'Dr. ' . $cleanPn : '—';
                                        $pi = $payment->doctor->profile_img ? (str_contains($payment->doctor->profile_img, '/') ? asset($payment->doctor->profile_img) : asset('uploads/profile/'.$payment->doctor->profile_img)) : null;
                                        $ps = $payment->status ?? 'pending';
                                        $psLabel = match(strtolower($ps)) { 'success','paid','completed'=>'Paid','failed','refunded'=>'Failed',default=>'Pending' };
                                        $psCls   = match(strtolower($ps)) { 'success','paid','completed'=>'success','failed','refunded'=>'cancelled',default=>'pending' };
                                    @endphp
                                    <tr>
                                        <td>
                                            <span style="font-family:monospace;font-size:12.5px;font-weight:700;color:var(--primary-teal);">
                                                #INV-{{ str_pad($payment->id,5,'0',STR_PAD_LEFT) }}
                                            </span>
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
                </div>
            </div>{{-- /sec-billing --}}

        </main>
    </div>
</div>

<script>
// ── Section switching (sidebar nav) ──
function switchSection(sectionId, clickedItem) {
    // Hide all sections
    document.querySelectorAll('.pd-section').forEach(s => s.style.display = 'none');
    // Deactivate all nav items that are in the sidebar nav
    document.querySelectorAll('.pd-nav-item').forEach(n => n.classList.remove('active'));
    // Show selected section
    const sec = document.getElementById('sec-' + sectionId);
    if (sec) sec.style.display = 'block';
    // Activate the clicked item (and matching sibling for Dashboard/My Appointments)
    if (clickedItem) {
        clickedItem.classList.add('active');
        // If clicking My Appointments, also activate Dashboard nav
        if (clickedItem.id === 'nav-appointments') {
            document.getElementById('nav-dashboard')?.classList.remove('active');
        }
    }
    // Scroll top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ── Appointment tab switching ──
function switchTab(tabId, btn) {
    document.querySelectorAll('.pd-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.pd-tab-content').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    const target = document.getElementById('tab-' + tabId);
    if(target) target.classList.add('active');
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