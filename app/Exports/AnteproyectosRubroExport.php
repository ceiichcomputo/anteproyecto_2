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
                    'usuario_id' => $anteproyecto->anteproyectos->id_usuario,
                    'apellido_paterno' => $anteproyecto->anteproyectos->usuario->detalle->apellido_paterno,
                    'apellido_materno' => $anteproyecto->anteproyectos->usuario->detalle->apellido_materno,
                    'nombre_usuario' => $anteproyecto->anteproyectos->usuario->detalle->nombres,
                    'ejercicio' => $anteproyecto->anteproyectos->ejercicio->ejercicio,
                    'rubro' => $anteproyecto->subcategoria->categoria->rubro->titulo,
                    'categoria' => $anteproyecto->subcategoria->categoria->categoria,
                    'subcategoria' => $anteproyecto->subcategoria->subcategoria,
                    'monto_estimado' => $anteproyecto->monto_estimado,
                    'usado' => $anteproyecto->devengado ? 'Sí' : 'No',
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
        ];
    }
}
