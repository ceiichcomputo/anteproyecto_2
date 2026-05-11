<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

#[Fillable(['name','description','is_active','guard_name'])]
class Role extends SpatieRole
{
    use HasFactory;

    // protected $fillable = [
    //     'name',
    //     'description',
    //     'is_active',
    //     'guard_name',
    // ];
}
