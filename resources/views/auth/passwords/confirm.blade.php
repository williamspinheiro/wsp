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
                        <div class="col-md-12 text-white text-center">
                            {{ __('pt-BR.' .'Please confirm your password before continuing.') }}
                        </div>
                        
    
                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf
    
                            <div class="row mb-3">
                                <label for="password" class="col-md-12 col-form-label text-md-end text-white">{{ __('pt-BR.' .'Password') }}</label>
    
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-2">
                                <div class="col-md-12 ">
                                    <button type="submit" class="btn btn-default-color btn-sm btn-block">
                                        {{ __('pt-BR.' .'Confirm Password') }}
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12 offset-md-12 text-white text-center">
                                @if (Route::has('password.request'))
                                    <a class="text-white" href="{{ route('password.request') }}">
                                        {{ __('pt-BR.' .'Forgot Your Password?') }}
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