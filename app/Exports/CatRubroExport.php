<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CatRubroExport implements FromCollection, WithHeadings
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
            ->map(function ($cat_subcategoria) {
                
                return [
                    'id' => $cat_subcategoria->id,
                    'rubro' => $cat_subcategoria->categoria->rubro->titulo,
                    'categoria' => $cat_subcategoria->categoria->categoria,
                    'subcategoria' => $cat_subcategoria->subcategoria,
                    'descripcion' => $cat_subcategoria->descripcion,
                    'monto_estimado' => $cat_subcategoria->monto_estimado,
                    
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Rubro',
            'Categoria',
            'Subcategoria',
            'Descripción',
            'Monto Estimado',
        ];
    }
}
