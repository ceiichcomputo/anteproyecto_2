<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Role;

new class extends Component
{
    #[Validate('required', message: 'Favor de ingresar el nombre del permiso')]
    #[Validate('min:2', message: 'La longitud mínima del nombre es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del nombre es de 255 caracteres')]
    #[Validate('string', message: 'El contenido del nombre debe ser una cadena de texto')]
    public $name;
    #[Validate('nullable|string')]
    public $description;
    #[Validate('required', message: 'Favor de ingresar el nombre del permiso')]
    #[Validate('min:2', message: 'La longitud mínima del nombre es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del nombre es de 255 caracteres')]
    #[Validate('string', message: 'El contenido del nombre debe ser una cadena de texto')]
    public $guard_name;

    public $rol;


    function submit() {

        $this->validate();

        if($this->rol){
            $this->rol->update($this->validate());
            $this->dispatch("updated");
        }else{
            Role::create([
                'name' => $this->name,
                'description' => $this->description,
                'guard_name' => $this->guard_name,
            ]);
        }

        session()->flash('status', 'Post successfully updated.');
 
        return $this->redirect('/dashboard/roles');

        // dd($this->module);
    }

    function mount(?int $id = null){
        if($id){
            $this->rol = Role::findOrFail($id);
            $this->name = $this->rol->name;
            $this->description = $this->rol->description;
            $this->guard_name = $this->rol->guard_name;
        }
    }
};
?>



<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Roles') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    <form wire:submit.prevent="submit" class="my-6 w-full space-y-6">
        <flux:input label="Nombre" type="text" wire:model="name" />
        <flux:textarea label="Descripción" wire:model="description" />
        <flux:input label="Nombre del Guard" type="text" wire:model="guard_name" />
        <flux:button variant="primary" type="submit">Guardar</flux:button>
    </form>
</div>