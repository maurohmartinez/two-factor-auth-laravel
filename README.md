<h1>2FA Auth for Laravel</h1>
<p>A simple 2FA that uses Google Authenticator.</p>

[link-author]: https://inspiredpulse.com

<!-- ABOUT THE PROJECT -->
## About The Project

This project uses the following two dependencies: 

* [pragmarx/google2fa-qrcode](https://packagist.org/packages/pragmarx/google2fa-qrcode)
* [pragmarx/google2fa-laravel](https://packagist.org/packages/pragmarx/google2fa-laravel)
* [bacon/bacon-qr-code](https://packagist.org/packages/bacon/bacon-qr-code)

You can obviously install those 2 packages and do it yourself, but this is a quick and easy implementation of those two repositories.

Behind the scenes, this package requests users to validate their session with Google Authenticator right after they logged in.
* If the user never register 2FA on his phone, we display the setup page to do it.
* If the user already did it, we display the validation form.

Also, if you have a "remember" input in your login form, we pick up on that and add a cookie after successful validation. So the next time the user visits the site, we don't ask again validation. Once the user logs out, we removed the cookie. 

### Installation

This section should list any major frameworks/libraries used to bootstrap your project. Leave any add-ons/plugins for the acknowledgements section. Here are a few examples.

1. Use composer to require this project
```sh
   composer require mhmartinez/two-factor-authentication-laravel
```
2. Run migrations
```sh
   php artisan migrate
```
3. Publish config file if you want to customize the texts
```sh
   php artisan vendor:publish --provider="MHMartinez\TwoFactorAuth\Providers\TwoFactorAuthServiceProvider" --tag="config"
```
4. Publish views if you want to adjust them or use your own
```sh
   php artisan vendor:publish --provider="MHMartinez\TwoFactorAuth\Providers\TwoFactorAuthServiceProvider" --tag="views"
```
4. Publish public file to be able to display the image used in views (unless you created your own views)
```sh
   php artisan vendor:publish --provider="MHMartinez\TwoFactorAuth\Providers\TwoFactorAuthServiceProvider" --tag="public"
```
5. Add our middleware wherever you need it<br>

This package automatically applies a middleware to route "admin", but you can adjust that by updating the config file:
```php
   'middleware_route' => 'admin'
```
You can also add the middleware `MHMartinez\TwoFactorAuth\app\Http\Middleware\TwoFactorAuthMiddleware` where you need it.

<!-- CONTACT -->
## Contact

Project Link: [https://github.com/maurohmartinez/two-factor-auth-laravel](https://github.com/maurohmartinez/two-factor-auth-laravel)