<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['id_anteproyecto','id_cat_subcategoria','devengado','observaciones','monto_estimado'])]
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
        return $this->hasOne(
            CatEstado::class,
            'id_estado'
        );
    }
}
