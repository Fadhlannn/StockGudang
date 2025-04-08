<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SparepartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sparepart')->insert([
            [
                'no_barang' => 'SP001',
                'name' => 'Kampas Rem',
                'kategory' => 'Rem',
                'harga' => 150000,
                'satuan' => 'Set',
                'keterangan_part' => 'Kampas rem depan untuk motor bebek',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_barang' => 'SP002',
                'name' => 'Busi',
                'kategory' => 'Mesin',
                'harga' => 50000,
                'satuan' => 'Pcs',
                'keterangan_part' => 'Busi NGK untuk motor sport',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_barang' => 'SP003',
                'name' => 'Oli Mesin',
                'kategory' => 'Pelumas',
                'harga' => 120000,
                'satuan' => 'Botol',
                'keterangan_part' => 'Oli sintetik 10W-40',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
