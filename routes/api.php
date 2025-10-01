<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModelClientController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route pour l'authentification des clients
Route::post('/login', [ModelClientController::class, 'login'])->name('clients.login');
Route::post('/register', [ModelClientController::class, 'register'])->name('clients.register');
Route::apiResource('clients', ModelClientController::class);
