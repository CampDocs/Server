<?php

namespace App\Actions\TwoFactor;

use App\Enums\TwoFactorEnum;
use App\Models\User;
use App\Support\TwoFactor\RecoveryCode;
use App\Support\TwoFactor\TwoFactorAuthentication;
use Illuminate\Support\Facades\Auth;

class EnableTwoFactor
{
    /**
     * The auth user instance.
     */
    private User $user;

    /**
     * The two factor type.
     */
    private string $type;

    /**
     * The two factor authentication provider.
     */
    private TwoFactorAuthentication $provider;

    /**
     * Create a new action instance.
     */
    public function __construct(TwoFactorAuthentication $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Enable two factor authentication for the user.
     */
    public function handle(string $type): void
    {
        $this->type = $type;

        $this->user = Auth::user();

        if ($this->type === TwoFactorEnum::APP) {
            $this->enableAppType();
        }

        if (in_array($this->type, [TwoFactorEnum::SMS, TwoFactorEnum::EMAIL])) {
            $this->enableSmsAndEmailType();
        }
    }

    /**
     * Enable the APP type.
     */
    private function enableAppType(): void
    {
        $codes = RecoveryCode::generateMany();

        $this->user->forceFill([
            'two_factor_type' => $this->type,
            'two_factor_secret' => encrypt($this->provider->generateSecretKey()),
            'two_factor_recovery_codes' => $codes,
            'two_factor_created_at' => null,
            'two_factor_confirmed_at' => null,
        ])->save();
    }

    /**
     * Enable the SMS or Email type.
     */
    private function enableSmsAndEmailType(): void
    {
        $codes = RecoveryCode::generateMany();

        $this->user->forceFill([
            'two_factor_type' => $this->type,
            'two_factor_recovery_codes' => $codes,
            'two_factor_created_at' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        app(SendLoginCode::class)->handle();
    }
}
