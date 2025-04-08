<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gudang')->insert([
            [
                'nama_gudang' => 'Gudang Utama',
                'lokasi' => 'Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_gudang' => 'Gudang Cadangan',
                'lokasi' => 'Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
