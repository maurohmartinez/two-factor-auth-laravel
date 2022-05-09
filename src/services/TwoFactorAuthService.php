<?php

namespace MHMartinez\TwoFactorAuth\services;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use MHMartinez\TwoFactorAuth\app\Models\TwoFactorAuth;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FALaravel\Google2FA;
use PragmaRX\Google2FAQRCode\Exceptions\MissingQrCodeServiceException;
use PragmaRX\Google2FAQRCode\QRCode\Bacon;

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
        $this->updateOrCreateUserSecret($userSecret);

        return $userSecret;
    }

    /**
     * @throws MissingQrCodeServiceException
     */
    public function generateQR(string $userSecret): string
    {
        $this->google2FA->setQrcodeService(new Bacon(new SvgImageBackEnd()));

        return $this->google2FA->getQRCodeInline(
            config('app.name'),
            Auth::guard(config(self::CONFIG_KEY . '.guard'))->user()->getAttribute('email'),
            $userSecret,
        );
    }

    public function getUserSecretKey(): ?string
    {
        /** @var TwoFactorAuth $secret */
        $secret = $this->getUserTwoFactorAuthSecret(Auth::guard(config(self::CONFIG_KEY . '.guard'))->user());

        return $secret ? decrypt($secret->secret) : null;
    }

    public function getOneTimePasswordRequestField(): ?string
    {
        $inputKey = config(self::CONFIG_KEY . '.otp_input');

        return $this->request->has($inputKey)
            ? $this->request->get($inputKey)
            : null;
    }

    public function handleRemember(): void
    {
        if (Session::has(config(self::CONFIG_KEY . '.remember_key'))) {
            $days = config(TwoFactorAuthService::CONFIG_KEY . '.2fa_expires');
            $key = config(self::CONFIG_KEY . '.remember_key');
            $minutes = $days === 0 ? null : $days * 60 * 24;

            Cookie::queue(Cookie::make($key, true, $minutes));
            Session::remove(config(self::CONFIG_KEY . '.remember_key'));
        }

        Session::remove(config(self::CONFIG_KEY . '.user_secret_key'));
    }

    public function getUserTwoFactorAuthSecret(Authenticatable $user): Builder|Model|null
    {
        return TwoFactorAuth::query()
            ->where('user_id', $user->id)
            ->first();
    }

    public function updateOrCreateUserSecret(string $userSecret)
    {
        TwoFactorAuth::updateOrCreate(
            ['user_id' => Auth::guard(config(self::CONFIG_KEY . '.guard'))->user()->id],
            ['secret' => $userSecret],
        );
    }
}