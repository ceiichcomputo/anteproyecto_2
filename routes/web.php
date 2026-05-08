<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::group(['prefix' => 'dashboard'], function () {
        Route::group(['prefix' => 'rubro'], function () {
            Route::livewire('', 'pages::dashboard.rubro.index')->name('rubro.index');
            Route::livewire('crear', 'pages::dashboard.rubro.save')->name('rubro.save');
            Route::livewire('editar/{id}', 'pages::dashboard.rubro.save')->name('rubro.edit');
        });
        Route::group(['prefix' => 'permisos'], function () {
            Route::livewire('', 'pages::dashboard.permisos.listado')->name('permisos.listado');
            Route::livewire('crear', 'pages::dashboard.permisos.agregar')->name('permisos.agregar');
            Route::livewire('editar/{id}', 'pages::dashboard.permisos.agregar')->name('permisos.editar');
        });
        Route::group(['prefix' => 'roles'], function () {
            Route::livewire('', 'pages::dashboard.roles.listado')->name('roles.listado');
            Route::livewire('crear', 'pages::dashboard.roles.agregar')->name('roles.agregar');
            Route::livewire('editar/{id}', 'pages::dashboard.roles.agregar')->name('roles.editar');
        });
    });

});

require __DIR__.'/settings.php';
