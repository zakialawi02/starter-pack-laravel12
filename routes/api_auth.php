<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;


Route::prefix('auth')->as('api.auth.')->group(function () {
    Route::get('/login', function () {
        return response()->json([
            'success' => false,
            'message' => 'Please Login [POST] /api/auth/login'
        ], 401);
    });
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('register', [RegisterController::class, 'register'])->name('register');
    Route::post('/forgot-password', [AuthController::class, 'passwordResetLink'])->middleware(['throttle:6,1'])->name('password.email');
    Route::get('reset-password/{token}', fn() => [
        'success' => true,
        'message' => 'Please Reset Password [GET] /api/auth/reset-password/{token}'
    ])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'newPassword'])->name('password.store');
    Route::get('/verify-email', function () {
        return response()->json([
            'success' => false,
            'message' => 'Please Verify Email [POST] /api/auth/verify-email'
        ], 401);
    })->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.notice');
    Route::post('/email/verification-notification', [AuthController::class, 'emailVerificationNotification'])->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
    Route::get('/verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.verify');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [LogoutController::class, 'logout'])->name('logout');
    });
});
