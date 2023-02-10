<?php

use App\Http\Controllers\TwoFactor\AuthenticationController;
use App\Http\Controllers\TwoFactor\ChallengeController;
use App\Http\Controllers\TwoFactor\ConfirmController;
use App\Http\Controllers\TwoFactor\QrCodeController;
use App\Http\Controllers\TwoFactor\RecoveryCodeController;
use App\Http\Controllers\TwoFactor\ResendCodeController;
use App\Http\Controllers\TwoFactor\SecretKeyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Two Factor Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('/two-factor')->group(function () {
    Route::middleware(['two-factor.confirmed', 'throttle:6,1'])->group(function () {
        Route::post('/resend', ResendCodeController::class);

        Route::post('/challenge', ChallengeController::class);
    });

    Route::middleware(['two-factor.required', 'password.confirm'])->group(function () {
        Route::post('/enable', [AuthenticationController::class, 'store']);

        Route::post('/confirm', ConfirmController::class);

        Route::delete('/disable', [AuthenticationController::class, 'destroy']);

        Route::get('/qr-code', QrCodeController::class);

        Route::get('/secret-key', SecretKeyController::class);

        Route::get('/recovery-codes', [RecoveryCodeController::class, 'index']);

        Route::post('/recovery-codes', [RecoveryCodeController::class, 'store']);
    });
});
