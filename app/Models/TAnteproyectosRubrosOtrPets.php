<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable(['id_anteproyecto_rubros','peticion','usuario_mod','usuario_del','deleted_at'])]
class TAnteproyectosRubrosOtrPets extends Model
{
    use HasFactory;
    use SoftDeletes;
}
