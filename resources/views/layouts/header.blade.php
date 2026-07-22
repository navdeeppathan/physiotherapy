{{-- ── PATIENT HEADER ── --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    *, *::before, *::after { box-sizing: border-box; }

    body {
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        background: #f8fafd;
        margin: 0;
    }

    /* ── NAVBAR ── */
    .pt-navbar {
        position: sticky;
        top: 0;
        z-index: 1000;
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 1px 20px rgba(0,0,0,0.06);
        padding: 0;
        /* Prevent backdrop-filter from creating a stacking context that traps modals */
        isolation: isolate;
    }

    .pt-nav-inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px;
        height: 68px;
        display: flex;
        align-items: center;
        gap: 32px;
    }

    /* Logo */
    .pt-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        flex-shrink: 0;
    }
    .pt-logo-img { height: 36px; width: auto; object-fit: contain; }
    .pt-logo-text {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.03em;
    }
    .pt-logo-text span { color: #0ea5e9; }

    /* Nav links */
    .pt-nav-links {
        display: flex;
        align-items: center;
        gap: 4px;
        flex: 1;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .pt-nav-links li a {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        transition: all 0.18s;
    }
    .pt-nav-links li a:hover, .pt-nav-links li.active a {
        background: #f0f9ff;
        color: #0ea5e9;
    }
    .pt-nav-links li.active a { font-weight: 700; }

    /* Right actions */
    .pt-nav-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: auto;
    }

    .pt-contact-pill {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 50px;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 600;
        color: #0369a1;
        text-decoration: none;
    }
    .pt-contact-pill svg { width: 14px; height: 14px; flex-shrink: 0; }

    .pt-btn-login {
        padding: 8px 18px;
        border-radius: 9px;
        font-size: 14px;
        font-weight: 600;
        border: 1.5px solid #e2e8f0;
        color: #334155;
        background: #fff;
        text-decoration: none;
        transition: all 0.18s;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .pt-btn-login:hover { border-color: #0ea5e9; color: #0ea5e9; background: #f0f9ff; }

    .pt-btn-signup {
        padding: 8px 18px;
        border-radius: 9px;
        font-size: 14px;
        font-weight: 700;
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        color: #fff;
        text-decoration: none;
        border: none;
        transition: all 0.18s;
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 12px rgba(14,165,233,0.3);
    }
    .pt-btn-signup:hover {
        background: linear-gradient(135deg, #0284c7, #0ea5e9);
        box-shadow: 0 6px 18px rgba(14,165,233,0.4);
        transform: translateY(-1px);
    }

    /* User dropdown */
    .pt-user-menu {
        position: relative;
    }
    .pt-user-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 14px 5px 6px;
        background: #f0f9ff;
        border: 1.5px solid #bae6fd;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.18s;
        text-decoration: none;
    }
    .pt-user-btn:hover { border-color: #0ea5e9; background: #e0f2fe; }
    .pt-user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }
    .pt-user-name {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
    }
    .pt-user-chevron {
        width: 14px;
        height: 14px;
        color: #64748b;
        transition: transform 0.2s;
    }
    .pt-user-menu:hover .pt-user-chevron { transform: rotate(180deg); }

    .pt-dropdown {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        min-width: 200px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
        padding: 8px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-8px);
        transition: all 0.2s;
        z-index: 2000;
    }
    .pt-user-menu:hover .pt-dropdown {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    .pt-dropdown-user {
        padding: 10px 12px 12px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 8px;
    }
    .pt-dropdown-user-name { font-size: 14px; font-weight: 700; color: #0f172a; }
    .pt-dropdown-user-role { font-size: 12px; color: #64748b; margin-top: 2px; }
    .pt-dropdown a, .pt-dropdown button {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 600;
        color: #334155;
        text-decoration: none;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.15s;
        text-align: left;
    }
    .pt-dropdown a:hover, .pt-dropdown button:hover { background: #f8fafc; color: #0ea5e9; }
    .pt-dropdown .logout-item { color: #ef4444; }
    .pt-dropdown .logout-item:hover { background: #fef2f2; color: #dc2626; }

    /* Mobile burger */
    .pt-burger {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        color: #334155;
        padding: 6px;
        margin-left: auto;
    }

    /* Mobile drawer */
    .pt-mobile-nav {
        display: none;
        position: fixed;
        top: 68px;
        left: 0;
        right: 0;
        background: rgba(255,255,255,0.98);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid #e2e8f0;
        padding: 16px 24px 20px;
        z-index: 999;
        flex-direction: column;
        gap: 8px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }
    .pt-mobile-nav.open { display: flex; }
    .pt-mobile-nav a {
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
    }
    .pt-mobile-nav a:hover { background: #f0f9ff; color: #0ea5e9; }
    .pt-mobile-nav .pt-btn-signup { justify-content: center; margin-top: 8px; }

    @media (max-width: 768px) {
        .pt-nav-links, .pt-nav-actions { display: none; }
        .pt-burger { display: flex; }
    }
</style>

<nav class="pt-navbar">
    <div class="pt-nav-inner">
        <a href="/" class="pt-logo">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="pt-logo-img">
        </a>

        <ul class="pt-nav-links">
            <li class="active"><a href="/">Home</a></li>
        </ul>

        <div class="pt-nav-actions">
            <a href="tel:+13153695943" class="pt-contact-pill">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 15.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                +1 315 369 5943
            </a>

            @guest
                <a href="{{ route('login') }}" class="pt-btn-login">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Login
                </a>
                <a href="{{ route('patient.register') }}" class="pt-btn-signup">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Sign Up Free
                </a>
            @endguest

            @auth
                <div class="pt-user-menu">
                    <div class="pt-user-btn">
                        <img
                            src="{{ Auth::user()->profile_img ? asset(Auth::user()->profile_img) : asset('assets/img/patients/patient.jpg') }}"
                            alt="{{ Auth::user()->name }}"
                            class="pt-user-avatar">
                        <span class="pt-user-name">{{ Auth::user()->name }}</span>
                        <svg class="pt-user-chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    <div class="pt-dropdown">
                        <div class="pt-dropdown-user">
                            <div class="pt-dropdown-user-name">{{ Auth::user()->name }}</div>
                            <div class="pt-dropdown-user-role">{{ ucfirst(Auth::user()->role ?? 'Patient') }}</div>
                        </div>
                        <a href="{{ route('patient.dashboard') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                            Dashboard
                        </a>
                        <form action="{{ route('patient.logout') }}" method="GET">
                            @csrf
                            <button type="submit" class="logout-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>

        <button class="pt-burger" id="ptBurger" onclick="document.getElementById('ptMobileNav').classList.toggle('open')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>
</nav>

<div class="pt-mobile-nav" id="ptMobileNav">
    <a href="/">Home</a>
    @guest
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('patient.register') }}" class="pt-btn-signup">Sign Up Free</a>
    @endguest
    @auth
        <a href="{{ route('patient.dashboard') }}">Dashboard</a>
        <form action="{{ route('patient.logout') }}" method="GET">
            @csrf
            <button type="submit" style="background:none;border:none;cursor:pointer;padding:10px 14px;color:#ef4444;font-size:15px;font-weight:600;text-align:left;width:100%;">Logout</button>
        </form>
    @endauth
</div>