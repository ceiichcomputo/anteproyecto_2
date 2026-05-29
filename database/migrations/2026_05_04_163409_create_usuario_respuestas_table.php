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
        Schema::create('t_acad_respuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ejercicio');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_cat_pregunta');
            $table->unsignedBigInteger('id_cat_respuesta');
            $table->text('comentarios')->nullable();
            $table->unsignedBigInteger('usuario_mod')->nullable();
            $table->unsignedBigInteger('usuario_del')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_ejercicio')->references('id')->on('cat_ejercicios')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_cat_pregunta')->references('id')->on('cat_preguntas')->onDelete('cascade');
            $table->foreign('id_cat_respuesta')->references('id')->on('cat_respuestas')->onDelete('cascade');
            $table->foreign('usuario_mod')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('usuario_del')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_acad_respuestas');
    }
};
