<?php

namespace MHMartinez\TwoFactorAuth\app\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use MHMartinez\TwoFactorAuth\listeners\TwoFactorAuthLoginListener;
use MHMartinez\TwoFactorAuth\listeners\TwoFactorAuthLogoutListener;

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