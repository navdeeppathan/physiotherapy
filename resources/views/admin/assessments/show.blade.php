@extends('admin.layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        {{-- Breadcrumb --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item"><a href="{{ route('admin.assessments.index') }}">Assessments</a></li>
                        <li class="breadcrumb-item active">Assessment #{{ $assessment->id }}</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                    <i class="fas fa-clipboard-check text-primary me-2"></i>
                    Assessment Detail
                </h1>
            </div>
            <a href="{{ route('admin.assessments.index') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="row g-4">

            {{-- Left Column --}}
            <div class="col-lg-4">

                {{-- Patient Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 fw-semibold pt-3 pb-0">
                        <i class="fas fa-user-injured text-primary me-1"></i> Patient Details
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                 style="width:50px;height:50px;font-size:1.3rem;font-weight:700;color:#2260FF;">
                                {{ strtoupper(substr(optional($assessment->patient)->name ?? 'P', 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ optional($assessment->patient)->name ?? '—' }}</div>
                                <div class="text-muted small">{{ optional($assessment->patient)->phone }}</div>
                            </div>
                        </div>
                        <table class="table table-sm table-borderless mb-0 small">
                            <tr><td class="text-muted">Patient ID</td><td class="fw-semibold">PTE{{ str_pad(optional($assessment->patient)->id, 5, '0', STR_PAD_LEFT) }}</td></tr>
                            <tr><td class="text-muted">Email</td><td>{{ optional($assessment->patient)->email }}</td></tr>
                        </table>
                    </div>
                </div>

                {{-- Doctor Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 fw-semibold pt-3 pb-0">
                        <i class="fas fa-user-md text-success me-1"></i> Doctor Details
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                 style="width:50px;height:50px;font-size:1.3rem;font-weight:700;color:#11998e;">
                                {{ strtoupper(substr(optional($assessment->doctor)->name ?? 'D', 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">Dr. {{ optional($assessment->doctor)->name }}</div>
                                <div class="text-muted small">{{ optional($assessment->doctor)->email }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Plan Summary Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 fw-semibold pt-3 pb-0">
                        <i class="fas fa-chart-bar text-warning me-1"></i> Treatment Plan Summary
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless mb-0 small">
                            <tr>
                                <td class="text-muted">Condition</td>
                                <td><span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill">{{ optional($assessment->condition)->name ?? '—' }}</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status</td>
                                <td>
                                    @php
                                        $bc = match($assessment->status) {
                                            'active' => 'success', 'completed' => 'primary',
                                            'cancelled' => 'danger', default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $bc }} rounded-pill px-2">{{ ucfirst($assessment->status) }}</span>
                                </td>
                            </tr>
                            <tr><td class="text-muted">Assessment Date</td><td>{{ $assessment->assessment_date?->format('d M Y') }}</td></tr>
                            <tr><td class="text-muted">Goal Duration</td><td>{{ $assessment->goal_duration_weeks }} Weeks</td></tr>
                            <tr><td class="text-muted">Baseline Score</td><td>{{ $assessment->baseline_score ?? '—' }} / 10</td></tr>
                            <tr>
                                <td class="text-muted">Sessions Progress</td>
                                <td>
                                    <span class="fw-semibold text-success">{{ $completedSessions }}</span> / {{ $assessment->total_sessions }}
                                    <div class="progress mt-1" style="height:5px;">
                                        <div class="progress-bar bg-success" style="width:{{ $assessment->total_sessions > 0 ? round(($completedSessions / $assessment->total_sessions) * 100) : 0 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr><td class="text-muted">Next Session</td>
                                <td>{{ $assessment->next_session_date ? \Carbon\Carbon::parse($assessment->next_session_date)->format('d M Y') : '—' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Overall Goal --}}
                @if($assessment->goal_text)
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 fw-semibold pt-3 pb-0">
                        <i class="fas fa-bullseye text-danger me-1"></i> Overall Goal
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-0">{{ $assessment->goal_text }}</p>
                    </div>
                </div>
                @endif

                {{-- Expected Outcomes --}}
                @if($assessment->goals->count() > 0)
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-transparent border-0 fw-semibold pt-3 pb-0">
                        <i class="fas fa-check-double text-success me-1"></i> Expected Outcomes
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            @foreach($assessment->goals as $goal)
                            <li class="d-flex align-items-start mb-2 small">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                {{ $goal->goal_text }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

            </div>

            {{-- Right Column --}}
            <div class="col-lg-8">

                {{-- Parameters (Baseline + Targets) --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 fw-semibold pt-3">
                        <i class="fas fa-sliders-h text-primary me-1"></i> Assessment Parameters
                    </div>
                    <div class="card-body p-0">
                        @if($assessment->parameters->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Parameter</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Baseline</th>
                                        <th class="text-center">Target</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assessment->parameters as $p)
                                    <tr>
                                        <td class="ps-4 fw-semibold small">{{ $p->parameter_label }}</td>
                                        <td class="text-center text-muted small">{{ $p->unit }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-2">{{ $p->baseline_value ?? '—' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success bg-opacity-10 text-success px-2">{{ $p->target_value ?? '—' }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted text-center py-3 small">No parameters recorded.</p>
                        @endif
                    </div>
                </div>

                {{-- Exercise Plan --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 fw-semibold pt-3">
                        <i class="fas fa-dumbbell text-warning me-1"></i> Exercise Plan
                        <span class="badge bg-warning bg-opacity-10 text-warning ms-2">{{ $assessment->exercises->count() }} exercises</span>
                    </div>
                    <div class="card-body p-0">
                        @if($assessment->exercises->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">#</th>
                                        <th>Exercise Name</th>
                                        <th class="text-center">Sets</th>
                                        <th class="text-center">Reps</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assessment->exercises as $idx => $ae)
                                    <tr>
                                        <td class="ps-4 text-muted small">{{ $idx + 1 }}</td>
                                        <td>
                                            <div class="fw-semibold small">{{ optional($ae->exercise)->name }}</div>
                                            <div class="text-muted" style="font-size:0.75rem;">{{ optional($ae->exercise)->category }}</div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-2">{{ $ae->sets }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info bg-opacity-10 text-info px-2">{{ $ae->reps }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted text-center py-3 small">No exercises added.</p>
                        @endif
                    </div>
                </div>

                {{-- Sessions --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-transparent border-0 fw-semibold pt-3">
                        <i class="fas fa-calendar-alt text-success me-1"></i> Session History
                        <span class="badge bg-success bg-opacity-10 text-success ms-2">{{ $completedSessions }} completed</span>
                        <span class="badge bg-warning bg-opacity-10 text-warning ms-1">{{ $scheduledSessions }} scheduled</span>
                    </div>
                    <div class="card-body p-0">
                        @if($assessment->sessions->count() > 0)
                        <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th class="ps-4">Session #</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th class="text-center">Status</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assessment->sessions->sortBy('session_number') as $s)
                                    <tr>
                                        <td class="ps-4 fw-semibold">Session {{ $s->session_number }}</td>
                                        <td class="small">{{ \Carbon\Carbon::parse($s->session_date)->format('d M Y') }}</td>
                                        <td class="text-muted small">
                                            {{ $s->session_time ? \Carbon\Carbon::parse($s->session_time)->format('h:i A') : '—' }}
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $sc = match($s->status) {
                                                    'completed' => 'success', 'scheduled' => 'primary',
                                                    'skipped' => 'warning', 'cancelled' => 'danger', default => 'secondary'
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $sc }} rounded-pill px-2">{{ ucfirst($s->status) }}</span>
                                        </td>
                                        <td class="text-muted small">{{ $s->notes ?? '—' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted text-center py-3 small">No sessions recorded.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
