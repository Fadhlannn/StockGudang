@extends('layouts/app', ['activePage' => 'hakakses', 'title' => 'Hak-Akses'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Hak Akses</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($roleData as $index => $data)
                            @if ($index % 3 == 0)
                                </div><div class="row">
                            @endif

                            <div class="col-md-4">
                                <div class="custom-card">
                                    <div class="total">Total {{ $data['role']->role }}: {{ $data['total_users'] }}</div>
                                    <!-- Button to open Modal -->
                                    <a href="#" data-toggle="modal" data-target="#editAccessModal{{ $data['role']->id }}">
                                        Edit Hak Akses
                                    </a>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="editAccessModal{{ $data['role']->id }}" tabindex="-1" role="dialog" aria-labelledby="editAccessModalLabel{{ $data['role']->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editAccessModalLabel{{ $data['role']->id }}">Edit Hak Akses untuk {{ $data['role']->role }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('update.access', ['role_id' => $data['role']->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                @foreach ($allMenus as $menu)
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="menus[]" value="{{ $menu->id }}"
                                                            {{ $data['editable_menus']->contains('menu_id', $menu->id) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="menu{{ $menu->id }}">{{ $menu->name }}</label>
                                                    </div>
                                                @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                            </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Users</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="#" class="btn btn-sm btn-default">Add user</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role->role ?? 'Tidak Ada Role' }}</td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
