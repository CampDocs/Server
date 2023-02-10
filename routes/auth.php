<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

/*********** Authentication Routes ***********/

Route::prefix('/auth')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::post('/login', [AuthenticatedSessionController::class, 'store']);

        Route::post('/register', RegisteredUserController::class);

        Route::post('/forgot-password', PasswordResetLinkController::class);

        Route::post('/reset-password', NewPasswordController::class);
    });

    Route::middleware(['auth'])->group(function () {
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

        Route::middleware(['throttle:6,1'])->group(function () {
            Route::post('/confirm-password', ConfirmablePasswordController::class);

            Route::get('/verify-email/{uuid}/{hash}', VerifyEmailController::class)->middleware(['signed']);

            Route::post('/email/verification-notification', EmailVerificationNotificationController::class);
        });
    });
});
