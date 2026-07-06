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
							<h1>Expert Physiotherapy at Your Home</h1>
							<p>Book trusted physiotherapists for personalized home care.</p>
						</div>
                         
						<!-- Search -->
						{{-- <div class="search-box">
							<form action="templateshub.net">
								<div class="form-group search-location">
									<input type="text" class="form-control" placeholder="Search Location">
									<span class="form-text">Based on your Location</span>
								</div>
								<div class="form-group search-info">
									<input type="text" class="form-control" placeholder="Search by Physiotherapy Category or Name">
									<span class="form-text">Ex: Orthopedic, Neurological, Sports, Pediatric</span>
								</div>
								<button type="submit" class="btn btn-primary search-btn"><i class="fas fa-search"></i> <span>Search</span></button>
							</form>
						</div> --}}
						<!-- /Search -->
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
			</section>
			<!-- /Home Banner -->
			  
			<!-- Clinic and Specialities -->
			<section class="section section-specialities">
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
						
								<!-- /Slider Item -->

								{{-- <div class="speicality-item text-center specialization-filter active"
									data-id="all">

									<div class="speicality-img">
										<img src="{{ asset('assets/img/fulllogo.png') }}" class="img-fluid">
									</div>

									<p>All</p>

								</div> --}}

								@foreach($specializations as $specialization)
									<div class="speicality-item text-center specialization-filter" data-id="{{ $specialization->id }}">
										<div class="speicality-img">
											<img
												src="{{ asset('images/specializations/' . $specialization->icon) }}"
												class="img-fluid"
												alt="{{ $specialization->name }}"
											>
											{{-- <span>
												<i class="fa fa-circle" aria-hidden="true"></i>
											</span> --}}
										</div>

										<p>{{ $specialization->name }}</p>
									</div>
								@endforeach
								
							</div>
							<!-- /Slider -->
							
						</div>
					</div>
				</div>   
			</section>	 
			<!-- Clinic and Specialities -->
		  
			<!-- Popular Section -->
			<section class="section section-doctor">
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

												{{-- @if(optional($doctor->profile)->approval_status == 'approved') --}}
													<i class="fas fa-check-circle verified"></i>
												{{-- @endif --}}
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
													{{-- {{ optional($doctor->profile)->clinic_address ?? '' }} --}}
												</li>

												<li>
													<i class="far fa-clock"></i>

													{{ optional($doctor->profile)->experience_years ?? 0 }}
													Years Experience
												</li>

												{{-- <li>
													<i class="far fa-money-bill-alt"></i>

													₹{{ number_format(optional($doctor->fee)->total_fee ?? 0,2) }}
												</li> --}}

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
													<a 
													
													href="{{ route('doctor.booking', $doctor->id) }}"
													class="btn book-btn">
														Book Now
													</a>
												</div>

											</div>

										</div>
									</div>
								@endforeach
							
								<!-- Doctor Widget -->
								{{-- <div class="profile-widget">
									<div class="doc-img">
										<a href="doctor-profile.html">
											<img class="img-fluid" alt="User Image" src="assets/img/doctors/doctor-01.jpg">
										</a>
										<a href="javascript:void(0)" class="fav-btn">
											<i class="far fa-bookmark"></i>
										</a>
									</div>
									<div class="pro-content">
										<h3 class="title">
											<a href="doctor-profile.html">Ruby Perrin</a> 
											<i class="fas fa-check-circle verified"></i>
										</h3>
										<p class="speciality">MDS - Periodontology and Oral Implantology, BDS</p>
										<div class="rating">
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<span class="d-inline-block average-rating">(17)</span>
										</div>
										<ul class="available-info">
											<li>
												<i class="fas fa-map-marker-alt"></i> Florida, USA
											</li>
											<li>
												<i class="far fa-clock"></i> Available on Fri, 22 Mar
											</li>
											<li>
												<i class="far fa-money-bill-alt"></i> $300 - $1000 
												<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
											</li>
										</ul>
										<div class="row row-sm">
											<div class="col-6">
												<a href="doctor-profile.html" class="btn view-btn">View Profile</a>
											</div>
											<div class="col-6">
												<a href="booking.html" class="btn book-btn">Book Now</a>
											</div>
										</div>
									</div>
								</div> --}}
								<!-- /Doctor Widget -->
						
								<!-- Doctor Widget -->
								{{-- <div class="profile-widget">
									<div class="doc-img">
										<a href="doctor-profile.html">
											<img class="img-fluid" alt="User Image" src="assets/img/doctors/doctor-02.jpg">
										</a>
										<a href="javascript:void(0)" class="fav-btn">
											<i class="far fa-bookmark"></i>
										</a>
									</div>
									<div class="pro-content">
										<h3 class="title">
											<a href="doctor-profile.html">Darren Elder</a> 
											<i class="fas fa-check-circle verified"></i>
										</h3>
										<p class="speciality">BDS, MDS - Oral & Maxillofacial Surgery</p>
										<div class="rating">
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star"></i>
											<span class="d-inline-block average-rating">(35)</span>
										</div>
										<ul class="available-info">
											<li>
												<i class="fas fa-map-marker-alt"></i> Newyork, USA
											</li>
											<li>
												<i class="far fa-clock"></i> Available on Fri, 22 Mar
											</li>
											<li>
												<i class="far fa-money-bill-alt"></i> $50 - $300 
												<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
											</li>
										</ul>
										<div class="row row-sm">
											<div class="col-6">
												<a href="doctor-profile.html" class="btn view-btn">View Profile</a>
											</div>
											<div class="col-6">
												<a href="booking.html" class="btn book-btn">Book Now</a>
											</div>
										</div>
									</div>
								</div> --}}
								<!-- /Doctor Widget -->
						
								<!-- Doctor Widget -->
								{{-- <div class="profile-widget">
									<div class="doc-img">
										<a href="doctor-profile.html">
											<img class="img-fluid" alt="User Image" src="assets/img/doctors/doctor-03.jpg">
										</a>
										<a href="javascript:void(0)" class="fav-btn">
											<i class="far fa-bookmark"></i>
										</a>
									</div>
									<div class="pro-content">
										<h3 class="title">
											<a href="doctor-profile.html">Deborah Angel</a> 
											<i class="fas fa-check-circle verified"></i>
										</h3>
										<p class="speciality">MBBS, MD - General Medicine, DNB - Cardiology</p>
										<div class="rating">
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star"></i>
											<span class="d-inline-block average-rating">(27)</span>
										</div>
										<ul class="available-info">
											<li>
												<i class="fas fa-map-marker-alt"></i> Georgia, USA
											</li>
											<li>
												<i class="far fa-clock"></i> Available on Fri, 22 Mar
											</li>
											<li>
												<i class="far fa-money-bill-alt"></i> $100 - $400 
												<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
											</li>
										</ul>
										<div class="row row-sm">
											<div class="col-6">
												<a href="doctor-profile.html" class="btn view-btn">View Profile</a>
											</div>
											<div class="col-6">
												<a href="booking.html" class="btn book-btn">Book Now</a>
											</div>
										</div>
									</div>
								</div> --}}
								<!-- /Doctor Widget -->
						
								<!-- Doctor Widget -->
								{{-- <div class="profile-widget">
									<div class="doc-img">
										<a href="doctor-profile.html">
											<img class="img-fluid" alt="User Image" src="assets/img/doctors/doctor-04.jpg">
										</a>
										<a href="javascript:void(0)" class="fav-btn">
											<i class="far fa-bookmark"></i>
										</a>
									</div>
									<div class="pro-content">
										<h3 class="title">
											<a href="doctor-profile.html">Sofia Brient</a> 
											<i class="fas fa-check-circle verified"></i>
										</h3>
										<p class="speciality">MBBS, MS - General Surgery, MCh - Urology</p>
										<div class="rating">
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star"></i>
											<span class="d-inline-block average-rating">(4)</span>
										</div>
										<ul class="available-info">
											<li>
												<i class="fas fa-map-marker-alt"></i> Louisiana, USA
											</li>
											<li>
												<i class="far fa-clock"></i> Available on Fri, 22 Mar
											</li>
											<li>
												<i class="far fa-money-bill-alt"></i> $150 - $250 
												<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
											</li>
										</ul>
										<div class="row row-sm">
											<div class="col-6">
												<a href="doctor-profile.html" class="btn view-btn">View Profile</a>
											</div>
											<div class="col-6">
												<a href="booking.html" class="btn book-btn">Book Now</a>
											</div>
										</div>
									</div>
								</div> --}}
								<!-- /Doctor Widget -->
								
								<!-- Doctor Widget -->
								{{-- <div class="profile-widget">
									<div class="doc-img">
										<a href="doctor-profile.html">
											<img class="img-fluid" alt="User Image" src="assets/img/doctors/doctor-05.jpg">
										</a>
										<a href="javascript:void(0)" class="fav-btn">
											<i class="far fa-bookmark"></i>
										</a>
									</div>
									<div class="pro-content">
										<h3 class="title">
											<a href="doctor-profile.html">Marvin Campbell</a> 
											<i class="fas fa-check-circle verified"></i>
										</h3>
										<p class="speciality">MBBS, MD - Ophthalmology, DNB - Ophthalmology</p>
										<div class="rating">
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star"></i>
											<span class="d-inline-block average-rating">(66)</span>
										</div>
										<ul class="available-info">
											<li>
												<i class="fas fa-map-marker-alt"></i> Michigan, USA
											</li>
											<li>
												<i class="far fa-clock"></i> Available on Fri, 22 Mar
											</li>
											<li>
												<i class="far fa-money-bill-alt"></i> $50 - $700 
												<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
											</li>
										</ul>
										<div class="row row-sm">
											<div class="col-6">
												<a href="doctor-profile.html" class="btn view-btn">View Profile</a>
											</div>
											<div class="col-6">
												<a href="booking.html" class="btn book-btn">Book Now</a>
											</div>
										</div>
									</div>
								</div> --}}
								<!-- /Doctor Widget -->
								
								<!-- Doctor Widget -->
								{{-- <div class="profile-widget">
									<div class="doc-img">
										<a href="doctor-profile.html">
											<img class="img-fluid" alt="User Image" src="assets/img/doctors/doctor-06.jpg">
										</a>
										<a href="javascript:void(0)" class="fav-btn">
											<i class="far fa-bookmark"></i>
										</a>
									</div>
									<div class="pro-content">
										<h3 class="title">
											<a href="doctor-profile.html">Katharine Berthold</a> 
											<i class="fas fa-check-circle verified"></i>
										</h3>
										<p class="speciality">MS - Orthopaedics, MBBS, M.Ch - Orthopaedics</p>
										<div class="rating">
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star"></i>
											<span class="d-inline-block average-rating">(52)</span>
										</div>
										<ul class="available-info">
											<li>
												<i class="fas fa-map-marker-alt"></i> Texas, USA
											</li>
											<li>
												<i class="far fa-clock"></i> Available on Fri, 22 Mar
											</li>
											<li>
												<i class="far fa-money-bill-alt"></i> $100 - $500 
												<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
											</li>
										</ul>
										<div class="row row-sm">
											<div class="col-6">
												<a href="doctor-profile.html" class="btn view-btn">View Profile</a>
											</div>
											<div class="col-6">
												<a href="booking.html" class="btn book-btn">Book Now</a>
											</div>
										</div>
									</div>
								</div> --}}
								<!-- /Doctor Widget -->
								
								<!-- Doctor Widget -->
								{{-- <div class="profile-widget">
									<div class="doc-img">
										<a href="doctor-profile.html">
											<img class="img-fluid" alt="User Image" src="assets/img/doctors/doctor-07.jpg">
										</a>
										<a href="javascript:void(0)" class="fav-btn">
											<i class="far fa-bookmark"></i>
										</a>
									</div>
									<div class="pro-content">
										<h3 class="title">
											<a href="doctor-profile.html">Linda Tobin</a> 
											<i class="fas fa-check-circle verified"></i>
										</h3>
										<p class="speciality">MBBS, MD - General Medicine, DM - Neurology</p>
										<div class="rating">
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star"></i>
											<span class="d-inline-block average-rating">(43)</span>
										</div>
										<ul class="available-info">
											<li>
												<i class="fas fa-map-marker-alt"></i> Kansas, USA
											</li>
											<li>
												<i class="far fa-clock"></i> Available on Fri, 22 Mar
											</li>
											<li>
												<i class="far fa-money-bill-alt"></i> $100 - $1000 
												<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
											</li>
										</ul>
										<div class="row row-sm">
											<div class="col-6">
												<a href="doctor-profile.html" class="btn view-btn">View Profile</a>
											</div>
											<div class="col-6">
												<a href="booking.html" class="btn book-btn">Book Now</a>
											</div>
										</div>
									</div>
								</div> --}}
								<!-- /Doctor Widget -->
								
								<!-- Doctor Widget -->
								{{-- <div class="profile-widget">
									<div class="doc-img">
										<a href="doctor-profile.html">
											<img class="img-fluid" alt="User Image" src="assets/img/doctors/doctor-08.jpg">
										</a>
										<a href="javascript:void(0)" class="fav-btn">
											<i class="far fa-bookmark"></i>
										</a>
									</div>
									<div class="pro-content">
										<h3 class="title">
											<a href="doctor-profile.html">Paul Richard</a> 
											<i class="fas fa-check-circle verified"></i>
										</h3>
										<p class="speciality">MBBS, MD - Dermatology , Venereology & Lepros</p>
										<div class="rating">
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star"></i>
											<span class="d-inline-block average-rating">(49)</span>
										</div>
										<ul class="available-info">
											<li>
												<i class="fas fa-map-marker-alt"></i> California, USA
											</li>
											<li>
												<i class="far fa-clock"></i> Available on Fri, 22 Mar
											</li>
											<li>
												<i class="far fa-money-bill-alt"></i> $100 - $400 
												<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
											</li>
										</ul>
										<div class="row row-sm">
											<div class="col-6">
												<a href="doctor-profile.html" class="btn view-btn">View Profile</a>
											</div>
											<div class="col-6">
												<a href="booking.html" class="btn book-btn">Book Now</a>
											</div>
										</div>
									</div>
								</div> --}}
								<!-- Doctor Widget -->
								
							</div>
						</div>
				   </div>
				</div>
			</section>
			<!-- /Popular Section -->
		   
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


   

			@include('layouts.footer')

		</div>

		<style>
			.specialization-filter{
				cursor:pointer;
			}

			

			.specialization-filter.active p{

				color:#09e5ab;

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