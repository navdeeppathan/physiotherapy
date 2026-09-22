<!-- Footer -->
			<footer class="footer">
				
				<!-- Footer Top -->
				<div class="footer-top">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-4 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-about">
									<div class="footer-logo">
										{{-- <img src="assets/img/footer-logo.png" alt="logo"> --}}
										<img src="{{ asset('assets/img/logo.png') }}" class="img-fluid w-50" alt="Logo">

									</div>
									<div class="footer-about-content">
										{{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p> --}}
										<p>
											Your health is our priority. Connect with experienced doctors, schedule appointments effortlessly, and enjoy a seamless healthcare experience anytime, anywhere.
										</p>
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
							
							<div class="col-lg-4 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">For Patients</h2>
									<ul>
										{{-- <li><a href="search.html"><i class="fas fa-angle-double-right"></i> Search for Doctors</a></li> --}}
										<li><a href="{{ route('login') }}"><i class="fas fa-angle-double-right"></i> Login</a></li>
										<li><a href="{{route('patient.register')}}"><i class="fas fa-angle-double-right"></i> Register</a></li>
										{{-- <li><a href="booking.html"><i class="fas fa-angle-double-right"></i> Booking</a></li> --}}
										{{-- <li><a href="patient-dashboard.html"><i class="fas fa-angle-double-right"></i> Patient Dashboard</a></li> --}}
										<li>
											@auth
												<a href="{{ route('patient.dashboard') }}">
													<i class="fas fa-angle-double-right"></i>
													Patient Dashboard
												</a>
											@else
												<a href="{{ route('login') }}">
													<i class="fas fa-angle-double-right"></i>
													Patient Dashboard
												</a>
											@endauth
										</li>
									</ul>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							{{-- <div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">For Doctors</h2>
									<ul>
										<li>
											@auth
												<a href="{{ route('patient.dashboard') }}">
													<i class="fas fa-angle-double-right"></i>
													Appointments
												</a>
											@else
												<a href="{{ route('login') }}">
													<i class="fas fa-angle-double-right"></i>
													Appointments
												</a>
											@endauth
										</li>
										
										<li><a href="appointments.html"><i class="fas fa-angle-double-right"></i> Appointments</a></li>
										<li><a href="chat.html"><i class="fas fa-angle-double-right"></i> Chat</a></li>
										<li><a href="{{route('login')}}"><i class="fas fa-angle-double-right"></i> Login</a></li>
										<li><a href="{{route('patient.register')}}"><i class="fas fa-angle-double-right"></i> Register</a></li>
										<li><a href="doctor-dashboard.html"><i class="fas fa-angle-double-right"></i> Doctor Dashboard</a></li>
									</ul>
								</div>
								<!-- /Footer Widget -->
								
							</div> --}}
							
							<div class="col-lg-4 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-contact">
									<h2 class="footer-title">Contact Us</h2>
									<div class="footer-contact-info">
										<div class="footer-address">
											<span><i class="fas fa-map-marker-alt"></i></span>
											<p> PhysioPii Healthcare<br> India </p>
										</div>
										<p>
											<i class="fas fa-phone-alt"></i>
											<a href="tel:+918855088426" style="color: inherit; text-decoration: none;">+91 8855088426</a>
										</p>
										<p class="mb-0">
											<i class="fas fa-envelope"></i>
											<a href="mailto:contact@physiopii.in" style="color: inherit; text-decoration: none;">contact@physiopii.in</a>
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
							<div class="row align-items-center">
								<div class="col-md-6 col-lg-6">
									<div class="copyright-text">
										<p class="mb-0">&copy; {{ date('Y') }} PhysioPii. All rights reserved.</p>
									</div>
								</div>
								<div class="col-md-6 col-lg-6 text-md-right text-center mt-2 mt-md-0">
								
									<!-- Copyright Menu -->
									<div class="copyright-menu">
										<ul class="policy-menu">
											<li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
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