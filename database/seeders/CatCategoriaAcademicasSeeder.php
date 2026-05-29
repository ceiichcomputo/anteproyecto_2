<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CatCategoriaAcademicas;

class CatCategoriaAcademicasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CatCategoriaAcademicas::create([
            'categoria_academica' => 'Investigador Asociado C',
        ]);
        CatCategoriaAcademicas::create([
            'categoria_academica' => 'Técnica Académica Asociada C',
        ]);
    }
}
