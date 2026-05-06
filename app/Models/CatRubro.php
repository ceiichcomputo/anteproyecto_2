<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['titulo','descripcion','imagen','activo','usuario_mod'])]
class CatRubro extends Model
{
    use HasFactory;
    use SoftDeletes;

    // protected $fillable = [
    //     'titulo',
    //     'descripcion',
    //     'imagen',
    //     'activo',
    //     'usuario_mod',
    // ];
}
