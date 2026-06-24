@extends('admin.layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="card">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Appointment Transfer Requests</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Current Doctor</th>
                        <th>Suggested Doctor</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($requests as $key => $item)

                    <tr>

                        <td>{{ $requests->firstItem() + $key }}</td>

                        <td>
                            {{ $item->appointment->patient_name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $item->currentDoctor->name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $item->requestedDoctor->name ?? 'Not Suggested' }}
                        </td>

                        <td>

                            <span class="badge
                            @if($item->status=='approved')
                                bg-success
                            @elseif($item->status=='pending')
                                bg-warning
                            @else
                                bg-danger
                            @endif">

                                {{ ucfirst($item->status) }}

                            </span>

                        </td>

                        <td>

                            <a href="{{ route('admin.appointment-transfer-requests.show',$item->id) }}"
                               class="btn btn-sm btn-primary">

                                View

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            No Requests Found
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            {{ $requests->links('pagination::bootstrap-5') }}

        </div>

    </div>

</div>

@endsection