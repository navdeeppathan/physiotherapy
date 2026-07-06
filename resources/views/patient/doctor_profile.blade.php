@extends('layouts.app')

@section('content')
<div class="main-wrapper">

    @include('layouts.header')

    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h2 class="breadcrumb-title">Doctor Profile</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            <div class="row">

                <!-- Left Sidebar -->
                <div class="col-md-5 col-lg-4 col-xl-3">

                    <div class="card widget-profile">
                        <div class="card-body text-center">

                            <img
                                src="{{ $doctor->profile_img ? asset('uploads/profile/'.$doctor->profile_img) : asset('assets/img/doctors/doctor-thumb-01.jpg') }}"
                                class="rounded-circle mb-3"
                                width="120">

                            <h4>{{ $doctor->name }}</h4>

                            <p class="text-muted">
                                {{ optional($doctor->profile->specializationdata)->name }}
                            </p>

                            <h5 class="text-warning">
                                ★ {{ number_format($avgRating,1) }}
                            </h5>

                            <hr>

                            <p>
                                <strong>Experience</strong><br>
                                {{ optional($doctor->profile)->experience_years }} Years
                            </p>

                            {{-- <p>
                                <strong>Consultation Fee</strong><br>
                                ₹{{ optional($doctor->fee)->consultation_fee ?? optional($doctor->profile)->consultation_fee }}
                            </p> --}}

                            <p>
                                <strong>Phone</strong><br>
                                {{ $doctor->phone }}
                            </p>

                            <p>
                                <strong>Location</strong><br>
                                {{ optional($doctor->profile)->city }},
                                {{ optional($doctor->profile)->state }}
                            </p>

                            @if(optional($doctor->profile)->home_visit_available)
                                <span class="badge badge-success">
                                    Home Visit Available
                                </span>
                            @endif

                            <hr>

                            <a href="{{ route('doctor.booking',$doctor->id) }}"
                               class="btn btn-primary btn-block">
                                Book Appointment
                            </a>

                        </div>
                    </div>

                </div>

                <!-- Right -->
                <div class="col-md-7 col-lg-8 col-xl-9">

                    <div class="row mb-4">

                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3>{{ optional($doctor->profile)->experience_years }}</h3>
                                    <small>Years Experience</small>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3>{{ $doctor->doctorAppointments_count ?? 0 }}</h3>
                                    <small>Appointments</small>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3>{{ $totalReviews }}</h3>
                                    <small>Reviews</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3>{{ number_format($avgRating,1) }}</h3>
                                    <small>Rating</small>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card">
                        <div class="card-body">

                            <ul class="nav nav-tabs nav-tabs-bottom">

                                <li class="nav-item">
                                    <a class="nav-link active"
                                       data-toggle="tab"
                                       href="#about">
                                        About
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link"
                                       data-toggle="tab"
                                       href="#qualification">
                                        Qualification
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link"
                                       data-toggle="tab"
                                       href="#career">
                                        Career
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link"
                                       data-toggle="tab"
                                       href="#highlights">
                                        Highlights
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link"
                                       data-toggle="tab"
                                       href="#reviews">
                                        Reviews
                                    </a>
                                </li>

                            </ul>

                            <div class="tab-content pt-4">

                                <div class="tab-pane fade show active" id="about">
                                    <h4>Biography</h4>
                                    {!! nl2br(e(optional($doctor->profile)->bio)) !!}
                                </div>

                                <div class="tab-pane fade" id="qualification">
                                    <h4>Qualification</h4>
                                    {!! nl2br(e(optional($doctor->profile)->qualification)) !!}
                                </div>

                                <div class="tab-pane fade" id="career">
                                    <h4>Career Path</h4>
                                    {!! nl2br(e(optional($doctor->profile)->career_path)) !!}
                                </div>

                                <div class="tab-pane fade" id="highlights">
                                    <h4>Highlights</h4>
                                    {!! nl2br(e(optional($doctor->profile)->highlights)) !!}
                                </div>

                                <div class="tab-pane fade" id="reviews">

                                    @forelse($doctor->receivedReviews as $review)

                                        <div class="media border-bottom pb-3 mb-3">

                                            <img
                                                src="{{ $review->patient->profile_img ? asset('uploads/profile/'.$review->patient->profile_img) : asset('assets/img/patients/patient.jpg') }}"
                                                width="60"
                                                class="rounded-circle mr-3">

                                            <div class="media-body">

                                                <h5>
                                                    {{ $review->patient->name }}

                                                    <small class="text-warning">
                                                        {{ str_repeat('★',$review->rating) }}
                                                    </small>

                                                </h5>

                                                <small class="text-muted">
                                                    {{ $review->created_at->format('d M Y') }}
                                                </small>

                                                <p class="mt-2">
                                                    {{ $review->review }}
                                                </p>

                                            </div>

                                        </div>

                                    @empty

                                        <div class="alert alert-info">
                                            No reviews yet.
                                        </div>

                                    @endforelse

                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    @include('layouts.footer')

</div>
@endsection
