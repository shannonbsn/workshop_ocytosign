<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InterpreteController;

Route::get('/', function () {
    return view('welcome');
});

// Routes pour la table Interpretes
Route::get('/interpretres', [InterpreteController::class, 'index'])->name('interpretres.index');
Route::post('/interpretres', [InterpreteController::class, 'store'])->name('interpretres.store');
Route::get('/interpretres/{id}', [InterpreteController::class, 'show'])->name('interpretres.show');
Route::put('/interpretres/{id}', [InterpreteController::class, 'update'])->name('interpretres.update');
Route::delete('/interpretres/{id}', [InterpreteController::class, 'destroy'])->name('interpretres.destroy');
