@extends('installer.layout')
@section('title', __('Install'))
@section('content')
    <link rel="stylesheet" href="{{ asset('css/smallPages.css') }}">
    <div class="middle-center">
        <div class="nk-block nk-auth-body wide-xs mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <img class="logo-img logo-img-lg mb-3 p-0 ml-0" src="{{ url('media/logo/logo.png') }}" alt="{{ config('app.name') }}">
                        <h4 class="bold text-darker">{{ __('Ecom Installation wizard') }}</h4>
                        <p>
                           {{ __('This installer will guide you through various installation process and will need you to create Database from your control panel. It will ask for various details which you will get from your control panel after creating Database.') }}
                        </p>
                        <a href="{{ request()->fullUrlWithQuery(['steps' => 'requirements']) }}" class="btn btn-block btn-primary">{{ __('Proceed') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
