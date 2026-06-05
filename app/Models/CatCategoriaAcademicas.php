<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['categoria_academica'])]
class CatCategoriaAcademicas extends Model
{
    public function rubros_promos()
    {
        return $this->hasMany(
            TAnteproyectosRubrosPromos::class,
            'id_categoria_academica'
        );
    }
}
