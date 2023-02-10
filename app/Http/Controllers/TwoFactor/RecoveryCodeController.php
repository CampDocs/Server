<?php

namespace App\Http\Controllers\TwoFactor;

use App\Actions\TwoFactor\GenerateRecoveryCodes;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecoveryCodeController extends Controller
{
    /**
     * Get the recovery codes for the user.
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorize('two-factor-recovery');

        $codes = $request->user()->recoveryCodes();

        return $this->ok(data: ['recoveryCodes' => $codes]);
    }

    /**
     * Generate new recovery codes for the user.
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorize('two-factor-recovery');

        app(GenerateRecoveryCodes::class)->handle();

        return $this->ok(trans('two-factor.recovery_codes'));
    }
}
