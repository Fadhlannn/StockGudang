<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataMasuk;
use App\Models\Supliers;
use App\Models\Gudang;
use App\Models\Sparepart;
use App\Models\StockSparepart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataMasukController extends Controller
{
    public function index()
    {
        $dataMasuk = DataMasuk::with(['user', 'sparepart', 'suplier', 'gudang'])->paginate(5);
        $spareparts = Sparepart::all();
        $supliers = Supliers::all();
        $gudangs = Gudang::all();

        return view('DataBarang.DataMasuk', compact('dataMasuk', 'spareparts', 'supliers', 'gudangs'));
    }


public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'no_order'      => 'required|integer',
        'Tanggal_masuk' => 'required|date',
        'sparepart_id'  => 'required|exists:sparepart,id',
        'jumlah'        => 'required|integer',
        'supliers_id'   => 'required|exists:supliers,id',
        'gudang_id'     => 'required|exists:gudang,id',
        'keterangan'    => 'nullable|string',
    ]);

    // Ambil harga dari tabel sparepart
    $sparepart = Sparepart::findOrFail($request->sparepart_id);
    $hargaSatuan = $sparepart->harga;

    // Simpan transaksi barang masuk
    $dataMasuk = DataMasuk::create([
        'no_order'      => $request->no_order,
        'Tanggal_masuk' => $request->Tanggal_masuk,
        'sparepart_id'  => $request->sparepart_id,
        'jumlah'        => $request->jumlah,
        'harga_satuan'  => $hargaSatuan,
        'supliers_id'   => $request->supliers_id,
        'gudang_id'     => $request->gudang_id,
        'keterangan'    => $request->keterangan,
        'user_id'       => Auth::id(),
    ]);

    // Cek apakah stok dengan sparepart dan gudang sudah ada
    $stok = StockSparepart::where([
        'sparepart_id' => $request->sparepart_id,
        'gudang_id'    => $request->gudang_id,
    ])->first();

    if ($stok) {
        $stok->jumlah_stok += $request->jumlah;
        $stok->save();
    } else {
        StockSparepart::create([
            'sparepart_id' => $request->sparepart_id,
            'gudang_id'    => $request->gudang_id,
            'harga_satuan' => $hargaSatuan, // masih disimpan kalau kamu mau tracking histori harga
            'jumlah_stok'  => $request->jumlah,
        ]);
    }

    return redirect()->route('DataMasuk')->with('success', 'Data masuk berhasil ditambahkan.');
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

    public function getSpareparts(Request $request)
    {
        $search = $request->get('q');
        $gudangId = $request->get('gudang_id'); // ambil ID gudang dari request

        $spareparts = Sparepart::with(['stok' => function($query) use ($gudangId) {
            if ($gudangId) {
                $query->where('gudang_id', $gudangId); // filter stok hanya dari gudang terpilih
            }
        }])
        ->where(function($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('no_barang', 'like', "%{$search}%");
        })
        ->get();

        return response()->json(
            $spareparts->map(function ($item) {
                $stok = $item->stok->sum('jumlah_stok') ?? 0;

                return [
                    'id' => $item->id,
                    'text' => '[' . $item->no_barang . '] - ' . $item->name . ' (Stok Gudang: ' . $stok . ')',
                    'harga' => $item->harga,
                    'stok' => $stok
                ];
            })
        );
    }



    public function rekapTotalOrder($no_order = null)
    {
        // Ambil data dari tabel datamasuk dan sparepart
        $data = DB::table('datamasuk')
            ->join('sparepart', 'datamasuk.sparepart_id', '=', 'sparepart.id')
            ->select(
                'datamasuk.no_order',
                'sparepart.name as nama_barang',
                'datamasuk.jumlah',
                'datamasuk.harga_satuan',
                DB::raw('datamasuk.jumlah * datamasuk.harga_satuan as total_harga')
            )
            ->get()
            ->groupBy('no_order');

        // Jika $no_order di-parameter-kan, hanya ambil data yang sesuai dengan no_order tersebut
        if ($no_order) {
            $data = $data->only([$no_order]);
        }

        // Menghitung total harga untuk setiap no_order
        $rekap = [];

        foreach ($data as $no_order => $items) {
            $rekap[$no_order] = [
                'items' => $items,
                'total' => $items->sum('total_harga')
            ];
        }

        // Kirim data yang sudah difilter dan dihitung
        return view('DataBarang.rekap_total_order', compact('rekap'));
    }
}
