@extends('admin.layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                    <i class="fas fa-clipboard-list text-primary me-2"></i> Patient Enquiries
                </h1>
                <p class="text-muted small mb-0">Manage and track session booking enquiries submitted by patients.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Stat Cards Grid -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #2260FF 0%, #4C8BFF 100%); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white-50 small font-weight-bold text-uppercase">Total Enquiries</div>
                            <div class="h2 mb-0 font-weight-bold mt-1">{{ number_format($totalEnquiries) }}</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255, 255, 255, 0.22); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white-50 small font-weight-bold text-uppercase">Pending</div>
                            <div class="h2 mb-0 font-weight-bold mt-1">{{ number_format($pendingEnquiries) }}</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255, 255, 255, 0.22); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #06b6d4 0%, #38bdf8 100%); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white-50 small font-weight-bold text-uppercase">Contacted</div>
                            <div class="h2 mb-0 font-weight-bold mt-1">{{ number_format($contactedEnquiries) }}</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255, 255, 255, 0.22); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #10b981 0%, #34d399 100%); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white-50 small font-weight-bold text-uppercase">Resolved</div>
                            <div class="h2 mb-0 font-weight-bold mt-1">{{ number_format($resolvedEnquiries) }}</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255, 255, 255, 0.22); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <form action="{{ route('admin.enquiries.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-0" placeholder="Search patient name, contact number, location, symptoms..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select bg-light border-0">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-3 px-4 flex-grow-1"><i class="fas fa-filter me-1"></i> Filter</button>
                        @if(request()->has('search') || request()->has('status'))
                            <a href="{{ route('admin.enquiries.index') }}" class="btn btn-outline-secondary rounded-3"><i class="fas fa-undo"></i> Reset</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Enquiries Table Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Patient Name</th>
                                <th>Contact Number</th>
                                <th>Symptoms</th>
                                <th>Location</th>
                                <th>Submitted Date</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enquiries as $enquiry)
                                <tr>
                                    <td class="ps-4 font-weight-bold text-muted">#{{ $enquiry->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary font-weight-bold d-flex align-items-center justify-content-center me-2" style="width: 38px; height: 38px; font-size: 14px;">
                                                {{ strtoupper(substr($enquiry->patient_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark">{{ $enquiry->patient_name }}</div>
                                                @if($enquiry->user_id)
                                                    <span class="badge bg-info bg-opacity-10 text-info small">Registered User</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="tel:{{ $enquiry->contact_number }}" class="text-primary font-weight-bold text-decoration-none">
                                            <i class="fas fa-phone-alt me-1 small"></i> {{ $enquiry->contact_number }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary bg-opacity-10 text-dark px-3 py-2 rounded-pill font-weight-bold">
                                            <i class="fas fa-stethoscope me-1 text-primary"></i> {{ $enquiry->symptoms ?? 'General' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted small">
                                            <i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ $enquiry->location ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="small text-dark">{{ $enquiry->created_at->format('d M Y') }}</div>
                                        <div class="small text-muted">{{ $enquiry->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.enquiries.updateStatus', $enquiry->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()"
                                                class="form-select form-select-sm border-0 fw-semibold rounded-3
                                                    @if($enquiry->status == 'pending')   bg-warning text-dark
                                                    @elseif($enquiry->status == 'contacted') bg-info text-white
                                                    @elseif($enquiry->status == 'resolved')  bg-success text-white
                                                    @else bg-danger text-white @endif"
                                                style="min-width: 130px; cursor: pointer;">
                                                <option value="pending"   {{ $enquiry->status == 'pending'   ? 'selected' : '' }}>Pending</option>
                                                <option value="contacted" {{ $enquiry->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                                <option value="resolved"  {{ $enquiry->status == 'resolved'  ? 'selected' : '' }}>Resolved</option>
                                                <option value="cancelled" {{ $enquiry->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('admin.enquiries.destroy', $enquiry->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this enquiry?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 text-light"></i>
                                        <div>No patient enquiries found.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($enquiries->hasPages())
                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-end">
                    {{ $enquiries->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
