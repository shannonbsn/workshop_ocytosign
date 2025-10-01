<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InterpreteController;
use App\Http\Controllers\MedecinController;

Route::get('/', function () {
    return view('welcome');
});

// Routes pour la table Interpretes
Route::get('/interpretres', [InterpreteController::class, 'index'])->name('interpretres.index');
Route::post('/interpretres', [InterpreteController::class, 'store'])->name('interpretres.store');
Route::get('/interpretres/{id}', [InterpreteController::class, 'show'])->name('interpretres.show');
Route::put('/interpretres/{id}', [InterpreteController::class, 'update'])->name('interpretres.update');
Route::delete('/interpretres/{id}', [InterpreteController::class, 'destroy'])->name('interpretres.destroy');

// Routes pour la table Medecins
Route::get('/medecins', [MedecinController::class, 'index'])->name('medecins.index');
Route::post('/medecins', [MedecinController::class, 'store'])->name('medecins.store');
Route::get('/medecins/{id}', [MedecinController::class, 'show'])->name('medecins.show');
Route::put('/medecins/{id}', [MedecinController::class, 'update'])->name('medecins.update');
Route::delete('/medecins/{id}', [MedecinController::class, 'destroy'])->name('medecins.destroy');
