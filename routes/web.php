<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::group(['prefix' => 'dashboard'], function () {
        Route::group(['prefix' => 'usuarios'], function () {
            Route::livewire('', 'pages::dashboard.usuarios.listado')->name('usuarios.listado');
            Route::livewire('crear', 'pages::dashboard.usuarios.agregar')->name('usuarios.agregar');
            Route::livewire('editar/{id}', 'pages::dashboard.usuarios.agregar')->name('usuarios.editar');
        });
        Route::group(['prefix' => 'academicos'], function () {
            Route::livewire('', 'pages::dashboard.academicos.listado')->name('academicos.listado');
            Route::livewire('crear', 'pages::dashboard.academicos.agregar')->name('academicos.agregar');
            Route::livewire('editar/{id}', 'pages::dashboard.academicos.agregar')->name('academicos.editar');
        });
        Route::group(['prefix' => 'roles'], function () {
            Route::livewire('', 'pages::dashboard.roles.listado')->name('roles.listado');
            Route::livewire('crear', 'pages::dashboard.roles.agregar')->name('roles.agregar');
            Route::livewire('editar/{id}', 'pages::dashboard.roles.agregar')->name('roles.editar');
        });
        Route::group(['prefix' => 'permisos'], function () {
            Route::livewire('', 'pages::dashboard.permisos.listado')->name('permisos.listado');
            Route::livewire('crear', 'pages::dashboard.permisos.agregar')->name('permisos.agregar');
            Route::livewire('editar/{id}', 'pages::dashboard.permisos.agregar')->name('permisos.editar');
        });
        Route::group(['prefix' => 'rubro'], function () {
            Route::livewire('', 'pages::dashboard.rubro.index')->name('rubro.index');
            Route::livewire('crear', 'pages::dashboard.rubro.save')->name('rubro.save');
            Route::livewire('editar/{id}', 'pages::dashboard.rubro.save')->name('rubro.edit');
        });
    });

});

require __DIR__.'/settings.php';
