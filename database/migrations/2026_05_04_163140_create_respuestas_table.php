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
        Schema::create('cat_respuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pregunta');
            $table->string('respuesta', 255);
            $table->unsignedBigInteger('usuario_ins');
            $table->unsignedBigInteger('usuario_mod');
            $table->unsignedBigInteger('usuario_del');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_pregunta')->references('id')->on('cat_preguntas')->onDelete('cascade');
            $table->foreign('usuario_ins')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('usuario_mod')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('usuario_del')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_respuestas');
    }
};
