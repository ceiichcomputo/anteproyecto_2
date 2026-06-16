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
        CatNombramiento::create(['nombramiento' => ' Investigador Asociado C de Tiempo Completo']);    
        CatNombramiento::create(['nombramiento' => ' Investigador Asociado C, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Investigador Titular A, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Investigador Titular A, Tiempo Completo. Definitivo.']);    
        CatNombramiento::create(['nombramiento' => ' Investigador Titular B, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Investigador Titular C, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Investigadora Asociada C, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Investigadora Asociado C, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Investigadora Titular A, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Investigadora Titular B, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Investigadora Titular C, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Profesor Titular C, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Profesora Titular C, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Técnica Académica']);    
        CatNombramiento::create(['nombramiento' => ' Técnica Académica Titular A, T. C.']);    
        CatNombramiento::create(['nombramiento' => ' Técnica Asociada B, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Técnica Asociada C, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Técnica Titular A, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Técnica Titular B, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Técnica Titular C, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Técnico Asociado B, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Técnico Asociado C, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Técnico Titular A, T.C.']);    
        CatNombramiento::create(['nombramiento' => ' Técnico Titular C, T.C.']);    

    }
}
