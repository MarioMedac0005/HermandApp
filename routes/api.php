<?php

use App\Http\Controllers\GestorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Resources\AuthUserResource;
use App\Http\Controllers\Api\BandController;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\Api\FeaturedController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProcessionController;
use App\Http\Controllers\Api\BrotherhoodController;
use App\Http\Controllers\Api\AvailabilityController;

use App\Http\Controllers\Auth\ResetPasswordController;

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
Route::post('/register', [AuthController::class, 'register']);
Route::get('/search', [SearchController::class, 'index']);
Route::get('/featured', [FeaturedController::class, 'index']);

// Rutas públicas de lectura
Route::apiResource('bands', BandController::class)->only(['index', 'show']);
Route::apiResource('brotherhoods', BrotherhoodController::class)->only(['index', 'show']);
Route::apiResource('processions', ProcessionController::class)->only(['index', 'show']);
Route::apiResource('availabilities', AvailabilityController::class)->only(['index', 'show']);

Route::post('/password/forgot', [ResetPasswordController::class, 'sendResetLink']); // Pendiente
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);  // Pendiente

/*
|--------------------------------------------------------------------------
| Rutas para usuarios autenticados
|--------------------------------------------------------------------------
|
| Rutas comunes para cualquier usuario con sesión iniciada.
| Usadas principalmente por el frontend (SPA).
|
*/
Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Usuario autenticado (SPA)
    |--------------------------------------------------------------------------
    |
    | Devuelve la información necesaria para el Navbar y Sidebar:
    |  - avatar (banda / hermandad / admin)
    |  - nombre de usuario
    |  - organización que gestiona
    |  - permisos básicos
    |
    */
    Route::get('/me', function (Request $request) {
        return new AuthUserResource(
            $request->user()->load([
                'band.profileImage',
                'brotherhood.profileImage',
                'roles',
            ])
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    |
    | Cierra la sesión del usuario eliminando todos sus tokens activos.
    |
    */
    Route::post('/logout', [AuthController::class, 'logout']);
});

/*
|--------------------------------------------------------------------------
| Rutas para usuarios autenticados (Gestor / Admin)
|--------------------------------------------------------------------------
|
| Estas rutas requieren autenticación y rol de gestor o admin.
| Permiten crear, editar y eliminar contenido que verá el público.
|
*/
Route::middleware(['auth:sanctum', 'role:gestor|admin'])->group(function () {

    // CRUD completo excepto index/show (ya son públicos)
    Route::apiResource('bands', BandController::class)->except(['index', 'show']);
    Route::apiResource('brotherhoods', BrotherhoodController::class)->except(['index', 'show']);
    Route::apiResource('processions', ProcessionController::class)->except(['index', 'show']);
    Route::apiResource('availabilities', AvailabilityController::class)->except(['index', 'show']);

    Route::apiResource('media', MediaController::class)->parameters([
        'media' => 'media'
    ]);

    Route::apiResource('contracts', ContractController::class);
});

/*
|--------------------------------------------------------------------------
| Rutas para Admin
|--------------------------------------------------------------------------
|
| Solo accesibles para usuarios con rol admin.
| Gestionan usuarios, gestores y estadísticas globales.
|
*/
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::apiResource('users', UserController::class);

    Route::get('/dashboard/count', [DashboardController::class, 'count']);

    Route::apiResource('gestores', GestorController::class)->only(['index', 'store', 'destroy']);
});