<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/docs', function () {
    return view('pages.docs');
})->name('docs');

Route::prefix('dashboard')->name('admin.')->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::resource('users', UserController::class)->except('create', 'edit');
    });

    Route::middleware(['auth', 'verified', 'role:superadmin,admin'])->group(function () {
        // Route::get
    });


    Route::middleware(['auth', 'verified', 'role:superadmin,admin,user'])->group(function () {
        Route::get('/', function () {
            return view('pages.dashboard.dashboard');
        })->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/photo-profile', [ProfileController::class, 'updatePhoto'])->name('profile.photo-update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

Route::middleware(['auth', 'verified', 'role:superadmin,admin'])->group(function () {
    // Route::get
});


require __DIR__ . '/auth.php';
