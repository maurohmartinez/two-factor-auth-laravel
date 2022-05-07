@extends(\Illuminate\Support\Facades\Config::get(\MHMartinez\TwoFactorAuth\services\TwoFactorAuthService::CONFIG_KEY . '.layout'))

@section('twoFactorAuthValidate')
    <p class="text-center">{{ \Illuminate\Support\Facades\Config::get(\MHMartinez\TwoFactorAuth\services\TwoFactorAuthService::CONFIG_KEY . '.texts.validate_description') }} <a class="text-primary" href="{{ route(\MHMartinez\TwoFactorAuth\services\TwoFactorAuthService::CONFIG_KEY . '.setup') }}">{{ \Illuminate\Support\Facades\Config::get(\MHMartinez\TwoFactorAuth\services\TwoFactorAuthService::CONFIG_KEY . '.texts.re_setup_btn') }}</a></p>
@endsection

@section('content')
    @include(\MHMartinez\TwoFactorAuth\services\TwoFactorAuthService::CONFIG_KEY . '::form', ['formTitle' => \Illuminate\Support\Facades\Config::get(\MHMartinez\TwoFactorAuth\services\TwoFactorAuthService::CONFIG_KEY . '.texts.validate_title') ])
@endsection