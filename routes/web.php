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
        //  Route::group(['prefix' => 'categoria'], function () {
        //     Route::livewire('', 'pages::dashboard.categoria.index')->name('categoria.index');
        //     Route::livewire('crear', 'pages::dashboard.categoria.save')->name('categoria.save');
        //     Route::livewire('editar/{id}', 'pages::dashboard.categoria.save')->name('categoria.edit');
        // });
    });

});

require __DIR__.'/settings.php';
