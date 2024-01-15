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
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/home') }}" class="btn btn-orange-red btn-sm btn-block">Home</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-orange-red btn-sm btn-block">Login</a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
