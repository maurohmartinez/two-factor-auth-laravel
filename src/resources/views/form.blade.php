<div class="container-fluid pt-5 px-3 px-md-1 px-md-5 px-lg-1 col-xl-4 col-lg-7 col-md-10 col-12">
    <div class="auth-card card mb-0 border-0 px-4 py-5">
        <div class="text-center">
            <h4 class="mt-3">{{ $formTitle }}</h4>
        </div>
        <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('google2fa.authenticate') }}">
            @csrf
            <div class="text-center">
                @yield('formCustomFields')
                <input type="text" name="{{ \Illuminate\Support\Facades\Config::get('google2fa.otp_input')  }}" class="form-control mt-3 @error('error') is-invalid @enderror" placeholder="Enter code" autocomplete="false" autofocus>
                @if($errors->any())
                    <span class="invalid-feedback text-left">{{$errors->first()}}</span>
                @endif
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary text-center loading-login-btn">
                        <span class="spinner-border spinner-border-sm mr-2 loading-login" style="display: none;"></span>
                        <span class="loading-login-hide">Confirmar</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>