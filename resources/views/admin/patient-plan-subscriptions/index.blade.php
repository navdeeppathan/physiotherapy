@extends('admin.layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="card">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                Patient Plan Subscriptions
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Patient</th>
                            <th>Plan</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Used</th>
                            <th>Remaining</th>
                            <th>Payment</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($subscriptions as $key => $subscription)

                            <tr>

                                <td>
                                    {{ $subscriptions->firstItem() + $key }}
                                </td>

                                <td>
                                    {{ $subscription->patient->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $subscription->plan->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $subscription->start_date }}
                                </td>

                                <td>
                                    {{ $subscription->end_date }}
                                </td>

                                <td>
                                    {{ $subscription->used_appointments }}
                                </td>

                                <td>
                                    {{ $subscription->remaining_appointments }}
                                </td>

                                <td>
                                    @if($subscription->payment_status == 'paid')
                                        <span class="badge bg-success">
                                            Paid
                                        </span>
                                    @elseif($subscription->payment_status == 'pending')
                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            {{ ucfirst($subscription->payment_status) }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($subscription->status == 'active')
                                        <span class="badge bg-success">
                                            Active
                                        </span>
                                    @elseif($subscription->status == 'expired')
                                        <span class="badge bg-secondary">
                                            Expired
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            Cancelled
                                        </span>
                                    @endif
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="9" class="text-center">
                                    No Subscriptions Found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $subscriptions->links() }}
            </div>

        </div>

    </div>

</div>

@endsection