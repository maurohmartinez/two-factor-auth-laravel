<section class="bg-light" style="height: 100vh;">
    <div class="container py-5 h-100">
        <div class="row d-md-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3">
                    <div class="row g-0">
                        <div class="col-12 col-md-6 order-2 order-md-1">
                            <div class="card-body p-md-5 mx-md-4">
                                <div class="text-center">
                                    <h4 class="mt-1 mb-3 pb-1">{{ $formTitle }}</h4>
                                </div>

                                <form role="form"
                                      method="POST"
                                      action="{{ route('two_factor_auth.authenticate') }}">
                                    @csrf

                                    @yield('twoFactorAuthSetup')

                                    <div class="form-outline mb-4">
                                        <input type="text"
                                               name="{{ Config::get('google2fa.otp_input')  }}"
                                               class="form-control @error('error') is-invalid @enderror"
                                               placeholder="Enter code" autofocus="autofocus">
                                        @if($errors->any())
                                            <span class="invalid-feedback text-left">{{$errors->first()}}</span>
                                        @endif
                                    </div>

                                    @yield('twoFactorAuthValidate')

                                    <div class="d-flex align-items-center justify-content-center pb-4">
                                        <button type="button" class="btn btn-primary">Validate</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 order-md-2 d-none d-md-block" style="background-position: center; background-size: cover; background-image: url('{{ asset('vendor/two_factor_auth/google-authenticator.jpg') }}');"></div>
                        <div class="col-12 order-1 d-block d-md-none">
                            <div style="background-position: center; background-size: cover; background-image: url('{{ asset('vendor/two_factor_auth/google-authenticator.jpg') }}');">
                                <div class="d-block d-md-none p-5"></div>
                                <div class="d-block d-md-none p-5"></div>
                                <div class="d-block d-md-none p-5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>