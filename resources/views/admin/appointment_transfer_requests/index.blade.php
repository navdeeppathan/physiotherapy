@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Appointment Transfer Requests</h5>
        </div>

        <div class="card-body">

            <form method="GET" class="row g-3 mb-3">

                <div class="col-md-4">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Search Doctor"
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>

                        <option value="pending"
                            {{ request('status') == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="approved"
                            {{ request('status') == 'approved' ? 'selected' : '' }}>
                            Approved
                        </option>

                        <option value="rejected"
                            {{ request('status') == 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        Filter
                    </button>
                </div>

            </form>

            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Doctor</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Requested On</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($requests as $key => $request)

                        <tr>

                            <td>
                                {{ $requests->firstItem() + $key }}
                            </td>

                            <td>
                                {{ $request->doctor->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($request->from_date)->format('d M Y') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($request->to_date)->format('d M Y') }}
                            </td>

                            <td>
                                {{ $request->reason }}
                            </td>

                            <td>

                                <span class="badge
                                    @if($request->status == 'approved')
                                        bg-success
                                    @elseif($request->status == 'pending')
                                        bg-warning
                                    @else
                                        bg-danger
                                    @endif">

                                    {{ ucfirst($request->status) }}

                                </span>

                            </td>

                            <td>
                                {{ $request->created_at->format('d M Y') }}
                            </td>

                            <td>

                                @if($request->status == 'pending')

                                    <a href="{{ route('admin.appointment-transfer-requests.show',$request->id) }}"
                                       class="btn btn-sm btn-primary">
                                        Review
                                    </a>

                                @else

                                    <button
                                        class="btn btn-sm btn-secondary"
                                        disabled>
                                        Closed
                                    </button>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="8" class="text-center">
                                No Requests Found
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $requests->links('pagination::bootstrap-5') }}
            </div>

        </div>

    </div>
</div>
@endsection