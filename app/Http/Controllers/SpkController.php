<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\Pengemudi;
use App\Models\BusPrimajasa;
use App\Models\Route;
use App\Models\KodeRusak;
use App\Models\BagianGudang;
use App\Models\Mekanik;
use App\Models\Gudang;
use Illuminate\Http\Request;

class SpkController extends Controller
{
    public function index()
    {
        // Ambil data SPK dengan relasi yang sesuai
        $spks = Spk::with(['bus', 'pengemudi', 'mekanik', 'kodeRusak', 'bagianGudang','gudang'])->get();

        // Ambil data terkait lainnya
        $bus = BusPrimajasa::all();
        $pengemudi = Pengemudi::all();
        $mekanik = Mekanik::all();
        $kodeRusak = KodeRusak::all();
        $bagianGudang = BagianGudang::all();
        $gudang = Gudang::all();

        // Kirim data ke view
        return view('DataBarang.spk', compact('spks', 'bus', 'pengemudi', 'mekanik', 'kodeRusak', 'bagianGudang','gudang' ));
    }



    public function create()
    {
        // Mengambil data yang diperlukan untuk dropdown atau input form
        $busPrimajasa = BusPrimajasa::all();
        $pengemudi = Pengemudi::all();
        $mekanik = Mekanik::all();
        $kodeRusak = KodeRusak::all();
        $bagianGudang = BagianGudang::all();
        $routes = Route::all();

        return view('spk.create', compact('busPrimajasa', 'pengemudi', 'mekanik', 'kodeRusak', 'bagianGudang', 'routes'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'no_pk' => 'required|unique:spk,nomor_spk',
            'nama_pengemudi' => 'required|string',
            'nomor_body' => 'required|string',
            'route' => 'required|string',
            'km_standar' => 'required|numeric',
            'jenis_kerusakan' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date',
            'bagian_gudang' => 'required|string',
            'mekanik' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        // Create SPK baru
        $spk = new Spk();
        $spk->nomor_spk = $validated['no_pk'];
        $spk->bus_primajasa_id = BusPrimajasa::where('nomor_body', $validated['nomor_body'])->first()->id;
        $spk->pengemudi_id = Pengemudi::where('nama', $validated['nama_pengemudi'])->first()->id;
        $spk->kode_rusak_id = KodeRusak::where('kode_rusak', $validated['jenis_kerusakan'])->first()->id;
        $spk->gudang_id = BagianGudang::where('nama', $validated['bagian_gudang'])->first()->id;
        $spk->mekanik_id = Mekanik::where('nama', $validated['mekanik'])->first()->id;
        $spk->tanggal_spk = now();
        $spk->tanggal_keluar = $validated['tanggal_keluar'];
        $spk->km_standar = $validated['km_standar'];
        $spk->deskripsi_pekerjaan = $validated['keterangan'];
        $spk->save();

        return redirect()->route('DataBarang.spk')->with('success', 'SPK berhasil ditambahkan.');
    }

    public function edit(Spk $spk)
    {
        // Ambil data terkait untuk form edit
        $busPrimajasa = BusPrimajasa::all();
        $pengemudi = Pengemudi::all();
        $mekanik = Mekanik::all();
        $kodeRusak = KodeRusak::all();
        $bagianGudang = BagianGudang::all();
        $routes = Route::all();

        return view('spk.edit', compact('spk', 'busPrimajasa', 'pengemudi', 'mekanik', 'kodeRusak', 'bagianGudang', 'routes'));
    }

    public function update(Request $request, Spk $spk)
    {
        // Validasi input
        $validated = $request->validate([
            'no_pk' => 'required|unique:spk,nomor_spk,' . $spk->id,
            'nama_pengemudi' => 'required|string',
            'nomor_body' => 'required|string',
            'route' => 'required|string',
            'km_standar' => 'required|numeric',
            'jenis_kerusakan' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date',
            'bagian_gudang' => 'required|string',
            'mekanik' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        // Update SPK
        $spk->nomor_spk = $validated['no_pk'];
        $spk->bus_primajasa_id = BusPrimajasa::where('nomor_body', $validated['nomor_body'])->first()->id;
        $spk->pengemudi_id = Pengemudi::where('nama', $validated['nama_pengemudi'])->first()->id;
        $spk->kode_rusak_id = KodeRusak::where('kode_rusak', $validated['jenis_kerusakan'])->first()->id;
        $spk->gudang_id = BagianGudang::where('nama', $validated['bagian_gudang'])->first()->id;
        $spk->mekanik_id = Mekanik::where('nama', $validated['mekanik'])->first()->id;
        $spk->tanggal_keluar = $validated['tanggal_keluar'];
        $spk->km_standar = $validated['km_standar'];
        $spk->deskripsi_pekerjaan = $validated['keterangan'];
        $spk->save();

        return redirect()->route('DataBarang.spk')->with('success', 'SPK berhasil diperbarui.');
    }

    public function destroy(Spk $spk)
    {
        $spk->delete();

        return redirect()->route('DataBarang.spk')->with('success', 'SPK berhasil dihapus.');
    }
}
