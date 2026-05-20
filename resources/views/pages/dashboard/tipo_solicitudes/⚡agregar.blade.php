<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\CatTipoSolicitudes;

new class extends Component
{
    #[Validate('required', message: 'Favor de ingresar un título')]
    #[Validate('min:2', message: 'La longitud mínima del título es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del título es de 255 caracteres')]
    #[Validate('string', message: 'El contenido del título debe ser una cadena de texto')]
    public $tipo_solicitud;

    public $cat_tipo_solicitud;
    public $mensaje = '';


    function submit() {

        $this->validate();

        if($this->cat_tipo_solicitud){
            $this->cat_tipo_solicitud->update([
                'tipo_solicitud' => $this->tipo_solicitud,
                'usuario_ins' => auth()->id(),
                'updated_at' => now()
            ]);
            $this->mensaje = 'Tipo de solicitud actualizado correctamente';
        }else{
            CatTipoSolicitudes::create([
                'tipo_solicitud' => $this->tipo_solicitud,
                'usuario_ins' => auth()->id(),
                'updated_at' => now()
            ]);
            $this->mensaje = 'Tipo de solicitud creada correctamente';
        }

        session()->flash('success', $this->mensaje);
 
        return $this->redirect('/dashboard/tipo_solicitudes');

        // dd($this->categoria_academica);
    }

    function mount(?int $id = null){
        if($id){
            $this->cat_tipo_solicitud = CatTipoSolicitudes::findOrFail($id);
            $this->tipo_solicitud = $this->cat_tipo_solicitud->tipo_solicitud;
        }
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/tipo_solicitudes');
    }
};
?>



<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Tipos de Solicitud') }}</flux:heading>
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
        <flux:input label="Tipo de Solicitud" type="text" wire:model="tipo_solicitud" />
        <flux:button variant="primary" type="submit">Guardar</flux:button>
    </form>
</div>