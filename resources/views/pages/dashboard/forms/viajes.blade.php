<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    {{-- DESTINO --}}
    <div>
        <label class="block mb-2 font-semibold">
            Destino
        </label>
        <input
            type="text"
            wire:model="destino"
            class="w-full border rounded px-3 py-2"
        >

        @error('destino')

            <span class="text-red-500 text-sm">

                {{ $message }}

            </span>

        @enderror

    </div>

    {{-- FECHA --}}
    <div>

        <label class="block mb-2 font-semibold">

            Fecha salida

        </label>

        <input
            type="date"
            wire:model="fechaSalida"
            class="w-full border rounded px-3 py-2"
        >

        @error('fechaSalida')

            <span class="text-red-500 text-sm">

                {{ $message }}

            </span>

        @enderror

    </div>

    {{-- HOSPEDAJE --}}
    <div>

        <label class="block mb-2 font-semibold">

            Hospedaje

        </label>

        <input
            type="number"
            step="0.01"
            wire:model="hospedaje"
            class="w-full border rounded px-3 py-2"
        >

        @error('hospedaje')

            <span class="text-red-500 text-sm">

                {{ $message }}

            </span>

        @enderror

    </div>

</div>