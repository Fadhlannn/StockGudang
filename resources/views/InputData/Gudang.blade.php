@extends('layouts.app', ['activePage' => 'Gudang', 'title' => 'Gudang'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Gudang atau Pool Data</h3>
                                <p class="text-sm mb-0">
                                </p>
                            </div>
                            {{-- @php
                                use App\Models\RolePermission;
                            @endphp
                            @if (RolePermission::where('role_id', Auth::user()->role_id)
                                ->whereHas('permission', fn($q) => $q->where('name', 'create_spt'))
                                ->where('can_access', true)
                                ->exists()) --}}
                                <div class="col-4 text-right">
                                    <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#createGudangmodal">Tambah Gudang Atau Pool</a>
                                </div>
                            {{-- @endif --}}

                        </div>
                        {{-- <form class="d-flex" role="search" method="GET" action="{{ route('Sparepart') }}">
                            <input class="form-control me-2" type="search" name="search" placeholder="Cari Katalog" aria-label="Search" value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </form> --}}
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
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Action</th>
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($gudang as $g)
                                <tr>
                                    <td>{{ ($gudang->currentPage() - 1) * $gudang->perPage() + $loop->iteration }}</td>
                                    <td>{{ $g->nama_gudang }}</td>
                                    <td>{{ $g->lokasi }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editGudangModal{{ $g->id }}">
                                            Edit
                                        </button>
                                         <form action="{{ route('gudang.destroy', $g->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editGudangModal{{ $g->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('gudang.update', $g->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Suplier</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" class="form-control" name="nama_gudang" value="{{ $g->nama_gudang }}" required>

                                                        <label class="mt-2">Alamat</label>
                                                        <textarea class="form-control" name="lokasi" required>{{ $g->lokasi }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-4">
                            {{ $gudang->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <!-- Modal Tambah Suplier -->
<div class="modal fade" id="createGudangmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('gudang.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah gudang</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama_gudang" required>

                        <label class="mt-2">Lokasi</label>
                        <textarea class="form-control" name="lokasi" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
