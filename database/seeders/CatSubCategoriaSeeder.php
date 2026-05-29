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
            'subcategoria' => 'Servidor',
            'descripcion' => 'Servidor',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => true,
            'requiere_comentarios' => true,
            'monto_estimado' => 100000,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '5',
            'subcategoria' => 'Licencia de Software',
            'descripcion' => 'Licencia de Atlas TI',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => true,
            'requiere_comentarios' => true,
            'monto_estimado' => 9000,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '6',
            'subcategoria' => 'Ponencia con Servicio de galletas 30 Personas',
            'descripcion' => 'Es un servicio para 30 personas',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => true,
            'requiere_comentarios' => true,
            'monto_estimado' => 3000,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '6',
            'subcategoria' => 'Ponencia sin Servicio de galletas',
            'descripcion' => 'Es sin servicio de galletas',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => true,
            'requiere_comentarios' => true,
            'monto_estimado' => .1,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '7',
            'subcategoria' => 'Conferencia con Servicio de Galletas',
            'descripcion' => 'Es con servicio de galletas para 30 personas',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => true,
            'requiere_comentarios' => true,
            'monto_estimado' => 3000,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '8',
            'subcategoria' => 'Lap top',
            'descripcion' => 'Es por un lap top',
            'mostrar_monto_estimado' => false,
            'modificar_monto_estimado' => false,
            'requiere_comentarios' => false,
            'monto_estimado' => .1,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '9',
            'subcategoria' => 'Boleto de Avión + viáticos 3 días',
            'descripcion' => 'Boleto de Avión + viáticos 3 días',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => false,
            'requiere_comentarios' => false,
            'monto_estimado' => 30000,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '10',
            'subcategoria' => 'Préstamos de auto',
            'descripcion' => 'Préstamos de auto',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => false,
            'requiere_comentarios' => false,
            'monto_estimado' => 7000,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '11',
            'subcategoria' => 'Promoción de Pride',
            'descripcion' => 'Promoción de Pride',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => false,
            'requiere_comentarios' => false,
            'monto_estimado' => 10000,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '12',
            'subcategoria' => 'Boleto de avión Nacional',
            'descripcion' => 'Boleto de avión Nacional',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => false,
            'requiere_comentarios' => false,
            'monto_estimado' => 5000,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '12',
            'subcategoria' => 'Boleto de avión de Europa',
            'descripcion' => 'Boleto de avión de Europa',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => false,
            'requiere_comentarios' => false,
            'monto_estimado' => 19000,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '13',
            'subcategoria' => 'Boleto de avión Nacional + viáticos 3 días',
            'descripcion' => 'Boleto de avión Nacional + viáticos 3 días',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => false,
            'requiere_comentarios' => false,
            'monto_estimado' => 11000,
            'usuario_ins' => 1,
        ]);
        CatSubCategoria::create([
            'id_categoria' => '13',
            'subcategoria' => 'Boleto de avión de Europa + viáticos 3 días',
            'descripcion' => 'Boleto de avión de Europa + viáticos 3 días',
            'mostrar_monto_estimado' => true,
            'modificar_monto_estimado' => false,
            'requiere_comentarios' => false,
            'monto_estimado' => 25000,
            'usuario_ins' => 1,
        ]);
    }
}
