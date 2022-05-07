<?php

namespace MHMartinez\TwoFactorAuth\listeners;

use Illuminate\Support\Facades\Cookie;
use MHMartinez\TwoFactorAuth\services\TwoFactorAuthService;

class TwoFactorAuthLogoutListener
{
    public function handle(): void
    {
        Cookie::queue(Cookie::forget(config(TwoFactorAuthService::CONFIG_KEY . '.remember_key')));
    }
}
