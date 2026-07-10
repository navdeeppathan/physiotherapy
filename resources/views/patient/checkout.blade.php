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

										<input type="hidden" name="address" id="selected_address">

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

									@auth

										<div class="card mt-4">

											<div class="card-header d-flex justify-content-between align-items-center">

												<h4 class="mb-0">
													Select Address
												</h4>

												<button
													class="btn btn-primary btn-sm"
													data-toggle="modal"
													data-target="#addressModal"
													>

													+ Add New

												</button>

											</div>

											<div class="card-body">

												@php

												$addresses = Auth::user()->addresses;

												@endphp

												@forelse($addresses as $address)

													<div class="border rounded p-3 mb-3">

														<div class="d-flex justify-content-between">

															<div>

																<input
																	type="radio"
																	name="address_id"
																	value="{{ $address->address }},
																			{{ $address->city }},
																			{{ $address->state }},
																			{{ $address->country }} - {{ $address->postal_code }}"
																	{{ $address->is_default ? 'checked' : '' }}
																	onchange="setSelectedAddress(this)"
																	>

																<strong>{{ $address->address }}</strong>

																<br>

																{{ $address->city }},
																{{ $address->state }}

																<br>

																{{ $address->country }}
																-
																{{ $address->postal_code }}

															</div>

															<div>

																<button
																	type="button"
																	class="btn btn-sm btn-warning"
																	data-toggle="modal"
																	data-target="#editAddressModal{{ $address->id }}">

																	Edit

																</button>

																<form
																	action="{{ route('user.address.destroy',$address->id) }}"
																	method="POST"
																	class="d-inline">

																	@csrf
																	@method('DELETE')

																	<button
																		class="btn btn-sm btn-danger"
																		onclick="return confirm('Delete this address?')">

																		Delete

																	</button>

																</form>

															</div>

														</div>

													</div>

													<div class="modal fade" id="editAddressModal{{ $address->id }}">

														<div class="modal-dialog">

															<div class="modal-content">

																<div class="modal-header">

																	<h5>Edit Address</h5>

																	<button
																		class="close"
																		data-dismiss="modal">

																		<span>&times;</span>

																	</button>

																</div>

																<div class="modal-body">

																	<form
																		action="{{ route('user.address.update',$address->id) }}"
																		method="POST">

																		@csrf
																		@method('PUT')

																		<div class="mb-3">

																			<input
																				class="form-control"
																				name="address"
																				value="{{ $address->address }}"
																				required>

																		</div>

																		<div class="mb-3">

																			<input
																				class="form-control"
																				name="city"
																				value="{{ $address->city }}"
																				required>

																		</div>

																		<div class="mb-3">

																			<input
																				class="form-control"
																				name="state"
																				value="{{ $address->state }}"
																				required>

																		</div>

																		<div class="mb-3">

																			<input
																				class="form-control"
																				name="country"
																				value="{{ $address->country }}"
																				required>

																		</div>

																		<div class="mb-3">

																			<input
																				class="form-control"
																				name="postal_code"
																				value="{{ $address->postal_code }}"
																				required>

																		</div>

																		<div class="form-check">

																			<input
																				type="checkbox"
																				class="form-check-input"
																				name="is_default"
																				value="1"
																				{{ $address->is_default ? 'checked' : '' }}>

																			<label>

																				Make Default

																			</label>

																		</div>

																		<button
																			class="btn btn-primary mt-3">

																			Update Address

																		</button>

																	</form>

																</div>

															</div>

														</div>

													</div>

												@empty

													<p>No Address Found.</p>

												@endforelse

											</div>

										</div>

									@endauth
									
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
			@include('layouts.footer')
			<!-- /Footer -->
		   
		</div>
		<!-- /Main Wrapper -->

		<div class="modal fade" id="addressModal">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">

						<h5>Add Address</h5>

						<button
							type="button"
							class="close"
							data-dismiss="modal">
							<span>&times;</span>
						</button>

					</div>

					<div class="modal-body">

						<form action="{{ route('user.address.store') }}" method="POST">
							@csrf

							<div class="mb-3">
								<input
									type="text"
									class="form-control"
									name="address"
									placeholder="Address"
									required>
							</div>

							<div class="mb-3">
								<input
									type="text"
									class="form-control"
									name="city"
									placeholder="City"
									required>
							</div>

							<div class="mb-3">
								<input
									type="text"
									class="form-control"
									name="state"
									placeholder="State"
									required>
							</div>

							<div class="mb-3">
								<input
									type="text"
									class="form-control"
									name="country"
									value="India"
									required>
							</div>

							<div class="mb-3">
								<input
									type="text"
									class="form-control"
									name="postal_code"
									placeholder="Postal Code"
									required>
							</div>

							<div class="form-check">
								<input
									class="form-check-input"
									type="checkbox"
									name="is_default"
									value="1">

								<label class="form-check-label">
									Make Default
								</label>
							</div>

							<button type="submit" class="btn btn-primary mt-3">
								Save Address
							</button>
						</form>

					</div>

				</div>

			</div>

		</div>

		
	  
		<script>
			document.addEventListener('DOMContentLoaded', function () {

				function updateAddress() {
					const checked = document.querySelector('input[name="address_id"]:checked');
					if (checked) {
						document.getElementById('selected_address').value = checked.value;
					}
				}

				document.querySelectorAll('input[name="address_id"]').forEach(function(radio){
					radio.addEventListener('change', updateAddress);
				});

				updateAddress(); // set default checked address
			});
		</script>
		
		
		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>


		
		
@endsection