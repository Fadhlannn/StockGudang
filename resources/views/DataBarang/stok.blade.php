@extends('layouts.app', ['activePage' => 'stok', 'title' => 'Stok Sparepart'])

@section('content')
<div class="container">
    <h2 class="mb-4">Stok Sparepart</h2>

    <!-- Form Pencarian dan Filter -->
    <form class="d-flex mb-4" role="search" method="GET" action="{{ route('stok.index') }}">
        <input class="form-control me-2" type="search" name="search" placeholder="Cari Stok" aria-label="Search" value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit">Cari</button>

        <!-- Filter Gudang -->
        <div class="col-md-2 ms-2">
            <select class="form-control" name="filter_gdg">
                <option value="">Pilih Gudang</option>
                @foreach ($gudangs as $gudang)
                    <option value="{{ $gudang->id }}" {{ request('filter_gdg') == $gudang->id ? 'selected' : '' }}>
                        {{ $gudang->nama_gudang }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary ms-2">Filter</button>
    </form>

    <!-- Tabel Stok Sparepart -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sparepart</th>
                <th>Gudang</th>
                <th>Jumlah Stok</th>
                <th>Harga Standart</th>
                <th>Total Harga Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stok as $index => $item)
            <tr>
                <!-- Menampilkan nomor urut berdasarkan halaman dan iterasi -->
                <td>{{ ($stok->currentPage() - 1) * $stok->perPage() + $loop->iteration }}</td>
                <td>{{ $item->nama_sparepart }}</td>
                <td>{{ $item->nama_gudang }}</td>
                <td>{{ $item->total_stok }}</td>
                <td>Rp {{ number_format($item->harga_standart, 0, ',', '.') }}</td>
                {{-- <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td> --}}
                <td>Rp {{ number_format($item->harga_standart * $item->total_stok, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-3">
        <div>
            {{ $stok->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
