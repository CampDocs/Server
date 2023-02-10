<?php

namespace App\Actions\TwoFactor;

use App\Models\User;
use App\Support\TwoFactor\RecoveryCode;
use Illuminate\Support\Facades\Auth;

class GenerateRecoveryCodes
{
    /**
     * The auth user instance.
     */
    private User $user;

    /**
     * Generate new recovery codes for the user.
     */
    public function handle(): void
    {
        $this->user = Auth::user();

        $this->generateRecoveryCodes();
    }

    /**
     * Generate new recovery codes for the user.
     */
    private function generateRecoveryCodes(): void
    {
        $codes = RecoveryCode::generateMany();

        $this->user->forceFill(['two_factor_recovery_codes' => $codes])->save();
    }
}
