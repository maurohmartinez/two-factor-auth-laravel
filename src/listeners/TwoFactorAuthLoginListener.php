<?php

namespace MhMartinez\TwoFactorAuth\Listeners;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class TwoFactorAuthLoginListener
{
    public function handle(): void
    {
        $remember = Request::get('remember', false);
        if ($remember) {
            Session::put(config('two_factor_auth.remember_key'), true);
        }
    }
}
