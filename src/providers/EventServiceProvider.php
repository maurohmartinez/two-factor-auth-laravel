<?php

namespace MHMartinez\TwoFactorAuth\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use MHMartinez\TwoFactorAuth\Listeners\TwoFactorAuthLoginListener;
use MHMartinez\TwoFactorAuth\Listeners\TwoFactorAuthLogoutListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            TwoFactorAuthLoginListener::class,
        ],
        Logout::class => [
            TwoFactorAuthLogoutListener::class,
        ],
    ];
}