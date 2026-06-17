<?php

use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\TAnteproyectos;
use App\Livewire\Traits\WithPermissions;

new class extends Component
{
    use WithPagination;
    use WithPermissions;
    public $query = '';

    public function mount()
    {
        $this->checkPermission('anteproyecto.listar');
    }
 
    public function search()
    {
        $this->resetPage();
    }

    public function resetSearch()
    {
        return $this->redirect('/dashboard/anteproyectos');
    }

    #[Computed]
    public function anteproyectos()
    {
        return TAnteproyectos::where(
                'id_usuario',
                auth()->id()
            )->where('id_ejercicio', 'like', '%'.$this->query.'%')->simplepaginate(10); // paginate(10) --- IGNORE ---
    }
    
    // public function delete($id)
    // {
    //     $categoria = TAnteproyectos::findOrFail($id);
    //     $categoria->delete();
    //     session()->flash('success', 'Anteproyecto eliminado correctamente');
    // }
    
    public function editar($id)
    {
        return $this->redirect('/dashboard/anteproyecto/listado_rubro/' . $id);
    }

    public function agregar()
    {
        return $this->redirect('/dashboard/anteproyecto/crear');
    }
};
?>
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Anteproyectos') }}</flux:heading>
        <flux:heading size="xl" class="mb-6">{{ __('Listado de Anteproyectos') }}</flux:heading>
        <flux:button type="button" wire:click="agregar">Agregar Anteproyecto</flux:button>
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
    {{-- <form wire:submit="search">
        <flux:input.group>
            <flux:input type="text" wire:model="query" size="lg"  />
            <flux:button type="submit">Buscar</flux:button>
            <flux:button type="button" wire:click="resetSearch">Limpiar</flux:button>
        </flux:input.group>
    </form> --}}
    @if($this->anteproyectos->count() < 1)
            <flux:table.row>
                <flux:table.cell colspan="5" class="text-center">Sin registros, debes de agregar un Anteproyecto.</flux:table.cell>
            </flux:table.row>
        @else
        <flux:table style="table-layout:auto; white-space:normal;" class="w-full">
            <flux:table.columns>
                <flux:table.column>ID</flux:table.column>
                <flux:table.column>Ejercicio</flux:table.column>
                <flux:table.column>Inicia captura</flux:table.column>
                <flux:table.column>Fin captura</flux:table.column>
                <flux:table.column>Estatus</flux:table.column>
                <flux:table.column>Acciones</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->anteproyectos as $item)
                    <flux:table.row :key="$item->id">
                        <flux:table.cell class="!whitespace-normal break-words">{{ $item->id }}</flux:table.cell>
                        <flux:table.cell class="!whitespace-normal break-words">{{ $item->ejercicio->ejercicio }}</flux:table.cell>
                        <flux:table.cell class="!whitespace-normal break-words">{{ $item->ejercicio->fecha_captura_inicio }}</flux:table.cell>
                        <flux:table.cell class="!whitespace-normal break-words">{{ $item->ejercicio->fecha_captura_fin }}</flux:table.cell>
                        <flux:table.cell class="!whitespace-normal break-words">{{ $item->enviado ? 'Enviado' : 'No enviado' }}</flux:table.cell>
                        <flux:table.cell class="!whitespace-nowrap">
                            <button
                                wire:click="editar({{ $item->id }})"
                                class="bg-blue-500 text-white px-3 py-1 rounded"
                            >
                                Ver
                            </button>
                            {{-- <button
                                wire:click="delete({{ $item->id }})"
                                wire:confirm="¿Deseas eliminar esta categoría académica?"
                                class="bg-red-500 text-white px-3 py-1 rounded"
                            >
                                Eliminar
                            </button> --}}

                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table> 

    @endif
    <br>
    {{ $this->anteproyectos->links() }}
</div>