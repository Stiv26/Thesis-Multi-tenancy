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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('idNotifikasi');
            $table->foreignId('Users_pengirim')->constrained('users')->onDelete('cascade');
            $table->string('pesan', 225)->nullable(false);
            $table->date('tanggal')->nullable(false);
            $table->enum('status', ['Terkirim', 'Terbaca'])->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
