@extends('layouts.app', ['activePage' => 'DataKeluar', 'title' => 'DataKeluar SPK'])

@section('content')
<div class="container mt-4">
    <h3>Data Keluar - SPK {{ $spk->nomor_spk }}</h3>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Pengguna</th>
                    <td>{{$spk->user->name}} - {{$spk->user->nip}}</td>
                </tr>
                <tr>
                    <th>Nomor Body - Nomor Polisi</th>
                    <td>{{ $spk->bus->nomor_body }} - {{ $spk->bus->nomor_polisi }}</td>
                </tr>
                <tr>
                    <th>Route</th>
                    <td>{{ $spk->route->kode_route }}</td>
                </tr>
                <tr>
                    <th>Pengemudi</th>
                    <td>{{ $spk->pengemudi->nama }} - {{ $spk->pengemudi->nip }}</td>
                </tr>
                <tr>
                    <th>Pool</th>
                    <td>{{ $spk->gudang->nama_gudang }}</td>
                </tr>
                <tr>
                    <th>Mekanik</th>
                    <td>{{ $spk->mekanik->nama }} - {{ $spk->mekanik->nip }}</td>
                </tr>
                <tr>
                    <th>Tanggal Masuk</th>
                    <td>{{ $spk->tanggal_spk }}</td>
                </tr>
                <tr>
                    <th>Kode Rusak</th>
                    <td>{{ $spk->kodeRusak->kode_rusak }}</td>
                </tr>
                <tr>
                    <th>Detail Kerusakan</th>
                    <td>
                        @if ($spk->detailRusaks->isNotEmpty())
                            <ul>
                                @foreach ($spk->detailRusaks as $detail)
                                    <li>{{ $detail->jenis_rusak }}</li>
                                @endforeach
                            </ul>
                        @else
                            Tidak ada detail kerusakan.
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="container mt-4">
        <h4>Tambah Data Keluar - SPK {{ $spk->nomor_spk }}</h4>

        <div class="card mb-4">
            <div class="card-body">
                <!-- Menampilkan pesan sukses atau error -->
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('data-keluar.store', $spk->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="sparepart_id">Nama Sparepart</label>
                        <select name="sparepart_id" id="sparepart_id" class="form-control" style="width: 100%"></select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="harga_standar_out" class="form-label">Harga Standar</label>
                        <input type="number" class="form-control" id="harga_standar_out" name="harga_standar_out" readonly>
                    </div>
                    <div class="form-group mt-2">
                        <label for="tanggal_keluar">Tanggal Keluar</label>
                        <input type="date" name="tanggal_keluar" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                    <a href="{{ route('dataKeluar', $spk->id) }}" class="btn btn-secondary mt-3">Kembali</a>
                </form>
                <div class="container mt-4">
    <h4>Riwayat Data Keluar - SPK {{ $spk->nomor_spk }}</h4>

    <div class="card">
        <div class="card-body table-responsive">
            @if($spk->dataKeluar->isEmpty())
                <p class="text-muted">Belum ada data barang keluar untuk SPK ini.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sparepart</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                            <th>Tanggal Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($spk->dataKeluar as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->sparepart->name }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</td>
                            <td>{{ $item->tanggal_keluar }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="4" class="text-end">Total Harga Keseluruhan</th>
                            <th colspan="2">Rp {{ number_format($totalHarga, 0, ',', '.') }}</th>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function() {
    $('#sparepart_id').select2({
        placeholder: '-- Pilih Sparepart --',
        allowClear: true,
        ajax: {
            url: '{{ url("/get-spareparts") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term // keyword pencarian
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
        }
    });

    // Update harga standar saat memilih sparepart
    $('#sparepart_id').on('select2:select', function (e) {
        var data = e.params.data; // data yang dipilih
        $('#harga_standar_out').val(data.harga); // Set harga di input harga_standar_out
    });

    // Reset harga jika tidak ada pilihan
    $('#sparepart_id').on('select2:clear', function () {
        $('#harga_standar_out').val('');
    });
});

</script>
@endpush
@endsection
