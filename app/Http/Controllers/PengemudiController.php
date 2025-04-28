<?php

namespace App\Http\Controllers;

use App\Models\Pengemudi;
use Illuminate\Http\Request;

class PengemudiController extends Controller
{
    public function index(){
        $pengemudi = Pengemudi::paginate(2);
        return view('DataBarang.Pengemudi', compact('pengemudi'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:pengemudi,nip',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        Pengemudi::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('Pengemudi')->with('success', 'Data pengemudi berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:pengemudi,nip,' . $id,
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        $pengemudi = Pengemudi::findOrFail($id);
        $pengemudi->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('Pengemudi')->with('success', 'Data pengemudi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengemudi = Pengemudi::findOrFail($id);
        $pengemudi->delete();
        return redirect()->route('Pengemudi')->with('success', 'Data pengemudi berhasil dihapus.');
    }

}
