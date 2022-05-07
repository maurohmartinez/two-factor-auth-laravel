<?php

namespace MHMartinez\TwoFactorAuth\Listeners;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use MHMartinez\TwoFactorAuth\Services\TwoFactorAuthService;

class TwoFactorAuthLoginListener
{
    public function handle(): void
    {
        $remember = Request::get('remember', false);
        if ($remember) {
            Session::put(config(TwoFactorAuthService::CONFIG_KEY . '.remember_key'), true);
        }
    }
}
