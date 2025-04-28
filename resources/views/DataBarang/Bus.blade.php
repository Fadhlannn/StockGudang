@extends('layouts.app', ['activePage' => 'Bus', 'title' => 'Bus'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Bus Data</h3>
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
                                    <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#createbusmodal">Tambah Bus</a>
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
                                    <th>No body</th>
                                    <th>No Polisi</th>
                                    <th>Kode Route</th>
                                    <th>Nama Route</th>
                                </tr>
                        </thead>
                        <tbody>

                            @foreach ($bus as $b)
                                <tr>
                                    <td>{{ ($bus->currentPage() - 1) * $bus->perPage() + $loop->iteration }}</td>
                                    <td>{{ $b->nomor_body }}</td>
                                    <td>{{ $b->nomor_polisi }}</td>
                                    <td>{{ $b->route->kode_route }}</td>
                                    <td>{{ $b->route->nama_route }}</td>
                                    <td>
                                        <form action="{{route('bus.update',$b->id)}}" method="GET" style="display:inline;"data-toggle="modal" data-target="#editBusModal{{ $b->id }}">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" >
                                                    Edit
                                            </button>
                                         </form>
                                        <form action="{{ route('bus.destroy', $b->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" style="margin-right: 8px;" onclick="return confirm('Apakah Anda yakin ingin menghapus Menu ini?')">Delete</button>
                                         </form>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editBusModal{{ $b->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('bus.update', $b->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Bus</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>No Body</label>
                                                        <input type="text" class="form-control" name="nomor_body" value="{{ $b->nomor_body }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>No Polisi</label>
                                                        <input type="text" class="form-control" name="nomor_polisi" value="{{ $b->nomor_polisi }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Route</label>
                                                        <select class="form-control" name="route_id" required>
                                                            @foreach ($route as $r)
                                                                <option value="{{ $r->id }}" {{ $b->route_id == $r->id ? 'selected' : '' }}>{{ $r->kode_route }}</option>
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
                            {{ $bus->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="modal fade" id="createbusmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('bus.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Bus</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="nomor_body">Nomor Body</label>
                        <input type="text" class="form-control" id="nomor_body" name="nomor_body" required>

                        <label for="nomor_polisi" class="mt-3">Nomor Polisi</label>
                        <input type="text" class="form-control" id="nomor_polisi" name="nomor_polisi" required>

                        <label for="route_id" class="mt-3">Route</label>
                        <select name="route_id" class="form-control" required>
                            <option value="">-- Pilih Route --</option>
                            @foreach ($route as $r)
                                <option value="{{ $r->id }}">{{ $r->kode_route }} - {{$r->nama_route}}</option>
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
