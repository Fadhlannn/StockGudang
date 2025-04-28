<?php

namespace App\Http\Controllers;

use App\Models\BusPrimajasa;
use App\Models\Route;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index(){
        $bus = BusPrimajasa::paginate(8);;
        $route = Route::all();
        return view('DataBarang.Bus', compact('bus','route'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nomor_body' => 'required|string|max:255',
        'nomor_polisi' => 'required|string|max:255',
        'route_id' => 'required|exists:routes,id', // pastikan tabel routes dan relasinya ada
    ]);

    BusPrimajasa::create([
        'nomor_body' => $request->nomor_body,
        'nomor_polisi' => $request->nomor_polisi,
        'route_id' => $request->route_id,
    ]);

    return redirect()->route('Bus')->with('success', 'Bus berhasil ditambahkan.');
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_body' => 'required|string|max:255',
            'nomor_polisi' => 'required|string|max:255',
            'route_id' => 'required|exists:routes,id',
        ]);

        $bus = BusPrimajasa::findOrFail($id);
        $bus->update([
            'nomor_body' => $request->nomor_body,
            'nomor_polisi' => $request->nomor_polisi,
            'route_id' => $request->route_id,
        ]);

        return redirect()->route('Bus')->with('success', 'Data Bus berhasil diperbarui.');
    }


    public function destroy($id){
        $bus = BusPrimajasa::findOrFail($id);
        $bus->delete();
        return redirect()->route('Bus')->with('success','Role Berhasil dihapus.');
    }
}
