<?php

namespace App\Providers;

use App\Support\Provider\RegisterMacros;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RegisterMacros::handle();

        $this->registerModelConfig();

        $this->registerPasswordConfig();
    }

    /**
     * Configure the Eloquent Model.
     */
    private function registerModelConfig(): void
    {
        Model::unguard();

        Model::preventLazyLoading(! app()->environment('production'));
    }

    /**
     * Configure the Password Validation Rule.
     */
    private function registerPasswordConfig(): void
    {
        Password::defaults(function () {
            $rules = Password::min(8);

            return app()->environment('production')
                ? $rules->symbols()->numbers()->mixedCase()->uncompromised()
                : $rules;
        });
    }
}
