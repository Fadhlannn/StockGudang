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

    $queryBuilder = DB::table('datamasuk as dm')
        ->select(
            'dm.sparepart_id',
            'dm.gudang_id',
            'dm.harga_satuan',
            DB::raw('SUM(dm.jumlah) - IFNULL(SUM(dk.jumlah), 0) as jumlah_stok'),
            's.name as nama_sparepart',
            's.harga as harga_standart',
            'g.nama_gudang'
        )
        ->leftJoin('datakeluar as dk', function($join) {
            $join->on('dm.sparepart_id', '=', 'dk.sparepart_id')
                ->on('dm.gudang_id', '=', 'dk.gudang_id')
                ->on('dm.harga_satuan', '=', 'dk.harga_satuan');
        })
        ->join('sparepart as s', 'dm.sparepart_id', '=', 's.id')
        ->join('gudang as g', 'dm.gudang_id', '=', 'g.id')
        ->groupBy('dm.sparepart_id', 'dm.gudang_id', 'dm.harga_satuan', 's.name', 's.harga', 'g.nama_gudang')
        ->havingRaw('jumlah_stok > 0')
        ->orderBy('dm.harga_satuan', 'asc');

    if ($search) {
        $queryBuilder->where('s.name', 'like', "%{$search}%");
    }

    if ($filter_gdg) {
        $queryBuilder->where('dm.gudang_id', $filter_gdg);
    }

    $stok = $queryBuilder->paginate(5);
    $gudangs = gudang::all();

    return view('DataBarang.stok', compact('stok', 'filter_gdg', 'gudangs'));
}
}
