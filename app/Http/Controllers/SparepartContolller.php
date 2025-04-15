<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;

class SparepartContolller extends Controller
{
    public function index(Request $request)
    {
        $search = $request -> input("search");

        $queryBuilder = Sparepart::orderBy('created_at', 'asc'); // Query dasar untuk mengambil data

        // Tambahkan pencarian jika ada query
        if ($search) {
            $queryBuilder->where('name', 'like', "%{$search}%");
        }
        $spareparts = $queryBuilder->paginate(5);
        return view('DataBarang.Sparepart', compact('spareparts'));
    }
    public function store(Request $request){
        $validated = $request->validate([
            'no_barang'=>'required',
            'name'=>'required',
            'kategory'=>'required',
            'harga'=>'required',
            'satuan'=>'required',
            'keterangan_part'=>'required',

        ]);
        Sparepart::create([
            'no_barang' => $validated['no_barang'],
            'name' => $validated['name'],
            'kategory' => $validated['kategory'],
            'harga' => $validated['harga'],
            'satuan' => $validated['satuan'],
            'keterangan_part' => $validated['keterangan_part'],
        ]);
        return redirect()->route('Sparepart')->with('success','Data Berhasil ditambahkan');
    }
    public function destroy($id){
        $spareparts = Sparepart::findOrFail($id);
        $spareparts->delete();
        return redirect()->back()->with('success','Permission Berhasil dihapus.');
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'no_barang'=>'required',
            'name'=>'required',
            'kategory'=>'required',
            'harga'=>'required',
            'satuan'=>'required',
            'keterangan_part'=>'required',

        ]);

        $spareparts = Sparepart::findOrFail($id);
        $spareparts->update([
            'no_barang' => $validated['no_barang'],
            'name' => $validated['name'],
            'kategory' => $validated['kategory'],
            'harga' => $validated['harga'],
            'satuan' => $validated['satuan'],
            'keterangan_part' => $validated['keterangan_part'],
        ]);

        return redirect()->route('Sparepart')->with('success', 'Permission berhasil diperbarui.');
    }
}
