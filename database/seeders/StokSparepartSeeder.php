<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSparepartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stok_sparepart')->insert([
            [
                'sparepart_id' => 1, // ID dari 'Ban Depan'
                'gudang_id' => 1, // ID dari 'Gudang Utama'
                'jumlah_stok' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sparepart_id' => 2, // ID dari 'Oli Mesin'
                'gudang_id' => 2, // ID dari 'Gudang Cadangan'
                'jumlah_stok' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

    }
}
