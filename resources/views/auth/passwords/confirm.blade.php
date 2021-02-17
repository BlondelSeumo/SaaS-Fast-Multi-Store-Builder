@extends('layouts.app')
@section('title', __('Reset Password'))
@section('content')
<div class="nk-block nk-block-middle nk-auth-body wide-xs mt-8 mb-5">
   <div class="card form-card">
      <div class="card-inner card-inner-lg">
         <div class="nk-block-head">
            <div class="nk-block-head-content">
               <h4 class="nk-block-title">{{ __('Reset Password') }}</h4>
               <div class="nk-block-des">
                  <p>{{ __('Use the form below to reset your password') }}</p>
               </div>
            </div>
         </div>
       <form method="POST" action="{{ route('reset.password') }}">
          @csrf
          <input type="hidden" value="{{$token}}" name="token">
            <div class="form-group">
               <input type="text" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="{{ __('enter your new password') }}" name="password" value="{{ old('username') }}" autocomplete="user" autofocus>
               @error('password')
               <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
               @enderror
            </div>
            <div class="form-group">
               <input type="text" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" placeholder="{{ __('confirm your password') }}" name="password_confirmation">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-lg btn-primary btn-block">{{ __('Change password') }}</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
