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
        Schema::create('t_anteproyectos_rubros_promos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_anteproyecto_rubros');
            $table->unsignedBigInteger('id_tipo_solicitud');
            $table->unsignedBigInteger('id_categoria_academica');
            $table->text('descripcion_promocion');
            $table->date('fecha_inicio_promocion');
            $table->date('fecha_fin_promocion');
            $table->unsignedBigInteger('usuario_mod');
            $table->unsignedBigInteger('usuario_del');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_anteproyecto_rubros')->references('id')->on('t_anteproyectos_rubros')->onDelete('cascade');
            $table->foreign('id_tipo_solicitud')->references('id')->on('cat_tipo_solicitudes')->onDelete('cascade');
            $table->foreign('id_categoria_academica')->references('id')->on('cat_categoria_academicas')->onDelete('cascade');
            $table->foreign('usuario_mod')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('usuario_del')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_anteproyectos_rubros_promos');
    }
};
