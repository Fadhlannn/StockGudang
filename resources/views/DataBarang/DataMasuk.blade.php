@extends('layouts.app', ['activePage' => 'DataMasuk', 'title' => 'Data Masuk'])

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Input Pemasukan Sparepart</h2>

    <!-- Tombol buka modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahDataMasuk">
        + Tambah Data Masuk
    </button>

    <!-- Tabel data masuk -->
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No Order</th>
                        <th>Tanggal Masuk</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Supplier</th>
                        <th>Gudang</th>
                        <th>Bagian Gudang</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh data dummy --}}
                    <tr>
                        <td>1</td>
                        <td>2025-04-07</td>
                        <td>Filter Oli</td>
                        <td>10</td>
                        <td>PT Oli Indo</td>
                        <td>Jakarta</td>
                        <td>Agus</td>
                        <td>Stok Awal</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                    {{-- @foreach ($dataMasuk as $item) nanti untuk dinamis --}}
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal Tambah Data Masuk -->
<div class="modal fade" id="modalTambahDataMasuk" tabindex="-1" aria-labelledby="modalTambahDataMasukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="#" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahDataMasukLabel">Tambah Data Barang Masuk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
            <div class="row mb-3">
              <div class="col-md-4x ">
                <label for="No_Order" class="form-label">No Order</label>
                <input type="number" class="form-control" id="No_Order" name="No_Order" required>
              </div>
              <div class="col-md-4">
                <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
              </div>
              <div class="col-md-4">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-4">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
              </div>
              <div class="col-md-4">
                <label for="supplier" class="form-label">Supplier</label>
                <input type="text" class="form-control" id="supplier" name="supplier">
              </div>
            </div>

            {{-- Dropdown Gudang --}}
            <div class="mb-3">
              <label for="gudang_id" class="form-label">Gudang</label>
              <select class="form-select" id="gudang_id" name="gudang_id" required>
                <option value="">-- Pilih Gudang --</option>
                <option value="1">Gudang A</option>
                <option value="2">Gudang B</option>
                {{-- Nanti pakai @foreach dari $gudangs --}}
              </select>
            </div>

            {{-- Dropdown Bagian Gudang --}}
            <div class="mb-3">
              <label for="bagian_gudang_id" class="form-label">Bagian Gudang</label>
              <select class="form-select" id="bagian_gudang_id" name="bagian_gudang_id" disabled>
                <option value="">-- Pilih Gudang terlebih dahulu --</option>
                {{-- Nanti diisi dinamis setelah gudang dipilih --}}
              </select>
            </div>

            <div class="mb-3">
              <label for="keterangan" class="form-label">Keterangan</label>
              <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    // Simulasi aktifkan dropdown bagian gudang (tanpa AJAX dulu)
    document.getElementById('gudang_id').addEventListener('change', function () {
        const bagianDropdown = document.getElementById('bagian_gudang_id');
        if (this.value) {
            bagianDropdown.disabled = false;
            // Simulasi ganti isi select (nanti diganti pakai AJAX)
            bagianDropdown.innerHTML = `
                <option value="">-- Pilih Bagian --</option>
                <option value="1">Agus</option>
                <option value="2">Budi</option>
            `;
        } else {
            bagianDropdown.disabled = true;
            bagianDropdown.innerHTML = '<option value="">-- Pilih Gudang terlebih dahulu --</option>';
        }
    });
  </script>
  @endpush

@endsection
