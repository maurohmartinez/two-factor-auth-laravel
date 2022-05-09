<?php

namespace MHMartinez\TwoFactorAuth\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use MHMartinez\TwoFactorAuth\app\CustomCheckAuthenticator;
use MHMartinez\TwoFactorAuth\app\Interfaces\TwoFactorAuthInterface;
use MHMartinez\TwoFactorAuth\TwoFactorAuth;

class TwoFactorAuthMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!config('two_factor_auth.enabled')) {
            return $next($request);
        }

        $google2FA = new CustomCheckAuthenticator($request);

        if (Auth::guard(config('two_factor_auth.guard'))->check()) {
            $user = Auth::guard(config('two_factor_auth.guard'))->user();

            if (!$user) {
                return $next($request);
            }

            if ($user instanceof TwoFactorAuthInterface && !$user->shouldValidateWithTwoFactorAuth()) {
                return $next($request);
            }

            if (!app(TwoFactorAuth::class)->getUserTwoFactorAuthSecret($user)) {
                return Redirect::route('two_factor_auth.setup');
            }

            if (!$google2FA->isAuthenticated()) {
                if (Cookie::has(config('two_factor_auth.remember_key'))) {
                    $google2FA->login();
                } else {
                    return Redirect::route('two_factor_auth.validate');
                }
            }
        }

        return $next($request);
    }
}
