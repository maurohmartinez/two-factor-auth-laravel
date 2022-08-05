<?php

namespace MHMartinez\TwoFactorAuth\app;

use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use Illuminate\Contracts\Auth\Authenticatable;

class CustomCheckAuthenticator extends Authenticator
{
    /**
     * We return always true since in our middleware we already checked for this
     */
    public function isActivated(): bool
    {
        return true;
    }

    /**
     * We override the getUser method to return the one with the right guard
     */
    protected function getUser(): Authenticatable|null
    {
        return Auth::guard(config('two_factor_auth.guard'))->user();
    }
}