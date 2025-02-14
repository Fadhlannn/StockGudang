<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu')->insert([
            ['name' => 'Konfigurasi','order' => '0','url' => 'Konfigurasi','category'=>'Konfigurasi'],
            ['name' => 'Menu','order' => '0','url' => 'Konfigurasi/Menu','category'=>'Konfigurasi'],
            ['name' => 'Role','order' => '0','url' => 'Konfigurasi/Role','category'=>'Konfigurasi'],
            ['name' => 'Hak-Akses','order' => '0','url' => 'Konfigurasi/Hak-Akses','category'=>'Konfigurasi'],
            ['name' => 'Permission','order' => '0','url' => 'Konfigurasi/Permission','category'=>'Konfigurasi'],
        ]);
    }
}
