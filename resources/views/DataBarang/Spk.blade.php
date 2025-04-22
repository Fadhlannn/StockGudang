@extends('layouts.app', ['activePage' => 'Spk', 'title' => 'Daftar SPK'])

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Surat Perintah Kerja (SPK)</h2>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahDataMasuk">
        Tambah SPK
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modalTambahDataMasuk" tabindex="-1" aria-labelledby="modalSpkLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <form action="{{ route('spk.store') }}" method="POST">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalSpkLabel">Form SPK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">

                {{-- No PK --}}
                <div class="mb-3">
                  <label for="no_pk" class="form-label">No PK</label>
                  <input type="text" name="no_pk" class="form-control" required>
                </div>

                {{-- Nama Pengemudi --}}
                <div class="mb-3">
                  <label for="nama_pengemudi" class="form-label">Nama Pengemudi</label>
                  <select name="nama_pengemudi" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    @foreach ($pengemudi as $p)
                      <option value="{{ $p->nama }}">{{ $p->nama }} - {{ $p->nip }}</option>
                    @endforeach
                  </select>
                </div>

                {{-- Nomor Body, Route, KM --}}
                <div class="row mb-3">
                  <div class="col">
                    <label for="nomor_body" class="form-label">Nomor Body</label>
                    <select class="form-select" name="nomor_body" id="nomor_body" required>
                      <option value="">-- Pilih --</option>
                      @foreach ($bus as $b)
                        <option value="{{ $b->nomor_body }}"{{ old('bus_primajasa_id') == $b ->id ? 'selected' : '' }}>{{ $b->nomor_body }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col">
                    <label for="route" class="form-label">Route</label>
                    <select id="route" name="route" class="form-select" required disabled>
                        <option value="">-- Pilih Nomor Body Dulu --</option>
                      </select>
                  </div>
                  <div class="col">
                    <label for="km_standar" class="form-label">KM Standar</label>
                    <input type="number" name="km_standar" class="form-control" required>
                  </div>
                </div>

                {{-- Jenis Kerusakan --}}
                <div class="mb-3">
                  <label for="jenis_kerusakan" class="form-label">Jenis Kerusakan</label>
                 {{-- Dropdown untuk kode rusak --}}
                    <select name="kode_rusak_id" id="kode_rusak_id" class="form-select">
                        <option value="">-- Pilih Kode Rusak --</option>
                        @foreach($kodeRusak as $kode)
                            <option value="{{ $kode->id }}">{{ $kode->kode_rusak }}</option>
                        @endforeach
                    </select>
                <select name="jenis_rusak_id" id="jenis_rusak_id" class="form-select">
                    <option value="">-- Pilih Jenis Kerusakan --</option>
                    @foreach($detail_rusak as $detail)
                        <option value="{{ $detail->id }}" data-kode="{{ $detail->kode_rusak_id }}">
                            {{ $detail->jenis_rusak }}
                        </option>
                    @endforeach
                </select>
                </div>

                {{-- Tanggal Masuk dan Keluar --}}
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

                {{-- Pool (Gudang), Bagian Gudang, Mekanik --}}
                <div class="row mb-3">
                    <div class="col">
                      <label for="pool" class="form-label">Pool</label>
                      <select name="pool" id="pool" class="form-select" required>
                        <option value="">-- Pilih Pool --</option>
                        @foreach ($gudang as $g)
                        <option value="{{ $g->id }}" {{ old('gudang_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_gudang }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col">
                      <label for="bagian_gudang" class="form-label">Bagian Gudang</label>
                      <select name="bagian_gudang_id" id="bagian_gudang_id" class="form-select" required disabled>
                        <option value="">-- Pilih pool terlebih dahulu --</option>
                      </select>
                    </div>
                    <div class="col">
                      <label for="mekanik" class="form-label">Mekanik</label>
                      <select name="mekanik_id" id="mekanik_id" class="form-select" required disabled>
                        <option value="">-- Pilih Mekanik terlebih dahulu --</option>
                      </select>
                    </div>
                  </div>

                {{-- Keterangan --}}
                <div class="mb-3">
                  <label for="keterangan" class="form-label">Keterangan</label>
                  <textarea name="keterangan" class="form-control" rows="3"></textarea>
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
                        <th>Tanggal Keluar</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spks as $spk)
                    <tr>
                        <td>{{ $spk->nomor_spk }}</td>
                        <td>{{ $spk->gudang->nama_gudang ?? 'N/A' }}</td>
                        <td>{{ $spk->bus->nomor_body ?? 'N/A' }}</td>
                        <td>{{ $spk->tanggal_spk ?? 'N/A' }}</td>
                        <td>{{ $spk->tanggal_keluar ?? 'N/A' }}</td>
                        <td>{{ $spk->deskripsi_pekerjaan ?? 'N/A' }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editSpkModal{{ $spk->id }}">Edit</a>
                            <form action="{{ route('spk.destroy', $spk->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus SPK ini?')">Hapus</button>
                            </form>
                            <a href="{{ route('dataKeluar', $spk->id) }}" class="btn btn-sm btn-primary">Data Keluar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach ($spks as $spk)
<!-- Modal Edit SPK -->
<div class="modal fade" id="editSpkModal{{ $spk->id }}" tabindex="-1" aria-labelledby="editSpkModalLabel{{ $spk->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('spk.update', $spk->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editSpkModalLabel{{ $spk->id }}">Edit SPK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nomor_body" class="form-label">Nomor Body</label>
                            <select class="form-select nomor-body" name="nomor_body" data-spk-id="{{ $spk->id }}" required>
                                <option value="">-- Pilih Nomor Body --</option>
                                @foreach ($bus as $body)
                                    <option value="{{ $body->id }}" {{ $body->id == $spk->nomor_body ? 'selected' : '' }}>
                                        {{ $body->nomor_body }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="route" class="form-label">Route</label>
                            <input type="text" class="form-control" name="route" value="{{ $spk->route }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="gudang_id" class="form-label">Pool / Gudang</label>
                            <select class="form-select gudang-select" name="gudang_id" data-spk-id="{{ $spk->id }}" required>
                                <option value="">-- Pilih Gudang --</option>
                                @foreach ($gudang as $g)
                                    <option value="{{ $g->id }}" {{ $g->id == $spk->gudang_id ? 'selected' : '' }}>{{ $g->nama_gudang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="mekanik_id" class="form-label">Mekanik</label>
                            <select class="form-select" name="mekanik_id" required>
                                <option value="">-- Pilih Mekanik --</option>
                                @foreach ($mekanik as $m)
                                    @if ($m->gudang_id == $spk->gudang_id)
                                        <option value="{{ $m->id }}" {{ $m->id == $spk->mekanik_id ? 'selected' : '' }}>
                                            {{ $m->nama }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bagian_gudang_id" class="form-label">Bagian Gudang</label>
                        <select class="form-select" name="bagian_gudang_id" required>
                            <option value="">-- Pilih Bagian Gudang --</option>
                            @foreach ($bagianGudang as $bg)
                                @if ($bg->gudang_id == $spk->gudang_id)
                                    <option value="{{ $bg->id }}" {{ $bg->id == $spk->bagian_gudang_id ? 'selected' : '' }}>
                                        {{ $bg->nama }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kode_rusak" class="form-label">Kode Rusak</label>
                            <select class="form-select kode-rusak" name="kode_rusak" data-spk-id="{{ $spk->id }}" required>
                                <option value="">-- Pilih Kode Rusak --</option>
                                @foreach ($kodeRusak as $kr)
                                    <option value="{{ $kr->id }}" {{ $kr->id == $spk->kode_rusak ? 'selected' : '' }}>
                                        {{ $kr->kode }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 jenis-kerusakan-wrapper" id="jenisKerusakanWrapper{{ $spk->id }}">
                            <label for="jenis_kerusakan" class="form-label">Jenis Kerusakan</label>
                            <input type="text" class="form-control" name="jenis_kerusakan" value="{{ $spk->jenis_kerusakan }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="2">{{ $spk->keterangan }}</textarea>
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
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const kodeSelect = document.getElementById('kode_rusak_id');
        const jenisSelect = document.getElementById('jenis_rusak_id');
        const allOptions = Array.from(jenisSelect.options);

        kodeSelect.addEventListener('change', function () {
            const selectedKodeId = this.value;

            jenisSelect.innerHTML = '<option value="">-- Pilih Jenis Kerusakan --</option>';

            allOptions.forEach(option => {
                if (option.dataset.kode === selectedKodeId) {
                    jenisSelect.appendChild(option.cloneNode(true));
                }
            });
        });
    });
    </script>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const routeData = @json($bus);
    const nomorBodySelect = document.getElementById('nomor_body');
    const routeSelect = document.getElementById('route');

    const bagianGudang = @json($bagianGudang);  // Data bagian gudang
    const mekanik = @json($mekanik);            // Data mekanik
    const gudangSelect = document.getElementById('pool');
    const bagianGudangSelect = document.getElementById('bagian_gudang_id');
    const mekanikSelect = document.getElementById('mekanik_id');

    console.log('DATA Bus:', routeData);

    console.log('DATA BAGIAN GUDANGS:', bagianGudang);
    console.log('DATA BAGIAN MEKANIK:', mekanik);

    nomorBodySelect.addEventListener('change', function () {
        const selectedNomorBody = this.value;

        // Reset route
        routeSelect.innerHTML = '<option value="">-- Pilih Route --</option>';
        routeSelect.disabled = true;

        if (selectedNomorBody) {
            const selectedBus = routeData.find(bus => bus.nomor_body === selectedNomorBody);

            if (selectedBus && selectedBus.route) {
                const option = document.createElement('option');
                option.value = selectedBus.route.kode_route;
                option.textContent = selectedBus.route.kode_route;
                routeSelect.appendChild(option);
                routeSelect.disabled = false;
            } else {
                routeSelect.innerHTML = '<option value="">-- Tidak ada route untuk nomor body ini --</option>';
            }
        }
    });

    const modal = document.getElementById('modalTambahDataMasuk');
    modal.addEventListener('shown.bs.modal', function () {
        bagianGudangSelect.innerHTML = '<option value="">-- Pilih Gudang terlebih dahulu --</option>';
        bagianGudangSelect.disabled = true;
        mekanikSelect.innerHTML = '<option value="">-- Pilih Mekanik terlebih dahulu --</option>';
        mekanikSelect.disabled = true;
        gudangSelect.value = ''; // reset gudang juga
    });

    gudangSelect.addEventListener('change', function () {
        const selectedGudangId = this.value;

            // Reset bagian gudang dan mekanik
        bagianGudangSelect.innerHTML = '<option value="">-- Pilih Bagian --</option>';
        bagianGudangSelect.disabled = true;
        mekanikSelect.innerHTML = '<option value="">-- Pilih Mekanik --</option>';
        mekanikSelect.disabled = true;

        if (selectedGudangId) {
                // Filter bagian gudang berdasarkan gudang yang dipilih
            const filteredBagian = bagianGudang.filter(bg => parseInt(bg.gudang_id) === parseInt(selectedGudangId));
            if (filteredBagian.length > 0) {
                filteredBagian.forEach(bg => {
                    const option = document.createElement('option');
                    option.value = bg.id;
                    option.textContent = `${bg.nama}${bg.nip ? ' - ' + bg.nip : ''}`;
                    bagianGudangSelect.appendChild(option);
                });
                bagianGudangSelect.disabled = false;
            } else {
                bagianGudangSelect.innerHTML = '<option value="">-- Tidak ada bagian untuk gudang ini --</option>';
            }

                // Filter mekanik berdasarkan gudang yang dipilih
            const filteredMekanik = mekanik.filter(m => parseInt(m.gudang_id) === parseInt(selectedGudangId));
            if (filteredMekanik.length > 0) {
                filteredMekanik.forEach(m => {
                    const option = document.createElement('option');
                    option.value = m.id;
                    option.textContent = `${m.nama}`;
                    mekanikSelect.appendChild(option);
                });
                mekanikSelect.disabled = false;
            } else {
                mekanikSelect.innerHTML = '<option value="">-- Tidak ada mekanik untuk gudang ini --</option>';
            }
        }
    });
});
</script>
@endpush


@endsection
