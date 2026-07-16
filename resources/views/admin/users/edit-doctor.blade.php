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
        background: #059669;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 11px 22px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s;
    }

    .save-btn:hover { background: #047857; }

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

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e2e8f0;
        margin: 24px auto 6px;
        display: block;
    }

    .profile-avatar-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #ECFDF5;
        color: #059669;
        font-size: 24px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 24px auto 6px;
        border: 3px solid #e2e8f0;
    }

    .profile-name-preview {
        text-align: center;
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 20px;
    }

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
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5,150,105,0.1);
    }

    textarea.form-control { resize: vertical; min-height: 80px; }

    select.form-control { appearance: none; cursor: pointer; }

    .form-hint {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 4px;
    }

    .error-text {
        font-size: 11.5px;
        color: #be123c;
        margin-top: 4px;
    }

    /* ── DAY / VISIT TOGGLES ─────────────────────────── */
    .toggle-group {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .toggle-pill {
        position: relative;
    }

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

<form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST">
@csrf
@method('PUT')

<div class="doctor-wrap">

    <!-- ── PAGE HEADER ── -->
    <div class="page-header">
        <div class="page-header-left">
            <a href="{{ route('admin.users.show', $doctor->id) }}" class="back-btn" title="Back to Profile">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </a>
            <div>
                <h1>Edit Doctor</h1>
                <p>Update details for {{ $doctor->name }}</p>
            </div>
        </div>

        <button type="submit" class="save-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
            </svg>
            Save Changes
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

                @if($doctor->profile_img)
                    <img src="{{ asset($doctor->profile_img) }}" alt="{{ $doctor->name }}" class="profile-avatar">
                @else
                    <div class="profile-avatar-placeholder">
                        {{ strtoupper(substr($doctor->name, 0, 2)) }}
                    </div>
                @endif
                <div class="profile-name-preview">{{ $doctor->name }}</div>

                <div class="card-body" style="padding-top:0;">

                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $doctor->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $doctor->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $doctor->phone) }}" required>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="{{ old('dob', $doctor->dob) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="">Select</option>
                                <option value="male" {{ old('gender', $doctor->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $doctor->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $doctor->gender) === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ old('status', $doctor->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $doctor->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="blocked" {{ old('status', $doctor->status) === 'blocked' ? 'selected' : '' }}>Blocked</option>
                        </select>
                    </div>

                    <hr class="section-divider">

                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                        <div class="form-hint">Only fill this in if you want to change the password.</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
                    </div>

                </div>
            </div>

            <!-- Consultation Fee -->
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                        Consultation Fee
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Doctor Fee (₹)</label>
                        <input type="number" name="doctor_fee" class="form-control" step="0.01" min="0"
                            value="{{ old('doctor_fee', $doctor->fee->doctor_fee ?? '') }}">
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
                                    <option value="{{ $spec->id }}" {{ old('specialization', $doctor->profile->specialization ?? '') == $spec->id ? 'selected' : '' }}>
                                        {{ $spec->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Qualification</label>
                            <input type="text" name="qualification" class="form-control"
                                value="{{ old('qualification', $doctor->profile->qualification ?? '') }}">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Experience (years)</label>
                            <input type="number" name="experience_years" class="form-control" min="0"
                                value="{{ old('experience_years', $doctor->profile->experience_years ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Career Path</label>
                            <input type="text" name="career_path" class="form-control"
                                value="{{ old('career_path', $doctor->profile->career_path ?? '') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Highlights</label>
                        <input type="text" name="highlights" class="form-control"
                            value="{{ old('highlights', $doctor->profile->highlights ?? '') }}"
                            placeholder="e.g. 10+ years in sports rehab, published researcher">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Bio</label>
                        <textarea name="bio" class="form-control" rows="4">{{ old('bio', $doctor->profile->bio ?? '') }}</textarea>
                    </div>

                </div>
            </div>

            <!-- Address -->
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                        Address
                    </div>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label class="form-label">Personal Address</label>
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $doctor->address) }}">
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control"
                                value="{{ old('city', $doctor->city) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control"
                                value="{{ old('state', $doctor->state) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pincode</label>
                        <input type="text" name="pincode" class="form-control"
                            value="{{ old('pincode', $doctor->pincode) }}">
                    </div>

                    <hr class="section-divider">

                    <div class="form-group">
                        <label class="form-label">Clinic Address</label>
                        <input type="text" name="clinic_address" class="form-control"
                            value="{{ old('clinic_address', $doctor->profile->clinic_address ?? '') }}">
                    </div>

                </div>
            </div>

            <!-- Availability -->
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Availability
                    </div>
                </div>
                <div class="card-body">

                    <div class="form-grid" style="margin-bottom:20px;">
                        <div class="form-group">
                            <label class="form-label">Start Time</label>
                            <input type="time" name="default_start_time" class="form-control"
                                value="{{ old('default_start_time', $doctor->default_start_time ? \Carbon\Carbon::createFromFormat('H:i:s', $doctor->default_start_time)->format('H:i') : '') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">End Time</label>
                            <input type="time" name="default_end_time" class="form-control"
                                value="{{ old('default_end_time', $doctor->default_end_time ? \Carbon\Carbon::createFromFormat('H:i:s', $doctor->default_end_time)->format('H:i') : '') }}">
                        </div>
                    </div>

                    @php
                        $selectedDays = old('available_days', $doctor->default_available_days ? json_decode($doctor->default_available_days, true) : []);
                        $allDays = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
                    @endphp

                    <div class="form-group">
                        <label class="form-label" style="margin-bottom:10px;">Available Days</label>
                        <div class="toggle-group">
                            @foreach($allDays as $day)
                                <div class="toggle-pill">
                                    <input type="checkbox" name="available_days[]" id="day-{{ $day }}" value="{{ $day }}"
                                        {{ in_array($day, $selectedDays ?? []) ? 'checked' : '' }}>
                                    <label for="day-{{ $day }}">{{ ucfirst($day) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:20px;margin-bottom:0;">
                        <label class="form-label" style="margin-bottom:10px;">Visit Types</label>
                        <div class="toggle-group">
                            <div class="toggle-pill visit">
                                <input type="checkbox" name="home_visit_available" id="home-visit" value="1"
                                    {{ old('home_visit_available', $doctor->profile->home_visit_available ?? false) ? 'checked' : '' }}>
                                <label for="home-visit">🏠 Home Visit</label>
                            </div>
                            <div class="toggle-pill visit">
                                <input type="checkbox" name="clinic_visit_available" id="clinic-visit" value="1"
                                    {{ old('clinic_visit_available', $doctor->profile->clinic_visit_available ?? false) ? 'checked' : '' }}>
                                <label for="clinic-visit">🏥 Clinic Visit</label>
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

@endsection