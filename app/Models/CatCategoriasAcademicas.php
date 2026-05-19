<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['categoria_academica','usuario_ins'])]
class CatCategoriasAcademicas extends Model
{
    use HasFactory;
}
