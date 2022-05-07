<?php

use Illuminate\Support\Facades\Route;
use MHMartinez\TwoFactorAuth\app\Http\Controllers\TwoFactorAuthController;

Route::group([
    'middleware' => 'web',
    'prefix' => 'two-factor-auth',
], function () {
    Route::get('/', [TwoFactorAuthController::class, 'validateTwoFactorAuth'])->name('two_factor_auth.validate');
    Route::get('setup', [TwoFactorAuthController::class, 'setupTwoFactorAuth'])->name('two_factor_auth.setup');
    Route::post('authenticate', [TwoFactorAuthController::class, 'authenticateTwoFactorAuth'])->name('two_factor_auth.authenticate');
});
