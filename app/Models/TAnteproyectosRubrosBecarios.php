<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable(['id_anteproyecto_rubros','actividades_a_desarrollar','nombre_becario','fecha_inicio_becario','fecha_fin_becario','usuario_mod','usuario_del','deleted_at'])]
class TAnteproyectosRubrosBecarios extends Model
{
    use HasFactory;
    use SoftDeletes;
}
