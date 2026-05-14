<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\CatSubcategoria;

new class extends Component
{
    #[Validate('required', message: 'Favor de ingresar un título')]
    #[Validate('min:2', message: 'La longitud mínima del título es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del título es de 255 caracteres')]
    #[Validate('string', message: 'El contenido del título debe ser una cadena de texto')]
    public $titulo;
    #[Validate('nullable|string')]
    public $descripcion;

    public $rubro;
    
    public $mensaje = '';


    function submit() {

        $this->validate();

        if($this->rubro){
            $this->rubro->update([
                'titulo' => $this->titulo,
                'descripcion' => $this->descripcion,
                'usuario_mod' => auth()->id(),
                'updated_at' => now()
            ]);
            $this->mensaje = 'Subcategoría actualizada correctamente';
        }else{
            CatSubcategoria::create([
                'titulo' => $this->titulo,
                'descripcion' => $this->descripcion,
                'usuario_mod' => auth()->id(),
                'updated_at' => now()
            ]);
            $this->mensaje = 'Subcategoría creada correctamente';
        }

        session()->flash('success', $this->mensaje);
 
        return $this->redirect('/dashboard/subcategorias');

        // dd($this->titulo);
    }

    function mount(?int $id = null){
        if($id){
            $this->subcategoria = CatSubcategoria::findOrFail($id);
            $this->titulo = $this->subcategoria->titulo;
            $this->descripcion = $this->subcategoria->descripcion;
        }
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/subcategorias');
    }
};
?>



<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Subcategorias') }}</flux:heading>
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
        <flux:input label="Título" type="text" wire:model="titulo" />
        <flux:textarea label="Descripción" wire:model="descripcion" />
        <flux:button variant="primary" type="submit">Guardar</flux:button>
    </form>
</div>