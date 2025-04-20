<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailSpkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detail_rusak_spk')->insert([
            ['spk_id' => 4, 'detail_rusak_id' => 1],
            ['spk_id' => 4, 'detail_rusak_id' => 2],
            // Tambahkan relasi detail rusak lainnya ke SPK
        ]);
    }
}
