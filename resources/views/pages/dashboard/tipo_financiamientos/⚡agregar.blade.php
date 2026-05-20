<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\CatTipoFinanciamiento;

new class extends Component
{
    #[Validate('required', message: 'Favor de ingresar un título')]
    #[Validate('min:2', message: 'La longitud mínima del título es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del título es de 255 caracteres')]
    #[Validate('string', message: 'El contenido del título debe ser una cadena de texto')]
    public $tipo_financiamiento;

    public $cat_tipo_financiamiento;
    public $mensaje = '';


    function submit() {

        $this->validate();

        if($this->cat_tipo_financiamiento){
            $this->cat_tipo_financiamiento->update([
                'tipo_financiamiento' => $this->tipo_financiamiento,
                'usuario_ins' => auth()->id(),
                'updated_at' => now()
            ]);
            $this->mensaje = 'Tipo de financiamiento actualizado correctamente';
        }else{
            CatTipoFinanciamiento::create([
                'tipo_financiamiento' => $this->tipo_financiamiento,
                'usuario_ins' => auth()->id(),
                'updated_at' => now()
            ]);
            $this->mensaje = 'Tipo de financiamiento creado correctamente';
        }

        session()->flash('success', $this->mensaje);
 
        return $this->redirect('/dashboard/tipo_financiamientos');

        // dd($this->tipo_financiamiento);
    }

    function mount(?int $id = null){
        if($id){
            $this->cat_tipo_financiamiento = CatTipoFinanciamiento::findOrFail($id);
            $this->tipo_financiamiento = $this->cat_tipo_financiamiento->tipo_financiamiento;
        }
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/tipo_financiamientos');
    }
};
?>



<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Tipos de Financiamiento') }}</flux:heading>
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
        <flux:input label="Tipo de Financiamiento" type="text" wire:model="tipo_financiamiento" />
        <flux:button variant="primary" type="submit">Guardar</flux:button>
    </form>
</div>