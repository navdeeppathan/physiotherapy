@extends('layouts.app')

@section('content')

<!-- <style>
	/* ===== Physiopii Home — theme-matched refresh ===== */
	:root{
		--pp-primary:#09e5ab;
		--pp-primary-dark:#09dca4;
		--pp-cyan:#0de0fe;
		--pp-navy:#15558d;
		--pp-navy-dark:#0e3f68;
		--pp-text:#272b41;
		--pp-muted:#757575;
		--pp-bg:#f8f9fa;
	}

	/* Hero */
	.pp-hero{
		background:linear-gradient(135deg, var(--pp-navy) 0%, var(--pp-navy-dark) 100%);
		padding:90px 0 130px;
		position:relative;
		overflow:hidden;
	}
	.pp-hero::before{
		content:"";
		position:absolute;
		top:-80px; right:-80px;
		width:320px; height:320px;
		background:radial-gradient(circle, rgba(9,229,171,0.25) 0%, rgba(9,229,171,0) 70%);
		border-radius:50%;
	}
	.pp-hero::after{
		content:"";
		position:absolute;
		bottom:-100px; left:-60px;
		width:260px; height:260px;
		background:radial-gradient(circle, rgba(13,224,254,0.2) 0%, rgba(13,224,254,0) 70%);
		border-radius:50%;
	}
	.pp-hero-inner{ position:relative; z-index:2; max-width:720px; margin:0 auto; text-align:center; }
	.pp-hero-inner h1{ color:#fff; font-weight:600; font-size:2.6rem; margin-bottom:14px; }
	.pp-hero-inner p{ color:rgba(255,255,255,0.75); font-size:1.05rem; margin-bottom:0; }

	.pp-search-card{
		background:#fff;
		border-radius:14px;
		box-shadow:0 20px 45px rgba(14,63,104,0.25);
		padding:14px;
		margin-top:40px;
		display:flex;
		gap:10px;
		position:relative;
		z-index:2;
	}
	.pp-search-card .pp-field{
		flex:1;
		display:flex;
		align-items:center;
		gap:10px;
		padding:10px 16px;
		border-radius:10px;
		background:var(--pp-bg);
	}
	.pp-search-card .pp-field i{ color:var(--pp-cyan); font-size:16px; }
	.pp-search-card .pp-field input{
		border:0; background:transparent; width:100%; font-size:14px; color:var(--pp-text);
	}
	.pp-search-card .pp-field input:focus{ outline:none; }
	.pp-search-btn{
		background:var(--pp-primary);
		border:none;
		color:#fff;
		font-weight:500;
		border-radius:10px;
		padding:0 28px;
		white-space:nowrap;
		transition:background .3s ease;
	}
	.pp-search-btn:hover{ background:var(--pp-primary-dark); color:#fff; }

	.pp-stats{
		position:relative; z-index:2;
		display:flex; justify-content:center; gap:60px;
		margin-top:50px;
	}
	.pp-stats div{ text-align:center; }
	.pp-stats h3{ color:#fff; font-weight:600; font-size:1.7rem; margin-bottom:2px; }
	.pp-stats span{ color:rgba(255,255,255,0.65); font-size:13px; text-transform:uppercase; letter-spacing:.5px; }

	/* Why choose us strip */
	.pp-why{ background:#fff; padding:0; margin-top:-60px; position:relative; z-index:3; }
	.pp-why-card{
		background:#fff;
		border:1px solid #f0f0f0;
		border-radius:14px;
		box-shadow:0 10px 30px rgba(21,85,141,0.06);
		padding:26px;
		display:flex;
		gap:16px;
		align-items:flex-start;
		height:100%;
	}
	.pp-why-icon{
		width:48px; height:48px; min-width:48px;
		border-radius:12px;
		display:flex; align-items:center; justify-content:center;
		background:rgba(9,229,171,0.12);
		color:var(--pp-primary-dark);
		font-size:20px;
	}
	.pp-why-card h5{ font-size:16px; font-weight:600; margin-bottom:6px; }
	.pp-why-card p{ font-size:13.5px; color:var(--pp-muted); margin:0; }

	/* Specialities */
	.pp-spec-card{
		background:#fff;
		border:1px solid #f0f0f0;
		border-radius:14px;
		padding:24px 16px;
		text-align:center;
		transition:transform .25s ease, box-shadow .25s ease, border-color .25s ease;
	}
	.pp-spec-card:hover{
		transform:translateY(-6px);
		box-shadow:0 14px 30px rgba(21,85,141,0.1);
		border-color:transparent;
	}
	.pp-spec-card img{ width:56px; height:56px; object-fit:contain; margin-bottom:14px; }
	.pp-spec-card p{ font-weight:500; font-size:14px; margin:0; color:var(--pp-text); }

	/* Doctor cards */
	.pp-doc-card{
		background:#fff;
		border:1px solid #f0f0f0;
		border-radius:14px;
		overflow:hidden;
		transition:transform .25s ease, box-shadow .25s ease;
		height:100%;
	}
	.pp-doc-card:hover{ transform:translateY(-4px); box-shadow:0 16px 34px rgba(21,85,141,0.1); }
	.pp-doc-img{ position:relative; height:190px; overflow:hidden; }
	.pp-doc-img img{ width:100%; height:100%; object-fit:cover; }
	.pp-doc-badge{
		position:absolute; top:12px; left:12px;
		background:var(--pp-primary);
		color:#fff; font-size:11px; font-weight:600;
		padding:4px 10px; border-radius:20px;
	}
	.pp-doc-body{ padding:18px; }
	.pp-doc-body h3{ font-size:16px; font-weight:600; margin-bottom:2px; }
	.pp-doc-body .pp-spec{ font-size:13px; color:var(--pp-cyan); font-weight:500; margin-bottom:10px; }
	.pp-doc-meta{ display:flex; justify-content:space-between; font-size:12.5px; color:var(--pp-muted); margin-bottom:16px; }
	.pp-doc-meta span i{ margin-right:4px; color:var(--pp-primary-dark); }
	.pp-doc-actions{ display:flex; gap:8px; }
	.pp-doc-actions a{ flex:1; text-align:center; border-radius:8px; padding:9px; font-size:13px; font-weight:500; }
	.pp-doc-actions .pp-view{ border:1.5px solid var(--pp-cyan); color:var(--pp-cyan); }
	.pp-doc-actions .pp-view:hover{ background:var(--pp-cyan); color:#fff; }
	.pp-doc-actions .pp-book{ background:var(--pp-primary); color:#fff; border:1.5px solid var(--pp-primary); }
	.pp-doc-actions .pp-book:hover{ background:var(--pp-primary-dark); border-color:var(--pp-primary-dark); }

	/* CTA */
	.pp-cta{
		background:linear-gradient(120deg, var(--pp-navy) 0%, var(--pp-navy-dark) 100%);
		border-radius:20px;
		padding:50px 40px;
		display:flex;
		align-items:center;
		justify-content:space-between;
		flex-wrap:wrap;
		gap:20px;
	}
	.pp-cta h3{ color:#fff; font-weight:600; margin-bottom:6px; }
	.pp-cta p{ color:rgba(255,255,255,0.7); margin:0; }
	.pp-cta a{
		background:var(--pp-primary);
		color:#fff; font-weight:500;
		padding:14px 30px; border-radius:10px;
		white-space:nowrap;
	}
	.pp-cta a:hover{ background:var(--pp-primary-dark); color:#fff; }

	@media (max-width: 767px){
		.pp-hero{ padding:60px 0 100px; }
		.pp-hero-inner h1{ font-size:1.9rem; }
		.pp-search-card{ flex-direction:column; }
		.pp-stats{ gap:30px; flex-wrap:wrap; }
		.pp-cta{ flex-direction:column; text-align:center; }
	}
</style> -->

		<!-- Main Wrapper -->
		<div class="main-wrapper">

			@include('layouts.header')

			<!-- Hero -->
			<section class="pp-hero">
				<div class="container-fluid">
					<div class="pp-hero-inner">
						<h1>Search Doctor, Make an Appointment</h1>
						<p>Discover the best doctors, clinics & hospitals in the city nearest to you.</p>
					</div>

					<div class="pp-search-card">
						<div class="pp-field">
							<i class="fas fa-map-marker-alt"></i>
							<input type="text" placeholder="Search Location">
						</div>
						<div class="pp-field">
							<i class="fas fa-search"></i>
							<input type="text" placeholder="Search Doctors, Clinics, Diseases Etc">
						</div>
						<form action="" method="GET" style="display:flex;">
							<button type="submit" class="pp-search-btn">Search</button>
						</form>
					</div>

					<div class="pp-stats">
						<div>
							<h3>{{ $doctors->count() ?? '250+' }}</h3>
							<span>Verified Doctors</span>
						</div>
						<div>
							<h3>15K+</h3>
							<span>Happy Patients</span>
						</div>
						<div>
							<h3>4.8/5</h3>
							<span>Average Rating</span>
						</div>
					</div>
				</div>
			</section>
			<!-- /Hero -->

			<!-- Why Choose Us -->
			<section class="pp-why">
				<div class="container-fluid">
					<div class="row g-3">
						<div class="col-md-4 mb-3 mb-md-0">
							<div class="pp-why-card">
								<div class="pp-why-icon"><i class="fas fa-user-md"></i></div>
								<div>
									<h5>Verified Doctors</h5>
									<p>Every profile is checked for licensing and credentials before going live.</p>
								</div>
							</div>
						</div>
						<div class="col-md-4 mb-3 mb-md-0">
							<div class="pp-why-card">
								<div class="pp-why-icon"><i class="fas fa-calendar-check"></i></div>
								<div>
									<h5>Instant Booking</h5>
									<p>Pick a slot and confirm your appointment in under two minutes.</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="pp-why-card">
								<div class="pp-why-icon"><i class="fas fa-shield-alt"></i></div>
								<div>
									<h5>Secure & Private</h5>
									<p>Your medical data and payments are encrypted end-to-end.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- /Why Choose Us -->

			<!-- Clinic and Specialities -->
			<section class="section section-specialities">
				<div class="container-fluid">
					<div class="section-header text-center">
						<h2>Clinic and Specialities</h2>
						<p class="sub-title">Browse doctors by specialty and find the right care faster.</p>
					</div>
					<div class="row justify-content-center g-3">
						<div class="col-6 col-md-2">
							<div class="pp-spec-card">
								<img src="{{ asset('assets/img/specialities/specialities-01.png') }}" alt="Urology">
								<p>Urology</p>
							</div>
						</div>
						<div class="col-6 col-md-2">
							<div class="pp-spec-card">
								<img src="{{ asset('assets/img/specialities/specialities-02.png') }}" alt="Neurology">
								<p>Neurology</p>
							</div>
						</div>
						<div class="col-6 col-md-2">
							<div class="pp-spec-card">
								<img src="{{ asset('assets/img/specialities/specialities-03.png') }}" alt="Orthopedic">
								<p>Orthopedic</p>
							</div>
						</div>
						<div class="col-6 col-md-2">
							<div class="pp-spec-card">
								<img src="{{ asset('assets/img/specialities/specialities-04.png') }}" alt="Cardiologist">
								<p>Cardiologist</p>
							</div>
						</div>
						<div class="col-6 col-md-2">
							<div class="pp-spec-card">
								<img src="{{ asset('assets/img/specialities/specialities-05.png') }}" alt="Dentist">
								<p>Dentist</p>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- /Clinic and Specialities -->

			<!-- Popular Section -->
			<section class="section section-doctor">
				<div class="container-fluid">
					<div class="section-header text-center">
						<h2>Book Our Doctors</h2>
						<p class="sub-title">Trusted specialists, verified profiles, and easy online booking.</p>
					</div>

					<div class="row g-4">
						@forelse($doctors as $doctor)
							<div class="col-md-6 col-lg-3">
								<div class="pp-doc-card">
									<div class="pp-doc-img">
										<span class="pp-doc-badge"><i class="fas fa-check-circle"></i> Verified</span>
										<a href="{{ route('doctor.profile', $doctor->id) }}">
											<img src="{{ $doctor->profile?->profile_image ?? asset('assets/img/doctors/default.jpg') }}"
												alt="Dr. {{ $doctor->name }}">
										</a>
									</div>
									<div class="pp-doc-body">
										<h3>
											<a href="{{ route('doctor.profile', $doctor->id) }}" style="color:inherit;">
												Dr. {{ $doctor->name }}
											</a>
										</h3>
										<p class="pp-spec">{{ $doctor->profile?->specializationdata?->name ?? 'Physiotherapist' }}</p>
										<div class="pp-doc-meta">
											<span><i class="fas fa-map-marker-alt"></i>{{ $doctor->profile?->city ?? 'Indore' }}</span>
											<span><i class="far fa-money-bill-alt"></i>₹{{ $doctor->fee?->total_fee ?? 0 }}</span>
										</div>
										<div class="pp-doc-actions">
											<a href="{{ route('doctor.profile', $doctor->id) }}" class="pp-view">View Profile</a>
											<a href="{{ route('booking', $doctor->id) }}" class="pp-book">Book Now</a>
										</div>
									</div>
								</div>
							</div>
						@empty
							<div class="col-12 text-center py-4">
								<p class="text-muted">No doctors available right now. Please check back soon.</p>
							</div>
						@endforelse
					</div>

					<div class="text-center mt-4">
						<a href="{{ route('search') }}" class="btn btn-primary btn-rounded px-4">View All Doctors</a>
					</div>
				</div>
			</section>
			<!-- /Popular Section -->

			<!-- Available Features -->
			<section class="section section-features">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-5 features-img">
							<img src="{{ asset('assets/img/features/feature.png') }}" class="img-fluid" alt="Clinic feature overview">
						</div>
						<div class="col-md-7">
							<div class="section-header">
								<h2 class="mt-2">Available Features in Our Clinic</h2>
								<p>Everything you need for comfortable, quality care under one roof.</p>
							</div>
							<div class="features-slider slider">
								<div class="feature-item text-center">
									<img src="{{ asset('assets/img/features/feature-01.jpg') }}" class="img-fluid" alt="Patient Ward">
									<p>Patient Ward</p>
								</div>
								<div class="feature-item text-center">
									<img src="{{ asset('assets/img/features/feature-02.jpg') }}" class="img-fluid" alt="Test Room">
									<p>Test Room</p>
								</div>
								<div class="feature-item text-center">
									<img src="{{ asset('assets/img/features/feature-03.jpg') }}" class="img-fluid" alt="ICU">
									<p>ICU</p>
								</div>
								<div class="feature-item text-center">
									<img src="{{ asset('assets/img/features/feature-04.jpg') }}" class="img-fluid" alt="Laboratory">
									<p>Laboratory</p>
								</div>
								<div class="feature-item text-center">
									<img src="{{ asset('assets/img/features/feature-05.jpg') }}" class="img-fluid" alt="Operation">
									<p>Operation</p>
								</div>
								<div class="feature-item text-center">
									<img src="{{ asset('assets/img/features/feature-06.jpg') }}" class="img-fluid" alt="Medical">
									<p>Medical</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- /Available Features -->

			<!-- CTA -->
			<section class="section" style="padding:0 0 80px;">
				<div class="container-fluid">
					<div class="pp-cta">
						<div>
							<h3>Ready to book your appointment?</h3>
							<p>Join thousands of patients who trust Physiopii for their healthcare needs.</p>
						</div>
						<a href="{{ route('search') }}">Find a Doctor</a>
					</div>
				</div>
			</section>
			<!-- /CTA -->

			@include('layouts.footer')

		</div>
@endsection