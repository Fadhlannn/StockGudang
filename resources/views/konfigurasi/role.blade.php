@extends('layouts/app', ['activePage' => 'Role', 'title' => 'Role'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card strpied-tabled-with-hover">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Role</h4>
                            @php
                                use App\Models\RolePermission;
                            @endphp

                            @if (RolePermission::where('role_id', Auth::user()->role_id)
                            ->whereHas('permission', fn($q) => $q->where('name', 'create_role'))
                            ->where('can_access', true)
                            ->exists())
                                <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#createrolemodal">Tambah Role</a>
                            @endif
                        </div>
                        <form class="d-flex" role="search" method="GET" action="{{ route('index.role') }}">
                            <input class="form-control me-2" type="search" name="search" placeholder="Cari Role" aria-label="Search" value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </form>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Guard Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $roles as $role )
                                    <tr>
                                        <td>
                                            {{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}
                                        </td>
                                        <td>
                                            {{$role->role}}
                                        </td>
                                        <td>
                                            {{$role->Guard_Name}}
                                        </td>
                                        <td>
                                        @if (RolePermission::where('role_id', Auth::user()->role_id)
                                        ->whereHas('permission', fn($q) => $q->where('name', 'delete_role'))
                                        ->where('can_access', true)
                                        ->exists())
                                            <form action="{{ route('role.destroy', $role->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" style="margin-right: 8px;" onclick="return confirm('Apakah Anda yakin ingin menghapus role ini?')">Delete</button>
                                            </form>
                                        @endif
                                        @if (RolePermission::where('role_id', Auth::user()->role_id)
                                        ->whereHas('permission', fn($q) => $q->where('name', 'edit_role'))
                                        ->where('can_access', true)
                                        ->exists())
                                            <form action="{{ route('update.role', $role->id) }}" method="GET" style="display:inline;">
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editRoleModal{{ $role->id }}">
                                                    Edit
                                                </button>
                                            </form>
                                        @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Role</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('update.role', $role->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="form-group">
                                                            <label for="role">Role</label>
                                                            <input type="text" class="form-control" id="role" name="role" value="{{ $role->role }}" placeholder="Masukkan Role">

                                                            <label for="guard_name">Guard_Name</label>
                                                            <input type="text" class="form-control" id="guard_name" name="Guard_Name" value="{{ $role->Guard_Name }}" placeholder="Masukkan Guard">
                                                        </div>

                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-4">
                                {{ $roles->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createrolemodal" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createKategoriModalLabel">Tambah Role</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('store.role')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="role">Role</label>
                            <input type="text" class="form-control" id="role" name="role" value="{{ old('role') }}" placeholder="Masukkan Role">
                            @error('role')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <label for="guard_name">Guard_Name</label>
                            <input type="text" class="form-control" id="guard_name" name="Guard_Name" value="{{ old('Guard_Name') }}" placeholder="Masukkan Guard">
                            @error('Guard_Name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Buat</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
