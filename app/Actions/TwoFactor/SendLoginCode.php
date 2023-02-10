<?php

namespace App\Actions\TwoFactor;

use App\Enums\TwoFactorEnum;
use App\Models\User;
use App\Support\TwoFactor\TwoFactorAuthentication;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SendLoginCode
{
    /**
     * The auth user instance.
     */
    private User $user;

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
     * Resend the login code.
     */
    public function handle(): void
    {
        $this->user = Auth::user();

        if ($this->user->two_factor_type?->is(TwoFactorEnum::SMS)) {
            $this->enableSmsType();
        }

        if ($this->user->two_factor_type?->is(TwoFactorEnum::EMAIL)) {
            $this->enableEmailType();
        }
    }

    /**
     * Update the two-factor code that will be sent to the user.
     */
    private function updateUserCode(): void
    {
        $this->user->forceFill([
            'two_factor_secret' => encrypt($this->provider->generateCode()),
            'two_factor_created_at' => Carbon::now(),
        ])->save();
    }

    /**
     * Update the code and send the SMS notification to the user.
     */
    private function enableSmsType(): void
    {
        $this->updateUserCode();

        $this->user->sendSmsCodeNotification();
    }

    /**
     * Update the code and send the Email notification to the user.
     */
    private function enableEmailType(): void
    {
        $this->updateUserCode();

        $this->user->sendEmailCodeNotification();
    }
}
