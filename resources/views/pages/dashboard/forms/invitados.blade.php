<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <flux:input label="Actividades a desarrollar" :disabled="!$this->pueden_editar" type="text" wire:model="actividades_a_desarrollar" />
    </div>

    <div>
        <flux:input label="Descripción del evento" :disabled="!$this->pueden_editar" type="text" wire:model="descripcion_evento" />
    </div>

    <div>
        <flux:input label="Nombre Invitado" :disabled="!$this->pueden_editar" type="text" wire:model="nombre_invitado" />
    </div>

    <div>
        <flux:input label="Procedencia Invitado" :disabled="!$this->pueden_editar" type="text" wire:model="procedencia_invitado" />
    </div>

    <div>
        <flux:input type="date" label="Fecha inicio" :disabled="!$this->pueden_editar" wire:model="fecha_inicio_evento" />
    </div>
    
    <div>
        <flux:input type="date" label="Fecha final" :disabled="!$this->pueden_editar" wire:model="fecha_fin_evento" />
    </div>
    
    <div>
        <flux:input label="Monto estimado" :disabled="!$this->modificar_monto_estimado" type="number" wire:model="monto_estimado" />
    </div>

</div>