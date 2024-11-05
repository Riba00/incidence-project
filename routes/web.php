<?php

use App\Livewire\EditIncidenceForm;
use App\Livewire\ShowIncidence;
use App\Livewire\DeleteIncidenceForm;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome');

Route::redirect('/', 'incidences');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
    Route::view('incidences', 'incidences.index')->name('incidences.index');
    Route::view('incidences/create', 'incidences.create')->name('incidences.create');

    Route::get('incidences/{id}', ShowIncidence::class)->name('incidences.show');
    Route::get('incidences/edit/{id}', EditIncidenceForm::class)->name('incidences.edit');
    Route::get('incidences/delete/{id}', DeleteIncidenceForm::class)->name('incidences.delete');
    
});

require __DIR__ . '/auth.php';
