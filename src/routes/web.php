<?php

use Illuminate\Support\Facades\Route;
use MHM\TwoFactorAuthenticationLaravel\Controllers\TwoFactorAuthenticationController;

Route::get('google2fa/setup', [TwoFactorAuthenticationController::class, 'setup'])->name('google2fa.setup');
Route::get('google2fa', [TwoFactorAuthenticationController::class, 'validate'])->name('google2fa.validate');
Route::post('google2fa/authenticate', [TwoFactorAuthenticationController::class, 'authenticate'])->name('google2fa.authenticate');
