<?php

namespace MHM\TwoFactorAuth\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class TwoFactorAuth
{
    public function handle(Request $request, Closure $next): mixed
    {
        $google2FA = new Authenticator($request);

        if (Auth::guard(config('two_factor_auth.guard'))->check()) {
            $user = Auth::guard(config('two_factor_auth.guard'))->user();
            if (!$user->{config('two_factor_auth.is_enabled')}) {

                return Redirect::route(config('two_factor_auth.view.setup'));
            }
            if (!$google2FA->isAuthenticated()) {
                if (Cookie::has(config('two_factor_auth.remember_key'))) {
                    $google2FA->login();
                } else {
                    return Redirect::route(config('two_factor_auth.view.validate'));
                }
            }
        }

        return $next($request);
    }
}
