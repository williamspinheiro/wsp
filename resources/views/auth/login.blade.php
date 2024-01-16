@extends('layouts.login')

@section('content')
    <div class="container">
        <div class="max-w-7xl mx-auto p-2 lg:p-8">
            <div class="flex justify-center">
                <img src="{{ asset('img/logo_grande.png') }}" alt="WSP" width="300">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card bg-transparent">
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
    
                            <div class="row mb-3">
                                <label for="email" class="col-md-12 text-white">{{ __('pt-BR.' . 'Login') }}</label>
    
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="E-mail" autocomplete="email" autofocus>
    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-3">
                                <label for="password" class="col-md-12 text-white">{{ __('pt-BR.' . 'Password') }}</label>
    
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-3">
                                <div class="col-md-12 offset-md-12 text-white">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                        <label class="form-check-label" for="remember">
                                            {{ __('pt-BR.' . 'Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
    
                            <div class="row mb-2">
                                <div class="col-md-12 ">
                                    <button type="submit" class="btn btn-default-color btn-sm btn-block">
                                        {{ __('pt-BR.' . 'Enter') }}
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12 offset-md-12 text-white text-center">
                                @if (Route::has('password.request'))
                                    <a class="text-white" href="{{ route('password.request') }}">
                                        {{ __('pt-BR.' . 'Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection