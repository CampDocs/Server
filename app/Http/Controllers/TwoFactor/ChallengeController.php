<?php

namespace App\Http\Controllers\TwoFactor;

use App\Actions\TwoFactor\ChallengeTwoFactor;
use App\Http\Controllers\Controller;
use App\Http\Requests\TwoFactor\ChallengeRequest;
use Illuminate\Http\JsonResponse;

class ChallengeController extends Controller
{
    /**
     * Login user with two-factor authentication.
     */
    public function __invoke(ChallengeRequest $request): JsonResponse
    {
        $this->authorize('two-factor-challenge');

        app(ChallengeTwoFactor::class)->handle($request);

        return $this->noContent();
    }
}
