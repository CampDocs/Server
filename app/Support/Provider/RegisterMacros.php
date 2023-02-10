<?php

namespace App\Support\Provider;

use Illuminate\Support\Str;

class RegisterMacros
{
    /**
     * Configure the macros to be registered.
     */
    public static function handle(): void
    {
        Str::macro('onlyNumbers', function (?string $value): ?string {
            return Str::of($value)->replaceMatches('/[^0-9]/', '');
        });
    }
}
