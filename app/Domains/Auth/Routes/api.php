<?php

use App\Domains\Auth\Http\Controllers\EmailVerificationController;
use App\Domains\Auth\Http\Controllers\RegisterController;
use App\Domains\Auth\Http\Controllers\LoginController;
use App\Domains\Auth\Http\Controllers\LogoutController;
use App\Domains\Auth\Http\Controllers\PasswordResetController;
use App\Domains\Auth\Http\Controllers\RefreshTokenController;
use Illuminate\Support\Facades\Route;




Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::middleware('guest')->group(function () {

    Route::post('/password-forgot', [PasswordResetController::class, 'forgot'])
        ->name('password.request');

    Route::post('/password-reset', [PasswordResetController::class, 'reset'])
        ->name('password.reset');
});


Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// Route::post('/auth/refresh-token', [RefreshTokenController::class, 'refresh']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', LogoutController::class);
});

