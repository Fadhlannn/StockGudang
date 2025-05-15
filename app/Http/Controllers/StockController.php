<?php

namespace App\Http\Controllers;

use App\Models\DataMasuk;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\StockSparepart;
use App\Models\gudang;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input("search");
    $filter_gdg = $request->get('filter_gdg');

    // Mulai dengan query builder di tabel stok_sparepart
    $queryBuilder = DB::table('stok_sparepart as ss')
        ->select(
            'ss.sparepart_id',
            'ss.gudang_id',
            'ss.harga_satuan',
            DB::raw('ss.jumlah_stok as jumlah_stok'),
            's.name as nama_sparepart',
            's.harga as harga_standart',
            'g.nama_gudang'
        )
        ->join('sparepart as s', 'ss.sparepart_id', '=', 's.id')
        ->join('gudang as g', 'ss.gudang_id', '=', 'g.id')
        ->orderBy('ss.harga_satuan', 'asc');

    // Menambahkan filter pencarian berdasarkan nama sparepart
    if ($search) {
        $queryBuilder->where('s.name', 'like', "%{$search}%");
    }

    // Menambahkan filter berdasarkan gudang jika ada
    if ($filter_gdg) {
        $queryBuilder->where('ss.gudang_id', $filter_gdg);
    }
    $queryBuilder->where('ss.jumlah_stok', '>', 0);

    // Ambil data dengan paginasi
    $stok = $queryBuilder->paginate(5);
    $gudangs = gudang::all();

    // Kembalikan view dengan data stok dan filter gudang
    return view('DataBarang.stok', compact('stok', 'filter_gdg', 'gudangs'));
}

}
