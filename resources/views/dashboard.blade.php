<x-layouts::app :title="__('Dashboard')">
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        {{-- <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div> --}}
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />

            @if(session()->has('error'))
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 3000)"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if(session()->has('success'))
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 3000)"
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <div class="p-6 align-center text-center">
                <h1 class="text-2xl font-bold mb-4">Te damos la bienvenida</h1>
                <p class="text-gray-700 dark:text-gray-300">Aquí podrás gestionar tus rubros y más.</p>
            </div>
        </div>

        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Documentos</h1>
            <a href="storage/Documentos/INSTRUCCIONES_ANTEPROYECTO2027.pdf" target="_blank" style="color: #2b87c8;">Guía de usuario Anteproyecto 2027</a>
        </div>
    </div>
</x-layouts::app>
