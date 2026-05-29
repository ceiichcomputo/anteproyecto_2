<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['id_anteproyecto_rubros','objeto_comprar','justificacion_objeto_comprar','usuario_mod','usuario_del','deleted_at'])]
class TAnteproyectosRubrosComputos extends Model
{
    public function anteproyectos_rubros()
    {
        return $this->belongsTo(
            TAnteproyectosRubro::class,
            'id_anteproyecto_rubros'
        );
    }
}
