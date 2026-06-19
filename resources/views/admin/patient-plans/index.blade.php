@extends('admin.layouts.admin')

@section('content')

<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Patient Plans</h5>

            <a href="{{ route('admin.patient-plans.create') }}"
               class="btn btn-light btn-sm">
                Add Plan
            </a>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Appointments</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($plans as $key => $plan)

                            <tr>

                                <td>{{ $plans->firstItem() + $key }}</td>

                                <td>{{ $plan->name }}</td>

                                <td>
                                    {{ $plan->currency }}
                                    {{ $plan->price }}
                                </td>

                                <td>{{ $plan->total_appointments }}</td>

                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ ucfirst(str_replace('_', ' ', $plan->duration)) }}
                                    </span>
                                </td>

                                <td>
                                    @if($plan->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>

                                <td>

                                    <a href="{{ route('admin.patient-plans.edit', $plan->id) }}"
                                       class="btn btn-sm btn-primary">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.patient-plans.destroy', $plan->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this plan?')">
                                            Delete
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center">
                                    No Plans Found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $plans->links('pagination::bootstrap-5') }}
                
            </div>

        </div>

    </div>

</div>

@endsection