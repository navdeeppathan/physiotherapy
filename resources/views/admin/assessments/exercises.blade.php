@extends('admin.layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                    <i class="fas fa-dumbbell text-warning me-2"></i> Exercise Library
                </h1>
                <p class="text-muted small mb-0">Manage exercises used in patient treatment plans.</p>
            </div>
            <button class="btn btn-primary btn-sm rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#addExerciseModal">
                <i class="fas fa-plus me-1"></i> Add Exercise
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3" style="background:linear-gradient(135deg,#f7971e,#ffd200);color:#fff;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Total Exercises</div>
                            <div class="h3 mb-0 fw-bold">{{ $totalExercises }}</div>
                        </div>
                        <i class="fas fa-dumbbell fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3" style="background:linear-gradient(135deg,#11998e,#38ef7d);color:#fff;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Active</div>
                            <div class="h3 mb-0 fw-bold">{{ $activeExercises }}</div>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3" style="background:linear-gradient(135deg,#2260FF,#4C8BFF);color:#fff;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Conditions Covered</div>
                            <div class="h3 mb-0 fw-bold">{{ $conditions->count() }}</div>
                        </div>
                        <i class="fas fa-list fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('admin.exercises.index') }}" class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small text-muted fw-semibold">Search Exercise</label>
                        <input type="text" name="search" class="form-control form-control-sm rounded-3"
                               placeholder="Exercise name..." value="{{ request('search') }}">
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
                        <label class="form-label small text-muted fw-semibold">Category</label>
                        <select name="category" class="form-select form-select-sm rounded-3">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm rounded-3 w-100">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.exercises.index') }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Exercises Table --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width:60px;">Image</th>
                                <th>Exercise Name</th>
                                <th>Condition</th>
                                <th>Category</th>
                                <th class="text-center">Sets</th>
                                <th class="text-center">Reps</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($exercises as $ex)
                            <tr>
                                <td class="ps-4">
                                    @if($ex->image)
                                        <img src="{{ asset($ex->image) }}"
                                             alt="{{ $ex->name }}"
                                             class="rounded-3 object-fit-cover"
                                             style="width:46px;height:46px;object-fit:cover;">
                                    @else
                                        <div class="rounded-3 d-flex align-items-center justify-content-center bg-light"
                                             style="width:46px;height:46px;">
                                            <i class="fas fa-dumbbell text-muted" style="font-size:1.1rem;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $ex->name }}</div>
                                    @if($ex->description)
                                    <div class="text-muted small text-truncate" style="max-width:200px;">{{ $ex->description }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($ex->specialization)
                                        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-2 py-1 small">
                                            {{ $ex->specialization->name }}
                                        </span>
                                    @else
                                        <span class="text-muted small">General</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ ucfirst($ex->category ?? '—') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary fw-semibold px-2">{{ $ex->sets_default }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info bg-opacity-10 text-info fw-semibold px-2">{{ $ex->reps_default }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $ex->status === 'active' ? 'bg-success' : 'bg-danger' }} rounded-pill px-2 py-1">
                                        {{ ucfirst($ex->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <form action="{{ route('admin.exercises.toggle', $ex->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-outline-{{ $ex->status === 'active' ? 'warning' : 'success' }} btn-sm rounded-3 me-1"
                                                title="{{ $ex->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $ex->status === 'active' ? 'toggle-off' : 'toggle-on' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.exercises.destroy', $ex->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this exercise?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-3">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-dumbbell fa-2x mb-2 d-block opacity-25"></i>
                                    No exercises found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($exercises->hasPages())
                <div class="d-flex align-items-center justify-content-between px-4 py-3 border-top">
                    <div class="text-muted small">
                        Showing <strong>{{ $exercises->firstItem() }}</strong> to <strong>{{ $exercises->lastItem() }}</strong>
                        of <strong>{{ $exercises->total() }}</strong> exercises
                    </div>
                    <div>
                        {{ $exercises->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- Add Exercise Modal --}}
<div class="modal fade" id="addExerciseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-semibold">
                    <i class="fas fa-plus-circle text-primary me-2"></i>Add New Exercise
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.exercises.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Image Upload --}}
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Exercise Image</label>
                            <div class="d-flex align-items-center gap-3">
                                <div id="imagePreviewBox"
                                     class="rounded-3 border d-flex align-items-center justify-content-center overflow-hidden"
                                     style="width:80px;height:80px;background:#f8f9fa;">
                                    <i class="fas fa-image text-muted fa-2x" id="imagePlaceholderIcon"></i>
                                    <img id="imagePreview" src="#" alt="Preview"
                                         class="d-none rounded-3"
                                         style="width:80px;height:80px;object-fit:cover;">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="image" id="exerciseImageInput"
                                           class="form-control form-control-sm rounded-3"
                                           accept="image/jpeg,image/png,image/jpg,image/webp">
                                    <div class="text-muted" style="font-size:0.72rem;">JPG, PNG, WebP. Max 2MB.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label small fw-semibold">Exercise Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3"
                                   placeholder="e.g. Pelvic Tilt" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Category</label>
                            <input type="text" name="category" class="form-control rounded-3"
                                   placeholder="e.g. back, knee, shoulder">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Condition (Specialization)</label>
                            <select name="specialization_id" class="form-select rounded-3">
                                <option value="">General (All Conditions)</option>
                                @foreach($conditions as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Default Sets <span class="text-danger">*</span></label>
                            <input type="number" name="sets_default" class="form-control rounded-3"
                                   value="3" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Default Reps <span class="text-danger">*</span></label>
                            <input type="number" name="reps_default" class="form-control rounded-3"
                                   value="10" min="1" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Description</label>
                            <textarea name="description" class="form-control rounded-3" rows="2"
                                      placeholder="Brief description of the exercise..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-3 px-3"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm rounded-3 px-4">
                        <i class="fas fa-save me-1"></i> Save Exercise
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Image preview before upload
    document.getElementById('exerciseImageInput').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('imagePlaceholderIcon').classList.add('d-none');
                const preview = document.getElementById('imagePreview');
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
