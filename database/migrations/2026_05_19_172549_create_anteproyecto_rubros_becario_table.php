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
        Schema::create('t_anteproyectos_rubros_becarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_anteproyecto_rubros');
            $table->text('actividades_a_desarrollar');
            $table->text('nombre_becario');
            $table->date('fecha_inicio_becario');
            $table->date('fecha_fin_becario');

            $table->foreign('id_anteproyecto_rubros')->references('id')->on('t_anteproyectos_rubros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_anteproyectos_rubros_becarios');
    }
};
