<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnteproyectosRubroExport implements FromCollection, WithHeadings
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query
            ->get()
            ->map(function ($anteproyecto) {

                return [
                    'id' => $anteproyecto->id,
                    'usuario_id' => $anteproyecto->anteproyecto->id_usuario,
                    'apellido_paterno' => $anteproyecto->anteproyecto->usuario->detalle->apellido_paterno,
                    'apellido_materno' => $anteproyecto->anteproyecto->usuario->detalle->apellido_materno,
                    'nombre_usuario' => $anteproyecto->anteproyecto->usuario->detalle->nombres,
                    'ejercicio' => $anteproyecto->anteproyecto->ejercicio->ejercicio,
                    'rubro' => $anteproyecto->subcategoria->categoria->rubro->titulo,
                    'categoria' => $anteproyecto->subcategoria->categoria->categoria,
                    'subcategoria' => $anteproyecto->subcategoria->subcategoria,
                    'monto_estimado' => $anteproyecto->monto_estimado,
                    'usado' => $anteproyecto->devengado ? 'Sí' : 'No',
                    'becarios_actividades_a_desarrollar' => $anteproyecto->rubros_becario->actividades_a_desarrollar ?? 'N/A',
                    'becarios_nombre_becario' =>  $anteproyecto->rubros_becario->nombre_becario ?? 'N/A',
                    'becarios_fecha_inicio_becario' => $anteproyecto->rubros_becario->fecha_inicio_becario ?? 'N/A',
                    'becarios_fecha_fin_becario' => $anteproyecto->rubros_becario->fecha_fin_becario ?? 'N/A',
                    'computo_justificacion_objeto_comprar' => $anteproyecto->rubros_computo->justificacion_objeto_comprar ?? 'N/A',
                    'evento_nombre_evento' => $anteproyecto->rubros_eventos->nombre_evento ?? 'N/A',
                    'evento_descripcion_evento' => $anteproyecto->rubros_eventos->descripcion_evento ?? 'N/A',
                    'evento_fecha_inicio_evento' => $anteproyecto->rubros_eventos->fecha_inicio_evento ?? 'N/A',
                    'evento_fecha_fin_evento' => $anteproyecto->rubros_eventos->fecha_fin_evento ?? 'N/A',
                    'fin_ext_tipo_financiamiento' => $anteproyecto->rubros_fin_exts->tipo_financiamiento->tipo_financiamiento ?? 'N/A',
                    'fin_ext_titulo_del_proyecto' => $anteproyecto->rubros_fin_exts->titulo_proyecto ?? 'N/A',
                    'fin_ext_nombre_dependencia' => $anteproyecto->rubros_fin_exts->nombre_dependencia ?? 'N/A',
                    'fin_ext_fecha_inicio_evento' => $anteproyecto->rubros_fin_exts->fecha_inicio_evento ?? 'N/A',
                    'fin_ext_fecha_fin_evento' => $anteproyecto->rubros_fin_exts->fecha_fin_evento ?? 'N/A',
                    'invitados_actividades_a_desarrollar' => $anteproyecto->rubros_invitados->actividades_a_desarrollar ?? 'N/A',
                    'invitados_descripcion' => $anteproyecto->rubros_invitados->descripcion_evento ?? 'N/A',
                    'invitados_nombre_invitado' => $anteproyecto->rubros_invitados->nombre_invitado ?? 'N/A',
                    'invitados_procedencia_invitado' => $anteproyecto->rubros_invitados->procedencia_invitado ?? 'N/A',
                    'invitados_fecha_inicio_evento' => $anteproyecto->rubros_invitados->fecha_inicio_evento ?? 'N/A',
                    'invitados_fecha_fin_evento' => $anteproyecto->rubros_invitados->fecha_fin_evento ?? 'N/A',
                    'peticion_peticion' => $anteproyecto->rubros_otr_pets->peticion ?? 'N/A',
                    'promocion_tipo_solicitud' => $anteproyecto->rubros_promos->tipo_solicitud->tipo_solicitud ?? 'N/A',
                    'promocion_categoria_academica' => $anteproyecto->rubros_promos->categoria_academica->categoria_academica ?? 'N/A',
                    'promocion_descripcion' => $anteproyecto->rubros_promos->descripcion ?? 'N/A',
                    'promocion_fecha_inicio_promocion' => $anteproyecto->rubros_promos->fecha_inicio_promocion ?? 'N/A',
                    'promocion_fecha_fin_promocion' => $anteproyecto->rubros_promos->fecha_fin_promocion ?? 'N/A',
                    'viajes_destino' => ($anteproyecto->rubros_viajes !== null) ? $anteproyecto->rubros_viajes->estado->pais->pais . ' - ' . $anteproyecto->rubros_viajes->estado->estado : 'N/A',
                    'viajes_lugar_institucion' => $anteproyecto->rubros_viajes->lugar_institucion ?? 'N/A',
                    'viajes_fecha_inicio_viaje' => $anteproyecto->rubros_viajes->fecha_inicio_viaje ?? 'N/A',
                    'viajes_fecha_fin_viaje' => $anteproyecto->rubros_viajes->fecha_fin_viaje ?? 'N/A',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Usuario ID',
            'Apellido Paterno',
            'Apellido Materno',
            'Nombre',
            'Ejercicio',
            'Rubro',
            'Categoría',
            'Subcategoría',
            'Presupuesto Estimado',
            'Usado',
            'Becarios_Actividades_a_Desarrollar',
            'Becarios_Nombre_Becario',
            'Becarios_Fecha_Inicio_Becario',
            'Becarios_Fecha_Fin_Becario',
            'Computo_Justificacion_objeto_comprar',
            'Evento Nombre Evento',
            'Evento Descripción Evento',
            'Evento Fecha Inicio Evento',
            'Evento Fecha Fin Evento',
            'Fin Ext Tipo financiamiento',
            'Fin Ext Titulo del proyecto',
            'Fin Ext Nombre dependencia',
            'Fin Ext Fecha inicio Evento',
            'Fin Ext Fecha fin Evento',
            'Invitados act a desarrollar',
            'Invitados descripcion',
            'Invitados Nombre invitado',
            'Invitados Procedencia invitado',
            'Invitados Fecha inicio evento',
            'Invitados Fecha fin evento',
            'Peticion Petición',
            'Promocion Tipo solicitud',
            'Promocion Categoría académica',
            'Promocion Descripción',
            'Promocion Fecha inicio promoción',
            'Promocion Fecha fin promoción',
            'Viajes Destino',
            'Viajes Lugar institución',
            'Viajes Fecha inicio viaje',
            'Viajes Fecha fin viaje'
        ];
    }
}
