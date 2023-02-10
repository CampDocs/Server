<?php

namespace App\Support\TwoFactor;

use App\Enums\TwoFactorEnum;
use Illuminate\Support\Carbon;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthentication
{
    /**
     * The underlying library providing two factor authentication helper services.
     */
    protected Google2FA $engine;

    /**
     * Create a new two factor authentication provider instance.
     */
    public function __construct(Google2FA $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Generate a new secret key.
     */
    public function generateCode(): string
    {
        return mt_rand(100000, 999999);
    }

    /**
     * Generate a new secret key.
     */
    public function generateSecretKey(): string
    {
        return $this->engine->generateSecretKey();
    }

    /**
     * Get the two factor authentication QR code URL.
     */
    public function qrCodeUrl(string $companyName, string $companyEmail, string $secret): string
    {
        return $this->engine->getQRCodeUrl($companyName, $companyEmail, $secret);
    }

    /**
     * Verify the given code.
     */
    public function verify(mixed $user, string $code): bool
    {
        if ($user->two_factor_type->is(TwoFactorEnum::APP)) {
            return $this->verifyApp($user, $code);
        }

        if ($user->two_factor_type->in([TwoFactorEnum::SMS, TwoFactorEnum::EMAIL])) {
            return $this->verifySmsAndEmail($user, $code);
        }

        return false;
    }

    /**
     * Verify the given code for the APP type.
     */
    protected function verifyApp(mixed $user, string $code): bool
    {
        $secret = decrypt($user->two_factor_secret);

        return $this->engine->verifyKey($secret, $code);
    }

    /**
     * Verify the given code for SMS and Email type.
     */
    protected function verifySmsAndEmail(mixed $user, string $code): bool
    {
        if (Carbon::now()->diffInSeconds($user->two_factor_created_at) > 180) {
            return false;
        }

        return decrypt($user->two_factor_secret) === $code;
    }
}
