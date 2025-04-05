<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->as('api.')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('users', App\Http\Controllers\Api\UserController::class);
        Route::get('/user', [App\Http\Controllers\Api\UserController::class, 'me'])->name('user.me');
        Route::patch('/user', [App\Http\Controllers\Api\UserController::class, 'updateMyProfile'])->name('user.me');
        Route::patch('/user/photo', [App\Http\Controllers\Api\UserController::class, 'updateMyPhotoProfile'])->name('user.photo');
        Route::delete('/user/destroy/me', [App\Http\Controllers\Api\UserController::class, 'destroyMyAccount'])->name('user.destroy.me');
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        //
    });
});


// Auth routes for API
require __DIR__ . '/api_auth.php';
