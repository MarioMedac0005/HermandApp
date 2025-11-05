<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BandController;
use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\Api\ProcessionController;
use App\Http\Controllers\Api\BrotherhoodController;
use App\Http\Controllers\Api\AvailabilityController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('bands', BandController::class);
Route::apiResource('brotherhoods', BrotherhoodController::class);
Route::apiresource('contracts', ContractController::class);
Route::apiresource('processions', ProcessionController::class);
Route::apiresource('availabilities', AvailabilityController::class);





