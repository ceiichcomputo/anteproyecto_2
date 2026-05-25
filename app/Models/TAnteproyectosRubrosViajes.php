<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable(['id_anteproyecto','id_cat_subcategoria','devengado','observaciones','monto_estimado','usuario_ins','usuario_mod','usuario_del','deleted_at'])]
class TAnteproyectosRubrosViajes extends Model
{
    use HasFactory;
    use SoftDeletes;
}
