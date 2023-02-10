<?php

namespace App\Http\Requests\TwoFactor;

use App\Rules\RecoveryCodeRule;
use App\Support\TwoFactor\TwoFactorAuthentication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ChallengeRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    public function prepareForValidation(): void
    {
        $this->merge(['code' => Str::onlyNumbers($this->code)]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'code' => [
                'nullable',
                'string',
                'size:6',
            ],
            'recovery_code' => [
                'nullable',
                'string',
                'size:21',
                new RecoveryCodeRule(),
            ],
        ];
    }

    /**
     * Determine if the request has a valid two factor code.
     */
    public function hasValidCode(): bool
    {
        return $this->code && app(TwoFactorAuthentication::class)->verify($this->user(), $this->code);
    }

    /**
     * Get the valid recovery code if one exists on the request.
     */
    public function validRecoveryCode(): string|null
    {
        if (! $this->recovery_code) {
            return null;
        }

        return collect($this->user()->recoveryCodes())->first(
            fn ($code) => hash_equals($code, $this->recovery_code) ? $code : null
        );
    }
}
