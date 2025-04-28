<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataMasuk;
use App\Models\Supliers;
use App\Models\gudang;
use App\Models\Sparepart;
use App\Models\StockSparepart;
use Illuminate\Support\Facades\Auth;

class DataMasukController extends Controller
{
    public function index(){
        $dataMasuk = DataMasuk::with(['user','sparepart', 'suplier', 'gudang'])->get();
        $spareparts = Sparepart::all();
        $supliers = Supliers::all();
        $gudangs = Gudang::all();
        return view('DataBarang.DataMasuk', compact('dataMasuk','spareparts', 'supliers', 'gudangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_order' => 'required|integer',
            'Tanggal_masuk' => 'required|date',
            'sparepart_id' => 'required|exists:sparepart,id',
            'jumlah' => 'required|integer',
            'supliers_id' => 'required|exists:supliers,id',
            'gudang_id' => 'required|exists:gudang,id',
            'keterangan' => 'nullable|string',
        ]);



        DataMasuk::create(array_merge(
            $request->all(),
            ['user_id' => Auth::id()]
        ));

        $stok = StockSparepart::where('sparepart_id', $request->sparepart_id)
        ->where('gudang_id', $request->gudang_id)
        ->first();

    if ($stok) {
        // Jika stok sudah ada, tambahkan jumlah
        $stok->jumlah_stok += $request->jumlah;
        $stok->save();
    } else {
        // Jika belum ada, buat stok baru
        StockSparepart::create([
            'sparepart_id' => $request->sparepart_id,
            'gudang_id' => $request->gudang_id,
            'jumlah' => $request->jumlah,
        ]);
    }

        return redirect()->route('DataMasuk')->with('success', 'Data masuk berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataMasuk $dataMasuk)
    {
        $spareparts = Sparepart::all();
        $supliers = Supliers::all();
        $gudangs = Gudang::all();

        return view('dataMasuk.edit', compact('dataMasuk', 'spareparts', 'supliers', 'gudangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataMasuk $dataMasuk)
    {
        $request->validate([
            'no_order' => 'required|integer',
            'Tanggal_masuk' => 'required|date',
            'sparepart_id' => 'required|exists:sparepart,id',
            'jumlah' => 'required|integer',
            'supliers_id' => 'required|exists:supliers,id',
            'gudang_id' => 'required|exists:gudang,id',
            'keterangan' => 'nullable|string',
        ]);

        $oldJumlah = $dataMasuk->jumlah;
        $oldSparepartId = $dataMasuk->sparepart_id;
        $oldGudangId = $dataMasuk->gudang_id;

        $newJumlah = $request->jumlah;
        $newSparepartId = $request->sparepart_id;
        $newGudangId = $request->gudang_id;

        // Jika sparepart & gudang tidak berubah
        if ($oldSparepartId == $newSparepartId && $oldGudangId == $newGudangId) {
            $selisih = $newJumlah - $oldJumlah;
            $stok = StockSparepart::where('sparepart_id', $newSparepartId)
                    ->where('gudang_id', $newGudangId)
                    ->first();

            if ($stok) {
                $stok->jumlah_stok += $selisih;

                if ($stok->jumlah_stok < 0) {
                    $stok->jumlah_stok = 0;
                }

                $stok->save();
            }
        } else {
            // Kembalikan stok lama
            $oldStok = StockSparepart::where('sparepart_id', $oldSparepartId)
                        ->where('gudang_id', $oldGudangId)
                        ->first();
            if ($oldStok) {
                $oldStok->jumlah_stok -= $oldJumlah;
                if ($oldStok->jumlah_stok < 0) {
                    $oldStok->jumlah_stok = 0;
                }
                $oldStok->save();
            }

            // Tambahkan stok baru
            $newStok = StockSparepart::where('sparepart_id', $newSparepartId)
                        ->where('gudang_id', $newGudangId)
                        ->first();

            if ($newStok) {
                $newStok->jumlah_stok += $newJumlah;
                $newStok->save();
            } else {
                // Kalau belum ada stoknya, buat baru
                StockSparepart::create([
                    'sparepart_id' => $newSparepartId,
                    'gudang_id' => $newGudangId,
                    'jumlah_stok' => $newJumlah,
                ]);
            }
        }
        $dataMasuk->update($request->all());

        return redirect()->route('DataMasuk')->with('success', 'Data masuk berhasil diperbarui.');
    }

    public function destroy(DataMasuk $dataMasuk)
    {
    // Ambil data sparepart, gudang, dan jumlah dari data masuk
    $sparepartId = $dataMasuk->sparepart_id;
    $gudangId = $dataMasuk->gudang_id;
    $jumlah = $dataMasuk->jumlah;

    // Cari stok sesuai sparepart dan gudang
    $stok = StockSparepart::where('sparepart_id', $sparepartId)
        ->where('gudang_id', $gudangId)
        ->first();

    // Kurangi stok jika ditemukan
    if ($stok) {
        $stok->jumlah_stok -= $jumlah;

        // Pastikan stok tidak negatif
        if ($stok->jumlah_stok < 0) {
            $stok->jumlah_stok = 0;
        }

        $stok->save();
    }
        $dataMasuk->delete();

        return redirect()->route('DataMasuk')->with('success', 'Data masuk dan stok berhasil dihapus/dikurangi.');
    }

}
