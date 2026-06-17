<?php

use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\TAnteproyectos;
use App\Models\CatEjercicio;
use App\Models\CatRubro;
use App\Models\TAnteproyectosRubro;
use App\Livewire\Traits\WithPermissions;
use Carbon\Carbon;
use App\Services\AnteproyectoRubroService;

new class extends Component
{
    use WithPermissions;
    use WithPagination;

    public $perteneceAUsuario = false;
    public $anteproyecto;
    public $ejercicio;
    public $anteproyectosRubros = [];
    public $boolSiSePuedeAgregar = true;


    public function mount(?int $anteproyecto_id = null)
    {
        $this->checkPermission('anteproyecto.listar');
        $service = app(AnteproyectoRubroService::class);

        if($anteproyecto_id){
            $this->anteproyecto = TAnteproyectos::findOrFail($anteproyecto_id);
            $this->ejercicio = $this->anteproyecto->ejercicio->ejercicio;
            //$this->anteproyectosRubros = $this->anteproyecto->anteproyectos_rubros;
        }

        if($this->anteproyecto->id_usuario != auth()->id()){

            session()->flash('error', 'Por alguna razón, este Anteproyecto no te pertenece.');
            return $this->redirect('/dashboard');
        }
        $this->boolSiSePuedeAgregar = $service->ValidaSiSePuedeAgregar($this->anteproyecto);
        // try{
        //     $service->ValidaSiSePuedeAgregar($this->anteproyecto);
        // }
        // catch(Exception $e){
        //     $this->boolSiSePuedeAgregar = false;
        // }

    }
    
    public $query = '';
 
    public function search()
    {
        $this->resetPage();
    }

    public function resetSearch()
    {
        return $this->redirect('/dashboard/anteproyecto/listado_rubro/' . $this->anteproyecto->id);
    }

    #[Computed]
    public function rubros()
    {
        if($this->query){
            return TAnteproyectosRubro::with('subcategoria.categoria.rubro')->where(CatRubro::select('titulo')
            ->join('cat_categorias', 'cat_categorias.id_rubro', '=', 'cat_rubros.id')
            ->join('cat_subcategorias', 'cat_subcategorias.id_categoria', '=', 'cat_categorias.id')
            ->whereColumn(
                'cat_subcategorias.id',
                't_anteproyectos_rubros.id_cat_subcategoria'
            )
            ->limit(1), 'like', '%'.$this->query.'%')->orderBy(
        CatRubro::select('titulo')
            ->join('cat_categorias', 'cat_categorias.id_rubro', '=', 'cat_rubros.id')
            ->join('cat_subcategorias', 'cat_subcategorias.id_categoria', '=', 'cat_categorias.id')
            ->whereColumn(
                'cat_subcategorias.id',
                't_anteproyectos_rubros.id_cat_subcategoria'
            )
            ->limit(1)
    )
    ->simplePaginate(10);
        }

        return TAnteproyectosRubro::with('subcategoria.categoria.rubro')->where('id_anteproyecto', $this->anteproyecto->id)->orderBy(
        CatRubro::select('titulo')
            ->join('cat_categorias', 'cat_categorias.id_rubro', '=', 'cat_rubros.id')
            ->join('cat_subcategorias', 'cat_subcategorias.id_categoria', '=', 'cat_categorias.id')
            ->whereColumn(
                'cat_subcategorias.id',
                't_anteproyectos_rubros.id_cat_subcategoria'
            )
            ->limit(1)
    )
    ->simplePaginate(10);
        
    }
    
    public function delete($id)
    {
        $rubro = TAnteproyectosRubro::findOrFail($id);
        $rubro->update([
            'usuario_del' => auth()->id()
        ]);
        $rubro->delete();
        session()->flash('success', 'Rubro eliminado correctamente');
    }
    
    public function editar($rubro_id)
    {
        return $this->redirect('/dashboard/anteproyecto/editar_rubro/' . $this->anteproyecto->id . '/' . $rubro_id);
    }

    public function detalle($rubro_id)
    {
        return $this->redirect('/dashboard/anteproyecto/detalle_rubro/' . $this->anteproyecto->id . '/' . $rubro_id);
    }

    public function agregar()
    {
        return $this->redirect('/dashboard/anteproyecto/crear_rubro/' . $this->anteproyecto->id);
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/anteproyecto');
    }

    public function concluir()
    {
        $this->anteproyecto->update([
            'enviado' => 1,
            'usuario_mod' => auth()->id(),
        ]);

        session()->flash('success', 'El anteproyecto ' . $this->anteproyecto->ejercicio->ejercicio . ' ha sido concluido y enviado correctamente.');

        return $this->redirect('/dashboard/anteproyecto');
    }


    public function exportarPdf()
    {
        $anteproyectos = $this->buildQuery()
            ->with([
                'subcategoria.categoria.rubro'
            ])
            ->get();

        $pdf = Pdf::loadView(
            'pdf.vistaPreviaAnteproyecto',
            compact('anteproyectos')
        );

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'anteproyectos.pdf'
        );
    }

    private function buildQuery()
    {
        $query = TAnteproyectosRubro::with('subcategoria.categoria.rubro')->whereHas(
                'anteproyecto', fn ($q) => $q->where('id_usuario', auth()->id())
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

        return $query;
    }

    // private function ValidaSiSePuedeAgregar()
    // {
    //     $fechaInicio = Carbon::parse($this->anteproyecto->ejercicio->fecha_captura_inicio);
    //     $fechaFin = Carbon::parse($this->anteproyecto->ejercicio->fecha_captura_fin);

    //     if($this->anteproyecto->enviado == 1){
    //         $this->boolSiSePuedeAgregar = false;
    //         return false;
    //     } 
    //     if (!Carbon::now('America/Mexico_City')->betweenIncluded($fechaInicio, $fechaFin)) {
    //         // La fecha de hoy se encuentra entre el rango
    //         $this->boolSiSePuedeAgregar = false;
    //         return false;
    //     }
    // }


};
?>
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Anteproyecto del ejercicio: ' . $this->ejercicio ) }}</flux:heading>
        <flux:heading size="xl" class="mb-6">{{ __('Listado de Rubros') }}</flux:heading>
        <flux:button type="button" wire:click="regresar">Regresar</flux:button>
        @if($this->boolSiSePuedeAgregar)
            <flux:button type="button" wire:click="agregar">Agregar nuevo registro</flux:button>
        @else
            <p> </p>
        @endif
            <p> </p>
        <flux:separator variant="subtle" />
         <p></p>
    </div>
    @error('error')
        <div class="text-red-500">
            {{ $message }}
        </div>
    @enderror

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
    @if(session()->has('error'))
        <div 
            x-init="setTimeout(() => show = false, 3000)"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- <form wire:submit="search">
        <flux:input.group>
            <flux:input type="text" wire:model="query" size="lg"  />
            <flux:button type="submit">Buscar</flux:button>
            <flux:button type="button" wire:click="resetSearch">Limpiar</flux:button>
        </flux:input.group>
    </form> --}}
    <br>
    @if($this->rubros->count() < 1)
            <flux:table.row>
                <flux:table.cell colspan="5" class="text-center">Sin registros, debes de agregar un nuevo registro.</flux:table.cell>
            </flux:table.row>
    @else
        <flux:table style="table-layout:auto; white-space:normal;" class="w-full">
            <flux:table.columns>
                <flux:table.column>#</flux:table.column>
                <flux:table.column>Rubro</flux:table.column>
                <flux:table.column>Subcategoría</flux:table.column>
                <flux:table.column>Presupuesto Estimado</flux:table.column>
                <flux:table.column>Acciones</flux:table.column>
            </flux:table.columns>

            
            <flux:table.rows>
                @foreach ($this->rubros as $item)
                    <flux:table.row :key="$item->id">
                        <flux:table.cell class="!whitespace-normal break-words">{{ $loop->iteration }}</flux:table.cell>
                        <flux:table.cell class="!whitespace-normal break-words">{{ $item->subcategoria->categoria->rubro->titulo ?? 'N/A' }}</flux:table.cell>
                        <flux:table.cell class="!whitespace-normal break-words">{{ $item->subcategoria->subcategoria ?? 'N/A' }}</flux:table.cell>
                        <flux:table.cell class="!whitespace-normal break-words">{{ $item->monto_estimado }}</flux:table.cell>
                        <flux:table.cell class="!whitespace-nowrap">

                            <button
                                wire:click="detalle({{ $item->id }})"
                                class="bg-blue-500 text-white px-3 py-1 rounded"
                            >
                                Detalle
                            </button>
                        @if($this->anteproyecto->enviado == 0)    
                            <button
                                wire:click="editar({{ $item->id }})"
                                class="bg-blue-500 text-white px-3 py-1 rounded"
                            >
                                Editar
                            </button>
                            <button
                                wire:click="delete({{ $item->id }})"
                                wire:confirm="¿Deseas eliminar este rubro?"
                                class="bg-red-500 text-white px-3 py-1 rounded"
                            >
                                Eliminar
                            </button>
                        @endif

                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>            
        </flux:table> 
    @endif
    <br>
    {{ $this->rubros->links() }}

    <div class="relative mb-6 w-full">
        <flux:separator variant="subtle" />
        @if($this->anteproyecto->enviado == 0 && $this->rubros->count() > 0)
            <flux:button type="button" wire:click="concluir" wire:confirm="¿Desea concluir el anteproyecto y enviarlo? Ya no podrá realizar más cambios. ¿Desea continuar?"> {{ __('Concluir anteproyecto: ' . $this->ejercicio) }}</flux:button>
        @endif
        @if($this->rubros->count() > 0)
            <flux:button type="button" wire:click="exportarPdf">Exportar PDF</flux:button>
        @endif
    </div>
</div>