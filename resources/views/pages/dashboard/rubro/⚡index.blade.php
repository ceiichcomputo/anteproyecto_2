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
        <input type="text" wire:model="query">
        <button type="submit">Buscar</button>
        <button type="button" wire:click="resetSearch">Limpiar</button>
    </form>
    <table class="table w-full">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($this->rubros as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->titulo }}</td>
                    <td>
                        <a href="{{ route('rubro.edit', $item->id) }}" class="btn btn-sm btn-primary">Editar</a>
                    </td>
                        
                </tr>
            @endforeach
        </tbody>
    </table> 
    <br>
    {{ $this->rubros->links() }}
</div>