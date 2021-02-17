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
                      <h4 class="bold text-darker">{{ __('Database Details') }}</h4>
                       <form method="POST" action="{{ route('InstallDatabase') }}">
                          @csrf
                          <div class="row">
                              <div class="col">
                                <div class="form-group mb-5">
                                   <div class="form-label-group"><label class="form-label">{{ __('Database Host') }}</label></div>
                                   <input type="text" class="form-control form-control-lg" placeholder="{{ __('Enter Database Hostname') }}" required="" name="DB_HOST" value="{{ env('DB_HOST', 'localhost') }}" autocomplete="off">
                                </div>
                              </div>
                              <div class="col">
                                <div class="form-group mb-5">
                                   <div class="form-label-group"><label class="form-label">{{ __('Database Port') }}</label></div>
                                   <input type="text" class="form-control form-control-lg" name="DB_PORT" placeholder="{{ __('Enter Database Port') }}" required="" value="{{ env('DB_PORT', '3306') }}" autocomplete="off">
                                </div>
                              </div>
                          </div>
                            <div class="form-group">
                               <div class="form-label-group"><label class="form-label">{{ __('Database Name') }}</label></div>
                               <input type="text" class="form-control form-control-lg" name="DB_DATABASE" placeholder="{{ __('Enter Database Name') }}" required="" value="{{ env('DB_DATABASE', '') }}" autocomplete="off">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group mt-1">
                                       <div class="form-label-group"><label class="form-label">{{ __('Database Username') }}</label></div>
                                       <input type="text" class="form-control form-control-lg" name="DB_USERNAME" placeholder="{{ __('Enter Database Name') }}" value="{{ env('DB_USERNAME', '') }}" required="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mt-1">
                                       <div class="form-label-group"><label class="form-label">{{ __('Database Password') }}</label></div>
                                       <input type="text" class="form-control form-control-lg" name="DB_PASSWORD" placeholder="{{ __('Enter Database Password') }}" value="{{ env('DB_PASSWORD', '') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-4">
                              <button type="submit" class="btn btn-lg btn-primary btn-block">{{ __('Create tables') }}</button>
                            </div>
                         </form>
                        @if(!$errors->isEmpty())
                        <div class="alert alert-icon alert-danger mt-4 alert-fill" role="alert">
                            <em class="icon ni ni-alert-circle"></em> 
                            @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
