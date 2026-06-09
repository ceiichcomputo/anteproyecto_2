<?php

use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\CatCategoria;
use App\Models\CatSubcategoria;
use App\Livewire\Traits\WithPermissions;

new class extends Component
{
    use WithPermissions;
    use WithPagination;

    public $categoria;
    public $titulo;

    public function mount(?int $categoria_id = null)
    {
        $this->checkPermission('catalogos.categorias.listar');

        if($categoria_id){
            $this->categoria = CatCategoria::findOrFail($categoria_id);
            $this->titulo = $this->categoria->categoria;
        }
    }
    
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
        if($this->query){
            return CatSubcategoria::where('subcategoria', 'like', '%'.$this->query.'%')->simplepaginate(10); // paginate(10) --- IGNORE ---
        }

        return CatSubcategoria::where('id_categoria', $this->categoria->id)->simplepaginate(10); // paginate(10) --- IGNORE ---
    }
    
    public function editar($categoria_id, $id)
    {
        return $this->redirect('/dashboard/subcategorias/editar/' . $categoria_id . '/' . $id);
    }
    
    public function delete($id)
    {
        $subcategoria = CatSubcategoria::findOrFail($id);
        $subcategoria->update([
            'usuario_del' => auth()->id()
        ]);
        $subcategoria->delete();
        session()->flash('success', 'Subcategoría eliminada correctamente');
    }

    public function agregar()
    {
        return $this->redirect('/dashboard/subcategorias/crear/' . $this->categoria->id);
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/categorias/rubro/' . $this->categoria->id_rubro);
    }
};
?>
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Subcategorías de Categoría: ' . $this->titulo) }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:button type="button" wire:click="regresar">Regresar</flux:button>
        <flux:button type="button" wire:click="agregar">Agregar Subcategoría</flux:button>
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
            @foreach ($this->subcategorias as $item)
                <flux:table.row :key="$item->id">
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->id }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->subcategoria }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->descripcion }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->monto_estimado }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-nowrap">
                        <button
                            wire:click="editar({{ $this->categoria->id }}, {{ $item->id }})"
                            class="bg-blue-500 text-white px-3 py-1 rounded"
                        >
                            Editar
                        </button>
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