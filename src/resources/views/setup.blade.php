@extends('layouts.auth')

@section('formCustomFields')
    <p>Configure your two-factor authentication by scanning the following code. Alternatively, enter it manually: <strong>{{ $secret }}</strong></p>
    {!! $QR_Image !!}
@endsection

@section('content')
    @include('google2fa.form', ['formTitle' => 'Iniciar Google Authenticator'])
@endsection