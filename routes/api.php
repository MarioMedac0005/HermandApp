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

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
|
| Estas rutas son visibles para todos los usuarios. No se requiere login.
| Permiten ver información de bandas, hermandades, procesiones y demás.
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::get('/search', [SearchController::class, 'index']);
Route::get('featured', [FeaturedController::class, 'index']);

// Rutas públicas de lectura
Route::apiResource('bands', BandController::class)->only(['index', 'show']);
Route::apiResource('brotherhoods', BrotherhoodController::class)->only(['index', 'show']);
Route::apiResource('processions', ProcessionController::class)->only(['index', 'show']);
Route::apiResource('availabilities', AvailabilityController::class)->only(['index', 'show']);

/* Route::post('/password/forgot', [ResetPasswordController::class, 'sendResetLink']); // Pendiente para saber si la usaremos o no
Route::post('/password/reset', [ResetPasswordController::class, 'resetPassword']); // Pendiente para saber si la usaremos o no */
    
/*
|--------------------------------------------------------------------------
| Rutas para usuarios autenticados (Gestor)
|--------------------------------------------------------------------------
|
| Estas rutas requieren autenticación y rol de gestor.
| Permiten crear, editar y eliminar contenido que verá el público.
|
*/
Route::middleware(['auth:sanctum', 'role:gestor'])->group(function () {

    // CRUD completo excepto index/show (ya son públicos)
    Route::apiResource('bands', BandController::class)->except(['index', 'show']);
    Route::apiResource('brotherhoods', BrotherhoodController::class)->except(['index', 'show']);
    Route::apiResource('processions', ProcessionController::class)->except(['index', 'show']);
    Route::apiResource('availabilities', AvailabilityController::class)->except(['index', 'show']);

    Route::apiResource('media', MediaController::class)->parameters([
        'media' => 'media'
    ]);
    
    Route::apiresource('contracts', ContractController::class);
});

/*
|--------------------------------------------------------------------------
| Rutas para usuarios autenticados 
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

/*
|--------------------------------------------------------------------------
| Rutas para Admin
|--------------------------------------------------------------------------
|
| Solo accesibles para usuarios con rol admin.
| Gestionan usuarios, roles y estadísticas.
|
*/
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::get('/dashboard/count', [DashboardController::class, 'count']);
    Route::post('/gestor', [AuthController::class, 'addGestor']);
});
