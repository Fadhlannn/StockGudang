<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoutesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('routes')->insert([
            [
                'kode_route' => 'R-JKT-BDG',
                'asal' => 'Jakarta',
                'tujuan' => 'Bandung',
                'jarak_km' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_route' => 'R-BDG-SBY',
                'asal' => 'Bandung',
                'tujuan' => 'Surabaya',
                'jarak_km' => 700,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_route' => 'R-SBY-MDN',
                'asal' => 'Surabaya',
                'tujuan' => 'Medan',
                'jarak_km' => 1900,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
