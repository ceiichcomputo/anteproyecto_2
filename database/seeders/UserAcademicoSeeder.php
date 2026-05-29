<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UsersDetalle;

class UserAcademicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarioacad = User::findOrFail(2); //Lo mejor sería crearlos al momento y relacionarlos, pero por ahora se hace así
        UsersDetalle::create(['id_usuario' => 2, 'apellido_paterno' => 'Académico','apellido_materno' => 'Académico','nombres' => 'Académico','id_nombramiento' => '1',]);
    
    }
}
