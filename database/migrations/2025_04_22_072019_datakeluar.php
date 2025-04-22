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
        Schema::create('data_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spk_id')->constrained('spk')->onDelete('cascade');
            $table->foreignId('sparepart_id')->constrained('sparepart')->onDelete('cascade');
            $table->foreignId('gudang_id')->constrained('gudang')->onDelete('cascade');
            $table->foreignId('bagian_gudang_id')->constrained('bagian_gudang')->onDelete('cascade');
            $table->date('tanggal_keluar');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_keluar');
    }
};
