<section class="bg-light" style="height: 100vh;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
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
                        <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                            <img src="{{  }}" alt="QR">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>