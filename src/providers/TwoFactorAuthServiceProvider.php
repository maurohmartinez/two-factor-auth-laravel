<?php

namespace mhm\TwoFactorAuthLaravel\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use mhm\TwoFactorAuthLaravel\Listeners\TwoFactorAuthLoginListener;
use mhm\TwoFactorAuthLaravel\Listeners\TwoFactorAuthLogoutListener;

class TwoFactorAuthServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            TwoFactorAuthLoginListener::class,
        ],
        Logout::class => [
            TwoFactorAuthLogoutListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__ . '/../config/two_factor_auth.php' => config_path('two_factor_auth.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/two_factor_auth.php', 'two_factor_auth'
        );
    }
}
