@extends('admin.layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold d-flex align-items-center">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#2260FF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="18" x2="12" y2="12"></line>
                        <line x1="9" y1="15" x2="15" y2="15"></line>
                    </svg>
                    Patient Documents
                </h1>
                <p class="text-muted small mb-0 mt-1">Browse, preview, and download medical reports, prescriptions, scans, and documents uploaded by patients.</p>
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
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255, 255, 255, 0.22); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
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
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255, 255, 255, 0.22); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white-50 small font-weight-bold text-uppercase">PDF Documents</div>
                            <div class="h2 mb-0 font-weight-bold mt-1">{{ number_format($pdfCount) }}</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255, 255, 255, 0.22); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <text x="6" y="17" font-size="7" font-weight="bold" fill="#ffffff" stroke="none" font-family="sans-serif">PDF</text>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white-50 small font-weight-bold text-uppercase">Image Files</div>
                            <div class="h2 mb-0 font-weight-bold mt-1">{{ number_format($imageCount) }}</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255, 255, 255, 0.22); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <form action="{{ route('admin.patient-documents.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-7">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </span>
                            <input type="text" name="search" class="form-control bg-light border-0" placeholder="Search by patient name, phone, email, or document title..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date" class="form-control bg-light border-0" value="{{ request('date') }}" title="Upload Date">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 rounded-3 d-flex align-items-center justify-content-center gap-1">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                            </svg>
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'date']))
                            <a href="{{ route('admin.patient-documents.index') }}" class="btn btn-light rounded-3 d-flex align-items-center justify-content-center" title="Reset Filters">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="23 4 23 10 17 10"></polyline>
                                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Documents Table Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-0 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 text-gray-800 font-weight-bold d-flex align-items-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                    Uploaded Documents Listing
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
                            <th>File Info</th>
                            <th>Uploaded Date</th>
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
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($isPdf)
                                            <span class="badge bg-danger text-white rounded px-2 py-1">PDF</span>
                                        @elseif($isImage)
                                            <span class="badge bg-success text-white rounded px-2 py-1">{{ strtoupper($doc->file_type) }}</span>
                                        @else
                                            <span class="badge bg-secondary text-white rounded px-2 py-1">{{ strtoupper($doc->file_type ?: 'FILE') }}</span>
                                        @endif
                                        <span class="small text-muted">{{ $doc->formatted_file_size }}</span>
                                    </div>
                                    <div class="small text-muted text-truncate mt-1" style="max-width: 220px;" title="{{ $doc->file_name }}">
                                        {{ $doc->file_name }}
                                    </div>
                                </td>
                                <td>
                                    <div class="small text-dark font-weight-bold">{{ $doc->created_at ? $doc->created_at->format('d M Y') : 'N/A' }}</div>
                                    <div class="small text-muted">{{ $doc->created_at ? $doc->created_at->format('h:i A') : '' }}</div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- Preview Button -->
                                        @if($isPdf || $isImage)
                                            <button type="button" class="btn btn-outline-primary d-inline-flex align-items-center"
                                                    title="Preview File"
                                                    onclick="openPreviewModal('{{ $previewUrl }}', '{{ addslashes($doc->title ?: $doc->file_name) }}', '{{ $doc->file_type }}', '{{ $downloadUrl }}')">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                                Preview
                                            </button>
                                        @else
                                            <a href="{{ $previewUrl }}" target="_blank" class="btn btn-outline-primary d-inline-flex align-items-center" title="Open File">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                    <polyline points="15 3 21 3 21 9"></polyline>
                                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                                </svg>
                                                Open
                                            </a>
                                        @endif

                                        <!-- Download Button -->
                                        <a href="{{ $downloadUrl }}" class="btn btn-outline-success d-inline-flex align-items-center" title="Download File">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                <line x1="12" y1="15" x2="12" y2="3"></line>
                                            </svg>
                                            Download
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.patient-documents.destroy', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this document?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger d-inline-flex align-items-center" title="Delete">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-3 d-block mx-auto opacity-50">
                                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                    <h5>No patient documents found</h5>
                                    <p class="small mb-0">Documents uploaded by patients will appear here.</p>
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
