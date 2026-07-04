			
			
<!-- Header -->
			<header class="header">
				<nav class="navbar navbar-expand-lg header-nav">
					<div class="navbar-header">
						<a id="mobile_btn" href="javascript:void(0);">
							<span class="bar-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</a>
						<a href="/" class="navbar-brand logo">
							<img src="{{ asset('assets/img/logo.png') }}" class="img-fluid" alt="Logo">
							 {{-- <img src="assets/img/logo.png" class="img-fluid" alt="Logo"> --}}
						</a>
					</div>
					<div class="main-menu-wrapper">
						<div class="menu-header">
							<a href="/" class="menu-logo">
								<img src="assets/img/logo.png" class="img-fluid" alt="Logo">
							</a>
							<a id="menu_close" class="menu-close" href="javascript:void(0);">
								<i class="fas fa-times"></i>
							</a>
						</div>
						<ul class="main-nav">
							<li class="active">
								<a href="/">Home</a>
							</li>	
							{{-- <li class="has-submenu">
								<a href="#">Patients <i class="fas fa-chevron-down"></i></a>
								<ul class="submenu">
									<li><a href="/patient-dashboard">Patient Dashboard</a></li>
								
								</ul>
							</li>	 --}}
							
							{{-- <li class="login-link">
								<a href="/login">Login / Signup</a>
							</li> --}}
						</ul>		 
					</div>		 
					{{-- <ul class="nav header-navbar-rht">
						<li class="nav-item contact-item">
							<div class="header-contact-img">
								<i class="far fa-hospital"></i>							
							</div>
							<div class="header-contact-detail">
								<p class="contact-header">Contact</p>
								<p class="contact-info-header"> +1 315 369 5943</p>
							</div>
						</li>
						<li class="nav-item">
							<a class="nav-link header-login" href="/login">login / Signup </a>
						</li>
					</ul> --}}
					<ul class="nav header-navbar-rht">
						<li class="nav-item contact-item">
							<div class="header-contact-img">
								<i class="far fa-hospital"></i>
							</div>
							<div class="header-contact-detail">
								<p class="contact-header">Contact</p>
								<p class="contact-info-header">+1 315 369 5943</p>
							</div>
						</li>

						@guest
							<li class="nav-item">
								<a class="nav-link header-login" href="{{ route('login') }}">
									Login / Signup
								</a>
							</li>
						@endguest

						@auth
							<li class="nav-item dropdown has-arrow logged-item">
								<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
									<span class="user-img">
										<img class="rounded-circle"
											src="{{ Auth::user()->profile_img ? asset(Auth::user()->profile_img) : asset('assets/img/patients/patient.jpg') }}"
											width="35"
											height="35"
											alt="{{ Auth::user()->name }}">
									</span>
								</a>

								<div class="dropdown-menu dropdown-menu-right">
									<div class="user-header">
										<div class="avatar avatar-sm">
											<img class="avatar-img rounded-circle"
												src="{{ Auth::user()->profile_img ? asset(Auth::user()->profile_img) : asset('assets/img/patients/patient.jpg') }}"
												alt="">
										</div>

										<div class="user-text">
											<h6>{{ Auth::user()->name }}</h6>
											<p class="text-muted mb-0">{{ ucfirst(Auth::user()->role) }}</p>
										</div>
									</div>

									<a class="dropdown-item" href="{{ route('patient.dashboard') }}">
										Dashboard
									</a>

									{{-- <a class="dropdown-item" href="{{ route('patient.profile') }}">
										Profile Settings
									</a> --}}

									<form action="{{ route('patient.logout') }}" method="GET">
										@csrf

										<button type="submit" class="dropdown-item">
											Logout
										</button>
									</form>
								</div>
							</li>
						@endauth
					</ul>
				</nav>
			</header>
			<!-- /Header -->