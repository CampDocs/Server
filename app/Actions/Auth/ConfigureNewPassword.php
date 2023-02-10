<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\NewPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ConfigureNewPassword
{
    public function handle(User $user, NewPasswordRequest $request): void
    {
        $user->forceFill([
            'password' => $request->password,
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));
    }
}
