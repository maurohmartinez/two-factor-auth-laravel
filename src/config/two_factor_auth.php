<?php

return [
    /*
     * Disable this packages in your local environments by adding TWO_FACTOR_AUTH_ENABLED=false in your .env
     */
    'enabled' => env('TWO_FACTOR_AUTH_ENABLED', true),

    /*
     * Set in days when the one-time-password expires
     * 0 means it never expires
     */
    '2fa_expires' => 60,

    /*
     * Name of checkbox input to remember users in your login form
     * This will be used to save a cookie to remember 2FA for that user as well.
     * Check carefully "always_remember_one_time_pass" which will override this value.
     */
    'remember_input_name' => 'remember',

    /*
     * If true, we will ignore the "remember me" input and always remember one time password
     */
    'always_remember_one_time_pass' => false,

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
     * Customize the blade @extends() for the views
     */
    'layout' => 'layouts.app',

    /*
     * Customize the user model
     */
    'user_model' => \App\Models\User::class,
];
