<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable(['id_ejercicio','id_usuario','devengado','created_at','updated_at'])]
class TAnteproyectos extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function ejercicio()
    {
        return $this->belongsTo(
            CatEjercicio::class,
            'id_ejercicio'
        );
    }
}
