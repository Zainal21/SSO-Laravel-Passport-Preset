@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Single Sign On OAUTH 2.0 Server') }}</div>

                <div class="card-body">
                    {{ __('This apps running in port 8000!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
