<?php

return [
    /*
     * Name of the route where you want to redirect users after successful validation
     */
    'route_after_validation' => 'home',

    /*
     * The key to be used in sessions and cookies
     */
    'remember_key' => 'remember_2fa',

    /*
     * Guard you use in Auth
     */
    'guard' => 'web',

    /*
     * One time password input field name in form
     */
    'otp_input' => 'two_factor_auth_input',

    /*
     * Middleware route name where you want to check if user validated 2FA
     */
    'middleware_route' => 'admin',

    /*
     * Key name for session and cookies
     */
    'user_secret_key' => 'user_secret',

    /*
     * Customize the texts displays in views
     */
    'texts' => [
        'setup_title' => 'Setup Google Authenticator',
        'setup_description' => 'Configure your two-factor authentication by scanning the following code. Alternatively, enter it manually:',
        'validate_title' => 'Validate with Google Authenticator',
        'validate_description' => 'Click the following link to reset your Google Authenticator App:',
        're_setup_btn' => 'Reset',
    ],

    /*
     * Customize the blade @extends() for the views
     */
    'layout' => 'layouts.app',

    /*
     * The message displayed to user when they entered a wrong code
     */
    'error_msg' => 'Invalid code. Please try again.',

    /*
     * Button text displayed to user
     */
    'validate_btn' => 'Validate',

    /*
     * Placeholder displayed to users in main input
     */
    'enter_code_placeholder' => 'Enter code...',
];
