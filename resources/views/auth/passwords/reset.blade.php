@extends('layouts.app')
@section('headJS')
  @if (config('app.captcha_status') && config('app.captcha_type') == 'recaptcha')
  {!! htmlScriptTagJsApi() !!}
  @endif
@stop
@section('title', __('Reset password'))
@section('content')
<div class="nk-block nk-block-middle nk-auth-body wide-xs mt-8 mb-5">
   <div class="card card-shadow bdrs-20">
      <div class="card-inner card-inner-lg">
         <div class="nk-block-head">
            <div class="nk-block-head-content">
               <h4 class="nk-block-title">{{ __('Reset password') }}</h4>
               <div class="nk-block-des">
                  <p>{{ __('Use the form below to request for a password reset') }}</p>
               </div>
            </div>
         </div>
       <form method="POST" action="{{ route('resetpassword') }}">
          @csrf
            <div class="form-group">
               <input type="text" class="form-control form-control-lg" placeholder="{{ __('Your email address') }}" name="email" autofocus>
            </div>
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
              <button type="submit" class="btn btn-lg btn-primary btn-block">{{ __('Reset') }}</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
