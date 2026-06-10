<?php

use Livewire\Attributes\Computed;

?>

    <div class="text-center py-20">

        <h1 class="text-5xl font-bold">
            403
        </h1>

        <p class="mt-4">
            No tienes permisos para acceder.
        </p>

        <div class="mt-6 text-center">
             No tienes permisos para acceder a esta página.

             <a href="{{ url('/dashboard') }}" class="text-blue-500 hover:underline">
                Volver al inicio
            </a>
        </div>

    </div>

