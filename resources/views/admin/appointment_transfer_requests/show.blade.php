@extends('admin.layouts.admin')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            <h5>Transfer Request Details</h5>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <strong>Doctor:</strong>
                {{ $requestData->doctor->name }}
            </div>

            <div class="mb-3">
                <strong>Period:</strong>
                {{ $requestData->from_date }}
                -
                {{ $requestData->to_date }}
            </div>

            <div class="mb-3">
                <strong>Reason:</strong>
                {{ $requestData->reason }}
            </div>

            <hr>

            <h5>Affected Appointments</h5>

            <form method="POST"
      action="{{ route('admin.appointment-transfer-requests.approve',$requestData->id) }}">

    @csrf

    <table class="table table-bordered">

        <thead>
            <tr>
                <th>Patient</th>
                <th>Date</th>
                <th>Time</th>
                <th>Transfer To Doctor</th>
            </tr>
        </thead>

        <tbody>

            @foreach($appointments as $appointment)

            <tr>

                <td>
                    {{ $appointment->patient_name }}
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                    -
                    {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                </td>

                <td>

                    <select
                        name="appointments[{{ $appointment->id }}]"
                        class="form-control">

                        <option value="">
                            Select Doctor
                        </option>

                        @foreach($appointment->available_doctors as $doctor)

                            <option value="{{ $doctor->id }}">
                                {{ $doctor->name }}
                            </option>

                        @endforeach

                    </select>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

    <div class="mb-3">
        <label>Admin Remark</label>

        <textarea
            name="admin_remark"
            class="form-control"></textarea>
    </div>

    <button
        type="submit"
        class="btn btn-success">

        Approve & Transfer
    </button>

</form>

            <hr>

            

           

            <form method="POST"
                  class="mt-2"
                  action="{{ route('admin.appointment-transfer-requests.reject',$requestData->id) }}">

                @csrf

                <textarea
                    name="admin_remark"
                    class="form-control mb-2"
                    placeholder="Reason for rejection"></textarea>

                <button
                    type="submit"
                    class="btn btn-danger">

                    Reject Request
                </button>

            </form>

        </div>

    </div>

</div>

@endsection