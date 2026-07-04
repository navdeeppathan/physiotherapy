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
									<li class="breadcrumb-item active" aria-current="page">Change Password</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Change Password</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
						
							<!-- Profile Sidebar -->
							<div class="profile-sidebar">
								<div class="widget-profile pro-widget-content">
									<div class="profile-info-widget">
										<a href="#" class="booking-doc-img">
											{{-- <img src="assets/img/patients/patient.jpg" alt="User Image"> --}}
											<img src="{{ $patient->profile_img ? asset($patient->profile_img) : asset('assets/img/patients/patient.jpg') }}"
                         						alt="{{ $patient->name }}">
										</a>
										<div class="profile-det-info">
											<h3>{{ $patient->name }}</h3>
											<div class="patient-details">
												{{-- <h5><i class="fas fa-birthday-cake"></i> 24 Jul 1983, 38 years</h5> --}}
												@if($patient->dob)
													<h5>
														<i class="fas fa-birthday-cake"></i>

														{{ \Carbon\Carbon::parse($patient->dob)->format('d M Y') }}

														@php
															$age = \Carbon\Carbon::parse($patient->dob)->age;
														@endphp

														, {{ $age }} Years
													</h5>
												@endif
												{{-- <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Newyork, USA</h5> --}}
												<h5 class="mb-0">
													<i class="fas fa-map-marker-alt"></i>

													{{ collect([$patient->city, $patient->state])
														->filter()
														->implode(', ') ?: 'Location not added' }}
												</h5>
											</div>
										</div>
									</div>
								</div>
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li>
												<a href="{{ route('patient.dashboard') }}">
													<i class="fas fa-columns"></i>
													<span>Dashboard</span>
												</a>
											</li>
											{{-- <li>
												<a href="favourites.html">
													<i class="fas fa-bookmark"></i>
													<span>Favourites</span>
												</a>
											</li>
											<li>
												<a href="chat.html">
													<i class="fas fa-comments"></i>
													<span>Message</span>
													<small class="unread-msg">23</small>
												</a>
											</li> --}}
											<li>
												<a href="{{ route('patient.profile') }}">
													<i class="fas fa-user-cog"></i>
													<span>Profile Settings</span>
												</a>
											</li>
											<li class="active">
												<a href="{{ route('patient.change.password') }}">
													<i class="fas fa-lock"></i>
													<span>Change Password</span>
												</a>
											</li>
											<li>
												<a href="{{ route('patient.logout') }}">
													<i class="fas fa-sign-out-alt"></i>
													<span>Logout</span>
												</a>
											</li>
										</ul>
									</nav>
								</div>

							</div>
							<!-- /Profile Sidebar -->
							
						</div>
						
						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-12 col-lg-6">
										
											<!-- Change Password Form -->
											{{-- <form>
												<div class="form-group">
													<label>Old Password</label>
													<input type="password" class="form-control">
												</div>
												<div class="form-group">
													<label>New Password</label>
													<input type="password" class="form-control">
												</div>
												<div class="form-group">
													<label>Confirm Password</label>
													<input type="password" class="form-control">
												</div>
												<div class="submit-section">
													<button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
												</div>
											</form> --}}
											<!-- /Change Password Form -->
											<form action="{{ route('patient.change-password.update') }}" method="POST">

												@csrf

												<div class="form-group">
													<label>Current Password</label>

													<div class="input-group">

														<input
															type="password"
															name="old_password"
															id="old_password"
															class="form-control"
															required>

														<div class="input-group-append">
															<span class="input-group-text toggle-password" data-target="old_password">
																<i class="fas fa-eye"></i>
															</span>
														</div>

													</div>

													@error('old_password')
														<small class="text-danger">{{ $message }}</small>
													@enderror
												</div>

												<div class="form-group">
													<label>New Password</label>

													<div class="input-group">

														<input
															type="password"
															name="password"
															id="password"
															class="form-control"
															required>

														<div class="input-group-append">
															<span class="input-group-text toggle-password" data-target="password">
																<i class="fas fa-eye"></i>
															</span>
														</div>

													</div>

													@error('password')
														<small class="text-danger">{{ $message }}</small>
													@enderror
												</div>

												<div class="form-group">
													<label>Confirm Password</label>

													<div class="input-group">

														<input
															type="password"
															name="password_confirmation"
															id="password_confirmation"
															class="form-control"
															required>

														<div class="input-group-append">
															<span class="input-group-text toggle-password" data-target="password_confirmation">
																<i class="fas fa-eye"></i>
															</span>
														</div>

													</div>

												</div>

												<div class="submit-section">
													<button type="submit" class="btn btn-primary submit-btn">
														Save Changes
													</button>
												</div>

											</form>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>		
			<!-- /Page Content -->
   
			@include('layouts.footer')
			
		   
		</div>
		<!-- /Main Wrapper -->

		<script>
			document.querySelectorAll(".toggle-password").forEach(function(button){

				button.addEventListener("click", function(){

					let input = document.getElementById(this.dataset.target);
					let icon = this.querySelector("i");

					if(input.type === "password"){

						input.type = "text";
						icon.classList.remove("fa-eye");
						icon.classList.add("fa-eye-slash");

					}else{

						input.type = "password";
						icon.classList.remove("fa-eye-slash");
						icon.classList.add("fa-eye");

					}

				});

			});
		</script>
		<style>
			.input-group-text{
				cursor:pointer;
				background:#fff;
			}

			.input-group-text i{
				color:#6c757d;
			}
		</style>

@endsection
		



	  