@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">All Users</h5>
        </div>

        <div class="card-body">

            <!-- 🔎 Filter Section -->
            <form method="GET" class="row g-3 mb-3">

                <div class="col-md-4">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Search name or email"
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                        <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
                        <option value="blocked" {{ request('status')=='blocked'?'selected':'' }}>Blocked</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Filter
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100">
                        Reset
                    </a>
                </div>

            </form>

            <!-- 📋 Table -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>role</th>
                            <th>Status</th>
                            <th>Doctor Fee</th>
                            <th>Admin Fee</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $key => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $key }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    @if($user->status == 'blocked')
                                        <span class="badge bg-danger">Blocked</span>
                                    @else
                                    <label class="switch">
                                        <input type="checkbox" 
                                               class="toggle-status"
                                               data-id="{{ $user->id }}"
                                               {{ $user->status == 'active' ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>{{ $user->fee->doctor_fee ?? '-' }}</td>
                                <td>{{ $user->fee->admin_fee ?? '-' }}</td>
                                <td>{{ $user->fee->total_fee ?? '-' }}</td>
                                <td>
                                    @if($user->role == 'doctor')
                                    <button class="btn btn-sm btn-primary open-fee-modal"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}">
                                        Set Fee
                                    </button>
                                    @else
                                    {{-- <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-primary">
                                        View
                                    </a> --}}
                                    <div>
                                        -
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No Users Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 📄 Pagination -->
            <div class="mt-3">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</div>

<!-- Fee Modal -->
<div class="modal fade" id="feeModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Set Appointment Fee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="feeForm">
            <input type="hidden" name="doctor_id" id="doctor_id">

            <div class="mb-3">
                <label>Doctor Fee</label>
                <input type="number" name="doctor_fee" id="doctor_fee" class="form-control">
            </div>

            <div class="mb-3">
                <label>Admin Fee</label>
                <input type="number" name="admin_fee" id="admin_fee" class="form-control">
            </div>

            <button type="submit" class="btn btn-success w-100">
                Save Fee
            </button>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    let modal = new bootstrap.Modal(document.getElementById('feeModal'));

    document.querySelectorAll('.open-fee-modal').forEach(btn => {

        btn.addEventListener('click', function(){

            let userId = this.dataset.id;

            document.getElementById('doctor_id').value = userId;

            // 🔥 Load existing fee
            fetch(`/admin/fees/${userId}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('doctor_fee').value = data.data?.doctor_fee || '';
                    document.getElementById('admin_fee').value = data.data?.admin_fee || '';
                });

            modal.show();
        });
    });

    // ✅ Submit form
    document.getElementById('feeForm').addEventListener('submit', function(e){
        e.preventDefault();

        let formData = new FormData(this);

        fetch("{{ route('admin.fees.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {

            if(data.success){
                Swal.fire({
                    icon: 'success',
                    title: 'Saved!',
                    text: data.message
                }).then(() => {
                    location.reload(); // refresh table
                });
            }
        });
    });

});
</script>
@endsection




<style>
    /* Toggle Switch Design */
    .switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
    }

    .switch input { 
    opacity: 0;
    width: 0;
    height: 0;
    }

    .slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
    }

    input:checked + .slider {
    background-color: #2260FF;
    }

    input:checked + .slider:before {
    transform: translateX(24px);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll('.toggle-status').forEach(function(toggle){

        toggle.addEventListener('change', function(){

            let userId = this.dataset.id;
            let checkbox = this;

            fetch(`/admin/users/toggle-status/${userId}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {

                if(data.success){

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.status === 'active' 
                               ? 'User Activated Successfully'
                               : 'User Deactivated Successfully',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true
                    });

                } else {
                    checkbox.checked = !checkbox.checked;
                }

            })
            .catch(error => {
                checkbox.checked = !checkbox.checked;

                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong!',
                    text: 'Please try again.'
                });
            });

        });

    });

});
</script>
