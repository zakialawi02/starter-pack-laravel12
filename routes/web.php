<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Socialite\ProviderCallbackController;
use App\Http\Controllers\Socialite\ProviderRedirectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Socialite Authentication Routes
Route::get('/auth/{provider}/redirect', ProviderRedirectController::class)->name('auth.redirect');
Route::get('/auth/{provider}/callback', ProviderCallbackController::class)->name('auth.callback');

if (app()->environment('testing')) {
    Route::middleware(['auth', 'role:superadmin'])
        ->get('/test-superadmin', fn () => response()->noContent())
        ->name('test.superadmin');
}

// Dashboard Routes
Route::prefix('dashboard')->name('admin.')->group(function () {
    // Super Admin Only Routes
    Route::middleware(['auth', 'verified', 'role:superadmin'])->group(function () {
        Route::resource('users', UserController::class)->except('create', 'edit');
    });

    // Super Admin & Admin Routes
    Route::middleware(['auth', 'verified', 'role:superadmin,admin'])->group(function () {
        //
    });

    // Authenticated User Routes
    Route::middleware(['auth', 'verified'])->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/empty', [DashboardController::class, 'empty'])->name('dashboard.empty');
    });

    // Authenticated only
    Route::middleware(['auth'])->group(function () {
        // Profile Management
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/photo-profile', [ProfileController::class, 'updatePhoto'])->name('profile.photo-update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

// Redirect old admin route to dashboard
Route::get('/admin', function () {
    return redirect('/dashboard');
});

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/docs', function () {
    return view('pages.docs');
})->name('docs');


// Authentication Routes
require __DIR__ . '/auth.php';
