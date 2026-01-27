<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('handphones', function (Blueprint $table) {
            $table->id();
            $table->string('merk');
            $table->integer('harga');
            $table->text('deskripsi');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('handphones');
    }
};