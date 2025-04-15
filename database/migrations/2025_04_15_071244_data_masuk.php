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
        Schema::create('DataMasuk', function (Blueprint $table) {
            $table->id();
            $table->integer('no_order');
            $table->date('Tanggal_masuk');
            $table->foreignId('sparepart_id')->constrained('sparepart')->onDelete('cascade');
            $table->integer('jumlah');
            $table->foreignId('supliers_id')->constrained('supliers')->onDelete('cascade');
            $table->foreignId('gudang_id')->constrained('gudang')->onDelete('cascade');
            $table->foreignId('bagian_gudang_id')->constrained('bagian_gudang')->onDelete('cascade');
            $table->string('keterangan');
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
