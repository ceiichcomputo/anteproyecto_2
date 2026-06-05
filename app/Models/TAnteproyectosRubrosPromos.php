<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['id_anteproyecto_rubros','id_tipo_solicitud','id_categoria_academica','descripcion_promocion','fecha_inicio_promocion','fecha_fin_promocion'])]
class TAnteproyectosRubrosPromos extends Model
{
    public $timestamps = false;

    public function anteproyectos_rubros()
    {
        return $this->belongsTo(
            TAnteproyectosRubro::class,
            'id_anteproyecto_rubros'
        );
    }
    public function tipo_solicitud()
    {
        return $this->belongsTo(
            CatTipoSolicitudes::class,
            'id_tipo_solicitud'
        );
    }
    public function categoria_academica()
    {
        return $this->belongsTo(
            CatCategoriaAcademicas::class,
            'id_categoria_academica'
        );
    }
}
