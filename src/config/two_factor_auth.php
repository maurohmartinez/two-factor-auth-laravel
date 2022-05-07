<?php

return [
    'enabled' => env('2FA_ENABLED', false),
    'users_table' => env('2FA_USERS_TABLE', 'users'),
    'is_enabled' => env('2FA_USER_COLUMN_IS_ENABLED', 'google2fa_is_enabled'),
    'view' => [
        'setup' => env('2FA_VIEW_SETUP', 'google2fa.setup'),
        'validate' => env('2FA_VIEW_VALIDATE', 'google2fa.validate'),
    ],
    'route_after_validated' => env('2FA_ROUTE_AFTER_VALIDATE', 'backpack'),
    'remember_key' => env('2FA_REMEMBER_KEY', 'remember_2fa'),
    'guard' => env('2FA_GUARD', 'backpack'),
    'user_secret_key' => env('2FA_USER_SECRET_KEY', 'user_secret'),
    'texts' => [
        'setup_title' => 'Setup Google Authenticator',
        'setup_description' => 'Configure your two-factor authentication by scanning the following code. Alternatively, enter it manually:',
        'validate_title' => 'Validate with Google Authenticator',
        'validate_description' => 'Click the following link to reset your Google Authenticator App:',
        're_setup_btn' => 'Reset',
    ],
    'layout' => 'layouts.plain',
];
