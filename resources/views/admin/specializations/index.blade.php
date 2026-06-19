@extends('admin.layouts.admin')

@section('content')

<div class="container">

    <h3 class="mb-3">Specializations</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    {{-- ADD SPECIALIZATION --}}
    <form method="POST" action="{{ route('admin.specializations.store') }}"  enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">

            <div class="col-md-4 mb-2">
                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Specialization Name"
                       required>
            </div>
            <div class="col-md-3 mb-2">
                <input type="file"
                    name="icon"
                    class="form-control">
            </div>

            <div class="col-md-6 mb-2">
                <textarea name="description" class="form-control" placeholder="Specialization Description"></textarea>
            </div>

            

            <div class="col-md-2">
                <button class="btn btn-primary w-100">
                    Add
                </button>
            </div>

        </div>
    </form>


    {{-- LIST --}}
    <table class="table table-bordered align-middle">

        <thead>
            <tr>
                <th>#</th>
                <th>Icon</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th >Actions</th>
            </tr>
        </thead>

        <tbody>

            @foreach($specializations as $item)

            <tr>

                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($item->icon)
                        <img src="{{ asset('images/specializations/'.$item->icon) }}"
                            width="60"
                            height="60"
                            style="object-fit:cover;border-radius:8px;">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>


                <td>{{ $item->name }}</td>

                <td class="w-50">{{ $item->description }}</td>

                <td>
                    <span class="badge {{ $item->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>

                <td>

                    {{-- UPDATE --}}
                    <form method="POST"
                          action="{{ route('admin.specializations.update',$item->id) }}"
                          enctype="multipart/form-data"
                          class="mb-2">

                        @csrf
                        @method('PUT')

                        <input type="text"
                               name="name"
                               value="{{ $item->name }}"
                               class="form-control mb-1">

                        @if($item->icon)
                            <img src="{{ asset('images/specializations/'.$item->icon) }}"
                                width="80"
                                class="mb-2 d-block">
                        @endif

                        <input type="file"
                            name="icon"
                            class="form-control mb-2">

                        <textarea name="description"
                                  class="form-control mb-1">{{ $item->description }}</textarea>

                        <select name="status" class="form-control mb-1">

                            <option value="active" {{ $item->status=='active'?'selected':'' }}>
                                Active
                            </option>

                            <option value="inactive" {{ $item->status=='inactive'?'selected':'' }}>
                                Inactive
                            </option>

                        </select>

                        <button class="btn btn-sm btn-warning w-100">
                            Update
                        </button>

                    </form>


                    {{-- DELETE --}}
                    <form method="POST"
                          action="{{ route('admin.specializations.destroy',$item->id) }}">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-danger w-100"
                                onclick="return confirm('Delete specialization?')">
                            Delete
                        </button>

                    </form>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection