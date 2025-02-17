<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Menu;
use App\Models\RoleMenu;

class HakAksesController extends Controller
{
    public function hakakses()
    {
        // Ambil semua user dengan role terkait
        $users = User::with('role')->get();

        // Ambil semua role
        $roles = Role::all();

        // Ambil semua menu
        $allMenus = Menu::all();

        // Inisialisasi array untuk menyimpan data role, total user dan menu yang bisa diedit
        $roleData = [];

        foreach ($roles as $role) {
            // Ambil total user berdasarkan role
            $totalUsers = User::where('role_id', $role->id)->count();

            // Ambil menu yang bisa diedit berdasarkan role dan hak akses
            $editableMenus = RoleMenu::where('role_id', $role->id)
                ->where('can_access', true)
                ->get();

            // Simpan data ke dalam array
            $roleData[] = [
                'role' => $role,
                'total_users' => $totalUsers,
                'editable_menus' => $editableMenus
            ];
        }

        // Kirim data roleData, allMenus, dan users ke view
        return view('konfigurasi.hakakses', compact('users', 'roleData', 'allMenus'));
    }

    public function hakaksesrole()
    {
        // Ambil semua user dengan role terkait
        $users = User::with('role')->get();

        // Ambil semua role
        $roles = Role::all();

        // Ambil semua menu
        $allMenus = Menu::all();

        // Inisialisasi array untuk menyimpan data role, total user dan menu yang bisa diedit
        $roleData = [];

        foreach ($roles as $role) {
            // Ambil total user berdasarkan role
            $totalUsers = User::where('role_id', $role->id)->count();

            // Ambil menu yang bisa diedit berdasarkan role dan hak akses
            $editableMenus = RoleMenu::where('role_id', $role->id)
                ->where('can_access', true)
                ->get();

            // Simpan data ke dalam array
            $roleData[] = [
                'role' => $role,
                'total_users' => $totalUsers,
                'editable_menus' => $editableMenus
            ];
        }
        // Kirim data roleData dan allMenus ke view
        return view('konfigurasi.hakakses', compact('users', 'roleData', 'allMenus'));

    }

    public function editrole($role_id)
    {
        // Ambil role dan menu terkait untuk editing
        $role = Role::findOrFail($role_id);
        $menus = Menu::all();
        return view('edit-access', compact('role', 'menus'));
    }

    public function updaterole(Request $request, $role_id)
    {
        // Ambil semua menu ID yang dikirim dari form
        $menus = $request->input('menus', []);

        // Temukan role berdasarkan role_id
        $role = Role::findOrFail($role_id);

        // Ambil semua menu yang ada
        $allMenus = Menu::pluck('id')->toArray();

        // Loop melalui semua menu dan update can_accsess berdasarkan input user
        foreach ($allMenus as $menu_id) {
            $can_access = in_array($menu_id, $menus); // Jika menu_id ada di array $menus, berarti true
            RoleMenu::updateOrCreate(
                ['role_id' => $role->id, 'menu_id' => $menu_id],
                ['can_access' => $can_access]
            );
        }

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('hakaksesrole')->with('success', 'Hak akses berhasil diperbarui');
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
}
