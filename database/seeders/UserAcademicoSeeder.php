<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UsersDetalle;
use Illuminate\Support\Facades\Hash;

class UserAcademicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //$usuarioacad = User::findOrFail(2); //Lo mejor sería crearlos al momento y relacionarlos, pero por ahora se hace así
        // UsersDetalle::create(['id_usuario' => 2, 'apellido_paterno' => 'Académico','apellido_materno' => 'Académico','nombres' => 'Académico','id_nombramiento' => '1',]);

        // $usuario_1 = User::create([ 'name' => 'Maya Aguiluz Ibargüen', 'email' => 'aguiluz@unam.mx',  'password' => Hash::make('duar48'), ]);           UsersDetalle::create([ 'id_usuario' => $usuario_1->id,'apellido_paterno' => 'Aguiluz',  'apellido_materno' => 'Ibargüen', 'nombres' => 'Maya', ]);             $usuario_1->assignRole('Académico'); 
        // $usuario_2 = User::create([ 'name' => 'Lucía Álvarez Enríquez', 'email' => 'lalvarez@unam.mx',  'password' => Hash::make('rsMri93'), ]);           UsersDetalle::create([ 'id_usuario' => $usuario_2->id,'apellido_paterno' => 'Álvarez',  'apellido_materno' => 'Enríquez', 'nombres' => 'Lucía', ]);             $usuario_2->assignRole('Académico'); 


    // $usuario_77 = User::create([ 'name' => 'Adrián Pineda', 'email' => 'adrian.pineda@ceiich.unam.mx',  'password' => Hash::make('RTh356'), ]);           UsersDetalle::create([ 'id_usuario' => $usuario_77->id,'apellido_paterno' => 'Pineda',  'apellido_materno' => '', 'nombres' => 'Adrian', ]);             $usuario_77->assignRole('Administrador'); 
    // $usuario_85 = User::create([ 'name' => 'Secretaría Técnica', 'email' => 'secretaria.tecnica@ceiich.unam.mx',  'password' => Hash::make('Jgh431'), ]);           UsersDetalle::create([ 'id_usuario' => $usuario_85->id,'apellido_paterno' => 'Técnica',  'apellido_materno' => '', 'nombres' => 'Secretaría', ]);             $usuario_85->assignRole('Secretaria técnica'); 
    // $usuario_87 = User::create([ 'name' => 'Secretaría Académica', 'email' => 'planeacionyseguimiento@ceiich.unam.mx',  'password' => Hash::make('p74s3g'), ]);           UsersDetalle::create([ 'id_usuario' => $usuario_87->id,'apellido_paterno' => 'Académica',  'apellido_materno' => '', 'nombres' => 'Secretaría', ]);             $usuario_87->assignRole('Secretaría académica'); 

    }
}
