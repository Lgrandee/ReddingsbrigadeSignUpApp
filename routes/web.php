<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActiviteitController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('Activiteiten', 'Activiteiten.index')->name('Activiteiten');
});


// Formulier tonen
Route::get('/planner/create', [ActiviteitController::class, 'create'])->name('activiteiten.create');
Route::post('/planner', [ActiviteitController::class, 'store'])->name('activiteiten.store');

require __DIR__.'/settings.php';
