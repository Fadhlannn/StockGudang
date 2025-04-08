@extends('layouts/app', ['activePage' => 'Menu', 'title' => 'Menu'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Menu</h3>
                                <p class="text-sm mb-0">
                                </p>
                            </div>
                            @php
                                use App\Models\RolePermission;
                            @endphp
                            @if (RolePermission::where('role_id', Auth::user()->role_id)
                                ->whereHas('permission', fn($q) => $q->where('name', 'create_menu'))
                                ->where('can_access', true)
                                ->exists())
                                <div class="col-4 text-right">
                                    <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#createrolemodal">Tambah Menu</a>
                                </div>
                            @endif
                        </div>
                        <form class="d-flex" role="search" method="GET" action="{{ route('index.menu') }}">
                            <input class="form-control me-2" type="search" name="search" placeholder="Cari Menu" aria-label="Search" value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </form>
                    </div>

                    <div class="col-12 mt-2">
                    </div>

                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>No</th>
                                <th>Name</th>
                                <th>Order</th>
                                <th>Url</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($menus as $menu)
                                <tr>
                                    <td>{{ ($menus->currentPage() - 1) * $menus->perPage() + $loop->iteration }}</td>
                                    <td>{{ $menu->name }}</td>
                                    <td>{{ $menu->order }}</td>
                                    <td>{{ $menu->url }}</td>
                                    <td>{{ $menu->category }}</td>
                                    <td>
                                        @if (RolePermission::where('role_id', Auth::user()->role_id)
                                            ->whereHas('permission', fn($q) => $q->where('name', 'delete_menu'))
                                            ->where('can_access', true)
                                            ->exists())
                                            <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" style="margin-right: 8px;" onclick="return confirm('Apakah Anda yakin ingin menghapus Menu ini?')">Delete</button>
                                            </form>
                                        @endif

                                        @if (RolePermission::where('role_id', Auth::user()->role_id)
                                            ->whereHas('permission', fn($q) => $q->where('name', 'edit_menu'))
                                            ->where('can_access', true)
                                            ->exists())
                                            <form action="{{ route('update.menu', $menu->id) }}" method="GET" style="display:inline;">
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editMenuModal{{ $menu->id }}">
                                                    Edit
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>


                                <div class="modal fade" id="editMenuModal{{ $menu->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Role</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('update.menu', $menu->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="form-group">
                                                        <label for="name">Menu</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ $menu->name }}" placeholder="Masukkan Nama">

                                                        <label for="url">URL</label>
                                                        <input type="text" class="form-control" id="url" name="url" value="{{ $menu->url }}" placeholder="Masukkan Guard">

                                                        <label for="category">Category</label>
                                                        <input type="text" class="form-control" id="category" name="category" value="{{ $menu->category  }}" placeholder="Masukkan Guard">
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
                            {{ $menus->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="modal fade" id="createrolemodal" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog modal-xl">
     <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createKategoriModalLabel">Tambah Menu</h5>
        </div>
            <div class="modal-body">
                        <form method="POST" action="{{route('store.menu')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan Name">
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <label for="url">url</label>
                                <input type="text" class="form-control" id="url" name="url" value="{{ old('url') }}" placeholder="Masukkan url">
                                @error('url')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <label for="category">category</label>
                                <input type="text" class="form-control" id="category" name="category" value="{{ old('category') }}" placeholder="Masukkan category">
                                @error('category')
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
