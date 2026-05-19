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
        Schema::create('cat_subcategorias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_categoria');
            $table->string('subcategoria', 255);
            $table->text('descripcion')->nullable();
            $table->boolean('mostrar_monto_estimado')->default(false);
            $table->boolean('modificar_monto_estimado')->default(false);
            $table->boolean('requiere_comentarios')->default(false);
            $table->double('monto_estimado', 10, 2);
            $table->unsignedBigInteger('usuario_ins');
            $table->unsignedBigInteger('usuario_mod')->nullable();
            $table->unsignedBigInteger('usuario_del')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_categoria')->references('id')->on('cat_categorias')->onDelete('cascade');
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
        Schema::dropIfExists('cat_subcategorias');
    }
};
