@extends(\Illuminate\Support\Facades\Config::get('two_factor_auth.layout'))

<section class="bg-light" style="height: 100vh;">
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
                            @if($emailSent)
                                <div class="alert alert-success text-center">
                                    <p class="mb-0">{{ __('two_factor_auth::messages.setup_email_sent') }}</p>
                                </div>
                            @else
                                <div class="alert alert-danger text-center">
                                    <p class="mb-0">{{ __('two_factor_auth::messages.error_email_not_sent') }}</p>
                                </div>
                            @endif
                            @if(__('two_factor_auth::form.warning'))
                                <hr>
                                <div class="alert alert-warning text-center">
                                    <small class="text-center">{{ __('two_factor_auth::form.warning') }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
