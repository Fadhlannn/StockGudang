<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bus_primajasa')->insert([
            [
                'nomor_polisi' => 'B 1234 ABC',
                'nomor_body' => 'BPJ-001',
                'route_id' => 1, // pastikan ID ini sesuai dengan tabel routes
                'pengemudi_id' => 1, // pastikan ID ini sesuai dengan tabel pengemudi
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_polisi' => 'B 5678 DEF',
                'nomor_body' => 'BPJ-002',
                'route_id' => 2,
                'pengemudi_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
