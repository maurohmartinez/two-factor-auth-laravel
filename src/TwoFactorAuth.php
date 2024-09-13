<?php

namespace MHMartinez\TwoFactorAuth;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use MHMartinez\TwoFactorAuth\app\Models\TwoFactorAuth as TwoFactorAuthModel;
use MHMartinez\TwoFactorAuth\app\Notifications\ResetTwoFactorAuth;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FALaravel\Google2FA;
use PragmaRX\Google2FAQRCode\Exceptions\MissingQrCodeServiceException;
use PragmaRX\Google2FAQRCode\QRCode\Bacon;

class TwoFactorAuth
{
    /**
     * @throws IncompatibleWithGoogleAuthenticatorException|SecretKeyTooShortException
     * @throws InvalidCharactersException
     */
    public function generateUserSecretKey(): string
    {
        if (Session::has(config('two_factor_auth.user_secret_key'))) {
            return Session::get(config('two_factor_auth.user_secret_key'));
        }

        $userSecret = app(Google2FA::class)->generateSecretKey();
        $this->updateOrCreateUserSecret($userSecret);

        return $userSecret;
    }

    /**
     * @throws MissingQrCodeServiceException
     */
    public function generateQR(string $userSecret): string
    {
        $google2FA = app(Google2FA::class);
        $google2FA->setQrcodeService(new Bacon(new SvgImageBackEnd()));

        return $google2FA->getQRCodeInline(
            config('app.name'),
            Auth::guard(config('two_factor_auth.guard'))->user()->getAttribute('email'),
            $userSecret,
            200,
        );
    }

    public function getUserSecretKey(): ?string
    {
        /** @var TwoFactorAuthModel $secret */
        $secret = $this->getUserTwoFactorAuthSecret(Auth::guard(config('two_factor_auth.guard'))->user());

        return $secret?->secret;
    }

    public function getOneTimePasswordRequestField(): ?string
    {
        $inputKey = config('two_factor_auth.otp_input');

        return Request::has($inputKey)
            ? Request::get($inputKey)
            : null;
    }

    public function handleRemember(): void
    {
        if (Session::has(config('two_factor_auth.remember_key'))) {
            $days = config('two_factor_auth.2fa_expires');
            $key = config('two_factor_auth.remember_key');
            $minutes = $days === 0 ? null : $days * 60 * 24;

            Cookie::queue(Cookie::make($key, true, $minutes));
            Session::remove(config('two_factor_auth.remember_key'));
        }

        Session::remove(config('two_factor_auth.user_secret_key'));
    }

    public function sendSetupEmail(Authenticatable $user): bool
    {
        try {
            $token = $this->getUserTwoFactorAuthSecret($user)?->getRawOriginal('secret') ?? $this->generateUserSecretKey();
            $notification = new ResetTwoFactorAuth($token);
            $user->notify($notification);
        } catch (Exception $e) {
            Log::error($e);

            return false;
        }

        return true;
    }

    public function getUserTwoFactorAuthSecret(?Authenticatable $user): Builder|Model|null
    {
        return !$user
            ? null
            : TwoFactorAuthModel::query()
                ->where('user_id', $user->id)
                ->first();
    }

    public function updateOrCreateUserSecret(string $userSecret): void
    {
        TwoFactorAuthModel::updateOrCreate(
            ['user_id' => Auth::guard(config('two_factor_auth.guard'))->user()->id],
            ['secret' => $userSecret],
        );
    }
}
