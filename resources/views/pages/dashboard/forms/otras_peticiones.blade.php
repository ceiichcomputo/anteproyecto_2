<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <flux:textarea label="Petición" rows="3" :disabled="!$this->pueden_editar" type="text" wire:model="peticion" />
    </div>
    
    {{-- <div>
        <flux:input label="Presupuesto estimado" :disabled="!$this->modificar_monto_estimado" type="number" wire:model="monto_estimado" />
    </div> --}}

</div>