<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['id_rubro', 'categoria', 'descripcion', 'usuario_ins', 'usuario_mod', 'usuario_del'])]
class CatCategoria extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function userDetalle()
    {
        return $this->hasOne(
            UsersDetalle::class,
            'id_nombramiento'
        );
    }

    public function rubro()
    {
        return $this->belongsTo(
            CatRubro::class,
            'id_rubro'
        );
    }

    public function subcategorias()
    {
        return $this->hasMany(
            CatSubcategoria::class,
            'id_categoria'
        );
    }
}