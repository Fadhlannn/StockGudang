@extends('layouts/app', ['activePage' => 'Transaksi', 'title' => 'Transaksi'])

@section('content')
<div class="container">
    <h2>Data Transaksi Sparepart</h2>

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('Transaksi.store') }}">
        @csrf
        <div class="form-group">
            <label>Sparepart</label>
            <select name="sparepart_id" class="form-control">
                @foreach($spareparts as $sparepart)
                <option value="{{ $sparepart->id }}" {{ old('sparepart_id') == $sparepart->id ? 'selected' : '' }}>{{ $sparepart->name }}</option>
                @endforeach
            </select>
            @error('sparepart_id')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Gudang</label>
            <select name="gudang_id" class="form-control">
                @foreach($gudangs as $gudang)
                <option value="{{ $gudang->id }}" {{ old('gudang_id') == $gudang->id ? 'selected' : '' }}>{{ $gudang->nama_gudang }}</option>
                @endforeach
            </select>
            @error('gudang_id')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Jenis Transaksi</label>
            <select name="jenis_transaksi" class="form-control">
                <option value="masuk" {{ old('jenis_transaksi') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                <option value="keluar" {{ old('jenis_transaksi') == 'keluar' ? 'selected' : '' }}>Keluar</option>
            </select>
            @error('jenis_transaksi')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah') }}">
            @error('jumlah')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}">
            @error('tanggal')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
    </form>
</div>
@endsection
