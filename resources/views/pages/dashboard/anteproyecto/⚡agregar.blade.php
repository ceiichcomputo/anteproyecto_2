<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\CatCategoria;
use App\Models\TAnteproyectos;
use App\Models\CatEjercicio;
use App\Services\CatEjercicioService;

new class extends Component
{
    #[Validate('required', message: 'Favor de seleccionar un ejercicio')]
    #[Validate('numeric', message: 'Favor de seleccionar un ejercicio')]
    public $id_ejercicio;

    public $anios = [];

    public $objAnteproyecto;

    public $mensaje = '';


    function submit() {
        $service = app(CatEjercicioService::class);

        $this->validate();

        // VALIDAR DUPLICADO
        $existe = $service->ValidaSiExisteParaUsuario($this->id_ejercicio, auth()->id());

        if ($existe) {

        session()->flash('error', 'Ya existe un Anteproyecto registrado para este año.');

            return;
        }
        
        $objAnteproyecto = TAnteproyectos::create([
            'id_ejercicio' => $this->id_ejercicio,
            'id_usuario' => auth()->id(),
            'updated_at' => now()
        ]);
        $this->mensaje = 'Anteproyecto creado correctamente';

        session()->flash('success', $this->mensaje);
 
        return $this->redirect('/dashboard/anteproyecto/listado_rubro/' . $objAnteproyecto->id);
    }

    function mount(){
        $this->anios =
            CatEjercicio::orderBy('ejercicio', 'asc')
                ->get();
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/anteproyecto/');
    }
};
?>



<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Ejercicio a Capturar Anteproyecto: ') }}</flux:heading>
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
        <flux:select label="Ejercicio" size="sm" wire:model="id_ejercicio">
            <flux:select.option value="">Selecciona el ejercicio</flux:select.option>
                @foreach($anios as $anio)
                    <flux:select.option value="{{ $anio->id }}">
                        {{ $anio->ejercicio. '- Inicia captura: ' . $anio->fecha_captura_inicio . '- Termina captura: ' .$anio->fecha_captura_fin}}
                    </flux:select.option>
                @endforeach
        </flux:select>
        <flux:button variant="primary" type="submit">Guardar</flux:button>
    </form>
</div>