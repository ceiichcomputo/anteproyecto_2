<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Permission;

new class extends Component
{
    #[Validate('required', message: 'Favor de ingresar un módulo')]
    #[Validate('min:2', message: 'La longitud mínima del módulo es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del módulo es de 255 caracteres')]
    #[Validate('string', message: 'El contenido del módulo debe ser una cadena de texto')]
    public $module;
    #[Validate('required', message: 'Favor de ingresar el nombre del permiso')]
    #[Validate('min:2', message: 'La longitud mínima del nombre es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del nombre es de 255 caracteres')]
    #[Validate('string', message: 'El contenido del nombre debe ser una cadena de texto')]
    public $name;
    #[Validate('nullable|string')]
    public $description;

    public $permiso;

    public $mensaje = '';


    function submit() {

        $this->validate();

        if($this->permiso){
            $this->permiso->update($this->validate());
            $mensaje = 'Permiso actualizado correctamente';
        }else{
            Permission::create([
                'module' => $this->module,
                'name' => $this->name,
                'description' => $this->description,
                'guard_name' => 'web',
            ]);
            $mensaje = 'Permiso creado correctamente';
        }

        session()->flash('status', $mensaje);
 
        return $this->redirect('/dashboard/permisos');

        // dd($this->module);
    }

    function mount(?int $id = null){
        if($id){
            $this->permiso = Permission::findOrFail($id);
            $this->module = $this->permiso->module;
            $this->name = $this->permiso->name;
            $this->description = $this->permiso->description;
        }
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/roles');
    }
};
?>



<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Permisos') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:button type="button" wire:click="regresar" wire:confirm="Se perderán todos los cambios, ¿Deseas continuar?">Regresar</flux:button>
        <flux:separator variant="subtle" />
    </div>
    <form wire:submit.prevent="submit" class="my-6 w-full space-y-6">
        <flux:input label="Módulo" type="text" wire:model="module" />
        <flux:input label="Nombre" type="text" wire:model="name" />
        <flux:textarea label="Descripción" wire:model="description" />
        <flux:button variant="primary" type="submit">Guardar</flux:button>
    </form>
</div>