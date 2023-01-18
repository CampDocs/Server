<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     */
    public function __invoke(RegisteredUserRequest $request): Response
    {
        $user = User::create($request->validated());

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
