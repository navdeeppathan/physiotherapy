@extends('admin.layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="card">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Patient Plan</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.patient-plans.update', $plan->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Plan Name</label>

                    <input type="text"
                           name="name"
                           value="{{ $plan->name }}"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Description</label>

                    <textarea name="description"
                              class="form-control">{{ $plan->description }}</textarea>
                </div>

                <div class="row">

                    <div class="col-md-4">
                        <label>Price</label>

                        <input type="number"
                               step="0.01"
                               name="price"
                               value="{{ $plan->price }}"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label>Total Appointments</label>

                        <input type="number"
                               name="total_appointments"
                               value="{{ $plan->total_appointments }}"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label>Duration</label>

                        <select name="duration"
                                class="form-select">

                            <option value="weekly" {{ $plan->duration == 'weekly' ? 'selected' : '' }}>Weekly</option>

                            <option value="monthly" {{ $plan->duration == 'monthly' ? 'selected' : '' }}>Monthly</option>

                            <option value="quarterly" {{ $plan->duration == 'quarterly' ? 'selected' : '' }}>Quarterly</option>

                            <option value="half_yearly" {{ $plan->duration == 'half_yearly' ? 'selected' : '' }}>Half Yearly</option>

                            <option value="yearly" {{ $plan->duration == 'yearly' ? 'selected' : '' }}>Yearly</option>

                        </select>
                    </div>

                </div>

                <div class="mt-3">

                    <button type="submit"
                            class="btn btn-success">
                        Update Plan
                    </button>

                    <a href="{{ route('admin.patient-plans.index') }}"
                       class="btn btn-secondary">
                        Back
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection