<?php

namespace App\Http\Controllers;

use App\Models\Supliers;
use Illuminate\Http\Request;

class SupliersController extends Controller
{
    public function index()
    {
        $supliers = Supliers::paginate(5);
        return view('DataBarang.Supliers', compact('supliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
        ]);

        Supliers::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Data mekanik berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $suplier = Supliers::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
        ]);

        $suplier->update($validated);

        $suplier->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        return redirect()->back()->with('success', 'Data suplier berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $suplier = Supliers::findOrFail($id);
        $suplier->delete();

        return redirect()->back()->with('success', 'Data supliers berhasil dihapus.');
    }
}
