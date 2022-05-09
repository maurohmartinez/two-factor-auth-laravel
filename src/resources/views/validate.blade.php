@extends(\Illuminate\Support\Facades\Config::get('two_factor_auth.layout'))

@section('twoFactorAuthValidate')
    <p class="text-center">{{ __('two_factor_auth::form.validate_description') }} <a class="text-primary" href="{{ route('two_factor_auth.setup') }}">{{ __('two_factor_auth::form.re_setup_btn') }}</a></p>
@endsection

@section('content')
    @include('two_factor_auth::form', ['formTitle' => __('two_factor_auth::form.validate_title') ])
@endsection