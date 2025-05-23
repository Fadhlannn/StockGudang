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
                    <th>No</th>
                    <th>No Order</th>
                    <th>Tanggal Masuk</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Supplier</th>
                    <th>Gudang</th>
                    <th>Keterangan</th>
                    <th>Pengguna/Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataMasuk as $t)
                <tr>
                    <td>{{ ($dataMasuk->currentPage() - 1) * $dataMasuk->perPage() + $loop->iteration }}</td>
                    <td>{{ $t->no_order }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->Tanggal_masuk)->translatedFormat('d F Y') }}</td>
                    <td>{{ $t->sparepart->name ?? '-' }}</td>
                    <td>{{ $t->jumlah }}</td>
                    <td>{{ $t->suplier->nama ?? '-' }}</td>
                    <td>{{ $t->gudang->nama_gudang ?? '-' }}</td>
                    <td>{{ $t->keterangan }}</td>
                    <td>{{ $t->user->name ?? '-' }}/{{ $t->user->role->role ?? '-' }}</td>
                    <td>
                        <!-- Tombol Edit dengan Modal -->
                        <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $t->id }}">
                            Edit
                        </a>

                        <!-- Form Hapus -->
                        <form action="{{ route('dataMasuk.destroy', $t->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                Hapus
                            </button>
                        </form>

                        <!-- Tombol Lihat Rekap -->
                        <a href="{{ route('rekapTotalOrder', ['no_order' => $t->no_order]) }}" class="btn btn-sm btn-danger">
                            Rekap Harga Total
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-end mt-4">
            {{ $dataMasuk->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

</div>

<!-- Modal Tambah Data Masuk -->
<div class="modal fade" id="modalTambahDataMasuk" tabindex="-1" aria-labelledby="modalTambahDataMasukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('dataMasuk.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDataMasukLabel">Tambah Data Barang Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <!-- Notifikasi di sini -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="no_order" class="form-label">No Order</label>
                            <input type="number" class="form-control @error('no_order') is-invalid @enderror" id="no_order" name="no_order" value="{{ old('no_order') }}" required>
                            @error('no_order')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="Tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control @error('Tanggal_masuk') is-invalid @enderror" id="Tanggal_masuk" name="Tanggal_masuk" value="{{ old('Tanggal_masuk', date('Y-m-d')) }}" readonly required>
                            @error('Tanggal_masuk')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Penginput</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        </div>

                        <div class="col-md-4 mt-3">
                            <label for="sparepart_id" class="form-label">Nama Barang</label>
                            <select class="form-control @error('sparepart_id') is-invalid @enderror"
                                    id="sparepart_id"
                                    name="sparepart_id"
                                    style="width: 100%"
                                    required>
                             <option></option>
                            </select>
                            @error('sparepart_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" required>
                            @error('jumlah')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="supliers_id" class="form-label">Supplier</label>
                            <select class="form-select @error('supliers_id') is-invalid @enderror" id="supliers_id" name="supliers_id" required>
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($supliers as $s)
                                    <option value="{{ $s->id }}" {{ old('supliers_id') == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                                @endforeach
                            </select>
                            @error('supliers_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="harga_satuan" class="form-label">Harga Satuan</label>
                            <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" required>
                        </div>
                        <div class="col-md-4">
                            <label for="harga_standar" class="form-label">Harga Standar</label>
                            <input type="number" class="form-control" id="harga_standar" name="harga_standar" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="gudang_id" class="form-label">Gudang</label>
                        <select class="form-select @error('gudang_id') is-invalid @enderror" id="gudang_id" name="gudang_id" required>
                            <option value="">-- Pilih Gudang --</option>
                            @foreach ($gudangs as $g)
                                <option value="{{ $g->id }}" {{ old('gudang_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_gudang }}</option>
                            @endforeach
                        </select>
                        @error('gudang_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="2">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
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
<script>
 $(document).ready(function() {
    // Reset Select2 dan harga saat modal ditutup
    $('#modalTambahDataMasuk').on('hidden.bs.modal', function () {
        $('#sparepart_id').val(null).trigger('change'); // Clear Select2
        $('#harga_standar').val(''); // Reset harga
    });

    $('#modalTambahDataMasuk').on('shown.bs.modal', function () {
        $('#sparepart_id').select2({
            dropdownParent: $('#modalTambahDataMasuk'),
            placeholder: '-- Pilih Barang --',
            allowClear: true,
            ajax: {
                url: '{{ url("/get-spareparts") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.text,
                                harga: item.harga
                            };
                        })
                    };
                },
                cache: true
            },
        });
    });

    // Isi harga saat pilih sparepart
    $('#sparepart_id').on('select2:select', function (e) {
        var data = e.params.data;
        $('#harga_standar').val(data.harga);
    });

    // Kosongkan harga saat hapus pilihan
    $('#sparepart_id').on('select2:clear', function (e) {
        $('#harga_standar').val('');
    });
});
</script>

{{-- @foreach ($dataMasuk as $t)
<!-- Modal Edit -->
<div class="modal fade" id="editModal{{ $t->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $t->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('dataMasuk.update', $t->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $t->id }}">Edit Data Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="no_order" class="form-label">No Order</label>
                            <input type="number" class="form-control" name="no_order" value="{{ $t->no_order }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="Tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control" name="Tanggal_masuk" value="{{ $t->Tanggal_masuk }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="sparepart_id" class="form-label">Nama Barang</label>
                            <select class="form-select" name="sparepart_id" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($spareparts as $s)
                                    <option value="{{ $s->id }}" {{ $s->id == $t->sparepart_id ? 'selected' : '' }}>{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" value="{{ $t->jumlah }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="supliers_id" class="form-label">Supplier</label>
                            <select class="form-select" name="supliers_id" required>
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($supliers as $s)
                                    <option value="{{ $s->id }}" {{ $s->id == $t->supliers_id ? 'selected' : '' }}>{{ $s->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="gudang_id" class="form-label">Gudang</label>
                        <select class="form-select" name="gudang_id" required>
                            <option value="">-- Pilih Gudang --</option>
                            @foreach ($gudangs as $g)
                                <option value="{{ $g->id }}" {{ $g->id == $t->gudang_id ? 'selected' : '' }}>{{ $g->nama_gudang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="2">{{ $t->keterangan }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach --}}
@endsection
