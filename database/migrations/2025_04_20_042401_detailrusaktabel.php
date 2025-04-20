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
        Schema::create('detail_rusak', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_rusak');
            $table->foreignId('kode_rusak_id')->constrained('kode_rusak')->onDelete('cascade'); // bus yang dikerjakan
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
