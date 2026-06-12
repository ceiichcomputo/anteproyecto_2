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
        Schema::table('cat_ejercicios', function (Blueprint $table) {            
            // Optional: Position it after a specific column
            $table->date('fecha_captura_inicio')->after('usuario_ins')->nullable(); 
            $table->date('fecha_captura_fin')->after('fecha_captura_inicio')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cat_ejercicios', function (Blueprint $table) {
            $table->dropColumn(['fecha_captura_inicio', 'fecha_captura_fin']);
        });
    }
};
