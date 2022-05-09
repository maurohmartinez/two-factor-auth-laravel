<?php

namespace MHMartinez\TwoFactorAuth\app\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use MHMartinez\TwoFactorAuth\app\Http\Middleware\TwoFactorAuthMiddleware;

class TwoFactorAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        // Routes
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // Config
        $this->publishes([
            __DIR__ . '/../../config/two_factor_auth.php' => config_path('two_factor_auth.php'),
        ], 'config');

        // Views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'two_factor_auth');
        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/two_factor_auth'),
        ], 'views');

        // Public - assets
        $this->publishes([
            __DIR__ . '/../../public' => public_path('vendor/two_factor_auth'),
        ], 'public');

        // Middleware
        $router = $this->app->make(Router::class);
        $router->pushMiddlewareToGroup(config('two_factor_auth.middleware_route'), TwoFactorAuthMiddleware::class);

        // Translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'two_factor_auth');
        $this->publishes([
            __DIR__ . '/../../resources/lang' => $this->app->langPath('vendor/two_factor_auth'),
        ]);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/two_factor_auth.php', 'two_factor_auth'
        );

        $this->app->register(EventServiceProvider::class);
    }
}
