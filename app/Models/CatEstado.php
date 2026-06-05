<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatEstado extends Model
{
    public function rubros_viajes()
    {
        return $this->belongsTo(
            TAnteproyectosRubrosViajes::class,
            'id_estado'
        );
    }
    public function pais()
    {
        return $this->hasOne(
            CatPais::class,
            'id_pais'
        );
    }
}
