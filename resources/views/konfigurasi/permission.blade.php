@extends('layouts/app', ['activePage' => 'permission', 'title' => 'Permission'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card strpied-tabled-with-hover">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Permission</h4>
                                <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#createpermissionmodal">Tambah Permission</a>
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $permissions as $permission )
                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>
                                            {{$permission->name}}
                                        </td>

                                        <td>
                                            <form action="{{ route('permission.destroy', $permission->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus permission ini?')">Delete</button>
                                            </form>
                                            <form action="{{ route('update.permission', $permission->id) }}" method="GET" style="display:inline;">
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editPermissionModal{{ $permission->id }}">
                                                    Edit
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editPermissionModal{{ $permission->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit permission</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('update.permission', $permission->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="form-group">
                                                            <label for="name">Name</label>
                                                            <input type="text" class="form-control" id="name" name="name" value="{{ $permission->name }}" placeholder="Masukkan Name">
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
    <div class="modal fade" id="createpermissionmodal" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createKategoriModalLabel">Tambah Role</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('store.permission')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="role" name="role" value="{{ old('name') }}" placeholder="Masukkan Name">
                            @error('name')
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
