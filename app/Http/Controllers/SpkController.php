<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\Pengemudi;
use App\Models\BusPrimajasa;
use App\Models\Route;
use App\Models\KodeRusak;
use App\Models\Mekanik;
use App\Models\Gudang;
use App\Models\DetailRusak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class SpkController extends Controller
{
        public function index()
        {
            // Ambil data SPK dengan relasi yang sesuai
            $spks = Spk::with(['bus', 'pengemudi', 'mekanik', 'kodeRusak','gudang','route'])->get();

            // Ambil data terkait lainnya
            $bus = BusPrimajasa::with('route')->get();
            $pengemudi = Pengemudi::all();
            $mekanik = Mekanik::all();
            $kodeRusak = KodeRusak::all();
            $gudang = Gudang::all();
            $route = Route::all();
            $detail_rusak = DetailRusak::all();

            // Kirim data ke view
            return view('DataBarang.spk', compact('spks', 'bus', 'pengemudi', 'mekanik', 'kodeRusak','gudang','route','detail_rusak' ));
        }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_pk' => 'required|unique:spk,nomor_spk',
            'nama_pengemudi' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!Pengemudi::where('nama', $value)->exists()) {
                        $fail('Nama pengemudi "' . $value . '" tidak ditemukan di database.');
                    }
                }
            ],
            'nomor_body' => 'required|string',
            'route' => 'required|string',
            'km_standar' => 'required|numeric',
            'kode_rusak_id' => 'required',
            'jenis_rusak_id' => 'required|array',
            'jenis_rusak_id.*' => 'exists:detail_rusak,id',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date',
            'mekanik_id' => 'required',
            'pool' => 'required',
            'keterangan' => 'nullable|string',
        ]);

        // Buat SPK baru
        $spk = new Spk();
        $spk->nomor_spk = $validated['no_pk'];
        $spk->bus_primajasa_id = BusPrimajasa::where('nomor_body', $validated['nomor_body'])->first()->id;
        $spk->pengemudi_id = Pengemudi::where('nama', $validated['nama_pengemudi'])->first()->id;
        $spk->kode_rusak_id = $validated['kode_rusak_id'];
        $spk->mekanik_id = $validated['mekanik_id'];
        $spk->gudang_id = $validated['pool'];
        $spk->tanggal_spk = now();
        $spk->tanggal_keluar = $validated['tanggal_keluar'];
        $spk->km_standar = $validated['km_standar'];
        $spk->deskripsi_pekerjaan = $validated['keterangan'];
        $spk->route_id = Route::where('kode_route', $validated['route'])->first()?->id;
        $spk->user_id = Auth::id();
        $spk->save();

        // Ambil semua DetailRusak yang berkaitan dengan kode_rusak_id, lalu attach ke SPK
        $detailRusakList = $request->input('jenis_rusak_id');
        // Attach ke SPK
        $spk->detailRusaks()->attach($detailRusakList);

        return redirect()->route('Spk')->with('success', 'SPK berhasil ditambahkan.');
    }

    public function edit(Spk $spk)
    {
        // Ambil data terkait untuk form edit
        $bus = BusPrimajasa::all();
        $pengemudi = Pengemudi::all();
        $mekanik = Mekanik::all();
        $kodeRusak = KodeRusak::all();
        $gudang = Gudang::all(); // tambahkan ini
        $route = Route::all(); // betulkan ini (dulu typo)
        $detail_rusak = DetailRusak::all();

        return view('DataBarang.SpkEdit', compact('spk', 'bus', 'pengemudi', 'mekanik', 'kodeRusak', 'route','gudang','detail_rusak'));
    }

    public function update(Request $request, Spk $spk)
    {
        // Validasi data yang diterima dari form
        $validated = $request->validate([
            'no_pk' => 'required|unique:spk,nomor_spk',
            'nama_pengemudi' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!Pengemudi::where('nama', $value)->exists()) {
                        $fail('Nama pengemudi "' . $value . '" tidak ditemukan di database.');
                    }
                }
            ],
            'nomor_body' => 'required|string',
            'route' => 'required|string',
            'km_standar' => 'required|numeric',
            'kode_rusak_id' => 'required',
            'jenis_rusak_id' => 'required|array',
            'jenis_rusak_id.*' => 'exists:detail_rusak,id',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date',
            'mekanik_id' => 'required',
            'pool' => 'required',
            'keterangan' => 'nullable|string',
        ]);


        // Update data SPK dengan validasi yang telah diterima
        $spk = new Spk();
        $spk->nomor_spk = $validated['no_pk'];
        $spk->bus_primajasa_id = BusPrimajasa::where('nomor_body', $validated['nomor_body'])->first()->id;
        $spk->pengemudi_id = Pengemudi::where('nama', $validated['nama_pengemudi'])->first()->id;
        $spk->kode_rusak_id = $validated['kode_rusak_id'];
        $spk->mekanik_id = $validated['mekanik_id'];
        $spk->gudang_id = $validated['pool'];
        $spk->tanggal_spk = now();
        $spk->tanggal_keluar = $validated['tanggal_keluar'];
        $spk->km_standar = $validated['km_standar'];
        $spk->deskripsi_pekerjaan = $validated['keterangan'];
        $spk->route_id = Route::where('kode_route', $validated['route'])->first()?->id;
        $spk->user_id = Auth::id();
        $spk->save();

        // Simpan perubahan
        $spk->save();

        // Update relasi many-to-many (jenis_rusak)
        $spk->detailRusaks()->sync($validated['jenis_rusak_id']);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('Spk')->with('success', 'SPK berhasil diperbarui.');
    }




    public function destroy(Spk $spk)
    {
        DB::table('detail_rusak_spk')->where('spk_id', $spk->id)->delete();

    // Hapus SPK itu sendiri
        $spk->delete();

        return redirect()->route('Spk')->with('success', 'SPK berhasil dihapus.');
    }
    public function getNipPengemudi(Request $request)
    {
        $nama = $request->input('nama');

        $pengemudi = DB::table('pengemudi')
            ->select('nip') // ambil field nip aja
            ->where('nama', 'LIKE', '%' . $nama . '%')
            ->first();

        return response()->json(['nip' => $pengemudi->nip ?? null]);
    }

    public function getRoutePolisi(Request $request)
    {
        $nomorBody = $request->input('nomor_body');

        // Join bus_primajasa dengan rute
        $bus = DB::table('bus_primajasa')
            ->join('routes', 'bus_primajasa.route_id', '=', 'routes.id')
            ->select('bus_primajasa.nomor_polisi', 'routes.kode_route')
            ->where('bus_primajasa.nomor_body', $nomorBody)
            ->first();

        if ($bus) {
            return response()->json([
                'route' => $bus->kode_route,
                'nomor_polisi' => $bus->nomor_polisi
            ]);
        }

        return response()->json([
            'route' => null,
            'nomor_polisi' => null
        ]);
    }




}
