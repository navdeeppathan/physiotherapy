@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">All Appointments</h5>
        </div>

        <div class="card-body">

            <!-- 🔎 Filters -->
            <form method="GET" class="row g-3 mb-3">

                <div class="col-md-3">
                    <input type="text" name="search"
                           class="form-control"
                           placeholder="Search Patient Name"
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                        <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
                        <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
                        <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Cancelled</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="payment_status" class="form-select">
                        <option value="">All Payment</option>
                        <option value="paid" {{ request('payment_status')=='paid'?'selected':'' }}>Paid</option>
                        <option value="unpaid" {{ request('payment_status')=='unpaid'?'selected':'' }}>Unpaid</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>

            </form>

            <!-- 📋 Table -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Doctor</th>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $key => $appointment)
                        <tr>
                            <td>{{ $appointments->firstItem() + $key }}</td>

                            <td>
                                {{ $appointment->doctor->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $appointment->patient_name }}
                            </td>

                            <td>
                                {{ $appointment->appointment_date }}
                            </td>

                            <td>
                                {{ $appointment->start_time }} - {{ $appointment->end_time }}
                            </td>

                            <td>
                                <span class="badge 
                                    @if($appointment->status=='approved') bg-success
                                    @elseif($appointment->status=='pending') bg-warning
                                    @elseif($appointment->status=='cancelled') bg-danger
                                    @elseif($appointment->status=='confirmed') bg-info
                                    @elseif($appointment->status=='completed') bg-primary
                                    @else bg-danger
                                    @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge 
                                    {{ $appointment->payment_status=='paid'?'bg-success':'bg-danger' }}">
                                    {{ ucfirst($appointment->payment_status) }}
                                </span>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No Appointments Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 📄 Pagination -->
            <div class="mt-3">
                {{ $appointments->links() }}
            </div>

        </div>
    </div>
</div>
@endsection