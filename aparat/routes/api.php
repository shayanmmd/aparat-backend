<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/change-email', [UserController::class, 'changeEmail']);
    Route::post('/verify-change-email', [UserController::class, 'verifyChangeEmail']);
});

Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('/verify-register', [App\Http\Controllers\Auth\AuthController::class, 'verifyRegister']);
