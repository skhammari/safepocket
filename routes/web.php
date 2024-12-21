<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\UserVerificationController;

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
    Route::get('/user-level', [UserVerificationController::class, 'showUserLevel'])
        ->name('user.level');
    Route::post('/verification/phone', [UserVerificationController::class, 'updatePhoneNumber'])
        ->name('verification.phone');
    Route::post('/verification/address', [UserVerificationController::class, 'updateAddress'])
        ->name('verification.address');
    Route::post('/verification/id-documents', [UserVerificationController::class, 'uploadIdDocuments'])
        ->name('verification.id-documents');
    Route::post('/verification/selfie', [UserVerificationController::class, 'uploadSelfie'])
        ->name('verification.selfie');
    Route::get('/verification/status', [UserVerificationController::class, 'getVerificationStatus'])
        ->name('verification.status');
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
