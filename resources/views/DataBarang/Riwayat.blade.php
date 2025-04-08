@extends('layouts.app', ['activePage' => 'Riwayat', 'title' => 'Riwayat'])

@section('content')
<div class="container">
    <h3 class="mb-4">Riwayat Transaksi</h3>

    {{-- Form Pencarian dan Filter --}}
    <form class="row g-3 align-items-center mb-4" method="GET" action="{{ route('Riwayat') }}">
        <div class="col-md-3">
            <input type="text" class="form-control" name="search" placeholder="Cari Katalog" value="{{ request('search') }}">
        </div>

        <div class="col-md-2">
            <select class="form-control" name="filter_jns">
                <option value="">Pilih Jenis Transaksi</option>
                <option value="masuk" {{ request('filter_jns') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                <option value="keluar" {{ request('filter_jns') == 'keluar' ? 'selected' : '' }}>Keluar</option>
            </select>
        </div>

        <div class="col-md-2">
            <select class="form-control" name="filter_gdg">a
                <option value="">Pilih Gudang</option>
                @foreach ($gudangs as $gudang)
                    <option value="{{ $gudang->id }}" {{ request('filter_gdg') == $gudang->id ? 'selected' : '' }}>
                        {{ $gudang->nama_gudang }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter Tahun --}}
        <div class="col-md-2">
            <select class="form-control" name="filter_year">
                <option value="">Pilih Tahun</option>
                @for ($year = date('Y'); $year >= 2000; $year--)
                    <option value="{{ $year }}" {{ request('filter_year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endfor
            </select>
        </div>

        {{-- Filter Bulan --}}
        <div class="col-md-2">
            <select class="form-control" name="filter_month">
                <option value="">Pilih Bulan</option>
                @for ($month = 1; $month <= 12; $month++)
                    <option value="{{ $month }}" {{ request('filter_month') == $month ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    {{-- Tabel Riwayat Transaksi --}}
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th>Sparepart</th>
                <th>Gudang</th>
                <th>Jenis Transaksi</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $trx)
                <tr>
                    <td>{{ $trx->sparepart->name }}</td>
                    <td>{{ $trx->gudang->nama_gudang }}</td>
                    <td>{{ ucfirst($trx->jenis_transaksi) }}</td>
                    <td>{{ $trx->jumlah }}</td>
                    <td>{{ date('d-m-Y', strtotime($trx->tanggal)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada transaksi ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div>
        <a href="{{ route('riwayat.export-pdf', request()->all()) }}" class="btn btn-danger">Export PDF</a>
    </div>
    {{-- Pagination --}}
    <div class="d-flex justify-content-end mt-3">
        <div>
            {{ $transaksi->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
