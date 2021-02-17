@extends('layouts.app')
  @section('title', __('Email activation'))
    @section('content')
    <link rel="stylesheet" href="{{ asset('css/smallPages.css') }}">
    <div class="middle-center">
        <div class="nk-block nk-auth-body wide-md mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-5">
                             <img src="{{ url('media/bermuda-message.png') }}" alt="{{ env('APP_HOME') }}">
                        </div>
                    </div>
                    <div class="col-md-6 mt-5">
                         <h2 class="bold text-darker mt-5">{{ __('Email activation needed!') }}</h2>
				         <p class="nk-error-text">{{ __('Kindly check your email for an activation link or resend it') }}</p>
	         			<a href="{{ route('resend-token') }}" class="btn-block btn btn-lg btn-primary mt-2">{{ __('Resend') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop