<?php

namespace MHMartinez\TwoFactorAuth\listeners;

use Illuminate\Support\Facades\Cookie;
use MHMartinez\TwoFactorAuth\TwoFactorAuth;

class TwoFactorAuthLogoutListener
{
    public function handle(): void
    {
        Cookie::queue(Cookie::forget(config('two_factor_auth.remember_key')));
    }
}
