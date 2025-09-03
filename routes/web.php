<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Socialite\ProviderCallbackController;
use App\Http\Controllers\Socialite\ProviderRedirectController;

Route::get('/auth/{provider}/redirect', ProviderRedirectController::class)->name('auth.redirect');
Route::get('/auth/{provider}/callback', ProviderCallbackController::class)->name('auth.callback');

Route::prefix('dashboard')->name('admin.')->group(function () {
    Route::middleware(['auth', 'verified', 'role:superadmin'])->group(function () {
        Route::resource('users', UserController::class)->except('create', 'edit');
    });

    Route::middleware(['auth', 'verified', 'role:superadmin,admin'])->group(function () {
        Route::get('/requestContributor', [UserController::class, 'requestContributor'])->name('requestContributor.index');
        Route::delete('/requestContributor/{requestContributor:id}', [UserController::class, 'destroyRequestContributor'])->name('requestContributor.destroy');
    });

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/photo-profile', [ProfileController::class, 'updatePhoto'])->name('profile.photo-update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});


Route::get('/admin', function () {
    return redirect('/dashboard');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/docs', function () {
    return view('pages.docs');
})->name('docs');

require __DIR__ . '/auth.php';
