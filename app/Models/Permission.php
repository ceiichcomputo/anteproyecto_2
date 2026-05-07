<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['module','name','description','is_active','guard_name'])]
class Permission extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'module',
    //     'name',
    //     'description',
    //     'is_active',
    //     'guard_name',
    // ];
}
