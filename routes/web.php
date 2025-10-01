<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use App\Http\Controllers\InterpreteController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\ModelClientController;

Route::get('/', function () {
    return view('welcome');
});

// Création du token d'authentification
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

// Route pour l'authentification des clients
Route::post('/login', [ModelClientController::class, 'login'])->name('clients.login');

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

// Routes pour la table Clients
Route::get('/clients', [ModelClientController::class, 'index'])->name('clients.index');
Route::post('/clients', [ModelClientController::class, 'store'])->name('clients.store');
Route::get('/clients/{id}', [ModelClientController::class, 'show'])->name('clients.show');
Route::put('/clients/{id}', [ModelClientController::class, 'update'])->name('clients.update');
Route::delete('/clients/{id}', [ModelClientController::class, 'destroy'])->name('clients.destroy');
