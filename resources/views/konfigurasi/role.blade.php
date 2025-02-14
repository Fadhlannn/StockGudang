@extends('layouts/app', ['activePage' => 'Role', 'title' => 'Role'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card strpied-tabled-with-hover">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Role</h4>
                                <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#createrolemodal">Tambah Role</a>
                        </div>
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
                                            {{$loop->iteration}}
                                        </td>
                                        <td>
                                            {{$role->role}}
                                        </td>
                                        <td>
                                            {{$role->Guard_Name}}
                                        </td>
                                        <td>
                                            <form action="{{ route('role.destroy', $role->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus role ini?')">Delete</button>
                                            </form>
                                            <form action="{{ route('update.role', $role->id) }}" method="GET" style="display:inline;">
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editRoleModal{{ $role->id }}">
                                                    Edit
                                                </button>
                                            </form>
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
