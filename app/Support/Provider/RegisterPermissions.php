<?php

namespace App\Support\Provider;

use App\Enums\TwoFactorEnum;
use Illuminate\Support\Facades\Gate;

class RegisterPermissions
{
    /**
     * Configure the permissions to be registered.
     */
    public static function handle(): void
    {
        Gate::define('two-factor-challenge', function ($user) {
            return $user->two_factor_type->isNot(TwoFactorEnum::NONE)
                && ! is_null($user->two_factor_secret)
                && ! is_null($user->two_factor_recovery_codes)
                && ! is_null($user->two_factor_confirmed_at);
        });

        Gate::define('two-factor-confirm', function ($user) {
            return $user->two_factor_type->isNot(TwoFactorEnum::NONE)
                && ! is_null($user->two_factor_secret)
                && is_null($user->two_factor_confirmed_at);
        });

        Gate::define('two-factor-disable', function ($user) {
            return $user->two_factor_type->isNot(TwoFactorEnum::NONE)
                && ! is_null($user->two_factor_secret)
                && ! is_null($user->two_factor_confirmed_at);
        });

        Gate::define('two-factor-enable', function ($user) {
            return is_null($user->two_factor_confirmed_at);
        });

        Gate::define('two-factor-qr-code', function ($user) {
            return $user->two_factor_type->is(TwoFactorEnum::APP)
                && ! is_null($user->two_factor_secret)
                && ! is_null($user->two_factor_recovery_codes);
        });

        Gate::define('two-factor-recovery', function ($user) {
            return $user->two_factor_type->isNot(TwoFactorEnum::NONE)
                && ! is_null($user->two_factor_secret)
                && ! is_null($user->two_factor_recovery_codes);
        });

        Gate::define('two-factor-resend', function ($user) {
            return $user->two_factor_type->in([TwoFactorEnum::SMS, TwoFactorEnum::EMAIL])
                && ! is_null($user->two_factor_secret)
                && ! is_null($user->two_factor_confirmed_at);
        });

        Gate::define('two-factor-secret-key', function ($user) {
            return $user->two_factor_type->is(TwoFactorEnum::APP)
                && ! is_null($user->two_factor_secret)
                && ! is_null($user->two_factor_recovery_codes);
        });
    }
}
