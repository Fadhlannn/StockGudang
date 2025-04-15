<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class bagian_gudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bagian_gudang')->insert([
            [
                'nama' => 'Ahmad Subari',
                'nip' => 'BG001',
                'no_hp' => '081234567890',
                'gudang_id' => 1, // pastikan ini ID gudang yang ada
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dewi Anggraini',
                'nip' => 'BG002',
                'no_hp' => '082134567891',
                'gudang_id' => 2, // sesuaikan juga
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
