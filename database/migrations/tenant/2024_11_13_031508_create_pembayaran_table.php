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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('idPembayaran');
            $table->foreignId('idKontrak')->references('idKontrak')->on('kontrak')->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('total_bayar')->nullable(false);
            $table->foreignId('idMetodePembayaran')->nullable()->references('idMetodePembayaran')->on('metodepembayaran')->onDelete('cascade');
            $table->enum('status', ['Belum Lunas', 'Lunas'])->nullable(false);
            $table->string('keterangan', 255)->nullable();
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
