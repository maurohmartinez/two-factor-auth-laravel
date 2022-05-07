<?php

namespace MHMartinez\TwoFactorAuth\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FALaravel\Google2FA;
use PragmaRX\Google2FAQRCode\Exceptions\MissingQrCodeServiceException;

class TwoFactorAuthService
{
    public const CONFIG_KEY = 'two_factor_auth';

    public function __construct(private Request $request, private Google2FA $google2FA)
    {
    }

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException|SecretKeyTooShortException
     * @throws InvalidCharactersException
     */
    public function generateUserSecretKey(): string
    {
        if (Session::has(config(self::CONFIG_KEY . '.user_secret_key'))) {
            return Session::get(config(self::CONFIG_KEY . '.user_secret_key'));
        }

        $userSecret = $this->google2FA->generateSecretKey();
        Auth::guard(config(self::CONFIG_KEY . '.guard'))->user()->update([config('google2fa.otp_secret_column') => $userSecret]);

        return $userSecret;
    }

    /**
     * @throws MissingQrCodeServiceException
     */
    public function generateQR(string $userSecret): string
    {
        return $this->google2FA->getQRCodeInline(
            config('app.name'),
            Auth::guard(config(self::CONFIG_KEY . '.guard'))->user()->getAttribute('email'),
            $userSecret,
        );
    }

    public function getUserSecretKey(): ?string
    {
        return Auth::guard(config(self::CONFIG_KEY . '.guard'))->user()->{config('google2fa.otp_secret_column')} ?? null;
    }

    public function getOneTimePasswordRequestField(): ?string
    {
        $inputKey = config('google2fa.otp_input');

        return $this->request->has($inputKey)
            ? $this->request->get($inputKey)
            : null;
    }

    public function handleRemember(): void
    {
        Auth::guard(config(self::CONFIG_KEY . '.guard'))->user()->update([config(self::CONFIG_KEY . '.is_enabled') => true]);

        if (Session::has(config(self::CONFIG_KEY . '.remember_key'))) {
            Cookie::queue(Cookie::make(config(self::CONFIG_KEY . '.remember_key'), true));
            Session::remove(config(self::CONFIG_KEY . '.remember_key'));
        }

        Session::remove(config(self::CONFIG_KEY . '.user_secret_key'));
    }
}