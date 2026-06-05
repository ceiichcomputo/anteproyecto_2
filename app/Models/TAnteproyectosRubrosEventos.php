<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['id_anteproyecto_rubros','nombre_evento','descripcion_evento','fecha_inicio_evento','fecha_fin_evento'])]
class TAnteproyectosRubrosEventos extends Model
{
    public $timestamps = false;

    public function anteproyectos_rubros()
    {
        return $this->belongsTo(
            TAnteproyectosRubro::class,
            'id_anteproyecto_rubros'
        );
    }
}
