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
            $table->date('tgl_tagihan')->nullable(false);
            $table->date('tgl_denda')->nullable(false);
            $table->date('tanggal')->nullable();
            $table->integer('total_bayar')->nullable(false);
            $table->enum('status', ['Belum Lunas', 'Verifikasi', 'Lunas'])->nullable(false);
            $table->foreignId('idMetodePembayaran')->nullable()->references('idMetodePembayaran')->on('metodepembayaran')->onDelete('cascade');
            $table->string('bukti', 255)->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->integer('dibayar')->nullable();
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
