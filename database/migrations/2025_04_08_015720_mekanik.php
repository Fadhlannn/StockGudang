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
        Schema::create('mekanik', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->unique(); // Nomor identitas pengemudi
            $table->string('no_hp');
            $table->string('alamat')->nullable();
            $table->foreignId('gudang_id')->constrained('gudang')->onDelete('cascade');
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
