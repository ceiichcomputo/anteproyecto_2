<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CatRubro;

class CatRubroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CatRubro::create([
            'titulo' => 'Becarios',
            'descripcion' => 'Son los becarios',
            'activo' => true,
        ]);
        CatRubro::create([
            'titulo' => 'Cómputo',
            'descripcion' => 'Son los equipos de cómputo',
            'activo' => true,
        ]);
        CatRubro::create([
            'titulo' => 'Eventos',
            'descripcion' => 'Son los eventos',
            'activo' => true,
        ]);
        CatRubro::create([
            'titulo' => 'Financiamiento Externo',
            'descripcion' => 'Son los financiamientos externos',
            'activo' => true,
        ]);
        CatRubro::create([
            'titulo' => 'Invitados',
            'descripcion' => 'Son los invitados',
            'activo' => true,
        ]);
        CatRubro::create([
            'titulo' => 'Otras Peticiones',
            'descripcion' => 'Son las otras peticiones',
            'activo' => true,
        ]);
        CatRubro::create([
            'titulo' => 'Promociones',
            'descripcion' => 'Son las promociones',
            'activo' => true,
        ]);
        CatRubro::create([
            'titulo' => 'Viajes',
            'descripcion' => 'Son los viajes',
            'activo' => true,
        ]);
    }
}
