@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Login — Physiopii</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .login-page-bg {
        min-height: 100vh;
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 40%, #f8faff 100%);
        display: flex;
        flex-direction: column;
    }

    .login-page-center {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    /* ── CARD ── */
    .login-card {
        width: 100%;
        max-width: 980px;
        display: flex;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 24px 80px rgba(14,165,233,0.12), 0 4px 20px rgba(0,0,0,0.06);
        background: #fff;
    }

    /* ── LEFT PANEL ── */
    .login-panel-left {
        width: 42%;
        background: linear-gradient(160deg, #0c4a6e 0%, #0369a1 50%, #0284c7 100%);
        padding: 52px 44px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }
    .login-panel-left::before {
        content: '';
        position: absolute;
        right: -60px; top: -60px;
        width: 240px; height: 240px;
        border-radius: 50%;
        background: rgba(56,189,248,0.12);
    }
    .login-panel-left::after {
        content: '';
        position: absolute;
        left: -40px; bottom: -40px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(186,230,253,0.08);
    }

    .lpl-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        z-index: 1;
    }
    .lpl-brand-icon {
        width: 40px; height: 40px;
        background: rgba(255,255,255,0.18);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        backdrop-filter: blur(10px);
    }
    .lpl-brand-name {
        font-size: 16px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.02em;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .lpl-brand-sub { font-size: 11.5px; color: rgba(255,255,255,0.55); font-weight: 500; margin-top: 2px; }

    .lpl-main { position: relative; z-index: 1; }
    .lpl-icon-wrap {
        width: 70px; height: 70px;
        background: rgba(255,255,255,0.12);
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 24px;
        backdrop-filter: blur(10px);
    }
    .lpl-title {
        font-size: 28px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.04em;
        line-height: 1.2;
        margin-bottom: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .lpl-desc { font-size: 14px; color: rgba(255,255,255,0.6); line-height: 1.7; }

    .lpl-features { position: relative; z-index: 1; display: flex; flex-direction: column; gap: 12px; }
    .lpl-feature {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 12px;
        padding: 12px 16px;
        backdrop-filter: blur(10px);
    }
    .lpl-feature-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .lpl-feature-dot.teal  { background: #38bdf8; box-shadow: 0 0 8px rgba(56,189,248,0.6); }
    .lpl-feature-dot.green { background: #34d399; box-shadow: 0 0 8px rgba(52,211,153,0.6); }
    .lpl-feature-dot.amber { background: #fbbf24; box-shadow: 0 0 8px rgba(251,191,36,0.6); }
    .lpl-feature-text { font-size: 13px; color: rgba(255,255,255,0.8); font-weight: 500; }

    /* ── RIGHT PANEL ── */
    .login-panel-right {
        flex: 1;
        padding: 52px 52px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .lpr-eyebrow {
        font-size: 11px;
        font-weight: 700;
        color: #0ea5e9;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .lpr-heading {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.04em;
        margin-bottom: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .lpr-sub { font-size: 14px; color: #64748b; margin-bottom: 32px; }

    /* Fields */
    .lpr-field { margin-bottom: 18px; }
    .lpr-label {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 7px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .lpr-input-wrap { position: relative; }
    .lpr-input-icon {
        position: absolute;
        left: 14px; top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        display: flex; align-items: center;
        pointer-events: none;
    }
    .lpr-input {
        width: 100%;
        height: 48px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 0 14px 0 44px;
        font-size: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #0f172a;
        outline: none;
        transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
    }
    .lpr-input:focus {
        border-color: #0ea5e9;
        background: #fff;
        box-shadow: 0 0 0 3.5px rgba(14,165,233,0.12);
    }
    .lpr-input::placeholder { color: #94a3b8; }

    .lpr-opts {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 6px 0 24px;
    }
    .lpr-remember {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #64748b;
        cursor: pointer;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .lpr-remember input { accent-color: #0ea5e9; width: 15px; height: 15px; }
    .lpr-forgot { font-size: 13px; color: #0ea5e9; font-weight: 600; text-decoration: none; }
    .lpr-forgot:hover { color: #0284c7; }

    .lpr-submit {
        width: 100%;
        height: 50px;
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        letter-spacing: -0.01em;
        box-shadow: 0 8px 24px rgba(14,165,233,0.35);
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .lpr-submit:hover {
        background: linear-gradient(135deg, #0284c7, #0ea5e9);
        box-shadow: 0 12px 32px rgba(14,165,233,0.45);
        transform: translateY(-1px);
    }
    .lpr-submit:active { transform: scale(0.99); }

    .lpr-register-text {
        text-align: center;
        font-size: 13.5px;
        color: #64748b;
        margin-top: 20px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .lpr-register-text a { color: #0ea5e9; font-weight: 700; text-decoration: none; }
    .lpr-register-text a:hover { color: #0284c7; }

    /* Responsive */
    @media (max-width: 768px) {
        .login-card { flex-direction: column; }
        .login-panel-left { width: 100%; padding: 36px 28px; }
        .login-panel-right { padding: 36px 28px; }
        .lpl-features { display: none; }
    }
    @media (max-width: 420px) {
        .login-panel-right { padding: 28px 20px; }
    }
</style>

<div class="login-page-bg">
    @include('layouts.header')

    <div class="login-page-center">
        <div class="login-card">

            {{-- LEFT PANEL --}}
            <div class="login-panel-left">
                <div class="lpl-brand">
                    <div class="lpl-brand-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="lpl-brand-name">Physiopii</div>
                        <div class="lpl-brand-sub">Patient Portal</div>
                    </div>
                </div>

                <div class="lpl-main">
                    <div class="lpl-icon-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,0.9)" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <p class="lpl-title">Welcome<br>Back!</p>
                    <p class="lpl-desc">Sign in to manage your appointments and health records with ease.</p>
                </div>

                <div class="lpl-features">
                    <div class="lpl-feature">
                        <div class="lpl-feature-dot teal"></div>
                        <span class="lpl-feature-text">Track your appointments</span>
                    </div>
                    <div class="lpl-feature">
                        <div class="lpl-feature-dot green"></div>
                        <span class="lpl-feature-text">View billing & invoices</span>
                    </div>
                    <div class="lpl-feature">
                        <div class="lpl-feature-dot amber"></div>
                        <span class="lpl-feature-text">Manage health records</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT PANEL --}}
            <div class="login-panel-right">
                <p class="lpr-eyebrow">Patient Portal</p>
                <h1 class="lpr-heading">Sign in to your account</h1>
                <p class="lpr-sub">Enter your credentials to continue.</p>

                <form method="POST" action="{{ route('patient.login.check') }}">
                    @csrf

                    <div class="lpr-field">
                        <label class="lpr-label" for="phone">Phone Number</label>
                        <div class="lpr-input-wrap">
                            <span class="lpr-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 15.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <input type="text" id="phone" name="phone" class="lpr-input" placeholder="Enter your phone number" required autocomplete="username">
                        </div>
                    </div>

                    <div class="lpr-field">
                        <label class="lpr-label" for="password">Password</label>
                        <div class="lpr-input-wrap">
                            <span class="lpr-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            </span>
                            <input type="password" id="password" name="password" class="lpr-input" placeholder="••••••••" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="lpr-opts">
                        <label class="lpr-remember">
                            <input type="checkbox" name="remember"> Keep me signed in
                        </label>
                        <a href="#" class="lpr-forgot">Forgot password?</a>
                    </div>

                    <button type="submit" class="lpr-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14"/></svg>
                        Sign In
                    </button>
                </form>

                <p class="lpr-register-text">
                    Don't have an account? <a href="/patient-register">Create one free</a>
                </p>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Login Failed',
        text: 'Invalid phone number or password. Please try again.',
        confirmButtonColor: '#0ea5e9',
        customClass: { popup: 'swal-pj' }
    });
</script>
@endif
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Welcome Back!',
        text: 'Login successful. Redirecting...',
        timer: 1800,
        showConfirmButton: false,
        customClass: { popup: 'swal-pj' }
    });
</script>
@endif
<style>
    .swal-pj { font-family: 'Plus Jakarta Sans', sans-serif !important; border-radius: 16px !important; }
</style>
@endsection