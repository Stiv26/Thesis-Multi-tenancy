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
        Schema::create('dendaTambahan', function (Blueprint $table) {
            $table->foreignId('idDenda')->references('idDenda')->on('denda')->onDelete('cascade');
            $table->foreignId('idPembayaran')->references('idPembayaran')->on('pembayaran')->onDelete('cascade');
            $table->integer('nominal_denda');
        
            $table->primary(['idDenda', 'idPembayaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denda_kontrak');
    }
};
