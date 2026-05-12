<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\User;
use App\Models\UsersDetalle;

new class extends Component
{
    public $id_usuario;
    #[Validate('required', message: 'Favor de ingresar el apellido paterno')]
    #[Validate('min:2', message: 'La longitud mínima del apellido paterno es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del apellido paterno es de 255 caracteres')]
    #[Validate('string', message: 'El contenido del apellido paterno debe ser una cadena de texto')]
    public $apellido_paterno;
    #[Validate('required', message: 'Favor de ingresar el nombre')]
    #[Validate('min:2', message: 'La longitud mínima del nombre es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del nombre es de 255 caracteres')]
    #[Validate('string', message: 'El contenido del nombre debe ser una cadena de texto')]
    public $nombres;
    #[Validate('nullable|string')]
    public $apellido_materno;

    public $academico;

    public $mensaje = '';

    public $users = [];

    public $selectedUser;


    function submit() {
        try {
            $this->validate();

            if($this->selectedUser){
                $this->id_usuario = $this->selectedUser;

                if($this->academico){
                    $this->academico->id_usuario = $this->id_usuario;
                    $this->academico->update($this->validate());
                    $this->mensaje = 'Académico actualizado correctamente';
                }else{
                    UsersDetalle::create([
                        'id_usuario' => $this->id_usuario,
                        'apellido_paterno' => $this->apellido_paterno,
                        'nombres' => $this->nombres,
                        'apellido_materno' => $this->apellido_materno,
                    ]);
                    $this->mensaje = 'Académico creado correctamente';
                }

                session()->flash('success', $this->mensaje);
        
                return $this->redirect('/dashboard/academicos');
            }
            else{
                session()->flash('error', 'Favor de seleccionar al menos un usuario para el académico.');
                return;
            }

        } catch (\Exception $e) {
            report($e->getMessage());

            session()->flash(
                'error',
                'Ocurrió un error al actualizar el Académico, por favor intenta nuevamente.'
            );
        }
        

        // dd($this->module);
    }

    function mount(?int $id = null){
        if($id){
            $this->academico = UsersDetalle::findOrFail($id);
            $this->apellido_paterno = $this->academico->apellido_paterno;
            $this->nombres = $this->academico->nombres;
            $this->apellido_materno = $this->academico->apellido_materno;
            $this->id_usuario = $this->academico->id_usuario;
        }


        if( $id ){
            $this->selectedUser = $this->academico->id_usuario;
        }
        $this->users = User::orderBy('name')->get();
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/academicos');
    }
};
?>



<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Académicos') }}</flux:heading>
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
        <flux:input label="Apellido Paterno" type="text" wire:model="apellido_paterno" />
        <flux:input label="Apellido Materno" type="text" wire:model="apellido_materno" />
        <flux:input label="Nombres" type="text" wire:model="nombres" />
        

        {{-- Usuarios --}}
        <div class="mb-6">

            <h2 class="text-lg font-semibold mb-4">
                Usuarios
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 whitespace-normal">
                @foreach($users as $user)
                    <label class="flex items-center gap-2 border rounded p-3">
                        <input class="h-4 w-4 text-blue-600"
                            type="radio"
                            value="{{ $user->id }}"
                            wire:model="selectedUser"
                        >
                        <span>
                            {{ $user->name }}
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