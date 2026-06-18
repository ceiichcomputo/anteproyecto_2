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
            'tipo_solicitud' => 'COA',
            'usuario_ins' => 1
        ]);
        CAtTipoSolicitudes::create([
            'tipo_solicitud' => 'Promoción',
            'usuario_ins' => 1
        ]);
        CAtTipoSolicitudes::create([
            'tipo_solicitud' => 'Definitividad',
            'usuario_ins' => 1
        ]);
        CAtTipoSolicitudes::create([
            'tipo_solicitud' => 'Sabático disfrute',
            'usuario_ins' => 1
        ]);
        CAtTipoSolicitudes::create([
            'tipo_solicitud' => 'Sabático diferimiento',
            'usuario_ins' => 1
        ]);
        CAtTipoSolicitudes::create([
            'tipo_solicitud' => 'Superación académica',
            'usuario_ins' => 1
        ]);
    }
}
