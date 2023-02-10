<?php

namespace App\Http\Controllers\TwoFactor;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    /**
     * Get the QR Code for the user.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->authorize('two-factor-qr-code');

        $svg = $request->user()->twoFactorQrCodeSvg();

        $url = $request->user()->twoFactorQrCodeUrl();

        return $this->ok(data: ['svg' => $svg, 'url' => $url]);
    }
}
