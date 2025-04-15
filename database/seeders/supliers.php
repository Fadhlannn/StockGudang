<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class supliers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('supliers')->insert([
            [
                'nama' => 'PT Maju Jaya',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta',
                'telepon' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'CV Sejahtera',
                'alamat' => 'Jl. Merdeka No. 45, Bandung',
                'telepon' => '082134567891',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'UD Makmur Sentosa',
                'alamat' => 'Jl. Diponegoro No. 9, Surabaya',
                'telepon' => '083134567892',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
