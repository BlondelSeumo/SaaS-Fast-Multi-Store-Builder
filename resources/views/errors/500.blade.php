@if($exception)
@extends('layouts.app')
  @section('title', __('Server Error'))
    @section('content')
    <link rel="stylesheet" href="{{ asset('css/smallPages.css') }}">
    <div class="middle-center">
        <div class="nk-block nk-auth-body wide-md mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="p-5">
                             <img src="{{ url('media/kingdom-fatal-error.png') }}" alt="{{ env('APP_HOME') }}">
                        </div>
                    </div>
                    <div class="col-lg-6 margin-top">
                         <h2 class="bold text-darker mt-lg-9 mt-5">{{ __('500 | Server error') }}</h2>
                         <p class="nk-error-text">{{ __("You've encountered an error while processing your request. Please try again or send us an email with specifying this error.") }}</p>
                        <a href="mailto:{{ settings('email') }}" class="btn btn-lg btn-primary mt-2">{{ __('Send an email') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@else
    @section('message', __('Not Found'))
@endif