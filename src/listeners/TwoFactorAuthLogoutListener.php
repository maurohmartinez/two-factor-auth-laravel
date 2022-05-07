<?php

namespace mhm\TwoFactorAuth\Listeners;

use Illuminate\Support\Facades\Cookie;

class TwoFactorAuthLogoutListener
{
    public function handle(): void
    {
        Cookie::queue(Cookie::forget(config('two_factor_auth.remember_key')));
    }
}
