<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['id_anteproyecto','id_cat_subcategoria','devengado','observaciones','monto_estimado'])]
class TAnteproyectosRubrosViajes extends Model
{
    public $timestamps = false;
}
