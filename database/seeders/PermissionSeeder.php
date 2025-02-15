<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'create_menu'],
            ['name' => 'edit_menu'],
            ['name' => 'delete_menu'],
        ];

        DB::table('permission')->insert($permissions);
    }
}
