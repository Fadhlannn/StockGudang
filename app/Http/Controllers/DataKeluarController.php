<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\Sparepart;
use App\Models\DataKeluar;
use App\Models\DataMasuk;
use App\Models\StockSparepart;
use Illuminate\Http\Request;

class DataKeluarController extends Controller
{
    public function dataKeluar($id)
    {
        $spk = Spk::with(['detailRusaks','dataKeluar.sparepart'])->findOrFail($id);
        $datakeluar = DataKeluar::with(['spk','sparepart','gudang','jumlah','tanggal']);
        $sparepart = Sparepart::all();
        $barangKeluars = $spk->dataKeluar ?? collect(); // ubah sesuai relasi kamu
        $totalHarga = $spk->dataKeluar->sum(function ($item) {
        return $item->jumlah * $item->harga_satuan;
        });


    return view('DataBarang.DataKeluar', compact('spk','barangKeluars','sparepart','totalHarga'));
    }

    public function store(Request $request, $spkId)
    {
        $request->validate([
            'sparepart_id' => 'required|exists:sparepart,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
        ]);

        // Pastikan SPK ditemukan
        $spk = Spk::findOrFail($spkId);

        // Ambil stok sparepart berdasarkan gudang dan sparepart_id
        $stok = StockSparepart::where('sparepart_id', $request->sparepart_id)
                    ->where('gudang_id', $spk->gudang_id)
                    ->orderBy('created_at', 'asc') // FIFO: urutkan berdasarkan tanggal masuk
                    ->get();

        $totalHarga = 0;
        $totalQty = $request->jumlah;
        $jumlahKeluar = $totalQty;

        foreach ($stok as $stokItem) {
            if ($jumlahKeluar <= 0) break;

            if ($stokItem->jumlah_stok >= $jumlahKeluar) {
                $totalHarga += $jumlahKeluar * $stokItem->harga_satuan;
                $stokItem->jumlah_stok -= $jumlahKeluar;
                $stokItem->save();
                $jumlahKeluar = 0;
            } else {
                $totalHarga += $stokItem->jumlah_stok * $stokItem->harga_satuan;
                $jumlahKeluar -= $stokItem->jumlah_stok;
                $stokItem->jumlah_stok = 0;
                $stokItem->save();
            }
        }

        // Hitung rata-rata tertimbang
        $hargaSatuanRata = $totalHarga / $totalQty;

        // Simpan
        DataKeluar::create([
            'spk_id' => $spk->id,
            'sparepart_id' => $request->sparepart_id,
            'gudang_id' => $spk->gudang_id,
            'jumlah' => $totalQty,
            'tanggal_keluar' => $request->tanggal_keluar,
            'harga_satuan' => $hargaSatuanRata,
        ]);

        return redirect()->route('dataKeluar', $spkId)->with('success', 'Data barang keluar berhasil disimpan!');
    }

  public function getSpareparts(Request $request)
    {
        $search = $request->q;

        // Mengambil sparepart berdasarkan pencarian
        $spareparts = Sparepart::where('name', 'like', '%' . $search . '%')->get();

        $results = $spareparts->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->name,
                'harga' => $item->harga
            ];
        });

        return response()->json($results);
    }

}
