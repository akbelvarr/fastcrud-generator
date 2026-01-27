<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('Owner');
            $table->text('type');
            $table->integer('price');
            $table->date('date_place');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};