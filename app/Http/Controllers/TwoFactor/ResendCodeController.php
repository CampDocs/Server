<?php

namespace App\Http\Controllers\TwoFactor;

use App\Actions\TwoFactor\SendLoginCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResendCodeController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $this->authorize('two-factor-resend');

        app(SendLoginCode::class)->handle();

        return $this->ok(trans('two-factor.resent'));
    }
}
