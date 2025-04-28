@extends('layouts.app', ['activePage' => 'Pengemudi', 'title' => 'Pengemudi'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Pengemudi Data</h3>
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
                                    <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#createPengemudimodal">Tambah Pengemudi</a>
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
                                    <th>No HP</th>
                                    <th>Alamat</th>
                                    <th>Action</th>
                                </tr>
                        </thead>
                        <tbody>

                            @foreach ($pengemudi as $p)
                                <tr>
                                    <td>{{ ($pengemudi->currentPage() - 1) * $pengemudi->perPage() + $loop->iteration }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->nip}}</td>
                                    <td>{{ $p->no_hp }}</td>
                                    <td>{{ $p->alamat }}</td>
                                    <td>
                                        <form action="{{route('pengemudi.update',$p->id)}}" method="GET" style="display:inline;"data-toggle="modal" data-target="#editPengemudiModal{{ $p->id }}">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" >
                                                    Edit
                                            </button>
                                         </form>
                                        <form action="{{ route('pengemudi.destroy', $p->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" style="margin-right: 8px;" onclick="return confirm('Apakah Anda yakin ingin menghapus Menu ini?')">Delete</button>
                                         </form>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editPengemudiModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('pengemudi.update', $p->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Pengemudi</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" class="form-control" name="nama" value="{{ $p->nama }}" required>
                                                        <label class="mt-2">NIP</label>
                                                        <input type="text" class="form-control" name="nip" value="{{ $p->nip }}" required>
                                                        <label class="mt-2">No HP</label>
                                                        <input type="text" class="form-control" name="no_hp" value="{{ $p->no_hp }}" required>
                                                        <label class="mt-2">Alamat</label>
                                                        <textarea class="form-control" name="alamat" required>{{ $p->alamat }}</textarea>
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
                            {{ $pengemudi->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="createPengemudimodal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('pengemudi.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Pengemudi</h5>
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
                                <textarea class="form-control" name="alamat" required></textarea>
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

