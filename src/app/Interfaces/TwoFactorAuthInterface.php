<?php

namespace MHMartinez\TwoFactorAuth\app\Interfaces;

interface TwoFactorAuthInterface
{
    /**
     * You should add and edit this method as you need to require or not 2FA validation
     * base on your logic.
     */
    public function shouldValidateWithTwoFactorAuth(): bool;
}