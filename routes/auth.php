<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

/*********** Authentication Routes ***********/

Route::middleware(['guest'])->group(function () {
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

    Route::post('/register', RegisteredUserController::class)->name('register');

    Route::post('/forgot-password', PasswordResetLinkController::class)->name('password.email');

    Route::post('/reset-password', NewPasswordController::class)->name('password.reset');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::middleware(['throttle:6,1'])->group(function () {
        Route::get('/verify-email/{uuid}/{hash}', VerifyEmailController::class)->middleware(['signed'])->name('verification.verify');

        Route::post('/email/verification-notification', EmailVerificationNotificationController::class)->name('verification.send');
    });
});
