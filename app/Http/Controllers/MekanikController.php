<?php

namespace App\Http\Controllers;

use App\Models\gudang;
use App\Models\Mekanik;
use Illuminate\Http\Request;

class MekanikController extends Controller
{
    public function index(){
        $mekanik = Mekanik::paginate(5);
        $gudang = gudang::all();
        return view('DataBarang.Mekanik', compact('mekanik','gudang'));
    }
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:mekanik,nip',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'gudang_id' => 'required|exists:gudang,id',
        ]);

        // Simpan data ke database
        Mekanik::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'gudang_id' => $request->gudang_id,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data mekanik berhasil ditambahkan.');
    }

    // public function update(Request $request, $id){

    //     $request->validate([
    //         'kode_route' => 'required|unique:routes,kode_route,' . $id,
    //         'nama_route' => 'required|string|max:255',
    //         'asal' => 'required|string|max:255',
    //         'tujuan' => 'required|string|max:255',
    //         'jarak_km' => 'nullable|integer|min:0',
    //     ]);

    //     $route = Route::findOrFail($id);
    //     $route->update([
    //         'kode_route' => $request->kode_route,
    //         'nama_route' => $request->nama_route,
    //         'asal' => $request->asal,
    //         'tujuan' => $request->tujuan,
    //         'jarak_km' => $request->jarak_km,
    //     ]);

    //     return redirect()->back()->with('success', 'Data route berhasil diperbarui.');
    // }

    // public function destroy($id){
    //     $route = Route::findOrFail($id);
    //     $route->delete();

    //     return redirect()->back()->with('success', 'Data route berhasil dihapus.');
    // }
}
