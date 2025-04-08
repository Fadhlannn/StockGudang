@extends('layouts/app', ['activePage' => 'stok', 'title' => 'stok'])


@section('content')
<div class="container">
    <h2 class="mb-4">Stok Sparepart</h2>
    <form class="d-flex" role="search" method="GET" action="{{ route('stok.index') }}">
        <input class="form-control me-2" type="search" name="search" placeholder="Cari Stock" aria-label="Search" value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit">Cari</button>
        <div class="col-md-2">
            <select class="form-control" name="filter_gdg">
                <option value="">Pilih Gudang</option>
                @foreach ($gudangs as $gudang)
                    <option value="{{ $gudang->id }}" {{ request('filter_gdg') == $gudang->id ? 'selected' : '' }}>
                        {{ $gudang->nama_gudang }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sparepart</th>
                <th>Gudang</th>
                <th>Jumlah Stok</th>
                <th>Harga Per Sparepart</th>
                <th>Total Harga Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stok as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->sparepart->name }}</td>
                <td>{{ $item->gudang->nama_gudang}}</td>
                <td>{{ $item->jumlah_stok }}</td>
                <td>Rp {{ number_format($item->sparepart->harga, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->jumlah_stok * $item->sparepart->harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end mt-3">
        <div>
            {{ $stok->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
