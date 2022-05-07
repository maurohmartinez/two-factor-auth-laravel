<?php

namespace MHMartinez\TwoFactorAuth\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use MHMartinez\TwoFactorAuth\app\Http\Middleware\TwoFactorAuthMiddleware;
use MHMartinez\TwoFactorAuth\Services\TwoFactorAuthService;

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
        ], 'views');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'two_factor_auth');
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/two_factor_auth'),
        ], 'config');
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/two_factor_auth'),
        ], 'public');
        $router = $this->app->make(Router::class);
        $router->pushMiddlewareToGroup(config(TwoFactorAuthService::CONFIG_KEY . '.middleware_route'), TwoFactorAuthMiddleware::class);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/two_factor_auth.php', 'two_factor_auth'
        );
        $this->app->register(EventServiceProvider::class);
    }
}
