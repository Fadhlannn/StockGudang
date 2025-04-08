<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\StockSparepart;
use App\Models\gudang;


class StockController extends Controller
{
    public function index(Request $request)
    {
        $search = $request -> input("search");
        $filter_gdg = $request->get('filter_gdg');

        $queryBuilder = StockSparepart::with(['sparepart', 'gudang'])->orderBy('created_at', 'asc'); // Query dasar untuk mengambil data

        // Tambahkan pencarian jika ada query
        if ($search) {
            $queryBuilder->whereHas('sparepart', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            });
        }
        if ($filter_gdg) {
            $queryBuilder->where('gudang_id', $filter_gdg);
        }

        $stok = $queryBuilder->paginate(5);
        $gudangs = gudang::all();


        return view('DataBarang.stok', compact('stok','filter_gdg','gudangs'));
    }
}
