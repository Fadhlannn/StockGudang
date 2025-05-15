@extends('layouts.app', ['activePage' => 'Mekanik', 'title' => 'Mekanik'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Mekanik Data</h3>
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
                                    <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#createMekanikmodal">Tambah Mekanik</a>
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
                                    <th>NIP</th>
                                    <th>Nomor HP</th>
                                    <th>Alamat</th>
                                    <th>Gudang</th>
                                    <th>Action</th>
                                </tr>
                        </thead>
                        <tbody>

                            @foreach ($mekanik as $k)
                                <tr>
                                    <td>{{ ($mekanik->currentPage() - 1) * $mekanik->perPage() + $loop->iteration }}</td>
                                    <td>{{ $k->nama }}</td>
                                    <td>{{ $k->nip }}</td>
                                    <td>{{ $k->no_hp }}</td>
                                    <td>{{ $k->alamat }}</td>
                                    <td>{{ $k->gudang->nama_gudang }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editMekanikModal{{ $k->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('mekanik.destroy', $k->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" style="margin-right: 8px;" onclick="return confirm('Apakah Anda yakin ingin menghapus Menu ini?')">Delete</button>
                                         </form>
                                    </td>
                                </tr>
                                <!-- Modal Edit Mekanik -->
                                <div class="modal fade" id="editMekanikModal{{ $k->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('mekanik.update', $k->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Mekanik</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" class="form-control" name="nama" value="{{ $k->nama }}" required>

                                                        <label class="mt-2">NIP</label>
                                                        <input type="text" class="form-control" name="nip" value="{{ $k->nip }}" required>

                                                        <label class="mt-2">No HP</label>
                                                        <input type="text" class="form-control" name="no_hp" value="{{ $k->no_hp }}" required>

                                                        <label class="mt-2">Alamat</label>
                                                        <textarea class="form-control" name="alamat" rows="2" required>{{ $k->alamat }}</textarea>

                                                        <label class="mt-2">Gudang</label>
                                                        <select name="gudang_id" class="form-control" required>
                                                            @foreach($gudang as $item)
                                                                <option value="{{ $item->id }}" {{ $item->id == $k->gudang_id ? 'selected' : '' }}>
                                                                    {{ $item->nama_gudang }}
                                                                </option>
                                                            @endforeach
                                                        </select>
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
                            {{ $mekanik->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
     <!-- Modal Tambah Mekanik -->
    <div class="modal fade" id="createMekanikmodal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('mekanik.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Mekanik</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" required>

                            <label class="mt-2">NIP</label>
                            <input type="text" class="form-control" name="nip" required>

                            <label class="mt-2">No HP</label>
                            <input type="text" class="form-control" name="no_hp" required>

                            <label class="mt-2">Alamat</label>
                            <textarea class="form-control" name="alamat" rows="2" required></textarea>

                            <label class="mt-2">Gudang</label>
                            <select name="gudang_id" class="form-control" required>
                                <option value="">-- Pilih Gudang --</option>
                                @foreach($gudang as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_gudang }}</option>
                                @endforeach
                            </select>
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
