<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable(['id_anteproyecto','id_cat_subcategoria','devengado','observaciones','monto_estimado','usuario_ins','usuario_mod','usuario_del','deleted_at'])]
class TAnteproyectosRubro extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function anteproyecto()
    {
        return $this->belongsTo(
            TAnteproyectos::class,
            'id_anteproyecto'
        );
    }
    public function subcategoria()
    {
        return $this->belongsTo(
            CatSubcategoria::class,
            'id_cat_subcategoria'
        );
    }
    public function rubros_becario()
    {
        return $this->hasOne(
            TAnteproyectosRubrosBecarios::class,
            'id_anteproyecto_rubros'
        );
    }
    public function rubros_computo()
    {
        return $this->hasOne(
            TAnteproyectosRubrosComputos::class,
            'id_anteproyecto_rubros'
        );
    }
    public function rubros_eventos()
    {
        return $this->hasOne(
            TAnteproyectosRubrosEventos::class,
            'id_anteproyecto_rubros'
        );
    }
    public function rubros_fin_exts()
    {
        return $this->hasOne(
            TAnteproyectosRubrosFinExts::class,
            'id_anteproyecto_rubros'
        );
    }
    public function rubros_invitados()
    {
        return $this->hasOne(
            TAnteproyectosRubrosInvitados::class,
            'id_anteproyecto_rubros'
        );
    }
    public function rubros_otr_pets()
    {
        return $this->hasOne(
            TAnteproyectosRubrosOtrPets::class,
            'id_anteproyecto_rubros'
        );
    }
    public function rubros_promos()
    {
        return $this->hasOne(
            TAnteproyectosRubrosPromos::class,
            'id_anteproyecto_rubros'
        );
    }
    public function rubros_viajes()
    {
        return $this->hasOne(
            TAnteproyectosRubrosViajes::class,
            'id_anteproyecto_rubros'
        );
    }

}
