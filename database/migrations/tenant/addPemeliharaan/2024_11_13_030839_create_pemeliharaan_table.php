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
        Schema::create('pemeliharaan', function (Blueprint $table) {
            $table->id('idPemeliharaan');
            $table->foreignId('idKontrak')->references('idKontrak')->on('kontrak')->onDelete('cascade');
            $table->string('fasilitas')->nullable(false);
            $table->string('pesan', 225)->nullable(false);
            $table->date('tanggal')->nullable(false);
            $table->datetime('tgl_pemeliharaan')->nullable();
            $table->enum('status', ['Permintaan', 'Pengerjaan', 'Tolak', 'Selesai'])->nullable(false);
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeliharaan');
    }
};
