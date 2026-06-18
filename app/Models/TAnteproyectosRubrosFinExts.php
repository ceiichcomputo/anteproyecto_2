<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['id_anteproyecto_rubros','id_tipo_financiamiento','titulo_proyecto','nombre_dependencia','fecha_inicio_evento'])]
class TAnteproyectosRubrosFinExts extends Model
{
    public $timestamps = false;

    public function anteproyectos_rubros()
    {
        return $this->belongsTo(
            TAnteproyectosRubro::class,
            'id_anteproyecto_rubros'
        );
    }
    public function tipo_financiamiento()
    {
        return $this->belongsTo(
            CatTipoFinanciamiento::class,
            'id_tipo_financiamiento'
        );
    }
}
