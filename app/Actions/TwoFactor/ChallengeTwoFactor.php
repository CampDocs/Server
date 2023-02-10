<?php

namespace App\Actions\TwoFactor;

use App\Http\Requests\TwoFactor\ChallengeRequest;
use Illuminate\Validation\ValidationException;

class ChallengeTwoFactor
{
    /**
     * Login two factor authentication for the user.
     */
    public function handle(ChallengeRequest $request): void
    {
        if ($code = $request->validRecoveryCode()) {
            $request->user()->replaceRecoveryCode($code);
        } elseif (! $request->hasValidCode()) {
            $this->toResponse($request);
        }

        session()->put('two::factor::auth', true);
    }

    /**
     * Create an HTTP response that represents the object.
     */
    private function toResponse(ChallengeRequest $request): void
    {
        [$key, $message] = $request->filled('recovery_code')
            ? ['recovery_code', trans('two-factor.invalid-recovery-code')]
            : ['code', trans('two-factor.invalid-code')];

        throw ValidationException::withMessages([$key => $message]);
    }
}
