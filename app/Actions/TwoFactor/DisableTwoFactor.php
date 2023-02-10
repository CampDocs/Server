<?php

namespace App\Actions\TwoFactor;

use App\Enums\TwoFactorEnum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DisableTwoFactor
{
    /**
     * The auth user instance.
     */
    private User $user;

    /**
     * Enable two factor authentication for the user.
     */
    public function handle(): void
    {
        $this->user = Auth::user();

        $this->disableTwoFactor();
    }

    /**
     * Disabling user two-factor fields.
     */
    private function disableTwoFactor(): void
    {
        $this->user->forceFill([
            'two_factor_type' => TwoFactorEnum::NONE,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_created_at' => null,
            'two_factor_confirmed_at' => null,
        ])->save();
    }
}
