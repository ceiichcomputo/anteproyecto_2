<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <flux:input label="Nombre del evento" :disabled="!$this->pueden_editar" type="text" wire:model="nombre_evento" />
    </div>

    <div>
        <flux:input label="Descripción del evento" :disabled="!$this->pueden_editar" type="text" wire:model="descripcion_evento" />
    </div>

    <div>
        <flux:input type="date" label="Fecha inicio" :disabled="!$this->pueden_editar" wire:model="fecha_inicio_evento" />
    </div>
    
    <div>
        <flux:input type="date" label="Fecha final" :disabled="!$this->pueden_editar" wire:model="fecha_fin_evento" />
    </div>
    
    {{-- <div>
        <flux:input label="Presupuesto estimado" :disabled="!$this->modificar_monto_estimado" type="number" wire:model="monto_estimado" />
    </div> --}}

</div>