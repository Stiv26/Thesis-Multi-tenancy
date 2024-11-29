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
        Schema::create('biayakontrak', function (Blueprint $table) {
            $table->foreignId('idBiaya')->references('idBiaya')->on('biaya')->onDelete('cascade');
            $table->foreignId('idKontrak')->references('idKontrak')->on('kontrak')->onDelete('cascade');
        
            $table->primary(['idBiaya', 'idKontrak']);
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biayakontrak');
    }
};
