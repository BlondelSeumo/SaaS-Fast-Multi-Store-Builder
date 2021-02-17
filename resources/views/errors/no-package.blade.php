@extends('layouts.app')
  @section('title', __('No package'))
    @section('content')
    <link rel="stylesheet" href="{{ asset('css/smallPages.css') }}">
    <div class="middle-center">
        <div class="nk-block nk-auth-body wide-md mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-5">
                             <img src="{{ url('media/bermuda-no-comments.png') }}" alt="{{ env('APP_HOME') }}">
                        </div>
                    </div>
                    <div class="col-md-6 mt-5em">
                         <h2 class="bold text-darker mt-5">{{ __('No package') }}</h2>
				         <p class="nk-error-text">{{ __('This package has either been deleted or out of stock') }}</p>
                        <a href="{{ route('pricing') }}" class="btn btn-block btn-outline-dark"><em class="icon ni ni-package"></em> <span>{{ __('Check other package') }}</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop