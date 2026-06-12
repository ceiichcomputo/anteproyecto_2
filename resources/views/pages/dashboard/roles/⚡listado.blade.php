<?php

use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Role;
use Livewire\Attributes\On;
use App\Livewire\Traits\WithPermissions;

new class extends Component
{
    use WithPermissions;

    public function mount()
    {
        $this->checkPermission('admin.roles.listar');
    }

    use WithPagination;
    public $query = '';
 
    public function search()
    {
        $this->resetPage();
    }

    public function resetSearch()
    {
        return $this->redirect('/dashboard/roles');
    }

    public function agregar()
    {
        return $this->redirect('/dashboard/roles/crear');
    }

    #[Computed]
    public function roles()
    {
        return Role::where('name', 'like', '%'.$this->query.'%')->orderBy('name')->simplepaginate(10); // paginate(10) --- IGNORE ---
    }
};
?>
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Roles') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        @can('admin.roles.editar')
        <flux:button type="button" wire:click="agregar">Agregar Rol</flux:button>
        @endcan
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
            <flux:table.column>Nombre</flux:table.column>
            <flux:table.column>Descripción</flux:table.column>
            <flux:table.column>Acciones</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->roles as $item)
                <flux:table.row :key="$item->id">
                    <flux:table.cell class="whitespace-nowrap">{{ $item->id }}</flux:table.cell>
                    <flux:table.cell class="whitespace-normal">{{ $item->name }}</flux:table.cell>
                    <flux:table.cell class="whitespace-normal">{{ $item->description }}</flux:table.cell>
                    <flux:table.cell class="whitespace-normal"><a href="{{ route('roles.editar', $item->id) }}" 
                        class="btn btn-sm btn-primary">Editar</a>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table> 
    <br>
    {{ $this->roles->links() }}
</div>