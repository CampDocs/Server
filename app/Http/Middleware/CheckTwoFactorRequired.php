<?php

namespace App\Http\Middleware;

use App\Traits\API\ApiResponse;
use Closure;
use Illuminate\Http\Request;

class CheckTwoFactorRequired
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->user()->hasEnabledTwoFactorAuthentication() && session()->has('two::factor::auth') === false) {
            return $this->found(trans('two-factor.redirect'));
        }

        return $next($request);
    }
}
