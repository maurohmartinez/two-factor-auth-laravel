<?php

namespace MHMartinez\TwoFactorAuth\app\Listeners;

use MHMartinez\TwoFactorAuth\app\CustomCheckAuthenticator;

class ReLoginUserListener
{
    public function handle($event): void
    {
        $google2FA = new CustomCheckAuthenticator($event->request);
        $google2FA->login();
    }
}
