<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['id_anteproyecto_rubros','actividades_a_desarrollar','nombre_becario','fecha_inicio_becario','fecha_fin_becario','usuario_mod','usuario_del','deleted_at'])]
class TAnteproyectosRubrosBecarios extends Model
{

    public function anteproyectos_rubros()
    {
        return $this->belongsTo(
            TAnteproyectosRubro::class,
            'id_anteproyecto_rubros'
        );
    }
}
