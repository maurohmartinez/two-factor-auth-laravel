@extends(\Illuminate\Support\Facades\Config::get('two_factor_auth.layout'))

@section('twoFactorAuthValidate')
    <p class="text-center">{{ \Illuminate\Support\Facades\Config::get('two_factor_auth.texts.validate_description') }} <a class="text-primary" href="{{ route('two_factor_auth.setup') }}">{{ \Illuminate\Support\Facades\Config::get('two_factor_auth.texts.re_setup_btn') }}</a></p>
@endsection

@section('content')
    @include('two_factor_auth::form', ['formTitle' => \Illuminate\Support\Facades\Config::get('two_factor_auth.texts.validate_title') ])
@endsection