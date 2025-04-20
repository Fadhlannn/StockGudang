<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SpkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('spk')->insert([
            [
                'nomor_spk' => 'SPK-0001',
                'bus_primajasa_id' => 1, // Misal: bus_primajasa_id
                'pengemudi_id' => 1, // Misal: pengemudi_id
                'mekanik_id' => 4, // Misal: mekanik_id
                'bagian_gudang_id' => 1, // Misal: bagian_gudang_id
                'kode_rusak_id' => 1, // Misal: kode_rusak_id
                'gudang_id' => 1, // Misal: gudang_id
                'tanggal_keluar' => Carbon::now()->format('Y-m-d'),
                'km_standar' => '100000', // Misal: kilometer standar
                'deskripsi_pekerjaan' => 'Ganti oli & rem',
                'tanggal_spk' => Carbon::now()->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor_spk' => 'SPK-0002',
                'bus_primajasa_id' => 2,
                'pengemudi_id' => 2,
                'mekanik_id' => 5,
                'bagian_gudang_id' => 2,
                'kode_rusak_id' => 2,
                'gudang_id' => 2,
                'tanggal_keluar' => Carbon::now()->format('Y-m-d'),
                'km_standar' => '120000',
                'deskripsi_pekerjaan' => 'Ganti ban & servis rem',
                'tanggal_spk' => Carbon::now()->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Tambahkan SPK lainnya jika perlu
        ]);
    }
}
