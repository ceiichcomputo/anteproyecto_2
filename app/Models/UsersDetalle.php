<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['id_usuario','apellido_paterno','apellido_materno','nombres','id_nombramiento','id_sni','id_pride','id_area_investigacion','id_programa_investigacion'])]
class UsersDetalle extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_usuario'
        );
    }
}
