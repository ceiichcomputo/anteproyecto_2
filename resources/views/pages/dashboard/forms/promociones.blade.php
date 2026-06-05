<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <flux:select label="Tipo de Solicitud" :disabled="!$this->pueden_editar" wire:model.live="selected_tipo_solicitud">
            <flux:select.option value="">Selecciona el Tipo de solicitud</flux:select.option>
                @foreach($cat_tipo_solicitudes as $item)
                    <flux:select.option value="{{ $item->id }}">
                        {{ $item->tipo_solicitud }}
                    </flux:select.option>
                @endforeach
        </flux:select>
    </div>

    <div>
        <flux:select label="Categoría Académica" :disabled="!$this->pueden_editar" wire:model.live="selected_categoria_academica">
            <flux:select.option value="">Selecciona la Categoría Académica</flux:select.option>
                @foreach($cat_categoria_academicas as $item)
                    <flux:select.option value="{{ $item->id }}">
                        {{ $item->categoria_academica }}
                    </flux:select.option>
                @endforeach
        </flux:select>
    </div>

    <div>
        <flux:input label="Descripción promoción" :disabled="!$this->pueden_editar" type="text" wire:model="descripcion_promocion" />
    </div>

    <div>
        <flux:input type="date" label="Fecha inicio" :disabled="!$this->pueden_editar" wire:model="fecha_inicio_promocion" />
    </div>
    
    <div>
        <flux:input type="date" label="Fecha final" :disabled="!$this->pueden_editar" wire:model="fecha_fin_promocion" />
    </div>
    
    <div>
        <flux:input label="Monto estimado" :disabled="!$this->modificar_monto_estimado" type="number" wire:model="monto_estimado" />
    </div>

</div>
