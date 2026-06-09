<?php

use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\UsersDetalle;
use App\Livewire\Traits\WithPermissions;

new class extends Component
{
    use WithPermissions;

    public function mount()
    {
        $this->checkPermission('admin.academicos.listar');
    }
    
    use WithPagination;
    public $query = '';
 
    public function search()
    {
        $this->resetPage();
    }

    public function resetSearch()
    {
        return $this->redirect('/dashboard/academicos');
    }

    #[Computed]
    public function academicos()
    {
        return UsersDetalle::where('nombres', 'like', '%'.$this->query.'%')->orderBy('apellido_paterno')->orderBy('nombres')->simplepaginate(10); // paginate(10) --- IGNORE ---
    }

    public function agregar()
    {
        return $this->redirect('/dashboard/academicos/crear');
    }
};
?>
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Académicos') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:button type="button" wire:click="agregar">Agregar Académico</flux:button>
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
            <flux:table.column>Usuario</flux:table.column>
            <flux:table.column>Nombre</flux:table.column>
            <flux:table.column>Nombramiento</flux:table.column>
            <flux:table.column>Acciones</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->academicos as $item)
                <flux:table.row :key="$item->id">
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->id }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->user->name }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->nombres }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-normal break-words">{{ $item->nombramiento->nombramiento }}</flux:table.cell>
                    <flux:table.cell class="!whitespace-normal break-words"><a href="{{ route('academicos.editar', $item->id) }}" 
                        class="bg-blue-500 text-white px-3 py-1 rounded">Editar</a>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table> 
    <br>
    {{ $this->academicos->links() }}
</div>