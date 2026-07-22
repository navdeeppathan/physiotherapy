@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Patient Register — Physiopii</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .reg-page-bg {
        min-height: 100vh;
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 40%, #f8faff 100%);
        display: flex;
        flex-direction: column;
    }
    .reg-page-center {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .reg-card {
        width: 100%;
        max-width: 1020px;
        display: flex;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 24px 80px rgba(16,185,129,0.1), 0 4px 20px rgba(0,0,0,0.06);
        background: #fff;
    }

    /* LEFT */
    .reg-panel-left {
        width: 38%;
        background: linear-gradient(160deg, #064e3b 0%, #065f46 50%, #047857 100%);
        padding: 52px 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }
    .reg-panel-left::before {
        content: '';
        position: absolute;
        right: -50px; top: -50px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(52,211,153,0.1);
    }
    .reg-panel-left::after {
        content: '';
        position: absolute;
        left: -30px; bottom: -30px;
        width: 150px; height: 150px;
        border-radius: 50%;
        background: rgba(110,231,183,0.07);
    }

    .rpl-brand { display: flex; align-items: center; gap: 12px; position: relative; z-index: 1; }
    .rpl-brand-icon {
        width: 40px; height: 40px;
        background: rgba(255,255,255,0.18);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
    }
    .rpl-brand-name { font-size: 16px; font-weight: 800; color: #fff; font-family: 'Plus Jakarta Sans', sans-serif; }
    .rpl-brand-sub { font-size: 11.5px; color: rgba(255,255,255,0.5); margin-top: 2px; }

    .rpl-main { position: relative; z-index: 1; }
    .rpl-icon-wrap {
        width: 68px; height: 68px;
        background: rgba(255,255,255,0.12);
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 22px;
    }
    .rpl-title { font-size: 26px; font-weight: 800; color: #fff; letter-spacing: -0.04em; line-height: 1.2; margin-bottom: 10px; font-family: 'Plus Jakarta Sans', sans-serif; }
    .rpl-desc { font-size: 13.5px; color: rgba(255,255,255,0.6); line-height: 1.7; }

    .rpl-steps { position: relative; z-index: 1; display: flex; flex-direction: column; gap: 10px; }
    .rpl-step {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 12px;
        padding: 11px 14px;
    }
    .rpl-step-num {
        width: 24px; height: 24px;
        background: rgba(52,211,153,0.3);
        border-radius: 50%;
        font-size: 12px;
        font-weight: 800;
        color: #6ee7b7;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .rpl-step-text { font-size: 13px; color: rgba(255,255,255,0.75); font-weight: 500; }

    /* RIGHT */
    .reg-panel-right {
        flex: 1;
        padding: 44px 52px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        overflow-y: auto;
        max-height: 90vh;
    }

    .rpr-eyebrow { font-size: 11px; font-weight: 700; color: #10b981; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 8px; font-family: 'Plus Jakarta Sans', sans-serif; }
    .rpr-heading { font-size: 26px; font-weight: 800; color: #0f172a; letter-spacing: -0.04em; margin-bottom: 6px; font-family: 'Plus Jakarta Sans', sans-serif; }
    .rpr-sub { font-size: 13.5px; color: #64748b; margin-bottom: 28px; }

    .rpr-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .rpr-grid .full { grid-column: span 2; }

    .rpr-field { margin-bottom: 0; }
    .rpr-label { display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px; font-family: 'Plus Jakarta Sans', sans-serif; }
    .rpr-input-wrap { position: relative; }
    .rpr-input-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: #94a3b8; display: flex; align-items: center; pointer-events: none; }
    .rpr-input {
        width: 100%;
        height: 46px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 11px;
        padding: 0 14px 0 42px;
        font-size: 13.5px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #0f172a;
        outline: none;
        transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
    }
    .rpr-input.no-icon { padding-left: 14px; }
    .rpr-input:focus { border-color: #10b981; background: #fff; box-shadow: 0 0 0 3.5px rgba(16,185,129,0.1); }
    .rpr-input::placeholder { color: #94a3b8; }

    select.rpr-input { padding-left: 14px; cursor: pointer; appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; }

    .rpr-submit {
        width: 100%;
        height: 50px;
        background: linear-gradient(135deg, #10b981, #34d399);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        box-shadow: 0 8px 24px rgba(16,185,129,0.35);
        transition: all 0.2s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        margin-top: 22px;
    }
    .rpr-submit:hover { background: linear-gradient(135deg, #059669, #10b981); box-shadow: 0 12px 32px rgba(16,185,129,0.45); transform: translateY(-1px); }
    .rpr-submit:active { transform: scale(0.99); }

    .rpr-login-text { text-align: center; font-size: 13px; color: #64748b; margin-top: 18px; font-family: 'Plus Jakarta Sans', sans-serif; }
    .rpr-login-text a { color: #10b981; font-weight: 700; text-decoration: none; }
    .rpr-login-text a:hover { color: #059669; }

    @media (max-width: 900px) {
        .reg-card { flex-direction: column; }
        .reg-panel-left { width: 100%; padding: 32px 28px; }
        .reg-panel-right { padding: 32px 28px; max-height: none; }
        .rpl-steps { display: none; }
    }
    @media (max-width: 560px) {
        .rpr-grid { grid-template-columns: 1fr; }
        .rpr-grid .full { grid-column: span 1; }
        .reg-panel-right { padding: 24px 20px; }
    }
</style>

<div class="reg-page-bg">
    @include('layouts.header')

    <div class="reg-page-center">
        <div class="reg-card">

            {{-- LEFT PANEL --}}
            <div class="reg-panel-left">
                <div class="rpl-brand">
                    <div class="rpl-brand-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <div>
                        <div class="rpl-brand-name">Physiopii</div>
                        <div class="rpl-brand-sub">Patient Portal</div>
                    </div>
                </div>

                <div class="rpl-main">
                    <div class="rpl-icon-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,0.9)" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                    <p class="rpl-title">Create Your<br>Account</p>
                    <p class="rpl-desc">Join thousands of patients managing their physiotherapy journey with us.</p>
                </div>

                <div class="rpl-steps">
                    <div class="rpl-step"><div class="rpl-step-num">1</div><span class="rpl-step-text">Fill in your details</span></div>
                    <div class="rpl-step"><div class="rpl-step-num">2</div><span class="rpl-step-text">Book an appointment</span></div>
                    <div class="rpl-step"><div class="rpl-step-num">3</div><span class="rpl-step-text">Track your recovery</span></div>
                </div>
            </div>

            {{-- RIGHT PANEL --}}
            <div class="reg-panel-right">
                <p class="rpr-eyebrow">New Account</p>
                <h1 class="rpr-heading">Patient Registration</h1>
                <p class="rpr-sub">Fill in all fields to get started. It takes less than 2 minutes.</p>

                <form action="{{ route('patient.register.store') }}" method="POST">
                    @csrf
                    <div class="rpr-grid">

                        <div class="rpr-field full">
                            <label class="rpr-label" for="name">Full Name</label>
                            <div class="rpr-input-wrap">
                                <span class="rpr-input-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></span>
                                <input type="text" id="name" name="name" class="rpr-input" placeholder="Your full name" value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <div class="rpr-field">
                            <label class="rpr-label" for="email">Email Address</label>
                            <div class="rpr-input-wrap">
                                <span class="rpr-input-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 01-2.06 0L2 7"/></svg></span>
                                <input type="email" id="email" name="email" class="rpr-input" placeholder="you@email.com" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="rpr-field">
                            <label class="rpr-label" for="phone">Phone Number</label>
                            <div class="rpr-input-wrap">
                                <span class="rpr-input-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 15.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></span>
                                <input type="text" id="phone" name="phone" class="rpr-input" placeholder="Mobile number" value="{{ old('phone') }}" required>
                            </div>
                        </div>

                        <div class="rpr-field">
                            <label class="rpr-label" for="dob">Date of Birth</label>
                            <input type="date" id="dob" name="dob" class="rpr-input no-icon" value="{{ old('dob') }}" required>
                        </div>

                        <div class="rpr-field">
                            <label class="rpr-label" for="gender">Gender</label>
                            <select id="gender" name="gender" class="rpr-input" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender')=='male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender')=='other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="rpr-field">
                            <label class="rpr-label" for="password">Password</label>
                            <div class="rpr-input-wrap">
                                <span class="rpr-input-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 11V7a5 5 0 0110 0v4"/></svg></span>
                                <input type="password" id="password" name="password" class="rpr-input" placeholder="Create password" required>
                            </div>
                        </div>

                        <div class="rpr-field">
                            <label class="rpr-label" for="password_confirmation">Confirm Password</label>
                            <div class="rpr-input-wrap">
                                <span class="rpr-input-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></span>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="rpr-input" placeholder="Confirm password" required>
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="rpr-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        Create Account
                    </button>
                </form>

                <p class="rpr-login-text">Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Registration Error',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonColor: '#10b981',
        customClass: { popup: 'swal-pj' }
    });
</script>
@endif
<style>.swal-pj { font-family: 'Plus Jakarta Sans', sans-serif !important; border-radius: 16px !important; }</style>
@endsection