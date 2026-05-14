<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['nombramiento'])]
class CatNombramiento extends Model
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
}

