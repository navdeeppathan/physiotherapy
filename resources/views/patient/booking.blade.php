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
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">35</span>
											</div>
											<p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i> {{ $doctor->profile->clinic_address }}</p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Schedule Widget -->
							<div class="card booking-schedule schedule-widget">
							
								<!-- Schedule Header -->
								<div class="schedule-header">
									<div class="row">
										<div class="col-md-12">
										
											<!-- Day Slot -->
											{{-- <div class="day-slot">
												<ul>
													<li class="left-arrow">
														<a href="#">
															<i class="fa fa-chevron-left"></i>
														</a>
													</li>
													<li>
														<span>Mon</span>
														<span class="slot-date">11 Nov <small class="slot-year">2019</small></span>
													</li>
													<li>
														<span>Tue</span>
														<span class="slot-date">12 Nov <small class="slot-year">2019</small></span>
													</li>
													<li>
														<span>Wed</span>
														<span class="slot-date">13 Nov <small class="slot-year">2019</small></span>
													</li>
													<li>
														<span>Thu</span>
														<span class="slot-date">14 Nov <small class="slot-year">2019</small></span>
													</li>
													<li>
														<span>Fri</span>
														<span class="slot-date">15 Nov <small class="slot-year">2019</small></span>
													</li>
													<li>
														<span>Sat</span>
														<span class="slot-date">16 Nov <small class="slot-year">2019</small></span>
													</li>
													<li>
														<span>Sun</span>
														<span class="slot-date">17 Nov <small class="slot-year">2019</small></span>
													</li>
													<li class="right-arrow">
														<a href="#">
															<i class="fa fa-chevron-right"></i>
														</a>
													</li>
												</ul>
											</div> --}}
											<!-- /Day Slot -->

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
								</div>
								<!-- /Schedule Header -->
								
								<!-- Schedule Content -->
								<div class="schedule-cont">
									<div class="row">
										<div class="col-md-12">
										
											<!-- Time Slot -->
											{{-- <div class="time-slot">
												<ul class="clearfix">
													<li>
														<a class="timing" href="#">
															<span>9:00</span> <span>AM</span>
														</a>
														<a class="timing" href="#">
															<span>10:00</span> <span>AM</span>
														</a>
														<a class="timing" href="#">
															<span>11:00</span> <span>AM</span>
														</a>
													</li>
													<li>
														<a class="timing" href="#">
															<span>9:00</span> <span>AM</span>
														</a>
														<a class="timing" href="#">
															<span>10:00</span> <span>AM</span>
														</a>
														<a class="timing" href="#">
															<span>11:00</span> <span>AM</span>
														</a>
													</li>
													<li>
														<a class="timing" href="#">
															<span>9:00</span> <span>AM</span>
														</a>
														<a class="timing" href="#">
															<span>10:00</span> <span>AM</span>
														</a>
														<a class="timing" href="#">
															<span>11:00</span> <span>AM</span>
														</a>
													</li>
													<li>
														<a class="timing" href="#">
															<span>9:00</span> <span>AM</span>
														</a>
														<a class="timing" href="#">
															<span>10:00</span> <span>AM</span>
														</a>
														<a class="timing" href="#">
															<span>11:00</span> <span>AM</span>
														</a>
													</li>
													<li>
														<a class="timing" href="#">
															<span>9:00</span> <span>AM</span>
														</a>
														<a class="timing selected" href="#">
															<span>10:00</span> <span>AM</span>
														</a>
														<a class="timing" href="#">
															<span>11:00</span> <span>AM</span>
														</a>
													</li>
													<li>
														<a class="timing" href="#">
															<span>9:00</span> <span>AM</span>
														</a>
														<a class="timing" href="#">
															<span>10:00</span> <span>AM</span>
														</a>
														<a class="timing" href="#">
															<span>11:00</span> <span>AM</span>
														</a>
													</li>
													<li>
														<a class="timing" href="#">
															<span>9:00</span> <span>AM</span>
														</a>
														<a class="timing" href="#">
															<span>10:00</span> <span>AM</span>
														</a>
														<a class="timing" href="#">
															<span>11:00</span> <span>AM</span>
														</a>
													</li>
												</ul>
											</div> --}}
											<!-- /Time Slot -->

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

							@foreach($patientPlans as $plan)

							<div class="col-lg-4 col-md-6 mb-4">

								<div class="pricing-card plan-card"
									data-id="{{ $plan->id }}"
									data-total="{{ $plan->total_appointments }}">

									<div class="pricing-header">

										<h6>{{ strtoupper($plan->name) }}</h6>

										<h2>

											₹{{ number_format($plan->price,0) }}

											<small>/ {{ ucfirst($plan->duration) }}</small>

										</h2>

									</div>

									<ul class="pricing-features">

										<li>
											<i class="fa fa-check text-success"></i>

											{{ $plan->total_appointments }}
											Appointments
										</li>

										<li>
											<i class="fa fa-check text-success"></i>

											{{ ucfirst($plan->duration) }}
											Validity
										</li>

										<li>
											<i class="fa fa-check text-success"></i>

											Online Consultation
										</li>

										<li>
											<i class="fa fa-check text-success"></i>

											Priority Booking
										</li>

									</ul>

									<div class="p-4">

										<button
											type="button"
											class="btn btn-block btn-primary choose-plan">

											Choose Plan

										</button>

									</div>

								</div>

							</div>

							@endforeach

						</div>

					</div>

				</div>
			</div>
		</div>
		
		<script>

			document.addEventListener("DOMContentLoaded", function () {

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

			});


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


			let selectedPlan = null;

			document.querySelectorAll(".plan-card").forEach(function(card){

				card.querySelector(".choose-plan").onclick=function(e){

					e.stopPropagation();

					document.querySelectorAll(".plan-card").forEach(function(c){
						c.classList.remove("active");
					});

					card.classList.add("active");

					let total=parseInt(card.dataset.total);

					if(selectedSlots.length!=total){

						Swal.fire({
							icon: "info",
							title: "Plan & Appointment Mismatch",
							html: `
								<p><strong>${card.querySelector('h6').innerText}</strong> includes <strong>${total} appointment(s)</strong>.</p>
								<p>You have currently selected <strong>${selectedSlots.length}</strong> appointment slot(s).</p>
								<p>Please select exactly <strong>${total}</strong> appointment slot(s) to proceed with this plan.</p>
							`,
							confirmButtonText: "Got it"
						});

						return;

					}

					let doctorId=document.getElementById("doctor_id").value;

					let query=new URLSearchParams({

						doctor_id:doctorId,

						plan_id:card.dataset.id,

						slots:selectedSlots.join(",")

					});

					// window.location.href="{{ route('doctor.payment') }}?"+query;

					fetch("{{ route('patient.subscribe.web') }}",{

						method:"POST",

						headers:{
							"Content-Type":"application/json",
							"X-CSRF-TOKEN":"{{ csrf_token() }}"
						},

						body:JSON.stringify({

							plan_id:card.dataset.id,

							doctor_id:doctorId,

							slots:selectedSlots.join(",")

						})

					})
					.then(res=>res.json())
					.then(function(res){

						if(res.status){

							let query=new URLSearchParams({

								doctor_id:doctorId,

								subscription_id:res.subscription_id,

								slots:selectedSlots.join(",")

							});

							window.location.href="{{ route('doctor.payment') }}?"+query;

						}else{

							Swal.fire("Error",res.message,"error");

						}

					});

				};

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

	.pricing-card{

		background:#fff;
		border-radius:10px;
		overflow:hidden;
		transition:.35s;
		box-shadow:0 8px 25px rgba(0,0,0,.08);
		cursor:pointer;
		text-align:center;
		border:2px solid transparent;

	}

	.pricing-card:hover{

		transform:translateY(-10px);

	}

	.pricing-header{

		background:#09e5ab;
		color:#fff;
		padding:30px 20px;

	}

	.pricing-header h6{

		font-size:18px;
		font-weight:700;
		margin-bottom:15px;

	}

	.pricing-header h2{

		font-size:42px;
		font-weight:700;
		margin:0;

	}

	.pricing-header small{

		font-size:16px;

	}

	.pricing-features{

		list-style:none;
		padding:25px;
		margin:0;

	}

	.pricing-features li{

		padding:12px 0;
		border-bottom:1px solid #eee;
		font-size:15px;

	}

	.plan-card.active{

		transform:scale(1.08);
		border:3px solid #09e5ab;
		box-shadow:0 15px 35px rgba(9,229,171,.35);

	}

	.plan-card.active .pricing-header{

		background:#00c897;

	}

	.choose-plan{

		border-radius:30px;
		font-weight:600;

	}
</style>
@endsection		
	