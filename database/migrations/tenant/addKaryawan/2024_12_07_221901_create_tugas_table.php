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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id('idTugas');
            $table->string('tugas', 255)->nullable(false);
            $table->date('tanggal')->nullable(false);
            $table->enum('status', ['Belum Selesai', 'Selesai'])->nullable(false);
            $table->string('bukti', 255)->nullable();
            $table->date('tgl_update')->nullable();
            $table->foreignId('Users_id')->nullable()->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
