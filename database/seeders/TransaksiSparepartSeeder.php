<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSparepartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaksi_sparepart')->insert([
            [
                'sparepart_id' => 1, // ID dari 'Ban Depan'
                'gudang_id' => 1, // ID dari 'Gudang Utama'
                'jenis_transaksi' => 'masuk',
                'jumlah' => 10,
                'tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sparepart_id' => 2, // ID dari 'Oli Mesin'
                'gudang_id' => 2, // ID dari 'Gudang Cadangan'
                'jenis_transaksi' => 'keluar',
                'jumlah' => 5,
                'tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
