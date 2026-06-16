<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <flux:select label="Tipo de Financiamiento" :disabled="!$this->pueden_editar" wire:model.live="selected_tipo_financiamiento">
            <flux:select.option value="">Selecciona el Tipo de financiamiento</flux:select.option>
                @foreach($cat_tipo_financiamientos as $item)
                    <flux:select.option value="{{ $item->id }}">
                        {{ $item->tipo_financiamiento }}
                    </flux:select.option>
                @endforeach
        </flux:select>
    </div>

    <div>
        <flux:input label="Título del proyecto" :disabled="!$this->pueden_editar" type="text" wire:model="titulo_proyecto" />
    </div>

    <div>
        <flux:input label="Nombre de la dependencia" :disabled="!$this->pueden_editar" type="text" wire:model="nombre_dependencia" />
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
