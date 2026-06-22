<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['tipo_financiamiento','usuario_ins'])]
class CatTipoFinanciamiento extends Model
{
    public $timestamps = false;

    public function rubros_fin_ext()
    {
        return $this->hasMany(
            TAnteproyectosRubrosFinExts::class,
            'id_tipo_financiamiento'
        );
    }
}
