<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\CatCategoriaAcademicas;

new class extends Component
{
    #[Validate('required', message: 'Favor de ingresar un título')]
    #[Validate('min:2', message: 'La longitud mínima del título es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del título es de 255 caracteres')]
    #[Validate('string', message: 'El contenido del título debe ser una cadena de texto')]
    public $categoria_academica;

    public $cat_cat_academica;
    public $mensaje = '';


    function submit() {

        $this->validate();

        if($this->cat_cat_academica){
            $this->cat_cat_academica->update([
                'categoria_academica' => $this->categoria_academica,
                'usuario_ins' => auth()->id(),
                'updated_at' => now()
            ]);
            $this->mensaje = 'Categoría académica actualizada correctamente';
        }else{
            CatCategoriaAcademicas::create([
                'categoria_academica' => $this->categoria_academica,
                'usuario_ins' => auth()->id(),
                'updated_at' => now()
            ]);
            $this->mensaje = 'Categoría académica creada correctamente';
        }

        session()->flash('success', $this->mensaje);
 
        return $this->redirect('/dashboard/cat_academicas');

        // dd($this->categoria_academica);
    }

    function mount(?int $id = null){
        if($id){
            $this->cat_cat_academica = CatCategoriaAcademicas::findOrFail($id);
            $this->categoria_academica = $this->cat_cat_academica->categoria_academica;
        }
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/cat_academicas');
    }
};
?>



<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Categorías Académicas') }}</flux:heading>
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
        <flux:input label="Categoría Académica" type="text" wire:model="categoria_academica" />
        <flux:button variant="primary" type="submit">Guardar</flux:button>
    </form>
</div>