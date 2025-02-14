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
                            <div class="col-4 text-right">
                                <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#createrolemodal">Tambah Menu</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                                                                            </div>

                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr><th>Name</th>
                                <th>Order</th>
                                <th>Url</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $menu)
                                <tr>
                                    <td>{{ $menu->name }}</td>
                                    <td>{{ $menu->order }}</td>
                                    <td>{{ $menu->url }}</td>
                                    <td>{{ $menu->category }}</td>
                                    <td>
                                        <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus Menu ini?')">Delete</button>
                                        </form>
                                        <form action="{{ route('update.menu', $menu->id) }}" method="GET" style="display:inline;">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editMenuModal{{ $menu->id }}">
                                                Edit
                                            </button>
                                        </form>
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
