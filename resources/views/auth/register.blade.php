@extends('layouts.app')
@section('headJS')
  @if (config('app.captcha_status') && config('app.captcha_type') == 'recaptcha')
  {!! htmlScriptTagJsApi() !!}
  @endif
@stop
@section('title', __('Register'))
@section('content')
<div class="container mt-9">
        <div class="nk-block nk-block-middle card card-shadow p-4 nk-auth-body">
            <div class="brand-logo pb-5">
                <a href="html/general/index.html" class="logo-link">
                    <img class="logo-img logo-img-lg" src="{{ url('media/logo/logo.png') }}" alt="logo">
                </a>
            </div>
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h5 class="nk-block-title">{{ __('Sign-Up') }}</h5>
                    <div class="nk-block-des">
                        <p>{{ __('Sign up to our platform!') }}</p>
                    </div>
                </div>
            </div><!-- .nk-block-head -->
         <form method="POST" action="{{ route('register') }}">
            @csrf
              <div class="row mb-4">
                <div class="col">
                  <div class="form-group custom">
                       <input class="form-control form-control-lg @error('first_name') is-invalid @enderror" type="text" placeholder="{{ __('First Name') }}" name="first_name" value="{{ old('first_name') }}" autocomplete="first_name" autofocus/>
                     @error('first_name')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                  </div>
                </div>
                <div class="col">
                  <div class="form-group custom">
                       <input class="form-control form-control-lg @error('last_name') is-invalid @enderror" type="text" placeholder="{{ __('Last Name') }}" name="last_name" value="{{ old('last_name') }}" autocomplete="last_name" autofocus/>
                     @error('last_name')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group custom mt-3">
                       <input id="username_email" class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" placeholder="{{ __('Email') }}" name="email" value="{{ !empty(old('email')) ? old('email') : request()->get('email') }}" autocomplete="email"/>
                     @error('email')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                  </div>
                </div>
              </div>
              <div class="form-group custom">
                   <input id="username" class="form-control form-control-lg @error('username') is-invalid @enderror" type="text" placeholder="{{ __('Username') }}" name="username" value="{{ old('username') }}" autocomplete="username"/>
                 @error('username')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                 @enderror
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group custom">
                      <input id="password" class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" placeholder="{{ __('Password') }}" name="password" value="{{ old('password') }}" />
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>
                <div class="col">
                  <div class="form-group custom">
                      <input id="password-confirm" type="password" placeholder="{{ __('Confirm Password') }}" name="password_confirmation" autocomplete="new-password" class="form-control form-control-lg" />
                  </div>

                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
              </div>
              @if (!empty($website->privacy) || !empty($website->terms))
              <div class="col-12 p-0 mb-2 mt-3">
                <div class="form-group">
                  <div class="custom-control custom-control-xs custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkbox" required="">
                      <label class="custom-control-label" for="checkbox">{{ __('I agree to ') }}<b>{{env("APP_HOME") }}</b> {!! clean((!empty($website->privacy) ? '<a href="' . url($website->privacy) . '">'.__('Privacy Policy').'</a>' : "") . (!empty($website->privacy) && !empty($website->terms) ? ' &amp; ' : "") .(!empty($website->terms) ? '<a href="' . url($website->terms) . '">'.__('Terms').'</a>' : ""), 'titles') . ' ' . __('of this site') !!}
                    </label>
                  </div>
                </div>
              </div>
              @endif
              @if (config('app.captcha_status') && config('app.captcha_type') == 'recaptcha')
               {!! htmlFormSnippet() !!}
               @endif
               @if (config('app.captcha_status') && config('app.captcha_type') == 'default')
               <div class="row mt-3 mb-4">
                 <div class="col-md-6 mb-4 mb-md-0">
                   <div class="bdrs-20 p-2 text-center card-shadow">
                       {!! captcha_img() !!}
                   </div>
                 </div>
                 <div class="col-md-6">
                   <div class="form-group">
                       <input type="text" class="form-control form-control-lg @error('captcha') is-invalid @enderror" placeholder="{{ __('Captcha') }}" name="captcha">
                   </div>
                 </div>
               </div>
               @endif
              <div class="form-group">
                <button type="submit" class="btn btn-lg btn-primary btn-block mt-3">{{ __('Register') }}</button>
              </div>
           </form>
         <div class="form-note-s2 text-center pt-4">{{ __('Have an account?') }} <a href="{{ route('login') }}">{{ __('Login') }}</a>
         </div>
        </div><!-- .nk-block -->
</div>
@endsection
