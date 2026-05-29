<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CatCategoria;

class CatCategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CatCategoria::create([
            'id_rubro' => '1',
            'categoria' => 'Apoyo a la investigación',
            'descripcion' => 'Apoyo a la investigación',
            'usuario_ins' => 1,
        ]);
        CatCategoria::create([
            'id_rubro' => '1',
            'categoria' => 'Estancia posdoctoral',
            'descripcion' => 'Estancia posdoctoral',
            'usuario_ins' => 1,
        ]);
        CatCategoria::create([
            'id_rubro' => '1',
            'categoria' => 'Documentador',
            'descripcion' => 'Documentador',
            'usuario_ins' => 1,
        ]);
        CatCategoria::create([
            'id_rubro' => '2',
            'categoria' => 'Equipo de cómputo',
            'descripcion' => 'Equipo de cómputo',
            'usuario_ins' => 1,
        ]);
        CatCategoria::create([
            'id_rubro' => '2',
            'categoria' => 'Software',
            'descripcion' => 'Software',
            'usuario_ins' => 1,
        ]);
        CatCategoria::create([
            'id_rubro' => '3',
            'categoria' => 'Ponencia',
            'descripcion' => 'Ponencia',
            'usuario_ins' => 1,
        ]);
        CatCategoria::create([
            'id_rubro' => '3',
            'categoria' => 'Conferencia',
            'descripcion' => 'Conferencia',
            'usuario_ins' => 1,
        ]);
        CatCategoria::create([
            'id_rubro' => '4',
            'categoria' => 'Financiamiento Externo',
            'descripcion' => 'Financiamiento Externo',
            'usuario_ins' => 1,
        ]);
        CatCategoria::create([
            'id_rubro' => '5',
            'categoria' => 'Boleto de Avión + viáticos 3 días',
            'descripcion' => 'Boleto de Avión + viáticos 3 días',
            'usuario_ins' => 1,
        ]);
        CatCategoria::create([
            'id_rubro' => '6',
            'categoria' => 'Préstamos',
            'descripcion' => 'Son préstamos',
            'usuario_ins' => 1,
        ]);
        CatCategoria::create([
            'id_rubro' => '7',
            'categoria' => 'Promoción de Pride',
            'descripcion' => 'Promoción de Pride',
            'usuario_ins' => 1,
        ]);
        CatCategoria::create([
            'id_rubro' => '8',
            'categoria' => 'Boleto de avión',
            'descripcion' => 'Boleto de avión',
            'usuario_ins' => 1,
        ]);
        CatCategoria::create([
            'id_rubro' => '8',
            'categoria' => 'Boleto de avión + viáticos 3 días',
            'descripcion' => 'Boleto de avión + viáticos 3 días',
            'usuario_ins' => 1,
        ]);
    }
}
