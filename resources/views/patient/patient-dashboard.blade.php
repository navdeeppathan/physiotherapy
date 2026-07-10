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
									<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Dashboard</h2>
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
											<h3>{{ Auth::user()->name }}</h3>
											<div class="patient-details">
												<h5><i class="fas fa-birthday-cake"></i> 
													@if(Auth::user()->dob)
														{{ \Carbon\Carbon::parse(Auth::user()->dob)->format('d M Y') }},
														{{ \Carbon\Carbon::parse(Auth::user()->dob)->age }} Years
													@else
														Date of birth not available
													@endif
												</h5>
												<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> 
													{{ Auth::user()->city ?? 'N/A' }}
													@if(Auth::user()->state)
														, {{ Auth::user()->state }}
													@endif
												</h5>
											</div>
										</div>
									</div>
								</div>
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li class="active">
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
											</li> --}}
											{{-- <li>
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
						<!-- / Profile Sidebar -->
						
						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body pt-0">
								
									<!-- Tab Menu -->
									<nav class="user-tabs mb-4">
										<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
											<li class="nav-item">
												<a class="nav-link active" href="#pat_appointments" data-toggle="tab">All Appointments</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#pat_upcoming_appointments" data-toggle="tab">Upcoming</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#pat_completed" data-toggle="tab">Completed</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#pat_shifted" data-toggle="tab"><span class="med-records">Shifted</span></a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#pat_cancel" data-toggle="tab"><span class="med-records">Cancelled</span></a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#pat_billing" data-toggle="tab">Billing</a>
											</li>
										</ul>
									</nav>
									<!-- /Tab Menu -->
									
									<!-- Tab Content -->
									<div class="tab-content pt-0">

										<!-- Upcoming Tab -->
										<div id="pat_appointments" class="tab-pane fade show active">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>Doctor</th>
																	<th>Appt Date</th>
																	<th>Booking Date</th>
																	<th>Amount</th>
																	<th>Follow Up</th>
																	<th>Status</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>

																@forelse($appointments as $appointment)

																<tr>

																	<td>
																		<h2 class="table-avatar">

																			<a href="#" class="avatar avatar-sm mr-2">

																				<img class="avatar-img rounded-circle"
																					src="{{ $appointment->doctor->profile_img ? asset($appointment->doctor->profile_img) : asset('assets/img/doctors/doctor-thumb-01.jpg') }}"
																					alt="Doctor">

																			</a>

																			<a href="#">

																				Dr. {{ $appointment->doctor->name }}

																				<span>
																					{{ $appointment->doctor->profile->specializationdata->name ?? 'Doctor' }}
																				</span>

																			</a>

																		</h2>
																	</td>

																	<td>
																		{{ $appointment->appointment_date->format('d M Y') }}

																		<span class="d-block text-info">

																			{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}

																		</span>
																	</td>

																	<td>
																		{{ $appointment->created_at->format('d M Y') }}
																	</td>

																	<td>
																		₹{{ number_format($appointment->doctor->fee->doctor_fee ?? 0,2) }}
																	</td>

																	<td>

																		@if($appointment->appointment_date->isFuture())

																			{{ $appointment->appointment_date->copy()->addDays(7)->format('d M Y') }}

																		@else

																			-

																		@endif

																	</td>

																	<td>

																		@php

																			$badge = match($appointment->status){

																				'confirmed' => 'success',

																				'pending' => 'warning',

																				'cancelled' => 'danger',

																				'completed' => 'primary',

																				default => 'secondary'

																			};

																		@endphp

																		<span class="badge badge-pill bg-{{ $badge }}-light">

																			{{ ucfirst($appointment->status) }}

																		</span>

																	</td>

																	<td class="text-right">

																		<div class="table-action">

																			{{-- <a 
																			href="{{ route('appointment.invoice',$appointment->id) }}"
																			class="btn btn-sm bg-primary-light">

																				<i class="fas fa-print"></i> Print

																			</a> --}}

																			<a 
																			href="{{ route('patient.appointments.show',$appointment->id) }}"
																			class="btn btn-sm bg-info-light">

																				<i class="far fa-eye"></i> View

																			</a>

																		</div>

																	</td>

																</tr>

																@empty

																<tr>

																	<td colspan="6" class="text-center">
																		No appointments found.
																	</td>

																</tr>

																@endforelse

															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- /Upcoming Tab -->
										
										<!-- Upcoming Tab -->
										<div id="pat_upcoming_appointments" class="tab-pane fade">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>Doctor</th>
																	<th>Appt Date</th>
																	<th>Booking Date</th>
																	<th>Amount</th>
																	<th>Follow Up</th>
																	<th>Status</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>

																@forelse($upcomingAppointments as $appointment)

																<tr>

																	<td>
																		<h2 class="table-avatar">

																			<a href="#" class="avatar avatar-sm mr-2">

																				<img class="avatar-img rounded-circle"
																					src="{{ $appointment->doctor->profile_img ? asset($appointment->doctor->profile_img) : asset('assets/img/doctors/doctor-thumb-01.jpg') }}"
																					alt="Doctor">

																			</a>

																			<a href="#">

																				Dr. {{ $appointment->doctor->name }}

																				<span>
																					{{ $appointment->doctor->profile->specializationdata->name ?? 'Doctor' }}
																				</span>

																			</a>

																		</h2>
																	</td>

																	<td>
																		{{ $appointment->appointment_date->format('d M Y') }}

																		<span class="d-block text-info">

																			{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}

																		</span>
																	</td>

																	<td>
																		{{ $appointment->created_at->format('d M Y') }}
																	</td>

																	<td>
																		₹{{ number_format($appointment->doctor->fee->doctor_fee ?? 0,2) }}
																	</td>

																	<td>

																		@if($appointment->appointment_date->isFuture())

																			{{ $appointment->appointment_date->copy()->addDays(7)->format('d M Y') }}

																		@else

																			-

																		@endif

																	</td>

																	<td>

																		@php

																			$badge = match($appointment->status){

																				'confirmed' => 'success',

																				'pending' => 'warning',

																				'cancelled' => 'danger',

																				'completed' => 'primary',

																				default => 'secondary'

																			};

																		@endphp

																		<span class="badge badge-pill bg-{{ $badge }}-light">

																			{{ ucfirst($appointment->status) }}

																		</span>

																	</td>

																	<td class="text-right">

																		<div class="table-action">

																			{{-- <a 
																			href="{{ route('appointment.invoice',$appointment->id) }}"
																			class="btn btn-sm bg-primary-light">

																				<i class="fas fa-print"></i> Print

																			</a> --}}

																			<a 
																			href="{{ route('patient.appointments.show',$appointment->id) }}"
																			class="btn btn-sm bg-info-light">

																				<i class="far fa-eye"></i> View

																			</a>

																		</div>

																	</td>

																</tr>

																@empty

																<tr>

																	<td colspan="6" class="text-center">
																		No appointments found.
																	</td>

																</tr>

																@endforelse

															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- /Upcoming Tab -->

										<!-- Completed Tab -->
										<div id="pat_completed" class="tab-pane fade">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>Doctor</th>
																	<th>Appt Date</th>
																	<th>Booking Date</th>
																	<th>Amount</th>
																	<th>Follow Up</th>
																	<th>Status</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>

																@forelse($completedAppointments as $appointment)

																<tr>

																	<td>
																		<h2 class="table-avatar">

																			<a href="#" class="avatar avatar-sm mr-2">

																				<img class="avatar-img rounded-circle"
																					src="{{ $appointment->doctor->profile_img ? asset($appointment->doctor->profile_img) : asset('assets/img/doctors/doctor-thumb-01.jpg') }}"
																					alt="Doctor">

																			</a>

																			<a href="#">

																				Dr. {{ $appointment->doctor->name }}

																				<span>
																					{{ $appointment->doctor->profile->specializationdata->name ?? 'Doctor' }}
																				</span>

																			</a>

																		</h2>
																	</td>

																	<td>
																		{{ $appointment->appointment_date->format('d M Y') }}

																		<span class="d-block text-info">

																			{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}

																		</span>
																	</td>

																	<td>
																		{{ $appointment->created_at->format('d M Y') }}
																	</td>

																	<td>
																		₹{{ number_format($appointment->doctor->fee->doctor_fee ?? 0,2) }}
																	</td>

																	<td>

																		@if($appointment->appointment_date->isFuture())

																			{{ $appointment->appointment_date->copy()->addDays(7)->format('d M Y') }}

																		@else

																			-

																		@endif

																	</td>

																	<td>

																		@php

																			$badge = match($appointment->status){

																				'confirmed' => 'success',

																				'pending' => 'warning',

																				'cancelled' => 'danger',

																				'completed' => 'primary',

																				default => 'secondary'

																			};

																		@endphp

																		<span class="badge badge-pill bg-{{ $badge }}-light">

																			{{ ucfirst($appointment->status) }}

																		</span>

																	</td>

																	<td class="text-right">

																		<div class="table-action">

																			{{-- <a 
																			href="{{ route('appointment.invoice',$appointment->id) }}"
																			class="btn btn-sm bg-primary-light">

																				<i class="fas fa-print"></i> Print

																			</a> --}}

																			<a 
																			href="{{ route('patient.appointments.show',$appointment->id) }}"
																			class="btn btn-sm bg-info-light">

																				<i class="far fa-eye"></i> View

																			</a>

																		</div>

																	</td>

																</tr>

																@empty

																<tr>

																	<td colspan="6" class="text-center">
																		No appointments found.
																	</td>

																</tr>

																@endforelse

															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- /Completed Tab -->

										<!-- Shift Tab -->
										<div id="pat_shift" class="tab-pane fade">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>Doctor</th>
																	<th>Appt Date</th>
																	<th>Booking Date</th>
																	<th>Amount</th>
																	<th>Follow Up</th>
																	<th>Status</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>

																@forelse($shiftedAppointments as $appointment)

																<tr>

																	<td>
																		<h2 class="table-avatar">

																			<a href="#" class="avatar avatar-sm mr-2">

																				<img class="avatar-img rounded-circle"
																					src="{{ $appointment->doctor->profile_img ? asset($appointment->doctor->profile_img) : asset('assets/img/doctors/doctor-thumb-01.jpg') }}"
																					alt="Doctor">

																			</a>

																			<a href="#">

																				Dr. {{ $appointment->doctor->name }}

																				<span>
																					{{ $appointment->doctor->profile->specializationdata->name ?? 'Doctor' }}
																				</span>

																			</a>

																		</h2>
																	</td>

																	<td>
																		{{ $appointment->appointment_date->format('d M Y') }}

																		<span class="d-block text-info">

																			{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}

																		</span>
																	</td>

																	<td>
																		{{ $appointment->created_at->format('d M Y') }}
																	</td>

																	<td>
																		₹{{ number_format($appointment->doctor->fee->doctor_fee ?? 0,2) }}
																	</td>

																	<td>

																		@if($appointment->appointment_date->isFuture())

																			{{ $appointment->appointment_date->copy()->addDays(7)->format('d M Y') }}

																		@else

																			-

																		@endif

																	</td>

																	<td>

																		@php

																			$badge = match($appointment->status){

																				'confirmed' => 'success',

																				'pending' => 'warning',

																				'cancelled' => 'danger',

																				'completed' => 'primary',

																				default => 'secondary'

																			};

																		@endphp

																		<span class="badge badge-pill bg-{{ $badge }}-light">

																			{{ ucfirst($appointment->status) }}

																		</span>

																	</td>

																	<td class="text-right">

																		<div class="table-action">

																			{{-- <a 
																			href="{{ route('appointment.invoice',$appointment->id) }}"
																			class="btn btn-sm bg-primary-light">

																				<i class="fas fa-print"></i> Print

																			</a> --}}

																			<a 
																			href="{{ route('patient.appointments.show',$appointment->id) }}"
																			class="btn btn-sm bg-info-light">

																				<i class="far fa-eye"></i> View

																			</a>

																		</div>

																	</td>

																</tr>

																@empty

																<tr>

																	<td colspan="6" class="text-center">
																		No appointments found.
																	</td>

																</tr>

																@endforelse

															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- /Shift Tab -->

										<!-- Cancelled Tab -->
										<div id="pat_cancel" class="tab-pane fade">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>Doctor</th>
																	<th>Appt Date</th>
																	<th>Booking Date</th>
																	<th>Amount</th>
																	<th>Follow Up</th>
																	<th>Status</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>

																@forelse($cancelledAppointments as $appointment)

																<tr>

																	<td>
																		<h2 class="table-avatar">

																			<a href="#" class="avatar avatar-sm mr-2">

																				<img class="avatar-img rounded-circle"
																					src="{{ $appointment->doctor->profile_img ? asset($appointment->doctor->profile_img) : asset('assets/img/doctors/doctor-thumb-01.jpg') }}"
																					alt="Doctor">

																			</a>

																			<a href="#">

																				Dr. {{ $appointment->doctor->name }}

																				<span>
																					{{ $appointment->doctor->profile->specializationdata->name ?? 'Doctor' }}
																				</span>

																			</a>

																		</h2>
																	</td>

																	<td>
																		{{ $appointment->appointment_date->format('d M Y') }}

																		<span class="d-block text-info">

																			{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}

																		</span>
																	</td>

																	<td>
																		{{ $appointment->created_at->format('d M Y') }}
																	</td>

																	<td>
																		₹{{ number_format($appointment->doctor->fee->doctor_fee ?? 0,2) }}
																	</td>

																	<td>

																		@if($appointment->appointment_date->isFuture())

																			{{ $appointment->appointment_date->copy()->addDays(7)->format('d M Y') }}

																		@else

																			-

																		@endif

																	</td>

																	<td>

																		@php

																			$badge = match($appointment->status){

																				'confirmed' => 'success',

																				'pending' => 'warning',

																				'cancelled' => 'danger',

																				'completed' => 'primary',

																				default => 'secondary'

																			};

																		@endphp

																		<span class="badge badge-pill bg-{{ $badge }}-light">

																			{{ ucfirst($appointment->status) }}

																		</span>

																	</td>

																	<td class="text-right">

																		<div class="table-action">

																			{{-- <a 
																			href="{{ route('appointment.invoice',$appointment->id) }}"
																			class="btn btn-sm bg-primary-light">

																				<i class="fas fa-print"></i> Print

																			</a> --}}

																			<a 
																			href="{{ route('patient.appointments.show',$appointment->id) }}"
																			class="btn btn-sm bg-info-light">

																				<i class="far fa-eye"></i> View

																			</a>

																		</div>

																	</td>

																</tr>

																@empty

																<tr>

																	<td colspan="6" class="text-center">
																		No appointments found.
																	</td>

																</tr>

																@endforelse

															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- /Cancelled Tab -->
								
										<!-- Billing Tab -->
										<div id="pat_billing" class="tab-pane fade">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="row justify-content-center mb-4">

														<div class="col-md-4">

															<div class="card border-success">

																<div class="card-body text-center">

																	<h6 class="text-muted mb-2">
																		Total Amount Paid
																	</h6>

																	<h2 class="text-success mb-0">
																		₹{{ number_format($totalPaymentAmount, 2) }}
																	</h2>

																</div>

															</div>

														</div>

														<div class="col-md-4">

															<div class="card">

																<div class="card-body text-center">

																	<h6 class="text-muted mb-2">
																		Total Payments
																	</h6>

																	<h2 class="mb-0">
																		{{ $payments->count() }}
																	</h2>

																</div>

															</div>

														</div>

													</div>
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>Invoice No</th>
																	<th>Doctor</th>
																	<th>Amount</th>
																	<th>Paid On</th>
																	<th>Status</th>
																	{{-- <th></th> --}}
																</tr>
															</thead>
															
															<tbody>

																@forelse($payments as $payment)

																<tr>

																	<td>

																		#INV-{{ str_pad($payment->id,5,'0',STR_PAD_LEFT) }}

																	</td>

																	<td>

																		<h2 class="table-avatar">

																			<a href="#" class="avatar avatar-sm mr-2">

																				<img class="avatar-img rounded-circle"
																					src="{{ $payment->doctor->profile_img ? asset($payment->doctor->profile_img) : asset('assets/img/doctors/doctor-thumb-01.jpg') }}"
																					alt="Doctor">

																			</a>

																			<a href="#">

																				Dr. {{ $payment->doctor->name }}

																				<span>

																					{{ $payment->doctor->profile->specializationdata->name ?? 'Doctor' }}

																				</span>

																			</a>

																		</h2>

																	</td>

																	<td>

																		₹{{ number_format($payment->amount,2) }}

																	</td>

																	<td>

																		{{ optional($payment->paid_at)->format('d M Y') ?? $payment->created_at->format('d M Y') }}

																	</td>

																	<td>

																		@php

																			$badge = match($payment->status){

																				'success' => 'success',

																				'pending' => 'warning',

																				'failed' => 'danger',

																				default => 'secondary'

																			};

																		@endphp

																		<span class="badge badge-pill bg-{{ $badge }}-light">

																			{{ ucfirst($payment->status) }}

																		</span>

																	</td>
																	

																	{{-- <td class="text-right">

																		<div class="table-action">

																			<a
																			href="{{ route('payment.invoice',$payment->id) }}"
																			class="btn btn-sm bg-info-light">

																				<i class="far fa-eye"></i> View

																			</a>

																			<a 
																			href="{{ route('payment.invoice.print',$payment->id) }}"
																			class="btn btn-sm bg-primary-light">

																				<i class="fas fa-print"></i> Print

																			</a>

																		</div>

																	</td> --}}

																</tr>

																@empty

																<tr>

																	<td colspan="5" class="text-center">
																		No billing history found.
																	</td>

																</tr>

																@endforelse

															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- /Billing Tab -->
										
									</div>
									<!-- Tab Content -->
									
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