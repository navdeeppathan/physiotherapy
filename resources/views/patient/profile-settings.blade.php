@extends('layouts.app')

@section('content')

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			@include('layouts.header')
			
<style>
.breadcrumb-bar {
    background: linear-gradient(135deg, #074752 0%, #0c6978 100%) !important;
    padding: 24px 0 !important;
    box-shadow: 0 4px 16px rgba(7, 71, 82, 0.15);
}
.breadcrumb-bar .breadcrumb a { color: rgba(255,255,255,.8) !important; }
.breadcrumb-bar .breadcrumb-item.active { color: #fff !important; font-weight: 600; }
.breadcrumb-title { color: #fff !important; font-weight: 800 !important; }
.profile-sidebar {
    background: #fff;
    border-radius: 18px;
    border: 1.5px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(12,105,120,.05);
}
.widget-profile {
    border-bottom: 1.5px solid #f1f5f9;
}
.dashboard-menu ul li.active a {
    color: #0c6978 !important;
    background: #eef8f9 !important;
    font-weight: 700;
}
.dashboard-menu ul li a:hover {
    color: #0c6978 !important;
}
.btn-primary.submit-btn {
    background: linear-gradient(135deg, #0c6978 0%, #108598 100%) !important;
    border: none !important;
    border-radius: 12px !important;
    padding: 12px 30px !important;
    font-weight: 700 !important;
    box-shadow: 0 4px 14px rgba(12,105,120,.25) !important;
    transition: all .2s !important;
}
.btn-primary.submit-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(12,105,120,.35) !important;
}
.change-photo-btn {
    background: #0c6978 !important;
    border-radius: 10px !important;
}
.card {
    border-radius: 18px !important;
    border: 1.5px solid #e2e8f0 !important;
    box-shadow: 0 4px 20px rgba(12,105,120,.04) !important;
}
.form-control:focus {
    border-color: #0c6978 !important;
    box-shadow: 0 0 0 3px rgba(12,105,120,.12) !important;
}
</style>
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Profile Settings</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					<div class="row">
					
						<!-- Profile Sidebar -->
						<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
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
											<li class="active">
												<a href="{{ route('patient.profile') }}">
													<i class="fas fa-user-cog"></i>
													<span>Profile Settings</span>
												</a>
											</li>
											<li>
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
						</div>
						<!-- /Profile Sidebar -->
						
						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body">
									
									<!-- Profile Settings Form -->
									<form action="{{ route('patient.profile.update') }}"
										method="POST"
										enctype="multipart/form-data">

										@csrf
										<div class="row form-row">
											<div class="col-12 col-md-12">
												<div class="form-group">
													<div class="change-avatar">
														<div class="profile-img">

															<img src="{{ $patient->profile_img ? asset($patient->profile_img) : asset('assets/img/patients/patient.jpg') }}">

														</div>
														<div class="upload-img">
															<div class="change-photo-btn">
																<span>
																	<i class="fa fa-upload"></i> Upload Photo
																</span>

																<input type="file"
																	name="profile_img"
																	class="upload">
															</div>
															<small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
														</div>
													</div>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Name</label>
													<input type="text" name="name" class="form-control" value="{{ old('name',$patient->name) }}">
												</div>
											</div>
											{{-- <div class="col-12 col-md-6">
												<div class="form-group">
													<label>Email</label>
													<input type="email" disabled readonly class="form-control" value="Wilson">
												</div>
											</div> --}}
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label for="dob">Date of Birth</label>
													<div class="cal-icon">
														<input type="date" id="dob"  name="dob" class="form-control" value="{{ old('dob',$patient->dob) }}">
													</div>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Gender</label>
													<select name="gender" class="form-control">

														<option value="">Select</option>

														<option value="male"
															{{ $patient->gender=='male'?'selected':'' }}>
															Male
														</option>

														<option value="female"
															{{ $patient->gender=='female'?'selected':'' }}>
															Female
														</option>

														<option value="other"
															{{ $patient->gender=='other'?'selected':'' }}>
															Other
														</option>

													</select>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Email ID</label>
													<input type="email"  disabled readonly class="form-control" value="{{ old('email',$patient->email) }}">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Mobile</label>
													<input type="text"  name="phone" value="{{ old('phone',$patient->phone) }}" class="form-control">
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
												<label>Address</label>
													<input type="text" name="address" class="form-control" value="{{ old('address',$patient->address) }}">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>City</label>
													<input type="text" name="city" class="form-control" value="{{ old('city',$patient->city) }}">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>State</label>
													<input type="text" name="state" class="form-control" value="{{ old('state',$patient->state) }}">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Zip Code</label>
													<input type="text" name="pincode" class="form-control" value="{{ old('pincode',$patient->pincode) }}">
												</div>
											</div>
											{{-- <div class="col-12 col-md-6">
												<div class="form-group">
													<label>Country</label>
													<input type="text" class="form-control" value="United States">
												</div>
											</div> --}}
										</div>
										<div class="submit-section">
											<button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
										</div>
									</form>
									<!-- /Profile Settings Form -->
									
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

@endsection		