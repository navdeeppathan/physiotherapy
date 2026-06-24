@extends('admin.layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="card">

        <div class="card-header bg-primary text-white">
            Review Transfer Request
        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-6">
                    <strong>Patient:</strong>
                    {{ $transferRequest->appointment->patient_name }}
                </div>

                <div class="col-md-6">
                    <strong>Appointment Date:</strong>
                    {{ $transferRequest->appointment->appointment_date }}
                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">
                    <strong>Current Doctor:</strong>
                    {{ $transferRequest->currentDoctor->name }}
                </div>

                <div class="col-md-6">
                    <strong>Suggested Doctor:</strong>
                    {{ $transferRequest->requestedDoctor->name ?? 'Not Suggested' }}
                </div>

            </div>

            <div class="mb-4">

                <strong>Reason:</strong>

                <div class="border rounded p-3 mt-2">
                    {{ $transferRequest->reason }}
                </div>

            </div>

            @if($transferRequest->status == 'pending')

            <form method="POST"
                  action="{{ route('admin.appointment-transfer-requests.approve',$transferRequest->id) }}">

                @csrf

                <div class="mb-3">

                    <label>Select New Doctor</label>

                    <select name="new_doctor_id"
                            class="form-select"
                            required>

                        <option value="">
                            Select Doctor
                        </option>

                        @foreach($doctors as $doctor)

                        <option value="{{ $doctor->id }}"
                            {{ $transferRequest->requested_doctor_id == $doctor->id ? 'selected' : '' }}>

                            {{ $doctor->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label>Admin Remark</label>

                    <textarea
                        name="admin_remark"
                        class="form-control"
                        rows="3"></textarea>

                </div>

                <button class="btn btn-success">
                    Approve & Transfer
                </button>

            </form>

            <hr>

            <form method="POST"
                  action="{{ route('admin.appointment-transfer-requests.reject',$transferRequest->id) }}">

                @csrf

                <textarea
                    name="admin_remark"
                    class="form-control mb-3"
                    placeholder="Reason for rejection"
                    required></textarea>

                <button class="btn btn-danger">
                    Reject Request
                </button>

            </form>

            @else

                <div class="alert alert-info">
                    This request has already been
                    <strong>{{ ucfirst($transferRequest->status) }}</strong>.
                </div>

            @endif

        </div>

    </div>

</div>

@endsection