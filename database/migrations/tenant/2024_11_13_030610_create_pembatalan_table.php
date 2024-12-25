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
        Schema::create('pembatalan', function (Blueprint $table) {
            $table->id('idPembatalan');
            $table->foreignId('idKontrak')->references('idKontrak')->on('kontrak')->onDelete('cascade');
            $table->enum('deposit', ['Kembalikan', 'Potong'])->nullable(false);
            $table->integer('pengembalian_deposit')->nullable(false);
            $table->date('tanggal')->nullable(false);
            $table->string('alasan', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembatalan');
    }
};
