<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['jercicio','usuario_ins'])]
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
