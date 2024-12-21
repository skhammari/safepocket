<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\SignUpController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Profile/UserProfile');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('signup', [SignUpController::class, 'create'])
        ->name('signup');
        
    Route::post('signup', [SignUpController::class, 'store'])
        ->name('signup.request');
        
    Route::get('signup/verify/{token}', [SignUpController::class, 'verify'])
        ->name('signup.verify');
        
    Route::post('signup/complete', [SignUpController::class, 'complete'])
        ->name('signup.complete');
});

require __DIR__.'/auth.php';
