@extends('admin.layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                    <i class="fas fa-file-medical text-primary me-2"></i> Patient Documents
                </h1>
                <p class="text-muted small mb-0">Browse, preview, and download medical reports, prescriptions, scans, and documents uploaded by patients.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Stat Cards Grid -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #2260FF 0%, #4C8BFF 100%); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white-50 small font-weight-bold text-uppercase">Total Documents</div>
                            <div class="h2 mb-0 font-weight-bold mt-1">{{ number_format($totalDocuments) }}</div>
                        </div>
                        <div class="rounded-3 p-3 bg-white bg-opacity-20">
                            <i class="fas fa-folder-open fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #10b981 0%, #34d399 100%); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white-50 small font-weight-bold text-uppercase">Uploaded Today</div>
                            <div class="h2 mb-0 font-weight-bold mt-1">{{ number_format($todayDocuments) }}</div>
                        </div>
                        <div class="rounded-3 p-3 bg-white bg-opacity-20">
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white-50 small font-weight-bold text-uppercase">Prescriptions</div>
                            <div class="h2 mb-0 font-weight-bold mt-1">{{ number_format($prescriptionCount) }}</div>
                        </div>
                        <div class="rounded-3 p-3 bg-white bg-opacity-20">
                            <i class="fas fa-prescription fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white-50 small font-weight-bold text-uppercase">Reports & Scans</div>
                            <div class="h2 mb-0 font-weight-bold mt-1">{{ number_format($reportCount) }}</div>
                        </div>
                        <div class="rounded-3 p-3 bg-white bg-opacity-20">
                            <i class="fas fa-x-ray fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <form action="{{ route('admin.patient-documents.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-0" placeholder="Search patient name, phone, document title..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="document_type" class="form-select bg-light border-0">
                            <option value="">All Document Types</option>
                            <option value="medical_report" {{ request('document_type') == 'medical_report' ? 'selected' : '' }}>Medical Report</option>
                            <option value="prescription" {{ request('document_type') == 'prescription' ? 'selected' : '' }}>Prescription</option>
                            <option value="mri_scan" {{ request('document_type') == 'mri_scan' ? 'selected' : '' }}>MRI Scan</option>
                            <option value="xray" {{ request('document_type') == 'xray' ? 'selected' : '' }}>X-Ray</option>
                            <option value="lab_report" {{ request('document_type') == 'lab_report' ? 'selected' : '' }}>Lab Report</option>
                            <option value="id_proof" {{ request('document_type') == 'id_proof' ? 'selected' : '' }}>ID Proof</option>
                            <option value="discharge_summary" {{ request('document_type') == 'discharge_summary' ? 'selected' : '' }}>Discharge Summary</option>
                            <option value="other" {{ request('document_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date" class="form-control bg-light border-0" value="{{ request('date') }}" title="Upload Date">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 rounded-3">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        @if(request()->hasAny(['search', 'document_type', 'date']))
                            <a href="{{ route('admin.patient-documents.index') }}" class="btn btn-light rounded-3" title="Reset Filters">
                                <i class="fas fa-redo"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Documents Table Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-0 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 text-gray-800 font-weight-bold">
                    <i class="fas fa-list text-muted me-2"></i> Uploaded Documents Listing
                </h5>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill font-weight-bold">
                    {{ $documents->total() }} Total Files
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Patient</th>
                            <th>Document Title</th>
                            <th>Type</th>
                            <th>File Info</th>
                            <th>Linked Doctor / Appt</th>
                            <th>Uploaded At</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                            @php
                                $isPdf = in_array(strtolower($doc->file_type), ['pdf']);
                                $isImage = in_array(strtolower($doc->file_type), ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                $previewUrl = route('admin.patient-documents.preview', $doc->id);
                                $downloadUrl = route('admin.patient-documents.download', $doc->id);

                                $typeBadgeColor = match($doc->document_type) {
                                    'prescription'      => 'bg-warning text-dark',
                                    'mri_scan', 'xray'  => 'bg-info text-dark',
                                    'lab_report'        => 'bg-primary text-white',
                                    'medical_report'    => 'bg-success text-white',
                                    'id_proof'          => 'bg-secondary text-white',
                                    default             => 'bg-light text-dark border'
                                };
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-2 text-white font-weight-bold"
                                             style="width: 38px; height: 38px; background: linear-gradient(135deg, #2260FF 0%, #4C8BFF 100%); font-size: 0.85rem;">
                                            {{ strtoupper(substr(optional($doc->patient)->name ?? 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark">{{ optional($doc->patient)->name ?? 'Unknown Patient' }}</div>
                                            <div class="small text-muted">{{ optional($doc->patient)->phone_number ?? optional($doc->patient)->email ?? 'ID: #'.$doc->patient_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $doc->title ?: ($doc->file_name ?: 'Untitled Document') }}</div>
                                    @if($doc->description)
                                        <div class="small text-muted text-truncate" style="max-width: 260px;" title="{{ $doc->description }}">{{ $doc->description }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $typeBadgeColor }} px-2 py-1 rounded-pill text-capitalize">
                                        {{ str_replace('_', ' ', $doc->document_type) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($isPdf)
                                            <span class="badge bg-danger text-white rounded px-2 py-1"><i class="fas fa-file-pdf me-1"></i> PDF</span>
                                        @elseif($isImage)
                                            <span class="badge bg-success text-white rounded px-2 py-1"><i class="fas fa-file-image me-1"></i> {{ strtoupper($doc->file_type) }}</span>
                                        @else
                                            <span class="badge bg-secondary text-white rounded px-2 py-1"><i class="fas fa-file me-1"></i> {{ strtoupper($doc->file_type ?: 'FILE') }}</span>
                                        @endif
                                        <span class="small text-muted">{{ $doc->formatted_file_size }}</span>
                                    </div>
                                    <div class="small text-muted text-truncate mt-1" style="max-width: 180px;" title="{{ $doc->file_name }}">
                                        {{ $doc->file_name }}
                                    </div>
                                </td>
                                <td>
                                    @if($doc->doctor)
                                        <div class="small text-dark font-weight-bold">
                                            <i class="fas fa-user-md text-primary me-1"></i> Dr. {{ $doc->doctor->name }}
                                        </div>
                                    @endif
                                    @if($doc->appointment_id)
                                        <div class="small text-muted">
                                            <i class="fas fa-calendar-check text-muted me-1"></i> Appt #{{ $doc->appointment_id }}
                                        </div>
                                    @endif
                                    @if(!$doc->doctor && !$doc->appointment_id)
                                        <span class="small text-muted fst-italic">Direct Upload</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small text-dark">{{ $doc->created_at ? $doc->created_at->format('d M Y') : 'N/A' }}</div>
                                    <div class="small text-muted">{{ $doc->created_at ? $doc->created_at->format('h:i A') : '' }}</div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- Preview Button -->
                                        @if($isPdf || $isImage)
                                            <button type="button" class="btn btn-outline-primary"
                                                    title="Preview File"
                                                    onclick="openPreviewModal('{{ $previewUrl }}', '{{ addslashes($doc->title ?: $doc->file_name) }}', '{{ $doc->file_type }}', '{{ $downloadUrl }}')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        @else
                                            <a href="{{ $previewUrl }}" target="_blank" class="btn btn-outline-primary" title="Open File">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @endif

                                        <!-- Download Button -->
                                        <a href="{{ $downloadUrl }}" class="btn btn-outline-success" title="Download File">
                                            <i class="fas fa-download"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.patient-documents.destroy', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to permanently delete this document?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3 d-block text-secondary opacity-50"></i>
                                    <h5>No patient documents found</h5>
                                    <p class="small mb-0">Documents uploaded by patients or assigned doctors will appear here.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($documents->hasPages())
                <div class="card-footer bg-white py-3 border-0">
                    <div class="d-flex justify-content-center">
                        {{ $documents->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>

<!-- Document Preview Modal -->
<div class="modal fade" id="documentPreviewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-file-medical text-primary fs-5"></i>
                    <div>
                        <h5 class="modal-title font-weight-bold mb-0 text-dark" id="previewModalTitle">Document Preview</h5>
                        <small class="text-muted" id="previewModalSubtitle"></small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="#" id="modalDownloadBtn" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        <i class="fas fa-download me-1"></i> Download
                    </a>
                    <a href="#" id="modalExternalBtn" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        <i class="fas fa-external-link-alt me-1"></i> New Tab
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-0 d-flex justify-content-center align-items-center bg-light" style="min-height: 550px;">
                <div id="previewSpinner" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading preview...</span>
                    </div>
                    <div class="small text-muted mt-2">Loading document preview...</div>
                </div>

                <!-- PDF Viewer -->
                <iframe id="pdfFrame" src="" class="w-100 border-0 d-none" style="height: 75vh;"></iframe>

                <!-- Image Viewer -->
                <div id="imageContainer" class="p-3 text-center d-none" style="max-height: 75vh; overflow: auto;">
                    <img id="imagePreview" src="" class="img-fluid rounded shadow-sm" style="max-height: 70vh; object-fit: contain;" alt="Preview">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openPreviewModal(previewUrl, title, fileType, downloadUrl) {
    document.getElementById('previewModalTitle').innerText = title || 'Document Preview';
    document.getElementById('previewModalSubtitle').innerText = (fileType ? fileType.toUpperCase() : 'FILE') + ' • Preview';
    document.getElementById('modalDownloadBtn').href = downloadUrl;
    document.getElementById('modalExternalBtn').href = previewUrl;

    const spinner = document.getElementById('previewSpinner');
    const pdfFrame = document.getElementById('pdfFrame');
    const imageContainer = document.getElementById('imageContainer');
    const imagePreview = document.getElementById('imagePreview');

    // Reset displays
    spinner.classList.remove('d-none');
    pdfFrame.classList.add('d-none');
    imageContainer.classList.add('d-none');
    pdfFrame.src = '';
    imagePreview.src = '';

    const lowerType = (fileType || '').toLowerCase();

    if (lowerType === 'pdf') {
        pdfFrame.src = previewUrl;
        pdfFrame.onload = function() {
            spinner.classList.add('d-none');
            pdfFrame.classList.remove('d-none');
        };
    } else {
        imagePreview.src = previewUrl;
        imagePreview.onload = function() {
            spinner.classList.add('d-none');
            imageContainer.classList.remove('d-none');
        };
        imagePreview.onerror = function() {
            spinner.classList.add('d-none');
            window.open(previewUrl, '_blank');
        };
    }

    const modal = new bootstrap.Modal(document.getElementById('documentPreviewModal'));
    modal.show();
}

// Cleanup modal iframe when closed
document.getElementById('documentPreviewModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('pdfFrame').src = '';
    document.getElementById('imagePreview').src = '';
});
</script>
@endsection
