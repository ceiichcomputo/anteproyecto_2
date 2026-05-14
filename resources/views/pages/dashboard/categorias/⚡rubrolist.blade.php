<?php

use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\CatCategoria;
use App\Models\CatRubro;
use App\Livewire\Traits\WithPermissions;

new class extends Component
{
    use WithPermissions;
    use WithPagination;

    public $rubro;
    public $titulo;

    public function mount(?int $rubro_id = null)
    {
        $this->checkPermission('catalogos.categorias.listar');

        if($rubro_id){
            $this->rubro = CatRubro::findOrFail($rubro_id);
            $this->titulo = $this->rubro->titulo;

            //$this->categorias = CatCategoria::where('id_rubro', 'equals', $this->rubro->id )->simplepaginate(10); --- IGNORE ---
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
    public function categorias()
    {
        if($this->query){
            return CatCategoria::where('categoria', 'like', '%'.$this->query.'%')->simplepaginate(10); // paginate(10) --- IGNORE ---
        }

        return CatCategoria::where('id_rubro', $this->rubro->id)->simplepaginate(10); // paginate(10) --- IGNORE ---
    }
    
    public function delete($id)
    {
        $categoria = CatCategoria::findOrFail($id);
        $categoria->delete();
        session()->flash('success', 'Categoría eliminada correctamente');
    }

    public function agregar()
    {
        return $this->redirect('/dashboard/categorias/crear/' . $this->rubro->id);
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/rubro');
    }
};
?>
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Categorías de Rubro: ' . $this->titulo) }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:button type="button" wire:click="regresar">Regresar</flux:button>
        <flux:button type="button" wire:click="agregar">Agregar Categoría</flux:button>
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
            <flux:table.column>Título</flux:table.column>
            <flux:table.column>Descripción</flux:table.column>
            <flux:table.column>Acciones</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->categorias as $item)
                <flux:table.row :key="$item->id">
                    <flux:table.cell class="whitespace-nowrap">{{ $item->id }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $item->categoria }}</flux:table.cell>
                    <flux:table.cell class="whitespace-normal">{{ $item->descripcion }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap"><a href="{{ route('categorias.editar', ['rubro_id' => $this->rubro->id, 'id' => $item->id]) }}" 
                        class="btn btn-sm btn-primary">Editar</a>
                        <button
                            wire:click="delete({{ $item->id }})"
                            wire:confirm="¿Deseas eliminar esta categoria?"
                            class="bg-red-500 text-white px-3 py-1 rounded"
                        >
                            Eliminar
                        </button>

                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table> 
    <br>
    {{ $this->categorias->links() }}
</div>