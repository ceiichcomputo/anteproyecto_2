<x-layouts::auth :title="__('Recuperación de contraseña')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Recuperación contraseña')" :description="__('Ingresa el correo electrónico para recibir un link de restauración')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Correo electrónico')"
                type="email"
                required
                autofocus
                placeholder="email@example.com"
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="email-password-reset-link-button">
                {{ __('Enviar correo para restaurar contraseña') }}
            </flux:button>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
            <span>{{ __('O, regresar a ') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('inicar sesión') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
