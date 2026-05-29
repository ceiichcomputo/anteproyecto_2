<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CatNombramiento;

class CatNombramientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CatNombramiento::create([
            'nombramiento' => 'Técnico Académico Asociado C, T. C.'
        ]);
        CatNombramiento::create([
            'nombramiento' => 'Investigador Asociado C, T. C.'
        ]);
    }
}
