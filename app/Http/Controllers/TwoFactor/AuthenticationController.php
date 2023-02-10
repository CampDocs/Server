<?php

namespace App\Http\Controllers\TwoFactor;

use App\Actions\TwoFactor\DisableTwoFactor;
use App\Actions\TwoFactor\EnableTwoFactor;
use App\Http\Controllers\Controller;
use App\Http\Requests\TwoFactor\EnableRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    /**
     * Enable two-factor authentication for the user.
     */
    public function store(EnableRequest $request): JsonResponse
    {
        $this->authorize('two-factor-enable');

        app(EnableTwoFactor::class)->handle($request->type);

        return $this->ok(trans('two-factor.enabled'));
    }

    /**
     * Disable two-factor authentication for the user.
     */
    public function destroy(Request $request): JsonResponse
    {
        $this->authorize('two-factor-disable');

        app(DisableTwoFactor::class)->handle();

        return $this->ok(trans('two-factor.disabled'));
    }
}
