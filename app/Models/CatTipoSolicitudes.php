<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['tipo_solicitud','usuario_ins'])]
class CatTipoSolicitudes extends Model
{
    use HasFactory;
}
