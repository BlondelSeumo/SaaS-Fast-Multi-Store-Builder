@if($exception)
@extends('layouts.app')
  @section('title', __('Not Found'))
    @section('content')
    <link rel="stylesheet" href="{{ asset('css/smallPages.css') }}">
    <div class="middle-center">
        <div class="nk-block nk-auth-body wide-md mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="p-5">
                             <img src="{{ url('media/surr-317.png') }}" alt="{{ env('APP_HOME') }}">
                        </div>
                    </div>
                    <div class="col-lg-6 mt-lg-5">
                         <h2 class="bold text-darker mt-5">{{ __('Oops! Why you’re here?') }}</h2>
				         <p class="nk-error-text">{{ __('The page you were looking for has either been deleted or never existed.') }}</p>
	         			<a href="{{ url('/') }}" class="btn btn-lg btn-primary mt-2">{{ __('Back To Home') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@else
    @section('message', __('Not Found'))
@endif