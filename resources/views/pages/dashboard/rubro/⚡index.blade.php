<?php

use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\CatRubro;

new class extends Component
{
    use WithPagination;
    public $query = '';
 
    public function search()
    {
        $this->resetPage();
    }

    public function resetSearch()
    {
        return $this->redirect('/dashboard/rubro');
    }

    #[Computed]
    public function rubros()
    {
        return CatRubro::where('titulo', 'like', '%'.$this->query.'%')->simplepaginate(10); // paginate(10) --- IGNORE ---
    }
    
    public function delete($id)
    {
        $rubro = CatRubro::findOrFail($id);
        $rubro->delete();
        session()->flash('success', 'Rubro eliminado correctamente');
    }
    
    public function editar($id)
    {
        return $this->redirect('/dashboard/rubro/editar/' . $id);
    }

    public function agregarCategoria($rubro_id)
    {
        return $this->redirect('/dashboard/categorias/rubro/' . $rubro_id);
    }

    public function agregar()
    {
        return $this->redirect('/dashboard/rubro/crear');
    }
};
?>
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Rubros') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:button type="button" wire:click="agregar">Agregar Rubro</flux:button>
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
    <flux:table style="table-layout:auto; white-space:normal;" class="w-full">
        <flux:table.columns>
            <flux:table.column>ID</flux:table.column>
            <flux:table.column>Título</flux:table.column>
            <flux:table.column>Descripción</flux:table.column>
            <flux:table.column>Acciones</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->rubros as $item)
                <flux:table.row :key="$item->id">
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->id }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->titulo }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->descripcion }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-nowrap">
                        <button
                            wire:click="editar({{ $item->id }})"
                            class="bg-blue-500 text-white px-3 py-1 rounded"
                        >
                            Editar
                        </button>
                        <button
                            wire:click="agregarCategoria({{ $item->id }})"
                            class="bg-blue-500 text-white px-3 py-1 rounded"
                        >
                            Categorías
                        </button>
                        <button
                            wire:click="delete({{ $item->id }})"
                            wire:confirm="¿Deseas eliminar este rubro?"
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
    {{ $this->rubros->links() }}
</div>