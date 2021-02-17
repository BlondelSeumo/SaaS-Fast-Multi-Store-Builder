@extends('admin.layouts.app')

@section('title', __('Settings'))
@section('content')
<div class="nk-block-head mb-4">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('Settings') }}</h2>
        </div>
    </div>
</div>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#home"><em class="icon ni ni-home"></em> <span>{{ __('Home') }}</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#user"><em class="icon ni ni-account-setting-alt"></em> <span>{{ __('User') }}</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#ads"><em class="icon ni ni-money"></em> <span>{{ __('Ads') }}</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#social"><em class="icon ni ni-viber"></em> <span>{{ __('Social') }}</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#custom-js-css"><em class="icon ni ni-js"></em> <span>{{ __('Custom JS / CSS') }}</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#emailsnotify"><em class="icon ni ni-bell"></em> <span>{{ __('Email') }}</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#captcha"><em class="icon ni ni-policy"></em> <span>{{ __('Captcha') }}</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#social_logins"><em class="icon ni ni-google"></em> <span>{{ __('Social logins') }}</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#payment"><em class="icon ni ni-wallet"></em> <span>{{ __('Payment') }}</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#business"><em class="icon ni ni-briefcase"></em> <span>{{ __('Business') }}</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#site"><em class="icon ni ni-layout2"></em> <span>{{ __('Site') }}</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#smtp"><em class="icon ni ni-emails"></em> <span>{{ __('SMTP') }}</span></a>
    </li>
</ul>
<form action="{{ route('post.settings') }}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="tab-content settings-card">
        <div class="tab-pane" id="business">
          <h5>{{ __('Business Details') }}</h5>
          <p>{{ __('These details will be used when generating invoices for the user payments') }}</p>
          <div class="form-group mt-5">
             <label class="form-label"><span>{{ __('Invoicing System') }}</span></label>
             <div class="form-control-wrap">
                <select class="form-select" data-search="off" data-ui="lg" name="business_enabled">
                   <option value="1" {{ (settings('business.enabled') == 1) ? 'selected' : '' }}> {{ __('Yes') }} </option>
                   <option value="0" {{ (settings('business.enabled') == 0) ? 'selected' : '' }}> {{ __('No') }} </option>
               </select>
             </div>
          </div>
          <div class="row">
             <div class="col-6">
                 <div class="form-group">
                     <label class="form-label">{{ __('Name') }}</label>
                     <input type="text" name="business_name" class="form-control form-control-lg" value="{{settings('business.name')}}">
                 </div>

                 <div class="form-group">
                     <label class="form-label">{{ __('Email') }}</label>
                     <input type="text" name="business_email" class="form-control form-control-lg" value="{{settings('business.email')}}">
                 </div>

                 <div class="form-group">
                     <label class="form-label">{{ __('Phone') }}</label>
                     <input type="text" name="business_phone" class="form-control form-control-lg" value="{{settings('business.phone')}}">
                 </div>

                 <div class="form-group">
                     <label class="form-label">{{ __('Tax Type') }}</label>
                     <input type="text" name="business_tax_type" class="form-control form-control-lg" value="{{settings('business.tax_type')}}" placeholder="ex: VAT">
                 </div>

                 <div class="form-group">
                     <label class="form-label">{{ __('Tax ID') }}</label>
                     <input type="text" name="business_tax_id" class="form-control form-control-lg" value="{{settings('business.tax_id')}}">
                 </div>

                 <div class="form-group">
                     <label class="form-label">{{ __('Custom Field Key') }}</label>
                     <input type="text" name="business_custom_key_one" class="form-control form-control-lg" value="{{settings('business.custom_key_one')}}">
                 </div>

                 <div class="form-group">
                     <label class="form-label">{{ __('Custom Field Key') }}</label>
                     <input type="text" name="business_custom_key_two" class="form-control form-control-lg" value="{{settings('business.custom_key_two')}}">
                 </div>
             </div>

             <div class="col-6">
                 <div class="form-group">
                     <label class="form-label">{{ __('Address') }}</label>
                     <input type="text" name="business_address" class="form-control form-control-lg" value="{{settings('business.address')}}">
                 </div>

                 <div class="form-group">
                     <label class="form-label">{{ __('City') }}</label>
                     <input type="text" name="business_city" class="form-control form-control-lg" value="{{settings('business.city')}}">
                 </div>

                 <div class="form-group">
                     <label class="form-label">{{ __('County') }}</label>
                     <input type="text" name="business_county" class="form-control form-control-lg" value="{{settings('business.county')}}">
                 </div>

                 <div class="form-group">
                     <label class="form-label">{{ __('ZIP') }}</label>
                     <input type="number" name="business_zip" class="form-control form-control-lg" value="{{settings('business.zip')}}">
                 </div>

                 <div class="form-group">
                     <label class="form-label">{{ __('Country') }}</label>
                     <input type="text" name="business_country" class="form-control form-control-lg" value="{{settings('business.country')}}">
                 </div>

                 <div class="form-group">
                     <label class="form-label">{{ __('Custom Field Value') }}</label>
                     <input type="text" name="business_custom_value_one" class="form-control form-control-lg" value="{{settings('business.custom_value_one')}}">
                 </div>

                 <div class="form-group">
                     <label class="form-label">{{ __('Custom Field Value') }}</label>
                     <input type="text" name="business_custom_value_two" class="form-control form-control-lg" value="{{settings('business.custom_value_two')}}">
                 </div>
             </div>
         </div>
        </div>
		    <div class="tab-pane active" id="home">
		    	<div class="row">
		    		<div class="col-md-6">
				    	<div class="form-group mt-5 mt-lg-2">
						    <label class="form-label"><em class="icon ni ni-italic"></em> <span>{{ __('Website title') }}</span></label>
						    <div class="form-control-wrap">
						        <input type="text" class="form-control form-control-lg" placeholder="{{ __('Enter site name') }}" value="{{ env('APP_NAME') }}" name="title">
						    </div>
						 </div>
		    		</div>
            <div class="col-md-6">
              <div class="form-group mt-5 mt-lg-2">
                 <label class="form-label"><span> {{ __('Locale') }}</span></label>
                 <div class="form-control-wrap">
                    <select class="form-select" data-search="on" data-ui="lg" name="locale">
                       @foreach ($alltransfiles as $value)
                          @php
                            $file = pathinfo($value);
                          @endphp
                          <option value="{{ strtolower($file['filename']) }}" {{config('app.locale') == strtolower($file['filename']) ? 'selected' : ''}}> {{ ucfirst($file['filename']) }} </option>
                       @endforeach
                   </select>
                 </div>
              </div>
            </div>
		    		<div class="col-md-6">
				    	<div class="form-group mt-4">
						    <label class="form-label"><em class="icon ni ni-mail"></em> <span>{{ __('Site Email') }}</span></label>
						    <div class="form-control-wrap">
						        <input type="email" class="form-control form-control-lg" placeholder="{{ __('your email') }}" value="{{ settings('email') }}" name="email">
						    </div>
						</div>
		    		</div>
            <div class="col-md-6">
              <div class="form-group mt-5">
                <div class="custom-control custom-switch">
                  <input type="hidden" name="scheme" value="http">
                  <input type="checkbox" value="https" class="custom-control-input" id="scheme" name="scheme" {{ (env('APP_SCHEME') == 'https') ? "checked" : "" }}>
                  <label class="custom-control-label" for="scheme">{{ __('Force https scheme') }}</label>
               </div>
              </div>
            </div>
		    	</div>
		    	<div class="row">
		    		<div class="col-md-6">
              <div class="form-group mt-5">
                 <label class="form-label"><em class="icon ni ni-globe"></em> <span>{{ __('Timezone') }}</span></label>
                 <div class="form-control-wrap">
                    {!! $timezone !!}
                 </div>
              </div>
		    		</div>
		    		<div class="col-md-6">
                       <div class="form-group mt-5">
                          <label class="form-label"><em class="icon ni ni-map"></em> <span>{{ __('optional') }}</span> <small>{{ __('optional') }}</small></label>
						    <div class="form-control-wrap">
						        <input type="text" class="form-control form-control-lg" placeholder="{{ __('enter your location') }}" value="{{ settings('location') }}" name="location">
						    </div>
                       </div>
		    		</div>
		    		<div class="col-md-6">
                       <div class="form-group mt-5">
                          <label class="form-label"><em class="icon ni ni-home"></em> <span>{{ __('Custom index url') }}</span></label>
						    <div class="form-control-wrap">
						        <input type="url" class="form-control form-control-lg" placeholder="{{ __('enter your location') }}" value="{{ settings('custom_home') }}" name="custom_home">
						    </div>
						    <p>{{ __('Set the full custom index url ( ex: https://google.com/ ) if you want to completely disable the default landing page of the product. Helpful when you want to have your own landing page. Leave empty to disable.') }}</p>
                       </div>
		    		</div>
		    		<div class="col-md-6">
                       <div class="form-group mt-5">
                          <label class="form-label"><em class="icon ni ni-notes-alt"></em> <span>{{ __('Terms url') }}</span></label>
						    <div class="form-control-wrap">
						        <input type="text" class="form-control form-control-lg" placeholder="{{ __('enter your location') }}" value="{{ settings('terms') }}" name="terms">
						    </div>
                       </div>
		    		</div>
		    		<div class="col-md-6">
                       <div class="form-group mt-5">
                          <label class="form-label"><em class="icon ni ni-shield-star"></em> <span>{{ __('Privacy url') }}</span></label>
						    <div class="form-control-wrap">
						        <input type="text" class="form-control form-control-lg" placeholder="{{ __('enter your location') }}" value="{{ settings('privacy') }}" name="privacy">
						    </div>
                       </div>
		    		</div>
		    		<div class="col-md-6">
                       <div class="form-group mt-5">
                          <label class="form-label"><em class="icon ni ni-histroy"></em> <span>{{ __('Support status changer') }}</span></label>
						    <div class="form-control-wrap">
						        <input type="text" class="form-control form-control-lg" placeholder="{{ __('enter days') }}" value="{{ settings('support_days') }}" name="support_status_change">
						    </div>
						    <p>{{ __('Auto close support after x days of no new entry') }}</p>
                       </div>
		    		</div>
		    	</div>
		    </div>
        <div class="tab-pane" id="social_logins">
         <div class="row">
          <div class="col-md-6">
          <div class="form-group mt-5">
            <div class="custom-control custom-switch">
              <input type="hidden" class="custom-control-input" name="facebook_status" value="0">
              <input type="checkbox" class="custom-control-input" id="facebook_status" name="facebook_status" value="1" {{ (config('app.facebook_status') == 1) ? "checked" : "" }}>
              <label class="custom-control-label" for="facebook_status">{{ __('Enable Facebook login') }}</label>
           </div>
          </div>
           <div class="form-group mt-5">
              <label class="form-label"><span>{{ __('Facebook client ID') }}</span></label>
              <div class="form-control-wrap">
               <input type="text" value="{{config("services.facebook.client_id")}}" class="form-control form-control-lg" placeholder="{{ __('your facebook client ID') }}" name="facebook_client_id">
              </div>
           </div>
           <div class="form-group mt-5">
              <label class="form-label"><span>{{ __('Facebook Secret Key') }}</span></label>
              <div class="form-control-wrap">
               <input type="text" value="{{config("services.facebook.client_secret")}}" class="form-control form-control-lg" placeholder="{{ __('your facebook secret key') }}" name="facebook_secret_key">
              </div>
           </div>
           <div class="form-group mt-5">
              <label class="form-label"><span>{{ __('Facebook Callback') }}</span></label>
              <div class="form-control-wrap">
               <input type="text" value="{{env('FACEBOOK_CALLBACK')}}" class="form-control form-control-lg" readonly>
              </div>
           </div>
          </div>
          <div class="col-md-6">
          <div class="form-group mt-5">
            <div class="custom-control custom-switch">
              <input type="hidden" class="custom-control-input" name="google_status" value="0">
              <input type="checkbox" class="custom-control-input" id="google_status" name="google_status" value="1" {{ (config('app.google_status') == 1) ? "checked" : "" }}>
              <label class="custom-control-label" for="google_status">{{ __('Enable Google login') }}</label>
           </div>
          </div>
           <div class="form-group mt-5">
              <label class="form-label"><span>{{ __('Google client ID') }}</span></label>
              <div class="form-control-wrap">
               <input type="text" value="{{config("services.google.client_id")}}" class="form-control form-control-lg" placeholder="{{ __('your google client ID') }}" name="google_client_id">
              </div>
           </div>
           <div class="form-group mt-5">
              <label class="form-label"><span>{{ __('Recaptcha Secret Key') }}</span></label>
              <div class="form-control-wrap">
               <input type="text" value="{{config("services.google.client_secret")}}" class="form-control form-control-lg" placeholder="{{ __('your google secret key') }}" name="google_secret_key">
              </div>
           </div>
           <div class="form-group mt-5">
              <label class="form-label"><span>{{ __('Google Callback') }}</span></label>
              <div class="form-control-wrap">
               <input type="text" value="{{env('GOOGLE_CALLBACK')}}" class="form-control form-control-lg" readonly>
              </div>
           </div>
          </div>
          </div>
        </div>
        <div class="tab-pane" id="captcha">
         <div class="row">
          <div class="col-md-6">
            
          <div class="form-group mt-5">
            <div class="custom-control custom-switch">
              <input type="hidden" class="custom-control-input" name="captcha_status" value="0">
              <input type="checkbox" class="custom-control-input" id="captcha_status" name="captcha_status" value="1" {{ (config('app.captcha_status') == 1) ? "checked" : "" }}>
              <label class="custom-control-label" for="captcha_status">{{ __('Enable Captcha') }}</label>
           </div>
          </div>
          <div class="form-group mt-5">
             <label class="form-label"><span> {{ __('Captcha type') }}</span></label>
             <div class="form-control-wrap">
                <select class="form-select" data-search="off" data-ui="lg" name="captcha_type">
                   <option value="default" {{ config('app.captcha_type') == 'default' ? 'selected' : '' }}> {{ __('Default') }} </option>
                   <option value="recaptcha" {{ config('app.captcha_type') == 'recaptcha' ? 'selected' : '' }}> {{ __('Google Recaptcha') }} </option>
               </select>
             </div>
          </div>
          </div>
            <div class="col-md-6">
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Recaptcha Site Key') }}</span></label>
                 <div class="form-control-wrap">
                  <input type="text" value="{{config("app.recaptcha_site_key")}}" class="form-control form-control-lg" placeholder="{{ __('your recaptcha site key') }}" name="recaptcha_site_key">
                 </div>
              </div>
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Recaptcha Secret Key') }}</span></label>
                 <div class="form-control-wrap">
                  <input type="text" value="{{config("app.recaptcha_secret_key")}}" class="form-control form-control-lg" placeholder="{{ __('your recaptcha secret key') }}" name="recaptcha_secret_key">
                 </div>
              </div>
            </div>
          </div>
        </div>
		    <div class="tab-pane" id="payment">
				<div class="data-head mt-5 mb-1">
           <h6 class="overline-title">{{ __(' General ') }}</h6>
         </div>
    			<div class="row">
    			 <div class="col">
             <div class="form-group mt-5">
                <label class="form-label"><span> {{ __('Payments System Is Enabled') }}</span></label>
                <div class="form-control-wrap">
                   <select class="form-select" data-search="off" data-ui="lg" name="payment_system">
                      <option value="1" {{settings('payment_system') ? "selected" : ""}}> {{ __('Yes') }}</option>
                      <option value="0" {{!settings('payment_system') ? "selected" : ""}}> {{ __('No') }}</option>
                  </select>
                </div>
                <p>{{ __('Disabling the payment system will remove all the options for the users to upgrade their accounts or see any payment related information.') }}</p>
             </div>
    			 </div>
    			 <div class="col">
             <div class="form-group mt-5">
                <label class="form-label"><span>{{ __('Currency') }}</span></label>
                <div class="form-control-wrap">
                 <input type="text" value="{{settings('currency')}}" class="form-control form-control-lg" placeholder="{{ __('currency') }}" name="currency">
                 <p>{{ __('Enter your currency code. ex: USD') }}</p>
                </div>
             </div>
    			 </div>
    			</div>

            <div class="row">
		     <div class="col-md-6">
			        <div class="data-head mt-5 mb-1">
                <h6 class="overline-title">{{ __('Paypal') }}</h6>
              </div>
              <div class="form-group mt-3">
                 <label class="form-label"><span>{{ __('Status') }}</span></label>
                 <div class="form-control-wrap">
                    <select class="form-select" data-search="off" data-ui="lg" name="paypal_status">
                       <option value="1" {{(env("PAYPAL_STATUS") == 1) ? "selected" : ""}}> {{ __('Yes') }}</option>
                       <option value="0" {{(env("PAYPAL_STATUS") == 0) ? "selected" : ""}}> {{ __('No') }}</option>
                   </select>
                 </div>
              </div>
              <div class="form-group mt-3">
                 <label class="form-label"><span>{{ __('Mode') }}</span></label>
                 <div class="form-control-wrap">
                    <select class="form-select" data-search="off" data-ui="lg" name="paypal_mode">
                       <option value="live" {{(env("PAYPAL_MODE") == 'live') ? "selected" : ""}}> {{ __('Live') }}</option>
                       <option value="sandbox" {{(env("PAYPAL_MODE") == 'sandbox') ? "selected" : ""}}> {{ __('Sandbox') }}</option>
                   </select>
                 </div>
              </div>
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Client Id') }}</span></label>
                 <div class="form-control-wrap">
					 <input type="text" value="{{env("PAYPAL_CLIENT_ID")}}" class="form-control form-control-lg" placeholder="{{ __('your client id') }}" name="paypal_client_id">
                 </div>
              </div>
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Secret') }}</span></label>
                 <div class="form-control-wrap">
        					 <input type="text" value="{{env("PAYPAL_SECRET")}}" class="form-control form-control-lg" placeholder="{{ __('your secret') }}" name="paypal_secret">
                 </div>
              </div>
			  <div class="data-head mt-5 mb-1">
	            <h6 class="overline-title">{{ __('Paystack') }}</h6>
	           </div>
              <div class="form-group mt-3">
                 <label class="form-label"><span>{{ __('Status') }}</span></label>
                 <div class="form-control-wrap">
                    <select class="form-select" data-search="off" data-ui="lg" name="paystack_status">
                       <option value="0" {{(env("PAYSTACK_STATUS") == 0) ? "selected" : ""}}> {{ __('No') }}</option>
                       <option value="1" {{env("PAYSTACK_STATUS") == 1 ? "selected" : ""}}> {{ __('Yes') }}</option>
                   </select>
                 </div>
              </div>
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Public Key') }}</span></label>
                 <div class="form-control-wrap">
					 <input type="text" value="{{env("PAYSTACK_PUBLIC_KEY")}}" class="form-control form-control-lg" placeholder="{{ __('your public key') }}" name="paystack_public_key">
                 </div>
              </div>
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Secret key') }}</span></label>
                 <div class="form-control-wrap">
				         <input type="text" value="{{env("PAYSTACK_SECRET_KEY")}}" class="form-control form-control-lg" placeholder="{{ __('your secret key') }}" name="paystack_secret_key">
                 </div>
              </div>
              <div class="data-head mt-5 mb-1">
                <h6 class="overline-title">{{ __('MidTrans') }}</h6>
              </div>
              <div class="form-group mt-3">
                 <label class="form-label"><span>{{ __('Status') }}</span></label>
                 <div class="form-control-wrap">
                    <select class="form-select" data-search="off" data-ui="lg" name="midtrans_status">
                       <option value="1" {{(env("MIDTRANS_STATUS") == 1) ? "selected" : ""}}> {{ __('Yes') }}</option>
                       <option value="0" {{(env("MIDTRANS_STATUS") == 0) ? "selected" : ""}}> {{ __('No') }}</option>
                   </select>
                 </div>
              </div>
              <div class="form-group mt-3">
                 <label class="form-label"><span>{{ __('Mode') }}</span></label>
                 <div class="form-control-wrap">
                    <select class="form-select" data-search="off" data-ui="lg" name="midtrans_mode">
                       <option value="live" {{(env("MIDTRANS_MODE") == 'live') ? "selected" : ""}}> {{ __('Live') }}</option>
                       <option value="sandbox" {{(env("MIDTRANS_MODE") == 'sandbox') ? "selected" : ""}}> {{ __('Sandbox') }}</option>
                   </select>
                 </div>
              </div>
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Client Key') }}</span></label>
                 <div class="form-control-wrap">
                    <input type="text" value="{{env("MIDTRANS_CLIENT_KEY")}}" class="form-control form-control-lg" placeholder="{{ __('your client key') }}" name="midtrans_client_key">
                 </div>
              </div>
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Server Key') }}</span></label>
                 <div class="form-control-wrap">
                   <input type="text" value="{{env("MIDTRANS_SERVER_KEY")}}" class="form-control form-control-lg" placeholder="{{ __('your server key') }}" name="midtrans_server_key">
                 </div>
              </div>
		     </div>
		     <div class="col-md-6">
		     	
			       <div class="data-head mt-5 mb-1">
	            <h6 class="overline-title">{{ __('Bank Transfer') }}</h6>
	           </div>

              <div class="form-group mt-3">
                 <label class="form-label"><span>{{ __('Status') }}</span></label>
                 <div class="form-control-wrap">
                    <select class="form-select" data-search="off" data-ui="lg" name="bank_status">
                       <option value="0" {{(config('app.bank_status') == 0) ? "selected" : ""}}> {{ __('No') }}</option>
                       <option value="1" {{config('app.bank_status') == 1 ? "selected" : ""}}> {{ __('Yes') }}</option>
                   </select>
                 </div>
              </div>
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Bank Details including bank name') }}</span></label>
                 <div class="form-control-wrap">
					         <input type="text" value="{{config("app.bank_details")}}" class="form-control form-control-lg" placeholder="{{ __('your key id') }}" name="bank_details">
                 </div>
              </div>

             <div class="data-head mt-5 mb-1">
              <h6 class="overline-title">{{ __('Razor Pay') }}</h6>
             </div>
              <div class="form-group mt-3">
                 <label class="form-label"><span>{{ __('Status') }}</span></label>
                 <div class="form-control-wrap">
                    <select class="form-select" data-search="off" data-ui="lg" name="rozor_status">
                       <option value="0" {{(env("RAZOR_STATUS") == 0) ? "selected" : ""}}> {{ __('No') }}</option>
                       <option value="1" {{env("RAZOR_STATUS") == 1 ? "selected" : ""}}> {{ __('Yes') }}</option>
                   </select>
                 </div>
              </div>
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Key Id') }}</span></label>
                 <div class="form-control-wrap">
                   <input type="text" value="{{config("app.razor_key")}}" class="form-control form-control-lg" placeholder="{{ __('your key id') }}" name="razor_key_id">
                 </div>
              </div>
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Key Secret') }}</span></label>
                 <div class="form-control-wrap">
                  <input type="text" value="{{config("app.razor_secret")}}" class="form-control form-control-lg" placeholder="{{ __('your secret key') }}" name="rozor_secret_key">
                 </div>
              </div>
             <div class="data-head mt-5 mb-1">
              <h6 class="overline-title">{{ __('Stripe') }}</h6>
             </div>
              <div class="form-group mt-3">
                 <label class="form-label"><span>{{ __('Status') }}</span></label>
                 <div class="form-control-wrap">
                    <select class="form-select" data-search="off" data-ui="lg" name="stripe_status">
                       <option value="0" {{(config("app.stripe_status") == 0) ? "selected" : ""}}> {{ __('No') }}</option>
                       <option value="1" {{config("app.stripe_status") == 1 ? "selected" : ""}}> {{ __('Yes') }}</option>
                   </select>
                 </div>
              </div>
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Client Id') }}</span></label>
                 <div class="form-control-wrap">
                   <input type="text" value="{{config("app.stripe_client")}}" class="form-control form-control-lg" placeholder="{{ __('your client id') }}" name="stripe_client">
                 </div>
              </div>
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Secret Id') }}</span></label>
                 <div class="form-control-wrap">
                  <input type="text" value="{{config("app.stripe_secret")}}" class="form-control form-control-lg" placeholder="{{ __('your secret key') }}" name="stripe_secret">
                 </div>
               </div>
		          </div>
            </div>
		    </div>
		    <div class="tab-pane" id="ads">
		    	<div class="form-group mt-5">
		    		<div class="custom-control custom-switch">
					    <input type="hidden" class="custom-control-input" name="ads_enabled" value="0">
					    <input type="checkbox" class="custom-control-input" id="ads_switch" name="ads_enabled" value="1" {{ settings('ads.enabled') ? "checked" : "" }}>
					    <label class="custom-control-label" for="ads_switch">{{ __('Enable ads') }}</label>
					</div>
		    	</div>
		    	<h5>{{ __('These fields accept text or html.') }}</h5>
		    	<p>{{ __('Note ads can remove depending on user plan') }}</p>
				 <div class="data-head mt-5 mb-5">
           <h6 class="overline-title">{{ __('Site | Dashboard ads') }}</h6>
         </div>
		    	<div class="row mt-4">
		    		<div class="col-md-6 mt-4">
				    	<div class="form-group">
						    <label class="form-label"><span>{{ __('Header') }}</span></label>
						    <div class="form-control-wrap">
						        <textarea class="form-control form-control-lg" placeholder="{{ __('input header code') }}" name="ads_site_header">{{settings('ads.site_header')}}</textarea>
						    </div>
						</div>
		    		</div>
		    		<div class="col-md-6 mt-4">
				    	<div class="form-group">
						    <label class="form-label"><span>{{ __('Footer') }}</span></label>
						    <div class="form-control-wrap">
						        <textarea class="form-control form-control-lg" placeholder="{{ __('input header footer') }}" name="ads_site_footer">{{settings('ads.site_footer')}}</textarea>
						    </div>
						</div>
		    		</div>
		    	</div>

				<div class="data-head mt-5 mb-5">
                   <h6 class="overline-title">{{ __('Profile ads') }}</h6>
                 </div>
		    	<div class="row">
		    		<div class="col-md-6 mt-4">
				    	<div class="form-group">
						    <label class="form-label"><span>{{ __('Header') }}</span></label>
						    <div class="form-control-wrap">
						        <textarea class="form-control form-control-lg" placeholder="{{ __('input header code') }}" name="ads_profile_header">{{settings('ads.profile_header')}}</textarea>
						    </div>
						</div>
		    		</div>
		    		<div class="col-md-6 mt-4">
				    	<div class="form-group">
						    <label class="form-label"><span>{{ __('Footer') }}</span></label>
						    <div class="form-control-wrap">
						        <textarea class="form-control form-control-lg" placeholder="{{ __('input header footer') }}" name="ads_profile_footer">{{settings('ads.profile_footer')}}</textarea>
						    </div>
						</div>
		    		</div>
		    	</div>
		    </div>



		    <!-- Custom JS / CSS -->

		    <div class="tab-pane" id="custom-js-css">
		    	<div class="form-group mt-5">
		    		<div class="custom-control custom-switch">
					    <input type="hidden" class="custom-control-input" name="custom_code_enabled" value="0">
					    <input type="checkbox" class="custom-control-input" id="custom_js_css" name="custom_code_enabled" value="1" {{ settings('custom_code.enabled') ? "checked" : "" }}>
					    <label class="custom-control-label" for="custom_js_css">{{ __('Enable Custom JS / Css') }}</label>
					</div>
		    	</div>
		    	<div class="row">
		    		<div class="col-md-6">
				    	<div class="form-group mt-5 mt-lg-2">
						    <label class="form-label"><em class="icon ni ni-css3-fill"></em> <span>{{ __('Head Javascript') }}</span></label>
						    <div class="form-control-wrap">
						        <textarea class="form-control form-control-lg" placeholder="{{ __('input js code') }}" name="custom_code_js">{{settings('custom_code.js')}}</textarea>
						    </div>
						</div>
		    		</div>
		    		<div class="col-md-6">
				    	<div class="form-group mt-5 mt-lg-2">
						    <label class="form-label"><em class="icon ni ni-js"></em> <span>{{ __('Head Css') }}</span></label>
						    <div class="form-control-wrap">
						        <textarea class="form-control form-control-lg" placeholder="{{ __('input css code') }}" name="custom_code_css">{{settings('custom_code.css')}}</textarea>
						    </div>
						</div>
		    		</div>
		    	</div>
		    </div>




		    <!-- User -->
		    <div class="tab-pane" id="user">
				<div class="data-head mt-5 mb-2">
          <h6 class="overline-title">{{ __('Registration') }}</h6>
        </div>
		    	<div class="row">
            <div class="col-6">
              <div class="form-group mt-5">
                <div class="custom-control custom-switch">
                  <input type="hidden" name="registration" value="0">
                  <input type="checkbox" value="1" class="custom-control-input" id="registration" name="registration" {{ settings('registration') ? "checked" : "" }}>
                  <label class="custom-control-label" for="registration">{{ __('Enable Registration') }}</label>
              </div>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Enable email verification') }}</span></label>
                 <div class="form-control-wrap">
                    <select class="form-select" data-search="off" data-ui="lg" name="email_activation">
                      <option value="1" {{ settings('email_activation') ? "selected" : "" }}>On</option>
                      <option value="0" {{ !settings('email_activation') ? "selected" : "" }}>Off</option>
                  </select>
                </div>
             </div>
            </div>
            <div class="col-6">
              <div class="form-group mt-5">
                 <label class="form-label"><span>{{ __('Featured User') }}</span></label>
                 <p>{{ __('This will show users on index page') }}</p>
                 <div class="form-control-wrap">
                    <select class="form-select" data-search="off" data-ui="lg" name="user_featured">
                      <option value="off" {{ (settings('user.featured') == 'off') ? "selected" : "" }}>{{ __('Off') }}</option>
                      <option value="top_user" {{ (settings('user.featured') == 'top_user') ? "selected" : "" }}>{{ __('Show top 3 users') }}</option>
                      <option value="selected_user" {{ (settings('user.featured') == 'selected_user') ? "selected" : "" }}>{{ __('Selected Users') }}</option>
                  </select>
                </div>
             </div>
            </div>
            <div class="col-6">
              <div class="form-group mt-5">
                <label>{{ __('Domains') }}</label>
                  <p>{{ __('if checked user profile will be shown on all multidomain. if unchecked user profile will be limited to selected domain') }}</p>
                <div class="custom-control custom-switch">
                  <input type="hidden" name="user_domains_restrict" value="0">
                  <input type="checkbox" value="1" class="custom-control-input" id="user_domains_restrict" name="user_domains_restrict" {{ settings('user.domains_restrict') ? "checked" : "" }}>
                  <label class="custom-control-label" for="user_domains_restrict"></label>
                </div>
              </div>
            </div>
				</div>
		    </div>
		    <div class="tab-pane" id="social">
		    	<div class="row mt-5">
		    		<div class="col-6 col-lg-4">
				    	<div class="form-group mt-2">
						    <label class="form-label"><em class="icon ni ni-facebook-f"></em> <span>{{ __('Facebook') }}</span></label>
						    <div class="form-control-wrap">
						        <input type="text" value="{{ settings('social.facebook') }}" class="form-control form-control-lg" placeholder="{{ __('your username') }}" name="social_facebook">
						    </div>
						</div>
				    </div>
		    		<div class="col-6 col-lg-4">
				    	<div class="form-group mt-2">
						    <label class="form-label"><em class="icon ni ni-instagram"></em> <span>{{ __('Instagram') }}</span></label>
						    <div class="form-control-wrap">
						        <input type="text" value="{{ settings('social.instagram') }}" class="form-control form-control-lg" placeholder="{{ __('your username') }}" name="social_instagram">
						    </div>
						</div>
				    </div>
		    		<div class="col-6 col-lg-4">
				    	<div class="form-group mt-5 mt-lg-2">
						    <label class="form-label"><em class="icon ni ni-youtube"></em> <span>{{ __('Youtube') }}</span></label>
						    <div class="form-control-wrap">
						        <input type="text" value="{{ settings('social.youtube') }}" class="form-control form-control-lg" placeholder="{{ __('channel id') }}" name="social_youtube">
						    </div>
						</div>
				    </div>
		    		<div class="col-6 col-lg-4">
				    	<div class="form-group mt-5">
						    <label class="form-label"><em class="icon ni ni-twitter"></em> <span>{{ __('Twitter') }}</span></label>
						    <div class="form-control-wrap">
						        <input type="text" value="{{ settings('social.twitter') }}" class="form-control form-control-lg" placeholder="{{ __('your username') }}" name="social_twitter">
						    </div>
						</div>
				    </div>
		    		<div class="col-6 col-lg-4">
				    	<div class="form-group mt-5">
						    <label class="form-label"><em class="icon ni ni-whatsapp"></em> <span>{{ __('Whatsapp') }}</span></label>
						    <div class="form-control-wrap">
						        <input type="text" value="{{ settings('social.whatsapp') }}" class="form-control form-control-lg" placeholder="{{ __('phone number including county code') }}" name="social_whatsapp">
						    </div>
						</div>
				    </div>
				</div>
		    </div>
		    <div class="tab-pane" id="emailsnotify">
		    	<div class="row">
		    		
		    	<div class="col-md-6">
				 	<div class="form-group mt-5 mt-lg-2">
					    <label class="form-label"><em class="icon ni ni-bell-fill"></em> <span> {{ __('Emails to be notify') }}</span></label>
					    <div class="form-control-wrap">
					        <textarea class="form-control form-control-lg" placeholder="{{ __('input emails') }}" name="email_notify_emails">{{ settings('email_notify.emails') }}</textarea>
					    </div>
		    			<p>{{ __('Emails that will receive a notification when one of the bottom actions are performed. Add valid email addresses separated by a comma.') }}</p>
					</div>
		    	</div>
		    	<div class="col-md-6">
		    		
		    	<div class="row mt-4">
						<div class="row">
				    	<div class="col-12 mt-4 mb-4">
					        <div class="custom-control custom-checkbox">
							    <input type="hidden" name="email_notify_user" value="0">
							    <input type="checkbox" class="custom-control-input" name="email_notify_user" id="email_notify_user"{{ settings('email_notify.user') == 1 ? "checked" : "" }} value="1">
							    <label class="custom-control-label" for="email_notify_user">{{ __('New User') }}</label>
							</div>
							<p>{{ __('Receive an email when a new users registers to the website.') }}</p>
				    	</div>
				    	  <div class="col-6">
					        <div class="custom-control custom-checkbox">
							    <input type="hidden" name="email_notify_support" value="0">
							    <input type="checkbox" class="custom-control-input" name="email_notify_support" id="email_notify_support" {{ settings('email_notify.support') ? "checked" : "" }} value="1" >
							    <label class="custom-control-label" for="email_notify_support">{{ __('New Support') }}</label>
							</div>
							<p>{{ __('Receive an email when a user create support') }}</p>
				    		</div>
				    		<div class="col-6">
					        <div class="custom-control custom-checkbox">
							    <input type="hidden" name="email_notify_supportreply" value="0">
							    <input type="checkbox" class="custom-control-input" name="email_notify_supportreply" id="email_notify_supportreply" {{ settings('email_notify.supportreply') ? "checked" : "" }} value="1">
							    <label class="custom-control-label" for="email_notify_supportreply">{{ __('Support reply') }}</label>
							</div>
							<p>{{ __('Receive an email when a user reply support ticket.') }}</p>
				    		</div>				
					    	<div class="col-6 mt-4">
						       <div class="custom-control custom-checkbox">
								    <input type="hidden" name="email_notify_payment" value="0">
							      <input type="checkbox" class="custom-control-input" name="email_notify_payment" id="email_notify_payment"{{ settings('email_notify.payment') ? "checked" : "" }} value="1">
							      <label class="custom-control-label" for="email_notify_payment">{{ __('New Payment') }}</label>
							  </div>
							  <p>{{ __('Receive an email when a new payment is successfully processed.') }}</p>
							</div>
					    	<div class="col-6 mt-4">
						       <div class="custom-control custom-checkbox">
								    <input type="hidden" name="email_notify_bank_transfer" value="0">
							      <input type="checkbox" class="custom-control-input" name="email_notify_bank_transfer" id="email_notify_bank_transfer"{{ settings('email_notify.bank_transfer') ? "checked" : "" }} value="1">
							      <label class="custom-control-label" for="email_notify_bank_transfer">{{ __('New Bank Transfer') }}</label>
							  </div>
							  <p>{{ __('Receive an email when a new bank transfer request is made.') }}</p>
							</div>
						</div>
		    	  </div>
		    	</div>
		      </div>
		    </div>

		    <!-- Site -->
		    <div class="tab-pane" id="site">
				<div class="data-head mt-5 mb-2">
                   <h6 class="overline-title">{{ __('Topbar') }}</h6>
                </div>
		        <div class="row">
		    		<div class="col-4">
                       <div class="form-group mt-5">
                          <label class="form-label"><span>{{ __('Enable topbar') }}</span></label>
                          <div class="form-control-wrap">
                             <select class="form-select" data-search="off" data-ui="lg" name="topbar_enabled">
                                <option value="1" {{ settings('topbar.enabled') ? "selected" : "" }}> {{ __('On') }}</option>
                                <option value="0" {{ !settings('topbar.enabled') ? "selected" : "" }}> {{ __('Off') }}</option>
                            </select>
                          </div>
                       </div>
				    </div>
		    		<div class="col-4">
                       <div class="form-group mt-5">
                          <label class="form-label"><span> {{ __('Use Site location') }}</span></label>
                          <div class="form-control-wrap">
                             <select class="form-select" data-search="off" data-ui="lg" name="topbar_location">
                                <option value="1" {{ settings('topbar.location') ? "selected" : "" }}> {{ __('On') }}</option>
                                <option value="0" {{ !settings('topbar.location') ? "selected" : "" }}> {{ __('Off') }}</option>
                            </select>
                          </div>
                       </div>
				    </div>
		    		<div class="col-4">
                       <div class="form-group mt-5">
                          <label class="form-label"><span>{{ __('Enable top bar social') }}</span></label>
                          <div class="form-control-wrap">
                             <select class="form-select" data-search="off" data-ui="lg" name="topbar_social">
                                <option value="1" {{ settings('topbar.social') ? "selected" : "" }}> {{ __('On') }}</option>
                                <option value="0" {{ !settings('topbar.social') ? "selected" : "" }}> {{ __('Off') }}</option>
                            </select>
                          </div>
                       </div>
				    </div>
		        </div>
			   <div class="data-head mt-5 mb-2">
	              <h6 class="overline-title">{{ __('Images') }}</h6>
	           </div>
	           <div class="row">
	           	<div class="col">
			   		<div class="image-upload pages {{(!empty(settings('logo')) ? file_exists(public_path('img/logo/' . settings('logo'))) ? "active" : "" : "")}}">
			                 <label for="upload">{{ __('Click here or drop an image for logo') }}</label>
			                 <input type="file" id="upload" name="logo" class="upload">
			                 <img src="{{ url('img/logo/' . settings('logo')) }}" alt=" ">
			            </div>
	           	</div>
	           	<div class="col">
			   		<div class="image-upload pages {{ file_exists(public_path('img/favicon/' . settings('favicon'))) ? "active" : "")}}">
			                 <label for="upload">{{ __('Click here or drop an image for favicon') }}</label>
			                 <input type="file" id="upload" name="favicon" class="upload">
			                 <img src="{{ url('img/favicon/' . settings('favicon')) }}" alt=" ">
			            </div>
	           	</div>
	           </div>
	           <div class="row">
		    	<div class="col-md-6">
                   <div class="form-group mt-5">
                      <label class="form-label"><span>{{ __('Enable maintenance mode') }}</span></label>
                      <p>{{ __('General maintenance mode.') }} <br> {{ __('Note only admins can login.') }}</p>
                      <div class="form-control-wrap">
                         <select class="form-select" data-search="off" data-ui="lg" name="maintenance_enabled">
                            <option value="0" {{ !settings('maintenance.enabled') ? "selected" : "" }}> {{ __('Off') }}</option>
                            <option value="1" {{ settings('maintenance.enabled') ? "selected" : "" }}> {{ __('On') }}</option>
                        </select>
                      </div>
                   </div>
				 </div>
		    	<div class="col-md-6">
                   <div class="form-group mt-5">
                      <label class="form-label"><span>{{ __('Custom maintenance text') }}</span></label>
                      <div class="form-control-wrap">
                      	<textarea name="maintenance_custom_text" class="form-control form-control-lg">{{ settings('maintenance.custom_text') }}</textarea>
                      </div>
                      <p>{{ __('Leave empty for default text') }}</p>
                   </div>
				 </div>
		    		<div class="col-6 col-lg-4">
				    	<div class="form-group mt-5">
						    <label class="form-label"><span>{{ __('Show contact form') }}</span></label>
						    <div class="form-control-wrap">
		                         <select class="form-select" data-search="off" data-ui="lg" name="contact">
		                            <option value="0" {{ !settings('contact') ? "selected" : "" }}> {{ __('Off') }}</option>
		                            <option value="1" {{ settings('contact') ? "selected" : "" }}> {{ __('On') }}</option>
		                        </select>
						    </div>
						</div>
				    </div>
	           </div>
		    </div>
		    <div class="tab-pane" id="smtp">
		    	<div class="row">
		    		<div class="col-md-6">
				    	<div class="form-group mt-4">
						    <label class="form-label"><span>{{ __('Host') }}</span></label>
						    <div class="form-control-wrap">
						        <input type="text" class="form-control form-control-lg" placeholder="{{ __('SMTP HOST') }}" value="{{ env('MAIL_HOST') }}" name="smtp_host">
						    </div>
						</div>
		    		</div>
		    		<div class="col-md-6">
                       <div class="form-group mt-4">
                          <label class="form-label"><span>{{ __('From Email') }}</span></label>
                          <div class="form-control-wrap">
						    <input type="text" class="form-control form-control-lg" placeholder="{{ __('SMTP FROM ADDRESS') }}" value="{{ env('MAIL_FROM_ADDRESS') }}" name="smtp_from_address">
                          </div>
                          <p>{{ __("The email that the users get the email from / the 'reply-to'") }}</p>
                       </div>
		    		</div>
		    	</div>
                <div class="form-group mt-4">
                   <label class="form-label"><span>{{ __('From Name') }}</span></label>
                   <div class="form-control-wrap">
				     <input type="text" class="form-control form-control-lg" placeholder="SMTP FROM NAME" value="{{ env('MAIL_FROM_NAME') }}" name="smtp_from_name">
                   </div>
                    <p>{{ __('Empty to use default app name') }}</p>
                </div>
		    	<div class="row">
		    		<div class="col-4">
				    	<div class="form-group mt-4">
						    <label class="form-label"><span>{{ __('Port') }}</span></label>
						    <div class="form-control-wrap">
                               <select class="form-select" data-search="off" data-ui="lg" name="smtp_encryption">
                                  <option value="ssl" {{(env('MAIL_ENCRYPTION') == 'ssl') ? 'selected' : ''}}> {{ __('SSL') }}</option>
                                  <option value="tls" {{(env('MAIL_ENCRYPTION') == 'tls') ? 'selected' : ''}}> {{ __('TLS') }}</option>
                              </select>
						    </div>
						</div>
		    		</div>
		    		<div class="col-8">
                       <div class="form-group mt-4">
                          <label class="form-label"><span>{{ __('Port') }}</span></label>
						    <div class="form-control-wrap">
						        <input type="text" class="form-control form-control-lg" placeholder="{{ __('SMTP PORT') }}" value="{{ env('MAIL_PORT') }}" name="smtp_port">
						    </div>
                       </div>
		    		</div>
		    	</div>
		    	<div class="row">
		    		<div class="col-6">
				    	<div class="form-group mt-4">
						    <label class="form-label"><span>{{ __('Username') }}</span></label>
						    <div class="form-control-wrap">
						        <input type="text" class="form-control form-control-lg" placeholder="{{ __('SMTP USERNAME') }}" value="{{ env('MAIL_USERNAME') }}" name="smtp_username">
						    </div>
						</div>
		    		</div>
		    		<div class="col-6">
                       <div class="form-group mt-4">
                          <label class="form-label"><span>{{ __('Password') }}</span></label>
                          <div class="form-control-wrap">
						    <input type="text" class="form-control form-control-lg" placeholder="{{ __('SMTP PASSWORD') }}" value="{{ env('MAIL_PASSWORD') }}" name="smtp_password">
                          </div>
                       </div>
		    		</div>
		    	</div>
		    </div>
		<div class="form-group mt-5">
			<button type="submit" class="btn btn-primary w-50"><em class="icon ni ni-save-fill"></em> <span>{{ __('Save') }}</span></button>
		</div>
	</div>
</form>
@endsection
