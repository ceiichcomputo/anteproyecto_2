<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['id_anteproyecto_rubros','nombre_evento','descripcion_evento','fecha_inicio_evento','fecha_fin_evento','usuario_mod','usuario_del','deleted_at'])]
class TAnteproyectosRubrosEventos extends Model
{
    use HasFactory;
    use SoftDeletes;
}
