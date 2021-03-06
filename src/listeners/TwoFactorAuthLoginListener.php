<?php

namespace MHMartinez\TwoFactorAuth\listeners;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class TwoFactorAuthLoginListener
{
    public function handle(): void
    {
        $remember = Request::get(config('two_factor_auth.remember_input_name'), false);

        if ($remember || config('two_factor_auth.always_remember_one_time_pass')) {
            Session::put(config('two_factor_auth.remember_key'), true);
        }
    }
}
