<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ✅ BASIC SEO -->
    <title>Physiotherapy</title>
    <meta name="title" content="Physiotherapy">
    <meta name="description" content="Physiotherapy is a results-driven marketing and branding agency helping businesses grow through strategy, creativity, and performance-focused digital marketing.">
    <meta name="keywords" content="marketing agency india, branding agency delhi, digital marketing company, Physiotherapy">
    <meta name="author" content="Physiotherapy">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://physiotherapy.infoharry.in/">
    <meta property="og:title" content="Physiotherapy - Marketing & Branding Agency">
    <meta property="og:description" content="Results-driven marketing and branding agency helping businesses grow.">
    <meta property="og:image" content="{{asset('logo.png')}}">
    <meta property="og:site_name" content="Physiotherapy">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Physiotherapy">
    <meta name="twitter:description" content="Marketing and Branding Agency in India">
    <meta name="twitter:image" content="{{asset('logo.png')}}">
    <link rel="canonical" href="http://physiotherapy.infoharry.in/">
    <link rel="icon" href="{{asset('logo.png')}}" type="image/jpeg">
    <link rel="apple-touch-icon" href="{{asset('logo.png')}}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <!-- Google Fonts: Inter + Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 68px;

            /* ── Sidebar Palette (White + Light Blue) ── */
            --sb-bg:            #FFFFFF;
            --sb-bg-bottom:     #F0F6FF;
            --sb-border:        #DDE8F8;
            --sb-logo-bg:       #EBF3FF;

            --sb-nav-idle:      #6B8CB8;
            --sb-nav-hover-bg:  #EBF3FF;
            --sb-nav-hover-fg:  #1A5FD6;
            --sb-nav-active-bg: linear-gradient(135deg, #2260FF 0%, #4C8BFF 100%);
            --sb-nav-active-fg: #FFFFFF;
            --sb-nav-active-shadow: 0 4px 14px rgba(34,96,255,0.28);

            --sb-section-label: #A4BCE0;
            --sb-icon-idle:     #9BB6D8;
            --sb-divider:       #E6EEF9;
            --sb-footer-bg:     #F4F8FF;
            --sb-footer-border: #DDE8F8;

            /* ── Main / Topbar Palette ── */
            --primary:          #2260FF;
            --primary-hover:    #1A4FD6;

            --bg-page:          #F2F5FB;
            --bg-card:          #FFFFFF;
            --bg-card-hover:    #F7FAFF;

            --text-dark:        #0F1E3A;
            --text-body:        #3D5278;
            --text-muted:       #7A92B8;
            --text-placeholder: #B0C2DC;

            --border-card:      #E4ECFA;

            --topbar-bg:        #FFFFFF;
            --topbar-border:    #E4ECFA;

            --success:          #10b981;
            --success-bg:       rgba(16,185,129,0.10);
            --danger:           #ef4444;
            --danger-bg:        rgba(239,68,68,0.10);
            --warning:          #f59e0b;
            --warning-bg:       rgba(245,158,11,0.10);
            --purple:           #8b5cf6;
            --cyan:             #06b6d4;
            --orange:           #f97316;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-page);
            color: var(--text-dark);
            overflow-x: hidden;
            line-height: 1.5;
        }

        /* ═══════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════ */
        .sidebar {
            position: fixed;
            left: 0; top: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sb-bg);
            border-right: 1.5px solid var(--sb-border);
            transition: width 0.28s cubic-bezier(.4,0,.2,1);
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 24px rgba(34,96,255,0.06);
        }

        .sidebar::-webkit-scrollbar { width: 3px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: var(--sb-border); border-radius: 2px; }

        .sidebar.collapsed { width: var(--sidebar-collapsed-width); }

        /* ── Header ── */
        .sidebar-header {
            padding: 1rem 1rem 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.625rem;
            border-bottom: 1.5px solid var(--sb-divider);
            flex-shrink: 0;
            background: var(--sb-logo-bg);
        }

        .sidebar-logo {
            width: 100%;
            height: 36px;
            object-fit: contain;
            transition: opacity 0.28s, width 0.28s;
            flex-shrink: 0;
        }

        .sidebar.collapsed .sidebar-logo {
            opacity: 0;
            width: 0;
            pointer-events: none;
        }

        /* Collapsed: show a small icon mark */
        .sidebar-icon-mark {
            display: none;
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 10px;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .sidebar-icon-mark svg { width: 18px; height: 18px; color: #fff; }
        .sidebar.collapsed .sidebar-icon-mark { display: flex; }

        .collapse-btn {
            margin-left: auto;
            background: transparent;
            border: 1px solid var(--sb-border);
            color: var(--sb-nav-idle);
            cursor: pointer;
            padding: 0.375rem;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .collapse-btn:hover {
            background: var(--sb-nav-hover-bg);
            border-color: var(--primary);
            color: var(--primary);
        }
        .sidebar.collapsed .collapse-btn { transform: rotate(180deg); }

        /* ── Navigation ── */
        .sidebar-nav {
            padding: 0.875rem 0;
            flex: 1;
        }

        .nav-section { margin-bottom: 0.25rem; }

        .nav-section-title {
            padding: 0.625rem 1.125rem 0.375rem;
            font-size: 0.625rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: var(--sb-section-label);
            font-family: 'Nunito', sans-serif;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.2s, height 0.2s;
        }
        .sidebar.collapsed .nav-section-title {
            opacity: 0;
            height: 0;
            padding: 0;
        }

        .nav-item { margin: 0.125rem 0.625rem; }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.625rem 0.75rem;
            color: var(--sb-nav-idle);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.18s ease;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 600;
            font-family: 'Nunito', sans-serif;
            white-space: nowrap;
            gap: 0;
        }

        .nav-link:hover {
            background: var(--sb-nav-hover-bg);
            color: var(--sb-nav-hover-fg);
        }

        .nav-link.active {
            background: var(--sb-nav-active-bg);
            color: var(--sb-nav-active-fg);
            box-shadow: var(--sb-nav-active-shadow);
            font-weight: 700;
        }

        /* Tooltip for collapsed mode */
        .nav-item { position: relative; }
        .sidebar.collapsed .nav-link::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(var(--sidebar-collapsed-width) + 8px);
            top: 50%;
            transform: translateY(-50%);
            background: #0F1E3A;
            color: #fff;
            padding: 0.375rem 0.75rem;
            border-radius: 7px;
            font-size: 0.75rem;
            font-weight: 700;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s;
            z-index: 9999;
            box-shadow: 0 4px 16px rgba(0,0,0,0.18);
        }
        .sidebar.collapsed .nav-item:hover > .nav-link::after { opacity: 1; }

        .nav-icon {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            flex-shrink: 0;
            background: transparent;
            transition: background 0.18s;
        }
        .nav-icon svg { width: 18px; height: 18px; }

        .nav-link:hover .nav-icon {
            background: rgba(34,96,255,0.10);
        }
        .nav-link.active .nav-icon {
            background: rgba(255,255,255,0.18);
        }

        .sidebar.collapsed .nav-icon { margin-right: 0; }

        .nav-text {
            white-space: nowrap;
            transition: opacity 0.22s, max-width 0.22s;
            max-width: 160px;
            overflow: hidden;
            margin-left: 0.625rem;
        }
        .sidebar.collapsed .nav-text {
            opacity: 0;
            max-width: 0;
            margin-left: 0;
        }

        /* Dropdown arrow */
        .dropdown-arrow {
            margin-left: auto;
            transition: transform 0.2s ease;
            flex-shrink: 0;
        }
        .dropdown-arrow svg { width: 12px; height: 12px; }
        .nav-item.open .dropdown-arrow { transform: rotate(180deg); }
        .sidebar.collapsed .dropdown-arrow { opacity: 0; width: 0; overflow: hidden; }

        /* Dropdown */
        .sidebar-dropdown { display: none; padding-left: 8px; }
        .nav-item.open .sidebar-dropdown { display: block; }
        .sidebar.collapsed .sidebar-dropdown { display: none !important; }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 0.75rem 0.5rem 2.75rem;
            color: var(--sb-nav-idle);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.15s ease;
            margin: 0.1rem 0;
            font-size: 0.8125rem;
            font-weight: 600;
            font-family: 'Nunito', sans-serif;
        }
        .dropdown-item:hover {
            background: var(--sb-nav-hover-bg);
            color: var(--sb-nav-hover-fg);
        }
        .dropdown-item.active {
            background: rgba(34,96,255,0.08);
            color: var(--primary);
            font-weight: 700;
        }

        /* Active left indicator bar */
        .nav-link.active::before {
            content: '';
            position: absolute;
            left: -0.625rem;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: var(--primary);
            border-radius: 0 3px 3px 0;
        }
        .nav-item { position: relative; }

        /* ── Footer / Logout ── */
        .sidebar-footer {
            padding: 0.875rem;
            border-top: 1.5px solid var(--sb-footer-border);
            background: var(--sb-footer-bg);
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            padding: 0.25rem;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
            justify-content: flex-start;
            background: transparent;
            border: 1.5px solid var(--sb-border);
            color: var(--sb-nav-idle);
            padding: 0.5rem 0.875rem;
            border-radius: 9px;
            font-size: 0.875rem;
            font-weight: 700;
            font-family: 'Nunito', sans-serif;
            cursor: pointer;
            transition: all 0.18s;
        }
        .logout-btn:hover {
            background: rgba(239,68,68,0.08);
            border-color: var(--danger);
            color: var(--danger);
        }
        .sidebar.collapsed .logout-text { display: none; }
        .sidebar.collapsed .logout-btn { justify-content: center; padding: 0.5rem; }

        /* ═══════════════════════════════════════
           MAIN CONTENT
        ═══════════════════════════════════════ */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.28s cubic-bezier(.4,0,.2,1);
            min-height: 100vh;
            background: var(--bg-page);
        }
        .sidebar.collapsed ~ .main-wrapper {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* ── Topbar ── */
        .topbar {
            background: var(--topbar-bg);
            border-bottom: 1.5px solid var(--topbar-border);
            padding: 0.75rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 12px rgba(34,96,255,0.05);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .icon-btn {
            width: 38px; height: 38px;
            border-radius: 9px;
            background: transparent;
            border: 1.5px solid var(--border-card);
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.15s;
        }
        .icon-btn:hover {
            background: var(--sb-nav-hover-bg);
            border-color: var(--primary);
            color: var(--primary);
        }
        .icon-btn svg { width: 18px; height: 18px; }

        .notification-badge {
            position: absolute;
            top: 7px; right: 7px;
            width: 7px; height: 7px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid var(--topbar-bg);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.375rem 0.875rem 0.375rem 0.5rem;
            background: var(--sb-nav-hover-bg);
            border: 1.5px solid var(--sb-border);
            border-radius: 50px;
            cursor: pointer;
            margin-left: 0.5rem;
            transition: all 0.15s;
        }
        .user-profile:hover {
            border-color: var(--primary);
            box-shadow: 0 2px 12px rgba(34,96,255,0.12);
        }

        .user-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2260FF, #4C8BFF);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.6875rem;
            color: white;
            font-family: 'Nunito', sans-serif;
        }

        .user-profile-text {
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--text-dark);
            font-family: 'Nunito', sans-serif;
        }

        .status-badge {
            font-size: 0.625rem;
            padding: 0.15rem 0.45rem;
            background: var(--success-bg);
            color: var(--success);
            border-radius: 20px;
            font-weight: 800;
            font-family: 'Nunito', sans-serif;
        }

        /* ── Content Area ── */
        .content {
            padding: 1.75rem;
        }

        .page-header { margin-bottom: 1.75rem; }

        .page-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-dark);
            font-family: 'Nunito', sans-serif;
            margin-bottom: 0.25rem;
        }
        .page-subtitle {
            color: var(--text-muted);
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* ── Action Cards ── */
        .action-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .action-card {
            background: var(--bg-card);
            border: 1.5px solid var(--border-card);
            border-radius: 14px;
            padding: 1.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .action-card:hover {
            transform: translateY(-3px);
            border-color: rgba(34,96,255,0.35);
            box-shadow: 0 8px 28px rgba(34,96,255,0.10);
        }

        .action-icon {
            width: 44px; height: 44px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.875rem;
        }
        .action-icon svg { width: 22px; height: 22px; }

        .action-card:nth-child(1) .action-icon { background: rgba(59,130,246,0.12); color: #3b82f6; }
        .action-card:nth-child(2) .action-icon { background: rgba(16,185,129,0.12); color: #10b981; }
        .action-card:nth-child(3) .action-icon { background: rgba(139,92,246,0.12); color: #8b5cf6; }
        .action-card:nth-child(4) .action-icon { background: rgba(245,158,11,0.12); color: #f59e0b; }

        .action-card h3 {
            font-size: 0.9375rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: var(--text-dark);
            font-family: 'Nunito', sans-serif;
        }
        .action-card p { color: var(--text-muted); font-size: 0.8125rem; }

        /* ── Stats Grid ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #2260FF 0%, #4C8BFF 100%);
            border: none;
            border-radius: 14px;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(34,96,255,0.18);
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 100px; height: 100px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 28px rgba(34,96,255,0.28);
        }

        .stat-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 0.875rem;
        }

        .stat-icon {
            width: 38px; height: 38px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.18);
        }
        .stat-icon svg { width: 18px; height: 18px; color: #fff; }

        .stat-change {
            font-size: 0.625rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.125rem;
            font-family: 'Nunito', sans-serif;
            background: rgba(255,255,255,0.18);
            color: #fff;
        }

        .stat-value {
            font-size: 1.625rem;
            font-weight: 800;
            color: #fff;
            font-family: 'Nunito', sans-serif;
            margin-bottom: 0.2rem;
        }
        .stat-label {
            color: rgba(255,255,255,0.80);
            font-size: 0.8125rem;
            font-weight: 600;
            font-family: 'Nunito', sans-serif;
        }
        .stat-meta {
            color: rgba(255,255,255,0.55);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        /* ── Chart Card ── */
        .chart-card {
            background: var(--bg-card);
            border: 1.5px solid var(--border-card);
            border-radius: 14px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(34,96,255,0.04);
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .chart-title { display: flex; align-items: center; gap: 0.75rem; }

        .chart-icon {
            width: 40px; height: 40px;
            background: rgba(34,96,255,0.10);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }
        .chart-icon svg { width: 20px; height: 20px; }

        .chart-title-text h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            font-family: 'Nunito', sans-serif;
            margin-bottom: 0.125rem;
        }
        .chart-title-text p { font-size: 0.8125rem; color: var(--text-muted); }

        .chart-legend { display: flex; gap: 1.5rem; font-size: 0.8125rem; }
        .legend-item { display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-weight: 500; }
        .legend-dot { width: 8px; height: 8px; border-radius: 50%; }
        .chart-container { position: relative; height: 280px; }

        /* ── Mobile ── */
        .mobile-menu-btn {
            display: none;
            background: var(--primary);
            border: none;
            color: white;
            width: 48px; height: 48px;
            border-radius: 14px;
            cursor: pointer;
            position: fixed;
            bottom: 1.5rem; right: 1.5rem;
            z-index: 1001;
            box-shadow: 0 4px 18px rgba(34,96,255,0.35);
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15,30,58,0.45);
            backdrop-filter: blur(4px);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .overlay.active { opacity: 1; }

        /* ── Responsive ── */
        @media (max-width: 1400px) {
            .stats-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .mobile-menu-btn { display: flex; }
            .overlay { display: block; }
            .action-cards { grid-template-columns: repeat(2, 1fr); }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 640px) {
            .content { padding: 1rem; }
            .action-cards, .stats-grid { grid-template-columns: 1fr; }
            .topbar { padding: 0.75rem 1rem; }
            .user-profile-text, .status-badge { display: none; }
        }
    </style>
</head>
<body>
    <button class="mobile-menu-btn" onclick="toggleMobile()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <div class="overlay" onclick="toggleMobile()"></div>

    <aside class="sidebar" id="sidebar">

        <!-- Header -->
        <div class="sidebar-header">
            <!-- Collapsed: mini icon mark -->
            <div class="sidebar-icon-mark">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
            </div>
            <!-- Logo -->
            <img src="{{asset('logo.png')}}" class="sidebar-logo" alt="">
            <!-- Collapse button -->
            <button class="collapse-btn" onclick="toggleSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="14" height="14">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">

            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                   data-tooltip="Dashboard"
                   class="nav-link {{ Request::is('admin/dashboard*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h7v7H4V6zm9 0h7v7h-7V6zM4 15h7v3H4v-3zm9 0h7v3h-7v-3z"/>
                        </svg>
                    </span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.users.index') }}"
                   data-tooltip="Users"
                   class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4.13a4 4 0 100-8 4 4 0 000 8zm6 4a4 4 0 00-3-3.87"/>
                        </svg>
                    </span>
                    <span class="nav-text">Users</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.appointments.index') }}"
                   data-tooltip="Appointments"
                   class="nav-link {{ Request::is('admin/appointments*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <span class="nav-text">Appointments</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.appointment-transfer-requests.index') }}"
                   data-tooltip="Transfer Requests"
                   class="nav-link {{ Request::is('admin/appointment-transfer-requests*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </span>
                    <span class="nav-text">Transfer Requests</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.specializations.index') }}"
                   data-tooltip="Specializations"
                   class="nav-link {{ Request::is('admin/specializations*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                        </svg>
                    </span>
                    <span class="nav-text">Specializations</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.patient-plans.index') }}"
                   data-tooltip="Patient Plans"
                   class="nav-link {{ Request::is('admin/patient-plans*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6M7 4h7l5 5v11a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                        </svg>
                    </span>
                    <span class="nav-text">Patient Plans</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.patient-plan-subscriptions.index') }}"
                   data-tooltip="Subscriptions"
                   class="nav-link {{ Request::is('admin/patient-plan-subscriptions*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                    </span>
                    <span class="nav-text">Patient Subscriptions</span>
                </a>
            </div>

        </nav>

        <!-- Footer: Logout -->
        <div class="sidebar-footer">
            <div class="user-info">
                <form method="POST" action="{{ route('admin.logout') }}" class="logout-form" style="width:100%">
                    @csrf
                    <button type="submit" class="btn logout-btn">
                        <i class="fa fa-sign-out-alt"></i>
                        <span class="logout-text">Logout</span>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    <!-- Main -->
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-actions">
                <div class="user-profile">
                    <div class="user-avatar">{{ Auth::user()->name[0] }}</div>
                    <span class="user-profile-text">{{ Auth::user()->name }}</span>
                    <span class="status-badge">Active</span>
                </div>
            </div>
        </header>

        <main class="content">
            @yield('content')
        </main>
    </div>

    <script>
        let isDarkMode = false; // Light mode by default now

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            if (document.getElementById('sidebar').classList.contains('collapsed')) {
                document.querySelectorAll('.nav-item.open').forEach(item => item.classList.remove('open'));
            }
        }

        function toggleDropdown(element) {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.classList.contains('collapsed')) return;
            const navItem = element.closest('.nav-item');
            navItem.classList.toggle('open');
        }

        function toggleMobile() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.overlay');
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        }

        document.querySelectorAll('.nav-link:not([onclick]), .dropdown-item').forEach(link => {
            link.addEventListener('click', function(e) {
                document.querySelectorAll('.nav-link, .dropdown-item').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                if (this.classList.contains('dropdown-item')) {
                    const parentNavItem = this.closest('.nav-item');
                    if (parentNavItem) parentNavItem.querySelector('.nav-link').classList.add('active');
                }
                if (window.innerWidth <= 1024) toggleMobile();
            });
        });

        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 1024) toggleMobile();
            });
        });

        // Chart
        let chart;

        function initChart() {
            const canvas = document.getElementById('performanceChart');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            const gradient1 = ctx.createLinearGradient(0, 0, 0, 280);
            gradient1.addColorStop(0, 'rgba(34,96,255,0.25)');
            gradient1.addColorStop(1, 'rgba(34,96,255,0)');

            const gradient2 = ctx.createLinearGradient(0, 0, 0, 280);
            gradient2.addColorStop(0, 'rgba(16,185,129,0.25)');
            gradient2.addColorStop(1, 'rgba(16,185,129,0)');

            const gradient3 = ctx.createLinearGradient(0, 0, 0, 280);
            gradient3.addColorStop(0, 'rgba(245,158,11,0.25)');
            gradient3.addColorStop(1, 'rgba(245,158,11,0)');

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                    datasets: [{
                        label: 'Sent',
                        data: [2800,2600,5500,3200,4800,3800,3500,4200,5800,8500,5200,7500],
                        borderColor: '#2260FF',
                        backgroundColor: gradient1,
                        tension: 0.4, fill: true, borderWidth: 2,
                        pointRadius: 0, pointHoverRadius: 5,
                        pointBackgroundColor: '#2260FF'
                    },{
                        label: 'Opened',
                        data: [2200,2800,9500,3600,4200,3200,3000,3600,4500,9800,6500,5800],
                        borderColor: '#10b981',
                        backgroundColor: gradient2,
                        tension: 0.4, fill: true, borderWidth: 2,
                        pointRadius: 0, pointHoverRadius: 5,
                        pointBackgroundColor: '#10b981'
                    },{
                        label: 'Clicked',
                        data: [800,900,1800,1200,1600,1300,1100,1500,1700,2100,1900,2200],
                        borderColor: '#f59e0b',
                        backgroundColor: gradient3,
                        tension: 0.4, fill: true, borderWidth: 2,
                        pointRadius: 0, pointHoverRadius: 5,
                        pointBackgroundColor: '#f59e0b'
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#ffffff',
                            titleColor: '#0F1E3A',
                            bodyColor: '#7A92B8',
                            borderColor: '#E4ECFA',
                            borderWidth: 1,
                            padding: 12, cornerRadius: 8,
                            boxWidth: 8, boxHeight: 8, boxPadding: 4
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(228,236,250,0.8)', drawBorder: false },
                            ticks: { color: '#A4BCE0', font: { size: 11 }, padding: 8 },
                            border: { display: false }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#A4BCE0', font: { size: 11 }, padding: 8 },
                            border: { display: false }
                        }
                    }
                }
            });
        }

        initChart();
    </script>
</body>
</html>