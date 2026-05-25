<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable(['id_anteproyecto_rubros','id_tipo_solicitud','id_categoria_academica','descripcion_promocion','fecha_inicio_promocion','fecha_fin_promocion','usuario_mod','usuario_del','deleted_at'])]
class TAnteproyectosRubrosPromos extends Model
{
    use HasFactory;
    use SoftDeletes;
}
