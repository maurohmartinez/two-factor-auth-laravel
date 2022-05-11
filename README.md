<h1>2FA Auth for Laravel</h1>
<p>A simple 2FA that uses Google Authenticator.</p>

[link-author]: https://inspiredpulse.com

<!-- ABOUT THE PROJECT -->
## About The Project

This project uses the following three packages: 

* [pragmarx/google2fa-qrcode](https://packagist.org/packages/pragmarx/google2fa-qrcode)
* [pragmarx/google2fa-laravel](https://packagist.org/packages/pragmarx/google2fa-laravel)
* [bacon/bacon-qr-code](https://packagist.org/packages/bacon/bacon-qr-code)

You can obviously install those three packages and do it yourself, but this is a quick and easy implementation.

In short, this package requests users to validate their credentials with Google Authenticator right after they logged in.


* If the user never registered 2FA, it displays the setup page to do it.

![screenshot-1](https://raw.githubusercontent.com/maurohmartinez/two-factor-auth-laravel/main/src/storage/sample/screenshot-setup.jpg)

* If the user already did it, it displays the validation form.

![screenshot-2](https://raw.githubusercontent.com/maurohmartinez/two-factor-auth-laravel/main/src/storage/sample/screenshot-validate.jpg)

Also, if you have a "remember" input in your login form, we pick up on that and add a cookie after successful validation. So the next time the user visits the site, we don't ask again for 2FA validation. Once the user logs out, we removed the cookie.

### Installation

1. Use composer to require this project
    ```sh
       composer require maurohmartinez/two-factor-auth-laravel
    ```
2. Run migrations
    ```sh
       php artisan migrate
    ```

3. Publish config, views, and public files and customize them as (and if) you need
    ```sh
       php artisan vendor:publish --provider="MHMartinez\TwoFactorAuth\app\Providers\TwoFactorAuthServiceProvider"
    ```

4. [optional] Adjust middleware group name<br>

    This package automatically applies a middleware to route "admin", but you can adjust that by updating the config file:
    ```php
   'middleware_route' => 'admin'
    ```
   You can also manually add the middleware `MHMartinez\TwoFactorAuth\app\Http\Middleware\TwoFactorAuthMiddleware` where you need it.


5. [optional] If you only want to ask certain users to validate 2FA, your `User` model should implement interface `MHMartinez\TwoFactorAuth\app\Interfaces\TwoFactorAuthInterface`. That will require you to add a new method `shouldValidateWithTwoFactorAuth` which should return a boolean indicating whether the middleware should skip that given user.<br>
    
   Sample of your `User` Model Class:
   ```php
   use MHMartinez\TwoFactorAuth\app\Interfaces\TwoFactorAuthInterface;
   
   class User extends Authenticate implements TwoFactorAuthInterface
    ```
   Sample of method `shouldValidateWithTwoFactorAuth()`:
   ```php
   public function shouldValidateWithTwoFactorAuth(): bool
    {
        // do your logic here
        
        return true; // or false :)
    }
    ```

6. [optional] Disable this package in local environments by adding `TWO_FACTOR_AUTH_ENABLED=false` in your `.env`

7. [optional] Set in days when the one-time-password expires in the config file. FYI, 0 means it never expires `'2fa_expires' => 0,`

<!-- CONTACT -->
## Contact

Project Link: [https://github.com/maurohmartinez/two-factor-auth-laravel](https://github.com/maurohmartinez/two-factor-auth-laravel)