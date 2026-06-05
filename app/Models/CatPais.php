<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['pais','iso_3','phone_code','activo','usuario_mod'])]
class CatPais extends Model
{
    use HasFactory;
    
    public function estados()
    {
        return $this->hasMany(
            CatEstado::class,
            'id_pais'
        );
    }
}
