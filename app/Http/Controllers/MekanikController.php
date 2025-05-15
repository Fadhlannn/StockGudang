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

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:mekanik,nip,' . $id, // Abaikan NIP milik sendiri
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'gudang_id' => 'required|exists:gudang,id',
        ]);

        // Cari data mekanik berdasarkan ID
        $mekanik = Mekanik::findOrFail($id);

        // Update data
        $mekanik->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'gudang_id' => $request->gudang_id,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data mekanik berhasil diperbarui.');
    }


    public function destroy($id){
        $mekanik = Mekanik::findOrFail($id);
        $mekanik->delete();

        return redirect()->back()->with('success', 'Data route berhasil dihapus.');
    }
}
