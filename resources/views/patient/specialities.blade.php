@extends('layouts.app')

@section('title', 'Specialities & Physiotherapists — PhysioPii Healthcare')
@section('meta_description', 'Explore all physiotherapy specialities, conditions, and certified specialist doctors at PhysioPii. Back pain, knee rehab, sports injuries, post-surgery, and neurological recovery.')
@section('meta_keywords', 'physiotherapy specialities, back pain physiotherapist, knee rehab doctor, stroke rehabilitation, sports injury physio, certified physiotherapists India')

@section('content')

<style>
:root {
    --brand-teal:        #0c6978;
    --brand-teal-hover:  #08535f;
    --brand-teal-light:  #e8f4f5;
    --brand-teal-soft:   #f0f8f8;
    --brand-dark-teal:   #0a3d46;
    --brand-forest-dark: #082d33;
    
    --text-primary:      #09282e;
    --text-secondary:    #475569;
    --text-muted:        #64748b;
    --text-subtle:       #94a3b8;
    
    --card-border:       #e2ebec;
    --card-border-subtle:#edf2f4;
    --card-bg:           #ffffff;
    --page-bg:           #fbfdfd;
    --input-border:      #d7e6e8;
    
    --radius-sm:         8px;
    --radius-md:         12px;
    --radius-lg:         18px;
    --radius-xl:         24px;
    
    --shadow-subtle:     0 4px 18px rgba(9, 40, 46, 0.04);
    --shadow-card:       0 8px 30px rgba(9, 40, 46, 0.06);
    --shadow-elevated:   0 16px 40px rgba(12, 105, 120, 0.10);
}

*, *::before, *::after {
    box-sizing: border-box;
}

body, input, button, select, textarea, h1, h2, h3, h4, h5, h6, p, a, span {
    font-family: 'Newsreader', Georgia, serif !important;
}

body {
    background-color: var(--page-bg);
    color: var(--text-primary);
    line-height: 1.55;
    -webkit-font-smoothing: antialiased;
}

a {
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
}

.kn-container {
    width: 100%;
    max-width: 1260px;
    margin-left: auto;
    margin-right: auto;
    padding-left: 24px;
    padding-right: 24px;
}

/* ── NAVBAR ── */
.kn-navbar-wrapper {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: #ffffff;
    border-bottom: 1px solid var(--card-border-subtle);
    box-shadow: var(--shadow-subtle);
}
.kn-nav-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 78px;
}
.kn-brand-link {
    display: inline-flex;
    align-items: center;
}
.kn-brand-logo-img {
    height: 48px;
    width: auto;
    max-width: 190px;
    object-fit: contain;
    display: block;
}
.kn-nav-menu {
    display: flex;
    align-items: center;
    gap: 32px;
    list-style: none;
    margin: 0;
    padding: 0;
}
.kn-nav-item a {
    font-size: 15.5px;
    font-weight: 600;
    color: var(--text-secondary);
    position: relative;
    padding: 6px 0;
}
.kn-nav-item a:hover,
.kn-nav-item a.active {
    color: var(--brand-teal);
}
.kn-nav-item a.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 2.5px;
    background: var(--brand-teal);
    border-radius: 2px;
}
.kn-nav-actions {
    display: flex;
    align-items: center;
    gap: 16px;
}
.kn-login-link {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    padding: 8px 16px;
}
.kn-btn-nav-book {
    background: var(--brand-teal);
    color: #ffffff !important;
    padding: 10px 22px;
    border-radius: 999px;
    font-size: 14.5px;
    font-weight: 700;
    box-shadow: 0 4px 14px rgba(12, 105, 120, 0.25);
}
.kn-btn-nav-book:hover {
    background: var(--brand-teal-hover);
    transform: translateY(-1px);
}
.kn-mobile-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 22px;
    color: var(--text-primary);
    cursor: pointer;
}

/* Mobile Drawer */
.kn-mobile-drawer {
    display: none;
    background: #ffffff;
    border-bottom: 1px solid var(--card-border);
    padding: 20px 24px 28px;
}
.kn-mobile-drawer.open {
    display: block;
}
.kn-mobile-menu-list {
    list-style: none;
    padding: 0;
    margin: 0 0 18px;
}
.kn-mobile-menu-list li a {
    display: block;
    padding: 12px 0;
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
    border-bottom: 1px solid #f0f4f5;
}

/* ── HERO BANNER ── */
.kn-page-hero {
    background: linear-gradient(180deg, #f0f8f8 0%, #ffffff 100%);
    padding: 56px 0 40px;
    border-bottom: 1px solid var(--card-border-subtle);
}
.kn-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--brand-teal);
    margin-bottom: 12px;
}
.kn-eyebrow-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--brand-teal);
}
.kn-hero-title {
    font-size: clamp(32px, 4vw, 44px);
    font-weight: 700;
    color: var(--brand-slate-deep, #09282e);
    letter-spacing: -0.025em;
    margin-bottom: 12px;
}
.kn-hero-desc {
    font-size: 17px;
    color: var(--text-secondary);
    max-width: 720px;
    line-height: 1.6;
    margin-bottom: 28px;
}

/* Search & Filter Bar */
.kn-search-filter-box {
    display: flex;
    align-items: center;
    background: #ffffff;
    border: 1.5px solid var(--card-border);
    border-radius: var(--radius-lg);
    padding: 6px 14px;
    max-width: 580px;
    box-shadow: var(--shadow-subtle);
    transition: border-color 0.2s, box-shadow 0.2s;
}
.kn-search-filter-box:focus-within {
    border-color: var(--brand-teal);
    box-shadow: 0 0 0 4px rgba(12, 105, 120, 0.12);
}
.kn-search-filter-box i {
    color: var(--brand-teal);
    font-size: 16px;
    margin-right: 12px;
}
.kn-search-filter-box input {
    border: none;
    outline: none;
    width: 100%;
    font-size: 15.5px;
    color: var(--text-primary);
    background: transparent;
}

/* Quick condition pills */
.kn-pills-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 24px;
}
.kn-condition-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #ffffff;
    border: 1px solid var(--card-border);
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.2s ease;
}
.kn-condition-pill:hover,
.kn-condition-pill.active {
    background: var(--brand-teal);
    border-color: var(--brand-teal);
    color: #ffffff;
    transform: translateY(-1px);
}
.kn-condition-pill.active {
    box-shadow: 0 4px 12px rgba(12, 105, 120, 0.25);
}

/* ── CONDITIONS DIRECTORY MAIN ── */
.kn-directory-section {
    padding: 50px 0 80px;
}
.kn-condition-block {
    background: #ffffff;
    border: 1.5px solid var(--card-border);
    border-radius: var(--radius-xl);
    padding: 32px 30px;
    margin-bottom: 36px;
    box-shadow: var(--shadow-card);
    transition: border-color 0.25s, box-shadow 0.25s;
    scroll-margin-top: 100px;
}
.kn-condition-block:hover {
    border-color: var(--brand-teal);
    box-shadow: var(--shadow-elevated);
}
.kn-cond-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    padding-bottom: 22px;
    border-bottom: 1.5px solid var(--card-border-subtle);
    margin-bottom: 26px;
}
.kn-cond-identity {
    display: flex;
    align-items: flex-start;
    gap: 18px;
}
.kn-cond-icon-box {
    width: 58px;
    height: 58px;
    border-radius: var(--radius-md);
    background: var(--brand-teal-light);
    color: var(--brand-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
    overflow: hidden;
}
.kn-cond-icon-img {
    width: 36px;
    height: 36px;
    object-fit: contain;
    border-radius: 4px;
}
.kn-cond-info h2 {
    font-size: 24px;
    font-weight: 700;
    color: var(--brand-dark-teal);
    margin-bottom: 6px;
}
.kn-cond-info p {
    font-size: 14.5px;
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 0;
    max-width: 780px;
}
.kn-cond-count-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--brand-teal-soft);
    border: 1px solid var(--brand-teal);
    color: var(--brand-teal);
    font-size: 13px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 999px;
    white-space: nowrap;
}

/* Doctors Sub-grid */
.kn-specialists-subgrid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}
.kn-doc-card-inner {
    background: #fbfdfd;
    border: 1px solid var(--card-border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.22s, box-shadow 0.22s, border-color 0.22s;
}
.kn-doc-card-inner:hover {
    transform: translateY(-3px);
    border-color: var(--brand-teal);
    box-shadow: 0 10px 28px rgba(12, 105, 120, 0.09);
    background: #ffffff;
}
.kn-doc-card-media {
    position: relative;
    width: 100%;
    height: 190px;
    background: #edf3f4;
    overflow: hidden;
}
.kn-doc-card-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}
.kn-doc-card-inner:hover .kn-doc-card-media img {
    transform: scale(1.03);
}
.kn-doc-rating {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(255, 255, 255, 0.94);
    backdrop-filter: blur(6px);
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
    color: var(--text-primary);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}
.kn-doc-rating i {
    color: #f59e0b;
    margin-right: 3px;
}
.kn-doc-card-body {
    padding: 18px 20px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
.kn-doc-card-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--brand-slate-deep, #09282e);
    margin-bottom: 4px;
}
.kn-doc-card-qual {
    font-size: 12.5px;
    color: var(--text-muted);
    font-weight: 600;
    margin-bottom: 12px;
}
.kn-doc-card-loc {
    font-size: 12.5px;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 14px;
}
.kn-doc-card-loc i {
    color: var(--brand-teal);
}
.kn-doc-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 12px;
    border-top: 1px solid var(--card-border-subtle);
    margin-top: auto;
}
.kn-doc-fee {
    font-size: 17px;
    font-weight: 800;
    color: var(--brand-teal);
}
.kn-doc-fee small {
    font-size: 11px;
    font-weight: 500;
    color: var(--text-muted);
    display: block;
}
.kn-doc-actions {
    display: flex;
    gap: 8px;
}
.kn-btn-sm-profile {
    padding: 6px 12px;
    border: 1px solid var(--card-border);
    border-radius: 6px;
    font-size: 12.5px;
    font-weight: 700;
    color: var(--text-primary);
    background: #ffffff;
}
.kn-btn-sm-profile:hover {
    border-color: var(--brand-teal);
    color: var(--brand-teal);
}
.kn-btn-sm-book {
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 12.5px;
    font-weight: 700;
    color: #ffffff !important;
    background: var(--brand-teal);
}
.kn-btn-sm-book:hover {
    background: var(--brand-teal-hover);
}

/* Empty State within condition block */
.kn-cond-empty-box {
    background: #f8fbfa;
    border: 1.5px dashed var(--card-border);
    border-radius: var(--radius-md);
    padding: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}
.kn-cond-empty-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.kn-cond-empty-left i {
    font-size: 26px;
    color: var(--brand-teal);
}
.kn-cond-empty-left h5 {
    font-size: 15px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 3px;
}
.kn-cond-empty-left p {
    font-size: 13px;
    color: var(--text-muted);
    margin: 0;
}
.kn-btn-request-consult {
    background: var(--brand-teal);
    color: #ffffff !important;
    padding: 8px 18px;
    border-radius: 999px;
    font-size: 13.5px;
    font-weight: 700;
    white-space: nowrap;
}
.kn-btn-request-consult:hover {
    background: var(--brand-teal-hover);
}

/* ── FOOTER ── */
.kn-footer {
    background: var(--brand-slate-deep, #09282e);
    color: #ffffff;
    padding: 60px 0 28px;
    margin-top: 40px;
}
.kn-footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 40px;
    padding-bottom: 40px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}
.kn-footer-desc {
    color: #94a3b8;
    font-size: 14px;
    line-height: 1.6;
    margin-top: 14px;
    max-width: 320px;
}
.kn-footer-col h6 {
    font-size: 15px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 18px;
}
.kn-footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}
.kn-footer-links li {
    margin-bottom: 10px;
}
.kn-footer-links li a {
    color: #94a3b8;
    font-size: 14px;
}
.kn-footer-links li a:hover {
    color: #ffffff;
}
.kn-footer-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 24px;
    font-size: 13px;
    color: #94a3b8;
}

/* Responsive */
@media (max-width: 992px) {
    .kn-nav-menu, .kn-btn-nav-book {
        display: none;
    }
    .kn-mobile-toggle {
        display: block;
    }
    .kn-specialists-subgrid {
        grid-template-columns: repeat(2, 1fr);
    }
    .kn-footer-grid {
        grid-template-columns: 1fr 1fr;
    }
}
@media (max-width: 640px) {
    .kn-specialists-subgrid {
        grid-template-columns: 1fr;
    }
    .kn-cond-header-row {
        flex-direction: column;
        align-items: flex-start;
    }
    .kn-cond-empty-box {
        flex-direction: column;
        align-items: flex-start;
    }
    .kn-footer-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="kn-main-wrapper">

    {{-- ══════════════════════════════════════════════════
         1. TOP STICKY NAVBAR
    ══════════════════════════════════════════════════ --}}
    <header class="kn-navbar-wrapper" id="navbar">
        <div class="kn-container">
            <div class="kn-nav-inner">
                
                {{-- Brand Logo --}}
                <a href="{{ route('home') }}" class="kn-brand-link" aria-label="PhysioPii Home">
                    <img src="{{ asset('logo.png') }}" alt="PhysioPii - Move Better. Live Better." class="kn-brand-logo-img">
                </a>

                {{-- Desktop Nav Links --}}
                <ul class="kn-nav-menu">
                    <li class="kn-nav-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="kn-nav-item"><a href="{{ route('specialities.index') }}" class="active">Specialities</a></li>
                    <li class="kn-nav-item"><a href="{{ route('home') }}#specialists">Find Doctors</a></li>
                    <li class="kn-nav-item"><a href="{{ route('home') }}#how-it-works">How It Works</a></li>
                    <li class="kn-nav-item"><a href="{{ route('home') }}#about">About Us</a></li>
                    <li class="kn-nav-item"><a href="{{ route('home') }}#faq">FAQ</a></li>
                </ul>

                {{-- Right Nav Actions --}}
                <div class="kn-nav-actions">
                    @auth
                        @if(Auth::user()->role === 'patient')
                            <a href="{{ route('patient.dashboard') }}" class="kn-login-link">Dashboard</a>
                        @elseif(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.appointments.index') }}" class="kn-login-link">Admin</a>
                        @else
                            <a href="{{ route('login') }}" class="kn-login-link">Portal</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="kn-login-link">Login</a>
                    @endauth

                    <a href="{{ route('home') }}#search-bar" class="kn-btn-nav-book">
                        Book Appointment
                    </a>

                    {{-- Mobile Hamburger --}}
                    <button class="kn-mobile-toggle" id="knMobileToggle" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>

            </div>
        </div>
    </header>

    {{-- Mobile Menu Drawer --}}
    <div class="kn-mobile-drawer" id="knMobileDrawer">
        <ul class="kn-mobile-menu-list">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('specialities.index') }}">Specialities</a></li>
            <li><a href="{{ route('home') }}#specialists">Find Doctors</a></li>
            <li><a href="{{ route('home') }}#how-it-works">How It Works</a></li>
            <li><a href="{{ route('home') }}#about">About Us</a></li>
            <li><a href="{{ route('home') }}#faq">FAQ</a></li>
            @auth
                <li><a href="{{ route('patient.dashboard') }}">My Dashboard</a></li>
                <li><a href="{{ route('patient.logout') }}">Logout</a></li>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('patient.register') }}">Register as Patient</a></li>
            @endauth
        </ul>
        <a href="{{ route('home') }}#search-bar" class="kn-btn-nav-book" style="display: block; text-align: center;">
            Book Appointment
        </a>
    </div>

    {{-- ══════════════════════════════════════════════════
         2. HERO BANNER & SEARCH
    ══════════════════════════════════════════════════ --}}
    <section class="kn-page-hero">
        <div class="kn-container">
            <div class="kn-eyebrow">
                <span class="kn-eyebrow-dot"></span> Clinical Expertise &amp; Departments
            </div>
            <h1 class="kn-hero-title">
                All Conditions &amp; Specialized Physiotherapists
            </h1>
            <p class="kn-hero-desc">
                Find experienced, verified clinicians specialized in your exact condition — from joint pain to surgical rehabilitation, spinal health, and neurological recovery.
            </p>

            {{-- Live Search Filter Box --}}
            <div class="kn-search-filter-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="specialitySearchInput" placeholder="Filter by condition (e.g. Back Pain, Knee, Sciatica)..." autocomplete="off">
            </div>

            {{-- Quick condition jump pills --}}
            <div class="kn-pills-wrap" id="conditionPillsWrap">
                <button type="button" class="kn-condition-pill active" onclick="filterConditionBlocks('all', this)">
                    All Conditions ({{ $specializations->count() }})
                </button>
                @foreach($specializations as $spec)
                    <button type="button" class="kn-condition-pill" onclick="filterConditionBlocks('{{ $spec->id }}', this)">
                        {{ $spec->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         3. CONDITIONS & DOCTORS DIRECTORY
    ══════════════════════════════════════════════════ --}}
    <section class="kn-directory-section">
        <div class="kn-container">

            @php
                $fallbackDoctorImgs = [
                    asset('assets/img/doctors/doctor-01.jpg'),
                    asset('assets/img/doctors/doctor-02.jpg'),
                    asset('assets/img/doctors/doctor-03.jpg'),
                ];
            @endphp

            @forelse($specializations as $specIndex => $spec)
                @php
                    // Collect doctors assigned to this specialization
                    $assignedDoctors = $allDoctors->filter(function($doc) use ($spec) {
                        return $doc->profile && (string)$doc->profile->specialization === (string)$spec->id;
                    });
                @endphp

                <div class="kn-condition-block" 
                     id="condition-{{ $spec->id }}" 
                     data-condition-id="{{ $spec->id }}" 
                     data-condition-name="{{ strtolower($spec->name) }}"
                     data-condition-desc="{{ strtolower($spec->description ?? '') }}">
                    
                    {{-- Header Row: Icon, Name, Description, Doctor count --}}
                    <div class="kn-cond-header-row">
                        <div class="kn-cond-identity">
                            <div class="kn-cond-icon-box">
                                @if(!empty($spec->icon))
                                    <img src="{{ asset('images/specializations/' . $spec->icon) }}"
                                         alt="{{ $spec->name }}"
                                         class="kn-cond-icon-img"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
                                    <i class="fa-solid fa-stethoscope" style="display: none;"></i>
                                @else
                                    <i class="fa-solid fa-stethoscope"></i>
                                @endif
                            </div>
                            <div class="kn-cond-info">
                                <h2>{{ $spec->name }}</h2>
                                <p>{{ $spec->description ?: 'Dedicated assessment and clinical physiotherapy rehabilitation designed to alleviate pain, restore mobility, and prevent recurrence.' }}</p>
                            </div>
                        </div>

                        <div class="kn-cond-count-badge">
                            <i class="fa-solid fa-user-doctor"></i>
                            <span>{{ $assignedDoctors->count() > 0 ? $assignedDoctors->count() . ' Specialists' : 'Available for Care' }}</span>
                        </div>
                    </div>

                    {{-- Doctors Grid or Empty State --}}
                    @if($assignedDoctors->count() > 0)
                        <div class="kn-specialists-subgrid">
                            @foreach($assignedDoctors as $dIdx => $doc)
                                @php
                                    $dName = $doc->name ?? 'Physiotherapist';
                                    if (!str_starts_with(strtolower($dName), 'dr.')) {
                                        $dName = 'Dr. ' . $dName;
                                    }

                                    $dImg = $fallbackDoctorImgs[$dIdx % count($fallbackDoctorImgs)];
                                    if (!empty($doc->profile_img)) {
                                        $dImg = asset($doc->profile_img);
                                    } elseif (!empty($doc->profile->profile_img)) {
                                        $dImg = asset($doc->profile->profile_img);
                                    }

                                    $qual = $doc->profile->qualification ?? 'MPT - Physiotherapy';
                                    $expYears = $doc->profile->experience_years ?? 8;
                                    $feeVal = '₹800';
                                    if (!empty($doc->fee->doctor_fee)) {
                                        $feeVal = '₹' . number_format($doc->fee->doctor_fee);
                                    } elseif (!empty($doc->profile->consultation_fee)) {
                                        $feeVal = '₹' . number_format($doc->profile->consultation_fee);
                                    }

                                    $locText = $doc->profile->clinic_address ?? ($doc->address ?? 'Central Clinic & Home Visits');
                                @endphp

                                <div class="kn-doc-card-inner">
                                    <div class="kn-doc-card-media">
                                        <img src="{{ $dImg }}" alt="{{ $dName }}" loading="lazy" onerror="this.src='{{ $fallbackDoctorImgs[$dIdx % count($fallbackDoctorImgs)] }}';">
                                        <div class="kn-doc-rating">
                                            <i class="fa-solid fa-star"></i> 4.9 ({{ 40 + ($doc->id * 5) }} reviews)
                                        </div>
                                    </div>
                                    <div class="kn-doc-card-body">
                                        <h3 class="kn-doc-card-title">{{ $dName }}</h3>
                                        <div class="kn-doc-card-qual">{{ $qual }} · {{ $expYears }} yrs exp</div>
                                        
                                        <div class="kn-doc-card-loc">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <span>{{ Str::limit($locText, 28) }}</span>
                                        </div>

                                        <div class="kn-doc-card-footer">
                                            <div class="kn-doc-fee">
                                                {{ $feeVal }}
                                                <small>per session</small>
                                            </div>
                                            <div class="kn-doc-actions">
                                                <a href="{{ route('doctor.profile', $doc->id) }}" class="kn-btn-sm-profile">
                                                    Profile
                                                </a>
                                                <a href="{{ route('doctor.booking', $doc->id) }}" class="kn-btn-sm-book">
                                                    Book
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Welcome Banner for conditions where doctors are assigned on request --}}
                        <div class="kn-cond-empty-box">
                            <div class="kn-cond-empty-left">
                                <i class="fa-solid fa-hand-holding-medical"></i>
                                <div>
                                    <h5>Certified Specialists Available for {{ $spec->name }}</h5>
                                    <p>Our network of licensed musculoskeletal physiotherapists provides personalized care for {{ $spec->name }} via clinic sessions and home visits.</p>
                                </div>
                            </div>
                            <a href="{{ route('home') }}?specialization={{ $spec->id }}#specialists" class="kn-btn-request-consult">
                                Book {{ $spec->name }} Consult <i class="fa-solid fa-arrow-right" style="font-size: 11px; margin-left: 4px;"></i>
                            </a>
                        </div>
                    @endif

                </div>
            @empty
                <div style="text-align: center; padding: 60px 20px; background: #ffffff; border-radius: var(--radius-lg); border: 1.5px dashed var(--card-border);">
                    <i class="fa-solid fa-notes-medical" style="font-size: 40px; color: var(--brand-teal); margin-bottom: 14px;"></i>
                    <h3>No Specialities Available</h3>
                    <p style="color: var(--text-muted);">Please check back soon or consult our homepage specialists.</p>
                    <a href="{{ route('home') }}" class="kn-btn-nav-book">Return to Home</a>
                </div>
            @endforelse

            {{-- No results search banner --}}
            <div id="noSearchResults" style="display: none; text-align: center; padding: 60px 20px; background: #ffffff; border-radius: var(--radius-lg); border: 1.5px dashed var(--card-border);">
                <i class="fa-solid fa-magnifying-glass" style="font-size: 36px; color: var(--brand-teal); margin-bottom: 12px;"></i>
                <h3>No conditions found</h3>
                <p style="color: var(--text-muted); margin-bottom: 18px;">We couldn't find any condition matching your search.</p>
                <button type="button" class="kn-btn-nav-book" onclick="resetSearch()" style="border: none; cursor: pointer;">
                    Show All Conditions
                </button>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         4. FOOTER
    ══════════════════════════════════════════════════ --}}
    <footer class="kn-footer">
        <div class="kn-container">
            <div class="kn-footer-grid">
                <div>
                    <a href="{{ route('home') }}" style="display: inline-block; margin-bottom: 18px;">
                        <img src="{{ asset('logo.png') }}" alt="PhysioPii" style="height: 42px; width: auto; max-width: 175px; object-fit: contain; filter: brightness(0) invert(1);">
                    </a>
                    <p class="kn-footer-desc">
                        Connecting you with certified physiotherapy specialists for comprehensive in-clinic and at-home rehabilitation.
                    </p>
                </div>

                <div class="kn-footer-col">
                    <h6>Quick Links</h6>
                    <ul class="kn-footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('specialities.index') }}">All Specialities</a></li>
                        <li><a href="{{ route('home') }}#specialists">Find Doctors</a></li>
                        <li><a href="{{ route('home') }}#how-it-works">How It Works</a></li>
                        <li><a href="{{ route('home') }}#about">About Us</a></li>
                    </ul>
                </div>

                <div class="kn-footer-col">
                    <h6>Popular Conditions</h6>
                    <ul class="kn-footer-links">
                        @foreach($specializations->take(5) as $footSpec)
                            <li><a href="#condition-{{ $footSpec->id }}">{{ $footSpec->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="kn-footer-col">
                    <h6>Contact Support</h6>
                    <ul class="kn-footer-links">
                        <li><i class="fa-regular fa-envelope"></i> contact@physiopii.in</li>
                        <li><i class="fa-solid fa-phone"></i> +91 8855088426</li>
                        <li><i class="fa-regular fa-clock"></i> Mon - Sun: 8am - 8pm</li>
                    </ul>
                </div>
            </div>

            <div class="kn-footer-bottom">
                <div>&copy; {{ date('Y') }} PhysioPii Healthcare. All rights reserved.</div>
                <div><a href="{{ route('privacy.policy') }}" style="color: #94a3b8;">Privacy Policy</a></div>
            </div>
        </div>
    </footer>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Mobile Menu Drawer Toggle
    var mobileToggle = document.getElementById('knMobileToggle');
    var mobileDrawer = document.getElementById('knMobileDrawer');
    if (mobileToggle && mobileDrawer) {
        mobileToggle.addEventListener('click', function () {
            mobileDrawer.classList.toggle('open');
            var icon = mobileToggle.querySelector('i');
            if (mobileDrawer.classList.contains('open')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            } else {
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            }
        });
    }

    // 2. Real-time Condition Search Input
    var searchInput = document.getElementById('specialitySearchInput');
    var conditionBlocks = document.querySelectorAll('.kn-condition-block');
    var noResults = document.getElementById('noSearchResults');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            var query = this.value.toLowerCase().trim();
            var visibleCount = 0;

            // Reset pill active states
            document.querySelectorAll('.kn-condition-pill').forEach(function(p) {
                p.classList.remove('active');
            });

            conditionBlocks.forEach(function (block) {
                var cName = block.getAttribute('data-condition-name') || '';
                var cDesc = block.getAttribute('data-condition-desc') || '';

                if (!query || cName.includes(query) || cDesc.includes(query)) {
                    block.style.display = '';
                    visibleCount++;
                } else {
                    block.style.display = 'none';
                }
            });

            if (noResults) {
                noResults.style.display = (visibleCount === 0) ? 'block' : 'none';
            }
        });
    }

    // 3. Pill Filter
    window.filterConditionBlocks = function (specId, element) {
        document.querySelectorAll('.kn-condition-pill').forEach(function(p) {
            p.classList.remove('active');
        });
        if (element) {
            element.classList.add('active');
        }

        if (searchInput) {
            searchInput.value = '';
        }

        var visibleCount = 0;
        conditionBlocks.forEach(function (block) {
            var bId = block.getAttribute('data-condition-id');
            if (specId === 'all' || bId === String(specId)) {
                block.style.display = '';
                visibleCount++;
            } else {
                block.style.display = 'none';
            }
        });

        if (noResults) {
            noResults.style.display = (visibleCount === 0) ? 'block' : 'none';
        }

        if (specId !== 'all') {
            var target = document.getElementById('condition-' + specId);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    };

    window.resetSearch = function () {
        if (searchInput) {
            searchInput.value = '';
        }
        var firstPill = document.querySelector('.kn-condition-pill');
        if (firstPill) {
            filterConditionBlocks('all', firstPill);
        }
    };

    // Auto-scroll to selected condition if passed in query param
    @if(!empty($selectedSpecId))
        var targetBlock = document.getElementById('condition-{{ $selectedSpecId }}');
        if (targetBlock) {
            setTimeout(function() {
                targetBlock.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);
        }
    @endif
});
</script>

@endsection
