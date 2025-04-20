<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengemudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengemudi')->insert([
            [
                'nama' => 'Ahmad Suryana',
                'nip' => 'PGM001',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 1, Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'nip' => 'PGM002',
                'no_hp' => '082233445566',
                'alamat' => 'Jl. Raya Bogor No. 45, Depok',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siti Aminah',
                'nip' => 'PGM003',
                'no_hp' => '083311223344',
                'alamat' => 'Jl. Soekarno Hatta No. 77, Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
