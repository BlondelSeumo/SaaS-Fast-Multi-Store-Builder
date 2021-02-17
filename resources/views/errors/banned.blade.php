@extends('layouts.app')
  @section('title', __('Banned'))
    @section('content')
    <link rel="stylesheet" href="{{ asset('css/smallPages.css') }}">
    <div class="middle-center">
        <div class="nk-block nk-auth-body wide-md mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-5">
                             <img src="{{ url('media/rush.png') }}" alt="{{ env('APP_HOME') }}">
                        </div>
                    </div>
                    <div class="col-md-6 mt-5">
                         <h2 class="bold text-darker mt-5">{{ __('Banned') }}</h2>
				         <p class="nk-error-text">{{ __('You cant view this page because the user is banned') }}</p>
                         @if (!empty($website->email))
                             <p>{{ __('Send an email if this is an error') }}</p>
                            <a href="mailto:{{$website->email}}" class="btn btn-block btn-primary text-white"><em class="icon ni ni-send"></em> <span>{{ __('Email us') }}</span></a>
                         @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop