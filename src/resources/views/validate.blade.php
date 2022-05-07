@extends('layouts.auth')

@section('formCustomFields')
    <p><a class="text-primary" href="{{ route('google2fa.setup') }}">Click here</a> to reset your Google Authenticator App.</p>
@endsection

@section('content')
    @include('google2fa.form', ['formTitle' => 'Validar con Google Authenticator'])
@endsection