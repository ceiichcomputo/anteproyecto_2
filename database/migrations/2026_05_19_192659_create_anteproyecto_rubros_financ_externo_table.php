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
        Schema::create('t_anteproyectos_rubros_fin_exts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_anteproyecto_rubros');
            $table->unsignedBigInteger('id_tipo_financiamiento');
            $table->text('titulo_proyecto');
            $table->text('nombre_dependencia');
            $table->date('fecha_inicio_evento');
            
            $table->foreign('id_anteproyecto_rubros')->references('id')->on('t_anteproyectos_rubros')->onDelete('cascade');
            $table->foreign('id_tipo_financiamiento')->references('id')->on('cat_tipo_financiamientos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_anteproyectos_rubros_fin_exts');
    }
};
