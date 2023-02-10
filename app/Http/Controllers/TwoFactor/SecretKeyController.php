<?php

namespace App\Http\Controllers\TwoFactor;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SecretKeyController extends Controller
{
    /**
     * Get the secret key for the user.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->authorize('two-factor-secret-key');

        $secret = decrypt($request->user()->two_factor_secret);

        return $this->ok(data: ['secretKey' => $secret]);
    }
}
