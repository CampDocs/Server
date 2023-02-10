<?php

namespace App\Http\Middleware;

use App\Traits\API\ApiResponse;
use Closure;
use Illuminate\Http\Request;

class CheckTwoFactorConfirmed
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (! $request->user()->hasEnabledTwoFactorAuthentication()) {
            return $this->forbidden(trans('two-factor.required'));
        }

        if (session()->has('two::factor::auth') === true) {
            return $this->found(trans('two-factor.already'));
        }

        return $next($request);
    }
}
