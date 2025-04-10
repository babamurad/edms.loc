<div>
    <x-slot name="title">{{ __('Login User') }}</x-slot>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-8 col-lg-10">
                    <div class="card overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6 d-none d-lg-block p-2">
                                <img src="assets/images/doc1.jpg" alt="" class="img-fluid rounded h-100">
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex flex-column h-100">
                                    <div class="auth-brand p-4">
                                        <a href="index.html" class="logo-light">
                                            <img src="assets/images/logo.png" alt="logo" height="22">
                                        </a>
                                        <a href="index.html" class="logo-dark">
                                            <img src="assets/images/logo-dark.png" alt="dark logo" height="22">
                                        </a>
                                    </div>
                                    <div class="p-4 my-auto">
                                        @if (session()->has('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                        @endif
                                        @if (session()->has('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                        @endif
                                        
                                        <a href="{{ route('home') }}">{{ __('to Home') }}</a>
                                        <h4 class="fs-20">{{ __('Sign In') }}</h4>
                                        <p class="text-muted mb-3">{{ __('Enter your email address and password to access account.') }}
                                        </p>                                        
                                        <!-- form -->
                                        <form wire:submit.prevent="login">
                                            <div class="mb-3">
                                                <label for="emailaddress" class="form-label">{{ __('Email address') }}</label>
                                                <input class="form-control @error('email') is-invalid @enderror"
                                                    type="email" id="emailaddress"wire:model="email" placeholder="{{ __('Enter your email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <a href="auth-forgotpw.html" class="text-muted float-end"><small>
                                                    {{ __('Forgot your password?') }}</small></a>
                                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                                
                                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                    id="emailaddress" wire:model="password" placeholder="{{ __('Enter your password') }}">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror    
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="checkbox-signin">
                                                    <label class="form-check-label" for="checkbox-signin">{{ __('Remember me') }}</label>
                                                </div>
                                            </div>
                                            <div class="mb-0 text-start">
                                                <button type="submit" class="btn btn-soft-primary w-100">
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading wire:target="login"></span>
                                                    <i class="ri-login-circle-fill me-1" wire:loading.remove></i> 
                                                    <span class="fw-bold">{{ __('Log In') }}</span> 
                                                </button>
                                            </div>                                            
                                        </form>
                                        <!-- end form-->
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-dark-emphasis">{{ __("Don't have an account?") }} <a href="{{ route('register') }}"
                            class="text-dark fw-bold ms-1 link-offset-3 text-decoration-underline" wire:navigate><b>{{ __('Sign up') }}</b></a>
                    </p>
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
</div>
