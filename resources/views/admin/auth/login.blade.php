<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BookmyRehab</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    *, *::before, *::after { box-sizing: border-box; }

    body {
        background: #f1f5f9;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', sans-serif;
        padding: 20px;
        margin: 0;
    }

    /* ── WRAPPER ── */
    .login-wrapper {
        max-width: 920px;
        width: 100%;
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,.07), 0 20px 50px -10px rgba(0,0,0,.12);
        display: flex;
        min-height: 560px;
    }

    /* ── LEFT PANEL ── */
    .login-left {
        width: 44%;
        background: #0A1628;
        padding: 44px 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }

    .login-left::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 15% 85%, rgba(59,130,246,0.10) 0%, transparent 50%),
            radial-gradient(circle at 85% 15%, rgba(99,179,237,0.07) 0%, transparent 50%);
        pointer-events: none;
    }

    /* Brand */
    .left-brand {
        display: flex;
        align-items: center;
        gap: 11px;
        position: relative;
        z-index: 1;
    }

    .brand-icon {
        width: 36px;
        height: 36px;
        background: #2563EB;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .brand-icon svg { display: block; }

    .brand-name {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        letter-spacing: -0.01em;
        line-height: 1.2;
    }

    .brand-sub {
        font-size: 11px;
        color: rgba(255,255,255,0.4);
        font-weight: 400;
        margin-top: 2px;
    }

    /* ECG */
    .ecg-wrap {
        position: relative;
        z-index: 1;
        margin: 0 -6px;
    }

    .ecg-line {
        stroke-dasharray: 400;
        stroke-dashoffset: 400;
        animation: ecgDraw 2.4s cubic-bezier(0.4,0,0.2,1) 0.5s forwards;
    }

    @keyframes ecgDraw {
        to { stroke-dashoffset: 0; }
    }

    /* Content */
    .left-content {
        position: relative;
        z-index: 1;
    }

    .left-title {
        font-size: 24px;
        font-weight: 700;
        color: #fff;
        line-height: 1.25;
        letter-spacing: -0.03em;
        margin: 0 0 10px;
    }

    .left-desc {
        font-size: 13px;
        color: rgba(255,255,255,0.48);
        line-height: 1.65;
        margin: 0;
        font-weight: 400;
    }

    /* Stats */
    .left-stats {
        display: flex;
        gap: 10px;
        position: relative;
        z-index: 1;
    }

    .stat-chip {
        background: rgba(255,255,255,0.06);
        border: 0.5px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 12px 14px;
        flex: 1;
    }

    .stat-val {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        line-height: 1;
        letter-spacing: -0.03em;
    }

    .stat-lbl {
        font-size: 11px;
        color: rgba(255,255,255,0.38);
        margin-top: 4px;
        font-weight: 400;
    }

    /* ── RIGHT PANEL ── */
    .login-right {
        flex: 1;
        padding: 56px 52px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .right-eyebrow {
        font-size: 11px;
        font-weight: 600;
        color: #2563EB;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin: 0 0 10px;
    }

    .right-heading {
        font-size: 26px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.03em;
        margin: 0 0 4px;
    }

    .right-sub {
        font-size: 13px;
        color: #64748b;
        margin: 0 0 32px;
        font-weight: 400;
    }

    /* Fields */
    .field-group {
        margin-bottom: 16px;
    }

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
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
        display: flex;
        align-items: center;
    }

    .field-input {
        width: 100%;
        height: 46px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
        padding: 0 14px 0 42px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        color: #0f172a;
        outline: none;
        transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
    }

    .field-input:focus {
        border-color: #2563EB;
        border-width: 1.5px;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    .field-input::placeholder {
        color: #94a3b8;
    }

    /* Options row */
    .options-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 6px 0 24px;
    }

    .remember-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: #64748b;
        cursor: pointer;
        user-select: none;
    }

    .remember-label input[type="checkbox"] {
        width: 15px;
        height: 15px;
        accent-color: #2563EB;
        cursor: pointer;
    }

    .forgot-link {
        font-size: 12.5px;
        color: #2563EB;
        font-weight: 500;
        text-decoration: none;
    }

    .forgot-link:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    /* Login button */
    .login-btn {
        width: 100%;
        height: 48px;
        background: #2563EB;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        letter-spacing: -0.01em;
        transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .login-btn:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 14px rgba(37,99,235,0.35);
    }

    .login-btn:active {
        transform: scale(0.99);
    }

    /* Divider */
    .divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 22px 0;
    }

    .divider-line {
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    .divider-text {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
    }

    /* SSO button */
    .sso-btn {
        width: 100%;
        height: 46px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #fff;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        color: #334155;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: background 0.15s, border-color 0.15s;
    }

    .sso-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* Footer badge */
    .login-footer {
        margin-top: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .status-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 500;
        color: #15803d;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #22c55e;
        animation: pulseDot 2s ease-in-out infinite;
    }

    @keyframes pulseDot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.35; }
    }

    .footer-text {
        font-size: 11px;
        color: #94a3b8;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .login-wrapper {
            flex-direction: column;
            min-height: auto;
        }

        .login-left {
            width: 100%;
            padding: 36px 28px;
            gap: 28px;
        }

        .left-stats {
            gap: 8px;
        }

        .login-right {
            padding: 40px 28px;
        }

        .right-heading {
            font-size: 22px;
        }
    }

    @media (max-width: 400px) {
        .login-right {
            padding: 32px 20px;
        }
    }
</style>
</head>

<body>

<div class="login-wrapper">

    <!-- ── LEFT PANEL ── -->
    <div class="login-left">

        <div class="left-brand">
            <div class="brand-icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M10 3v4M10 13v4M3 10h4M13 10h4" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="10" cy="10" r="3" fill="#fff"/>
                </svg>
            </div>
            <div>
                <div class="brand-name">BookmyRehab</div>
                <div class="brand-sub">Healthcare Management</div>
            </div>
        </div>

        <!-- Animated ECG line -->
        <div class="ecg-wrap">
            <svg viewBox="0 0 260 70" fill="none" xmlns="http://www.w3.org/2000/svg" width="100%" aria-hidden="true">
                <path class="ecg-line"
                    d="M0 42 L30 42 L38 42 L44 14 L50 62 L56 42 L80 42
                       L86 42 L92 14 L98 62 L104 42 L130 42
                       L136 42 L142 14 L148 62 L154 42 L180 42
                       L186 42 L192 14 L198 62 L204 42 L260 42"
                    stroke="#3B82F6" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="left-content">
            <p class="left-title">Doctor Admin<br>Portal</p>
            <p class="left-desc">Manage patients, appointments, and clinical operations from a single secure dashboard.</p>
        </div>

        <div class="left-stats">
            <div class="stat-chip">
                <div class="stat-val">2.4k</div>
                <div class="stat-lbl">Patients</div>
            </div>
            <div class="stat-chip">
                <div class="stat-val">18</div>
                <div class="stat-lbl">Today's appts</div>
            </div>
            <div class="stat-chip">
                <div class="stat-val">99.9%</div>
                <div class="stat-lbl">Uptime</div>
            </div>
        </div>

    </div>

    <!-- ── RIGHT PANEL ── -->
    <div class="login-right">

        <p class="right-eyebrow">Secure access</p>
        <h1 class="right-heading">Sign in</h1>
        <p class="right-sub">Enter your credentials to access the admin panel.</p>

        <form method="POST" action="{{ route('admin.login.check') }}">
            @csrf

            <div class="field-group">
                <label class="field-label" for="email">Email address</label>
                <div class="field-wrap">
                    <span class="field-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                    </span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="field-input"
                        placeholder="doctor@clinic.com"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                    >
                </div>
            </div>

            <div class="field-group">
                <label class="field-label" for="password">Password</label>
                <div class="field-wrap">
                    <span class="field-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="field-input"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                </div>
            </div>

            <div class="options-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember">
                    Keep me signed in
                </label>
                <!-- <a href="#" class="forgot-link">Forgot password?</a> -->
            </div>

            <button type="submit" class="login-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Sign in
            </button>

        </form>
      

        <div class="login-footer">
            <div class="status-badge">
                <div class="status-dot"></div>
                All systems operational
            </div>
            <span class="footer-text">· HIPAA compliant</span>
        </div>

    </div>

</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        title: 'Login Successful!',
        text: 'Welcome back. Redirecting to your dashboard…',
        icon: 'success',
        timer: 2000,
        showConfirmButton: false,
        customClass: { popup: 'swal-font' }
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Access Denied',
        text: 'Invalid email or password. Please try again.',
        confirmButtonColor: '#2563EB',
        customClass: { popup: 'swal-font' }
    });
</script>
@endif

<style>
    .swal-font { font-family: 'Inter', sans-serif !important; }
</style>

</body>
</html>