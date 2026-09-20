@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@php
    $cleanName = preg_replace('/^(dr\.?|doctor)\s+/i', '', trim($patient->name ?? ''));
    $initials   = strtoupper(substr($cleanName, 0, 1) ?: 'P');
@endphp

<style>
:root {
    --pt:#0c6978;--pt-dark:#074752;--pt-sub:#108598;
    --pt-soft:#eef8f9;--pt-border:#bce5ea;
    --green:#10b981;--amber:#f59e0b;--red:#ef4444;
    --ink:#0f172a;--body:#475569;--muted:#64748b;
    --border:#e2e8f0;--card:#ffffff;--bg:#f4f8fb;
    --shadow:0 2px 14px rgba(15,23,42,0.06);--radius:14px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg);color:var(--body);}

.bp-wrap{max-width:1260px;margin:0 auto;padding:28px 20px 60px;display:grid;grid-template-columns:240px 1fr;gap:24px;align-items:start;}

/* Sidebar */
.bp-sidebar{position:sticky;top:82px;background:var(--card);border-radius:var(--radius);border:1px solid var(--border);box-shadow:var(--shadow);overflow:hidden;}
.bp-sidebar-user{padding:20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:12px;}
.bp-sidebar-avatar{width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--pt),var(--pt-sub));display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;font-weight:800;flex-shrink:0;}
.bp-sidebar-name{font-size:14px;font-weight:700;color:var(--ink);}
.bp-sidebar-role{font-size:11.5px;color:var(--muted);margin-top:1px;}
.bp-nav{padding:10px 8px;}
.bp-nav-item{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:9px;font-size:13.5px;font-weight:600;color:var(--body);text-decoration:none;transition:all 0.15s;margin-bottom:2px;}
.bp-nav-item i{width:18px;text-align:center;font-size:14px;}
.bp-nav-item:hover,.bp-nav-item.active{background:var(--pt-soft);color:var(--pt);}
.bp-nav-divider{height:1px;background:var(--border);margin:8px 0;}
.bp-sidebar-support{padding:14px 16px;border-top:1px solid var(--border);background:var(--pt-soft);font-size:12px;color:var(--muted);text-align:center;}
.bp-sidebar-support strong{display:block;color:var(--ink);margin-bottom:4px;}
.bp-support-btn{display:inline-block;margin-top:8px;padding:7px 16px;border-radius:8px;background:var(--pt);color:#fff;font-size:12px;font-weight:700;text-decoration:none;transition:background 0.15s;}
.bp-support-btn:hover{background:var(--pt-dark);}

/* Main */
.bp-main{min-width:0;}
.bp-top-bar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:22px;}
.bp-page-title{font-size:24px;font-weight:800;color:var(--ink);}
.bp-page-sub{font-size:13px;color:var(--muted);margin-top:2px;}
.bp-top-actions{display:flex;gap:10px;}
.bp-btn-back{display:flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9px;border:1.5px solid var(--border);background:var(--card);color:var(--body);font-size:13px;font-weight:600;text-decoration:none;transition:all 0.15s;}
.bp-btn-back:hover{border-color:var(--pt);color:var(--pt);}
.bp-btn-refresh{display:flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9px;background:var(--pt-soft);border:1.5px solid var(--pt-border);color:var(--pt);font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;transition:all 0.15s;}
.bp-btn-refresh:hover{background:var(--pt-border);}

/* 2-col */
.bp-grid-2{display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;}

/* Card */
.bp-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;}
.bp-card-head{padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;}
.bp-card-head-icon{width:36px;height:36px;border-radius:9px;background:var(--pt-soft);display:flex;align-items:center;justify-content:center;color:var(--pt);font-size:15px;}
.bp-card-head h3{font-size:15px;font-weight:700;color:var(--ink);}
.bp-card-body{padding:20px;}

/* Overview */
.bp-overview-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.bp-ov-box{background:var(--pt-soft);border:1px solid var(--pt-border);border-radius:11px;padding:16px;}
.bp-ov-label{font-size:12px;color:var(--muted);font-weight:600;margin-bottom:4px;}
.bp-ov-val{font-size:22px;font-weight:800;color:var(--pt);letter-spacing:-0.5px;}
.bp-ov-sub{font-size:11px;color:var(--muted);margin-top:3px;}
.bp-ov-box.pending .bp-ov-val{color:var(--amber);}

/* Actions */
.bp-actions-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.bp-action-card{display:flex;align-items:center;gap:12px;padding:14px;background:var(--pt-soft);border:1px solid var(--pt-border);border-radius:11px;text-decoration:none;color:var(--ink);font-size:13px;font-weight:600;transition:all 0.15s;cursor:pointer;}
.bp-action-card:hover{background:var(--pt-border);}
.bp-action-icon{width:36px;height:36px;border-radius:9px;background:var(--pt);color:#fff;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;}
.bp-action-sub{font-size:11px;color:var(--muted);font-weight:400;margin-top:1px;}

/* Table */
.bp-table-wrap{overflow-x:auto;}
table.bp-table{width:100%;border-collapse:collapse;}
.bp-table thead tr{border-bottom:2px solid var(--pt-soft);}
.bp-table thead th{padding:10px 14px;font-size:12px;font-weight:700;color:var(--muted);text-align:left;text-transform:uppercase;letter-spacing:.5px;}
.bp-table tbody tr{border-bottom:1px solid #f1f5f9;transition:background 0.12s;}
.bp-table tbody tr:hover{background:var(--pt-soft);}
.bp-table td{padding:13px 14px;font-size:13px;color:var(--body);vertical-align:middle;}
.bp-doc-cell{display:flex;align-items:center;gap:10px;}
.bp-doc-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--pt),var(--pt-sub));display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700;flex-shrink:0;}
.bp-doc-name{font-size:13px;font-weight:700;color:var(--ink);}
.bp-doc-spec{font-size:11px;color:var(--muted);}
.bp-txn-id{font-size:11.5px;color:var(--muted);font-family:monospace;}
.bp-method-pill{display:inline-flex;align-items:center;gap:5px;font-size:11.5px;font-weight:600;padding:3px 9px;border-radius:20px;background:#f1f5f9;color:var(--body);}
.bp-status-pill{display:inline-block;padding:4px 11px;border-radius:20px;font-size:11.5px;font-weight:700;}
.bp-status-pill.paid{background:#d1fae5;color:#065f46;}
.bp-status-pill.pending{background:#fef3c7;color:#92400e;}
.bp-status-pill.failed{background:#fee2e2;color:#991b1b;}
.bp-amount-cell{font-size:14px;font-weight:800;color:var(--ink);white-space:nowrap;}
.bp-tbl-btn{width:30px;height:30px;border-radius:8px;background:var(--pt-soft);border:none;display:flex;align-items:center;justify-content:center;color:var(--pt);cursor:pointer;transition:all 0.15s;text-decoration:none;}
.bp-tbl-btn:hover{background:var(--pt);color:#fff;}
.bp-tbl-footer{padding:14px 20px;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;gap:12px;}
.bp-page-info{font-size:12.5px;color:var(--muted);}
.bp-pagination{display:flex;gap:4px;}
.bp-pagination a,.bp-pagination span{display:flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;border:1px solid var(--border);color:var(--body);transition:all 0.15s;}
.bp-pagination a:hover{border-color:var(--pt);color:var(--pt);background:var(--pt-soft);}
.bp-pagination span.active{background:var(--pt);color:#fff;border-color:var(--pt);}

/* Wallet */
.bp-wallet-card{background:linear-gradient(145deg,var(--pt),var(--pt-sub));border-radius:var(--radius);padding:20px;color:#fff;margin-bottom:16px;}
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
.bp-assist-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:18px;text-align:center;}
.bp-assist-icon{font-size:28px;color:var(--pt);margin-bottom:8px;}
.bp-assist-title{font-size:14px;font-weight:700;color:var(--ink);margin-bottom:4px;}
.bp-assist-sub{font-size:12px;color:var(--muted);margin-bottom:12px;}
.bp-assist-btn{display:block;padding:9px;border-radius:9px;border:1.5px solid var(--pt);color:var(--pt);font-size:13px;font-weight:700;text-decoration:none;text-align:center;transition:all 0.15s;}
.bp-assist-btn:hover{background:var(--pt);color:#fff;}

/* Empty */
.bp-empty{padding:50px 20px;text-align:center;}
.bp-empty i{font-size:40px;color:var(--pt-border);margin-bottom:12px;}
.bp-empty h4{font-size:16px;font-weight:700;color:var(--ink);margin-bottom:6px;}
.bp-empty p{font-size:13px;color:var(--muted);}

/* Modal */
.bp-modal-overlay{position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(5px);display:flex;align-items:center;justify-content:center;padding:20px;}
.bp-modal-overlay.hidden{display:none;}
.bp-modal{background:var(--card);border-radius:20px;width:100%;max-width:640px;max-height:92vh;overflow-y:auto;box-shadow:0 25px 70px rgba(0,0,0,0.25);animation:modalIn .22s cubic-bezier(0.16, 1, 0.3, 1);scrollbar-width:thin;scrollbar-color:#cbd5e1 transparent;}
.bp-modal::-webkit-scrollbar{width:6px;}
.bp-modal::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:10px;}
@keyframes modalIn{from{transform:scale(.95) translateY(10px);opacity:0;}to{transform:scale(1) translateY(0);opacity:1;}}
.bp-modal-head{display:flex;align-items:center;justify-content:space-between;padding:18px 24px;border-bottom:1px solid var(--border);font-size:16px;font-weight:800;color:var(--ink);}
.bp-modal-close{width:32px;height:32px;border-radius:8px;background:#f1f5f9;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;color:var(--muted);transition:all .15s;}
.bp-modal-close:hover{background:var(--red);color:#fff;}
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
.bp-inv-paid-box{background:var(--pt-soft);border:1px solid var(--pt-border);border-radius:12px;padding:14px 18px;display:flex;justify-content:space-between;align-items:center;margin:16px 0;}
.bp-inv-paid-lbl{font-size:13.5px;font-weight:700;color:var(--pt);}
.bp-inv-paid-sub{font-size:11.5px;color:var(--muted);margin-top:2px;}
.bp-inv-paid-amt{font-size:22px;font-weight:800;color:var(--pt);}
.bp-inv-note{display:flex;align-items:flex-start;gap:8px;background:#f8fafc;border-radius:10px;padding:10px 14px;font-size:11.5px;color:var(--muted);line-height:1.5;margin-bottom:6px;}
.bp-modal-footer{display:flex;gap:12px;padding:14px 28px 24px;}
.bp-modal-btn{flex:1;padding:11px;border-radius:11px;font-size:13.5px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;border:1.5px solid var(--border);color:var(--body);background:var(--card);transition:all .15s;text-decoration:none;}
.bp-modal-btn:hover{border-color:var(--pt);color:var(--pt);background:var(--pt-soft);}
.bp-modal-btn.primary{background:var(--pt);color:#fff;border-color:var(--pt);}
.bp-modal-btn.primary:hover{background:var(--pt-dark);}

@media(max-width:900px){.bp-wrap{grid-template-columns:1fr;}.bp-sidebar{position:static;}.bp-grid-2{grid-template-columns:1fr;}}
@media(max-width:640px){
    .bp-overview-grid{grid-template-columns:1fr;}
    .bp-actions-row{grid-template-columns:1fr;}
    .bp-tbl-footer{flex-direction:column;align-items:flex-start;}
    .bp-inv-parties{grid-template-columns:1fr;}
    .bp-inv-grid{grid-template-columns:1fr;}
    .bp-modal-body{padding:18px 16px;}
    .bp-modal-footer{padding:12px 16px 20px;}
}
</style>

@include('layouts.header')

<div class="bp-wrap">

    {{-- SIDEBAR --}}
    <aside class="bp-sidebar">
        <div class="bp-sidebar-user">
            @if($patient->profile_img)
                <img src="{{ asset($patient->profile_img) }}" alt="Avatar" style="width:44px;height:44px;border-radius:50%;object-fit:cover;">
            @else
                <div class="bp-sidebar-avatar">{{ $initials }}</div>
            @endif
            <div>
                <div class="bp-sidebar-name">{{ $patient->name }}</div>
                <div class="bp-sidebar-role">Patient</div>
            </div>
        </div>
        <nav class="bp-nav">
            <a href="{{ route('patient.dashboard') }}" class="bp-nav-item"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
            <a href="{{ route('patient.dashboard') }}" class="bp-nav-item"><i class="fa-regular fa-calendar-check"></i> My Appointments</a>
            <a href="{{ route('home') }}" class="bp-nav-item"><i class="fa-solid fa-user-doctor"></i> Doctors</a>
            <a href="{{ route('home') }}" class="bp-nav-item"><i class="fa-solid fa-box-open"></i> Packages</a>
            <div class="bp-nav-divider"></div>
            <a href="{{ route('patient.billing.payments') }}" class="bp-nav-item active"><i class="fa-solid fa-receipt"></i> Billing &amp; Payments</a>
            <a href="{{ route('patient.profile') }}" class="bp-nav-item"><i class="fa-regular fa-file-lines"></i> My Documents</a>
            <div class="bp-nav-divider"></div>
            <a href="{{ route('patient.profile') }}" class="bp-nav-item"><i class="fa-regular fa-bell"></i> Notifications</a>
            <a href="{{ route('patient.profile') }}" class="bp-nav-item"><i class="fa-solid fa-gear"></i> Settings</a>
        </nav>
        <div class="bp-sidebar-support">
            <i class="fa-solid fa-headset" style="font-size:20px;color:var(--pt);margin-bottom:4px;display:block;"></i>
            <strong>Need Help?</strong>
            Our support team is here for you.
            <a href="mailto:support@physiopii.com" class="bp-support-btn">Contact Support</a>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="bp-main">
        <div class="bp-top-bar">
            <div>
                <div class="bp-page-title">Billing &amp; Payments</div>
                <div class="bp-page-sub">Manage your payments, invoices and wallet details</div>
            </div>
            <div class="bp-top-actions">
                <a href="{{ route('patient.dashboard') }}" class="bp-btn-back"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
                <a href="{{ route('patient.billing.payments') }}" class="bp-btn-refresh"><i class="fa-solid fa-rotate-right"></i> Refresh</a>
            </div>
        </div>

        <div class="bp-grid-2">
            {{-- LEFT --}}
            <div style="display:flex;flex-direction:column;gap:20px;">

                {{-- Header card --}}
                <div class="bp-card">
                    <div class="bp-card-body" style="display:flex;align-items:center;gap:14px;">
                        <div style="width:52px;height:52px;border-radius:12px;background:var(--pt-soft);display:flex;align-items:center;justify-content:center;font-size:22px;color:var(--pt);flex-shrink:0;">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                        <div>
                            <div style="font-size:17px;font-weight:800;color:var(--ink);">Payment History</div>
                            <div style="font-size:12.5px;color:var(--muted);margin-top:2px;">Track your invoices, session payments and wallet details</div>
                        </div>
                    </div>
                </div>

                {{-- Overview --}}
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

                {{-- Quick Actions --}}
                <div class="bp-card">
                    <div class="bp-card-head">
                        <div class="bp-card-head-icon"><i class="fa-solid fa-bolt"></i></div>
                        <div><h3>Quick Actions</h3></div>
                    </div>
                    <div class="bp-card-body">
                        <div class="bp-actions-row">
                            <a href="#" class="bp-action-card" onclick="window.print();return false;">
                                <div class="bp-action-icon"><i class="fa-solid fa-download"></i></div>
                                <div>
                                    <div>Download Statement</div>
                                    <div class="bp-action-sub">Get your payment history in PDF</div>
                                </div>
                            </a>
                            <a href="mailto:support@physiopii.com" class="bp-action-card">
                                <div class="bp-action-icon"><i class="fa-solid fa-headset"></i></div>
                                <div>
                                    <div>Help &amp; Support</div>
                                    <div class="bp-action-sub">Get help with payments and invoices</div>
                                </div>
                            </a>
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
                            <i class="fa-solid fa-filter" style="color:var(--pt);font-size:11px;"></i> Filter
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
                                <tbody>
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
                                        @endphp
                                        <tr>
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
                                                    <i class="fa-solid fa-mobile-screen-button" style="font-size:11px;color:var(--pt);"></i>
                                                    {{ $method }}
                                                </span>
                                            </td>
                                            <td><span class="bp-status-pill {{ $statusCls }}">{{ $statusLabel }}</span></td>
                                            <td><div class="bp-amount-cell">₹{{ number_format($pay->amount, 0) }}</div></td>
                                            <td>
                                                <a href="?invoice={{ $pay->id }}" class="bp-tbl-btn" title="View Invoice">
                                                    <i class="fa-solid fa-chevron-right" style="font-size:11px;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="bp-tbl-footer">
                            <div class="bp-page-info">Showing {{ $payments->firstItem() }}–{{ $payments->lastItem() }} of {{ $payments->total() }} transactions</div>
                            <div class="bp-pagination">
                                @if($payments->onFirstPage())
                                    <span style="opacity:.4;cursor:not-allowed;"><i class="fa-solid fa-chevron-left" style="font-size:11px;"></i></span>
                                @else
                                    <a href="{{ $payments->previousPageUrl() }}"><i class="fa-solid fa-chevron-left" style="font-size:11px;"></i></a>
                                @endif
                                @foreach($payments->getUrlRange(1, $payments->lastPage()) as $page => $url)
                                    @if($page == $payments->currentPage())
                                        <span class="active">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    @endif
                                @endforeach
                                @if($payments->hasMorePages())
                                    <a href="{{ $payments->nextPageUrl() }}"><i class="fa-solid fa-chevron-right" style="font-size:11px;"></i></a>
                                @else
                                    <span style="opacity:.4;cursor:not-allowed;"><i class="fa-solid fa-chevron-right" style="font-size:11px;"></i></span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- RIGHT --}}
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
                    <button class="bp-wallet-add"><i class="fa-solid fa-plus"></i> Add Money</button>
                    <div class="bp-wallet-features">
                        <div class="bp-wallet-feat"><i class="fa-solid fa-shield-halved"></i><div><strong style="font-size:12px;">Fast &amp; Secure Payments</strong><br><span style="font-size:10.5px;opacity:.7;">100% Encrypted</span></div></div>
                        <div class="bp-wallet-feat"><i class="fa-solid fa-rotate-left"></i><div><strong style="font-size:12px;">Easy Refunds</strong><br><span style="font-size:10.5px;opacity:.7;">Hassle-free process</span></div></div>
                        <div class="bp-wallet-feat"><i class="fa-solid fa-bookmark"></i><div><strong style="font-size:12px;">Use for Future Bookings</strong><br><span style="font-size:10.5px;opacity:.7;">Seamless experience</span></div></div>
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
    </div>
</div>

{{-- INVOICE MODAL --}}
<div class="bp-modal-overlay {{ $invoicePayment ? '' : 'hidden' }}" id="invoiceOverlay" onclick="if(event.target===this)closeInvoice()">
    <div class="bp-modal" onclick="event.stopPropagation()">
        <div class="bp-modal-head">
            <span>Transaction Invoice</span>
            <button class="bp-modal-close" onclick="closeInvoice()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @if($invoicePayment)
            @php
                $ip      = $invoicePayment;
                $iDoc    = $ip->doctor;
                $iAppt   = $ip->appointment;
                $iPlan   = optional($iAppt)->plan;
                $iRawN   = $iDoc->name ?? 'Doctor';
                $iClean  = preg_replace('/^(dr\.?|doctor)\s+/i', '', trim($iRawN));
                $iDName  = 'Dr. ' . $iClean;
                $iPaidAt = $ip->paid_at ?? $ip->created_at;
                $iInvNo  = '#INV-' . date('Y') . '-' . str_pad($ip->id, 5, '0', STR_PAD_LEFT);
                $iTotal  = (float) $ip->amount;
                $iTxn    = $ip->transaction_id ?? ('TXN'.str_pad($ip->id, 10,'0',STR_PAD_LEFT));
            @endphp
            <div class="bp-modal-body">
                <div class="bp-inv-brand">
                    <img src="{{ asset('logo.png') }}" alt="PhysioPii" class="bp-inv-logo">
                    <div class="bp-inv-num">TAX INVOICE<span>{{ $iInvNo }}</span></div>
                </div>
                <div class="bp-inv-parties">
                    <div>
                        <div class="bp-inv-label">Bill To</div>
                        <div class="bp-inv-val">{{ $patient->name }}</div>
                        <div class="bp-inv-sub-val">{{ trim(implode(', ', array_filter([$patient->address ?? null, $patient->city ?? null, $patient->state ?? null]))) }}</div>
                    </div>
                    <div style="text-align:right;">
                        <div class="bp-inv-label">Invoice Date</div>
                        <div class="bp-inv-val">{{ $iPaidAt?->format('d M Y') ?? '—' }}</div>
                        <div class="bp-inv-label" style="margin-top:8px;">Payment Date</div>
                        <div class="bp-inv-val">{{ $iPaidAt?->format('d M Y • h:i A') ?? '—' }}</div>
                    </div>
                </div>
                <div class="bp-inv-section-title"><i class="fa-solid fa-file-lines" style="color:var(--pt);"></i> Invoice Details</div>
                <div class="bp-inv-grid">
                    <div class="bp-inv-item"><span class="lbl">Doctor Name</span><span class="val">{{ $iDName }}</span></div>
                    <div class="bp-inv-item"><span class="lbl">Package</span><span class="val">{{ $iPlan->name ?? 'Single Session' }}</span></div>
                    <div class="bp-inv-item"><span class="lbl">Appointment Date</span><span class="val">{{ $iAppt?->appointment_date?->format('d M Y') ?? ($iPaidAt?->format('d M Y') ?? '—') }}</span></div>
                    <div class="bp-inv-item"><span class="lbl">Start Time</span><span class="val">{{ $iAppt && $iAppt->start_time ? \Carbon\Carbon::parse($iAppt->start_time)->format('h:i A') : ($iPaidAt?->format('h:i A') ?? '—') }}</span></div>
                </div>

                <div class="bp-inv-section-title"><i class="fa-solid fa-list" style="color:var(--pt);"></i> Description &amp; Amount</div>
                <table class="bp-inv-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th style="text-align:right;">Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $iPlan->name ?? 'Session Fee' }}</td>
                            <td style="text-align:right;font-weight:700;">₹{{ number_format($iTotal, 0) }}</td>
                        </tr>
                        <tr>
                            <td>Convenience Fee</td>
                            <td style="text-align:right;font-weight:700;">₹0</td>
                        </tr>
                    </tbody>
                </table>

                <div class="bp-inv-total"><span>Total Amount</span><span>₹{{ number_format($iTotal, 0) }}</span></div>
                <div class="bp-inv-paid-box">
                    <div>
                        <div class="bp-inv-paid-lbl">Amount Paid</div>
                        <div class="bp-inv-paid-sub">You have paid this amount.</div>
                    </div>
                    <div class="bp-inv-paid-amt">₹{{ number_format($iTotal, 0) }}</div>
                </div>
                <div class="bp-inv-note">
                    <i class="fa-solid fa-circle-info" style="color:var(--pt);margin-top:2px;flex-shrink:0;"></i>
                    This is a computer generated invoice and does not require a physical signature.
                </div>
            </div>
            <div class="bp-modal-footer">
                <button class="bp-modal-btn" onclick="window.print()"><i class="fa-solid fa-download"></i> Download Invoice</button>
                <a href="{{ route('patient.billing.payments') }}" class="bp-modal-btn primary"><i class="fa-solid fa-arrow-left"></i> Back to Billing</a>
            </div>
        @endif
    </div>
</div>

<script>
function closeInvoice(){
    document.getElementById('invoiceOverlay').classList.add('hidden');
    const url=new URL(window.location.href);
    url.searchParams.delete('invoice');
    history.replaceState(null,'',url.toString());
}
</script>
@endsection
