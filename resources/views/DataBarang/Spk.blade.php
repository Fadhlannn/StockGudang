@extends('layouts.app', ['activePage' => 'Spk', 'title' => 'Daftar SPK'])

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Surat Perintah Kerja (SPK)</h2>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahDataMasuk">
        Tambah SPK
    </button>
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
                        <th>User</th>
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
                        <td>{{ $spk->user->name ?? 'N/A' }}</td>
                        <td>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalEditSpk{{ $spk->id }}">
                                    Edit
                                </button>
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

            {{-- No PK & Penginput --}}
            <div class="row mb-3">
              <div class="col">
                <label for="no_pk" class="form-label">No PK</label>
                <input type="text" name="no_pk" class="form-control" required>
              </div>
              <div class="col">
                <label class="form-label">Penginput</label>
                <input type="text" class="form-control mb-1" value="{{ Auth::user()->name }}" disabled>
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="text" class="form-control" value="{{ Auth::user()->role->role }}" disabled>
              </div>
            </div>

            {{-- Nama Pengemudi & NIP --}}
            <div class="row mb-3">
              <div class="col">
                <label for="nama_pengemudi" class="form-label">Nama Pengemudi</label>
                <input id="nama_pengemudi" list="list_pengemudi" name="nama_pengemudi"
                  class="form-control @error('nama_pengemudi') is-invalid @enderror"
                  value="{{ old('nama_pengemudi') }}" required>
                <datalist id="list_pengemudi">
                  @foreach ($pengemudi as $p)
                    <option value="{{ $p->nama }}">
                  @endforeach
                </datalist>
                @error('nama_pengemudi')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="col">
                <label for="nip" class="form-label">NIP Pengemudi</label>
                <input type="text" id="nip" name="nip" class="form-control" readonly>
              </div>
            </div>
            {{-- Nomor Body, Route, Nomor Polisi --}}
            <div class="row mb-3">
              <div class="col">
                <label for="nomor_body" class="form-label">Nomor Body</label>
                <input type="text" id="nomor_body" name="nomor_body" class="form-control" required placeholder="Ketik Nomor Body...">
              </div>
              <div class="col">
                <label for="route" class="form-label">Route</label>
                <input type="text" id="route" name="route" class="form-control" readonly>
              </div>
              <div class="col">
                <label for="nomor_polisi" class="form-label">Nomor Polisi</label>
                <input type="text" id="nomor_polisi" name="nomor_polisi" class="form-control" readonly>
              </div>
            </div>

            {{-- KM Standar --}}
            <div class="mb-3">
              <label for="km_standar" class="form-label">KM Standar</label>
              <input type="number" name="km_standar" class="form-control" required>
            </div>

            {{-- Jenis Kerusakan --}}
            <div class="row mb-3">
                <div class="col">
                <label for="jenis_kerusakan" class="form-label">Jenis Kerusakan</label>

                <select name="kode_rusak_id" id="kode_rusak_id" class="form-select mb-2" required>
                    <option value="">-- Pilih Kode Rusak --</option>
                    @foreach($kodeRusak as $kode)
                    <option value="{{ $kode->id }}">{{ $kode->kode_rusak }}</option>
                    @endforeach
                </select>
                </div>

                <div class="col">
                <div id="jenis-rusak-container">
                    <div class="jenis-rusak-item mb-2">
                    <select name="jenis_rusak_id[]" class="form-select" disabled required>
                        <option value="">--Pilih Jenis Rusak--</option>
                        @foreach($detail_rusak as $detail)
                        <option value="{{ $detail->id }}" data-kode="{{ $detail->kode_rusak_id }}">
                            {{ $detail->jenis_rusak }}
                        </option>
                        @endforeach
                    </select>
                    </div>
                </div>


              <button type="button" id="tambah-jenis-rusak" class="btn btn-sm btn-primary mt-2">Tambah Jenis Rusak</button>
            </div>
            </div>

            {{-- Tanggal Masuk dan Keluar --}}
            <div class="row mb-3">
              <div class="col">
                <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" value="{{ date('Y-m-d') }}" readonly required>
              </div>
              <div class="col">
                <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                <input type="date" name="tanggal_keluar" class="form-control">
              </div>
            </div>

            {{-- Pool, Mekanik --}}
            <div class="row mb-3">
              <div class="col">
                <label for="pool" class="form-label">Pool</label>
                <select name="pool" id="pool" class="form-select" required>
                  <option value="">-- Pilih Pool --</option>
                  @foreach ($gudang as $g)
                    <option value="{{ $g->id }}" {{ old('gudang_id') == $g->id ? 'selected' : '' }}>
                      {{ $g->nama_gudang }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col">
                <label for="mekanik_id" class="form-label">Mekanik</label>
                <select name="mekanik_id" id="mekanik_id" class="form-select" disabled required>
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
    @if ($errors->any())
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('modalTambahDataMasuk'));
        myModal.show();
    </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kodeSelect = document.getElementById('kode_rusak_id');
            const container = document.getElementById('jenis-rusak-container');
            const addButton = document.getElementById('tambah-jenis-rusak');

            const allOptions = [];
            container.querySelectorAll('option[data-kode]').forEach(opt => {
                allOptions.push(opt.cloneNode(true));
            });

            function filterJenisRusak() {
                const selectedKodeId = kodeSelect.value;
                const selects = container.querySelectorAll('select');

                selects.forEach(select => {
                    const currentValue = select.value;
                    select.innerHTML = '<option value="">-- Pilih Jenis Kerusakan --</option>';
                    if (selectedKodeId) {
                        allOptions.forEach(option => {
                            if (option.dataset.kode === selectedKodeId) {
                                select.appendChild(option.cloneNode(true));
                            }
                        });
                        select.disabled = false;
                    } else {
                        select.disabled = true;
                    }
                    select.value = currentValue;
                });
            }

            kodeSelect.addEventListener('change', filterJenisRusak);

            addButton.addEventListener('click', function () {
                const firstItem = container.querySelector('.jenis-rusak-item');
                const newItem = firstItem.cloneNode(true);
                const newSelect = newItem.querySelector('select');

                newSelect.innerHTML = '<option value="">-- Pilih Jenis Kerusakan --</option>';
                newSelect.disabled = kodeSelect.value ? false : true;

                // Tambahkan tombol hapus
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger btn-sm';
                removeButton.innerText = 'Hapus';
                removeButton.onclick = function () {
                    newItem.remove();
                };

                newItem.appendChild(removeButton);
                container.appendChild(newItem);

                filterJenisRusak();
            });

            filterJenisRusak();
        });
        </script>

    <script>
    $('#nama_pengemudi').on('input', function() {
        var nama = $(this).val();

        if (nama.length > 2) { // Biar ga query kalau ketik cuma 1-2 huruf
            $.ajax({
                url: '{{ route("get-nip-pengemudi") }}',
                method: 'GET',
                data: { nama: nama },
                success: function(response) {
                    if(response.nip){
                        $('#nip').val(response.nip);
                    } else {
                        $('#nip').val('');
                    }
                }
            });
        } else {
            $('#nip').val('');
        }
    });

    $('#nomor_body').on('input', function() {
    let nomorBody = $(this).val();

    if (nomorBody.length > 2) { // Biar ga query tiap ketik sedikit
        $.ajax({
            url: '{{ route("get-route-polisi") }}',
            method: 'GET',
            data: { nomor_body: nomorBody },
            success: function(response) {
                if(response.route && response.nomor_polisi){
                    $('#route').val(response.route);
                    $('#nomor_polisi').val(response.nomor_polisi);
                } else {
                    $('#route').val('');
                    $('#nomor_polisi').val('');
                }
            },
            error: function() {
                console.error('Gagal mengambil data dari server');
            }
        });
    } else {
        $('#route').val('');
        $('#nomor_polisi').val('');
    }
});


</script>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const mekanik = @json($mekanik);            // Data mekanik
    const gudangSelect = document.getElementById('pool');
    const mekanikSelect = document.getElementById('mekanik_id');

    console.log('DATA BAGIAN MEKANIK:', mekanik);


    const modal = document.getElementById('modalTambahDataMasuk');
    modal.addEventListener('shown.bs.modal', function () {
        mekanikSelect.innerHTML = '<option value="">-- Pilih Mekanik terlebih dahulu --</option>';
        mekanikSelect.disabled = true;
        gudangSelect.value = ''; // reset gudang juga
    });

    gudangSelect.addEventListener('change', function () {
        const selectedGudangId = this.value;

            // Reset bagian gudang dan mekanik
        mekanikSelect.innerHTML = '<option value="">-- Pilih Mekanik --</option>';
        mekanikSelect.disabled = true;

        if (selectedGudangId) {
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
