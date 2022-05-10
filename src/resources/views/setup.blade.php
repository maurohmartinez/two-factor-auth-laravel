@extends(\Illuminate\Support\Facades\Config::get('two_factor_auth.layout'))

<section class="bg-white">
    <div class="bg-light py-5" style="height: 100vh;">
        <div class="container py-5 h-100">
            <div class="row d-md-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 bg-white">
                        <div class="row g-0">
                            <div class="card-body p-md-5 mx-md-4">
                                <div class="text-center">
                                    <img src="{{ asset('vendor/two_factor_auth/shield.png') }}" alt="Shield" style="max-width: 100px; height: auto;">
                                    <h4 class="mt-1 pb-1">{{ __('two_factor_auth::form.setup_title') }}</h4>
                                </div>
                                <form role="form"
                                      method="POST"
                                      action="{{ route('two_factor_auth.authenticate') }}">
                                    @csrf
                                    <div class="alert alert-warning text-center">
                                        <small class="text-center">{{ __('two_factor_auth::form.warning') }}</small>
                                    </div>
                                    <p class="text-center">{{ __('two_factor_auth::form.description') }} <strong>{{ $secret }}</strong></p>
                                    <div class="text-center mb-3">
                                        {!! $QR_Image !!}
                                    </div>
                                    <div class="mb-4 col-10 col-md-8 col-lg-7 col-xl-6 mx-auto">
                                        <input type="text"
                                               name="{{ \Illuminate\Support\Facades\Config::get('two_factor_auth.otp_input')  }}"
                                               class="form-control @error('error') is-invalid @enderror"
                                               placeholder="{{ __('two_factor_auth::form.enter_code_placeholder') }}" autofocus="autofocus">
                                        @if($errors->any())
                                            <span class="invalid-feedback text-left">{{$errors->first()}}</span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button type="submit" class="btn btn-primary">{{ __('two_factor_auth::form.validate_btn') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>