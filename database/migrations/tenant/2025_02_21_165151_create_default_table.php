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
        Schema::create('default', function (Blueprint $table) {
            $table->id('idDefault');
            $table->integer('pertanggal_tagihan_bulan')->nullable();
            $table->integer('pertanggal_denda_bulan')->nullable();
            $table->integer('nominal_deposit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default');
    }
};
