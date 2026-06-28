@extends('admin.layouts.admin')

@section('content')

<style>
    *, *::before, *::after { box-sizing: border-box; }

    .pay-wrap {
        font-family: 'Inter', 'Poppins', sans-serif;
        padding: 0 0 40px;
    }

    /* ── PAGE HEADER ─────────────────────────────────── */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #64748b;
        text-decoration: none;
        transition: background 0.15s, box-shadow 0.15s;
        flex-shrink: 0;
    }

    .back-btn:hover {
        background: #f8fafc;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        color: #0f172a;
    }

    .page-header-left h1 {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 3px;
        letter-spacing: -0.03em;
    }

    .page-header-left p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    /* ── STAT CARDS ──────────────────────────────────── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    @media (max-width: 900px) { .stats-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 500px) { .stats-row { grid-template-columns: 1fr; } }

    .stat-card {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 20px;
    }

    .stat-icon.blue   { background: #EFF6FF; }
    .stat-icon.green  { background: #ECFDF5; }
    .stat-icon.amber  { background: #FFFBEB; }
    .stat-icon.red    { background: #FFF1F2; }

    .stat-label {
        font-size: 11.5px;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 3px;
    }

    .stat-value {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.03em;
        line-height: 1;
    }

    .stat-value.green { color: #059669; }
    .stat-value.amber { color: #d97706; }
    .stat-value.red   { color: #dc2626; }

    /* ── CARD BASE ───────────────────────────────────── */
    .card {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .card:last-child { margin-bottom: 0; }

    .card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    .card-head-title {
        font-size: 13.5px;
        font-weight: 600;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-head-title svg { color: #94a3b8; }

    .card-body { padding: 20px; }

    /* ── PAY PANEL ───────────────────────────────────── */
    .pay-panel {
        background: #0A1628;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 20px;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 24px;
        align-items: center;
    }

    @media (max-width: 700px) {
        .pay-panel { grid-template-columns: 1fr; }
    }

    .pay-panel-label {
        font-size: 12px;
        color: rgba(255,255,255,0.45);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
    }

    .pay-panel-amount {
        font-size: 32px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.04em;
        line-height: 1;
    }

    .pay-panel-sub {
        font-size: 12.5px;
        color: rgba(255,255,255,0.4);
        margin-top: 6px;
    }

    .pay-panel-sub span {
        color: rgba(255,255,255,0.7);
        font-weight: 600;
    }

    /* ── PAY FORM INLINE ─────────────────────────────── */
    .pay-form-row {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .pay-input-wrap {
        position: relative;
    }

    .pay-input-symbol {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255,255,255,0.4);
        font-size: 14px;
        font-weight: 600;
        pointer-events: none;
    }

    .pay-input {
        height: 44px;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 10px;
        background: rgba(255,255,255,0.07);
        padding: 0 14px 0 30px;
        font-size: 14px;
        font-weight: 600;
        font-family: inherit;
        color: #fff;
        outline: none;
        width: 160px;
        transition: border-color 0.15s, background 0.15s;
    }

    .pay-input::placeholder { color: rgba(255,255,255,0.25); }

    .pay-input:focus {
        border-color: rgba(255,255,255,0.3);
        background: rgba(255,255,255,0.1);
    }

    .pay-btn {
        height: 44px;
        padding: 0 20px;
        border-radius: 10px;
        background: #2563EB;
        color: #fff;
        border: none;
        font-size: 13.5px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: background 0.15s, box-shadow 0.15s;
        white-space: nowrap;
    }

    .pay-btn:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 14px rgba(37,99,235,0.4);
    }

    .pay-btn:disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }

    /* ── TABLE ───────────────────────────────────────── */
    .appt-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .appt-table th {
        padding: 10px 16px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .appt-table td {
        padding: 13px 16px;
        color: #334155;
        border-bottom: 1px solid #f8fafc;
        vertical-align: middle;
    }

    .appt-table tr:last-child td { border-bottom: none; }
    .appt-table tbody tr:hover td { background: #fafbff; }
    .appt-table tbody tr.selected-row td { background: #EFF6FF; }

    /* Checkbox */
    .appt-check {
        width: 16px;
        height: 16px;
        accent-color: #2563EB;
        cursor: pointer;
    }

    /* Patient cell */
    .patient-cell {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .patient-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #EFF6FF;
        color: #2563EB;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .patient-name {
        font-weight: 500;
        color: #0f172a;
        font-size: 13px;
    }

    .patient-sub {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 1px;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .badge.paid      { background: #ECFDF5; color: #065f46; }
    .badge.paid::before     { background: #10b981; }
    .badge.unpaid    { background: #FFFBEB; color: #92400e; }
    .badge.unpaid::before   { background: #f59e0b; }
    .badge.completed { background: #EFF6FF; color: #1d4ed8; }
    .badge.completed::before{ background: #3b82f6; }

    /* Amount */
    .amount-val {
        font-size: 13.5px;
        font-weight: 600;
        color: #0f172a;
    }

    /* ── PAGINATION ───────────────────────────────────── */
    .pagination-wrap {
        padding: 14px 18px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pagination-info {
        font-size: 12.5px;
        color: #94a3b8;
    }

    .pagination-wrap .pagination { margin: 0; }

    .pagination-wrap .page-link {
        border-radius: 7px !important;
        font-size: 13px;
        color: #334155;
        border-color: #e2e8f0;
        padding: 5px 10px;
        font-family: inherit;
    }

    .pagination-wrap .page-item.active .page-link {
        background: #2563EB;
        border-color: #2563EB;
        color: #fff;
    }

    .pagination-wrap .page-link:focus {
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    /* ── SELECTION BAR ───────────────────────────────── */
    .selection-bar {
        display: none;
        align-items: center;
        justify-content: space-between;
        background: #EFF6FF;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        padding: 10px 16px;
        margin-bottom: 14px;
        font-size: 13px;
        color: #1d4ed8;
        font-weight: 500;
        flex-wrap: wrap;
        gap: 8px;
    }

    .selection-bar.visible { display: flex; }

    .clear-sel-btn {
        background: none;
        border: none;
        color: #94a3b8;
        font-size: 12px;
        cursor: pointer;
        font-family: inherit;
        padding: 0;
    }

    .clear-sel-btn:hover { color: #334155; }

    /* ── TOAST ───────────────────────────────────────── */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .toast {
        background: #0f172a;
        color: #fff;
        padding: 12px 18px;
        border-radius: 10px;
        font-size: 13.5px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 9px;
        animation: slideIn 0.25s ease;
        max-width: 340px;
    }

    .toast.success { border-left: 3px solid #10b981; }
    .toast.error   { border-left: 3px solid #f43f5e; }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(20px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    @media (max-width: 768px) {
        .appt-table th:nth-child(5),
        .appt-table td:nth-child(5) { display: none; }
    }
</style>

<!-- Toast -->
<div class="toast-container" id="toastContainer"></div>

<div class="pay-wrap">

    <!-- ── PAGE HEADER ── -->
    <div class="page-header">
        <div class="page-header-left">
            <a href="{{ route('admin.doctors.show', $doctor->id) }}" class="back-btn" title="Back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </a>
            <div>
                <h1>Doctor Payments</h1>
                <p>Completed appointments &amp; payment management for <strong>{{ $doctor->name }}</strong></p>
            </div>
        </div>
    </div>

    <!-- ── STATS ── -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue">📋</div>
            <div>
                <div class="stat-label">Total Appointments</div>
                <div class="stat-value">{{ $appointments->total() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">✅</div>
            <div>
                <div class="stat-label">Total Earned</div>
                <div class="stat-value green">₹{{ number_format($totalAmount) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber">⏳</div>
            <div>
                <div class="stat-label">Remaining</div>
                <div class="stat-value amber">₹{{ number_format($remainingAmount) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">💰</div>
            <div>
                <div class="stat-label">Paid Out</div>
                <div class="stat-value green">₹{{ number_format($paidAmount) }}</div>
            </div>
        </div>
    </div>

    <!-- ── PAY PANEL ── -->
    <div class="pay-panel">
        <div>
            <div class="pay-panel-label">Remaining Balance</div>
            <div class="pay-panel-amount">₹{{ number_format($remainingAmount) }}</div>
            <div class="pay-panel-sub">
                <span>{{ $unpaidCount }}</span> unpaid appointment(s) selected below · Total earned ₹{{ number_format($totalAmount) }}
            </div>
        </div>
        <div>
            <form id="payForm" action="{{ route('admin.doctors.pay', $doctor->id) }}" method="POST">
                @csrf

                <input type="hidden"
                    name="appointment_ids"
                    id="appointmentIdsInput">

                <button type="submit"
                        class="pay-btn"
                        id="payBtn"
                        disabled>

                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>

                    Pay Selected Appointments

                </button>

                <div style="margin-top:8px;font-size:11.5px;color:rgba(255,255,255,0.3);">
                    Select unpaid appointments below. The payment amount will be calculated automatically using the doctor's configured fee.
                </div>

            </form>
        </div>
    </div>

    <!-- ── SELECTION BAR ── -->
    <div class="selection-bar" id="selectionBar">
        <span id="selectionText">0 appointment(s) selected</span>
        <button class="clear-sel-btn" onclick="clearSelection()">✕ Clear selection</button>
    </div>

    <!-- ── TABLE CARD ── -->
    <div class="card">
        <div class="card-head">
            <div class="card-head-title">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Completed Appointments
            </div>
            <span style="font-size:12px;color:#94a3b8;">
                Showing {{ $appointments->firstItem() }}–{{ $appointments->lastItem() }} of {{ $appointments->total() }}
            </span>
        </div>

        <div style="overflow-x:auto;">
            <table class="appt-table">
                <thead>
                    <tr>
                        <th style="width:40px;">
                            <input type="checkbox" class="appt-check" id="selectAll" title="Select all unpaid">
                        </th>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Date &amp; Time</th>
                        <th>Problem</th>
                        <th>Amount</th>
                        
                        <th>Doctor Paid</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $key => $appt)
                        @php
                            $isPaid = $appt->doctor_payment_status === 'paid';
                            $patientName = $appt->patient_name ?? ($appt->patient->name ?? '—');
                            $amount = $doctor->fee->doctor_fee ?? 0;
                        @endphp
                        <tr class="{{ $isPaid ? '' : 'unpaid-row' }}" data-id="{{ $appt->id }}" data-paid="{{ $isPaid ? '1' : '0' }}">
                            <td>
                                @if(!$isPaid)
                                    <input
                                        type="checkbox"
                                        class="appt-check row-check"
                                        value="{{ $appt->id }}"
                                        data-amount="{{ $amount }}"
                                    >
                                @else
                                    <span style="color:#cbd5e1;font-size:16px;">✓</span>
                                @endif
                            </td>
                            <td style="color:#94a3b8;font-size:12px;">
                                {{ $appointments->firstItem() + $key }}
                            </td>
                            <td>
                                <div class="patient-cell">
                                    <div class="patient-avatar">
                                        {{ strtoupper(substr($patientName, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="patient-name">{{ $patientName }}</div>
                                        <div class="patient-sub">
                                            {{ $appt->patient_age ? $appt->patient_age.' yrs' : '' }}
                                            {{ $appt->patient_gender ? '· '.ucfirst($appt->patient_gender) : '' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size:13px;font-weight:500;color:#0f172a;">
                                    {{ $appt->appointment_date ? $appt->appointment_date->format('d M, Y') : '—' }}
                                </div>
                                <div style="font-size:11.5px;color:#94a3b8;margin-top:1px;">
                                    {{ $appt->start_time ? \Carbon\Carbon::parse($appt->start_time)->format('h:i A') : '' }}
                                    {{ $appt->end_time   ? '– '.\Carbon\Carbon::parse($appt->end_time)->format('h:i A') : '' }}
                                </div>
                            </td>
                            <td style="max-width:180px;">
                                <div style="font-size:13px;color:#475569;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $appt->problem_description ?? '—' }}
                                </div>
                            </td>
                            <td>
                                <span class="amount-val">₹{{ number_format($amount) }}</span>
                            </td>
                            
                            <td>
                                <span class="badge {{ $isPaid ? 'paid' : 'unpaid' }}">
                                    {{ $isPaid ? 'Paid' : 'Pending' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;padding:40px 20px;color:#94a3b8;font-size:13px;">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 10px;">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                No completed appointments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrap">
            <div class="pagination-info">
                Page {{ $appointments->currentPage() }} of {{ $appointments->lastPage() }}
            </div>
            {{ $appointments->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>

<script>
    const selectedIds   = new Set();
    const selectAll     = document.getElementById('selectAll');
    const payBtn        = document.getElementById('payBtn');
    const selectionBar  = document.getElementById('selectionBar');
    const selectionText = document.getElementById('selectionText');
    const idsInput      = document.getElementById('appointmentIdsInput');

    function updateUI() {
        const count = selectedIds.size;
        payBtn.disabled = count === 0;
        idsInput.value  = JSON.stringify([...selectedIds]);

        if (count > 0) {
            selectionBar.classList.add('visible');
            const doctorFee = {{ optional($doctor->fee)->doctor_fee ?? 0 }};

            selectionText.textContent =
            `${count} appointment(s) selected • Total ₹${(count * doctorFee).toLocaleString()}`;
        } else {
            selectionBar.classList.remove('visible');
        }

        // highlight rows
        document.querySelectorAll('tr[data-id]').forEach(row => {
            if (selectedIds.has(row.dataset.id)) {
                row.classList.add('selected-row');
            } else {
                row.classList.remove('selected-row');
            }
        });

        // sync select-all state
        const allChecks = document.querySelectorAll('.row-check');
        selectAll.checked  = allChecks.length > 0 && [...allChecks].every(c => c.checked);
        selectAll.indeterminate = count > 0 && count < allChecks.length;
    }

    document.querySelectorAll('.row-check').forEach(chk => {
        chk.addEventListener('change', () => {
            chk.checked ? selectedIds.add(chk.value) : selectedIds.delete(chk.value);
            updateUI();
        });
    });

    selectAll.addEventListener('change', () => {
        document.querySelectorAll('.row-check').forEach(chk => {
            chk.checked = selectAll.checked;
            selectAll.checked ? selectedIds.add(chk.value) : selectedIds.delete(chk.value);
        });
        updateUI();
    });

    function clearSelection() {
        selectedIds.clear();
        document.querySelectorAll('.row-check').forEach(c => c.checked = false);
        selectAll.checked = false;
        updateUI();
    }

    // Form submit — AJAX
    document.getElementById('payForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        alert('submit fired');

        if (selectedIds.size === 0) { showToast('Select at least one appointment.', 'error'); return; }

        console.log("Action:", this.action);
        console.log("Selected:", [...selectedIds]);
        payBtn.disabled = true;
        payBtn.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="animation:spin 0.8s linear infinite"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-.22-3.36"/></svg> Processing…`;

        try {
            const res  = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    appointment_ids: [...selectedIds],
                   
                })
            });
        console.log("After Fetch");

    console.log("Status:", res.status);
            const data = await res.json();

            console.log(data);

            if (data.status) {
                showToast(data.message ?? 'Payment recorded successfully.', 'success');
                setTimeout(() => location.reload(), 1200);
            } else {
                showToast(data.message ?? 'Something went wrong.', 'error');
                payBtn.disabled = false;
                payBtn.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg> Pay Doctor`;
            }
        } catch {
            showToast('Network error. Please try again.', 'error');
            payBtn.disabled = false;
            payBtn.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg> Pay Doctor`;
        }
    });

    function showToast(msg, type = 'success') {
        const t = document.createElement('div');
        t.className = `toast ${type}`;
        t.innerHTML = (type === 'success' ? '✅' : '❌') + ' ' + msg;
        document.getElementById('toastContainer').appendChild(t);
        setTimeout(() => t.remove(), 4000);
    }
</script>

<style>
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

@endsection