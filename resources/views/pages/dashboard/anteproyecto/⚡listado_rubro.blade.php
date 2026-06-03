<?php

use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\TAnteproyectos;
use App\Models\CatEjercicio;
use App\Models\TAnteproyectosRubro;
use App\Livewire\Traits\WithPermissions;

new class extends Component
{
    use WithPermissions;
    use WithPagination;

    public $perteneceAUsuario = false;
    public $anteproyecto;
    public $ejercicio;
    public $anteproyectosRubros = [];

    public function mount(?int $anteproyecto_id = null)
    {
        $this->checkPermission('anteproyecto.listar');

        if($anteproyecto_id){
            $this->anteproyecto = TAnteproyectos::findOrFail($anteproyecto_id);
            $this->ejercicio = $this->anteproyecto->ejercicio->ejercicio;
            //$this->anteproyectosRubros = $this->anteproyecto->anteproyectos_rubros;
        }

        if($this->anteproyecto->id_usuario != auth()->id()){

            session()->flash('error', 'Por alguna razón, este Anteproyecto no te pertenece.');
            return $this->redirect('/dashboard');
        }
        

    }
    
    public $query = '';
 
    public function search()
    {
        $this->resetPage();
    }

    public function resetSearch()
    {
        return $this->redirect('/dashboard/categorias');
    }

    #[Computed]
    public function rubros()
    {
        if($this->query){
            return TAnteproyectosRubro::with('subcategoria')->where('rubro', 'like', '%'.$this->query.'%')->simplepaginate(10); // paginate(10) --- IGNORE ---
        }

        return TAnteproyectosRubro::with('subcategoria.categoria.rubro')->where('id_anteproyecto', $this->anteproyecto->id)->simplepaginate(10); // paginate(10) --- IGNORE ---
        
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
        $query = TAnteproyectosRubro::with('subcategoria.categoria.rubro');        

        return $query;
    }


};
?>
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Anteproyecto del ejercicio: ' . $this->ejercicio) }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:button type="button" wire:click="regresar">Regresar</flux:button>
        @if($this->anteproyecto->enviado == 0)
            <flux:button type="button" wire:click="agregar">Agregar Rubros</flux:button>
        @endif
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
    @if(session()->has('error'))
        <div 
            x-init="setTimeout(() => show = false, 3000)"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit="search">
        <flux:input.group>
            <flux:input type="text" wire:model="query" size="lg"  />
            <flux:button type="submit">Buscar</flux:button>
            <flux:button type="button" wire:click="resetSearch">Limpiar</flux:button>
        </flux:input.group>
    </form>
    <flux:table class="table w-full">
        <flux:table.columns>
            <flux:table.column>ID</flux:table.column>
            <flux:table.column>Rubro</flux:table.column>
            <flux:table.column>Subcategoría</flux:table.column>
            <flux:table.column>Monto Estimado</flux:table.column>
            <flux:table.column>Acciones</flux:table.column>
        </flux:table.columns>

        @if(!$this->rubros)
            <flux:table.row>
                <flux:table.cell colspan="5" class="text-center">No se encontraron rubros.</flux:table.cell>
            </flux:table.row>
        @else
            <flux:table.rows>
                @foreach ($this->rubros as $item)
                    <flux:table.row :key="$item->id">
                        <flux:table.cell class="whitespace-normal">{{ $item->id }}</flux:table.cell>
                        <flux:table.cell class="whitespace-normal">{{ $item->subcategoria->categoria->rubro->titulo ?? 'N/A' }}</flux:table.cell>
                        <flux:table.cell class="whitespace-normal">{{ $item->subcategoria->subcategoria ?? 'N/A' }}</flux:table.cell>
                        <flux:table.cell class="whitespace-normal">{{ $item->monto_estimado }}</flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">

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
        @endif
    </flux:table> 
    <br>
    {{ $this->rubros->links() }}

    <div class="relative mb-6 w-full">
        <flux:separator variant="subtle" />
        @if($this->anteproyecto->enviado == 0)
            <flux:button type="button" wire:click="concluir" wire:confirm="¿Desea concluir el anteproyecto y enviarlo? Ya no podrá realizar más cambios. ¿Desea continuar?"> {{ __('Concluir anteproyecto: ' . $this->ejercicio) }}</flux:button>
        @endif
        <flux:button type="button" wire:click="exportarPdf">Exportar PDF</flux:button>
    </div>
</div>