<?php

namespace MHMartinez\TwoFactorAuth\Listeners;

use Illuminate\Support\Facades\Cookie;
use MHMartinez\TwoFactorAuth\Services\TwoFactorAuthService;

class TwoFactorAuthLogoutListener
{
    public function handle(): void
    {
        Cookie::queue(Cookie::forget(config(TwoFactorAuthService::CONFIG_KEY . '.remember_key')));
    }
}
