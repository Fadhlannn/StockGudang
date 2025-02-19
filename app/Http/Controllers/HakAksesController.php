<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Menu;
use App\Models\RoleMenu;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Hash;

class HakAksesController extends Controller
{
    public function hakakses()
    {
        // Ambil semua user dengan role terkait
        $users = User::with('role')->get();

        // Ambil semua role
        $roles = Role::all();

        // Ambil semua menu & permission
        $allMenus = Menu::all();
        $allPermissions = Permission::all(); // 🔥 Tambahkan ini

        // Inisialisasi array untuk menyimpan data role, total user, menu & permissions yang bisa diedit
        $roleData = [];

        foreach ($roles as $role) {
            // Ambil total user berdasarkan role
            $totalUsers = User::where('role_id', $role->id)->count();

            // Ambil menu yang bisa diedit berdasarkan role dan hak akses
            $editableMenus = RoleMenu::where('role_id', $role->id)
                ->where('can_access', true)
                ->get();

            // Ambil permission yang bisa diakses berdasarkan role
            $editablePermissions = RolePermission::where('role_id', $role->id)
                ->where('can_access', true)
                ->get(); // 🔥 Tambahkan ini

            // Simpan data ke dalam array
            $roleData[] = [
                'role' => $role,
                'total_users' => $totalUsers,
                'editable_menus' => $editableMenus,
                'editable_permissions' => $editablePermissions, // 🔥 Tambahkan ini
            ];
        }

        // Kirim data ke view
        return view('konfigurasi.hakakses', compact('users', 'roleData', 'allMenus', 'allPermissions','roles'));

    }


    public function hakaksesrole()
    {
        // Ambil semua user dengan role terkait
        $users = User::with('role')->get();

        // Ambil semua role
        $roles = Role::all();

        // Ambil semua menu
        $allMenus = Menu::all();
        $allPermissions = Permission::all();

        // Inisialisasi array untuk menyimpan data role, total user dan menu yang bisa diedit
        $roleData = [];

        foreach ($roles as $role) {
            // Ambil total user berdasarkan role
            $totalUsers = User::where('role_id', $role->id)->count();

            // Ambil menu yang bisa diedit berdasarkan role dan hak akses
            $editableMenus = RoleMenu::where('role_id', $role->id)
                ->where('can_access', true)
                ->get();

            $editablePermissions = RolePermission::where('role_id', $role->id)
                ->where('can_access', true)
                ->get();
            // Simpan data ke dalam array
            $roleData[] = [
                'role' => $role,
                'total_users' => $totalUsers,
                'editable_menus' => $editableMenus,
                'editable_permissions' => $editablePermissions,
            ];
        }
        // Kirim data roleData dan allMenus ke view
        return view('konfigurasi.hakakses', compact('users', 'roleData', 'allMenus', 'allPermissions', 'editablePermissions','roles'));

    }


    public function updaterole(Request $request, $role_id)
    {
        // Ambil semua permission ID dan menu ID yang dikirim dari form
        $permissions = $request->input('permissions', []);
        $menus = $request->input('menus', []);

        // Temukan role berdasarkan role_id
        $role = Role::findOrFail($role_id);

        // *Update Permission*
        $allPermissions = Permission::pluck('id')->toArray();
        foreach ($allPermissions as $permission_id) {
            $can_access = in_array($permission_id, $permissions);
            RolePermission::updateOrCreate(
                ['role_id' => $role->id, 'permission_id' => $permission_id],
                ['can_access' => $can_access]
            );
        }

        // *Update Menu*
        $allMenus = Menu::pluck('id')->toArray();
        foreach ($allMenus as $menu_id) {
            $can_access = in_array($menu_id, $menus);
            RoleMenu::updateOrCreate(
                ['role_id' => $role->id, 'menu_id' => $menu_id],
                ['can_access' => $can_access]
            );
        }

        return redirect()->route('hakaksesrole')->with('success', 'Hak akses dan izin berhasil diperbarui');
    }
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success','User Berhasil dihapus.');
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('hakakses')->with('success', 'Name berhasil diperbarui.');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role_id' => 'required|exists:role,id',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
        ]);

        return redirect()->route('hakakses')->with('success', 'User Berhasil Ditambahkan');
    }

}
