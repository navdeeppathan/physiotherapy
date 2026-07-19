@extends('layouts.app')

@section('content')

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			@include('layouts.header')
			
			<!-- Home Banner -->
			{{-- <section class="section section-search">
				<div class="container-fluid">
					<div class="banner-wrapper">
						<div class="banner-header text-center">
							<h1>Expert Physiotherapy at Your Home</h1>
							<p>Book trusted physiotherapists for personalized home care.</p>
						</div>
                         
						
						<div class="search-box">

							<div class="form-group search-info">

								<input
									type="text"
									id="doctorSearch"
									class="form-control"
									placeholder="Search Doctor or Physiotherapy Category">

								<span class="form-text">
									Ex: Orthopedic, Neurological, Dr. Rahul
								</span>

								<div id="doctorDropdown"></div>

							</div>

						</div>
						
					</div>
				</div>
			</section> --}}
			<!-- /Home Banner -->

			<section class="section section-search">
				<div class="container-fluid">
					<div class="hero-wrapper">
						<div class="hero-grid">

							<!-- LEFT CONTENT -->
							<div class="hero-content">
								<span class="hero-badge">
									<i class="dot"></i> TRUSTED HOME PHYSIOTHERAPY
								</span>

								<h1 class="hero-title">
									Expert Physiotherapy <br>
									<span>at Your Home</span>
								</h1>

								<p class="hero-subtitle">
									Book trusted physiotherapists for personalized home care —
									anytime, anywhere across India.
								</p>

								<div class="search-box">
									<div class="form-group search-info">
										<input
											type="text"
											id="doctorSearch"
											class="form-control"
											placeholder="Search doctor or physiotherapy category...">

										{{-- <button class="search-btn" type="button">Search</button> --}}

										<div id="doctorDropdown"></div>
									</div>
								</div>

								<span class="search-hint">e.g. Orthopaedic, Neurological, Dr. Rahul</span>

								<ul class="hero-points">
									<li><i class="dot"></i> 100+ Verified Experts</li>
									<li><i class="dot"></i> 5,000+ Happy Patients</li>
									<li><i class="dot"></i> 4.9 &#9733; Average Rating</li>
								</ul>
							</div>

							<!-- RIGHT ILLUSTRATION -->
							<div class="hero-visual">
								<div class="visual-frame">
									<div class="illustration">
										<div class="ill-head"></div>
										<div class="ill-body"></div>
										<div class="ill-clipboard">
											<span></span><span></span><span></span>
										</div>
									</div>
								</div>

								<div class="floating-card rating-card">
									<div class="rating-value">4.9</div>
									<div class="rating-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
									<div class="rating-count">5,000+ reviews</div>
								</div>

								<div class="floating-card doctor-card">
									<div class="doctor-card-top">
										<div class="doctor-avatar">N</div>
										<div>
											<div class="doctor-name">Dr. Nikee</div>
											<div class="doctor-role">Post Surgery</div>
										</div>
									</div>
									<div class="doctor-card-bottom">
										<span class="slot-time">Today, 3:00 PM</span>
										<span class="slot-status">Booked</span>
									</div>
								</div>
							</div>

						</div>
					</div>

					<!-- BOTTOM STATS BAR -->
					<div class="stats-bar">
						<div class="stat-item">
							<div class="stat-icon">&#128101;</div>
							<div class="stat-text">
								<strong>100+</strong>
								<span>Physiotherapists</span>
							</div>
						</div>
						<div class="stat-item">
							<div class="stat-icon">&#10084;</div>
							<div class="stat-text">
								<strong>5,000+</strong>
								<span>Happy Patients</span>
							</div>
						</div>
						<div class="stat-item">
							<div class="stat-icon">&#9733;</div>
							<div class="stat-text">
								<strong>4.9&#9733;</strong>
								<span>Average Rating</span>
							</div>
						</div>
						<div class="stat-item">
							<div class="stat-icon">&#128337;</div>
							<div class="stat-text">
								<strong>24&times;7</strong>
								<span>Home Visit Support</span>
							</div>
						</div>
					</div>
				</div>
			</section>
			  
			<!-- Clinic and Specialities -->
			{{-- <section class="section section-specialities">
				<div class="container-fluid">
					<div class="section-header text-center">
						<h2>Specialities</h2>
						<p class="sub-title">
							Choose from trusted physiotherapy specialties for personalized care.
						</p>
					</div>
					<div class="row justify-content-center">
						<div class="col-md-9">
							<!-- Slider -->
							
							<div class="specialities-slider slider">
						
								

								@foreach($specializations as $specialization)
									<div class="speicality-item text-center specialization-filter" data-id="{{ $specialization->id }}">
										<div class="speicality-img">
											<img
												src="{{ asset('images/specializations/' . $specialization->icon) }}"
												class="img-fluid"
												alt="{{ $specialization->name }}"
											>
											
										</div>

										<p>{{ $specialization->name }}</p>
									</div>
								@endforeach
								
							</div>
							<!-- /Slider -->
							
						</div>
					</div>
				</div>   
			</section>	  --}}
			<!-- Clinic and Specialities -->
			<section class="section section-specialities">
				<div class="container-fluid">
					<div class="section-header text-center">
						<span class="spec-badge">BROWSE BY CATEGORY</span>
						<h2>Specialities</h2>
						<p class="sub-title">
							Choose from trusted physiotherapy specialities for personalized
							care.
						</p>
					</div>

					<div class="specialities-grid">

						@foreach($specializations as $specialization)
							<div class="speciality-card specialization-filter" data-id="{{ $specialization->id }}">
								<div class="speciality-icon icon-{{ $loop->iteration % 6 }}">
									<img
										src="{{ asset('images/specializations/' . $specialization->icon) }}"
										class="img-fluid"
										alt="{{ $specialization->name }}">
								</div>
								<p>{{ $specialization->name }}</p>
							</div>
						@endforeach

						<a 
						{{-- href="{{ route('doctors.index') }}"  --}}
						class="speciality-card speciality-viewall">
							<div class="speciality-icon icon-viewall">
								<i class="fa-solid fa-hospital-user"></i>
							</div>
							<p>View All</p>
						</a>

					</div>
				</div>
			</section>
		  
			<!-- Popular Section -->
			{{-- <section class="section section-doctor">
				<div class="container-fluid">
				   <div class="row">
						
						<div class="col-lg-12">
							<div class="doctor-slider slider">

								@foreach($doctors as $doctor)
									<div class="profile-widget doctor-card" data-specialization="{{ optional($doctor->profile)->specialization }}">
										<div class="doc-img">
											<a href="{{ route('doctor.profile', $doctor->id) }}">
												<img
													class="img-fluid"
													src="{{ $doctor->profile_img ? asset($doctor->profile_img) : asset('assets/img/doctors/doctor-thumb-01.jpg') }}"
													alt="{{ $doctor->name }}"
												>
											</a>

											<a href="javascript:void(0)" class="fav-btn">
												<i class="far fa-bookmark"></i>
											</a>
										</div>

										<div class="pro-content">

											<h3 class="title">
												<a href="{{ route('doctor.profile', $doctor->id) }}">
													{{ $doctor->name }}
												</a>

												
													<i class="fas fa-check-circle verified"></i>
												
											</h3>

											<p class="speciality">
												{{ optional($doctor->profile)->qualification }}

												
												@if(optional($doctor->profile->specializationdata)->name)
													,
													{{ optional($doctor->profile->specializationdata)->name }}
												@endif
											</p>

											<div class="rating">
												@php
													$rating = round(optional($doctor->profile)->rating ?? 0);
												@endphp

												@for($i=1;$i<=5;$i++)
													<i class="fas fa-star {{ $i <= $rating ? 'filled' : '' }}"></i>
												@endfor

												<span class="d-inline-block average-rating">
													({{ optional($doctor->profile)->total_reviews ?? 0 }})
												</span>
											</div>

											<ul class="available-info">

												<li>
													<i class="fas fa-map-marker-alt"></i>

													{{ optional($doctor->address) ? $doctor->address : $doctor->profile->clinic_address }}
													
												</li>

												<li>
													<i class="far fa-clock"></i>

													{{ optional($doctor->profile)->experience_years ?? 0 }}
													Years Experience
												</li>

												

											</ul>

											<div class="row row-sm">

												<div class="col-6">
													<a 
													href="{{ route('doctor.profile', $doctor->id) }}"
													class="btn view-btn">
														View Profile
													</a>
												</div>

												<div class="col-6">
													@auth
													<a 
														href="{{ route('doctor.booking', $doctor->id) }}"
														class="btn book-btn">
														Book Now
													</a>
													@else
													<a 
														href="{{ route('login') }}"
														class="btn book-btn">
														Book Now
													</a>
													@endauth
												</div>

											</div>

										</div>
									</div>
								@endforeach
							
								
								
							</div>
						</div>
				   </div>
				</div>
			</section> --}}
			<!-- /Popular Section -->
			<section class="section section-doctor">
				<div class="container-fluid">

					<div class="doctor-header">
						<div>
							<span class="section-badge">OUR TEAM</span>
							<h2>Top Physiotherapists</h2>
							<p class="section-sub">Verified, experienced specialists ready to visit your home.</p>
						</div>

						<a 
						{{-- href="{{ route('doctors.index') }}"  --}}
						class="btn-view-all">
							View All Doctors <i class="fa-solid fa-arrow-right"></i>
						</a>
					</div>

					<div class="doctor-grid">

						@foreach($doctors as $doctor)
							@php
								$colorIndex = $loop->iteration % 4;
								$rating = optional($doctor->profile)->rating ?? 0;
							@endphp

							<div class="doctor-card card-color-{{ $colorIndex }}" data-specialization="{{ optional($doctor->profile)->specialization }}">

								<div class="doc-banner">
									<span class="doc-rating">
										<i class="fa-solid fa-star"></i> {{ number_format($rating, 1) }}
									</span>

									<div class="doc-photo-wrap">
										<img
											src="{{ $doctor->profile_img ? asset($doctor->profile_img) : asset('assets/img/doctors/doctor-thumb-01.jpg') }}"
											class="doc-photo"
											alt="{{ $doctor->name }}">
									</div>
								</div>

								<div class="doc-content">
									<h3 class="doc-name">
										<a href="{{ route('doctor.profile', $doctor->id) }}">{{ $doctor->name }}</a>
										<i class="fa-solid fa-circle-check verified"></i>
									</h3>

									<p class="doc-speciality speciality-color-{{ $colorIndex }}">
										{{ optional($doctor->profile)->qualification }}
										@if(optional($doctor->profile->specializationdata)->name)
											&middot; {{ optional($doctor->profile->specializationdata)->name }}
										@endif
									</p>

									<ul class="doc-meta">
										<li>
											<i class="fa-solid fa-location-dot"></i>
											{{ optional($doctor->address) ? $doctor->address : $doctor->profile->clinic_address }}
										</li>
										<li>
											<i class="fa-regular fa-clock"></i>
											{{ optional($doctor->profile)->experience_years ?? 0 }} Years Experience
										</li>
									</ul>

									<div class="doc-actions">
										<a href="{{ route('doctor.profile', $doctor->id) }}" class="btn-profile">Profile</a>

										@auth
											<a href="{{ route('doctor.booking', $doctor->id) }}" class="btn-book book-color-{{ $colorIndex }}">Book Now</a>
										@else
											<a href="{{ route('login') }}" class="btn-book book-color-{{ $colorIndex }}">Book Now</a>
										@endauth
									</div>
								</div>

							</div>
						@endforeach

					</div>

				</div>
			</section>

			<section class="section section-how-why">
				<div class="container-fluid">
					<div class="how-why-grid">

						<!-- LEFT: HOW IT WORKS -->
						<div class="how-it-works">
							<span class="section-badge">SIMPLE PROCESS</span>
							<h2>How It Works</h2>
							<p class="section-sub">Get expert physiotherapy at home in 3 easy steps.</p>

							<div class="step-list">

								<div class="step-item">
									<div class="step-icon icon-teal">
										<i class="fa-solid fa-magnifying-glass"></i>
									</div>
									<div class="step-text">
										<h4>Search &amp; Select</h4>
										<p>Find the right specialist by specialty, location, or doctor name.</p>
									</div>
								</div>

								<div class="step-item">
									<div class="step-icon icon-orange">
										<i class="fa-solid fa-calendar-days"></i>
									</div>
									<div class="step-text">
										<h4>Pick a Slot</h4>
										<p>Choose your preferred date, time, and address for the visit.</p>
									</div>
								</div>

								<div class="step-item">
									<div class="step-icon icon-green">
										<i class="fa-solid fa-circle-check"></i>
									</div>
									<div class="step-text">
										<h4>Confirm &amp; Relax</h4>
										<p>Confirm your booking — a verified therapist will arrive at your door.</p>
									</div>
								</div>

							</div>
						</div>

						<!-- RIGHT: WHY CHOOSE US -->
						<div class="why-choose">
							<span class="section-badge">OUR ADVANTAGES</span>
							<h2>Why Choose Physiopii?</h2>
							<p class="section-sub">Expert physiotherapy at your doorstep — professional, convenient, trusted.</p>

							<div class="why-grid">

								<div class="why-card card-blue">
									<div class="why-icon icon-blue-solid">
										<i class="fa-solid fa-user"></i>
									</div>
									<h4>Certified Experts</h4>
									<p>Verified &amp; experienced physiotherapists only.</p>
								</div>

								<div class="why-card card-green">
									<div class="why-icon icon-green-solid">
										<i class="fa-solid fa-house"></i>
									</div>
									<h4>Home Visits</h4>
									<p>Comfortable care, no travel required.</p>
								</div>

								<div class="why-card card-purple">
									<div class="why-icon icon-purple-solid">
										<i class="fa-solid fa-heart"></i>
									</div>
									<h4>Personalized Care</h4>
									<p>Recovery plans tailored just for you.</p>
								</div>

								<div class="why-card card-yellow">
									<div class="why-icon icon-yellow-solid">
										<i class="fa-solid fa-bolt"></i>
									</div>
									<h4>Easy Booking</h4>
									<p>Book appointments anytime in minutes.</p>
								</div>

							</div>
						</div>

					</div>
				</div>
			</section>
		   
		   <!-- Availabe Features -->
		   	{{-- <section class="section section-features">
				<div class="container-fluid">
				   <div class="row">
						<div class="col-md-5 features-img">
							<img src="assets/img/features/feature.png" class="img-fluid" alt="Feature">
						</div>
						<div class="col-md-7">
							<div class="section-header">	
								<h2 class="mt-2">Availabe Features in Our Clinic</h2>
								<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </p>
							</div>	
							<div class="features-slider slider">
								<!-- Slider Item -->
								<div class="feature-item text-center">
									<img src="assets/img/features/feature-01.jpg" class="img-fluid" alt="Feature">
									<p>Patient Ward</p>
								</div>
								<!-- /Slider Item -->
								
								<!-- Slider Item -->
								<div class="feature-item text-center">
									<img src="assets/img/features/feature-02.jpg" class="img-fluid" alt="Feature">
									<p>Test Room</p>
								</div>
								<!-- /Slider Item -->
								
								<!-- Slider Item -->
								<div class="feature-item text-center">
									<img src="assets/img/features/feature-03.jpg" class="img-fluid" alt="Feature">
									<p>ICU</p>
								</div>
								<!-- /Slider Item -->
								
								<!-- Slider Item -->
								<div class="feature-item text-center">
									<img src="assets/img/features/feature-04.jpg" class="img-fluid" alt="Feature">
									<p>Laboratory</p>
								</div>
								<!-- /Slider Item -->
								
								<!-- Slider Item -->
								<div class="feature-item text-center">
									<img src="assets/img/features/feature-05.jpg" class="img-fluid" alt="Feature">
									<p>Operation</p>
								</div>
								<!-- /Slider Item -->
								
								<!-- Slider Item -->
								<div class="feature-item text-center">
									<img src="assets/img/features/feature-06.jpg" class="img-fluid" alt="Feature">
									<p>Medical</p>
								</div>
								<!-- /Slider Item -->
							</div>
						</div>
				   </div>
				</div>
			</section>		 --}}
			<!-- Availabe Features -->
	
			<!-- CTA -->
			{{-- <section class="section" style="padding:0 0 80px;">
				<div class="container-fluid">
					<div class="pp-cta">
						<div>
							<h3>Ready to book your appointment?</h3>
							<p>Join thousands of patients who trust Physiopii for their healthcare needs.</p>
						</div>
						<a href="{{ route('search') }}">Find a Doctor</a>
					</div>
				</div>
			</section> --}}
			<!-- /CTA -->

			<!-- About Section -->
			<section class="section section-features">
				<div class="container-fluid">

					<div class="row align-items-center">

						{{-- <div class="col-lg-5">

							<img src="{{ asset('assets/img/img-01.jpg') }}"
								class="img-fluid rounded shadow"
								alt="About">

						</div> --}}

						<div class="col-lg-12">

							<div class="section-header text-center">

								<h2>Expert Physiotherapy at Your Doorstep</h2>

								<p class="mb-4">
									We connect patients with experienced and certified physiotherapists
									who provide personalized home visit treatments. Our goal is to make
									professional physiotherapy accessible, convenient, and comfortable for
									everyone.
								</p>

							</div>

							<div class="row">

								<div class="col-md-6">

									<div class="feature-item text-center">

										<i class="fas fa-user-md fa-3x text-primary mb-3"></i>

										<h5>Certified Experts</h5>

										<p>
											Experienced physiotherapists delivering quality care.
										</p>

									</div>

								</div>

								<div class="col-md-6">

									<div class="feature-item text-center">

										<i class="fas fa-home fa-3x text-primary mb-3"></i>

										<h5>Home Visits</h5>

										<p>
											Comfortable treatment at your home without travel.
										</p>

									</div>

								</div>

								<div class="col-md-6">

									<div class="feature-item text-center">

										<i class="fas fa-heartbeat fa-3x text-primary mb-3"></i>

										<h5>Personalized Care</h5>

										<p>
											Treatment plans designed for every patient's recovery.
										</p>

									</div>

								</div>

								<div class="col-md-6">

									<div class="feature-item text-center">

										<i class="fas fa-calendar-check fa-3x text-primary mb-3"></i>

										<h5>Easy Booking</h5>

										<p>
											Book appointments online anytime with a few clicks.
										</p>

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>
			</section>


			<section class="section section-testimonials">
				<div class="container-fluid">
					<div class="testi-header text-center">
						<span class="testi-badge">PATIENT STORIES</span>
						<h2>What Patients Say</h2>
						<p>Trusted by thousands across India.</p>
					</div>

					<div class="testi-grid">

						<!-- CARD 1 - HIGHLIGHTED -->
						<div class="testi-card testi-dark">
							<div class="testi-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
							<p class="testi-text">
								"Physiopii made my recovery so smooth. The therapist was
								punctual, professional, and genuinely caring. I didn't have to
								leave my home once!"
							</p>
							<div class="testi-author">
								<div class="testi-avatar avatar-teal">R</div>
								<div>
									<div class="testi-name">Rahul Mehta</div>
									<div class="testi-role">Post Surgery &middot; Mumbai</div>
								</div>
							</div>
						</div>

						<!-- CARD 2 -->
						<div class="testi-card">
							<div class="testi-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
							<p class="testi-text">
								"Excellent service! The physiotherapist was highly
								knowledgeable and gave a personalized plan that really
								worked for my knee pain after surgery."
							</p>
							<div class="testi-author">
								<div class="testi-avatar avatar-purple">S</div>
								<div>
									<div class="testi-name">Sneha Patel</div>
									<div class="testi-role">Orthopaedic &middot; Ahmedabad</div>
								</div>
							</div>
						</div>

						<!-- CARD 3 -->
						<div class="testi-card">
							<div class="testi-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
							<p class="testi-text">
								"Booking was so easy and the doctor arrived on time. My
								father has seen great improvement in mobility. Highly
								recommend Physiopii to everyone!"
							</p>
							<div class="testi-author">
								<div class="testi-avatar avatar-green">A</div>
								<div>
									<div class="testi-name">Amit Sharma</div>
									<div class="testi-role">Geriatric &middot; Delhi</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</section>


			<!-- Why Choose Us -->

			<section class="section">

				<div class="container">

					<div class="section-header text-center">

						<h2>Why Choose Us</h2>

						<p class="sub-title">
							Trusted physiotherapy services focused on your recovery.
						</p>

					</div>

					<div class="row">

						<div class="col-lg-3 col-md-6">

							<div class="card text-center">

								<div class="card-body">

									<i class="fas fa-user-md fa-3x text-primary mb-3"></i>

									<h3>100+</h3>

									<p>Physiotherapists</p>

								</div>

							</div>

						</div>

						<div class="col-lg-3 col-md-6">

							<div class="card text-center">

								<div class="card-body">

									<i class="fas fa-users fa-3x text-success mb-3"></i>

									<h3>5,000+</h3>

									<p>Happy Patients</p>

								</div>

							</div>

						</div>

						<div class="col-lg-3 col-md-6">

							<div class="card text-center">

								<div class="card-body">

									<i class="fas fa-star fa-3x text-warning mb-3"></i>

									<h3>4.9</h3>

									<p>Average Rating</p>

								</div>

							</div>

						</div>

						<div class="col-lg-3 col-md-6">

							<div class="card text-center">

								<div class="card-body">

									<i class="fas fa-home fa-3x text-danger mb-3"></i>

									<h3>24×7</h3>

									<p>Home Visit Support</p>

								</div>

							</div>

						</div>

					</div>

				</div>

			</section>

			<section class="section section-cta">
				<div class="container-fluid">
					<div class="cta-card">
						<div class="cta-glow"></div>

						<div class="cta-content">
							<h2>
								Ready to Start <br>
								<span>Your Recovery?</span>
							</h2>
							<p>
								Book your first session today and get expert care delivered to your home.
								Fast, easy, and professional.
							</p>
						</div>

						<div class="cta-actions">
							<a href="#" class="btn-cta btn-cta-primary">Book Appointment Now</a>
							<a href="#" class="btn-cta btn-cta-outline">View All Doctors</a>
						</div>
					</div>
				</div>
			</section>


   

			@include('layouts.footer')

		</div>

		<style>
			.specialization-filter{
				cursor:pointer;
			}

			

			.specialization-filter.active p{

				color:#09e5ab;

			}

			.section-testimonials {
				background: #fff;
				padding: 90px 0;
			}

			/* ---------- HEADER ---------- */
			.testi-header {
				max-width: 600px;
				margin: 0 auto 50px;
			}

			.testi-badge {
				display: inline-block;
				background: #e4f4fb;
				color: #1a7a8a;
				font-size: 12px;
				font-weight: 700;
				letter-spacing: 0.5px;
				padding: 8px 18px;
				border-radius: 30px;
				margin-bottom: 20px;
			}

			.testi-header h2 {
				color: #0c2b3d;
				font-size: 38px;
				font-weight: 700;
				margin-bottom: 12px;
			}

			.testi-header p {
				color: #6b8088;
				font-size: 16px;
				margin: 0;
			}

			/* ---------- GRID ---------- */
			.testi-grid {
				display: flex;
				gap: 26px;
				max-width: 1300px;
				margin: 0 auto;
				align-items: stretch;
			}

			.testi-card {
				flex: 1;
				background: #f6f8f9;
				border-radius: 16px;
				padding: 32px 30px;
				display: flex;
				flex-direction: column;
				justify-content: space-between;
			}

			.testi-card.testi-dark {
				background: linear-gradient(135deg, #0c2b3d 0%, #14586f 100%);
			}

			.testi-stars {
				color: #f5a623;
				font-size: 15px;
				letter-spacing: 3px;
				margin-bottom: 18px;
			}

			.testi-text {
				font-style: italic;
				font-size: 15px;
				line-height: 1.7;
				color: #45555c;
				margin-bottom: 30px;
			}

			.testi-dark .testi-text {
				color: #dcebf0;
			}

			/* ---------- AUTHOR ---------- */
			.testi-author {
				display: flex;
				align-items: center;
				gap: 12px;
			}

			.testi-avatar {
				width: 42px;
				height: 42px;
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
				font-weight: 700;
				font-size: 15px;
				color: #fff;
				flex-shrink: 0;
			}

			.avatar-teal { background: #3fc7c0; }
			.avatar-purple { background: #a5a8f0; }
			.avatar-green { background: #8fd19e; }

			.testi-name {
				font-size: 15px;
				font-weight: 700;
				color: #0c2b3d;
			}

			.testi-dark .testi-name {
				color: #fff;
			}

			.testi-role {
				font-size: 13px;
				color: #8a9aa1;
			}

			.testi-dark .testi-role {
				color: #a9c2ca;
			}

			/* ---------- RESPONSIVE ---------- */
			@media (max-width: 991px) {
				.testi-grid {
					flex-direction: column;
				}
			}

			.section-cta {
				background: #eef5f8;
				padding: 60px 0;
			}

			.cta-card {
				max-width: 1300px;
				margin: 0 auto;
				background: linear-gradient(120deg, #0c2b3d 0%, #14586f 55%, #1a7a8a 100%);
				border-radius: 20px;
				padding: 55px 60px;
				display: flex;
				align-items: center;
				justify-content: space-between;
				gap: 30px;
				position: relative;
				overflow: hidden;
			}

			.cta-glow {
				position: absolute;
				top: -60px;
				right: 220px;
				width: 340px;
				height: 340px;
				background: rgba(255, 255, 255, 0.06);
				border-radius: 50%;
				filter: blur(10px);
				pointer-events: none;
			}

			.cta-content {
				position: relative;
				z-index: 2;
				max-width: 620px;
			}

			.cta-content h2 {
				font-size: 34px;
				font-weight: 700;
				color: #fff;
				line-height: 1.25;
				margin-bottom: 16px;
			}

			.cta-content h2 span {
				color: #5fd8d2;
			}

			.cta-content p {
				color: #c9dde3;
				font-size: 15px;
				line-height: 1.6;
				margin: 0;
			}

			.cta-actions {
				position: relative;
				z-index: 2;
				display: flex;
				flex-direction: column;
				gap: 14px;
				flex-shrink: 0;
			}

			.btn-cta {
				display: inline-flex;
				align-items: center;
				justify-content: center;
				padding: 14px 28px;
				border-radius: 10px;
				font-size: 15px;
				font-weight: 700;
				text-decoration: none;
				white-space: nowrap;
				transition: 0.2s;
			}

			.btn-cta-primary {
				background: #fff;
				color: #0c2b3d;
			}

			.btn-cta-primary:hover {
				background: #e6f4f4;
				color: #0c2b3d;
			}

			.btn-cta-outline {
				background: transparent;
				color: #fff;
				border: 1px solid rgba(255, 255, 255, 0.4);
			}

			.btn-cta-outline:hover {
				background: rgba(255, 255, 255, 0.08);
				color: #fff;
			}

			/* ---------- RESPONSIVE ---------- */
			@media (max-width: 991px) {
				.cta-card {
					flex-direction: column;
					text-align: center;
					padding: 45px 30px;
				}

				.cta-actions {
					flex-direction: row;
					width: 100%;
					justify-content: center;
				}

				.cta-content {
					max-width: 100%;
				}
			}

			@media (max-width: 575px) {
				.cta-actions {
					flex-direction: column;
					width: 100%;
				}

				.btn-cta {
					width: 100%;
				}
			}

			/* //how it works */
			/* ---------- HOW IT WORKS / WHY CHOOSE US ---------- */
			.section-how-why {
				background: #eef5f8;
				padding: 90px 0;
			}

			.how-why-grid {
				display: flex;
				gap: 60px;
				max-width: 1300px;
				margin: 0 auto;
			}

			.how-it-works,
			.why-choose {
				flex: 1;
			}

			.section-badge {
				display: inline-block;
				background: #d9f0f5;
				color: #1a7a8a;
				font-size: 11px;
				font-weight: 700;
				letter-spacing: 0.5px;
				padding: 7px 16px;
				border-radius: 30px;
				margin-bottom: 16px;
			}

			.how-it-works h2,
			.why-choose h2 {
				color: #0c2b3d;
				font-size: 30px;
				font-weight: 700;
				margin-bottom: 10px;
			}

			.section-sub {
				color: #6b8088;
				font-size: 14px;
				margin-bottom: 34px;
			}

			/* ---------- STEP LIST ---------- */
			.step-list {
				display: flex;
				flex-direction: column;
				gap: 26px;
			}

			.step-item {
				display: flex;
				align-items: flex-start;
				gap: 16px;
			}

			.step-icon {
				width: 44px;
				height: 44px;
				border-radius: 12px;
				display: flex;
				align-items: center;
				justify-content: center;
				color: #fff;
				font-size: 16px;
				flex-shrink: 0;
			}

			.step-icon.icon-teal { background: #16697a; }
			.step-icon.icon-orange { background: #f0a53c; }
			.step-icon.icon-green { background: #4caf6a; }

			.step-text h4 {
				font-size: 16px;
				font-weight: 700;
				color: #0c2b3d;
				margin-bottom: 4px;
			}

			.step-text p {
				font-size: 13.5px;
				color: #6b8088;
				margin: 0;
				max-width: 380px;
			}

			/* ---------- WHY CHOOSE GRID ---------- */
			.why-grid {
				display: grid;
				grid-template-columns: 1fr 1fr;
				gap: 18px;
			}

			.why-card {
				border-radius: 16px;
				padding: 22px;
			}

			.why-card h4 {
				font-size: 15px;
				font-weight: 700;
				color: #0c2b3d;
				margin: 14px 0 6px;
			}

			.why-card p {
				font-size: 13px;
				color: #5a6b72;
				margin: 0;
			}

			.why-icon {
				width: 40px;
				height: 40px;
				border-radius: 10px;
				display: flex;
				align-items: center;
				justify-content: center;
				color: #fff;
				font-size: 15px;
			}

			.card-blue { background: #daf0f4; }
			.card-green { background: #ddefe0; }
			.card-purple { background: #ecdff5; }
			.card-yellow { background: #fdecd0; }

			.icon-blue-solid { background: #1a7a8a; }
			.icon-green-solid { background: #2e8b4f; }
			.icon-purple-solid { background: #6b1fa0; }
			.icon-yellow-solid { background: #e06b1a; }

			/* ---------- RESPONSIVE ---------- */
			@media (max-width: 991px) {
				.how-why-grid {
					flex-direction: column;
				}
				.why-grid {
					grid-template-columns: 1fr 1fr;
				}
			}

			@media (max-width: 575px) {
				.why-grid {
					grid-template-columns: 1fr;
				}
			}

		</style>

		<script src="{{ asset('assets/js/jquery.min.js') }}"></script>


		<script>

			$('#doctorSearch').keyup(function(){

				let keyword=$(this).val();

				if(keyword.length<1){

					$('#doctorDropdown').hide();

					return;

				}

				$.ajax({

					url:"{{ route('search.doctors') }}",

					type:"GET",

					data:{
						keyword:keyword
					},

					success:function(response){

						let html='';

						if(response.length==0){

							html='<div class="doctor-item">No Doctor Found</div>';

						}else{

							response.forEach(function(item){

								let image=item.profile_img
								?"/uploads/profile/"+item.profile_img
								:"{{ asset('assets/img/doctors/doctor-thumb-01.jpg') }}";

								let specialization='';

								let specialization_id='';

								if(item.profile && item.profile.specializationdata){

									specialization=item.profile.specializationdata.name;

									specialization_id=item.profile.specializationdata.id;

								}

								html+=`

								<div class="doctor-item"

									onclick="window.location='/doctor/${item.id}'">

									<img src="${image}">

									<div>

										<div class="doctor-name">${item.name}</div>

										<div class="doctor-specialization">${specialization}</div>

									</div>

								</div>

								`;

							});

						}

						$('#doctorDropdown').html(html).show();

					}

				});

			});

			$(document).click(function(e){

				if(!$(e.target).closest('.search-info').length){

					$('#doctorDropdown').hide();

				}

			});

			$('.specialization-filter').click(function () {

				$('.specialization-filter').removeClass('active');
				$(this).addClass('active');

				let id = $(this).data('id');

				$('.doctor-slider').slick('slickUnfilter');

				if(id != 'all'){

					$('.doctor-slider').slick('slickFilter', function () {

						return $(this).find('.doctor-card').data('specialization') == id;

					});

				}

			});

		</script>
@endsection