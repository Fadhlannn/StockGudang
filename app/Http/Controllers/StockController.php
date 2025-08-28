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

    // Query stok yang digabung berdasarkan sparepart dan gudang
    $queryBuilder = DB::table('stok_sparepart as ss')
        ->select(
            'ss.sparepart_id',
            'ss.gudang_id',
            DB::raw('SUM(ss.jumlah_stok) as total_stok'),
            's.name as nama_sparepart',
            's.harga as harga_standart',
            'g.nama_gudang'
        )
        ->join('sparepart as s', 'ss.sparepart_id', '=', 's.id')
        ->join('gudang as g', 'ss.gudang_id', '=', 'g.id')
        ->groupBy('ss.sparepart_id', 'ss.gudang_id', 's.name', 's.harga', 'g.nama_gudang');

    // Filter nama sparepart
    if ($search) {
        $queryBuilder->where('s.name', 'like', "%{$search}%");
    }

    // Filter gudang
    if ($filter_gdg) {
        $queryBuilder->where('ss.gudang_id', $filter_gdg);
    }

    $stok = $queryBuilder->paginate(5);
    $gudangs = gudang::all();

    return view('DataBarang.stok', compact('stok', 'filter_gdg', 'gudangs'));
}


}
