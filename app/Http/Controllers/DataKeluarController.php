<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\Sparepart;
use App\Models\DataKeluar;
use App\Models\DataMasuk;
use App\Models\StockSparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataKeluarController extends Controller
{
    public function dataKeluar($id)
    {
        $spk = Spk::with(['detailRusaks','dataKeluar.sparepart'])->findOrFail($id);
        $datakeluar = DataKeluar::with(['spk','sparepart','gudang','jumlah','tanggal','user']);
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
        $totalStokTersedia = $stok->sum('jumlah_stok');
        if ($totalStokTersedia < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Jumlah yang diminta melebihi stok yang tersedia di gudang atau habis.']);
        }


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
            'user_id'       => Auth::id(),
        ]);

        return redirect()->route('dataKeluar', $spkId)->with('success', 'Data barang keluar berhasil disimpan!');
    }

    public function getSpareparts(Request $request)
    {
        $search = $request->get('q');
        $gudangId = $request->get('gudang_id'); // ambil ID gudang dari request

        $spareparts = Sparepart::with(['stok' => function($query) use ($gudangId) {
                if ($gudangId) {
                    $query->where('gudang_id', $gudangId);
                }
            }])
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('no_barang', 'like', "%{$search}%");
            })
            ->get();

        return response()->json(
            $spareparts->map(function ($item) {
                // Cek dulu apakah relasi stok-nya ada
                $stok = collect($item->stok)->sum('jumlah_stok');

                return [
                    'id' => $item->id,
                    'text' => '[' . $item->no_barang . '] - ' . $item->name . ' (Stok: ' . $stok . ')',
                    'harga' => $item->harga,
                    'stok' => $stok
                ];
            })
        );
    }


public function destroy($spkId, $id)
{
    $dataKeluar = DataKeluar::findOrFail($id);

    // Validasi opsional: pastikan dataKeluar milik SPK yang sama
    if ($dataKeluar->spk_id != $spkId) {
        abort(404, 'SPK tidak cocok');
    }

    // Kembalikan jumlah ke stok
    $stok = StockSparepart::where('sparepart_id', $dataKeluar->sparepart_id)
                ->where('gudang_id', $dataKeluar->gudang_id)
                ->orderBy('created_at', 'desc')
                ->get();

    $jumlahDikembalikan = $dataKeluar->jumlah;
    foreach ($stok as $stokItem) {
        if ($jumlahDikembalikan <= 0) break;

        $stokItem->jumlah_stok += $jumlahDikembalikan;
        $stokItem->save();
        break;
    }

    $dataKeluar->delete();

    return back()->with('success', 'Data barang keluar berhasil dihapus dan stok diperbarui!');
}



}
