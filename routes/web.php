<?php

use App\Http\Controllers\ActiviteitController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ActiviteitController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('activiteiten', 'planner.activiteiten')->name('activiteiten');
    Route::view('planner/activiteiten/create', 'planner.create')->name('planner.create');

});

// Formulier tonen
Route::get('/activiteiten/create', [ActiviteitController::class, 'create'])->name('activiteiten.create');
Route::post('/activiteiten', [ActiviteitController::class, 'store'])->name('activiteiten.store');

require __DIR__.'/settings.php';
