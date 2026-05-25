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

    public $anteproyecto;
    public $ejercicio;

    public function mount(?int $anteproyecto_id = null)
    {
        $this->checkPermission('anteproyecto.listar');

        if($anteproyecto_id){
            $this->anteproyecto = TAnteproyectos::findOrFail($anteproyecto_id);
            $this->ejercicio = $this->anteproyecto->ejercicio->ejercicio;
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
            return TAnteproyectosRubro::where('rubro', 'like', '%'.$this->query.'%')->simplepaginate(10); // paginate(10) --- IGNORE ---
        }

        return TAnteproyectosRubro::where('id_anteproyecto', $this->anteproyecto->id)->simplepaginate(10); // paginate(10) --- IGNORE ---
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
    
    public function editar($rubro_id, $id)
    {
        return $this->redirect('/dashboard/categorias/editar/' . $rubro_id . '/' . $id);
    }

    public function verSubcategoria($categoria_id)
    {
        return $this->redirect('/dashboard/subcategorias/categorias/' . $categoria_id);
    }

    public function agregar()
    {
        return $this->redirect('/dashboard/anteproyecto/crear_rubro/' . $this->anteproyecto->id);
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/anteproyecto');
    }
};
?>
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Anteproyecto del ejercicio: ' . $this->ejercicio) }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:button type="button" wire:click="regresar">Regresar</flux:button>
        <flux:button type="button" wire:click="agregar">Agregar Rubros</flux:button>
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
            <flux:table.column>Rubro</flux:table.column>
            <flux:table.column>Descripción</flux:table.column>
            <flux:table.column>Acciones</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->rubros as $item)
                <flux:table.row :key="$item->id">
                    <flux:table.cell class="whitespace-nowrap">{{ $item->id }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $item->categorias }}</flux:table.cell>
                    <flux:table.cell class="whitespace-normal">{{ $item->id_cat_subcategoria }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">
                        <button
                            wire:click="editar({{ $this->anteproyecto->id }}, {{ $item->id }})"
                            class="bg-blue-500 text-white px-3 py-1 rounded"
                        >
                            Editar
                        </button>
                        <button
                            wire:click="verSubcategoria({{ $item->id }})"
                            class="bg-blue-500 text-white px-3 py-1 rounded"
                        >
                            Subcategorías
                        </button>
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
    {{ $this->rubros->links() }}
</div>