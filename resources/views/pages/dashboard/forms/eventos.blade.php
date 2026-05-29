<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <flux:input label="Nombre del evento" type="text" wire:model="nombre_evento" />
    </div>

    <div>
        <flux:input label="Descripción del evento" type="text" wire:model="descripcion_evento" />
    </div>

    <div>
        <flux:input type="date" label="Fecha inicio" wire:model="fecha_inicio_evento" />
    </div>
    
    <div>
        <flux:input type="date" label="Fecha final" wire:model="fecha_fin_evento" />
    </div>
    
    <div>
        <flux:input label="Monto estimado" :disabled="!$this->modificar_monto_estimado" type="number" wire:model="monto_estimado" />
    </div>

</div>