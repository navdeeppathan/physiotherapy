@extends('layouts.app')

@section('content')



		<!-- Main Wrapper -->
		<div class="main-wrapper">

			@include('layouts.header')

				<!-- Home Banner -->
			<section class="section section-search">
				<div class="container-fluid">
					<div class="banner-wrapper">
						<div class="banner-header text-center">
							<h1>Search Doctor, Make an Appointment</h1>
							<p>Discover the best doctors, clinic & hospital the city nearest to you.</p>
						</div>
                         
						<!-- Search -->
						<div class="search-box">
							<form action="templateshub.net">
								<div class="form-group search-location">
									<input type="text" class="form-control" placeholder="Search Location">
									<span class="form-text">Based on your Location</span>
								</div>
								<div class="form-group search-info">
									<input type="text" class="form-control" placeholder="Search Doctors, Clinics, Hospitals, Diseases Etc">
									<span class="form-text">Ex : Dental or Sugar Check up etc</span>
								</div>
								<button type="submit" class="btn btn-primary search-btn"><i class="fas fa-search"></i> <span>Search</span></button>
							</form>
						</div>
						<!-- /Search -->
						
					</div>
				</div>
			</section>
			<!-- /Home Banner -->
			  
			<!-- Clinic and Specialities -->
			<section class="section section-specialities">
				<div class="container-fluid">
					<div class="section-header text-center">
						<h2>Clinic and Specialities</h2>
						<p class="sub-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
					</div>
					<div class="row justify-content-center">
						<div class="col-md-9">
							<!-- Slider -->
							<div class="specialities-slider slider">
							
								<!-- Slider Item -->
								<div class="speicality-item text-center">
									<div class="speicality-img">
										<img src="assets/img/specialities/specialities-01.png" class="img-fluid" alt="Speciality">
										<span><i class="fa fa-circle" aria-hidden="true"></i></span>
									</div>
									<p>Urology</p>
								</div>	
								<!-- /Slider Item -->
								
								<!-- Slider Item -->
								<div class="speicality-item text-center">
									<div class="speicality-img">
										<img src="assets/img/specialities/specialities-02.png" class="img-fluid" alt="Speciality">
										<span><i class="fa fa-circle" aria-hidden="true"></i></span>
									</div>
									<p>Neurology</p>	
								</div>							
								<!-- /Slider Item -->
								
								<!-- Slider Item -->
								<div class="speicality-item text-center">
									<div class="speicality-img">
										<img src="assets/img/specialities/specialities-03.png" class="img-fluid" alt="Speciality">
										<span><i class="fa fa-circle" aria-hidden="true"></i></span>
									</div>	
									<p>Orthopedic</p>	
								</div>							
								<!-- /Slider Item -->
								
								<!-- Slider Item -->
								<div class="speicality-item text-center">
									<div class="speicality-img">
										<img src="assets/img/specialities/specialities-04.png" class="img-fluid" alt="Speciality">
										<span><i class="fa fa-circle" aria-hidden="true"></i></span>
									</div>	
									<p>Cardiologist</p>	
								</div>							
								<!-- /Slider Item -->
								
								<!-- Slider Item -->
								<div class="speicality-item text-center">
									<div class="speicality-img">
										<img src="assets/img/specialities/specialities-05.png" class="img-fluid" alt="Speciality">
										<span><i class="fa fa-circle" aria-hidden="true"></i></span>
									</div>	
									<p>Dentist</p>
								</div>							
								<!-- /Slider Item -->
								
							</div>
							<!-- /Slider -->
							
						</div>
					</div>
				</div>   
			</section>	 
			<!-- Clinic and Specialities -->

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