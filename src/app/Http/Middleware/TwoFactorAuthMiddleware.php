<?php

namespace MHMartinez\TwoFactorAuth\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use MHMartinez\TwoFactorAuth\app\CustomCheckAuthenticator;
use MHMartinez\TwoFactorAuth\app\Interfaces\TwoFactorAuthInterface;
use MHMartinez\TwoFactorAuth\app\Models\TwoFactorAuth;
use MHMartinez\TwoFactorAuth\services\TwoFactorAuthService;

class TwoFactorAuthMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!config(TwoFactorAuthService::CONFIG_KEY . '.enabled')) {
            return $next($request);
        }

        $google2FA = new CustomCheckAuthenticator($request);

        if (Auth::guard(config(TwoFactorAuthService::CONFIG_KEY . '.guard'))->check()) {
            $user = Auth::guard(config(TwoFactorAuthService::CONFIG_KEY . '.guard'))->user();

            if (!$user) {
                return $next($request);
            }

            if ($user instanceof TwoFactorAuthInterface && !$user->shouldValidateWithTwoFactorAuth()) {
                return $next($request);
            }

            if (!app(TwoFactorAuthService::class)->getUserTwoFactorAuthSecret($user)) {
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
