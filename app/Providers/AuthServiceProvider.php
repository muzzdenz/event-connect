<?php

namespace App\Providers;

use App\Auth\RemoteSessionGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Auth::extend('remote-session', function ($app, $name, array $config) {
            return new RemoteSessionGuard(
                $name,
                $app['session.store'],
                $app['request']
            );
        });
    }
}



