<?php

use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\TAnteproyectos;
use App\Models\TAnteproyectosRubro;
use App\Models\CatEjercicio;
use App\Models\CatRubro;
use App\Models\CatCategoria;
use App\Models\CatSubcategoria;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AnteproyectosRubroExport;
use Barryvdh\DomPDF\Facade\Pdf;

new class extends Component
{
    use WithPagination;
    public $query = '';
    public $anios = [];
    public $selectedAnio = '';

    public $catRubros = [];
    public $selectedRubro = '';

    public $catCategorias= [];
    public $selectedCategoria = '';

    public $catSubCategorias = [];
    public $selectedSubCategoria = '';


    public function mount()
    {
        $this->catRubros = CatRubro::all();
        // Inicialmente vacío
        $this->catCategorias = collect();
        $this->anios = CatEjercicio::orderBy('ejercicio', 'asc')->get();
    }
 
    public function search()
    {
        $this->resetPage();
    }

    public function resetSearch()
    {
        return $this->redirect('/dashboard/reportes/anteproyectos');
    }

    #[Computed]
    public function anteproyectos()
    {
        // if($this->query){
        //     return TAnteproyectosRubro::with('subcategoria.categoria.rubro')->where('id', 'like', '%'.$this->query.'%')->simplepaginate(10); // paginate(10) --- IGNORE ---
        // }


        if($this->selectedRubro && !$this->selectedCategoria && !$this->selectedSubCategoria){
            return TAnteproyectosRubro::with('subcategoria.categoria.rubro', 'rubros_becario', 'rubros_computo')->whereHas(
                'subcategoria.categoria.rubro',
                fn($q) => $q->where('id', $this->selectedRubro)
            )->orderBy(
                CatRubro::select('titulo')
                    ->join('cat_categorias', 'cat_categorias.id_rubro', '=', 'cat_rubros.id')
                    ->join('cat_subcategorias', 'cat_subcategorias.id_categoria', '=', 'cat_categorias.id')
                    ->whereColumn(
                        'cat_subcategorias.id',
                        't_anteproyectos_rubros.id_cat_subcategoria'
                    )
                    ->limit(1)
            )->simplepaginate(5); // paginate(10) --- IGNORE ---
        }
        if($this->selectedCategoria && !$this->selectedSubCategoria){
            return TAnteproyectosRubro::with('subcategoria.categoria.rubro', 'rubros_becario', 'rubros_computo')->whereHas(
                'subcategoria.categoria',
                fn($q) => $q->where('id', $this->selectedCategoria)
            )->orderBy(
                CatRubro::select('titulo')
                    ->join('cat_categorias', 'cat_categorias.id_rubro', '=', 'cat_rubros.id')
                    ->join('cat_subcategorias', 'cat_subcategorias.id_categoria', '=', 'cat_categorias.id')
                    ->whereColumn(
                        'cat_subcategorias.id',
                        't_anteproyectos_rubros.id_cat_subcategoria'
                    )
                    ->limit(1)
            )->simplepaginate(5); // paginate(10) --- IGNORE ---
        }
        if($this->selectedSubCategoria ){
            return TAnteproyectosRubro::with('subcategoria.categoria.rubro', 'rubros_becario', 'rubros_computo')->whereHas(
                'subcategoria',
                fn($q) => $q->where('id', $this->selectedSubCategoria)
            )->orderBy(
                CatRubro::select('titulo')
                    ->join('cat_categorias', 'cat_categorias.id_rubro', '=', 'cat_rubros.id')
                    ->join('cat_subcategorias', 'cat_subcategorias.id_categoria', '=', 'cat_categorias.id')
                    ->whereColumn(
                        'cat_subcategorias.id',
                        't_anteproyectos_rubros.id_cat_subcategoria'
                    )
                    ->limit(1)
            )->simplepaginate(5); // paginate(10) --- IGNORE ---
        }

        return TAnteproyectosRubro::with('subcategoria.categoria.rubro')->orderBy(
                CatRubro::select('titulo')
                    ->join('cat_categorias', 'cat_categorias.id_rubro', '=', 'cat_rubros.id')
                    ->join('cat_subcategorias', 'cat_subcategorias.id_categoria', '=', 'cat_categorias.id')
                    ->whereColumn(
                        'cat_subcategorias.id',
                        't_anteproyectos_rubros.id_cat_subcategoria'
                    )
                    ->limit(1)
            )->simplepaginate(5); // paginate(10) --- IGNORE ---
    }
    
    public function updatedSelectedRubro()
    {
        // Resetear subcategoría
        $this->selectedCategoria = '';

        // Si no seleccionó categoría
        if (!$this->selectedRubro) {

            $this->catCategorias = collect();

            return;
        }

        // Consultar categorías
        $this->catCategorias =
            CatCategoria::where(
                'id_rubro',
                $this->selectedRubro
            )
            ->orderBy('categoria')
            ->get();
    }

    public function updatedSelectedCategoria()
    {
        // Resetear subcategoría
        $this->selectedSubCategoria = '';

        // Si no seleccionó categoría
        if (!$this->selectedCategoria) {

            $this->catSubCategorias = collect();

            return;
        }

        // Consultar subcategorías
        $this->catSubCategorias =
            CatSubcategoria::where(
                'id_categoria',
                $this->selectedCategoria
            )
            ->orderBy('subcategoria')
            ->get();
    }
    
    public function updatedSelectedSubCategoria()
    {

        // Si no seleccionó categoría
        if (!$this->selectedSubCategoria) {
            return;
        }
        

        // Consultar subcategorías
        $this->objSubcategoria =
            CatSubcategoria::findOrFail($this->selectedSubCategoria);
    }

    public function exportarExcel()
    {

        $query = $this->buildQuery();

        //dd($query);

        return Excel::download(
            new AnteproyectosRubroExport($query),
            'anteproyectos.xlsx'
        );
    }

    public function exportarPdf()
    {
        $anteproyectos = $this->buildQuery()
            ->with([
                'subcategoria.categoria.rubro'
            ])
            ->get();

        $pdf = Pdf::loadView(
            'pdf.anteproyectos',
            compact('anteproyectos')
        );

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'anteproyectos.pdf'
        );
    }

    private function buildQuery()
    {
        $query = TAnteproyectosRubro::with('subcategoria.categoria.rubro')->orderBy(
            CatRubro::select('titulo')
                ->join('cat_categorias', 'cat_categorias.id_rubro', '=', 'cat_rubros.id')
                ->join('cat_subcategorias', 'cat_subcategorias.id_categoria', '=', 'cat_categorias.id')
                ->whereColumn(
                    'cat_subcategorias.id',
                    't_anteproyectos_rubros.id_cat_subcategoria'
                )
                ->limit(1)
        );       

        if($this->selectedRubro && !$this->selectedCategoria && !$this->selectedSubCategoria){
            $query->whereHas(
                'subcategoria.categoria.rubro',
                fn($q) => $q->where('id', $this->selectedRubro)
            )->orderBy(
                CatRubro::select('titulo')
                    ->join('cat_categorias', 'cat_categorias.id_rubro', '=', 'cat_rubros.id')
                    ->join('cat_subcategorias', 'cat_subcategorias.id_categoria', '=', 'cat_categorias.id')
                    ->whereColumn(
                        'cat_subcategorias.id',
                        't_anteproyectos_rubros.id_cat_subcategoria'
                    )
                    ->limit(1)
            );       
        }
        if($this->selectedCategoria && !$this->selectedSubCategoria){
            $query->whereHas(
                'subcategoria.categoria',
                fn($q) => $q->where('id', $this->selectedCategoria)
            )->orderBy(
                CatRubro::select('titulo')
                    ->join('cat_categorias', 'cat_categorias.id_rubro', '=', 'cat_rubros.id')
                    ->join('cat_subcategorias', 'cat_subcategorias.id_categoria', '=', 'cat_categorias.id')
                    ->whereColumn(
                        'cat_subcategorias.id',
                        't_anteproyectos_rubros.id_cat_subcategoria'
                    )
                    ->limit(1)
            );       
        }
        if($this->selectedSubCategoria ){
            $query->whereHas(
                'subcategoria',
                fn($q) => $q->where('id', $this->selectedSubCategoria)
            )->orderBy(
                CatRubro::select('titulo')
                    ->join('cat_categorias', 'cat_categorias.id_rubro', '=', 'cat_rubros.id')
                    ->join('cat_subcategorias', 'cat_subcategorias.id_categoria', '=', 'cat_categorias.id')
                    ->whereColumn(
                        'cat_subcategorias.id',
                        't_anteproyectos_rubros.id_cat_subcategoria'
                    )
                    ->limit(1)
            );       
        }

        return $query;
    }



};
?>
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Reportes Anteproyectos') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            class="bg-green-500 text-white p-3 rounded"
        >
            {{ session('success') }}
        </div>
    @endif

    <div class="row mb-3">

        {{-- <div class="col-md-4">
            <flux:select label="Ejercicio" size="sm" wire:model="id_ejercicio">
                <flux:select.option value="">Selecciona el ejercicio</flux:select.option>
                    @foreach($anios as $anio)
                        <flux:select.option value="{{ $anio->id }}">
                            {{ $anio->ejercicio }}
                        </flux:select.option>
                    @endforeach
            </flux:select>
        </div> --}}

        <div class="col-md-4">

            <flux:select label="Rubros" wire:model.live="selectedRubro">
                <flux:select.option value="">Selecciona el rubro</flux:select.option>
                    @foreach($catRubros as $rubro)
                        <flux:select.option value="{{ $rubro->id }}">
                            {{ $rubro->titulo }}
                        </flux:select.option>
                    @endforeach
            </flux:select>

        </div>

        <div class="col-md-4">

            <flux:select label="Categorias" wire:model.live="selectedCategoria">
                <flux:select.option :disabled="!$this->selectedRubro" value="">Selecciona la categoria</flux:select.option>
                    @foreach($catCategorias as $categoria)
                        <flux:select.option value="{{ $categoria->id }}">
                            {{ $categoria->categoria }}
                        </flux:select.option>
                    @endforeach
            </flux:select>

        </div>

        <div class="col-md-4">

            <flux:select label="Subcategorías" wire:model.live="selectedSubCategoria">
                <flux:select.option :disabled="!$this->selectedCategoria" value="">Selecciona la subcategoria</flux:select.option>
                    @foreach($catSubCategorias as $subcategoria)
                        <flux:select.option value="{{ $subcategoria->id }}">
                            {{ $subcategoria->subcategoria }}
                        </flux:select.option>
                    @endforeach
            </flux:select>

        </div>

    </div>


    <form wire:submit="search">
        <flux:input.group>
            {{-- <flux:input type="text" wire:model="query" size="lg"  />
            <flux:button type="submit">Buscar</flux:button> --}}
            <flux:button type="button" wire:click="resetSearch">Limpiar</flux:button>
        </flux:input.group>
    </form>
    <div class="mb-3">
        <flux:button type="button" wire:click="exportarExcel">Exportar Excel</flux:button>
        {{-- <flux:button type="button" wire:click="exportarPdf">Exportar PDF</flux:button> --}}
    </div>
    <flux:table style="table-layout:auto; white-space:normal;" class="w-full">
        <flux:table.columns>
            <flux:table.column>ID</flux:table.column>
            <flux:table.column>Ejercicio</flux:table.column>
            <flux:table.column>Usuario</flux:table.column>
            <flux:table.column>Rubro</flux:table.column>
            <flux:table.column>Subcategoria</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->anteproyectos as $item)
                <flux:table.row :key="$item->id">
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->id }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->anteproyecto->ejercicio->ejercicio ?? 'N/A' }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->anteproyecto->usuario->detalle->nombres ?? 'N/A' }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->subcategoria->categoria->rubro->titulo ?? 'N/A' }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->subcategoria->subcategoria ?? 'N/A' }}</flux:table.cell>
                    {{-- <flux:table.cell class="!whitespace-normal break-words">{{ $item->rubros_becario->isNotEmpty() ? $item->rubros_becario->first()->actividades_a_desarrollar : 'No' }}</flux:table.cell> --}}
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table> 
    <br>
    {{ $this->anteproyectos->links() }}
</div>