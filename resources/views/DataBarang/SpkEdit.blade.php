@extends('layouts.app', ['activePage' => 'Spk', 'title' => 'Edit SPK'])

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Surat Perintah Kerja (SPK)</h2>

    <form action="{{ route('spk.update', $spk->id) }}" method="POST">
        @csrf
        @method('PUT')

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
                  <input type="text" name="no_pk" class="form-control" value="{{ old('no_pk', $spk->no_pk) }}" required>
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
                    value="{{ old('nama_pengemudi', $spk->nama_pengemudi) }}" required>
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
                  <input type="text" id="nip" name="nip" class="form-control" value="{{ old('nip', $spk->nip) }}" readonly>
                </div>
              </div>

              {{-- Nomor Body, Route, Nomor Polisi --}}
              <div class="row mb-3">
                <div class="col">
                  <label for="nomor_body" class="form-label">Nomor Body</label>
                  <input type="text" id="nomor_body" name="nomor_body" class="form-control" value="{{ old('nomor_body', $spk->nomor_body) }}" required placeholder="Ketik Nomor Body...">
                </div>
                <div class="col">
                  <label for="route" class="form-label">Route</label>
                  <input type="text" id="route" name="route" class="form-control" value="{{ old('route', $spk->route) }}" readonly>
                </div>
                <div class="col">
                  <label for="nomor_polisi" class="form-label">Nomor Polisi</label>
                  <input type="text" id="nomor_polisi" name="nomor_polisi" class="form-control" value="{{ old('nomor_polisi', $spk->nomor_polisi) }}" readonly>
                </div>
              </div>

              {{-- KM Standar --}}
              <div class="mb-3">
                <label for="km_standar" class="form-label">KM Standar</label>
                <input type="number" name="km_standar" class="form-control" value="{{ old('km_standar', $spk->km_standar) }}" required>
              </div>

              {{-- Jenis Kerusakan --}}
              <div class="row mb-3">
                <div class="col">
                    <label for="kode_rusak_id" class="form-label">Kode Rusak</label>
                    <select name="kode_rusak_id" id="kode_rusak_id" class="form-select mb-2" required>
                        <option value="">-- Pilih Kode Rusak --</option>
                        @foreach($kodeRusak as $kode)
                            <option value="{{ $kode->id }}" {{ old('kode_rusak_id', $spk->kode_rusak_id) == $kode->id ? 'selected' : '' }}>
                                {{ $kode->kode_rusak }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col">
                    <div id="jenis-rusak-container">
                        <div class="jenis-rusak-item mb-2">
                            <select name="jenis_rusak_id[]" class="form-select" disabled required>
                                <option value="">--Pilih Jenis Rusak--</option>
                                @foreach($detail_rusak as $detail)
                                    <option value="{{ $detail->id }}" data-kode="{{ $detail->kode_rusak_id }}"
                                        {{ is_array($spk->jenis_rusak_ids) && in_array($detail->id, $spk->jenis_rusak_ids) ? 'selected' : '' }}>
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
                  <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', $spk->tanggal_masuk) }}" readonly required>
                </div>
                <div class="col">
                  <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                  <input type="date" name="tanggal_keluar" class="form-control" value="{{ old('tanggal_keluar', $spk->tanggal_keluar) }}">
                </div>
              </div>

              {{-- Pool, Mekanik --}}
              <div class="row mb-3">
                <div class="col">
                  <label for="pool" class="form-label">Pool</label>
                  <select name="pool" id="pool" class="form-select" required>
                    <option value="">-- Pilih Pool --</option>
                    @foreach ($gudang as $g)
                      <option value="{{ $g->id }}" {{ $spk->pool_id == $g->id ? 'selected' : '' }}>
                        {{ $g->nama_gudang }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="col">
                  <label for="mekanik_id" class="form-label">Mekanik</label>
                  <select name="mekanik_id" id="mekanik_id" class="form-select" disabled required>
                    <option value="">-- Pilih Mekanik terlebih dahulu --</option>
                    @foreach ($mekanik as $m)
                      <option value="{{ $m->id }}" {{ $spk->mekanik_id == $m->id ? 'selected' : '' }}>
                        {{ $m->nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              {{-- Keterangan --}}
              <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $spk->keterangan) }}</textarea>
              </div>

            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Simpan</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>

          </div>
    </form>
</div>
<script>
// Update kode kerusakan dan jenis kerusakan
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

    if (nama.length > 2) {
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

if (nomorBody.length > 2) {
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
@endsection
