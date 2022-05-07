<?php

namespace MhMartinez\TwoFactorAuth\Services;

use Illuminate\Foundation\Auth\User;
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
    private ?User $user;

    public function __construct(private Request $request, private Google2FA $google2FA)
    {
    }

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException|SecretKeyTooShortException
     * @throws InvalidCharactersException
     */
    public function generateUserSecretKey(): string
    {
        $this->user = Auth::guard(config('two_auth_factor.guard'))->user();

        if (Session::has(config('two_factor_auth.user_secret_key'))) {
            return Session::get(config('two_factor_auth.user_secret_key'));
        }

        $userSecret = $this->google2FA->generateSecretKey();

        $this->user->update([config('google2fa.otp_secret_column') => $userSecret]);

        return $userSecret;
    }

    /**
     * @throws MissingQrCodeServiceException
     */
    public function generateQR(string $userSecret): string
    {
        return $this->google2FA->getQRCodeInline(
            config('app.name'),
            $this->user->getAttribute('email'),
            $userSecret,
        );
    }

    public function getUserSecretKey(): ?string
    {
        $this->user = Auth::guard(config('two_auth_factor.guard'))->user();

        return $this->user->{config('google2fa.otp_secret_column')} ?? null;
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
        $this->user->update([config('two_factor_auth.is_enabled') => true]);

        if (Session::has(config('two_factor_auth.remember_key'))) {
            Cookie::queue(Cookie::make(config('two_factor_auth.remember_key'), true));
            Session::remove(config('two_factor_auth.remember_key'));
        }

        Session::remove(config('two_factor_auth.user_secret_key'));
    }
}