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
                    @php
                        use App\Models\RolePermission;
                    @endphp

                    <!-- SWIPER CONTAINER -->
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($roleData as $data)
                                <div class="swiper-slide">
                                    <div class="custom-card">
                                        <div class="total">Total {{ $data['role']->role }}: {{ $data['total_users'] }}</div>
                                        <a href="#" data-toggle="modal" data-target="#editAccessModal{{ $data['role']->id }}">
                                            Edit Hak Akses
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Tombol Navigasi -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    <!-- Modal -->
                    @foreach ($roleData as $data)
                    <div class="modal fade" id="editAccessModal{{ $data['role']->id }}" tabindex="-1" role="dialog" aria-labelledby="editAccessModalLabel{{ $data['role']->id }}" aria-hidden="true">
                        <div class="modal-dialog" style="top: -20%;" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editAccessModalLabel{{ $data['role']->id }}">Edit Hak Akses untuk {{ $data['role']->role }}</h5>
                                </div>
                                <div class="modal-body">
                                    <!-- Form untuk update permissions dan menus -->
                                    <form action="{{ route('update.access', ['role_id' => $data['role']->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <!-- Bagian Menu -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pilih Menu:</label>
                                            @foreach ($allMenus as $menu)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input custom-checkbox" id="menu{{ $menu->id }}" name="menus[]" value="{{ $menu->id }}"
                                                        {{ $data['editable_menus']->contains('menu_id', $menu->id) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="menu{{ $menu->id }}">{{ $menu->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Bagian Permissions -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pilih Permissions:</label>
                                            @foreach ($allPermissions as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input custom-checkbox" id="permission{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}"
                                                        {{ in_array($permission->id, $data['editable_permissions']->pluck('permission_id')->toArray()) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permission{{ $permission->id }}">{{ $permission->name }}</label>
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
                    </div>
                    @endforeach

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Users</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#createusermodal">Add user</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>NO</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role->role ?? 'Tidak Ada Role' }}</td>
                                    <td>
                                        @if (RolePermission::where('role_id', Auth::user()->role_id)
                                        ->whereHas('permission', fn($q) => $q->where('name', 'delete_menu'))
                                        ->where('can_access', true)
                                        ->exists())
                                        <form action="{{ route('hakakses.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus role ini?')">Delete</button>
                                        </form>
                                        @endif
                                        <form action="{{ route('update.user', $user->id) }}" method="PUT" style="display:inline;">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edituserModal{{ $user->id }}">
                                                Edit
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <div class="modal fade" id="edituserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit user</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('update.user', $user->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" placeholder="Masukkan Name">
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


    <!-- Tambahkan Swiper.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <script>
            var swiper = new Swiper('.swiper-container', {
            slidesPerView: 3, // Tampilkan 2 kartu agar tidak terlalu besar
            spaceBetween: 10, // Kurangi jarak antar kartu
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                1024: { slidesPerView: 3 }, // Laptop/Desktop
                768: { slidesPerView: 1 }, // Tablet
                480: { slidesPerView: 1 }  // Mobile
            }
        });

    </script>


<div class="modal fade" id="createusermodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Tambah User</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('store.user') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama">
                        @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email">
                        @error('email')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                        @error('password')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select class="form-control" id="role_id" name="role_id">
                            <option value="">Pilih Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->role }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
