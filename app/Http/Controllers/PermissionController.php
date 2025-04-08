<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request){
        $search = $request -> input("search");

        $queryBuilder = Permission::orderBy('created_at', 'asc'); // Query dasar untuk mengambil data

        // Tambahkan pencarian jika ada query
        if ($search) {
            $queryBuilder->where('name', 'like', "%{$search}%");
        }
        $permissions = $queryBuilder->paginate(5);
        return view('konfigurasi.permission',compact('permissions'));
    }
    public function destroy($id){
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->back()->with('success','Permission Berhasil dihapus.');
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('konfigurasi.permission')->with('success', 'Permission berhasil diperbarui.');
    }
    public function store(Request $request){
        $validated = $request->validate([
            'name'=>'required',
        ]);
        Permission::create([
            'name' => $validated['name'],
        ]);
        return redirect()->route('konfigurasi.permission')->with('success','Data Berhasil ditambahkan');
    }
}
