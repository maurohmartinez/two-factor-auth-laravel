<?php

use Illuminate\Support\Facades\Route;
use MhMartinez\TwoFactorAuth\app\Http\Controllers\TwoFactorAuthController;

Route::get('google2fa/setup', [TwoFactorAuthController::class, 'setup'])->name('google2fa.setup');
Route::get('google2fa', [TwoFactorAuthController::class, 'validate'])->name('google2fa.validate');
Route::post('google2fa/authenticate', [TwoFactorAuthController::class, 'authenticate'])->name('google2fa.authenticate');
