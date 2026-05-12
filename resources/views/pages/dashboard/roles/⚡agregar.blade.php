<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Role;
use App\Models\Permission;
use Livewire\Attributes\On;

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

    public Role $role;

    public $rol;

    public $permissions = [];

    public $selectedPermissions = [];

    public function mount(?int $id = null)
    {
        if( $id ){
            $this->rol = Role::findOrFail($id);
            $this->name = $this->rol->name;
            $this->description = $this->rol->description;
            $this->guard_name = $this->rol->guard_name;
        }

        $this->permissions = Permission::orderBy('module')->orderBy('name')->get();

        //dd($rol);

        if( $id ){
            $this->selectedPermissions = $this->rol->permissions->pluck('name')->toArray();
        }
    }

    public function update()
    {
        if($this->rol){
            $this->rol->update($this->validate());
            $this->dispatch('rol-actualizado');
            // $this->dispatch('rol-actualizado', type: 'success', message: 'Rol actualizado correctamente');
        }else{
            Role::create([
                'name' => $this->name,
                'description' => $this->description,
                'guard_name' => $this->guard_name,
            ]);

            $this->dispatch('rol-actualizado', type: 'success', message: 'Rol creado correctamente');
        }

        //dd($this->selectedPermissions);

        // Sincronizar permisos
        $this->rol->syncPermissions($this->selectedPermissions);

        session()->flash('success', 'Rol actualizado correctamente');

        return $this->redirect('/dashboard/roles');
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/roles');
    }

    // public function render()
    // {
    //     return view('livewire.roles.edit');
    // }
};
?>

<div>

    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Roles') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:button type="button" wire:click="regresar" wire:confirm="Se perderán todos los cambios, ¿Deseas continuar?">Regresar</flux:button>
        <flux:separator variant="subtle" />
    </div>

    <form wire:submit="update">

        
        <flux:input label="Nombre" type="text" wire:model="name" />
        <flux:textarea label="Descripción" wire:model="description" />
        <flux:input label="Nombre del Guard" type="text" wire:model="guard_name" />

        {{-- Permisos --}}
        <div class="mb-6">

            <h2 class="text-lg font-semibold mb-4">
                Permisos
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 whitespace-normal">
                @foreach($permissions as $permission)
                    <label class="flex items-center gap-2 border rounded p-3">
                        <input class="h-4 w-4 text-blue-600"
                            type="checkbox"
                            value="{{ $permission->name }}"
                            wire:model="selectedPermissions"
                        >
                        <span>
                            {{ $permission->name }}
                        </span>
                    </label>
                @endforeach
            </div>

        </div>

        {{-- Botón --}}
        <div class="flex justify-end">
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded"
            >
                Guardar
            </button>
        </div>
    </form>
</div>