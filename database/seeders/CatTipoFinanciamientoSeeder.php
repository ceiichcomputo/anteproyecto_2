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
            'tipo_financiamiento' => 'PAPIIT'
        ]);
        CatTipoFinanciamiento::create([
            'tipo_financiamiento' => 'CONACYT'
        ]);
        CatTipoFinanciamiento::create([
            'tipo_financiamiento' => 'Otro'
        ]);
        CatTipoFinanciamiento::create([
            'tipo_financiamiento' => 'PAPIME'
        ]);
        CatTipoFinanciamiento::create([
            'tipo_financiamiento' => 'Sector público(Federal, estatal o municipal)'
        ]);
        CatTipoFinanciamiento::create([
            'tipo_financiamiento' => 'Sector privado'
        ]);
        CatTipoFinanciamiento::create([
            'tipo_financiamiento' => 'Otras universidades, centros o instituciones nacionales'
        ]);
    }
}
