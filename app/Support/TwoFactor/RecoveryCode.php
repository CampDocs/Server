<?php

namespace App\Support\TwoFactor;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class RecoveryCode
{
    /**
     * Generate a new recovery code.
     */
    public static function generate(): string
    {
        return Str::random(10).'-'.Str::random(10);
    }

    /**
     * Generate multiple recovery codes.
     */
    public static function generateMany(): string
    {
        $codes = Collection::times(10, fn () => self::generate())->all();

        return encrypt(json_encode($codes));
    }
}
