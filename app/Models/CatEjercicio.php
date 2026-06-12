<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['ejercicio','usuario_ins', 'fecha_captura_inicio', 'fecha_captura_fin'])]
class CatEjercicio extends Model
{
    use HasFactory;

    public function anteproyectos()
    {
        return $this->hasMany(
            TAnteproyectos::class,
            'id_ejercicio'
        );
    }
}
