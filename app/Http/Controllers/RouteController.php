<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index(){
        $route = Route::paginate(5);
        return view('DataBarang.route', compact('route'));
    }
    public function store(Request $request){

        $request->validate([
            'kode_route' => 'required|unique:routes,kode_route',
            'nama_route' => 'required|string|max:255',
            'asal' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'jarak_km' => 'nullable|integer|min:0',
        ]);

    // Simpan data ke database
        Route::create([
            'kode_route' => $request->kode_route,
            'nama_route' => $request->nama_route,
            'asal' => $request->asal,
            'tujuan' => $request->tujuan,
            'jarak_km' => $request->jarak_km,
        ]);

    // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data route berhasil ditambahkan.');
    }
    public function update(Request $request, $id){
        
        $request->validate([
            'kode_route' => 'required|unique:routes,kode_route,' . $id,
            'nama_route' => 'required|string|max:255',
            'asal' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'jarak_km' => 'nullable|integer|min:0',
        ]);

        $route = Route::findOrFail($id);
        $route->update([
            'kode_route' => $request->kode_route,
            'nama_route' => $request->nama_route,
            'asal' => $request->asal,
            'tujuan' => $request->tujuan,
            'jarak_km' => $request->jarak_km,
        ]);

        return redirect()->back()->with('success', 'Data route berhasil diperbarui.');
    }

    public function destroy($id){
        $route = Route::findOrFail($id);
        $route->delete();

        return redirect()->back()->with('success', 'Data route berhasil dihapus.');
    }
}
