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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('idTransaksi');
            $table->foreignId('idLayananTambahan')->references('idLayananTambahan')->on('layanantambahan')->onDelete('cascade');
            $table->foreignId('idKontrak')->references('idKontrak')->on('kontrak')->onDelete('cascade');
            $table->integer('jumlah')->nullable(false);
            $table->integer('total_bayar')->nullable(false);
            $table->foreignId('idMetodePembayaran')->nullable()->references('idMetodePembayaran')->on('metodepembayaran')->onDelete('cascade');
            $table->string('bukti', 255)->nullable();
            $table->date('tanggal')->nullable(false); 
            $table->dateTime('tgl_terima');
            $table->enum('pengantaran', ['Ambil Sendiri', 'Diantar'])->nullable(false);
            $table->enum('status_pengantaran', ['Menunggu', 'Sudah diantar', 'Ambil Sendiri', 'Selesai'])->nullable();
            $table->string('pesan', 255)->nullable();
            $table->enum('status', ['Belum Lunas', 'Verifikasi', 'Lunas'])->nullable(false);
            $table->integer('dibayar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
