<?php

use App\Http\Controllers\ActiviteitController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ActiviteitController::class, 'index'])->name('home');
Route::get('/activiteiten', [ActiviteitController::class, 'index'])->name('activiteiten');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth', 'verified', 'can:manage-activities'])->group(function () {
    Route::get('/activiteiten/create', [ActiviteitController::class, 'create'])->name('planner.create');
    Route::post('/activiteiten', [ActiviteitController::class, 'store'])->name('activiteiten.store');
    Route::get('/activiteiten/{activiteit}/bewerken', [ActiviteitController::class, 'edit'])->name('activiteiten.edit');
    Route::put('/activiteiten/{activiteit}', [ActiviteitController::class, 'update'])->name('activiteiten.update');
    Route::delete('/activiteiten/{activiteit}', [ActiviteitController::class, 'destroy'])->name('activiteiten.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/activiteiten/{activiteit}/aanmelden', [ActiviteitController::class, 'signup'])
        ->name('activiteiten.signup');
    Route::delete('/activiteiten/{activiteit}/aanmelding', [ActiviteitController::class, 'cancelSignup'])
        ->name('activiteiten.cancel-signup');
    Route::put('/profiel/diplomas', [ActiviteitController::class, 'updateDiplomas'])
        ->name('diplomas.update');
});

require __DIR__.'/settings.php';
