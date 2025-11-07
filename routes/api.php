<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/password/forgot', [ResetPasswordController::class, 'sendResetLink']);
Route::post('/password/reset', [ResetPasswordController::class, 'resetPassword']);