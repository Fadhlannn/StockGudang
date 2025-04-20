<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailRusakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detail_rusak')->insert([
            ['jenis_rusak' => 'Mesin','kode_rusak_id' => '1'],
            ['jenis_rusak' => 'AC','kode_rusak_id' => '2'],
            ['jenis_rusak' => 'Ban','kode_rusak_id' => '1'],
        ]);
    }
}
