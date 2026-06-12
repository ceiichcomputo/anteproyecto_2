<?php

namespace App\Services;

use App\Models\TAnteproyectos;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AnteproyectoRubroService
{
    public function ValidaSiSePuedeAgregar(TAnteproyectos $anteproyecto): bool
    {
        $fechaInicio = Carbon::parse($anteproyecto->ejercicio->fecha_captura_inicio);
        $fechaFin = Carbon::parse($anteproyecto->ejercicio->fecha_captura_fin);


        if($anteproyecto->enviado == 1){
                // throw ValidationException::withMessages([
                //     'error' =>
                //         'El anteproyecto ya no puede modificarse.'
                // ]);
            return false;
        } 
        if (!Carbon::now('America/Mexico_City')->betweenIncluded($fechaInicio, $fechaFin)) {
            return false;
        }
        return true;
    }
}