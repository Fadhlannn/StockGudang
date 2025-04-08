<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            'role'=>'required',
            'Guard_Name' =>'required',
        ]);
        Role::create([
            'role' => $validated['role'],
            'Guard_Name'=> $validated['Guard_Name'],
        ]);
        return redirect()->route('index.role')->with('success','Data Berhasil ditambahkan');
    }
    public function index(Request $request){
        $search = $request -> input("search");

        $queryBuilder = Role::orderBy('created_at', 'asc'); // Query dasar untuk mengambil data

        // Tambahkan pencarian jika ada query
        if ($search) {
            $queryBuilder->where('role', 'like', "%{$search}%");
        }
        $roles = $queryBuilder->paginate(5);
        return view('konfigurasi.role',compact('roles'));
    }
    public function destroy($id){
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->back()->with('success','Role Berhasil dihapus.');
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'role' => 'required',
            'Guard_Name' => 'required',
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'role' => $validated['role'],
            'Guard_Name' => $validated['Guard_Name'],
        ]);

        return redirect()->route('index.role')->with('success', 'Role berhasil diperbarui.');
    }
}
