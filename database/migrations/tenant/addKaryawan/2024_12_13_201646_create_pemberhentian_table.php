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
        Schema::create('pemberhentian', function (Blueprint $table) {
            $table->id('idPemberhentian');
            $table->string('alasan', 255)->nullable();
            $table->date('tanggal')->nullable(false);
            $table->foreignId('Users_id')->references('id')->on('users')->nullable()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemberhentian');
    }
};
