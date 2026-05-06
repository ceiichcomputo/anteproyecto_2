<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\CatRubro;

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


    function submit() {

        $this->validate();

        if($this->rubro){
            $this->rubro->update($this->validate());
            $this->dispatch("updated");
        }else{
            CatRubro::create([
                'titulo' => $this->titulo,
                'descripcion' => $this->descripcion,
            ]);
        }

        session()->flash('status', 'Post successfully updated.');
 
        return $this->redirect('/dashboard/rubro');

        // dd($this->titulo);
    }

    function mount(?int $id = null){
        if($id){
            $this->rubro = CatRubro::findOrFail($id);
            $this->titulo = $this->rubro->titulo;
            $this->descripcion = $this->rubro->descripcion;
        }
    }
};
?>



<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Rubros') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    <form wire:submit.prevent="submit" class="my-6 w-full space-y-6">
        <flux:input label="Título" type="text" wire:model="titulo" />
        <flux:textarea label="Descripción" wire:model="descripcion" />
        <flux:button variant="primary" type="submit">Guardar</flux:button>
    </form>
</div>