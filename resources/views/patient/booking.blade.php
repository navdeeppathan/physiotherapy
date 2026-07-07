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
									<li class="breadcrumb-item active" aria-current="page">Booking</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Booking</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">
				
					<div class="row">
						<div class="col-12">
						
							<div class="card">
								<div class="card-body">
									<div class="booking-doc-info">
										<a href="doctor-profile.html" class="booking-doc-img">
											<img src="{{asset('assets/img/doctors/doctor-thumb-02.jpg')}}" alt="User Image">
										</a>
										<div class="booking-info">
											<h4><a href="doctor-profile.html">{{ $doctor->name }}</a></h4>
											<p>{{ $doctor->profile->specializationdata->name }}, {{ $doctor->profile->qualification }}</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">{{ $doctor->profile->experience_years }} Years</span>
											</div>
											<p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i> {{ $doctor->profile->clinic_address }}</p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Schedule Widget -->
							<div class="card booking-schedule schedule-widget">
							
								<!-- Schedule Header -->
								{{-- <div class="schedule-header">
									<div class="row">
										<div class="col-md-12">
										
											

											<div class="day-slot">
												<ul>

													<li class="left-arrow">
														<a href="javascript:void(0)" id="prevDays">
															<i class="fa fa-chevron-left"></i>
														</a>
													</li>

													@foreach($doctor->availabilityDates as $index => $availability)

													<li class="day-item {{ $index==0 ? 'active' : '' }}"
														data-target="day{{ $availability->id }}">

														<span>
															{{ \Carbon\Carbon::parse($availability->available_date)->format('D') }}
														</span>

														<span class="slot-date">
															{{ \Carbon\Carbon::parse($availability->available_date)->format('d M') }}
															<small class="slot-year">
																{{ \Carbon\Carbon::parse($availability->available_date)->format('Y') }}
															</small>
														</span>

													</li>

													@endforeach

													<li class="right-arrow">
														<a href="javascript:void(0)" id="nextDays">
															<i class="fa fa-chevron-right"></i>
														</a>
													</li>

												</ul>
											</div>
											
										</div>
									</div>
								</div> --}}
								<!-- /Schedule Header -->
								
								<!-- Schedule Content -->
								{{-- <div class="schedule-cont">
									<div class="row">
										<div class="col-md-12">
										
											

											<div class="time-slot">
												<ul class="clearfix">

													@foreach($doctor->availabilityDates as $index => $availability)

														<li class="slot-item {{ $index == 0 ? 'active' : '' }}"
															id="day{{ $availability->id }}"
															style="{{ $index == 0 ? '' : 'display:none' }}">

															@forelse($availability->timeSlots as $slot)

																<a href="javascript:void(0)"
																class="timing {{ $slot->is_booked ? 'disabled' : '' }}"
																data-slot-id="{{ $slot->id }}">

																	<span>
																		{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}
																	</span>

																</a>

															@empty

																<div class="text-muted p-3">
																	No Slots Available
																</div>

															@endforelse

														</li>

													@endforeach

												</ul>
											</div>
											
										</div>
									</div>
								</div> --}}
								<!-- /Schedule Content -->

								<!-- Schedule Content -->
								<!-- Schedule Content -->
								<div class="schedule-cont">
									<div class="row">
										<div class="col-md-12">

											@foreach($doctor->availabilityDates as $availability)

												<div class="mb-4">

													<!-- Date Heading -->
													<div class="d-flex align-items-center mb-3">
														<h5 class="mb-0 font-weight-bold">
															{{ \Carbon\Carbon::parse($availability->available_date)->format('l, d M Y') }}
														</h5>
													</div>

													<!-- Slots -->
													<div class="time-slot">
														<ul class="clearfix">

															@forelse($availability->timeSlots as $slot)

																<li class="d-inline-block mb-2 mr-2">
																	<a href="javascript:void(0)"
																		class="timing {{ $slot->is_booked ? 'disabled' : '' }}"
																		data-slot-id="{{ $slot->id }}">

																		<span>
																			{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}
																		</span>

																	</a>
																</li>

															@empty

																<li class="text-muted">
																	No Slots Available
																</li>

															@endforelse

														</ul>
													</div>

												</div>

											@endforeach

										</div>
									</div>
								</div>
								<!-- /Schedule Content -->
								
							</div>
							<!-- /Schedule Widget -->
							<input type="hidden" id="doctor_id" value="{{ $doctor->id }}">
							<input type="hidden" id="selected_slots">
							<!-- Submit Section -->
							{{-- <div class="submit-section proceed-btn text-right">
								<a href="{{route('doctor.payment')}}" class="btn btn-primary submit-btn">Proceed to Pay</a>
							</div> --}}
							
							<div class="submit-section proceed-btn text-right">

								@auth
									<a href="javascript:void(0)"
									id="proceedPayment"
									class="btn btn-primary submit-btn">
										Proceed to Pay
									</a>
								@else
									<a href="{{ route('login') }}"
									class="btn btn-primary submit-btn">
										Login to Continue
									</a>
								@endauth

							</div>
							<!-- /Submit Section -->
							
						</div>
					</div>
				</div>

			</div>		
			<!-- /Page Content -->

			
   
			@include('layouts.footer')

		   
		</div>

		<form id="paymentForm" action="{{ route('doctor.payment') }}" method="POST" style="display:none;">
			@csrf

			<input type="hidden" name="doctor_id" id="paymentDoctorId">
			<input type="hidden" name="plan_id" id="paymentPlanId">
			<input type="hidden" name="slots" id="paymentSlots">
		</form>

		<div class="modal fade" id="planModal" tabindex="-1">
			<div class="modal-dialog modal-xl modal-dialog-centered">
				<div class="modal-content border-0 shadow-lg">

					<div class="modal-header">
						<h3 class="font-weight-bold mb-0">Choose Your Subscription Plan</h3>

						<button type="button" class="close" data-dismiss="modal">
							<span>&times;</span>
						</button>
					</div>

					<div class="modal-body">

						<div class="row justify-content-center">

							<div class="plan-list">

								@foreach($patientPlans as $plan)

								@php
									$perSession = $plan->total_appointments > 0
										? $plan->price / $plan->total_appointments
										: 0;
								@endphp

								<div class="plan-card"
									data-id="{{ $plan->id }}"
									data-total="{{ $plan->total_appointments }}">

									<div class="plan-radio">
										<span class="radio-circle"></span>
									</div>

									<div class="plan-content">

										<div class="plan-top">

											<div class="plan-name">
												{{ $plan->name }}
											</div>

											<div class="plan-price">
												₹{{ number_format($plan->price,2) }}
											</div>

										</div>

										<div class="plan-bottom">

											<div class="session-price">
												₹{{ number_format($perSession,0) }} per session
											</div>

											<div class="discount-area">

												@if($plan->discount_percentage > 0)

													<span class="old-price">
														₹{{ number_format($plan->original_price,2) }}
													</span>

													<span class="discount-badge">
														{{ rtrim(rtrim($plan->discount_percentage,'0'),'.') }}% Off
													</span>

												@endif

											</div>

										</div>

									</div>

									<button
										type="button"
										class="choose-plan d-none">
									</button>

								</div>

								@endforeach

							</div>

						</div>

					</div>

					<div class="modal-footer justify-content-end">

						<button
							type="button"
							class="btn btn-primary px-5"
							id="continuePlan"
							style="display:none; border-radius:30px;">

							Continue

							<i class="fa fa-arrow-right ml-2"></i>

						</button>

					</div>

				</div>
			</div>
		</div>
		
		<script>

			/*document.addEventListener("DOMContentLoaded", function () {

				const visibleCount = 7;
				let start = 0;

				const items = document.querySelectorAll(".day-item");
				const slotItems = document.querySelectorAll(".slot-item");

				function showSlots(targetId) {

					slotItems.forEach(function (slot) {

						slot.style.display = "none";
						slot.classList.remove("active");

					});

					const current = document.getElementById(targetId);

					if (current) {
						current.style.display = "block";
						current.classList.add("active");
					}

				}

				function render() {

					items.forEach(function (item, index) {

						if (index >= start && index < start + visibleCount) {
							item.style.display = "block";
						} else {
							item.style.display = "none";
						}

					});

					document.getElementById("prevDays").classList.toggle(
						"disabled",
						start == 0
					);

					document.getElementById("nextDays").classList.toggle(
						"disabled",
						start + visibleCount >= items.length
					);

				}

				render();

				// Show first day's slots
				if (items.length) {
					showSlots(items[0].dataset.target);
				}

				// Click on day
				items.forEach(function (item) {

					item.addEventListener("click", function () {

						items.forEach(function (d) {
							d.classList.remove("active");
						});

						this.classList.add("active");

						showSlots(this.dataset.target);

					});

				});

				// Next
				document.getElementById("nextDays").onclick = function () {

					if (start + visibleCount < items.length) {
						start++;
						render();
					}

				};

				// Previous
				document.getElementById("prevDays").onclick = function () {

					if (start > 0) {
						start--;
						render();
					}

				};

			});*/


			let selectedSlots = [];

			document.addEventListener("click", function(e){

				let slot = e.target.closest(".timing");

				if(!slot) return;

				if(slot.classList.contains("disabled")) return;

				let id = slot.dataset.slotId;

				if(slot.classList.contains("selected")){

					slot.classList.remove("selected");

					selectedSlots = selectedSlots.filter(x => x != id);

				}else{

					slot.classList.add("selected");

					selectedSlots.push(id);

				}

			});

			document.getElementById("proceedPayment").addEventListener("click", function () {

				// let slotId = document.getElementById("selected_slot_id").value;

				// if (!slotId) {
				// 	alert("Please select a time slot.");
				// 	return;
				// }

				// let doctorId = document.getElementById("doctor_id").value;

				// window.location.href =
				// 	"{{ route('doctor.payment') }}" +
				// 	"?doctor_id=" + doctorId +
				// 	"&slot_id=" + slotId;

				if(selectedSlots.length == 0){
					Swal.fire({
						icon:'warning',
						title:'Select Slot',
						text:'Please select at least one slot.'
					});
					return;
				}
				const modal = new bootstrap.Modal(document.getElementById('planModal'));
				modal.show();

			});


			document.querySelectorAll(".plan-card").forEach(function(card){

				card.addEventListener("click",function(){

					document.querySelectorAll(".plan-card").forEach(function(c){
						c.classList.remove("active");
					});

					card.classList.add("active");

					selectedPlan = card;

					document.getElementById("continuePlan").style.display="inline-block";

				});

			});

			document.getElementById("continuePlan").addEventListener("click", function () {

				if (!selectedPlan) {

					Swal.fire({
						icon: "warning",
						title: "Select Plan",
						text: "Please select a subscription plan."
					});

					return;
				}

				let total = parseInt(selectedPlan.dataset.total);

				if (selectedSlots.length != total) {

					Swal.fire({
						icon: "info",
						title: "Plan & Appointment Mismatch",
						html: `
							<p><strong>${selectedPlan.querySelector('.plan-name').innerText}</strong> includes <strong>${total}</strong> appointment(s).</p>

							<p>You selected <strong>${selectedSlots.length}</strong> appointment(s).</p>

							<p>Please select exactly <strong>${total}</strong> appointment(s).</p>
						`
					});

					return;
				}

				document.getElementById("paymentDoctorId").value =
					document.getElementById("doctor_id").value;

				document.getElementById("paymentPlanId").value =
					selectedPlan.dataset.id;

				document.getElementById("paymentSlots").value =
					selectedSlots.join(",");

				document.getElementById("paymentForm").submit();

			});

		</script>

<style>
	.day-item.active {
		background: #09e5ab;
		color: #fff;
		border-radius: 5px;
	}

	.day-item {
		cursor: pointer;
	}

	.slot-item {
		list-style: none;
	}

	.disabled {
		opacity: .4;
		pointer-events: none;
	}

	.plan-list{
		display:flex;
		flex-direction:column;
		gap:18px;
	}

	.plan-card{

		display:flex;
		align-items:flex-start;
		gap:18px;

		background:#fff;

		border:2px solid #ededed;

		border-radius:18px;

		padding:18px;

		cursor:pointer;

		transition:.3s;

		position:relative;

		

		

	}

	.plan-card:hover{

		border-color:#09e5ab;

		box-shadow:0 10px 25px rgba(0,0,0,.08);

	}

	.plan-card.active{

		border-color:#09e5ab;

		box-shadow:0 12px 30px rgba(9,229,171,.20);

	}

	.plan-radio{

		margin-top:3px;

	}

	.radio-circle{

		width:22px;

		height:22px;

		border-radius:50%;

		border:2px solid #cfcfcf;

		display:block;

		position:relative;

	}

	.plan-card.active .radio-circle{

		border-color:#09e5ab;

	}

	.plan-card.active .radio-circle:after{

		content:"";

		position:absolute;

		width:10px;

		height:10px;

		background:#09e5ab;

		border-radius:50%;

		left:50%;

		top:50%;

		transform:translate(-50%,-50%);

	}

	.plan-content{

		flex:1;
		

	}

	.plan-top{

		display:flex;

		justify-content:space-between;

		align-items:center;

		margin-bottom:10px;

	}

	.plan-name{

		font-size:22px;

		font-weight:700;

		color:#222;

	}

	.plan-price{

		font-size:32px;

		font-weight:700;

		color:#222;

	}

	.plan-bottom{

		display:flex;

		justify-content:space-between;

		align-items:center;

	}

	.session-price{

		color:#666;

		font-size:17px;

	}

	.discount-area{

		display:flex;

		align-items:center;

		gap:10px;

	}

	.old-price{

		text-decoration:line-through;

		color:#9d9d9d;

		font-size:17px;

	}

	.discount-badge{

		background:#eafaf2;

		color:#2d9d59;

		padding:5px 10px;

		border-radius:8px;

		font-size:14px;

		font-weight:600;

	}
</style>
@endsection		
	