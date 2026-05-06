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
        Schema::create('cat_estados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pais');
            $table->string('estado', 255);
            $table->unsignedBigInteger('usuario_ins');
            $table->timestamps();

            $table->foreign('id_pais')->references('id')->on('cat_pais')->onDelete('cascade');
            $table->foreign('usuario_ins')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_estados');
    }
};
