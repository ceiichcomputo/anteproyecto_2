<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CAtTipoSolicitudes;

class CatTipoSolicitudesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CAtTipoSolicitudes::create([
            'tipo_solicitud' => 'COA'
        ]);
        CAtTipoSolicitudes::create([
            'tipo_solicitud' => 'Promoción'
        ]);
        CAtTipoSolicitudes::create([
            'tipo_solicitud' => 'Definitividad'
        ]);
        CAtTipoSolicitudes::create([
            'tipo_solicitud' => 'Sabático disfrute'
        ]);
        CAtTipoSolicitudes::create([
            'tipo_solicitud' => 'Sabático diferimiento'
        ]);
        CAtTipoSolicitudes::create([
            'tipo_solicitud' => 'Superación académica'
        ]);
    }
}
