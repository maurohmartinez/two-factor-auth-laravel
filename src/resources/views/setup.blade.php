@extends(\Illuminate\Support\Facades\Config::get('two_factor_auth.layout'))

@section('twoFactorAuthSetup')
    <p class="text-center">{{ \Illuminate\Support\Facades\Config::get('two_factor_auth.texts.setup_description') }} <strong>{{ $secret }}</strong></p>
    <div class="text-center mb-3">
        @if(\Illuminate\Support\Str::startsWith($QR_Image, 'data:image'))
            <img src="{{ $QR_Image }}" alt="QR">
        @else
            {!! $QR_Image !!}
        @endif
    </div>
@endsection

@section('content')
    @include('two_factor_auth::form', ['formTitle' => \Illuminate\Support\Facades\Config::get('two_factor_auth.texts.setup_title') ])
@endsection