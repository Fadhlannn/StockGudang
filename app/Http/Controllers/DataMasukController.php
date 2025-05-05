<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataMasuk;
use App\Models\Supliers;
use App\Models\Gudang;
use App\Models\Sparepart;
use App\Models\StockSparepart;
use Illuminate\Support\Facades\Auth;

class DataMasukController extends Controller
{
    public function index()
    {
        $dataMasuk = DataMasuk::with(['user', 'sparepart', 'suplier', 'gudang'])->get();
        $spareparts = Sparepart::all();
        $supliers = Supliers::all();
        $gudangs = Gudang::all();

        return view('DataBarang.DataMasuk', compact('dataMasuk', 'spareparts', 'supliers', 'gudangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_order' => 'required|integer',
            'Tanggal_masuk' => 'required|date',
            'sparepart_id' => 'required|exists:sparepart,id',
            'jumlah' => 'required|integer',
            'harga_satuan' => 'required|numeric|min:0',
            'supliers_id' => 'required|exists:supliers,id',
            'gudang_id' => 'required|exists:gudang,id',
            'keterangan' => 'nullable|string',
        ]);

        // Simpan transaksi barang masuk
        $dataMasuk = DataMasuk::create([
            'no_order'      => $request->no_order,
            'Tanggal_masuk' => $request->Tanggal_masuk,
            'sparepart_id'  => $request->sparepart_id,
            'jumlah'        => $request->jumlah,
            'harga_satuan'  => $request->harga_satuan,
            'supliers_id'   => $request->supliers_id,
            'gudang_id'     => $request->gudang_id,
            'keterangan'    => $request->keterangan,
            'user_id'       => Auth::id(),
        ]);

        // Update atau buat stok sparepart
        $stok = StockSparepart::firstOrNew([
            'sparepart_id' => $request->sparepart_id,
            'gudang_id'    => $request->gudang_id,
        ]);

        $stok->jumlah_stok = ($stok->jumlah_stok ?? 0) + $request->jumlah;
        $stok->save();

        // Opsional: Update harga sparepart sebagai harga terbaru
        $sparepart = Sparepart::find($request->sparepart_id);

        return redirect()->route('DataMasuk')->with('success', 'Data masuk berhasil ditambahkan.');
    }

    public function edit(DataMasuk $dataMasuk)
    {
        $spareparts = Sparepart::all();
        $supliers = Supliers::all();
        $gudangs = Gudang::all();

        return view('dataMasuk.edit', compact('dataMasuk', 'spareparts', 'supliers', 'gudangs'));
    }

    public function update(Request $request, DataMasuk $dataMasuk)
    {
        $request->validate([
            'no_order' => 'required|integer',
            'Tanggal_masuk' => 'required|date',
            'sparepart_id' => 'required|exists:sparepart,id',
            'jumlah' => 'required|integer',
            'harga_satuan' => 'required|numeric|min:0',
            'supliers_id' => 'required|exists:supliers,id',
            'gudang_id' => 'required|exists:gudang,id',
            'keterangan' => 'nullable|string',
        ]);

        // Simpan data lama untuk hitung stok
        $oldJumlah = $dataMasuk->jumlah;
        $oldSparepartId = $dataMasuk->sparepart_id;
        $oldGudangId = $dataMasuk->gudang_id;

        // Update data masuk
        $dataMasuk->update([
            'no_order'      => $request->no_order,
            'Tanggal_masuk' => $request->Tanggal_masuk,
            'sparepart_id'  => $request->sparepart_id,
            'jumlah'        => $request->jumlah,
            'harga_satuan'  => $request->harga_satuan,
            'sisa_stok'     => $request->jumlah,
            'supliers_id'   => $request->supliers_id,
            'gudang_id'     => $request->gudang_id,
            'keterangan'    => $request->keterangan,
        ]);

        // Update stok jika ada perubahan
        if ($oldSparepartId == $request->sparepart_id && $oldGudangId == $request->gudang_id) {
            // Sparepart dan gudang sama, hanya jumlah berubah
            $selisih = $request->jumlah - $oldJumlah;

            $stok = StockSparepart::where('sparepart_id', $request->sparepart_id)
                ->where('gudang_id', $request->gudang_id)
                ->first();

            if ($stok) {
                $stok->jumlah_stok += $selisih;
                $stok->jumlah_stok = max($stok->jumlah_stok, 0);
                $stok->save();
            }
        } else {
            // Kembalikan stok lama
            $stokLama = StockSparepart::where('sparepart_id', $oldSparepartId)
                ->where('gudang_id', $oldGudangId)
                ->first();
            if ($stokLama) {
                $stokLama->jumlah_stok -= $oldJumlah;
                $stokLama->jumlah_stok = max($stokLama->jumlah_stok, 0);
                $stokLama->save();
            }

            // Tambahkan ke stok baru
            $stokBaru = StockSparepart::firstOrNew([
                'sparepart_id' => $request->sparepart_id,
                'gudang_id'    => $request->gudang_id,
            ]);
            $stokBaru->jumlah_stok = ($stokBaru->jumlah_stok ?? 0) + $request->jumlah;
            $stokBaru->save();
        }

        // Update harga terbaru sparepart (opsional)
        $sparepart = Sparepart::find($request->sparepart_id);
        $sparepart->harga = $request->harga_satuan;
        $sparepart->save();

        return redirect()->route('DataMasuk')->with('success', 'Data masuk berhasil diperbarui.');
    }

    public function destroy(DataMasuk $dataMasuk)
    {
        // Kurangi stok sesuai jumlah dan lokasi
        $stok = StockSparepart::where('sparepart_id', $dataMasuk->sparepart_id)
            ->where('gudang_id', $dataMasuk->gudang_id)
            ->first();

        if ($stok) {
            $stok->jumlah_stok -= $dataMasuk->jumlah;
            $stok->jumlah_stok = max($stok->jumlah_stok, 0);
            $stok->save();
        }

        // Hapus data masuk
        $dataMasuk->delete();

        return redirect()->route('DataMasuk')->with('success', 'Data masuk berhasil dihapus.');
    }
}
