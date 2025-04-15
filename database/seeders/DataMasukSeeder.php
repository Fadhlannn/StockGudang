<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('datamasuk')->insert([
            [
                'no_order' => 10001,
                'Tanggal_masuk' => '2025-04-01',
                'sparepart_id' => 1, // pastikan ID 1 ada di tabel sparepart
                'jumlah' => 20,
                'supliers_id' => 1, // pastikan ID 1 ada di tabel supliers
                'gudang_id' => 1, // pastikan ID 1 ada di tabel gudang
                'bagian_gudang_id' => 1, // pastikan ID 1 ada di tabel bagian_gudang
                'keterangan' => 'Pengiriman awal bulan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_order' => 10002,
                'Tanggal_masuk' => '2025-04-05',
                'sparepart_id' => 2,
                'jumlah' => 10,
                'supliers_id' => 2,
                'gudang_id' => 2,
                'bagian_gudang_id' => 2,
                'keterangan' => 'Restock item',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
