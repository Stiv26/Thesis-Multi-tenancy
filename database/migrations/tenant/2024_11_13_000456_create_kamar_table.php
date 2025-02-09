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
        Schema::create('kamar', function (Blueprint $table) {
            $table->id('idKamar');
            $table->integer('harga')->nullable(false);
            $table->integer('harga_mingguan')->nullable();
            $table->integer('harga_harian')->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('keterangan', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};
