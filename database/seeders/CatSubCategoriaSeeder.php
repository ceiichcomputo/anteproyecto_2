<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CatSubCategoria;

class CatSubCategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CatSubCategoria::create([
            'id_categoria' => '1',
            'subcategoria' => 'Apoyo a la investigación',
            'descripcion' => 'Apoyo a la investigación',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => true,
            'requiere_comentarios' => true,
            'monto_estimado' => 11000,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '1',
            'subcategoria' => 'Sin apoyo económico',
            'descripcion' => 'Sin apoyo económico',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => true,
            'requiere_comentarios' => true,
            'monto_estimado' => .1,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '2',
            'subcategoria' => 'Estancia Posdoctoral',
            'descripcion' => 'Estancia Posdoctoral',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => true,
            'requiere_comentarios' => true,
            'monto_estimado' => 14000,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '3',
            'subcategoria' => 'Documentador',
            'descripcion' => 'Documentador',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => true,
            'requiere_comentarios' => true,
            'monto_estimado' => 4900,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '4',
            'subcategoria' => 'Laptop Intermedia',
            'descripcion' => 'Laptop Intermedia',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => false,
            'requiere_comentarios' => true,
            'monto_estimado' => 30000,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '4',
            'subcategoria' => 'servidor',
            'descripcion' => 'servidor',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => true,
            'requiere_comentarios' => true,
            'monto_estimado' => 100000,
            'usuario_ins' => 1,
        ]);
    }
}
