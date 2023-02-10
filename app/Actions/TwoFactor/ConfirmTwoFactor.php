<?php

namespace App\Actions\TwoFactor;

use App\Models\User;
use App\Support\TwoFactor\TwoFactorAuthentication;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ConfirmTwoFactor
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
     * Enable two factor authentication for the user.
     */
    public function handle(string $code): void
    {
        $this->user = Auth::user();

        if (! $this->provider->verify($this->user, $code)) {
            throw ValidationException::withMessages([
                'code' => trans('two-factor.invalid-code'),
            ]);
        }

        $this->confirmTwoFactor();
    }

    /**
     * Mark the confirmation field and set two-factor validation in the session.
     */
    private function confirmTwoFactor(): void
    {
        $this->user->forceFill(['two_factor_confirmed_at' => Carbon::now()])->save();

        session()->put('two::factor::auth', true);
    }
}
