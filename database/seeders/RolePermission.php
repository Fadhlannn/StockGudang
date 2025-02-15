<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolePermissions = [
            // Admin memiliki semua izin
            ['role_id' => 1, 'permission_id' => 1, 'can_access' => true], // create_menu
            ['role_id' => 1, 'permission_id' => 2, 'can_access' => true], // edit_menu
            ['role_id' => 1, 'permission_id' => 3, 'can_access' => true], // delete_menu
        ];

        DB::table('role_permission')->insert($rolePermissions);
    }
}
