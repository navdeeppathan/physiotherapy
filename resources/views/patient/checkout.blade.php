@extends('layouts.app')

@section('content')

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			@include('layouts.header')
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Checkout</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Checkout</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						<div class="col-md-7 col-lg-8">
							<div class="card">
								<div class="card-body">
								
									<form action="{{ route('doctor.book') }}" method="POST">

										@csrf

										{{-- Selected Plan --}}
										<div class="card mb-4 border-primary">
											<div class="card-header bg-primary text-white">
												<h5 class="mb-0">Selected Plan</h5>
											</div>

											<div class="card-body">
												<div class="row">

													<div class="col-md-6 mb-3">
														<strong>Plan Name</strong>
														<p class="mb-0">{{ $plan->name }}</p>
													</div>

													<div class="col-md-6 mb-3">
														<strong>Price</strong>
														<p class="mb-0">₹{{ number_format($plan->price, 2) }}</p>
													</div>

													<div class="col-md-6 mb-3">
														<strong>Total Appointments</strong>
														<p class="mb-0">{{ $plan->total_appointments }}</p>
													</div>

													@if($plan->duration)
														<div class="col-md-6 mb-3">
															<strong>Validity</strong>
															<p class="mb-0">{{ $plan->duration }}</p>
														</div>
													@endif

													@if($plan->description)
														<div class="col-12">
															<strong>Description</strong>
															<p class="mb-0 text-muted">
																{{ $plan->description }}
															</p>
														</div>
													@endif

												</div>
											</div>
										</div>

										<input type="hidden" name="plan_id" value="{{ $plan->id }}">

										<input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
										{{-- <input type="hidden" name="subscription_id" value="{{ $subscriptionId }}"> --}}
										@foreach($slots as $slot)

										<input type="hidden"
											name="slot_ids[]"
											value="{{ $slot->id }}">

										@endforeach
										<input type="hidden" name="doctor_fee" value="{{ $doctor->fee->doctor_fee ?? 0 }}">

										<input type="hidden" name="booking_for" value="self">

										<div class="info-widget">
											<h4 class="card-title">Problem Description</h4>

											<div class="row">

												{{-- <div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Full Name</label>
														<input class="form-control" type="text" value="{{ old('patient_name') }}" name="patient_name" required>
													</div>
												</div> --}}

												{{-- <div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Age</label>
														<input class="form-control" type="number" value="{{ old('patient_age') }}" name="patient_age" required>
													</div>
												</div> --}}

												{{-- <div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Gender</label>

														<select name="patient_gender"  class="form-control">

															<option value="">Select</option>
															<option value="male">Male</option>
															<option value="female">Female</option>
															<option value="other">Other</option>

														</select>

													</div>
												</div> --}}

												<div class="col-md-12">
													<div class="form-group card-label">
														{{-- <label>Problem Description</label> --}}

														<textarea
															name="problem_description"
															class="form-control"
															rows="4"></textarea>
													</div>
												</div>

											</div>
										</div>

										<div class="submit-section mt-4">
											<button class="btn btn-primary submit-btn" @guest disabled @endguest>
												Confirm and Pay
											</button>
										</div>

										@guest
											<div class="alert alert-info border-left-primary mb-4 mt-4">
												<h5 class="mb-2">
													<i class="fas fa-lock"></i>
													Login Required
												</h5>

												<p class="mb-3">
													Please sign in to book your appointment, complete payment, and manage your bookings.
												</p>

												<a 
												{{-- href="{{ route('login') }}"  --}}
												class="btn btn-primary">
													Login to Continue
												</a>
											</div>
										@endguest

									</form>
									
								</div>
							</div>
							
						</div>
						
						<div class="col-md-5 col-lg-4 theiaStickySidebar">
						
							<!-- Booking Summary -->
							<div class="card booking-card">
								<div class="card-header">
									<h4 class="card-title">Booking Summary</h4>
								</div>
								<div class="card-body">
								
									<!-- Booking Doctor Info -->
									<div class="booking-doc-info">
										<a href="doctor-profile.html" class="booking-doc-img">
											<img src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
										</a>
										<div class="booking-info">
											<h4><a href="doctor-profile.html">{{ $doctor->name }}</a></h4>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">35</span>
											</div>
											<div class="clinic-details">
												<p class="doc-location"><i class="fas fa-map-marker-alt"></i> {{ $doctor->profile->clinic_address ?? '' }}</p>
											</div>
										</div>
									</div>
									<!-- Booking Doctor Info -->
									
									{{-- <div class="booking-summary">
										<div class="booking-item-wrap">
											<ul class="booking-date">
												<li>Date <span>{{ $slot->availabilityDate->available_date->format('d M Y') }}</span></li>
												<li>Time 
													<span>
														{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}
														-
														{{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
													</span>
												</li>
											</ul>
											<ul class="booking-fee">
												
												<li>
													Doctor Fee

													<span>
														₹{{ number_format($doctor->fee->doctor_fee ?? 0,2) }}
													</span>
												</li>
											</ul>
											<div class="booking-total">
												<ul class="booking-total-list">
													<li>
														<span>Total</span>
														<span class="total-cost">₹{{ number_format($doctor->fee->doctor_fee ?? 0,2) }}</span>
													</li>
												</ul>
											</div>
										</div>
									</div> --}}
									<div class="booking-summary">
										<div class="booking-item-wrap">
											{{-- Appointment List --}}
											<div style="max-height:320px; overflow-y:auto; padding-right:5px;">
												@foreach($slots as $index => $slot)

													<div class="border rounded p-3 mb-3">

														<h6 class="mb-3">
															Appointment {{ $index + 1 }}
														</h6>

														<ul class="booking-date mb-0">

															<li>
																Date
																<span>
																	{{ $slot->availabilityDate->available_date->format('d M Y') }}
																</span>
															</li>

															<li>
																Time
																<span>
																	{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}
																	-
																	{{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
																</span>
															</li>

															{{-- <li>
																Consultation Fee
																<span>
																	₹{{ number_format($doctor->fee->doctor_fee ?? 0,2) }}
																</span>
															</li> --}}

														</ul>

													</div>

												@endforeach
											</div>	

											<div class="booking-total">
												<ul class="booking-total-list">

													<li>
														<span>Total Appointments</span>
														<span class="total-cost">{{ $slots->count() }}</span>
													</li>

													<li>
														<span>Total Amount</span>
														<span class="total-cost">
															₹{{ number_format($plan->price, 2) }}
														</span>
													</li>
													

													{{-- <li>
														<span>Total Amount</span>
														<span class="total-cost">
															₹{{ number_format(($doctor->fee->doctor_fee ?? 0) * $slots->count(),2) }}
														</span>
													</li> --}}

												</ul>
											</div>

										</div>
									</div>
								</div>
							</div>
							<!-- /Booking Summary -->
							
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
   
			<!-- Footer -->
			<footer class="footer">
				
				<!-- Footer Top -->
				<div class="footer-top">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-about">
									<div class="footer-logo">
										<img src="assets/img/footer-logo.png" alt="logo">
									</div>
									<div class="footer-about-content">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
										<div class="social-icon">
											<ul>
												<li>
													<a href="#" target="_blank"><i class="fab fa-facebook-f"></i> </a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-twitter"></i> </a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-dribbble"></i> </a>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">For Patients</h2>
									<ul>
										<li><a href="search.html"><i class="fas fa-angle-double-right"></i> Search for Doctors</a></li>
										<li><a href="login.html"><i class="fas fa-angle-double-right"></i> Login</a></li>
										<li><a href="register.html"><i class="fas fa-angle-double-right"></i> Register</a></li>
										<li><a href="booking.html"><i class="fas fa-angle-double-right"></i> Booking</a></li>
										<li><a href="patient-dashboard.html"><i class="fas fa-angle-double-right"></i> Patient Dashboard</a></li>
									</ul>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">For Doctors</h2>
									<ul>
										<li><a href="appointments.html"><i class="fas fa-angle-double-right"></i> Appointments</a></li>
										<li><a href="chat.html"><i class="fas fa-angle-double-right"></i> Chat</a></li>
										<li><a href="login.html"><i class="fas fa-angle-double-right"></i> Login</a></li>
										<li><a href="doctor-register.html"><i class="fas fa-angle-double-right"></i> Register</a></li>
										<li><a href="doctor-dashboard.html"><i class="fas fa-angle-double-right"></i> Doctor Dashboard</a></li>
									</ul>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-contact">
									<h2 class="footer-title">Contact Us</h2>
									<div class="footer-contact-info">
										<div class="footer-address">
											<span><i class="fas fa-map-marker-alt"></i></span>
											<p> 3556  Beech Street, San Francisco,<br> California, CA 94108 </p>
										</div>
										<p>
											<i class="fas fa-phone-alt"></i>
											+1 315 369 5943
										</p>
										<p class="mb-0">
											<i class="fas fa-envelope"></i>
											doccure@example.com
										</p>
									</div>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
						</div>
					</div>
				</div>
				<!-- /Footer Top -->
				
				<!-- Footer Bottom -->
                <div class="footer-bottom">
					<div class="container-fluid">
					
						<!-- Copyright -->
						<div class="copyright">
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="copyright-text">
										<p class="mb-0"><a href="templateshub.net">Templates Hub</a></p>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
								
									<!-- Copyright Menu -->
									<div class="copyright-menu">
										<ul class="policy-menu">
											<li><a href="term-condition.html">Terms and Conditions</a></li>
											<li><a href="privacy-policy.html">Policy</a></li>
										</ul>
									</div>
									<!-- /Copyright Menu -->
									
								</div>
							</div>
						</div>
						<!-- /Copyright -->
						
					</div>
				</div>
				<!-- /Footer Bottom -->
				
			</footer>
			<!-- /Footer -->
		   
		</div>
		<!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>

<!-- doccure/checkout.html  30 Nov 2019 04:12:16 GMT -->
</html>