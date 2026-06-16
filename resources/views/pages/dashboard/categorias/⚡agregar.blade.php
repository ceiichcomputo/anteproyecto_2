<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\CatCategoria;
use App\Models\CatRubro;
use App\Livewire\Traits\WithPermissions;

new class extends Component
{
    use WithPermissions;
    
    function mount(?int $rubro_id = null, ?int $id = null){

        $this->checkPermission('catalogos.rubros.editar');

        if($rubro_id){
            $this->rubro = CatRubro::findOrFail($rubro_id);
        }

        if($id){
            $this->objCategoria = CatCategoria::findOrFail($id);
            $this->categoria = $this->objCategoria->categoria;
            $this->descripcion = $this->objCategoria->descripcion;
        }
    }

    #[Validate('required', message: 'Favor de ingresar un título')]
    #[Validate('min:2', message: 'La longitud mínima del título es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del título es de 255 caracteres')]
    #[Validate('string', message: 'El contenido del título debe ser una cadena de texto')]
    public $categoria;
    #[Validate('nullable|string')]
    public $descripcion;

    public $rubro;

    public $objCategoria;

    public $mensaje = '';


    function submit() {

        $this->validate();

        if($this->objCategoria){
            $this->objCategoria->update([
                'id_rubro' => $this->rubro->id,
                'categoria' => $this->categoria,
                'descripcion' => $this->descripcion,
                'usuario_mod' => auth()->id(),
                'updated_at' => now()
            ]);
            $this->mensaje = 'Categoría actualizada correctamente';
        }else{
            CatCategoria::create([
                'id_rubro' => $this->rubro->id,
                'categoria' => $this->categoria,
                'descripcion' => $this->descripcion,
                'usuario_ins' => auth()->id(),
                'updated_at' => now()
            ]);
            $this->mensaje = 'Categoría creada correctamente';
        }

        session()->flash('success', $this->mensaje);
 
        return $this->redirect('/dashboard/categorias/rubro/' . $this->rubro->id);
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/categorias/rubro/' . $this->rubro->id);
    }
};
?>



<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Rubro: ' . $this->rubro->titulo) }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:button type="button" wire:click="regresar" wire:confirm="Se perderán todos los cambios, ¿Deseas continuar?">Regresar</flux:button>
        <flux:separator variant="subtle" />
    </div>
    @if(session()->has('error'))
        <div 
            x-init="setTimeout(() => show = false, 3000)"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    <form wire:submit.prevent="submit" class="my-6 w-full space-y-6">
        <flux:input label="Categoría" type="text" wire:model="categoria" />
        <flux:textarea label="Descripción" wire:model="descripcion" />
        <flux:button variant="primary" type="submit">Guardar</flux:button>
    </form>
</div>