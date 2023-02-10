<?php

namespace App\Http\Controllers\TwoFactor;

use App\Actions\TwoFactor\ConfirmTwoFactor;
use App\Http\Controllers\Controller;
use App\Http\Requests\TwoFactor\ConfirmRequest;
use Illuminate\Http\JsonResponse;

class ConfirmController extends Controller
{
    /**
     * Confirm two-factor authentication for the user.
     */
    public function __invoke(ConfirmRequest $request): JsonResponse
    {
        $this->authorize('two-factor-confirm');

        app(ConfirmTwoFactor::class)->handle($request->code);

        return response()->json(['message' => trans('two-factor.confirmed')]);
    }
}
