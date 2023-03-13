@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('SSO Client') }}</div>

                    <div class="card-body">
                        <a href="{{ route('login.sso') }}" class="btn btn-danger">Login With SSO</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
