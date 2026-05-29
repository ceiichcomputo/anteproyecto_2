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
        Schema::create('t_anteproyectos_rubros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_anteproyecto');
            $table->unsignedBigInteger('id_cat_subcategoria');
            $table->boolean('devengado')->default(false);
            $table->text('observaciones')->nullable();
            $table->double('monto_estimado', 10, 2);
            $table->unsignedBigInteger('usuario_ins');
            $table->unsignedBigInteger('usuario_mod')->nullable();
            $table->unsignedBigInteger('usuario_del')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_anteproyecto')->references('id')->on('t_anteproyectos')->onDelete('cascade');
            $table->foreign('id_cat_subcategoria')->references('id')->on('cat_subcategorias')->onDelete('cascade');
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
        Schema::dropIfExists('t_anteproyectos_rubros');
    }
};
