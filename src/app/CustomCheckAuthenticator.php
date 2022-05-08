<?php

namespace MHMartinez\TwoFactorAuth\app;

use PragmaRX\Google2FALaravel\Support\Authenticator;

class CustomCheckAuthenticator extends Authenticator
{
    /**
     * We return always true since in our middleware we already checked for this
     */
    public function isActivated(): bool
    {
        return true;
    }
}