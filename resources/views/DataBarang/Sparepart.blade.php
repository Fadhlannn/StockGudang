@extends('layouts.app', ['activePage' => 'Sparepart', 'title' => 'Sparepart'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Sparepart Data</h3>
                                <p class="text-sm mb-0">
                                </p>
                            </div>
                            @php
                                use App\Models\RolePermission;
                            @endphp
                            @if (RolePermission::where('role_id', Auth::user()->role_id)
                                ->whereHas('permission', fn($q) => $q->where('name', 'create_spt'))
                                ->where('can_access', true)
                                ->exists())
                                <div class="col-4 text-right">
                                    <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#createrolemodal">Tambah Sparepart</a>
                                </div>
                            @endif

                        </div>
                        <form class="d-flex" role="search" method="GET" action="{{ route('Sparepart') }}">
                            <input class="form-control me-2" type="search" name="search" placeholder="Cari Katalog" aria-label="Search" value="{{ request('search') }}">
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
                                <tr>
                                    <th>No</th>
                                    <th>No barang</th>
                                    <th>Nama Sparepart</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Satuan</th>
                                    <th>keterangan part</th>
                                    <th>Action</th>
                                </tr>
                        </thead>
                        <tbody>

                            @foreach ($spareparts as $sparepart)
                                <tr>
                                    <td>{{ ($spareparts->currentPage() - 1) * $spareparts->perPage() + $loop->iteration }}</td>
                                    <td>{{ $sparepart->no_barang }}</td>
                                    <td>{{ $sparepart->name }}</td>
                                    <td>{{ $sparepart->kategory }}</td>
                                    <td>{{ $sparepart->harga }}</td>
                                    <td>{{ $sparepart->satuan }}</td>
                                    <td>{{ $sparepart->keterangan_part }}</td>
                                    <td>
                                        @if (RolePermission::where('role_id', Auth::user()->role_id)
                                            ->whereHas('permission', fn($q) => $q->where('name', 'delete_spt'))
                                            ->where('can_access', true)
                                            ->exists())
                                            <form action="{{ route('sparepart.destroy', $sparepart->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" style="margin-right: 8px;" onclick="return confirm('Apakah Anda yakin ingin menghapus Menu ini?')">Delete</button>
                                            </form>
                                        @endif

                                        @if (RolePermission::where('role_id', Auth::user()->role_id)
                                            ->whereHas('permission', fn($q) => $q->where('name', 'edit_spt'))
                                            ->where('can_access', true)
                                            ->exists())
                                            <form action="{{ route('update.sparepart', $sparepart->id) }}" method="GET" style="display:inline;">
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editMenuModal{{ $sparepart->id }}">
                                                    Edit
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="editMenuModal{{ $sparepart->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Sparepart</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('update.sparepart', $sparepart->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="form-group">
                                                        <label for="no_barang">No Barang</label>
                                                        <input type="text" class="form-control" id="no_barang" name="no_barang" value="{{ $sparepart->no_barang }}" placeholder="Masukkan No Barang">

                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ $sparepart->name }}" placeholder="Masukkan Nama">

                                                        <label for="kategory">Kategori</label>
                                                        <input type="text" class="form-control" id="kategory" name="kategory" value="{{ $sparepart->kategory }}" placeholder="Masukkan Kategori">

                                                        <label for="harga">Harga</label>
                                                        <input type="text" class="form-control" id="harga" name="harga" value="{{ $sparepart->harga }}" placeholder="Masukkan Harga">

                                                        <label for="satuan">Satuan</label>
                                                        <input type="text" class="form-control" id="satuan" name="satuan" value="{{ $sparepart->satuan }}" placeholder="Masukkan Satuan">

                                                        <label for="keterangan_part">Keterangan Part</label>
                                                        <input type="text" class="form-control" id="keterangan_part" name="keterangan_part" value="{{ $sparepart->keterangan_part }}" placeholder="Masukkan Keterangan">
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
                            {{ $spareparts->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="modal fade" id="createrolemodal" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog modal-xl" style="top: -25%">
     <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createKategoriModalLabel">Tambah sparepart</h5>
        </div>
            <div class="modal-body">
                        <form method="POST" action="{{route('store.sparepart')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="no_barang">no_barang</label>
                                <input type="text" class="form-control" id="no_barang" name="no_barang" value="{{ old('no_barang') }}" placeholder="Masukkan No barang">
                                @error('no_barang')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <label for="name">name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan Name">
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <label for="kategory">kategory</label>
                                <input type="text" class="form-control" id="kategory" name="kategory" value="{{ old('kategory') }}" placeholder="Masukkan kategory">
                                @error('kategory')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <label for="harga">harga</label>
                                <input type="text" class="form-control" id="harga" name="harga" value="{{ old('harga') }}" placeholder="Masukkan harga">
                                @error('harga')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <label for="satuan">satuan</label>
                                <input type="text" class="form-control" id="satuan" name="satuan" value="{{ old('satuan') }}" placeholder="Masukkan satuan">
                                @error('satuan')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <label for="keterangan_part">keterangan_part</label>
                                <input type="text" class="form-control" id="keterangan_part" name="keterangan_part" value="{{ old('keterangan_part') }}" placeholder="Masukkan keterangan">
                                @error('keterangan_part')
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


@push('scripts')
<script>
    $(document).ready(function() {
        $('#sparepartTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    });
</script>
@endpush
