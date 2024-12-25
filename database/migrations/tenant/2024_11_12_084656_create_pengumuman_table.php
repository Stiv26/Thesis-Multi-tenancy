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
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id('idPengumuman');
            $table->foreignId('Users_id')->constrained('users')->onDelete('cascade');
            $table->string('pesan', 255)->nullable(false);
            $table->date('tanggal')->nullable(false);
            $table->date('tgl_expired');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            //
        });
    }
};
