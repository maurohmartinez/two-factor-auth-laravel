<?php

namespace MHMartinez\TwoFactorAuth\listeners;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use MHMartinez\TwoFactorAuth\services\TwoFactorAuthService;

class TwoFactorAuthLoginListener
{
    public function handle(): void
    {
        $remember = Request::get(config(TwoFactorAuthService::CONFIG_KEY . '.remember_input_name'), false);
        if ($remember) {
            Session::put(config(TwoFactorAuthService::CONFIG_KEY . '.remember_key'), true);
        }
    }
}
