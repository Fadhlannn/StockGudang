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
        Schema::create('detail_rusak_spk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spk_id')->constrained('spk')->onDelete('cascade');
            $table->foreignId('detail_rusak_id')->constrained('detail_rusak')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_rusak_spk');
    }
};
