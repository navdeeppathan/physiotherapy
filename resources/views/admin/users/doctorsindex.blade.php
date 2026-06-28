@extends('admin.layouts.admin')

@section('content')

<style>
    *, *::before, *::after { box-sizing: border-box; }

    .users-wrap {
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

    .header-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #EFF6FF;
        border: 1px solid #bfdbfe;
        color: #1d4ed8;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 12.5px;
        font-weight: 500;
    }

    /* ── FILTER BAR ──────────────────────────────────── */
    .filter-bar {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .filter-search {
        flex: 1;
        min-width: 200px;
        position: relative;
    }

    .filter-search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
        display: flex;
        align-items: center;
    }

    .filter-input {
        width: 100%;
        height: 40px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        background: #f8fafc;
        padding: 0 14px 0 38px;
        font-size: 13.5px;
        font-family: inherit;
        color: #0f172a;
        outline: none;
        transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
    }

    .filter-input:focus {
        border-color: #2563EB;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
    }

    .filter-input::placeholder { color: #94a3b8; }

    .filter-select {
        height: 40px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        background: #f8fafc;
        padding: 0 32px 0 12px;
        font-size: 13.5px;
        font-family: inherit;
        color: #334155;
        outline: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        cursor: pointer;
        min-width: 150px;
        transition: border-color 0.15s;
    }

    .filter-select:focus {
        border-color: #2563EB;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
    }

    .filter-btn {
        height: 40px;
        padding: 0 18px;
        border-radius: 9px;
        font-size: 13.5px;
        font-family: inherit;
        font-weight: 500;
        cursor: pointer;
        border: none;
        transition: background 0.15s, box-shadow 0.15s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .filter-btn.primary {
        background: #2563EB;
        color: #fff;
    }

    .filter-btn.primary:hover {
        background: #1d4ed8;
        box-shadow: 0 3px 10px rgba(37,99,235,0.3);
    }

    .filter-btn.secondary {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .filter-btn.secondary:hover {
        background: #e2e8f0;
    }

    /* ── TABLE CARD ──────────────────────────────────── */
    .table-card {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 14px;
        overflow: hidden;
    }

    .table-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 22px;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-card-head-title {
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
    }

    .table-card-head-count {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 1px;
    }

    /* ── TABLE ───────────────────────────────────────── */
    .users-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .users-table th {
        padding: 10px 18px;
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

    .users-table td {
        padding: 13px 18px;
        color: #334155;
        border-bottom: 1px solid #f8fafc;
        vertical-align: middle;
    }

    .users-table tr:last-child td { border-bottom: none; }
    .users-table tbody tr:hover td { background: #fafbff; }

    /* User cell */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #EFF6FF;
        color: #2563EB;
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .user-avatar.doctor  { background: #ECFDF5; color: #059669; }
    .user-avatar.patient { background: #EFF6FF; color: #2563EB; }
    .user-avatar.other   { background: #f1f5f9; color: #64748b; }

    .user-name {
        font-weight: 500;
        color: #0f172a;
        font-size: 13.5px;
    }

    .user-email {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 1px;
    }

    /* Role badge */
    .role-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .role-badge.doctor  { background: #ECFDF5; color: #065f46; }
    .role-badge.patient { background: #EFF6FF; color: #1d4ed8; }
    .role-badge.admin   { background: #f5f3ff; color: #6d28d9; }
    .role-badge.other   { background: #f1f5f9; color: #64748b; }

    /* Status badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .status-badge.blocked {
        background: #FFF1F2;
        color: #be123c;
    }

    .status-badge.blocked::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #f43f5e;
        flex-shrink: 0;
    }

    /* Toggle switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #e2e8f0;
        transition: 0.25s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: #fff;
        transition: 0.25s;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }

    input:checked + .slider { background-color: #2563EB; }
    input:checked + .slider:before { transform: translateX(20px); }

    /* Fee cells */
    .fee-val {
        font-size: 13px;
        font-weight: 500;
        color: #0f172a;
    }

    .fee-na {
        color: #cbd5e1;
        font-size: 13px;
    }

    /* Action buttons */
    .act-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 500;
        font-family: inherit;
        cursor: pointer;
        border: none;
        transition: background 0.15s, box-shadow 0.15s;
    }

    .act-btn.fee {
        background: #EFF6FF;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .act-btn.fee:hover {
        background: #dbeafe;
        box-shadow: 0 2px 8px rgba(37,99,235,0.15);
    }

    /* ── PAGINATION ───────────────────────────────────── */
    .pagination-wrap {
        padding: 16px 20px;
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

    .pagination-wrap .pagination {
        margin: 0;
    }

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

    /* ── FEE MODAL ───────────────────────────────────── */
    .fee-modal .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    .fee-modal .modal-header {
        background: #0A1628;
        border-bottom: none;
        padding: 20px 24px 16px;
    }

    .fee-modal .modal-title {
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: -0.02em;
    }

    .fee-modal .btn-close {
        filter: invert(1) opacity(0.7);
    }

    .fee-modal .doctor-name-tag {
        font-size: 12px;
        color: rgba(255,255,255,0.45);
        margin-top: 2px;
    }

    .fee-modal .modal-body {
        padding: 24px;
    }

    .fee-modal .modal-footer {
        border-top: 1px solid #f1f5f9;
        padding: 16px 24px;
    }

    .fee-field-label {
        font-size: 12px;
        font-weight: 500;
        color: #475569;
        margin: 0 0 6px;
        display: block;
    }

    .fee-field-input {
        width: 100%;
        height: 44px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        background: #f8fafc;
        padding: 0 14px 0 40px;
        font-size: 14px;
        font-family: inherit;
        color: #0f172a;
        outline: none;
        transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
    }

    .fee-field-input:focus {
        border-color: #2563EB;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
    }

    .fee-field-wrap {
        position: relative;
        margin-bottom: 16px;
    }

    .fee-field-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
        font-weight: 600;
        pointer-events: none;
    }

    .fee-total-preview {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 4px;
    }

    .fee-total-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }

    .fee-total-value {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.03em;
    }

    .save-fee-btn {
        width: 100%;
        height: 46px;
        background: #2563EB;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background 0.15s, box-shadow 0.15s;
    }

    .save-fee-btn:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 14px rgba(37,99,235,0.35);
    }

    @media (max-width: 768px) {
        .filter-bar { flex-direction: column; }
        .filter-search,
        .filter-select { width: 100%; }
        .filter-btn { width: 100%; justify-content: center; }
        .users-table th:nth-child(4),
        .users-table td:nth-child(4) { display: none; }
    }
</style>

<div class="users-wrap">

    <!-- ── HEADER ── -->
    <div class="page-header">
        <div class="page-header-left">
            <h1>All Users</h1>
            <p>Manage doctors, patients, and their access across the platform.</p>
        </div>
        <div class="header-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            {{ $users->total() }} users total
        </div>
    </div>

    <!-- ── FILTER BAR ── -->
    <form method="GET" action="{{ route('admin.users.index') }}">
        <div class="filter-bar">

            <div class="filter-search">
                <span class="filter-search-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </span>
                <input
                    type="text"
                    name="search"
                    class="filter-input"
                    placeholder="Search by name or email…"
                    value="{{ request('search') }}"
                >
            </div>

            <select name="status" class="filter-select">
                <option value="">All Status</option>
                <option value="active"   {{ request('status') == 'active'   ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="blocked"  {{ request('status') == 'blocked'  ? 'selected' : '' }}>Blocked</option>
            </select>

            <button type="submit" class="filter-btn primary">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                </svg>
                Filter
            </button>

            <a href="{{ route('admin.users.index') }}" class="filter-btn secondary">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/>
                </svg>
                Reset
            </a>

        </div>
    </form>

    <!-- ── TABLE CARD ── -->
    <div class="table-card">

        <div class="table-card-head">
            <div>
                <div class="table-card-head-title">User Directory</div>
                <div class="table-card-head-count">
                    Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users
                </div>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Doctor Fee</th>
                        <th>Admin Fee</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $key => $user)
                        <tr>
                            <td style="color: #94a3b8; font-size: 12px;">
                                {{ $users->firstItem() + $key }}
                            </td>

                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar {{ $user->role }}">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="user-name">{{ $user->name }}</div>
                                        <div class="user-email">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <td style="color: #64748b;">
                                {{ $user->phone ?? '—' }}
                            </td>

                            <td>
                                <span class="role-badge {{ $user->role }}">{{ ucfirst($user->role) }}</span>
                            </td>

                            <td>
                                @if($user->status == 'blocked')
                                    <span class="status-badge blocked">Blocked</span>
                                @else
                                    <label class="switch" title="{{ $user->status == 'active' ? 'Active – click to deactivate' : 'Inactive – click to activate' }}">
                                        <input
                                            type="checkbox"
                                            class="toggle-status"
                                            data-id="{{ $user->id }}"
                                            {{ $user->status == 'active' ? 'checked' : '' }}
                                        >
                                        <span class="slider"></span>
                                    </label>
                                @endif
                            </td>

                            <td>
                                @if($user->fee && $user->fee->doctor_fee)
                                    <span class="fee-val">₹{{ number_format($user->fee->doctor_fee) }}</span>
                                @else
                                    <span class="fee-na">—</span>
                                @endif
                            </td>

                            <td>
                                @if($user->fee && $user->fee->admin_fee)
                                    <span class="fee-val">₹{{ number_format($user->fee->admin_fee) }}</span>
                                @else
                                    <span class="fee-na">—</span>
                                @endif
                            </td>

                            <td>
                                @if($user->fee && $user->fee->total_fee)
                                    <span class="fee-val" style="color: #059669; font-weight: 600;">₹{{ number_format($user->fee->total_fee) }}</span>
                                @else
                                    <span class="fee-na">—</span>
                                @endif
                            </td>

                            <td>
                                @if($user->role == 'doctor')
                                    <button
                                        class="act-btn fee open-fee-modal"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                    >
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                        </svg>
                                        Set Fee
                                    </button>
                                @else
                                    <span class="fee-na">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 36px 20px; color: #94a3b8; font-size: 13px;">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display: block; margin: 0 auto 10px;">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                                No users found matching your filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrap">
            <div class="pagination-info">
                Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
            </div>
            {{ $users->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>

<!-- ── FEE MODAL ── -->
<div class="modal fade fee-modal" id="feeModal" tabindex="-1" aria-labelledby="feeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="feeModalLabel">Set Appointment Fee</h5>
                    <div class="doctor-name-tag" id="feeModalDoctorName"></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="feeForm">
                    <input type="hidden" name="doctor_id" id="doctor_id">

                    <div class="fee-field-wrap">
                        <label class="fee-field-label" for="doctor_fee">Doctor Fee (₹)</label>
                        <span class="fee-field-icon">₹</span>
                        <input
                            type="number"
                            name="doctor_fee"
                            id="doctor_fee"
                            class="fee-field-input"
                            placeholder="0"
                            min="0"
                            step="1"
                        >
                    </div>

                    {{-- <div class="fee-field-wrap">
                        <label class="fee-field-label" for="admin_fee">Admin Fee (₹)</label>
                        <span class="fee-field-icon">₹</span>
                        <input
                            type="number"
                            name="admin_fee"
                            id="admin_fee"
                            class="fee-field-input"
                            placeholder="0"
                            min="0"
                            step="1"
                        >
                    </div>

                    <div class="fee-total-preview">
                        <span class="fee-total-label">Total fee</span>
                        <span class="fee-total-value" id="feeTotalPreview">₹0</span>
                    </div> --}}

                </form>
            </div>

            <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 16px 24px;">
                <button type="button" id="saveFeeBtn" class="save-fee-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Save Fee
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const modal = new bootstrap.Modal(document.getElementById('feeModal'));

    // ── Live total preview ──────────────────────────
    function updateTotal() {
        const df = parseFloat(document.getElementById('doctor_fee').value) || 0;
        const af = parseFloat(document.getElementById('admin_fee').value) || 0;
        document.getElementById('feeTotalPreview').textContent = '₹' + (df + af).toLocaleString('en-IN');
    }

    document.getElementById('doctor_fee').addEventListener('input', updateTotal);
    document.getElementById('admin_fee').addEventListener('input',  updateTotal);

    // ── Open fee modal ──────────────────────────────
    document.querySelectorAll('.open-fee-modal').forEach(btn => {
        btn.addEventListener('click', function () {

            const userId   = this.dataset.id;
            const userName = this.dataset.name;

            document.getElementById('doctor_id').value         = userId;
            document.getElementById('feeModalDoctorName').textContent = 'Dr. ' + userName;
            document.getElementById('doctor_fee').value        = '';
            document.getElementById('admin_fee').value         = '';
            document.getElementById('feeTotalPreview').textContent = '₹0';

            fetch(`/admin/fees/${userId}`)
                .then(res => res.json())
                .then(data => {
                    const fee = data.data;
                    if (fee) {
                        document.getElementById('doctor_fee').value = fee.doctor_fee || '';
                        document.getElementById('admin_fee').value  = fee.admin_fee  || '';
                        updateTotal();
                    }
                })
                .catch(() => {});

            modal.show();
        });
    });

    // ── Save fee ────────────────────────────────────
    document.getElementById('saveFeeBtn').addEventListener('click', function () {

        const form     = document.getElementById('feeForm');
        const formData = new FormData(form);
        const btn      = this;

        btn.disabled    = true;
        btn.textContent = 'Saving…';

        fetch("{{ route('admin.fees.store') }}", {
            method:  "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body:    formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                modal.hide();
                Swal.fire({
                    icon:              'success',
                    title:             'Fee saved',
                    text:              data.message || 'Appointment fee updated successfully.',
                    confirmButtonColor: '#2563EB',
                    customClass:       { popup: 'swal-inter' }
                }).then(() => location.reload());
            } else {
                Swal.fire({
                    icon:              'error',
                    title:             'Could not save',
                    text:              data.message || 'Please try again.',
                    confirmButtonColor: '#2563EB'
                });
            }
        })
        .catch(() => {
            Swal.fire({ icon: 'error', title: 'Network error', text: 'Please try again.' });
        })
        .finally(() => {
            btn.disabled    = false;
            btn.innerHTML   = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Save Fee';
        });
    });

    // ── Toggle status ───────────────────────────────
    document.querySelectorAll('.toggle-status').forEach(function (toggle) {
        toggle.addEventListener('change', function () {

            const userId   = this.dataset.id;
            const checkbox = this;

            fetch(`/admin/users/toggle-status/${userId}`, {
                method:  "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept":       "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        toast:            true,
                        position:         'top-end',
                        icon:             'success',
                        title:            data.status === 'active'
                                            ? 'User activated'
                                            : 'User deactivated',
                        showConfirmButton: false,
                        timer:            1800,
                        timerProgressBar: true,
                        customClass:      { popup: 'swal-inter' }
                    });
                } else {
                    checkbox.checked = !checkbox.checked;
                }
            })
            .catch(() => {
                checkbox.checked = !checkbox.checked;
                Swal.fire({ icon: 'error', title: 'Something went wrong', text: 'Please try again.' });
            });
        });
    });

});
</script>

<style>
    .swal-inter { font-family: 'Inter', 'Poppins', sans-serif !important; }
</style>

@endsection