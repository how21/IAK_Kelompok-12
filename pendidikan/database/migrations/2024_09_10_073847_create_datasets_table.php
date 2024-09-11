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
        Schema::create('datasets', function (Blueprint $table) {
            $table->string('pokok'); 
            $table->string('tingkat'); 
            $table->string('ket'); 
            $table->string('provinsi'); 
            $table->integer('nilai'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datasets');
    }
};
