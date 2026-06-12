<?php

namespace App\Services;

use App\Models\TAnteproyectos;
use Carbon\Carbon;

class CatEjercicioService
{
    public function ValidaSiExisteParaUsuario(int $id_ejercicio, int $id_usuario): bool
    {
        // VALIDAR DUPLICADO
        $existe = TAnteproyectos::where('id_usuario', $id_usuario)->where(
                'id_ejercicio',
                $id_ejercicio
            )
            ->exists();

        return $existe;
    }
}