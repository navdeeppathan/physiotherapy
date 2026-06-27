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

  <!-- ✅ OPEN GRAPH -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="http://physiotherapy.infoharry.in/">
  <meta property="og:title" content="Physiotherapy - Marketing & Branding Agency">
  <meta property="og:description" content="Results-driven marketing and branding agency helping businesses grow.">
  <meta property="og:image" content="{{asset('logo.png')}}">
  <meta property="og:site_name" content="Physiotherapy">

  <!-- ✅ TWITTER -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Physiotherapy">
  <meta name="twitter:description" content="Marketing and Branding Agency in India">
  <meta name="twitter:image" content="{{asset('logo.png')}}">

  <!-- ✅ CANONICAL -->
  <link rel="canonical" href="http://physiotherapy.infoharry.in/">
  <link rel="icon" href="{{asset('logo.png')}}" type="image/jpeg">
  <link rel="apple-touch-icon" href="{{asset('logo.png')}}">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <style>
    :root{
      --sidebar-width:          248px;
      --sidebar-collapsed-width: 68px;

      /* palette */
      --bg:         #EEF4FB;
      --white:      #FFFFFF;
      --blue:       #2D7DD2;
      --blue-l:     #E8F1FB;
      --blue-d:     #1A5BA8;
      --blue-mid:   #4A9AE8;
      --border:     #D6E4F5;
      --text:       #1A2B42;
      --text2:      #4A6080;
      --text3:      #8FA8C4;
      --green:      #16A96A;
      --green-bg:   #E8F8F2;
      --rose:       #E55A6B;
      --rose-bg:    #FDEEF0;
      --ease:       cubic-bezier(0.16,1,0.3,1);
    }

    *{ margin:0;padding:0;box-sizing:border-box; }

    body{
      font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
      background:var(--bg);
      color:var(--text);
      overflow-x:hidden;
      line-height:1.5;
      -webkit-font-smoothing:antialiased;
    }

    /* ══════════════════════════════
       SIDEBAR
    ══════════════════════════════ */
    .sidebar{
      position:fixed;left:0;top:0;
      height:100vh;
      width:var(--sidebar-width);
      background:var(--white);
      border-right:1px solid var(--border);
      transition:width 0.25s var(--ease);
      z-index:1000;
      overflow-y:auto;overflow-x:hidden;
      display:flex;flex-direction:column;
      box-shadow:2px 0 16px rgba(45,125,210,.06);
    }

    .sidebar::-webkit-scrollbar{ width:4px; }
    .sidebar::-webkit-scrollbar-track{ background:transparent; }
    .sidebar::-webkit-scrollbar-thumb{ background:var(--border);border-radius:2px; }

    .sidebar.collapsed{ width:var(--sidebar-collapsed-width); }

    /* header */
    .sidebar-header{
      padding:16px 14px;
      display:flex;align-items:center;gap:10px;
      border-bottom:1px solid var(--border);
      flex-shrink:0;min-height:64px;
      position:relative;
    }

    /* blue accent stripe */
    .sidebar-header::after{
      content:'';
      position:absolute;bottom:0;left:0;right:0;height:2px;
      background:linear-gradient(90deg,var(--blue-d),var(--blue-mid),transparent);
      opacity:.4;
    }

    .sidebar-logo{
      width:auto;height:36px;
      object-fit:contain;
      flex-shrink:0;
      transition:opacity .25s;
    }
    .sidebar.collapsed .sidebar-logo{ opacity:0;width:0;overflow:hidden; }

    .sidebar-logo-icon{
      width:36px;height:36px;
      background:linear-gradient(135deg,var(--blue-d),var(--blue));
      border-radius:10px;
      display:none;
      align-items:center;justify-content:center;
      flex-shrink:0;
      box-shadow:0 4px 12px rgba(45,125,210,.25);
    }
    .sidebar-logo-icon svg{ width:20px;height:20px;stroke:#fff;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round; }
    .sidebar.collapsed .sidebar-logo-icon{ display:flex; }

    .collapse-btn{
      margin-left:auto;
      background:transparent;border:none;
      color:var(--text3);cursor:pointer;
      padding:6px;
      transition:.2s;
      border-radius:7px;
      flex-shrink:0;
      display:flex;align-items:center;justify-content:center;
    }
    .collapse-btn:hover{ background:var(--blue-l);color:var(--blue); }
    .collapse-btn svg{ width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }
    .sidebar.collapsed .collapse-btn{ transform:rotate(180deg); }

    /* nav */
    .sidebar-nav{
      padding:12px 0;flex:1;
    }

    .nav-section-title{
      padding:10px 16px 4px;
      font-size:10px;font-weight:700;
      text-transform:uppercase;letter-spacing:.6px;
      color:var(--text3);
    }
    .sidebar.collapsed .nav-section-title{ opacity:0;height:0;padding:0;overflow:hidden; }

    .nav-item{ margin:1px 8px; }

    .nav-link{
      display:flex;align-items:center;
      padding:9px 10px;
      color:var(--text2);
      text-decoration:none;
      border-radius:9px;
      transition:all .15s ease;
      cursor:pointer;
      font-size:13.5px;font-weight:500;
      gap:0;
    }
    .nav-link:hover{ background:var(--blue-l);color:var(--blue); }
    .nav-link.active{
      background:linear-gradient(135deg,var(--blue-d),var(--blue));
      color:#fff;
      box-shadow:0 4px 12px rgba(45,125,210,.25);
    }
    .nav-link.active .nav-icon svg{ stroke:#fff; }

    .nav-icon{
      width:20px;height:20px;
      display:flex;align-items:center;justify-content:center;
      margin-right:10px;flex-shrink:0;
    }
    .nav-icon svg{ width:17px;height:17px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round; }
    .sidebar.collapsed .nav-icon{ margin-right:0; }

    .nav-text{
      white-space:nowrap;transition:opacity .2s;flex:1;
      font-weight:600;
    }
    .sidebar.collapsed .nav-text{ opacity:0;width:0;overflow:hidden; }

    /* dropdown arrow */
    .dropdown-arrow{ margin-left:auto;transition:transform .2s ease; }
    .dropdown-arrow svg{ width:11px;height:11px;fill:none;stroke:currentColor;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round; }
    .nav-item.open .dropdown-arrow{ transform:rotate(180deg); }
    .sidebar.collapsed .dropdown-arrow{ display:none; }

    /* dropdown */
    .sidebar-dropdown{ display:none;padding-left:8px; }
    .nav-item.open .sidebar-dropdown{ display:block; }
    .sidebar.collapsed .sidebar-dropdown{ display:none; }

    .dropdown-item{
      display:flex;align-items:center;
      padding:7px 10px 7px 32px;
      color:var(--text3);
      text-decoration:none;
      border-radius:7px;
      transition:all .15s ease;
      margin:1px 0;
      font-size:12.5px;font-weight:500;
    }
    .dropdown-item:hover{ background:var(--blue-l);color:var(--blue); }
    .dropdown-item.active{ background:rgba(45,125,210,.08);color:var(--blue); }

    /* footer */
    .sidebar-footer{
      padding:12px 10px;
      border-top:1px solid var(--border);
      flex-shrink:0;
    }

    .user-card{
      display:flex;align-items:center;gap:10px;
      padding:10px;border-radius:10px;
      transition:background .15s;
    }
    .user-card:hover{ background:var(--blue-l); }

    .user-avatar-sm{
      width:32px;height:32px;border-radius:50%;
      background:linear-gradient(135deg,var(--blue-d),var(--blue-mid));
      display:flex;align-items:center;justify-content:center;
      font-size:12px;font-weight:800;color:#fff;flex-shrink:0;
    }

    .sidebar.collapsed .user-details{ display:none; }

    .logout-btn{
      display:flex;align-items:center;justify-content:flex-start;
      gap:8px;width:100%;
      background:transparent;border:none;
      padding:0;cursor:pointer;
    }
    .sidebar.collapsed .logout-text{ display:none; }
    .sidebar.collapsed .logout-btn{ justify-content:center; }

    .logout-inner{
      display:flex;align-items:center;gap:8px;
      padding:9px 10px;border-radius:9px;
      transition:background .15s;
      width:100%;
      font-family:'Inter',sans-serif;
      font-size:13px;font-weight:600;
      color:var(--rose);
    }
    .logout-inner:hover{ background:var(--rose-bg); }
    .logout-inner svg{ width:16px;height:16px;fill:none;stroke:var(--rose);stroke-width:2;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0; }

    /* ══════════════════════════════
       MAIN WRAPPER
    ══════════════════════════════ */
    .main-wrapper{
      margin-left:var(--sidebar-width);
      transition:margin-left .25s var(--ease);
      min-height:100vh;
      background:var(--bg);
    }
    .sidebar.collapsed ~ .main-wrapper{ margin-left:var(--sidebar-collapsed-width); }

    /* ══════════════════════════════
       TOPBAR
    ══════════════════════════════ */
    .topbar{
      background:var(--white);
      border-bottom:1px solid var(--border);
      padding:0 24px;
      height:60px;
      display:flex;align-items:center;justify-content:flex-end;
      position:sticky;top:0;z-index:100;
      box-shadow:0 1px 8px rgba(45,125,210,.05);
    }

    .topbar-actions{ display:flex;align-items:center;gap:8px; }

    /* user pill */
    .user-pill{
      display:flex;align-items:center;gap:8px;
      padding:5px 12px 5px 5px;
      background:var(--bg);
      border:1px solid var(--border);
      border-radius:24px;
      cursor:pointer;
      transition:border-color .2s,box-shadow .2s;
    }
    .user-pill:hover{
      border-color:var(--blue);
      box-shadow:0 0 0 3px rgba(45,125,210,.08);
    }
    .user-pill-avatar{
      width:28px;height:28px;border-radius:50%;
      background:linear-gradient(135deg,var(--blue-d),var(--blue-mid));
      display:flex;align-items:center;justify-content:center;
      font-size:11px;font-weight:800;color:#fff;
    }
    .user-pill-name{
      font-size:13px;font-weight:600;color:var(--text);
    }
    .user-pill-badge{
      font-size:10px;font-weight:700;
      padding:2px 7px;border-radius:20px;
      background:var(--green-bg);color:var(--green);
      border:1px solid rgba(22,169,106,.2);
    }

    /* content */
    .content{ padding:0; }

    /* ══════════════════════════════
       MOBILE
    ══════════════════════════════ */
    .mobile-menu-btn{
      display:none;
      background:linear-gradient(135deg,var(--blue-d),var(--blue));
      border:none;color:#fff;
      width:48px;height:48px;border-radius:14px;
      cursor:pointer;
      position:fixed;bottom:24px;right:24px;z-index:1001;
      box-shadow:0 6px 20px rgba(45,125,210,.35);
      align-items:center;justify-content:center;
    }
    .mobile-menu-btn svg{ width:22px;height:22px;fill:none;stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }

    .overlay{
      display:none;
      position:fixed;inset:0;
      background:rgba(26,43,66,.4);
      backdrop-filter:blur(4px);
      z-index:999;opacity:0;
      transition:opacity .3s;
    }
    .overlay.active{ opacity:1; }

    @media(max-width:1024px){
      .sidebar{ transform:translateX(-100%);box-shadow:none; }
      .sidebar.mobile-open{ transform:translateX(0);box-shadow:4px 0 24px rgba(45,125,210,.15); }
      .main-wrapper{ margin-left:0 !important; }
      .mobile-menu-btn{ display:flex; }
      .overlay{ display:block; }
    }

    @media(max-width:640px){
      .topbar{ padding:0 14px; }
      .user-pill-name,.user-pill-badge{ display:none; }
    }
  </style>
</head>
<body>

  <button class="mobile-menu-btn" onclick="toggleMobile()">
    <svg viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
  </button>
  <div class="overlay" onclick="toggleMobile()"></div>

  {{-- ══════════════ SIDEBAR ══════════════ --}}
  <aside class="sidebar" id="sidebar">

    <div class="sidebar-header">
      {{-- Logo: full when expanded --}}
      <img src="{{asset('logo.png')}}" class="sidebar-logo" alt="Physiotherapy">

      {{-- Icon fallback when collapsed --}}
      <div class="sidebar-logo-icon">
        <svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 1 0 0 14A7 7 0 0 0 12 2z"/><path d="M12 8v4l3 2"/></svg>
      </div>

      <button class="collapse-btn" onclick="toggleSidebar()" title="Toggle Sidebar">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
      </button>
    </div>

    <nav class="sidebar-nav">

      {{-- Dashboard --}}
      <div class="nav-item">
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ Request::is('admin/dashboard*') ? 'active' : '' }}">
          <span class="nav-icon">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
          </span>
          <span class="nav-text">Dashboard</span>
        </a>
      </div>

      {{-- Users --}}
      <div class="nav-item">
        <a href="{{ route('admin.users.index') }}"
           class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
          <span class="nav-icon">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </span>
          <span class="nav-text">Users</span>
        </a>
      </div>

      {{-- Appointments --}}
      <div class="nav-item">
        <a href="{{ route('admin.appointments.index') }}"
           class="nav-link {{ Request::is('admin/appointments*') ? 'active' : '' }}">
          <span class="nav-icon">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          </span>
          <span class="nav-text">Appointments</span>
        </a>
      </div>

      {{-- Transfer Requests --}}
      <div class="nav-item">
        <a href="{{ route('admin.appointment-transfer-requests.index') }}"
           class="nav-link {{ Request::is('admin/appointment-transfer-requests*') ? 'active' : '' }}">
          <span class="nav-icon">
            <svg viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
          </span>
          <span class="nav-text">Transfer Requests</span>
        </a>
      </div>

      {{-- Specializations --}}
      <div class="nav-item">
        <a href="{{ route('admin.specializations.index') }}"
           class="nav-link {{ Request::is('admin/specializations*') ? 'active' : '' }}">
          <span class="nav-icon">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 12h8M12 8v8"/></svg>
          </span>
          <span class="nav-text">Specializations</span>
        </a>
      </div>

      {{-- Patient Plans --}}
      <div class="nav-item">
        <a href="{{ route('admin.patient-plans.index') }}"
           class="nav-link {{ Request::is('admin/patient-plans*') ? 'active' : '' }}">
          <span class="nav-icon">
            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          </span>
          <span class="nav-text">Patient Plans</span>
        </a>
      </div>

      {{-- Patient Subscriptions --}}
      <div class="nav-item">
        <a href="{{ route('admin.patient-plan-subscriptions.index') }}"
           class="nav-link {{ Request::is('admin/patient-plan-subscriptions*') ? 'active' : '' }}">
          <span class="nav-icon">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </span>
          <span class="nav-text">Patient Subscriptions</span>
        </a>
      </div>

    </nav>

    {{-- Logout footer --}}
    <div class="sidebar-footer">
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="logout-btn">
          <div class="logout-inner">
            <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            <span class="logout-text">Logout</span>
          </div>
        </button>
      </form>
    </div>

  </aside>

  {{-- ══════════════ MAIN ══════════════ --}}
  <div class="main-wrapper">

    <header class="topbar">
      <div class="topbar-actions">
        <div class="user-pill">
          <div class="user-pill-avatar">{{ Auth::user()->name[0] }}</div>
          <span class="user-pill-name">{{ Auth::user()->name }}</span>
          <span class="user-pill-badge">Active</span>
        </div>
      </div>
    </header>

    <main class="content">
      @yield('content')
    </main>

  </div>

  <script>
    function toggleSidebar() {
      const sb = document.getElementById('sidebar');
      sb.classList.toggle('collapsed');
      if (sb.classList.contains('collapsed')) {
        document.querySelectorAll('.nav-item.open').forEach(i => i.classList.remove('open'));
      }
    }

    function toggleDropdown(element) {
      const sb = document.getElementById('sidebar');
      if (sb.classList.contains('collapsed')) return;
      element.closest('.nav-item').classList.toggle('open');
    }

    function toggleMobile() {
      const sb      = document.getElementById('sidebar');
      const overlay = document.querySelector('.overlay');
      sb.classList.toggle('mobile-open');
      overlay.classList.toggle('active');
    }

    // Close mobile menu on nav link click (on mobile)
    document.querySelectorAll('.nav-link, .dropdown-item').forEach(link => {
      link.addEventListener('click', function() {
        if (window.innerWidth <= 1024) toggleMobile();
      });
    });

    // Chart init (kept from original for dashboard use)
    let chart;
    let isDarkMode = false; // light theme now

    function initChart() {
      const canvas = document.getElementById('performanceChart');
      if (!canvas) return;
      const ctx = canvas.getContext('2d');

      const g1 = ctx.createLinearGradient(0, 0, 0, 280);
      g1.addColorStop(0, 'rgba(45,125,210,0.20)');
      g1.addColorStop(1, 'rgba(45,125,210,0)');

      const g2 = ctx.createLinearGradient(0, 0, 0, 280);
      g2.addColorStop(0, 'rgba(22,169,106,0.20)');
      g2.addColorStop(1, 'rgba(22,169,106,0)');

      const g3 = ctx.createLinearGradient(0, 0, 0, 280);
      g3.addColorStop(0, 'rgba(208,128,32,0.20)');
      g3.addColorStop(1, 'rgba(208,128,32,0)');

      chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
          datasets: [{
            label: 'Sent',
            data: [2800,2600,5500,3200,4800,3800,3500,4200,5800,8500,5200,7500],
            borderColor: '#2D7DD2',
            backgroundColor: g1,
            tension: 0.4,fill:true,borderWidth:2,
            pointRadius:0,pointHoverRadius:5,
            pointBackgroundColor:'#2D7DD2',
          },{
            label: 'Opened',
            data: [2200,2800,9500,3600,4200,3200,3000,3600,4500,9800,6500,5800],
            borderColor: '#16A96A',
            backgroundColor: g2,
            tension: 0.4,fill:true,borderWidth:2,
            pointRadius:0,pointHoverRadius:5,
            pointBackgroundColor:'#16A96A',
          },{
            label: 'Clicked',
            data: [800,900,1800,1200,1600,1300,1100,1500,1700,2100,1900,2200],
            borderColor: '#D08020',
            backgroundColor: g3,
            tension: 0.4,fill:true,borderWidth:2,
            pointRadius:0,pointHoverRadius:5,
            pointBackgroundColor:'#D08020',
          }]
        },
        options: {
          responsive:true,maintainAspectRatio:false,
          interaction:{ mode:'index',intersect:false },
          plugins:{
            legend:{ display:false },
            tooltip:{
              backgroundColor:'#ffffff',
              titleColor:'#1A2B42',bodyColor:'#4A6080',
              borderColor:'#D6E4F5',borderWidth:1,
              padding:12,cornerRadius:8,
              boxWidth:8,boxHeight:8,boxPadding:4
            }
          },
          scales:{
            y:{
              beginAtZero:true,
              grid:{ color:'rgba(214,228,245,0.7)',drawBorder:false },
              ticks:{ color:'#8FA8C4',font:{size:11},padding:8 },
              border:{ display:false }
            },
            x:{
              grid:{ display:false },
              ticks:{ color:'#8FA8C4',font:{size:11},padding:8 },
              border:{ display:false }
            }
          }
        }
      });
    }

    document.addEventListener('DOMContentLoaded', initChart);
  </script>
</body>
</html>