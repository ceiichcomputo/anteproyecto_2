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
        Schema::create('cat_categorias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_rubro');
            $table->string('categoria', 255);
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('usuario_ins');
            $table->unsignedBigInteger('usuario_mod')->nullable();;
            $table->unsignedBigInteger('usuario_del')->nullable();;
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_rubro')->references('id')->on('cat_rubros')->onDelete('cascade');
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
        Schema::dropIfExists('cat_categorias');
    }
};
