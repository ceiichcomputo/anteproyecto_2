<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <flux:input label="Actividades a desarrollar" :disabled="!$this->pueden_editar" type="text" wire:model="actividades_a_desarrollar" />
    </div>

    <div>
        <flux:input label="Nombre becario" :disabled="!$this->pueden_editar" type="text" wire:model="nombre_becario" />
    </div>

    <div>
        <flux:input type="date" label="Fecha inicio" :disabled="!$this->pueden_editar" wire:model="fecha_inicio" />
    </div>
    
    <div>
        <flux:input type="date" label="Fecha final" :disabled="!$this->pueden_editar" wire:model="fecha_final" />
    </div>
    
    <div>
        <flux:input label="Presupuesto estimado" :disabled="!$this->modificar_monto_estimado" type="number" wire:model="monto_estimado" />
    </div>

</div>