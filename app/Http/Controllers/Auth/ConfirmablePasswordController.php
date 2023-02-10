<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ConfirmPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class ConfirmablePasswordController extends Controller
{
    /**
     * Confirm the user's password.
     */
    public function __invoke(ConfirmPasswordRequest $request): JsonResponse
    {
        $request->session()->put('auth.password_confirmed_at', Carbon::now()->timestamp);

        return $this->noContent();
    }
}
