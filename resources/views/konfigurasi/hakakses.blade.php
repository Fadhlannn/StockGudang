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
@endsection
