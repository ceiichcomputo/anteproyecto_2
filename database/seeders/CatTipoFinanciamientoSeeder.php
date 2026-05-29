<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CatTipoFinanciamiento;

class CatTipoFinanciamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CatTipoFinanciamiento::create([
            'tipo_financiamiento' => 'PAPIIT',
            'usuario_ins' => 1
        ]);
        CatTipoFinanciamiento::create([
            'tipo_financiamiento' => 'CONACYT',
            'usuario_ins' => 1
        ]);
        CatTipoFinanciamiento::create([
            'tipo_financiamiento' => 'Otro',
            'usuario_ins' => 1
        ]);
    }
}
