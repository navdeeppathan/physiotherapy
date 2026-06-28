@extends('admin.layouts.admin')

@section('content')

<style>
    *, *::before, *::after { box-sizing: border-box; }

    .book-wrap {
        font-family: 'Inter', 'Poppins', sans-serif;
        max-width: 780px;
        padding: 0 0 48px;
    }

    /* ── PAGE HEADER ─────────────────────────────────── */
    .book-header {
        margin-bottom: 28px;
    }

    .book-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px;
        letter-spacing: -0.03em;
    }

    .book-header p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    /* ── PATIENT CHIP ────────────────────────────────── */
    .patient-chip {
        display: flex;
        align-items: center;
        gap: 14px;
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 24px;
    }

    .patient-chip-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #EFF6FF;
        color: #2563EB;
        font-size: 15px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        letter-spacing: -0.02em;
    }

    .patient-chip-info {}
    .patient-chip-name {
        font-size: 15px;
        font-weight: 600;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .patient-chip-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
    }

    .patient-chip-badge {
        display: inline-block;
        background: #EFF6FF;
        color: #1d4ed8;
        border-radius: 20px;
        padding: 1px 8px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 6px;
    }

    /* ── FORM CARD ───────────────────────────────────── */
    .form-card {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 16px;
        overflow: hidden;
    }

    .form-card-head {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
    }

    .form-card-icon {
        width: 34px;
        height: 34px;
        background: #EFF6FF;
        color: #2563EB;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-card-icon svg { width: 16px; height: 16px; }

    .form-card-title {
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
    }

    .form-card-sub {
        font-size: 12px;
        color: #94a3b8;
        margin: 1px 0 0;
    }

    .form-body {
        padding: 24px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-body .full { grid-column: 1 / -1; }

    /* ── FIELD ───────────────────────────────────────── */
    .field-group {}

    .field-label {
        font-size: 12px;
        font-weight: 500;
        color: #475569;
        margin: 0 0 6px;
        display: block;
    }

    .field-wrap {
        position: relative;
    }

    .field-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        display: flex;
        align-items: center;
        pointer-events: none;
    }

    .field-icon svg { width: 15px; height: 15px; }

    .field-input,
    .field-select,
    .field-textarea {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
        font-size: 13.5px;
        font-family: inherit;
        color: #0f172a;
        outline: none;
        transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
    }

    .field-input,
    .field-select {
        height: 44px;
        padding: 0 14px 0 40px;
    }

    .field-input[readonly] {
        background: #f1f5f9;
        color: #64748b;
        cursor: not-allowed;
    }

    .field-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-color: #f8fafc;
        padding-right: 36px;
        cursor: pointer;
    }

    .field-textarea {
        height: 100px;
        padding: 12px 14px 12px 40px;
        resize: vertical;
        line-height: 1.6;
    }

    .field-input:focus,
    .field-select:focus,
    .field-textarea:focus {
        border-color: #2563EB;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
    }

    .field-input::placeholder,
    .field-textarea::placeholder { color: #94a3b8; }

    /* ── DIVIDER ─────────────────────────────────────── */
    .section-divider {
        grid-column: 1 / -1;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 4px 0 0;
    }

    .section-divider-line {
        flex: 1;
        height: 1px;
        background: #f1f5f9;
    }

    .section-divider-label {
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        white-space: nowrap;
    }

    /* ── SLOT AREA ───────────────────────────────────── */
    .slot-area {
        grid-column: 1 / -1;
    }

    .slots-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 10px;
        margin-top: 2px;
    }

    .slot-option {
        position: relative;
    }

    .slot-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slot-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 3px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 11px 10px;
        cursor: pointer;
        transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
        background: #f8fafc;
        text-align: center;
        user-select: none;
    }

    .slot-label:hover {
        border-color: #93c5fd;
        background: #EFF6FF;
    }

    .slot-option input[type="radio"]:checked + .slot-label {
        border-color: #2563EB;
        background: #EFF6FF;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    .slot-time {
        font-size: 12.5px;
        font-weight: 600;
        color: #0f172a;
        line-height: 1.3;
    }

    .slot-option input[type="radio"]:checked + .slot-label .slot-time {
        color: #1d4ed8;
    }

    .slot-sep {
        font-size: 10px;
        color: #94a3b8;
    }

    /* Loading skeleton */
    .slot-skeleton {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 10px;
    }

    .slot-skel-item {
        height: 56px;
        border-radius: 10px;
        background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
        background-size: 200% 100%;
        animation: skelShimmer 1.4s infinite;
    }

    @keyframes skelShimmer {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* Empty / error state */
    .slot-empty {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 14px 16px;
        background: #FFF1F2;
        border: 1px solid #fecdd3;
        border-radius: 10px;
        font-size: 13px;
        color: #be123c;
        font-weight: 500;
    }

    .slot-placeholder {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 14px 16px;
        background: #f8fafc;
        border: 1px dashed #e2e8f0;
        border-radius: 10px;
        font-size: 13px;
        color: #94a3b8;
    }

    /* ── FORM FOOTER ─────────────────────────────────── */
    .form-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        padding: 18px 24px;
        border-top: 1px solid #f1f5f9;
        background: #fafbfd;
    }

    .btn-cancel {
        height: 44px;
        padding: 0 20px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #fff;
        font-size: 13.5px;
        font-family: inherit;
        font-weight: 500;
        color: #475569;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s, border-color 0.15s;
    }

    .btn-cancel:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #334155;
    }

    .btn-book {
        height: 44px;
        padding: 0 24px;
        border-radius: 10px;
        border: none;
        background: #2563EB;
        color: #fff;
        font-size: 13.5px;
        font-family: inherit;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: background 0.15s, box-shadow 0.15s;
        letter-spacing: -0.01em;
    }

    .btn-book:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 14px rgba(37,99,235,0.35);
    }

    .btn-book:active { transform: scale(0.99); }

    @media (max-width: 640px) {
        .form-body {
            grid-template-columns: 1fr;
        }
        .form-body .full { grid-column: 1; }
        .section-divider { grid-column: 1; }
        .slot-area { grid-column: 1; }
    }
</style>

<div class="book-wrap">

    <!-- ── PAGE HEADER ── -->
    <div class="book-header">
        <h1>Book Appointment</h1>
        <p>Schedule a new appointment by selecting a doctor, date, and available time slot.</p>
    </div>

    <!-- ── PATIENT CHIP ── -->
    <div class="patient-chip">
        <div class="patient-chip-avatar">
            {{ strtoupper(substr($patient->name, 0, 2)) }}
        </div>
        <div class="patient-chip-info">
            <div class="patient-chip-name">
                {{ $patient->name }}
                <span class="patient-chip-badge">Patient</span>
            </div>
            <div class="patient-chip-tag">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                </svg>
                {{ $patient->email ?? 'No email on file' }}
                @if($patient->phone)
                    &nbsp;·&nbsp;
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.21 3.59 2 2 0 0 1 3.22 1.4h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16z"/>
                    </svg>
                    {{ $patient->phone }}
                @endif
            </div>
        </div>
    </div>

    <!-- ── FORM CARD ── -->
    <div class="form-card">

        <div class="form-card-head">
            <div class="form-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div>
                <p class="form-card-title">Appointment Details</p>
                <p class="form-card-sub">Fill in the details below to confirm booking</p>
            </div>
        </div>

        <form action="{{ route('admin.appointments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $patient->id }}">

            <div class="form-body">

                <!-- Doctor -->
                <div class="field-group">
                    <label class="field-label" for="doctor_id">Select Doctor</label>
                    <div class="field-wrap">
                        <span class="field-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                        </span>
                        <select name="doctor_id" id="doctor_id" class="field-select" required>
                            <option value="">Choose a doctor…</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">Dr. {{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Date -->
                <div class="field-group">
                    <label class="field-label" for="appointment_date">Appointment Date</label>
                    <div class="field-wrap">
                        <span class="field-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </span>
                        <input
                            type="date"
                            id="appointment_date"
                            class="field-input"
                            min="{{ date('Y-m-d') }}"
                        >
                    </div>
                </div>

                <!-- Divider -->
                <div class="section-divider">
                    <div class="section-divider-line"></div>
                    <span class="section-divider-label">Available Time Slots</span>
                    <div class="section-divider-line"></div>
                </div>

                <!-- Slots -->
                <div class="slot-area">
                    <div id="slot_container">
                        <div class="slot-placeholder">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                            </svg>
                            Select a doctor and date to see available slots.
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="section-divider">
                    <div class="section-divider-line"></div>
                    <span class="section-divider-label">Additional Info</span>
                    <div class="section-divider-line"></div>
                </div>

                <!-- Problem Description -->
                <div class="field-group full">
                    <label class="field-label" for="problem_description">Problem Description <span style="color:#94a3b8; font-weight:400;">(optional)</span></label>
                    <div class="field-wrap">
                        <span class="field-icon" style="top: 14px; transform: none;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                            </svg>
                        </span>
                        <textarea
                            name="problem_description"
                            id="problem_description"
                            class="field-textarea"
                            placeholder="Briefly describe the patient's symptoms or reason for visit…"
                        ></textarea>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="form-footer">
                <a href="{{ url()->previous() }}" class="btn-cancel">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn-book">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Confirm Booking
                </button>
            </div>

        </form>
    </div>

</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function () {

        function loadSlots() {
            const doctorId = $('#doctor_id').val();
            const date     = $('#appointment_date').val();

            if (!doctorId || !date) {
                $('#slot_container').html(`
                    <div class="slot-placeholder">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Select a doctor and date to see available slots.
                    </div>
                `);
                return;
            }

            // Show skeleton
            let skelHtml = '<div class="slot-skeleton">';
            for (let i = 0; i < 6; i++) {
                skelHtml += '<div class="slot-skel-item"></div>';
            }
            skelHtml += '</div>';
            $('#slot_container').html(skelHtml);

            $.ajax({
                url:    "{{ route('admin.doctor.slots') }}",
                method: "GET",
                data:   { doctor_id: doctorId, date: date },

                success: function (response) {

                    if (!response.data || response.data.length === 0) {
                        $('#slot_container').html(`
                            <div class="slot-empty">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                No slots available for this doctor on the selected date.
                            </div>
                        `);
                        return;
                    }

                    let html = '<div class="slots-grid">';
                    response.data.forEach(function (slot) {
                        // Format times nicely
                        const fmt = t => {
                            const [h, m] = t.split(':');
                            const hr = parseInt(h);
                            const ampm = hr >= 12 ? 'PM' : 'AM';
                            const h12  = hr % 12 || 12;
                            return `${h12}:${m} ${ampm}`;
                        };
                        const start = fmt(slot.start_time);
                        const end   = fmt(slot.end_time);

                        html += `
                            <div class="slot-option">
                                <input
                                    type="radio"
                                    name="time_slot_id"
                                    id="slot_${slot.id}"
                                    value="${slot.id}"
                                    required
                                >
                                <label class="slot-label" for="slot_${slot.id}">
                                    <span class="slot-time">${start}</span>
                                    <span class="slot-sep">to ${end}</span>
                                </label>
                            </div>
                        `;
                    });
                    html += '</div>';

                    $('#slot_container').html(html);
                },

                error: function (xhr) {
                    $('#slot_container').html(`
                        <div class="slot-empty">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            Failed to load slots. Please try again.
                        </div>
                    `);
                    console.error(xhr.responseText);
                }
            });
        }

        $('#doctor_id, #appointment_date').on('change', loadSlots);
    });
</script>

@endsection