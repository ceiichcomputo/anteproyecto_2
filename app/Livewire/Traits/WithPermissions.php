<?php

namespace App\Livewire\Traits;

use Illuminate\Support\Facades\Auth;

trait WithPermissions
{
    protected function checkPermission(string $permission): void
    {
        abort_unless(
            Auth::check() &&
            Auth::user()->can($permission),
            403,
            'No tienes permisos para acceder.'
        );
    }

    protected function checkAnyPermission(array $permissions): void
    {
        abort_unless(
            Auth::check() &&
            Auth::user()->canAny($permissions),
            403,
            'No tienes permisos para acceder.'
        );
    }

    protected function checkRole(string $role): void
    {
        abort_unless(
            Auth::check() &&
            Auth::user()->hasRole($role),
            403,
            'No tienes permisos para acceder.'
        );
    }
}