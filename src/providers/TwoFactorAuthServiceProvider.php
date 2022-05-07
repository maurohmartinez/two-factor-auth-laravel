<?php

namespace MHMartinez\TwoFactorAuth\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class TwoFactorAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__ . '/../config/two_factor_auth.php' => config_path('two_factor_auth.php'),
        ]);
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'two_factor_auth');
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/two_factor_auth'),
        ]);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/two_factor_auth.php', 'two_factor_auth'
        );
        $this->app->register(EventServiceProvider::class);
    }
}
