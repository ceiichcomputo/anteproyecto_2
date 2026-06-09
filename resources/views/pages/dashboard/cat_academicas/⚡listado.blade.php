<?php

use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\CatCategoriaAcademicas;

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
        return $this->redirect('/dashboard/cat_academicas');
    }

    #[Computed]
    public function catAcademicas()
    {
        return CatCategoriaAcademicas::where('categoria_academica', 'like', '%'.$this->query.'%')->simplepaginate(10); // paginate(10) --- IGNORE ---
    }
    
    public function delete($id)
    {
        $categoria = CatCategoriaAcademicas::findOrFail($id);
        $categoria->delete();
        session()->flash('success', 'Categoría eliminada correctamente');
    }
    
    public function editar($id)
    {
        return $this->redirect('/dashboard/cat_academicas/editar/' . $id);
    }

    public function agregar()
    {
        return $this->redirect('/dashboard/cat_academicas/crear');
    }
};
?>
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Categorías Académicas') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
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
    <flux:table style="table-layout:auto; white-space:normal;" class="w-full">
        <flux:table.columns>
            <flux:table.column>ID</flux:table.column>
            <flux:table.column>Categoría Académica</flux:table.column>
            <flux:table.column>Acciones</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->catAcademicas as $item)
                <flux:table.row :key="$item->id">
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->id }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->categoria_academica }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-nowrap">
                        <button
                            wire:click="editar({{ $item->id }})"
                            class="bg-blue-500 text-white px-3 py-1 rounded"
                        >
                            Editar
                        </button>
                        <button
                            wire:click="delete({{ $item->id }})"
                            wire:confirm="¿Deseas eliminar esta categoría académica?"
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
    {{ $this->catAcademicas->links() }}
</div>