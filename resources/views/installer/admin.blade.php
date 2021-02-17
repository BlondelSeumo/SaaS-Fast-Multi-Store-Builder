@extends('installer.layout')
@section('title', __('Install'))
@section('content')
    <link rel="stylesheet" href="{{ asset('css/smallPages.css') }}">
    <div class="middle-center">
        <div class="nk-block nk-auth-body wide-xs mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <img class="logo-img logo-img-lg mb-3 p-0 ml-0" src="{{ url('img/logo/logo.png') }}" alt="{{ config('app.name') }}">
                      <h4 class="bold text-darker">{{ __('Admin Details') }}</h4>
                       <form method="POST" action="{{ route('InstallAdmin') }}">
                          @csrf
                            <div class="row mb-4">
                              <div class="col">
                                <div class="form-group">
                                     <input id="name" class="form-control form-control-lg @error('name') is-invalid @enderror" type="text" placeholder="{{ __('Name') }}" name="name" value="{{ old('name') }}" autocomplete="name" autofocus/>
                                   @error('name')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                   @enderror
                                </div>
                              </div>
                              <div class="col">
                                <div class="form-group">
                                     <input id="username_email" class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" placeholder="{{ __('Email') }}" name="email" value="{{ old('email') }}" autocomplete="email"/>
                                   @error('email')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                   @enderror
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                                 <input id="username" class="form-control form-control-lg @error('username') is-invalid @enderror" type="text" placeholder="{{ __('Username') }}" name="username" value="{{ old('username') }}" autocomplete="username"/>
                               @error('username')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                               @enderror
                            </div>
                            <div class="row">
                              <div class="col">
                                <div class="form-group">
                                    <input id="password" class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" placeholder="{{ __('Password') }}" name="password" value="{{ old('password') }}" />
                                  @error('password')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                                </div>
                              </div>
                              <div class="col">
                                <div class="form-group">
                                    <input id="password-confirm" type="password" placeholder="{{ __('Confirm Password') }}" name="password_confirmation" autocomplete="new-password" class="form-control form-control-lg" />
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                            </div>
                            <div class="form-group">
                              <button type="submit" class="btn btn-lg btn-primary mt-4 btn-block">{{ __('Create') }}</button>
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
