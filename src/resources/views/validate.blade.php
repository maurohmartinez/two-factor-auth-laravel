@extends('layouts.auth')

@section('formCustomFields')
    <p><a class="text-primary" href="{{ route('two_factor_auth.setup') }}">Click here</a> to reset your Google Authenticator App.</p>
@endsection

@section('content')
    @include('two_factor_auth::form', ['formTitle' => 'Validate with Google Authenticator'])
@endsection