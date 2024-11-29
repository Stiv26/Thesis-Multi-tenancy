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
        Schema::create('DataDiri', function (Blueprint $table) {
            $table->id('idDataDiri');
            $table->foreignId('idListDataDiri')->constrained('listDataDiri', 'idListDataDiri')->onDelete('cascade');
            $table->string('deskripsi', 255)->nullable(false);
            $table->foreignId('Users_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datadiri');
    }
};
