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
            'Monto Estimado',
            'Usado',
            'Becarios_Actividades_a_Desarrollar',
            'Becarios_Nombre_Becario',
            'Becarios_Fecha_Inicio_Becario',
            'Becarios_Fecha_Fin_Becario',
            'Computo_Justificacion_objeto_comprar'
        ];
    }
}
