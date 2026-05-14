<?php

use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\CatSubcategoria;

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
        return $this->redirect('/dashboard/subcategorias');
    }

    #[Computed]
    public function subcategorias()
    {
        return CatSubcategoria::where('subcategoria', 'like', '%'.$this->query.'%')->simplepaginate(10); // paginate(10) --- IGNORE ---
    }
    
    public function delete($id)
    {
        $subcategoria = CatSubcategoria::findOrFail($id);
        $subcategoria->delete();
        session()->flash('success', 'Subcategoria eliminada correctamente');
    }

    public function agregar()
    {
        return $this->redirect('/dashboard/subcategorias/crear');
    }
};
?>
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Subcategorias') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:button type="button" wire:click="agregar">Agregar Subcategoria</flux:button>
        <flux:separator variant="subtle" />
    </div>
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
            @foreach ($this->subcategorias as $item)
                <flux:table.row :key="$item->id">
                    <flux:table.cell class="whitespace-nowrap">{{ $item->id }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $item->subcategoria }}</flux:table.cell>
                    <flux:table.cell class="whitespace-normal">{{ $item->descripcion }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap"><a href="{{ route('subcategorias.edit', $item->id) }}" 
                        class="btn btn-sm btn-primary">Editar</a>
                        <button
                            wire:click="delete({{ $item->id }})"
                            wire:confirm="¿Deseas eliminar esta subcategoria?"
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
    {{ $this->subcategorias->links() }}
</div>