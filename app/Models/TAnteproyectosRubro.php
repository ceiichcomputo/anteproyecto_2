<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable(['id_anteproyecto','id_cat_subcategoria','devengado','observaciones','monto_estimado','usuario_ins','usuario_mod','usuario_del','deleted_at'])]
class TAnteproyectosRubro extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function anteproyectos()
    {
        return $this->belongsTo(
            TAnteproyectos::class,
            'id_anteproyecto'
        );
    }
    public function subcategoria()
    {
        return $this->belongsTo(
            CatSubcategoria::class,
            'id_cat_subcategoria'
        );
    }
    public function rubros_becario()
    {
        return $this->hasMany(
            TAnteproyectosRubrosBecarios::class,
            'id_anteproyecto_rubros'
        );
    }
    public function rubros_computo()
    {
        return $this->hasMany(
            TAnteproyectosRubrosComputos::class,
            'id_anteproyecto_rubros'
        );
    }

}
