@extends(\Illuminate\Support\Facades\Config::get('two_factor_auth.layout'))

@section('longDescription')
    <div class="alert alert-warning">
        <small class="text-center">{{ __('two_factor_auth::form.setup_description_1') }}</small>
    </div>
@endsection

@section('twoFactorAuthSetup')
    <p class="text-center">{{ __('two_factor_auth::form.setup_description_2') }} <strong>{{ $secret }}</strong></p>
    <div class="text-center mb-3">
        {!! $QR_Image !!}
    </div>
@endsection

@section('content')
    @include('two_factor_auth::form', ['formTitle' => __('two_factor_auth::form.setup_title') ])
@endsection