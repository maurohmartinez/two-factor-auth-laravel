<?php

namespace mhm\TwoFactorAuthLaravel\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use JetBrains\PhpStorm\NoReturn;
use mhm\TwoFactorAuthLaravel\Services\TwoFactorAuthService;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FALaravel\Google2FA;
use PragmaRX\Google2FAQRCode\Exceptions\MissingQrCodeServiceException;

class TwoFactorAuthController extends Controller
{
    public function __construct(private Google2FA $google2FA, private TwoFactorAuthService $twoFactorAuth)
    {
    }

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException|MissingQrCodeServiceException
     * @throws InvalidCharactersException|SecretKeyTooShortException
     */
    #[NoReturn] public function setup(): Factory|View|Application
    {
        $userSecret = $this->twoFactorAuth->generateUserSecretKey();
        $QR_Image = $this->twoFactorAuth->generateQR($userSecret);

        return view(config('two_factor_auth.view.setup'), ['QR_Image' => $QR_Image, 'secret' => $userSecret]);
    }

    #[NoReturn] public function validate(): Factory|View|Application
    {
        return view(config('two_factor_auth.view.validate'), ['secret' => $this->twoFactorAuth->getUserSecretKey()]);
    }

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException|SecretKeyTooShortException|InvalidCharactersException
     */
    #[NoReturn] public function authenticate(): RedirectResponse
    {
        $oneTimePass = $this->twoFactorAuth->getOneTimePasswordRequestField();
        $userSecret = $this->twoFactorAuth->getUserSecretKey();

        if (!$oneTimePass || !$userSecret || !$this->google2FA->verifyKey($userSecret, $oneTimePass)) {
            Session::put(config('two_factor_auth.user_secret_key'), $userSecret);

            return Redirect::back()->withErrors(['error' => 'Invalid code, try again.']);
        }

        $this->twoFactorAuth->handleRemember();
        $this->google2FA->login();

        return Redirect::route(config('two_factor_auth.route_after_validated'));

    }
}
