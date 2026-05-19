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
        Schema::table('t_anteproyectos_rubros_viajes', function (Blueprint $table) {            
            // Optional: Position it after a specific column
            $table->string('lugar_institucion')->after('id_cat_estado'); 
            $table->string('fecha_inicio_viaje')->after('lugar_institucion'); 
            $table->string('fecha_fin_viaje')->after('fecha_inicio_viaje'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_anteproyectos_rubros_viajes', function (Blueprint $table) {
            $table->dropColumn(['lugar_institucion', 'fecha_inicio_viaje', 'fecha_fin_viaje']);
        });
    }
};
