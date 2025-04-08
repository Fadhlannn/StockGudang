<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiSparepart;
use App\Models\User;
use App\Models\Gudang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil total transaksi
        $totalTransaksi = TransaksiSparepart::count();

        // Mengambil total pengguna
        $totalUsers = User::count();

        // Mengambil jumlah gudang yang tersedia
        $totalGudang = Gudang::count();

        // Mengambil data transaksi per bulan
        $transaksiPerBulan = TransaksiSparepart::selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return view('dashboard', compact('totalTransaksi', 'totalUsers', 'totalGudang', 'transaksiPerBulan'));
    }
}
