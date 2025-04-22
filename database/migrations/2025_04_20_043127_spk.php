<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_spk')->unique(); // SPK-0001, dll
            $table->foreignId('bus_primajasa_id')->constrained('bus_primajasa')->onDelete('cascade'); // bus yang dikerjakan
            $table->foreignId('pengemudi_id')->nullable()->constrained('pengemudi')->onDelete('set null');
            $table->foreignId('mekanik_id')->nullable()->constrained('mekanik')->onDelete('set null'); // Nama teknisi
            $table->foreignId('bagian_gudang_id')->nullable()->constrained('bagian_gudang')->onDelete('set null');
            $table->foreignId('kode_rusak_id')->constrained('kode_rusak')->onDelete('cascade');
            $table->foreignId('gudang_id')->constrained('gudang')->onDelete('cascade');
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade'); // contoh
            $table->date('tanggal_keluar')->nullable();
            $table->string('km_standar');
            $table->text('deskripsi_pekerjaan'); // misal: Ganti oli & rem
            $table->date('tanggal_spk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
