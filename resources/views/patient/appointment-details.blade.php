@extends('layouts.app')

@section('content')

<div class="main-wrapper">

    @include('layouts.header')

    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">

                <h2 class="breadcrumb-title mb-0">
                    Appointment Details
                </h2>

                <a href="{{ route('patient.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>

            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            <div class="row">

                <!-- Left -->

                <div class="col-md-4">

                    <div class="card">

                        <div class="card-body text-center">

                            <img
                                src="{{ $appointment->doctor->profile_img ? asset('uploads/profile/'.$appointment->doctor->profile_img) : asset('assets/img/doctors/doctor-thumb-01.jpg') }}"
                                width="120"
                                class="rounded-circle mb-3">

                            <h4>
                              {{ $appointment->doctor->name }}
                            </h4>

                            <p class="text-muted">
                                {{ optional($appointment->doctor->profile->specializationdata)->name }}
                            </p>

                            <hr>

                            <p>

                                <strong>Phone</strong>

                                <br>

                                {{ $appointment->doctor->phone }}

                            </p>

                            <p>

                                <strong>Address</strong>

                                <br>

                                {{ optional($appointment->doctor->profile)->clinic_address }}

                            </p>

                            <hr>

                            <span class="badge
                                @if($appointment->status == 'cancelled')
                                    badge-danger
                                @elseif($appointment->status == 'completed')
                                    badge-success
                                @elseif($appointment->status == 'pending')
                                    badge-warning
                                @else
                                    badge-primary
                                @endif
                            ">
                                {{ ucfirst($appointment->status) }}
                            </span>

                        </div>

                        @if($appointment->status != 'cancelled')

                        <div class="card">

                            <div class="card-body text-center">

                                <button
                                    class="btn btn-danger"
                                    data-toggle="modal"
                                    data-target="#cancelAppointmentModal">

                                    Cancel Appointment

                                </button>

                            </div>

                        </div>

                        @endif

                        



                    </div>

                </div>

                <!-- Right -->

                <div class="col-md-8">

                    <div class="card">

                        <div class="card-header">

                            <h4>
                                Appointment Information
                            </h4>

                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <strong>Appointment ID</strong>

                                    <p>#{{ $appointment->id }}</p>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <strong>Status</strong>

                                    <p>

                                        <span class="badge
                                            @if($appointment->status == 'cancelled')
                                                badge-danger
                                            @elseif($appointment->status == 'completed')
                                                badge-success
                                            @elseif($appointment->status == 'pending')
                                                badge-warning
                                            @else
                                                badge-primary
                                            @endif
                                        ">
                                            {{ ucfirst($appointment->status) }}
                                        </span>

                                    </p>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <strong>Date</strong>

                                    <p>

                                        {{ $appointment->appointment_date->format('d M Y') }}

                                    </p>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <strong>Time</strong>

                                    <p>

                                        {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}

                                        -

                                        {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}

                                    </p>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <strong>Booking For</strong>

                                    <p>

                                        {{ ucfirst($appointment->booking_for) }}

                                    </p>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <strong>Payment Status</strong>

                                    <p>

                                        <span class="badge badge-success">

                                            {{ ucfirst($appointment->payment_status) }}

                                        </span>

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card">

                        <div class="card-header">

                            <h4>
                                Personal Information
                            </h4>

                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">

                                    <strong>Name</strong>

                                    <p>

                                        {{ $appointment->patient_name }}

                                    </p>

                                </div>

                                <div class="col-md-4">

                                    <strong>Age</strong>

                                    <p>

                                        {{ $appointment->patient_age }}

                                    </p>

                                </div>

                                <div class="col-md-4">

                                    <strong>Gender</strong>

                                    <p>

                                        {{ ucfirst($appointment->patient_gender) }}

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card">

                        <div class="card-header">

                            <h4>
                                Problem Description
                            </h4>

                        </div>

                        <div class="card-body">

                            {{ $appointment->problem_description ?: 'N/A' }}

                        </div>

                    </div>

                    <div class="card">

                        <div class="card-header">

                            <h4>
                                Address
                            </h4>

                        </div>

                        <div class="card-body">

                            {{ $appointment->patient_address ?: 'N/A' }}

                        </div>

                    </div>

                    @if($appointment->review)

                        <div class="card">

                            <div class="card-header">

                                <h4>
                                    Your Review
                                </h4>

                            </div>

                            <div class="card-body">

                                <h5 class="text-warning">

                                    {{ str_repeat('★',$appointment->review->rating) }}

                                </h5>

                                <p>

                                    {{ $appointment->review->review }}

                                </p>

                            </div>

                        </div>

                    @endif

                    @if($appointment->cancellation)

                        <div class="card border-danger">

                            <div class="card-header bg-danger text-white">

                                Cancellation Details

                            </div>

                            <div class="card-body">

                                <p>
                                    <strong>Reason:</strong>

                                    {{ optional($appointment->cancellation->reason)->title ?? 'Other' }}
                                </p>

                                @if($appointment->cancellation->custom_reason)
                                    <p>
                                        <strong>Details:</strong><br>
                                        {{ $appointment->cancellation->custom_reason }}
                                    </p>
                                @endif

                                <p>
                                    <strong>Cancelled By:</strong>
                                    {{ ucfirst($appointment->cancellation->cancelled_by) }}
                                </p>

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </div>
    </div>

    @include('layouts.footer')

</div>

@if($appointment->status != 'cancelled')

<div
    class="modal fade"
    id="cancelAppointmentModal">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                method="POST"
                action="{{ route('patient.appointment.cancel',$appointment->id) }}">

                @csrf

                <div class="modal-header">

                    <h5>

                        Cancel Appointment

                    </h5>

                    <button
                        class="close"
                        data-dismiss="modal">

                        &times;

                    </button>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <label>

                            Select Reason

                        </label>

                        <select
                            name="reason_id"
                            id="reason_id"
                            class="form-control">

                            <option value="">

                                Select Reason

                            </option>

                            @foreach($reasons as $reason)

                                <option
                                    value="{{ $reason->id }}"
                                    data-title="{{ strtolower($reason->title) }}">

                                    {{ $reason->title }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div
                        id="customReasonDiv"
                        style="display:none;">

                        <label>

                            Other Reason

                        </label>

                        <textarea
                            name="custom_reason"
                            class="form-control"
                            rows="4"></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-secondary"
                        data-dismiss="modal">

                        Close

                    </button>

                    <button
                        class="btn btn-danger">

                        Confirm Cancel

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endif

		<script src="{{ asset('assets/js/jquery.min.js') }}"></script>

<script>

    $(function(){

        $('#reason_id').change(function(){

            let text = $(this).find(':selected').text().trim().toLowerCase();

            if(text == 'other'){

                $('#customReasonDiv').slideDown();

            }else{

                $('#customReasonDiv').slideUp();

                $('textarea[name=custom_reason]').val('');

            }

        });

    });

</script>

@endsection