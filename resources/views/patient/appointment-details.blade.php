@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
    --primary-teal: #0c6978;
    --primary-teal-dark: #074752;
    --primary-teal-sub: #108598;
    --teal-soft-bg: #e6f6f8;
    --teal-badge-border: #bce5ea;
    --ink: #0f172a;
    --ink-light: #1e293b;
    --muted: #64748b;
    --muted-light: #94a3b8;
    --border: #e2e8f0;
    --border-light: #f1f5f9;
    --bg-page: #f8fafc;
    --white: #ffffff;
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
    --shadow-card: 0 2px 12px rgba(15, 23, 42, 0.04);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-page); color: var(--ink); }

/* Modal z-index fix */
.modal-backdrop { z-index: 99998 !important; }
.modal { z-index: 99999 !important; }

/* Page Layout */
.ad-page-container {
    max-width: 1260px;
    margin: 0 auto;
    padding: 32px 24px 64px;
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 36px;
    align-items: start;
}

/* ─────────────────────────────────────────────
   SIDEBAR
───────────────────────────────────────────── */
.ad-sidebar {
    display: flex;
    flex-direction: column;
    gap: 28px;
    position: sticky;
    top: 90px;
}

.ad-nav-list {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.ad-nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 16px;
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: 600;
    color: #475569;
    text-decoration: none;
    transition: all .15s ease;
}

.ad-nav-item:hover {
    background: var(--border-light);
    color: var(--primary-teal);
}

.ad-nav-item.active {
    background: var(--teal-soft-bg);
    color: var(--primary-teal);
    font-weight: 700;
}

.ad-nav-item i {
    font-size: 16px;
    width: 18px;
    text-align: center;
}

.ad-nav-badge {
    margin-left: auto;
    background: #ef4444;
    color: #ffffff;
    font-size: 11px;
    font-weight: 800;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Need Help Card */
.ad-help-card {
    background: #f0f9fb;
    border: 1px solid #d1edf2;
    border-radius: var(--radius-lg);
    padding: 22px 18px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.ad-help-icon-wrap {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #ddf4f7;
    color: var(--primary-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 12px;
}

.ad-help-title {
    font-size: 14px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 4px;
}

.ad-help-desc {
    font-size: 12px;
    color: var(--muted);
    line-height: 1.4;
    margin-bottom: 14px;
}

.ad-help-btn {
    display: inline-block;
    width: 100%;
    padding: 8px 12px;
    background: var(--white);
    border: 1.5px solid var(--primary-teal);
    border-radius: var(--radius-sm);
    color: var(--primary-teal);
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    text-align: center;
    transition: all .15s ease;
}

.ad-help-btn:hover {
    background: var(--primary-teal);
    color: var(--white);
}

/* ─────────────────────────────────────────────
   MAIN DETAILS AREA
───────────────────────────────────────────── */
.ad-main-content {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

/* Header & Breadcrumb */
.ad-top-header {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 4px;
}

.ad-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
}

.ad-breadcrumb a {
    color: var(--muted);
    text-decoration: none;
}

.ad-breadcrumb a:hover {
    color: var(--primary-teal);
}

.ad-breadcrumb .sep {
    font-size: 10px;
    color: var(--muted-light);
}

.ad-breadcrumb .active {
    color: var(--muted);
}

.ad-title-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.ad-page-title {
    font-size: 24px;
    font-weight: 900;
    color: #0d1b2a;
    letter-spacing: -0.02em;
}

.ad-kebab-btn {
    background: transparent;
    border: none;
    color: #475569;
    font-size: 18px;
    cursor: pointer;
    padding: 6px;
    border-radius: 6px;
    transition: background .15s;
}

.ad-kebab-btn:hover {
    background: var(--border-light);
    color: var(--ink);
}

/* Alert Banner */
.ad-alert-banner {
    border-radius: var(--radius-lg);
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
}

.ad-alert-banner.completed {
    background: #ecfdf5;
    border: 1px solid #bbf7d0;
}

.ad-alert-banner.upcoming {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
}

.ad-alert-banner.cancelled {
    background: #fef2f2;
    border: 1px solid #fecaca;
}

.ad-alert-icon {
    font-size: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ad-alert-banner.completed .ad-alert-icon { color: #16a34a; }
.ad-alert-banner.upcoming .ad-alert-icon { color: #2563eb; }
.ad-alert-banner.cancelled .ad-alert-icon { color: #dc2626; }

.ad-alert-title {
    font-size: 15.5px;
    font-weight: 800;
    line-height: 1.3;
}

.ad-alert-banner.completed .ad-alert-title { color: #15803d; }
.ad-alert-banner.upcoming .ad-alert-title { color: #1d4ed8; }
.ad-alert-banner.cancelled .ad-alert-title { color: #b91c1c; }

.ad-alert-sub {
    font-size: 13px;
    font-weight: 500;
    margin-top: 2px;
}

.ad-alert-banner.completed .ad-alert-sub { color: #15803d; }
.ad-alert-banner.upcoming .ad-alert-sub { color: #2563eb; }
.ad-alert-banner.cancelled .ad-alert-sub { color: #dc2626; }

/* ── CARDS COMMON ── */
.ad-card {
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 20px 24px;
    box-shadow: var(--shadow-card);
}

/* 1. Doctor Card */
.ad-doc-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.ad-doc-info-group {
    display: flex;
    align-items: center;
    gap: 16px;
}

.ad-doc-avatar {
    width: 62px;
    height: 62px;
    border-radius: 14px;
    object-fit: cover;
    border: 1px solid var(--border);
}

.ad-doc-avatar-ph {
    width: 62px;
    height: 62px;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--primary-teal), var(--primary-teal-sub));
    color: #fff;
    font-size: 22px;
    font-weight: 900;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ad-doc-main-name {
    font-size: 17px;
    font-weight: 800;
    color: var(--ink);
    display: flex;
    align-items: center;
    gap: 6px;
}

.ad-doc-main-name .verified-badge {
    color: #0284c7;
    font-size: 15px;
}

.ad-doc-main-spec {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--muted);
    margin-top: 2px;
}

.ad-doc-main-meta {
    font-size: 12.5px;
    font-weight: 500;
    color: var(--muted);
    margin-top: 2px;
}

.ad-doc-side-badge {
    background: #eef6fc;
    border-radius: var(--radius-md);
    padding: 10px 18px;
    text-align: center;
    min-width: 90px;
    flex-shrink: 0;
}

.ad-doc-side-badge-title {
    font-size: 13px;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
}

.ad-doc-side-badge-sub {
    font-size: 11.5px;
    font-weight: 700;
    color: #64748b;
    margin-top: 3px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

/* 2. Date & Time Card */
.ad-datetime-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.ad-date-box {
    border: 1.5px solid var(--border);
    border-radius: 12px;
    padding: 8px 16px;
    text-align: center;
    min-width: 72px;
    background: var(--white);
}

.ad-date-box-day {
    font-size: 22px;
    font-weight: 900;
    color: var(--ink);
    line-height: 1;
}

.ad-date-box-month {
    font-size: 12.5px;
    font-weight: 800;
    color: var(--ink);
    margin: 2px 0 1px;
}

.ad-date-box-year {
    font-size: 11px;
    font-weight: 600;
    color: var(--muted-light);
}

.ad-time-center {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.ad-time-lbl {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
}

.ad-time-val {
    font-size: 20px;
    font-weight: 900;
    color: var(--ink);
    letter-spacing: -0.01em;
}

.ad-time-span {
    font-size: 13px;
    font-weight: 500;
    color: var(--muted);
}

.ad-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
}

.ad-status-pill.completed {
    background: #dcfce7;
    color: #15803d;
}

.ad-status-pill.upcoming {
    background: #dbeafe;
    color: #1d4ed8;
}

.ad-status-pill.cancelled {
    background: #fee2e2;
    color: #dc2626;
}

/* 3. Package Details Card */
.ad-card-head {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 14px;
}

.ad-card-head i {
    color: var(--primary-teal);
    font-size: 16px;
}

.ad-pkg-pill-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}

.ad-pkg-badge {
    background: #e0f2fe;
    color: #0369a1;
    font-size: 13px;
    font-weight: 700;
    padding: 5px 14px;
    border-radius: 20px;
}

.ad-pkg-name {
    font-size: 14.5px;
    font-weight: 800;
    color: var(--ink);
}

.ad-pkg-session-count {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
}

/* 4. Patient Information Card */
.ad-patient-grid {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 18px;
}

.ad-patient-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
}

.ad-patient-row .label {
    color: var(--muted);
    font-weight: 600;
}

.ad-patient-row .val {
    color: var(--ink);
    font-weight: 800;
}

.ad-desc-section {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.ad-desc-lbl {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13.5px;
    font-weight: 700;
    color: var(--muted);
}

.ad-desc-lbl i {
    color: var(--primary-teal);
    font-size: 14px;
}

.ad-desc-box {
    background: var(--bg-page);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-md);
    padding: 14px 18px;
    font-size: 14px;
    font-weight: 600;
    color: var(--ink-light);
    min-height: 48px;
    line-height: 1.5;
}

/* 5. Bottom Action Buttons */
.ad-actions-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: 4px;
}

.ad-btn-outline {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 13px 24px;
    background: var(--white);
    border: 1.5px solid var(--primary-teal);
    border-radius: var(--radius-md);
    color: var(--primary-teal);
    font-size: 14.5px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: all .15s ease;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.ad-btn-outline:hover {
    background: var(--teal-soft-bg);
    color: var(--primary-teal-dark);
}

.ad-btn-solid-teal {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 13px 24px;
    background: var(--primary-teal);
    border: 1.5px solid var(--primary-teal);
    border-radius: var(--radius-md);
    color: var(--white);
    font-size: 14.5px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: all .15s ease;
    box-shadow: 0 4px 12px rgba(12, 105, 120, 0.2);
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.ad-btn-solid-teal:hover {
    background: var(--primary-teal-dark);
    border-color: var(--primary-teal-dark);
    color: var(--white);
}

.ad-btn-solid-red {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 13px 24px;
    background: #ef4444;
    border: 1.5px solid #ef4444;
    border-radius: var(--radius-md);
    color: var(--white);
    font-size: 14.5px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: all .15s ease;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.ad-btn-solid-red:hover {
    background: #dc2626;
    border-color: #dc2626;
    color: var(--white);
}

/* ─────────────────────────────────────────────
   INVOICE MODAL
───────────────────────────────────────────── */
.inv-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.55);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    backdrop-filter: blur(3px);
}
.inv-overlay.hidden { display: none; }

.inv-modal {
    background: #fff;
    border-radius: var(--radius-xl);
    width: 100%;
    max-width: 600px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.22);
    overflow: hidden;
    animation: modalIn .2s ease-out;
}
@keyframes modalIn {
    from { opacity: 0; transform: scale(.96) translateY(8px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}

.inv-modal-head {
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid var(--border-light);
    font-size: 16px;
    font-weight: 800;
    color: var(--ink);
}

.inv-modal-close {
    background: var(--border-light);
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-size: 15px;
    color: var(--muted);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .15s;
}
.inv-modal-close:hover { background: var(--border); color: var(--ink); }

.inv-modal-body {
    padding: 22px 24px;
    overflow-y: auto;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.inv-brand-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.inv-brand-logo { height: 38px; object-fit: contain; }

.inv-brand-num {
    font-size: 12px;
    font-weight: 800;
    color: var(--muted);
    text-align: right;
}
.inv-brand-num span {
    display: block;
    font-size: 15px;
    color: var(--ink);
    font-weight: 900;
    margin-top: 2px;
}

.inv-parties-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    padding: 14px 16px;
    background: var(--bg-page);
    border-radius: var(--radius-md);
    border: 1px solid var(--border-light);
}

.inv-label { font-size: 11px; font-weight: 700; color: var(--muted-light); text-transform: uppercase; letter-spacing: 0.04em; }
.inv-val { font-size: 13.5px; font-weight: 800; color: var(--ink); margin-top: 2px; }
.inv-sub-val { font-size: 12px; color: var(--muted); margin-top: 2px; line-height: 1.3; }

.inv-details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.inv-detail-item {
    background: var(--bg-page);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-sm);
    padding: 10px 14px;
}

.inv-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13.5px;
}
.inv-table th {
    text-align: left;
    padding: 10px 12px;
    background: var(--bg-page);
    color: var(--muted);
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
}
.inv-table td {
    padding: 12px 12px;
    border-bottom: 1px solid var(--border-light);
    color: var(--ink);
    font-weight: 600;
}

.inv-total-row {
    display: flex;
    justify-content: space-between;
    font-size: 15px;
    font-weight: 800;
    color: var(--ink);
    padding: 10px 12px;
    border-top: 1.5px solid var(--border);
}

.inv-paid-card {
    background: #ecfdf5;
    border: 1px solid #bbf7d0;
    border-radius: var(--radius-md);
    padding: 12px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.inv-paid-amt {
    font-size: 20px;
    font-weight: 900;
    color: #15803d;
}

.inv-modal-foot {
    padding: 16px 24px;
    border-top: 1px solid var(--border-light);
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
}

/* ─────────────────────────────────────────────
   CANCEL MODAL
───────────────────────────────────────────── */
.cm-dialog { max-width: 480px; }
.cm-content { border: none; border-radius: var(--radius-xl); overflow: hidden; box-shadow: 0 24px 80px rgba(0,0,0,.18); }
.cm-header { display: flex; align-items: center; gap: 12px; padding: 20px 24px; border-bottom: 1px solid var(--border-light); }
.cm-icon { width: 38px; height: 38px; border-radius: 10px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 17px; }
.cm-title { font-size: 17px; font-weight: 800; color: var(--ink); margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
.cm-close { margin-left: auto; background: var(--border-light); border: none; width: 30px; height: 30px; border-radius: 50%; font-size: 16px; color: var(--muted); cursor: pointer; display: flex; align-items: center; justify-content: center; }
.cm-body { padding: 22px 24px; }
.cm-label { font-size: 13px; font-weight: 700; color: var(--ink-light); margin-bottom: 8px; display: block; }
.cm-select, .cm-textarea {
    width: 100%; border: 1.5px solid var(--border); border-radius: var(--radius-md);
    font-size: 14px; font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--ink); background: var(--bg-page); outline: none;
    transition: all .18s;
}
.cm-select { height: 44px; padding: 0 14px; }
.cm-textarea { padding: 12px 14px; resize: vertical; min-height: 90px; margin-top: 14px; display: none; }
.cm-select:focus, .cm-textarea:focus { border-color: var(--primary-teal); background: #fff; box-shadow: 0 0 0 3px rgba(12,105,120,.12); }
.cm-footer { padding: 16px 24px; border-top: 1px solid var(--border-light); display: flex; justify-content: flex-end; gap: 10px; }
.cm-btn-secondary { padding: 10px 18px; border-radius: 10px; border: 1.5px solid var(--border); background: #fff; color: #475569; font-size: 14px; font-weight: 700; cursor: pointer; }
.cm-btn-danger { padding: 10px 20px; border-radius: 10px; background: #ef4444; color: #fff; font-size: 14px; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(239,68,68,.3); }
.cm-btn-danger:hover { background: #dc2626; }

/* Responsive adjustments */
@media (max-width: 991px) {
    .ad-page-container { grid-template-columns: 1fr; gap: 24px; }
    .ad-sidebar { position: static; }
}
@media (max-width: 640px) {
    .ad-page-container { padding: 12px 12px 40px; gap: 16px; }
    .ad-page-title { font-size: 20px; }
    .ad-card { padding: 16px 14px; border-radius: 14px; }
    .ad-actions-row { grid-template-columns: 1fr; gap: 10px; }
    .ad-btn-outline, .ad-btn-solid-teal, .ad-btn-solid-red { width: 100%; justify-content: center; padding: 12px 16px; font-size: 14px; }
    .ad-doc-row { flex-direction: column; align-items: flex-start; gap: 12px; }
    .ad-doc-side-badge { width: 100%; text-align: left; }
    .ad-datetime-row { flex-direction: column; align-items: flex-start; gap: 12px; }
    .ad-status-pill { align-self: flex-start; }
    .inv-modal { max-width: 100%; max-height: 94vh; margin: 8px; }
    .inv-modal-head { padding: 14px 16px; font-size: 15px; }
    .inv-modal-body { padding: 16px 14px; gap: 12px; }
    .inv-parties-grid { grid-template-columns: 1fr; gap: 10px; padding: 12px; }
    .inv-details-grid { grid-template-columns: 1fr; gap: 8px; }
    .inv-modal-foot { flex-direction: column; padding: 12px 16px; gap: 8px; }
    .inv-modal-foot button, .inv-modal-foot a { width: 100%; justify-content: center; text-align: center; }
}
@media (max-width: 440px) {
    .ad-patient-row { flex-direction: column; align-items: flex-start; gap: 2px; }
    .ad-pkg-pill-row { flex-direction: column; align-items: flex-start; gap: 6px; }
}
</style>

@include('layouts.header')

<div class="ad-page-container">

    {{-- ── LEFT SIDEBAR ── --}}
    <aside class="ad-sidebar">
        <nav class="ad-nav-list">
            <a href="{{ route('patient.dashboard') }}" class="ad-nav-item">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('patient.dashboard') }}" class="ad-nav-item active">
                <i class="fa-regular fa-calendar-check"></i>
                <span>My Appointments</span>
            </a>
            <a href="{{ route('patient.dashboard') }}#billing" class="ad-nav-item">
                <i class="fa-regular fa-credit-card"></i>
                <span>Billing &amp; Payments</span>
            </a>
            <a href="{{ route('patient.dashboard') }}" class="ad-nav-item">
                <i class="fa-solid fa-chart-line"></i>
                <span>Progress Report</span>
            </a>
            <a href="{{ route('patient.profile') }}" class="ad-nav-item">
                <i class="fa-regular fa-file-lines"></i>
                <span>My Documents</span>
            </a>
            <a href="{{ route('patient.dashboard') }}" class="ad-nav-item">
                <i class="fa-regular fa-bell"></i>
                <span>Notifications</span>
                <span class="ad-nav-badge">3</span>
            </a>
            <a href="{{ route('patient.profile') }}" class="ad-nav-item">
                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>
            </a>
        </nav>

        {{-- Need Help Card --}}
        <div class="ad-help-card">
            <div class="ad-help-icon-wrap">
                <i class="fa-solid fa-headset"></i>
            </div>
            <div class="ad-help-title">Need Help?</div>
            <div class="ad-help-desc">Our support team is here for you.</div>
            <a href="mailto:support@physiopii.com" class="ad-help-btn">Contact Support</a>
        </div>
    </aside>

    {{-- ── RIGHT DETAILS CONTENT ── --}}
    <main class="ad-main-content">

        {{-- Top Header & Breadcrumb --}}
        <div class="ad-top-header">
            <div class="ad-breadcrumb">
                <a href="{{ route('patient.dashboard') }}">My Appointments</a>
                <span class="sep"><i class="fa-solid fa-chevron-right" style="font-size:10px;"></i></span>
                <span class="active">Booking Details</span>
            </div>
            <div class="ad-title-row">
                <h1 class="ad-page-title">Booking Details</h1>
                <button type="button" class="ad-kebab-btn" title="More options">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
            </div>
        </div>

        @php
            $status = strtolower($appointment->status ?? 'confirmed');
            $isCompleted = ($status === 'completed');
            $isCancelled = ($status === 'cancelled');
            $isUpcoming  = !$isCompleted && !$isCancelled;

            // Doctor details formatting
            $rawDocName = $appointment->doctor->name ?? '';
            $cleanDocName = preg_replace('/^(dr\.?|doctor)\s+/i', '', trim($rawDocName));
            $displayDocName = $cleanDocName !== '' ? 'Dr. ' . $cleanDocName : '—';
            $cleanDocFirstName = explode(' ', $cleanDocName)[0] ?? 'Doctor';

            $specialization = optional(optional($appointment->doctor->profile)->specializationdata)->name ?? 'Physiotherapist';
            $qualification = optional($appointment->doctor->profile)->qualification ?? 'MPT (Back Pain)';
            $experienceYears = optional($appointment->doctor->profile)->experience_years ?? 10;

            // Date & Time formatting
            $apptDate = $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date) : now();
            $startTimeFormatted = $appointment->start_time ? \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') : '01:45 PM';
            $endTimeFormatted = $appointment->end_time ? \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') : \Carbon\Carbon::parse($appointment->start_time)->addMinutes(45)->format('h:i A');

            // Package Details
            $planName = optional($appointment->plan)->name ?? 'Basic';
            $totSessions = $totalSessions ?? 1;
            $currSession = $sessionIndex ?? 1;

            // Patient Info
            $patientName = $appointment->patient_name ?? ($patient->name ?? 'John Doe');
            $patientGender = ucfirst($appointment->patient_gender ?? ($patient->gender ?? 'Male'));
            $patientAge = $appointment->patient_age ?? ($patient->dob ? \Carbon\Carbon::parse($patient->dob)->age : 0);
            $bookingFor = ucfirst($appointment->booking_for ?? 'Self');
            $problemDesc = $appointment->problem_description ?: 'coho';
        @endphp

        {{-- Status Alert Banner --}}
        @if($isCompleted)
            <div class="ad-alert-banner completed">
                <div class="ad-alert-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="ad-alert-content">
                    <div class="ad-alert-title">Completed Appointment</div>
                    <div class="ad-alert-sub">Your session has been completed. Thank you for your visit!</div>
                </div>
            </div>
        @elseif($isCancelled)
            <div class="ad-alert-banner cancelled">
                <div class="ad-alert-icon">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="ad-alert-content">
                    <div class="ad-alert-title">Cancelled Appointment</div>
                    <div class="ad-alert-sub">This appointment has been cancelled.</div>
                </div>
            </div>
        @else
            <div class="ad-alert-banner upcoming">
                <div class="ad-alert-icon">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <div class="ad-alert-content">
                    <div class="ad-alert-title">Upcoming Appointment</div>
                    <div class="ad-alert-sub">Your session is scheduled. We look forward to seeing you!</div>
                </div>
            </div>
        @endif

        {{-- 1. Doctor Information Card --}}
        <div class="ad-card">
            <div class="ad-doc-row">
                <div class="ad-doc-info-group">
                    @if($appointment->doctor && $appointment->doctor->profile_img)
                        <img src="{{ str_contains($appointment->doctor->profile_img, '/') ? asset($appointment->doctor->profile_img) : asset('uploads/profile/'.$appointment->doctor->profile_img) }}" 
                             alt="{{ $displayDocName }}" class="ad-doc-avatar">
                    @else
                        <div class="ad-doc-avatar-ph">{{ strtoupper(substr($cleanDocName ?: 'D', 0, 1)) }}</div>
                    @endif
                    <div>
                        <div class="ad-doc-main-name">
                            {{ $displayDocName }}
                            <i class="fa-solid fa-circle-check verified-badge" title="Verified Doctor"></i>
                        </div>
                        <div class="ad-doc-main-spec">{{ $specialization }}</div>
                        <div class="ad-doc-main-meta">{{ $qualification }} &nbsp;|&nbsp; {{ $experienceYears }} Years Experience</div>
                    </div>
                </div>

                <div class="ad-doc-side-badge">
                    <div class="ad-doc-side-badge-title">dr. {{ $cleanDocFirstName }}</div>
                    <div class="ad-doc-side-badge-sub">{{ explode(' ', $qualification)[0] ?? 'MPT' }}</div>
                </div>
            </div>
        </div>

        {{-- 2. Date & Time Card --}}
        <div class="ad-card">
            <div class="ad-datetime-row">
                <div class="ad-date-box">
                    <div class="ad-date-box-day">{{ $apptDate->format('d') }}</div>
                    <div class="ad-date-box-month">{{ $apptDate->format('M') }}</div>
                    <div class="ad-date-box-year">{{ $apptDate->format('Y') }}</div>
                </div>

                <div class="ad-time-center">
                    <div class="ad-time-lbl">
                        <i class="fa-regular fa-clock"></i>
                        <span>Appointment Time</span>
                    </div>
                    <div class="ad-time-val">{{ $startTimeFormatted }}</div>
                    <div class="ad-time-span">{{ $startTimeFormatted }} - {{ $endTimeFormatted }}</div>
                </div>

                <div>
                    @if($isCompleted)
                        <span class="ad-status-pill completed">
                            <i class="fa-solid fa-circle-check"></i>
                            Completed
                        </span>
                    @elseif($isCancelled)
                        <span class="ad-status-pill cancelled">
                            <i class="fa-solid fa-circle-xmark"></i>
                            Cancelled
                        </span>
                    @else
                        <span class="ad-status-pill upcoming">
                            <i class="fa-regular fa-clock"></i>
                            Upcoming
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- 3. Package Details Card --}}
        <div class="ad-card">
            <div class="ad-card-head">
                <i class="fa-solid fa-bookmark"></i>
                <span>Package Details</span>
            </div>
            <div class="ad-pkg-pill-row">
                <span class="ad-pkg-badge">{{ $totSessions }} Sessions Package</span>
                <span class="ad-pkg-name">{{ $planName }}</span>
            </div>
            <div class="ad-pkg-session-count">
                <i class="fa-regular fa-calendar"></i>
                <span>Session {{ $currSession }} of {{ $totSessions }}</span>
            </div>
        </div>

        {{-- 4. Patient Information Card --}}
        <div class="ad-card">
            <div class="ad-card-head">
                <i class="fa-solid fa-user"></i>
                <span>Patient Information</span>
            </div>

            <div class="ad-patient-grid">
                <div class="ad-patient-row">
                    <span class="label">Patient Name</span>
                    <span class="val">{{ $patientName }}</span>
                </div>
                <div class="ad-patient-row">
                    <span class="label">Gender</span>
                    <span class="val">{{ $patientGender }}</span>
                </div>
                <div class="ad-patient-row">
                    <span class="label">Age</span>
                    <span class="val">{{ $patientAge }}</span>
                </div>
                <div class="ad-patient-row">
                    <span class="label">Booking For</span>
                    <span class="val">{{ $bookingFor }}</span>
                </div>
            </div>

            <div class="ad-desc-section">
                <div class="ad-desc-lbl">
                    <i class="fa-solid fa-bars-staggered"></i>
                    <span>Problem Description</span>
                </div>
                <div class="ad-desc-box">{{ $problemDesc }}</div>
            </div>
        </div>

        {{-- 5. Bottom Action Buttons --}}
        <div class="ad-actions-row">
            @if($isCompleted)
                <button type="button" class="ad-btn-outline" onclick="openInvoiceModal()">
                    <i class="fa-regular fa-file-lines"></i>
                    <span>View Invoice</span>
                </button>
                <a href="{{ route('doctor.booking', $appointment->doctor_id) }}" class="ad-btn-solid-teal">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span>Book Another Session</span>
                </a>
            @elseif($isCancelled)
                <button type="button" class="ad-btn-outline" onclick="openInvoiceModal()">
                    <i class="fa-regular fa-file-lines"></i>
                    <span>View Invoice</span>
                </button>
                <a href="{{ route('doctor.booking', $appointment->doctor_id) }}" class="ad-btn-solid-teal">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span>Book Another Session</span>
                </a>
            @else
                <a href="{{ route('doctor.booking', $appointment->doctor_id) }}" class="ad-btn-outline">
                    <i class="fa-regular fa-calendar-days"></i>
                    <span>Reschedule</span>
                </a>
                <button type="button" class="ad-btn-solid-red" data-toggle="modal" data-target="#cancelModal" onclick="$('#cancelModal').modal('show')">
                    <i class="fa-regular fa-circle-xmark"></i>
                    <span>Cancel Booking</span>
                </button>
            @endif
        </div>

    </main>
</div>

{{-- ── INVOICE MODAL ── --}}
@php
    $ip      = $payment;
    $iDoc    = $appointment->doctor;
    $iPlan   = $appointment->plan;
    $iPaidAt = optional($ip)->paid_at ?? (optional($ip)->created_at ?? $appointment->created_at);
    $iInvNo  = '#INV-' . date('Y') . '-' . str_pad($appointment->id, 5, '0', STR_PAD_LEFT);
    $iTotal  = (float) (optional($ip)->amount ?? (optional(optional($appointment->doctor)->fee)->consultation_fee ?? 800));
@endphp

<div class="inv-overlay hidden" id="invoiceOverlay" onclick="if(event.target===this)closeInvoiceModal()">
    <div class="inv-modal" onclick="event.stopPropagation()">
        <div class="inv-modal-head">
            <span>Transaction Invoice</span>
            <button class="inv-modal-close" onclick="closeInvoiceModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="inv-modal-body">
            <div class="inv-brand-row">
                <img src="{{ asset('logo.png') }}" alt="PhysioPii" class="inv-brand-logo">
                <div class="inv-brand-num">
                    TAX INVOICE
                    <span>{{ $iInvNo }}</span>
                </div>
            </div>

            <div class="inv-parties-grid">
                <div>
                    <div class="inv-label">Bill To</div>
                    <div class="inv-val">{{ $patientName }}</div>
                    <div class="inv-sub-val">{{ trim(implode(', ', array_filter([$patient->address ?? null, $patient->city ?? null, $patient->state ?? null]))) ?: 'Home Address' }}</div>
                </div>
                <div style="text-align:right;">
                    <div class="inv-label">Invoice Date</div>
                    <div class="inv-val">{{ $iPaidAt ? $iPaidAt->format('d M Y') : $apptDate->format('d M Y') }}</div>
                    <div class="inv-label" style="margin-top:6px;">Payment Date</div>
                    <div class="inv-val">{{ $iPaidAt ? $iPaidAt->format('d M Y • h:i A') : $apptDate->format('d M Y • h:i A') }}</div>
                </div>
            </div>

            <div class="inv-details-grid">
                <div class="inv-detail-item">
                    <div class="inv-label">Doctor Name</div>
                    <div class="inv-val">{{ $displayDocName }}</div>
                </div>
                <div class="inv-detail-item">
                    <div class="inv-label">Package</div>
                    <div class="inv-val">{{ $planName }} ({{ $totSessions }} Sessions)</div>
                </div>
                <div class="inv-detail-item">
                    <div class="inv-label">Appointment Date</div>
                    <div class="inv-val">{{ $apptDate->format('d M Y') }}</div>
                </div>
                <div class="inv-detail-item">
                    <div class="inv-label">Appointment Time</div>
                    <div class="inv-val">{{ $startTimeFormatted }} - {{ $endTimeFormatted }}</div>
                </div>
            </div>

            <table class="inv-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th style="text-align:right;">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $planName }} Package Consultation Fee</td>
                        <td style="text-align:right; font-weight:700;">₹{{ number_format($iTotal, 0) }}</td>
                    </tr>
                    <tr>
                        <td>Convenience Fee</td>
                        <td style="text-align:right; font-weight:700;">₹0</td>
                    </tr>
                </tbody>
            </table>

            <div class="inv-total-row">
                <span>Total Amount</span>
                <span>₹{{ number_format($iTotal, 0) }}</span>
            </div>

            <div class="inv-paid-card">
                <div>
                    <div style="font-size:12px; font-weight:700; color:#166534; text-transform:uppercase;">Amount Paid</div>
                    <div style="font-size:12px; color:#15803d; margin-top:2px;">Session fee paid in full.</div>
                </div>
                <div class="inv-paid-amt">₹{{ number_format($iTotal, 0) }}</div>
            </div>

            <div style="display:flex; align-items:flex-start; gap:8px; font-size:12px; color:var(--muted);">
                <i class="fa-solid fa-circle-info" style="color:var(--primary-teal); margin-top:2px;"></i>
                <span>This is a computer generated invoice and does not require a physical signature.</span>
            </div>
        </div>

        <div class="inv-modal-foot">
            <button type="button" class="ad-btn-solid-teal" onclick="window.print()" style="padding:10px 20px; font-size:13.5px;">
                <i class="fa-solid fa-download"></i> Download Invoice
            </button>
            <button type="button" class="ad-btn-outline" onclick="closeInvoiceModal()" style="padding:10px 18px; font-size:13.5px;">
                Close
            </button>
        </div>
    </div>
</div>

{{-- ── CANCEL APPOINTMENT MODAL ── --}}
@if(!$isCancelled)
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog cm-dialog modal-dialog-centered">
        <div class="modal-content cm-content">
            <form method="POST" action="{{ route('patient.appointment.cancel', $appointment->id) }}">
                @csrf
                <div class="cm-header">
                    <div class="cm-icon"><i class="fa-solid fa-circle-xmark"></i></div>
                    <h5 class="cm-title">Cancel Appointment</h5>
                    <button type="button" class="cm-close" data-dismiss="modal" onclick="$('#cancelModal').modal('hide')">&times;</button>
                </div>
                <div class="cm-body">
                    <label class="cm-label" for="reason_id">Select a reason</label>
                    <select name="reason_id" id="reason_id" class="cm-select" required>
                        <option value="">Choose reason…</option>
                        @foreach($reasons as $reason)
                            <option value="{{ $reason->id }}">{{ $reason->title }}</option>
                        @endforeach
                    </select>
                    <textarea name="custom_reason" id="customReason" class="cm-textarea" placeholder="Please describe your reason in detail…" rows="4"></textarea>
                </div>
                <div class="cm-footer">
                    <button type="button" class="cm-btn-secondary" data-dismiss="modal" onclick="$('#cancelModal').modal('hide')">Keep Appointment</button>
                    <button type="submit" class="cm-btn-danger"><i class="fa-solid fa-circle-xmark"></i> Confirm Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script>
function openInvoiceModal() {
    document.getElementById('invoiceOverlay').classList.remove('hidden');
}

function closeInvoiceModal() {
    document.getElementById('invoiceOverlay').classList.add('hidden');
}

$(function(){
    $('#reason_id').change(function(){
        const text = $(this).find(':selected').text().trim().toLowerCase();
        if (text === 'other') { 
            $('#customReason').slideDown(); 
        } else { 
            $('#customReason').slideUp(); 
            $('textarea[name=custom_reason]').val(''); 
        }
    });
});
</script>

@endsection