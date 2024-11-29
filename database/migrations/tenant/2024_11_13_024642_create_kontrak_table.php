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
        Schema::create('kontrak', function (Blueprint $table) {
            $table->id('idKontrak');
            $table->foreignId('idKamar')->references('idKamar')->on('kamar')->onDelete('cascade');
            $table->foreignId('Users_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('harga')->nullable(false);
            $table->enum('rentang', ['Bulan', 'Mingguan', 'Harian'])->nullable(false);
            $table->integer('waktu')->nullable(false);
            $table->date('tgl_masuk')->nullable(false);
            $table->date('tgl_tagihan')->nullable(false);
            $table->date('tgl_denda')->nullable(false);
            $table->date('tgl_keluar')->nullable();
            $table->integer('deposit')->nullable();
            $table->string('keterangan', 255)->nullable(false);
            $table->enum('status', ['Aktif', 'Nonaktif'])->nullable(false);
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak');
    }
};
