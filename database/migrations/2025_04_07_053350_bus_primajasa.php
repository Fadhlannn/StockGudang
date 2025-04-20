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
        Schema::create('bus_primajasa', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_polisi')->unique();
            $table->string('nomor_body')->unique();
            $table->timestamps();
            $table->foreignId('route_id')->nullable()->constrained('routes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_primajasa');
    }
};
