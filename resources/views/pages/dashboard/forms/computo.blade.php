<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    {{-- <div>
        <flux:select label="Objeto a comprar" size="sm" wire:model="objeto_comprar">
            <flux:select.option value="">Selecciona el tipo de objeto</flux:select.option>
                <flux:select.option value="HW">Hardware</flux:select.option>
                <flux:select.option value="SW">Software</flux:select.option>
        </flux:select>
    </div> --}}

    <div>
        <flux:input label="Justificacion compra" :disabled="!$this->pueden_editar" type="text" wire:model="justificacion_objeto_comprar" />
    </div>
    
    {{-- <div>
        <flux:input label="Presupuesto estimado" :disabled="!$this->modificar_monto_estimado" type="number" wire:model="monto_estimado" />
    </div> --}}

</div>