@extends('layouts.app', ['activePage' => 'Spk', 'title' => 'Spk'])

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Surat Perintah Kerja (SPK)</h2>

    {{-- <form action="{{ route('DataBarang.Spk') }}" method="POST"> --}}
        @csrf
        <!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalSpk">
    Tambah SPK
</button>

<!-- Modal -->
<div class="modal fade" id="modalSpk" tabindex="-1" aria-labelledby="modalSpkLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('Spk') }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSpkLabel">Form SPK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col">
                        <label for="no_pk" class="form-label">No PK</label>
                        <input type="text" name="no_pk" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="nama_pengemudi" class="form-label">Nama Pengemudi</label>
                        <input type="text" name="nama_pengemudi" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="nomor_body" class="form-label">Pool</label>
                        <input type="text" name="nomor_body" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for="route" class="form-label">Route</label>
                        <input type="text" name="route" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for="route" class="form-label">Nomor Body</label>
                        <input type="text" name="route" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for="km_standar" class="form-label">KM Standar</label>
                        <input type="number" name="km_standar" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="jenis_kerusakan" class="form-label">Kode Kerusakan</label>
                        <input type="text" name="jenis_kerusakan" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for="jenis_kerusakan" class="form-label">Jenis Kerusakan</label>
                        <input type="text" name="jenis_kerusakan" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for="jenis_kerusakan" class="form-label">Jenis Kerusakan</label>
                        <input type="text" name="jenis_kerusakan" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for="jenis_kerusakan" class="form-label">Jenis Kerusakan</label>
                        <input type="text" name="jenis_kerusakan" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                        <input type="date" name="tanggal_keluar" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="bagian_gudang" class="form-label">Bagian Gudang</label>
                        <input type="text" name="bagian_gudang" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for="mekanik" class="form-label">Mekanik</label>
                        <input type="text" name="mekanik" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </form>
  </div>
</div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No PK</th>
                        <th>Pool</th>
                        <th>No Body</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Selesai</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>hahaha</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                <a href=""class="btn btn-sm btn-danger">DataKeluar</a>
                            </td>
                        </tr>
                        {{-- @foreach ($dataMasuk as $item) nanti untuk dinamis --}}

                    </tbody>
                </table>
            </div>
        </div>
@endsection
