<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['id_anteproyecto_rubros','actividades_a_desarrollar','descripcion_evento','nombre_invitado','procedencia_invitado','fecha_inicio_evento','fecha_fin_evento'])]
class TAnteproyectosRubrosInvitados extends Model
{
    public $timestamps = false;
}
