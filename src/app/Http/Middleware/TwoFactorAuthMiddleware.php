<?php

namespace MHMartinez\TwoFactorAuth\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use MHMartinez\TwoFactorAuth\services\TwoFactorAuthService;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class TwoFactorAuthMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        $google2FA = new Authenticator($request);

        if (Auth::guard(config(TwoFactorAuthService::CONFIG_KEY . '.guard'))->check()) {
            $user = Auth::guard(config(TwoFactorAuthService::CONFIG_KEY . '.guard'))->user();
            if (!$user->{config(TwoFactorAuthService::CONFIG_KEY . '.is_enabled')}) {

                return Redirect::route(TwoFactorAuthService::CONFIG_KEY . '.setup');
            }
            if (!$google2FA->isAuthenticated()) {
                if (Cookie::has(config(TwoFactorAuthService::CONFIG_KEY . '.remember_key'))) {
                    $google2FA->login();
                } else {
                    return Redirect::route(TwoFactorAuthService::CONFIG_KEY . '.validate');
                }
            }
        }

        return $next($request);
    }
}
