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
* If the user already did it, it displays the validation form.

Also, if you have a "remember" input in your login form, we pick up on that and add a cookie after successful validation. So the next time the user visits the site, we don't ask again for 2FA validation. Once the user logs out, we removed the cookie. 

### Installation

1. Use composer to require this project
    ```sh
       composer require mhmartinez/two-factor-authentication-laravel
    ```
2. Run migrations
    ```sh
       php artisan migrate
    ```
3. Add "google2fa_secret" and "google2fa_is_enabled" to `User` fillable Model (or any other name if you edit the config file)
    ```php
   protected $fillable = [..., 'google2fa_secret', 'google2fa_is_enabled'];
    ```

4. Publish config, views, and public files and customize them as you need
    ```sh
       php artisan vendor:publish --provider="MHMartinez\TwoFactorAuth\Providers\TwoFactorAuthServiceProvider"
    ```

5. Add our middleware wherever you need it<br>

    This package automatically applies a middleware to route "admin", but you can adjust that by updating the config file:
    ```php
   'middleware_route' => 'admin'
    ```
   You can also manually add the middleware `MHMartinez\TwoFactorAuth\app\Http\Middleware\TwoFactorAuthMiddleware` where you need it.


7. [Optional] What if you only want to require users of type admins to validate with 2FA?
    In this case, your `User` model should implement interface `MHMartinez\TwoFactorAuth\app\Interfaces\TwoFactorAuthInterface`. That will require you to add a new method `shouldValidateWithTwoFactorAuth` which should return a boolean indicating whether the middleware should or not be used for that user.<br>
    
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

<!-- CONTACT -->
## Contact

Project Link: [https://github.com/maurohmartinez/two-factor-auth-laravel](https://github.com/maurohmartinez/two-factor-auth-laravel)