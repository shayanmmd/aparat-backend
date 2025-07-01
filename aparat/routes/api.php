<?php

use App\Http\Controllers\Channel\ChannelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Playlist\PlaylistController;
use App\Http\Controllers\Tag\TagController;
use App\Http\Controllers\Video\VideoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/change-email', [UserController::class, 'changeEmail']);
    Route::post('/verify-change-email', [UserController::class, 'verifyChangeEmail']);
    Route::match(['put', 'post'], '/change-password', [UserController::class, 'changePassword']);

    Route::prefix('/channel')->group(function () {
        Route::put('/update', [ChannelController::class, 'update']);
        Route::post('/upload-banner', [ChannelController::class, 'uploadBanner']);
    });

    Route::prefix('/video')->group(function(){
        Route::post('/',[VideoController::class,'create']);
        Route::get('/',[VideoController::class,'list']);
        Route::post('/upload',[VideoController::class,'upload']);
        Route::put('/change-state',[VideoController::class,'changeState']);
        Route::post('/republish',[VideoController::class,'republish']);
    });

    Route::prefix('/playlist')->group(function(){
        Route::post('/',[PlaylistController::class,'create']);
        Route::get('/',[PlaylistController::class,'all']);
    });

    Route::prefix('/tag')->group(function(){
        Route::post('/',[TagController::class,'create']);
        Route::get('/',[TagController::class,'all']);
    });
});

Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('/verify-register', [App\Http\Controllers\Auth\AuthController::class, 'verifyRegister']);
