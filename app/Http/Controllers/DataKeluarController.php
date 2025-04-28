<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\Sparepart;
use App\Models\DataKeluar;
use App\Models\StockSparepart;
use Illuminate\Http\Request;

class DataKeluarController extends Controller
{
    public function dataKeluar($id)
    {
        $spk = Spk::with(['detailRusaks'])->findOrFail($id);
        $datakeluar = DataKeluar::with(['spk','sparepart','gudang','jumlah','tanggal']);
        $sparepart = Sparepart::all();
        $barangKeluars = $spk->barangKeluars ?? collect(); // ubah sesuai relasi kamu

    return view('DataBarang.DataKeluar', compact('spk','barangKeluars','sparepart'));
    }

    public function store(Request $request, $spkId)
    {
        $request->validate([
            'sparepart_id' => 'required|exists:sparepart,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
        ]);

        $spk = SPK::findOrFail($spkId);

        $stok = StockSparepart::where('sparepart_id', $request->sparepart_id)
                ->where('gudang_id', $spk->gudang_id)
                ->first();

        if (!$stok || $stok->jumlah_stok < $request->jumlah) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok tidak mencukupi atau tidak ditemukan.']);
        }

        // Kurangi stok
        $stok->jumlah_stok -= $request->jumlah;
        $stok->save();

        DataKeluar::create([
            'spk_id' => $spk->id,
            'sparepart_id' => $request->sparepart_id,
            'gudang_id' => $spk->gudang_id,
            'jumlah' => $request->jumlah,
            'tanggal_keluar' => $request->tanggal_keluar,
        ]);

        return redirect()->route('dataKeluar', $spkId)->with('success', 'Data barang keluar berhasil disimpan!');
    }
}
