<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiSparepart;
use App\Models\Sparepart;
use App\Models\gudang;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input("search");
        $filter_jns= $request->get('filter_jns');
        $filter_gdg = $request->get('filter_gdg');
        $filter_year = $request->get('filter_year');
        $filter_month = $request->get('filter_month');

        $queryBuilder = TransaksiSparepart::with(['sparepart', 'gudang'])->orderBy('tanggal', 'asc');

        if ($search) {
            $queryBuilder->whereHas('sparepart', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            });
        }

        if($filter_jns){
            $queryBuilder->where('jenis_transaksi',$filter_jns);
        }

        if($filter_gdg){
            $queryBuilder->where('gudang_id',$filter_gdg);
        }
        if ($filter_year) {
            $queryBuilder->whereYear('tanggal', $filter_year);
        }

        if ($filter_month) {
            $queryBuilder->whereMonth('tanggal', $filter_month);
        }

        $transaksi = $queryBuilder->paginate(5);
        $gudangs = gudang::all();

        return view('DataBarang.Riwayat', compact('transaksi', 'gudangs','filter_jns','filter_gdg'));
    }

    public function exportPDF(Request $request)
{
    $search = $request->input("search");
    $filter_jns = $request->get('filter_jns');
    $filter_gdg = $request->get('filter_gdg');
    $filter_year = $request->get('filter_year');
    $filter_month = $request->get('filter_month');

    $queryBuilder = TransaksiSparepart::with(['sparepart', 'gudang'])->orderBy('tanggal', 'asc');

    if ($search) {
        $queryBuilder->whereHas('sparepart', function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        });
    }

    if ($filter_jns) {
        $queryBuilder->where('jenis_transaksi', $filter_jns);
    }

    if ($filter_gdg) {
        $queryBuilder->where('gudang_id', $filter_gdg);
    }

    if ($filter_year) {
        $queryBuilder->whereYear('tanggal', $filter_year);
    }

    if ($filter_month) {
        $queryBuilder->whereMonth('tanggal', $filter_month);
    }

    $transaksi = $queryBuilder->get();
    $gudangs = gudang::all();

    // Render view menjadi PDF
    $pdf = Pdf::loadView('DataBarang.RiwayatPDF', compact('transaksi', 'gudangs', 'filter_jns', 'filter_gdg'));

    return $pdf->download('riwayat_transaksi.pdf');
}
}
