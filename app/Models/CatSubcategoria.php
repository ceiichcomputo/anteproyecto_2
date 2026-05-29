<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['id_categoria', 'subcategoria', 'descripcion', 'mostrar_monto_estimado', 'modificar_monto_estimado', 'requiere_comentarios', 'monto_estimado', 'usuario_ins', 'usuario_mod', 'usuario_del'])]
class CatSubcategoria extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function categoria()
    {
        return $this->belongsTo(
            CatCategoria::class,
            'id_categoria'
        );
    }



    public function anteproyectos_rubros()
    {
        return $this->hasMany(
            TAnteproyectosRubro::class,
            'id_cat_subcategoria'
        );
    }
}