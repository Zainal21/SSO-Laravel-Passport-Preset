@extends('layouts.app')
 @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                  <a href="{{ route('auth.provider.redirect', ['provider' => 'google']) }}" class="btn btn-danger">Login With Google</a>
                                  <a href="{{ route('auth.provider.redirect', ['provider' => 'github']) }}" class="btn btn-primary">Login With Github</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
