<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable(['id_anteproyecto_rubros','objeto_comprar','justificacion_objeto_comprar','usuario_mod','usuario_del','deleted_at'])]
class TAnteproyectosRubrosComputos extends Model
{
    use HasFactory;
    use SoftDeletes;
}
