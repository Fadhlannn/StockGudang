<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KodeRusakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kode_rusak')->insert([
            ['kode_rusak' => 'RSK-001','created_at' => now(),'updated_at' => now(),],
            ['kode_rusak' => 'RSK-002','created_at' => now(),'updated_at' => now(),],
            ['kode_rusak' => 'RSK-003','created_at' => now(),'updated_at' => now(),],
        ]);
    }
}
