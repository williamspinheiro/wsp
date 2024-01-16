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
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="col-md-12 col-form-label text-md-end text-white">{{ __('pt-BR.' . 'Email Address') }}</label>

                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-default-color btn-sm btn-block">
                                        {{ __('pt-BR.' . 'Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
