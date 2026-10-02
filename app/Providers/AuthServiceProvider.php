<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\Auth;
use App\Auth\RobustTokenGuard;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Auth::extend('token', function ($app, $name, array $config) {
            return new RobustTokenGuard(
                Auth::createUserProvider($config['provider'] ?? null),
                $app['request'],
                $config['input_key'] ?? 'api_token',
                $config['storage_key'] ?? 'api_token',
                $config['hash'] ?? true
            );
        });
    }
}
