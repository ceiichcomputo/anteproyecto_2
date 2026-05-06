<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable(['pais','iso_3','phone_code','activo','usuario_mod'])]
class CatPais extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'titulo',
    //     'descripcion',
    //     'imagen',
    //     'activo',
    //     'usuario_mod',
    // ];
}
