<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Role;
use App\Models\User;
use Livewire\Attributes\On;

new class extends Component
{
    #[Validate('required', message: 'Favor de ingresar el nombre del permiso')]
    #[Validate('min:2', message: 'La longitud mínima del nombre es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del nombre es de 255 caracteres')]
    #[Validate('string', message: 'El contenido del nombre debe ser una cadena de texto')]
    public $name;
    #[Validate('required', message: 'Favor de ingresar el correo electrónico del usuario')]
    #[Validate('email', message: 'Favor de ingresar un correo electrónico válido')]
    #[Validate('min:2', message: 'La longitud mínima del nombre es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del nombre es de 255 caracteres')]
    public $email;

    public User $user;

    public $usuario;

    public $roles = [];

    public $selectedRoles = [];

    public function mount(?int $id = null)
    {
        if( $id ){
            $this->usuario = User::findOrFail($id);
            $this->name = $this->usuario->name;
            $this->email = $this->usuario->email;
        }

        $this->roles = Role::orderBy('name')->get();

        //dd($rol);

        if( $id ){
            $this->selectedRoles = $this->usuario->roles->pluck('name')->toArray();
        }
    }

    public function update()
    {
        if($this->usuario){
            $this->usuario->update($this->validate());
            $this->dispatch('usuario-actualizado');
            // $this->dispatch('usuario-actualizado', type: 'success', message: 'Usuario actualizado correctamente');
        }else{
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'guard_name' => $this->guard_name,
            ]);

            $this->dispatch('usuario-actualizado', type: 'success', message: 'Usuario creado correctamente');
        }

        //dd($this->selectedRoles);

        // Sincronizar roles
        $this->usuario->syncRoles($this->selectedRoles);

        session()->flash('success', 'Usuario actualizado correctamente');

        return $this->redirect('/dashboard/usuarios');
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/usuarios');
    }

    // public function render()
    // {
    //     return view('livewire.roles.edit');
    // }
};
?>

<div>

    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Usuarios') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:button type="button" wire:click="regresar" wire:confirm="Se perderán todos los cambios, ¿Deseas continuar?">Regresar</flux:button>
        <flux:separator variant="subtle" />
    </div>

    <form wire:submit="update">
        <flux:input label="Nombre" type="text" wire:model="name" />
        <flux:input label="Correo Electrónico" type="email" wire:model="email" />

        {{-- Roles --}}
        <div class="mb-6">

            <h2 class="text-lg font-semibold mb-4">
                Roles
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 whitespace-normal">
                @foreach($roles as $role)
                    <label class="flex items-center gap-2 border rounded p-3">
                        <input class="h-4 w-4 text-blue-600"
                            type="checkbox"
                            value="{{ $role->name }}"
                            wire:model="selectedRoles"
                        >
                        <span>
                            {{ $role->name }}
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