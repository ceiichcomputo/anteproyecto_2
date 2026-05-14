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
        Schema::create('users_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->string('apellido_paterno', 255);
            $table->string('apellido_materno', 255)->nullable();
            $table->string('nombres', 255);
            $table->unsignedBigInteger('id_nombramiento')->nullable();
            $table->unsignedBigInteger('id_sni')->nullable();
            $table->unsignedBigInteger('id_pride')->nullable();
            $table->unsignedBigInteger('id_area_investigacion')->nullable();
            $table->unsignedBigInteger('id_programa_investigacion')->nullable();
            $table->timestamps();


            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_nombramiento')->references('id')->on('cat_nombramientos')->onDelete('cascade');
            $table->foreign('id_sni')->references('id')->on('cat_snis')->onDelete('cascade');
            $table->foreign('id_pride')->references('id')->on('cat_prides')->onDelete('cascade');
            $table->foreign('id_area_investigacion')->references('id')->on('cat_area_investigaciones')->onDelete('cascade');
            $table->foreign('id_programa_investigacion')->references('id')->on('cat_programa_investigaciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_detalles');
    }
};
