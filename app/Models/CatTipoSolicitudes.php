<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['tipo_solicitud','usuario_ins'])]
class CatTipoSolicitudes extends Model
{
    public function rubros_promos()
    {
        return $this->hasMany(
            TAnteproyectosRubrosPromos::class,
            'id_tipo_financiamiento'
        );
    }
}
