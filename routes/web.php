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
        Route::group(['prefix' => 'categorias'], function () {
            Route::livewire('rubro/{rubro_id}', 'pages::dashboard.categorias.rubrolist')->name('categorias.rubrolist');
            Route::livewire('crear/{rubro_id}', 'pages::dashboard.categorias.agregar')->name('categorias.agregar');
            Route::livewire('editar/{rubro_id}/{id}', 'pages::dashboard.categorias.agregar')->name('categorias.editar');
        });
        Route::group(['prefix' => 'subcategorias'], function () {
            Route::livewire('categorias/{categoria_id}', 'pages::dashboard.subcategorias.listado')->name('subcategorias.listado');
            Route::livewire('crear/{categoria_id}', 'pages::dashboard.subcategorias.agregar')->name('subcategorias.agregar');
            Route::livewire('editar/{categoria_id}/{id}', 'pages::dashboard.subcategorias.agregar')->name('subcategorias.editar');
        });
        Route::group(['prefix' => 'cat_academicas'], function () {
            Route::livewire('', 'pages::dashboard.cat_academicas.listado')->name('cat_academicas.listado');
            Route::livewire('crear', 'pages::dashboard.cat_academicas.agregar')->name('cat_academicas.agregar');
            Route::livewire('editar/{id}', 'pages::dashboard.cat_academicas.agregar')->name('cat_academicas.editar');
        });
        Route::group(['prefix' => 'tipo_financiamientos'], function () {
            Route::livewire('', 'pages::dashboard.tipo_financiamientos.listado')->name('tipo_financiamientos.listado');
            Route::livewire('crear', 'pages::dashboard.tipo_financiamientos.agregar')->name('tipo_financiamientos.agregar');
            Route::livewire('editar/{id}', 'pages::dashboard.tipo_financiamientos.agregar')->name('tipo_financiamientos.editar');
        });
        Route::group(['prefix' => 'tipo_solicitudes'], function () {
            Route::livewire('', 'pages::dashboard.tipo_solicitudes.listado')->name('tipo_solicitudes.listado');
            Route::livewire('crear', 'pages::dashboard.tipo_solicitudes.agregar')->name('tipo_solicitudes.agregar');
            Route::livewire('editar/{id}', 'pages::dashboard.tipo_solicitudes.agregar')->name('tipo_solicitudes.editar');
        });
        Route::group(['prefix' => 'anteproyecto'], function () {
            Route::livewire('', 'pages::dashboard.anteproyecto.listado')->name('anteproyecto.listado');
            Route::livewire('crear', 'pages::dashboard.anteproyecto.agregar')->name('anteproyecto.agregar');
            Route::livewire('editar/{id}', 'pages::dashboard.anteproyecto.agregar')->name('anteproyecto.editar');
            Route::livewire('listado_rubro/{anteproyecto_id}', 'pages::dashboard.anteproyecto.listado_rubro')->name('anteproyecto.listado_rubro');
            Route::livewire('crear_rubro/{anteproyecto_id}', 'pages::dashboard.anteproyecto.agregar_rubro')->name('anteproyecto.agregar_rubro');
            Route::livewire('editar_rubro/{anteproyecto_id}/{rubro_id}', 'pages::dashboard.anteproyecto.agregar_rubro')->name('anteproyecto.editar_rubro');
        });
    });

});

require __DIR__.'/settings.php';
