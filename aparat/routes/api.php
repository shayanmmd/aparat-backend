<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/login', [App\Http\Controllers\Auth\AuthController::class , 'login']);

Route::get('/hi', function(){
    return 'hi';
});
