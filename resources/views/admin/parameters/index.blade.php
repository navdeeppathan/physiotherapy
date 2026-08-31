@extends('admin.layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                    <i class="fas fa-sliders-h text-primary me-2"></i> Assessment Parameters
                </h1>
                <p class="text-muted small mb-0">Manage trackable clinical parameters and baseline metrics for patient assessments.</p>
            </div>
            <button class="btn btn-primary btn-sm rounded-3 px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#addParameterModal">
                <i class="fas fa-plus me-1"></i> Add Parameter
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3" style="background: linear-gradient(135deg, #2260FF 0%, #4C8BFF 100%); color: #fff;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Total Parameters</div>
                            <div class="h2 mb-0 fw-bold">{{ $totalParameters }}</div>
                        </div>
                        <div class="rounded-3 p-3 bg-white bg-opacity-20">
                            <i class="fas fa-sliders-h fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: #fff;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Active Parameters</div>
                            <div class="h2 mb-0 fw-bold">{{ $activeParameters }}</div>
                        </div>
                        <div class="rounded-3 p-3 bg-white bg-opacity-20">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('admin.parameters.index') }}" class="row g-2 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label small text-muted fw-semibold">Search Parameter</label>
                        <input type="text" name="search" class="form-control form-control-sm rounded-3"
                               placeholder="Label, key (slug), or unit..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-semibold">Status</label>
                        <select name="status" class="form-select form-select-sm rounded-3">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm rounded-3 w-100">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.parameters.index') }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Parameters Table --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width:70px;">Icon</th>
                                <th>Parameter Label</th>
                                <th>Key (Slug)</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Order</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($parameters as $param)
                            <tr>
                                <td class="ps-4">
                                    <div class="rounded-3 p-1 d-flex align-items-center justify-content-center border"
                                         style="width:44px;height:44px;background:#f4fbfb;">
                                        @if($param->icon_url)
                                            <img src="{{ $param->icon_url }}" alt="{{ $param->label }}"
                                                 style="width:32px;height:32px;object-fit:contain;">
                                        @else
                                            <i class="fas fa-heartbeat text-teal" style="font-size:1.2rem;color:#0E8A8A;"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $param->label }}</div>
                                    @if($param->description)
                                        <div class="text-muted small text-truncate" style="max-width:260px;">{{ $param->description }}</div>
                                    @endif
                                </td>
                                <td>
                                    <code class="bg-light text-primary px-2 py-1 rounded small">{{ $param->key }}</code>
                                </td>
                                <td class="text-center">
                                    @if($param->unit)
                                        <span class="badge bg-secondary bg-opacity-10 text-dark px-2 py-1">{{ $param->unit }}</span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td class="text-center text-muted fw-semibold">
                                    {{ $param->sort_order }}
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $param->status === 'active' ? 'bg-success' : 'bg-danger' }} rounded-pill px-2 py-1">
                                        {{ ucfirst($param->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-outline-primary btn-sm rounded-3 me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editParameterModal{{ $param->id }}"
                                            title="Edit Parameter">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('admin.parameters.toggle', $param->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-outline-{{ $param->status === 'active' ? 'warning' : 'success' }} btn-sm rounded-3 me-1"
                                                title="{{ $param->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $param->status === 'active' ? 'toggle-off' : 'toggle-on' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.parameters.destroy', $param->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete parameter: {{ $param->label }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-3" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Edit Parameter Modal --}}
                            <div class="modal fade" id="editParameterModal{{ $param->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-semibold">
                                                <i class="fas fa-edit text-primary me-2"></i>Edit Parameter
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.parameters.update', $param->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    {{-- Current Icon & Upload --}}
                                                    <div class="col-12">
                                                        <label class="form-label small fw-semibold">Icon</label>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="rounded-3 border p-1 d-flex align-items-center justify-content-center bg-light"
                                                                 style="width:50px;height:50px;">
                                                                @if($param->icon_url)
                                                                    <img src="{{ $param->icon_url }}" alt="{{ $param->label }}" style="width:36px;height:36px;object-fit:contain;">
                                                                @else
                                                                    <i class="fas fa-image text-muted"></i>
                                                                @endif
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <input type="file" name="icon" class="form-control form-control-sm rounded-3"
                                                                       accept="image/svg+xml,image/png,image/jpeg,image/webp">
                                                                <div class="text-muted" style="font-size:0.72rem;">Upload new SVG, PNG or JPG to change.</div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label small fw-semibold">Parameter Label <span class="text-danger">*</span></label>
                                                        <input type="text" name="label" class="form-control rounded-3"
                                                               value="{{ $param->label }}" required>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-semibold">Unit</label>
                                                        <input type="text" name="unit" class="form-control rounded-3"
                                                               placeholder="e.g. score, °, min, %, grade" value="{{ $param->unit }}">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-semibold">Sort Order</label>
                                                        <input type="number" name="sort_order" class="form-control rounded-3"
                                                               value="{{ $param->sort_order }}">
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label small fw-semibold">Status</label>
                                                        <select name="status" class="form-select rounded-3">
                                                            <option value="active" {{ $param->status === 'active' ? 'selected' : '' }}>Active</option>
                                                            <option value="inactive" {{ $param->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label small fw-semibold">Description</label>
                                                        <textarea name="description" class="form-control rounded-3" rows="2"
                                                                  placeholder="Clinical notes or description...">{{ $param->description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-3 px-3"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary btn-sm rounded-3 px-4">
                                                    <i class="fas fa-save me-1"></i> Save Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-sliders-h fa-3x mb-3 text-light"></i>
                                    <div>No parameters found. Click "Add Parameter" above to create one.</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($parameters->hasPages())
                <div class="d-flex align-items-center justify-content-between px-4 py-3 border-top">
                    <div class="text-muted small">
                        Showing <strong>{{ $parameters->firstItem() }}</strong> to <strong>{{ $parameters->lastItem() }}</strong>
                        of <strong>{{ $parameters->total() }}</strong> parameters
                    </div>
                    <div>
                        {{ $parameters->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- Add Parameter Modal --}}
<div class="modal fade" id="addParameterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-semibold">
                    <i class="fas fa-plus-circle text-primary me-2"></i>Add New Parameter
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.parameters.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Icon Upload & Preview --}}
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Parameter Icon</label>
                            <div class="d-flex align-items-center gap-3">
                                <div id="paramIconPreviewBox"
                                     class="rounded-3 border d-flex align-items-center justify-content-center overflow-hidden bg-light"
                                     style="width:50px;height:50px;">
                                    <i class="fas fa-image text-muted" id="paramIconPlaceholder"></i>
                                    <img id="paramIconPreview" src="#" alt="Preview"
                                         class="d-none"
                                         style="width:40px;height:40px;object-fit:contain;">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="icon" id="paramIconInput"
                                           class="form-control form-control-sm rounded-3"
                                           accept="image/svg+xml,image/png,image/jpeg,image/webp">
                                    <div class="text-muted" style="font-size:0.72rem;">SVG, PNG, JPG. Max 2MB.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-semibold">Parameter Label <span class="text-danger">*</span></label>
                            <input type="text" name="label" class="form-control rounded-3"
                                   placeholder="e.g. Lumbar Flexion (°)" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Key (Slug, optional)</label>
                            <input type="text" name="key" class="form-control rounded-3"
                                   placeholder="e.g. lumbar_flexion">
                            <div class="text-muted" style="font-size:0.72rem;">Auto-generated from label if left blank.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Unit</label>
                            <input type="text" name="unit" class="form-control rounded-3"
                                   placeholder="e.g. score, °, min, %, grade">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control rounded-3" value="0">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-semibold">Description</label>
                            <textarea name="description" class="form-control rounded-3" rows="2"
                                      placeholder="Brief clinical description or notes..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-3 px-3"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm rounded-3 px-4">
                        <i class="fas fa-save me-1"></i> Save Parameter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Live preview for icon upload
    const paramIconInput = document.getElementById('paramIconInput');
    if (paramIconInput) {
        paramIconInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('paramIconPlaceholder').classList.add('d-none');
                    const preview = document.getElementById('paramIconPreview');
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });
    }
</script>
@endsection
