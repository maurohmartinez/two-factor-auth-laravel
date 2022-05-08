@extends(\Illuminate\Support\Facades\Config::get(\MHMartinez\TwoFactorAuth\services\TwoFactorAuthService::CONFIG_KEY . '.layout'))

@section('twoFactorAuthSetup')
    <p class="text-center">{{ \Illuminate\Support\Facades\Config::get(\MHMartinez\TwoFactorAuth\services\TwoFactorAuthService::CONFIG_KEY . '.texts.setup_description') }} <strong>{{ $secret }}</strong></p>
    <div class="text-center mb-3">
        {!! $QR_Image !!}
    </div>
@endsection

@section('content')
    @include(\MHMartinez\TwoFactorAuth\services\TwoFactorAuthService::CONFIG_KEY . '::form', ['formTitle' => \Illuminate\Support\Facades\Config::get(\MHMartinez\TwoFactorAuth\services\TwoFactorAuthService::CONFIG_KEY . '.texts.setup_title') ])
@endsection