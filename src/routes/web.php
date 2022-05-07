<?php

use Illuminate\Support\Facades\Route;
use MHMartinez\TwoFactorAuth\app\Http\Controllers\TwoFactorAuthController;

Route::get('google2fa/setup', [TwoFactorAuthController::class, 'setupTwoFactorAuth'])->name('google2fa.setup');
Route::get('google2fa', [TwoFactorAuthController::class, 'validateTwoFactorAuth'])->name('google2fa.validate');
Route::post('google2fa/authenticate', [TwoFactorAuthController::class, 'authenticateTwoFactorAuth'])->name('google2fa.authenticate');
