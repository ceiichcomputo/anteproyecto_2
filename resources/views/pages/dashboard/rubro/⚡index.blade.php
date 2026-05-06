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
        return CatRubro::where('titulo', 'like', '%'.$this->query.'%')->paginate(1);
    }
};
?>
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Rubros') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
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
            <flux:table.column>Acciones</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->rubros as $item)
                <flux:table.row :key="$item->id">
                    <flux:table.cell class="whitespace-nowrap">{{ $item->id }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $item->titulo }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap"><a href="{{ route('rubro.edit', $item->id) }}" 
                        class="btn btn-sm btn-primary">Editar</a>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table> 
    <br>
    {{ $this->rubros->links() }}
</div>