<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatEstado extends Model
{
    public function rubros_viajes()
    {
        return $this->hasMany(
            TAnteproyectosRubrosViajes::class,
            'id_estado'
        );
    }
    public function pais()
    {
        return $this->belongsTo(
            CatPais::class,
            'id_pais'
        );
    }
}
