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
        Schema::create('biayalainnya', function (Blueprint $table) {
            $table->foreignId('idBiaya')->references('idBiaya')->on('biaya')->onDelete('cascade');
            $table->foreignId('idPembayaran')->references('idPembayaran')->on('pembayaran')->onDelete('cascade');
            $table->integer('harga')->nullable(false);

            $table->primary(['idBiaya', 'idPembayaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biayalainnya');
    }
};
