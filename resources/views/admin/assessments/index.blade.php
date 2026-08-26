@extends('admin.layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                    <i class="fas fa-clipboard-check text-primary me-2"></i> Patient Assessments
                </h1>
                <p class="text-muted small mb-0">View all treatment plans created by doctors for patients.</p>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #2260FF 0%, #4C8BFF 100%); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white-50 small font-weight-bold text-uppercase">Total Assessments</div>
                            <div class="h3 mb-0 font-weight-bold">{{ $totalAssessments }}</div>
                        </div>
                        <div style="font-size:2rem; opacity:0.5;"><i class="fas fa-clipboard-list"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white-50 small font-weight-bold text-uppercase">Active Plans</div>
                            <div class="h3 mb-0 font-weight-bold">{{ $activeAssessments }}</div>
                        </div>
                        <div style="font-size:2rem; opacity:0.5;"><i class="fas fa-running"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white-50 small font-weight-bold text-uppercase">Completed Plans</div>
                            <div class="h3 mb-0 font-weight-bold">{{ $completedAssessments }}</div>
                        </div>
                        <div style="font-size:2rem; opacity:0.5;"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #7b4397 0%, #dc2430 100%); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white-50 small font-weight-bold text-uppercase">Total Sessions</div>
                            <div class="h3 mb-0 font-weight-bold">{{ $totalSessions }}</div>
                        </div>
                        <div style="font-size:2rem; opacity:0.5;"><i class="fas fa-calendar-check"></i></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('admin.assessments.index') }}" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-semibold">Search Patient / Doctor</label>
                        <input type="text" name="search" class="form-control form-control-sm rounded-3"
                               placeholder="Name..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted fw-semibold">Status</label>
                        <select name="status" class="form-select form-select-sm rounded-3">
                            <option value="">All Status</option>
                            <option value="active"    {{ request('status') == 'active'    ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="draft"     {{ request('status') == 'draft'     ? 'selected' : '' }}>Draft</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-semibold">Condition</label>
                        <select name="condition_id" class="form-select form-select-sm rounded-3">
                            <option value="">All Conditions</option>
                            @foreach($conditions as $c)
                                <option value="{{ $c->id }}" {{ request('condition_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted fw-semibold">Doctor</label>
                        <select name="doctor_id" class="form-select form-select-sm rounded-3">
                            <option value="">All Doctors</option>
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}" {{ request('doctor_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm rounded-3 w-100">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.assessments.index') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Condition</th>
                                <th>Sessions</th>
                                <th>Duration</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assessments as $a)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $a->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ optional($a->patient)->name ?? '—' }}</div>
                                    <div class="text-muted small">{{ optional($a->patient)->phone }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ optional($a->doctor)->name ?? '—' }}</div>
                                    <div class="text-muted small">Dr.</div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-2 py-1">
                                        {{ optional($a->condition)->name ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-semibold text-success">{{ $a->completed_sessions }}</span>
                                    <span class="text-muted">/{{ $a->total_sessions }}</span>
                                </td>
                                <td class="text-muted small">{{ $a->goal_duration_weeks }} Weeks</td>
                                <td class="text-muted small">
                                    {{ $a->assessment_date ? \Carbon\Carbon::parse($a->assessment_date)->format('d M Y') : '—' }}
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($a->status) {
                                            'active'    => 'bg-success',
                                            'completed' => 'bg-primary',
                                            'cancelled' => 'bg-danger',
                                            default     => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} rounded-pill px-2 py-1">
                                        {{ ucfirst($a->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.assessments.show', $a->id) }}"
                                       class="btn btn-outline-primary btn-sm rounded-3">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-clipboard fa-2x mb-2 d-block opacity-25"></i>
                                    No assessments found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($assessments->hasPages())
                <div class="d-flex justify-content-end p-3">
                    {{ $assessments->links() }}
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
