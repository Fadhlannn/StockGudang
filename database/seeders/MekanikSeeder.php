<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MekanikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mekanik')->insert([
            [
                'nama' => 'Rahmat Hidayat',
                'nip' => 'MK001',
                'no_hp' => '081212341234',
                'alamat' => 'Jl. Mangga Besar No. 10, Jakarta',
                'gudang_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dewi Sartika',
                'nip' => 'MK002',
                'no_hp' => '082212345678',
                'alamat' => 'Jl. Anggrek No. 25, Bandung',
                'gudang_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Surya Putra',
                'nip' => 'MK003',
                'no_hp' => '083312347654',
                'alamat' => 'Jl. Kenanga No. 7, Surabaya',
                'gudang_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
