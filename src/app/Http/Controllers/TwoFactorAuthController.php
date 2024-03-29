<?php

namespace MHMartinez\TwoFactorAuth\app\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use \MHMartinez\TwoFactorAuth\app\Models\TwoFactorAuth as ModelTwoFactorAuth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use MHMartinez\TwoFactorAuth\TwoFactorAuth;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FALaravel\Google2FA;

class TwoFactorAuthController extends Controller
{
    public function __construct(private readonly Google2FA $google2FA, private readonly TwoFactorAuth $twoFactorAuth)
    {
    }

    public function sendSetupEmail(): View
    {
        $user = Auth::guard(config('two_factor_auth.guard'))->user();
        $emailSent = $this->twoFactorAuth->sendSetupEmail($user);

        return view('two_factor_auth::send_setup_email', ['emailSent' => $emailSent]);
    }

    public function setupWithQr(string $token): View|RedirectResponse
    {
        // Users can only set a 2FA from a link sent by email
        $tokenSecret = ModelTwoFactorAuth::query()
            ->where('secret', $token)
            ->first();

        // If no token or user found, the token probably expired, abort!
        if (!$tokenSecret || !$tokenSecret->user) {
            abort(404);
        }

        // Login in the user
        Auth::guard(config('two_factor_auth.guard'))->login($tokenSecret->user);

        // Get token and build qr
        $userSecretToken = $tokenSecret->secret;
        $qr = $this->twoFactorAuth->generateQR($userSecretToken);

        return view('two_factor_auth::setup', ['qr' => $qr, 'secret' => $userSecretToken]);
    }

    public function validateTokenWithForm(): View|RedirectResponse
    {
        if (!$this->isUserLogged()) {
            return Redirect::to(url('/'));
        }

        // If the user doesn't have any device setup, redirect
        $user = Auth::guard(config('two_factor_auth.guard'))->user();
        $token = app(TwoFactorAuth::class)->getUserTwoFactorAuthSecret($user);
        if (!$token) {
            return Redirect::route('two_factor_auth.validate')->with('', '');
        }

        return view('two_factor_auth::validate', ['secret' => $this->twoFactorAuth->getUserSecretKey()]);
    }

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException|SecretKeyTooShortException|InvalidCharactersException
     */
    public function authenticatePost(): RedirectResponse
    {
        if (!Auth::guard(config('two_factor_auth.guard'))->user()) {
            return Redirect::to(url('/'));
        }

        $oneTimePass = $this->twoFactorAuth->getOneTimePasswordRequestField();
        $userSecret = $this->twoFactorAuth->getUserSecretKey();

        if (!$oneTimePass || !$userSecret || !$this->google2FA->verifyKey($userSecret, $oneTimePass)) {
            Session::put(config('two_factor_auth.user_secret_key'), $userSecret);

            return Redirect::back()->withErrors(['error' => __('two_factor_auth::messages.error_msg')]);
        }

        $this->twoFactorAuth->updateOrCreateUserSecret($userSecret);
        $this->twoFactorAuth->handleRemember();
        $this->google2FA->login();

        return Redirect::route(config('two_factor_auth.route_after_validation'));

    }

    private function isUserLogged(): bool
    {
        return Auth::guard(config('two_factor_auth.guard'))->check();
    }
}
