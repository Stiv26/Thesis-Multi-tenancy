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
        Schema::create('fasilitaskamar', function (Blueprint $table) {
            $table->foreignId('idFasilitas')->references('idFasilitas')->on('fasilitas')->onDelete('cascade');
            $table->foreignId('idKamar')->references('idKamar')->on('kamar')->onDelete('cascade');
        
            $table->primary(['idFasilitas', 'idKamar']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitaskamar');
    }
};
