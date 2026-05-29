<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);



         $this->call([
            //CatCategoriaAcademicasSeeder::class,
            CatEjercicioSeeder::class,
            CatRubroSeeder::class,
            CatCategoriaSeeder::class,
            CatSubCategoriaSeeder::class,
            CatEstadoSeeder::class,
            CatNombramientoSeeder::class,
            CatPaisSeeder::class,
            CatPreguntaSeeder::class,
            CatRespuestaSeeder::class,
            //CatTipoFinanciamientoSeeder::class,
            //CatTipoSolicitudesSeeder::class,
        ]);


    }
}
