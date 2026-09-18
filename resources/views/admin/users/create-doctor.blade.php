@extends('admin.layouts.admin')

@section('content')

<style>
    *, *::before, *::after { box-sizing: border-box; }

    .doctor-wrap {
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

    .save-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #2563EB;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 11px 22px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s, box-shadow 0.15s;
    }

    .save-btn:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 14px rgba(37,99,235,0.3);
    }

    /* ── GRID ────────────────────────────────────────── */
    .detail-grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .detail-grid { grid-template-columns: 1fr; }
    }

    /* ── CARD BASE ───────────────────────────────────── */
    .card {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .card-head {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-head-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-body { padding: 20px; }

    /* ── FORM ────────────────────────────────────────── */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-grid.single { grid-template-columns: 1fr; }

    @media (max-width: 600px) {
        .form-grid { grid-template-columns: 1fr; }
    }

    .form-group { margin-bottom: 16px; }
    .form-group:last-child { margin-bottom: 0; }

    .form-label {
        display: block;
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13.5px;
        color: #0f172a;
        background: #fff;
        font-family: inherit;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .form-control:focus {
        outline: none;
        border-color: #2563EB;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    textarea.form-control { resize: vertical; min-height: 80px; }
    select.form-control { appearance: none; cursor: pointer; }

    .form-hint {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 4px;
    }

    /* ── DAY / VISIT TOGGLES ─────────────────────────── */
    .toggle-group {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .toggle-pill { position: relative; }

    .toggle-pill input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        margin: 0;
    }

    .toggle-pill label {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 600;
        text-transform: capitalize;
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: background 0.15s, color 0.15s, border-color 0.15s;
    }

    .toggle-pill input:checked ~ label {
        background: #EFF6FF;
        color: #1d4ed8;
        border-color: #bfdbfe;
    }

    .toggle-pill.visit input:checked ~ label {
        background: #ECFDF5;
        color: #059669;
        border-color: #A7F3D0;
    }

    hr.section-divider {
        border: none;
        border-top: 1px solid #f1f5f9;
        margin: 20px 0;
    }
</style>

<form action="{{ route('admin.doctors.store') }}" method="POST">
@csrf

<div class="doctor-wrap">

    <!-- ── PAGE HEADER ── -->
    <div class="page-header">
        <div class="page-header-left">
            <a href="{{ route('admin.users.doctorsindex') }}" class="back-btn" title="Back to Doctors">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </a>
            <div>
                <h1>Add New Doctor</h1>
                <p>Register a new doctor with custom doctor fee &amp; platform admin fee.</p>
            </div>
        </div>

        <button type="submit" class="save-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            Create Doctor
        </button>
    </div>

    @if($errors->any())
        <div class="card" style="border-color:#FECDD3;background:#FFF1F2;margin-bottom:20px;">
            <div class="card-body" style="padding:14px 20px;">
                <div style="font-size:13px;font-weight:600;color:#be123c;margin-bottom:6px;">Please fix the following:</div>
                <ul style="margin:0;padding-left:18px;font-size:12.5px;color:#be123c;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- ── GRID ── -->
    <div class="detail-grid">

        <!-- LEFT COLUMN -->
        <div>

            <!-- Basic Info -->
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        Account &amp; Personal Info
                    </div>
                </div>

                <div class="card-body">

                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Dr. Jane Smith" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="doctor@example.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone Number *</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="9876543210" required>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="">Select</option>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="blocked" {{ old('status') === 'blocked' ? 'selected' : '' }}>Blocked</option>
                        </select>
                    </div>

                    <hr class="section-divider">

                    <div class="form-group">
                        <label class="form-label">Password *</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
                    </div>

                </div>
            </div>

            <!-- Fee Configuration -->
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                        Fee Configuration
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Doctor Fee (₹) *</label>
                        <input type="number" name="doctor_fee" id="create_doctor_fee" class="form-control" step="0.01" min="0"
                            placeholder="e.g. 800"
                            value="{{ old('doctor_fee', '800') }}">
                        <div class="form-hint">Fee retained by this doctor per appointment.</div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Physiopii / Admin Fee Type</label>
                        <select name="admin_fee_type" id="create_admin_fee_type" class="form-control">
                            <option value="fixed" {{ old('admin_fee_type', 'fixed') === 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                            <option value="percentage" {{ old('admin_fee_type') === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Physiopii / Admin Fee (<span id="createAdminFeeUnit">₹</span>)</label>
                        <input type="number" name="admin_fee" id="create_admin_fee" class="form-control" step="0.01" min="0"
                            placeholder="e.g. 300 or 10"
                            value="{{ old('admin_fee', '300') }}">
                        <div class="form-hint">Platform fee charged per appointment for this doctor.</div>
                    </div>

                    <div class="fee-preview-box" style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 10px; padding: 14px; margin-top: 14px;">
                        <div style="display:flex; justify-content:space-between; margin-bottom: 6px; font-size: 13px; color: #166534;">
                            <span>Doctor Fee:</span>
                            <strong id="createPreviewDocFee">₹0</strong>
                        </div>
                        <div style="display:flex; justify-content:space-between; margin-bottom: 6px; font-size: 13px; color: #166534;">
                            <span>Admin Fee:</span>
                            <strong id="createPreviewAdmFee">₹0</strong>
                        </div>
                        <div style="display:flex; justify-content:space-between; padding-top: 6px; border-top: 1px dashed #86efac; font-size: 14px; color: #14532d; font-weight: 700;">
                            <span>Total Fee (Customer Pays):</span>
                            <strong id="createPreviewTotalFee" style="color:#059669; font-size:15px;">₹0</strong>
                        </div>
                        <div style="display:flex; justify-content:space-between; margin-top: 6px; padding-top: 6px; border-top: 1px solid #dcfce7; font-size: 12.5px; color: #15803d;">
                            <span>5-Session Package:</span>
                            <strong id="createPreviewPkgFee">₹0</strong>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div>

            <!-- Professional Info -->
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                        </svg>
                        Professional Information
                    </div>
                </div>
                <div class="card-body">

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Specialization</label>
                            <select name="specialization" class="form-control">
                                <option value="">Select Specialization</option>
                                @foreach($specializations as $spec)
                                    <option value="{{ $spec->id }}" {{ old('specialization') == $spec->id ? 'selected' : '' }}>
                                        {{ $spec->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Qualification</label>
                            <input type="text" name="qualification" class="form-control" placeholder="e.g. BPT, MPT (Neuro)"
                                value="{{ old('qualification') }}">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Experience (years)</label>
                            <input type="number" name="experience_years" class="form-control" min="0" placeholder="e.g. 5"
                                value="{{ old('experience_years') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Career Path</label>
                            <input type="text" name="career_path" class="form-control" placeholder="e.g. Senior Physiotherapist"
                                value="{{ old('career_path') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Biography / About</label>
                        <textarea name="bio" class="form-control" placeholder="Professional bio and experience overview…">{{ old('bio') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Key Highlights</label>
                        <textarea name="highlights" class="form-control" placeholder="Special skills, certifications, awards…">{{ old('highlights') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Clinic / Hospital Address</label>
                        <textarea name="clinic_address" class="form-control" placeholder="Clinic location details…">{{ old('clinic_address') }}</textarea>
                    </div>

                </div>
            </div>

            <!-- Schedule & Availability -->
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Schedule &amp; Availability
                    </div>
                </div>
                <div class="card-body">

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Default Start Time</label>
                            <input type="time" name="default_start_time" class="form-control"
                                value="{{ old('default_start_time', '09:00') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Default End Time</label>
                            <input type="time" name="default_end_time" class="form-control"
                                value="{{ old('default_end_time', '18:00') }}">
                        </div>
                    </div>

                    @php
                        $selectedDays = old('available_days', ['monday','tuesday','wednesday','thursday','friday','saturday']);
                        $allDays = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
                    @endphp

                    <div class="form-group">
                        <label class="form-label" style="margin-bottom:10px;">Available Days</label>
                        <div class="toggle-group">
                            @foreach($allDays as $day)
                                <div class="toggle-pill">
                                    <input type="checkbox" name="available_days[]" id="create-day-{{ $day }}" value="{{ $day }}"
                                        {{ in_array($day, $selectedDays ?? []) ? 'checked' : '' }}>
                                    <label for="create-day-{{ $day }}">{{ ucfirst($day) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:20px;margin-bottom:0;">
                        <label class="form-label" style="margin-bottom:10px;">Visit Types</label>
                        <div class="toggle-group">
                            <div class="toggle-pill visit">
                                <input type="checkbox" name="home_visit_available" id="create-home-visit" value="1"
                                    {{ old('home_visit_available', 1) ? 'checked' : '' }}>
                                <label for="create-home-visit">🏠 Home Visit</label>
                            </div>
                            <div class="toggle-pill visit">
                                <input type="checkbox" name="clinic_visit_available" id="create-clinic-visit" value="1"
                                    {{ old('clinic_visit_available', 1) ? 'checked' : '' }}>
                                <label for="create-clinic-visit">🏥 Clinic Visit</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div><!-- /right col -->

    </div>
    <!-- /grid -->

</div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const docFeeInput  = document.getElementById('create_doctor_fee');
    const admFeeInput  = document.getElementById('create_admin_fee');
    const feeTypeInput = document.getElementById('create_admin_fee_type');
    const unitSpan     = document.getElementById('createAdminFeeUnit');

    function updateFeePreview() {
        const df   = parseFloat(docFeeInput.value) || 0;
        const af   = parseFloat(admFeeInput.value) || 0;
        const type = feeTypeInput.value;

        let effectiveAdmin = af;
        if (type === 'percentage') {
            effectiveAdmin = (df * af) / 100;
            if (unitSpan) unitSpan.textContent = '%';
        } else {
            if (unitSpan) unitSpan.textContent = '₹';
        }

        const singleTotal  = df + effectiveAdmin;
        const packageTotal = singleTotal * 5;

        document.getElementById('createPreviewDocFee').textContent   = '₹' + Math.round(df).toLocaleString('en-IN');
        document.getElementById('createPreviewAdmFee').textContent   = '₹' + Math.round(effectiveAdmin).toLocaleString('en-IN') + (type === 'percentage' ? ' (' + af + '%)' : '');
        document.getElementById('createPreviewTotalFee').textContent = '₹' + Math.round(singleTotal).toLocaleString('en-IN');
        document.getElementById('createPreviewPkgFee').textContent   = '₹' + Math.round(packageTotal).toLocaleString('en-IN');
    }

    if (docFeeInput && admFeeInput && feeTypeInput) {
        docFeeInput.addEventListener('input', updateFeePreview);
        admFeeInput.addEventListener('input', updateFeePreview);
        feeTypeInput.addEventListener('change', updateFeePreview);
        updateFeePreview();
    }
});
</script>

@endsection