    @extends('layouts.app', ['activePage' => 'DataKeluar', 'title' => 'DataKeluar SPK'])

    @section('content')
    <div class="container mt-4">
        <h3>Data Keluar - SPK {{ $spk->nomor_spk }}</h3>

        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-bordered">
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
                        <th>Bagian Gudang</th>
                        <td>{{ $spk->bagianGudang->nama }} - {{ $spk->bagianGudang->nip }}</td>
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
                    <form action="{{ route('data-keluar.store', $spk->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="sparepart_id">Nama Sparepart</label>
                            <select name="sparepart_id" id="sparepart_id" class="form-control">
                                @foreach($sparepart as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="tanggal_keluar">Tanggal Keluar</label>
                            <input type="date" name="tanggal_keluar" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        <a href="{{ route('dataKeluar', $spk->id) }}" class="btn btn-secondary mt-3">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
