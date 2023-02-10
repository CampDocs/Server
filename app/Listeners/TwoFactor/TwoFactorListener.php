<?php

namespace App\Listeners\TwoFactor;

use App\Actions\TwoFactor\SendLoginCode;
use Illuminate\Auth\Events\Login;

class TwoFactorListener
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        app(SendLoginCode::class)->handle();
    }
}
