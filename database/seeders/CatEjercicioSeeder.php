<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CatEjercicio;

class CatEjercicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CatEjercicio::create([
            'ejercicio' => '2027',
            'usuario_ins' => 1,
        ]);
    }
}
