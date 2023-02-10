<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class RecoveryCodeRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        $value = Str::mask($value, '*', 11);

        $value = Str::mask($value, '*', 0, 10);

        return $value === '**********-**********';
    }

    public function message(): string
    {
        return trans('two-factor.invalid-recovery-code');
    }
}
