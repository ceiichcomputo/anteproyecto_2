<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['id_anteproyecto_rubros','id_cat_estado','lugar_institucion','fecha_inicio_viaje','fecha_fin_viaje'])]
class TAnteproyectosRubrosViajes extends Model
{
    public $timestamps = false;

    public function anteproyectos_rubros()
    {
        return $this->belongsTo(
            TAnteproyectosRubro::class,
            'id_anteproyecto_rubros'
        );
    }
    public function estado()
    {
        return $this->belongsTo(
            CatEstado::class,
            'id_cat_estado'
        );
    }
}
