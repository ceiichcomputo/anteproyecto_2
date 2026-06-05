<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <flux:select label="País destino" :disabled="!$this->pueden_editar" wire:model.live="selectedPais">
            <flux:select.option value="">Selecciona el País destino</flux:select.option>
                @foreach($catPaises as $item)
                    <flux:select.option value="{{ $item->id }}">
                        {{ $item->pais }}
                    </flux:select.option>
                @endforeach
        </flux:select>
    </div>

    <div>
        <flux:select label="Estado destino" :disabled="!$this->pueden_editar" wire:model.live="selectedEstado">
            <flux:select.option value="">Selecciona el Estado destino</flux:select.option>
                @foreach($catEstados as $item)
                    <flux:select.option value="{{ $item->id }}">
                        {{ $item->estado }}
                    </flux:select.option>
                @endforeach
        </flux:select>
    </div>

    <div>
        <flux:input label="Lugar institución" :disabled="!$this->pueden_editar" type="text" wire:model="lugar_institucion" />
    </div>

    <div>
        <flux:input type="date" label="Fecha inicio" :disabled="!$this->pueden_editar" wire:model="fecha_inicio_viaje" />
    </div>
    
    <div>
        <flux:input type="date" label="Fecha final" :disabled="!$this->pueden_editar" wire:model="fecha_fin_viaje" />
    </div>
    
    <div>
        <flux:input label="Monto estimado" :disabled="!$this->modificar_monto_estimado" type="number" wire:model="monto_estimado" />
    </div>

</div>
