<?php

namespace App\Http\Controllers;

use App\Models\gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        $gudang = gudang::paginate(5);
        return view('InputData.Gudang', compact('gudang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_gudang' => 'required|string|max:255',
            'lokasi' => 'required|string',
        ]);

        gudang::create([
            'nama_gudang' => $request->nama_gudang,
            'lokasi' => $request->lokasi,
        ]);

        return redirect()->back()->with('success', 'Data Gudang berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $gudang = gudang::findOrFail($id);

        $validated = $request->validate([
            'nama_gudang' => 'required|string|max:255',
            'lokasi' => 'required|string',
        ]);

        $gudang->update($validated);

        $gudang->update([
            'nama_gudang' => $request->nama_gudang,
            'lokasi' => $request->lokasi,
        ]);

        return redirect()->back()->with('success', 'Data Gudang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $gudang = gudang::findOrFail($id);
        $gudang->delete();

        return redirect()->back()->with('success', 'Data supliers berhasil dihapus.');
    }
}
