<?php

use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Permission;
use App\Livewire\Traits\WithPermissions;

new class extends Component
{
    use WithPermissions;

    public function mount()
    {
        $this->checkPermission('admin.permisos.listar');
    }
    
    use WithPagination;
    public $query = '';
 
    public function search()
    {
        $this->resetPage();
    }

    public function resetSearch()
    {
        return $this->redirect('/dashboard/permisos');
    }

    #[Computed]
    public function permisos()
    {
        return Permission::where('name', 'like', '%'.$this->query.'%')->orderBy('module')->orderBy('name')->simplepaginate(10); // paginate(10) --- IGNORE ---
    }

    public function agregar()
    {
        return $this->redirect('/dashboard/permisos/crear');
    }
};
?>
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Permisos') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:button type="button" wire:click="agregar">Agregar Permiso</flux:button>
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

   <div class="relative mb-6 w-full overflow-x-auto">
        <flux:table style="table-layout:auto; white-space:normal;" class="w-full">
            <flux:table.columns>
                <flux:table.column>ID</flux:table.column>
                <flux:table.column>Módulo</flux:table.column>
                <flux:table.column>Permiso</flux:table.column>
                <flux:table.column>Descripción</flux:table.column>
                <flux:table.column>Acciones</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->permisos as $item)
                    <flux:table.row :key="$item->id">
                        <flux:table.cell class="!whitespace-normal break-words">{{ $item->id }}</flux:table.cell>
                        <flux:table.cell class="!whitespace-normal break-words">{{ $item->module }}</flux:table.cell>
                        <flux:table.cell class="!whitespace-normal break-words">{{ $item->name }}</flux:table.cell>
                        <flux:table.cell class="!whitespace-normal break-words">{{ $item->description }}</flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap"><a href="{{ route('permisos.editar', $item->id) }}" 
                            class="bg-blue-500 text-white px-3 py-1 rounded">Editar</a>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table> 
    </div>
    <br>
    {{ $this->permisos->links() }}
</div>