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
        Schema::table('datamasuk', function (Blueprint $table) {
            $table->decimal('harga_satuan', 15, 2)->after('jumlah');
            $table->integer('sisa_stok')->after('harga_satuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datamasuk', function (Blueprint $table) {
            $table->dropColumn('harga_satuan');
            $table->dropColumn('sisa_stok');
        });
    }
};
