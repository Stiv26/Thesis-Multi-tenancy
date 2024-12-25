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
        Schema::create('renter', function (Blueprint $table) {
            $table->id(); 
            $table->string('no_telp')->nullable(false);
            $table->string('password');
            $table->string('nama')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('alamat')->nullable(false);
            $table->string('keterangan')->nullable();
        
            $table->unsignedInteger('domains_id'); 
            $table->foreign('domains_id')->references('id')->on('domains')->onDelete('cascade');

            $table->foreignId('Users_id')->references('id')->on('users')->onDelete('cascade');
        
            $table->timestamps();
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renter');
    }
};
