<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BandController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\Api\FeaturedController;
use App\Http\Controllers\Api\ProcessionController;
use App\Http\Controllers\Api\BrotherhoodController;
use App\Http\Controllers\Api\AvailabilityController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SearchController;

Route::post('/register', [AuthController::class, 'register']); // Ruta para registrarse un usuario. PENDIENTE PARA SABER SI LA USAREMOS
Route::post('/login', [AuthController::class, 'login']); // Ruta para loguearse un usuario que tenga el rol banda o hermanda.

Route::post('/password/forgot', [ResetPasswordController::class, 'sendResetLink']); // Pendiente para saber si la usaremos o no
Route::post('/password/reset', [ResetPasswordController::class, 'resetPassword']); // Pendiente para saber si la usaremos o no
Route::apiResource('bands', BandController::class); // Ruta para los CRUDS
Route::apiResource('brotherhoods', BrotherhoodController::class); // Ruta para los CRUDS
Route::apiresource('processions', ProcessionController::class); // Ruta para los CRUDS
Route::apiresource('availabilities', AvailabilityController::class); // Ruta para los CRUDS

Route::get('/search', [SearchController::class, 'index'])->name('search'); // Ruta publica para poder buscar bandas y hermandades.

// Una vez creado los roles, crear los grupos para los diferentes roles, este es un ejemplo.
// Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']); // El usuario debe estar autenticado previamente.
    Route::apiResource('users', UserController::class); // El usuario debe de estar autenticado y tener el rol admin.
    Route::apiresource('contracts', ContractController::class); // El usuario debe estar autenticado y tener el rol de banda / hermandad.
    Route::get('/dashboard/count', [DashboardController::class, 'count'])->name('count'); // El usuario debe estar autenticado y tener el rol admin.
// });
Route::apiResource('media', MediaController::class)
    ->parameters([
        'media' => 'media'
    ]);

// Endpoint para los perfiles destacados de la Landing Page
Route::get('featured', [FeaturedController::class, 'index']);

Route::get('contracts/{contract}/accept', [ContractController::class, 'accept']);
Route::get('contracts/{contract}/reject', [ContractController::class, 'reject']);
