<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use App\Models\TransaksiSparepart;
use App\Models\gudang;
use App\Models\StockSparepart;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiSparepart::with(['sparepart', 'gudang'])->get();
        $spareparts = Sparepart::all();
        $gudangs = gudang::all();
        return view('DataBarang.Transaksi', compact('transaksi', 'spareparts', 'gudangs'));
    }

    public function store(Request $request)
{
    $request->validate([
        'sparepart_id' => 'required',
        'gudang_id' => 'required',
        'jenis_transaksi' => 'required|in:masuk,keluar',
        'jumlah' => 'required|integer|min:1',
        'tanggal' => 'required|date',
    ]);

    // Cek apakah stok sparepart sudah ada di gudang
    $stok = StockSparepart::where('sparepart_id', $request->sparepart_id)
        ->where('gudang_id', $request->gudang_id)
        ->first();

    if ($request->jenis_transaksi == 'keluar') {
        // Jika transaksi keluar tapi stok kosong atau kurang
        if (!$stok || $stok->jumlah_stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok Tidak Cukup');
        }
    }

    // Simpan Transaksi (HANYA jika stok mencukupi)
    $transaksi = TransaksiSparepart::create($request->all());

    // Update stok sparepart
    if ($request->jenis_transaksi == 'masuk') {
        if ($stok) {
            $stok->jumlah_stok += $request->jumlah;
            $stok->save();
        } else {
            StockSparepart::create([
                'sparepart_id' => $request->sparepart_id,
                'gudang_id' => $request->gudang_id,
                'jumlah_stok' => $request->jumlah,
            ]);
        }
    } elseif ($request->jenis_transaksi == 'keluar') {
        $stok->jumlah_stok -= $request->jumlah;
        $stok->save();
    }
        return redirect()->route('Transaksi')->with('success', 'Transaksi berhasil ditambahkan');
    }
}
