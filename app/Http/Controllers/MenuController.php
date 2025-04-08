<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            'name'=>'required',
            'url' =>'required',
            'category' =>'required',
        ]);
        Menu::create([
            'name' => $validated['name'],
            'url'=> $validated['url'],
            'category'=> $validated['category'],

        ]);
        return redirect()->route('index.menu')->with('success','Data Berhasil ditambahkan');
    }
    public function index(Request $request){

        $search = $request -> input("search");

        $queryBuilder = Menu::orderBy('created_at', 'asc'); // Query dasar untuk mengambil data

        // Tambahkan pencarian jika ada query
        if ($search) {
            $queryBuilder->where('name', 'like', "%{$search}%");
        }
        $menus = $queryBuilder->paginate(5);
        return view('konfigurasi.menu',compact('menus','search'));

    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'url' => 'required',
            'category' => 'required',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'category' => $validated['category'],
        ]);

        return redirect()->route('index.menu')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id){
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return redirect()->back()->with('success','Menu Berhasil dihapus.');
    }
}
