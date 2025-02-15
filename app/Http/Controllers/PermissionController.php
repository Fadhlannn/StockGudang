<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;

class PermissionController extends Controller
{
    public function permission()
    {
        // Ambil semua role
        $roles = Role::all();

        // Ambil semua permission
        $permissions = Permission::all();

        // Ambil semua data role-permission
        $rolePermissions = RolePermission::all();

        return view('konfigurasi.permission', compact('roles', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $role_id)
    {
        // Ambil semua permission ID yang dikirim dari form
        $permissions = $request->input('permissions', []);

        // Ambil semua permission yang ada
        $allPermissions = Permission::pluck('id')->toArray();

        // Loop melalui semua permission untuk update can_access
        foreach ($allPermissions as $permission_id) {
            $can_access = in_array($permission_id, $permissions); // True jika checkbox dicentang

            RolePermission::updateOrCreate(
                ['role_id' => $role_id, 'permission_id' => $permission_id],
                ['can_access' => $can_access]
            );
        }

        return redirect()->route('permission')->with('success', 'Izin berhasil diperbarui');
    }
}
