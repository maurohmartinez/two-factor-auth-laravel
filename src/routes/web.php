<?php

use Illuminate\Support\Facades\Route;
use MHMartinez\TwoFactorAuth\app\Http\Controllers\TwoFactorAuthController;

Route::group([
    'middleware' => 'web',
    'prefix' => 'two-factor-auth',
], function () {
    Route::get('', [TwoFactorAuthController::class, 'showSetupEmailLink'])->name('two_factor_auth.show_setup_email');
    Route::post('send', [TwoFactorAuthController::class, 'sendSetupEmail'])
        ->name('two_factor_auth.send_setup_email')
        ->middleware('throttle:1,5');
    Route::get('setup/{token}', [TwoFactorAuthController::class, 'setupWithQr'])->name('two_factor_auth.setup');
    Route::get('validate', [TwoFactorAuthController::class, 'validateTokenWithForm'])->name('two_factor_auth.validate');
    Route::post('authenticate', [TwoFactorAuthController::class, 'authenticatePost'])->name('two_factor_auth.authenticate');
});
