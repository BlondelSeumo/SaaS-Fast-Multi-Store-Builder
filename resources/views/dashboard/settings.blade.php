@extends('layouts.app')
@section('title', 'Settings')
@section('footerJS')
  <script src="{{ url('tinymce/tinymce.min.js') }}"></script>
  <script src="{{ url('tinymce/sr.js') }}"></script>
@stop
@section('content')
  <div class="card-content container mt-8">
    <form action="{{ route('user-settings') }}" method="post" enctype="multipart/form-data">
      @csrf
    <div class="row">
      <div class="col-md-4">
        <div class="nk-block-head-content">
          <h3 class="nk-block-title page-title">{{ __('Settings') }}</h3>
        </div>
      </div>
      <div class="col-md-8">
        
      </div>
    </div>
    <ul class="nav nav-tabs bg-white nav-tabs-mb-icon card-shadow radius-10 nav-tabs-card mt-4 border-0">
       <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#main">
          <em class="icon ni ni-grid-c"></em>
          <span>{{ __('Main') }}</span></a>
       </li>
       <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#socials">
          <em class="icon ni ni-instagram"></em>
          <span>{{ __('Social') }}</span></a>
       </li>
       <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#payment">
          <em class="icon ni ni-visa"></em>
          <span>{{ __('Payments') }}</span></a>
       </li>
      @if (Theme::has(user('extra.template')) && file_exists(public_path('Themes/'.Theme::get(user('extra.template'))['name'].'/views/settings/extra-settings.blade.php')))
       <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#theme-extra">
          <em class="icon ni ni-template"></em>
          <span>{{ __('Theme Extra') }}</span></a>
       </li>
      @endif
    </ul>
    <div class="tab-content">
     <div class="tab-pane" id="theme-extra">
      @if (Theme::has(user('extra.template')) && file_exists(public_path('Themes/'.Theme::get(user('extra.template'))['name'].'/views/settings/extra-settings.blade.php')))
        <?php require(public_path('Themes/'.Theme::get(user('extra.template'))['name'].'/views/settings/extra-settings.blade.php')) ?>
      @endif
     </div>
     <div class="tab-pane active" id="main">
      <div class="mt-5"></div>
      @if (session()->get('admin_overhead') && user('role') == 0)
       <div class="row mb-5">
         <div class="col-md-6 mb-3">
           <div class="form-group mt-5 custom">
              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('Status') }}</span>
                <small class="d-block mt-2">{{ __('Set this user as active or ban') }}</small>
              </label>
              <div class="form-control-wrap">
                 <select class="form-select" data-search="off" data-ui="lg" name="active">
                    <option value="1" {{ ($user->active == 1) ? "selected" : "" }}> {{ __('Active') }}</option>
                    <option value="0" {{ ($user->active == 0) ? "selected" : "" }}> {{ __('Banned') }}</option>
                </select>
           </div>
         </div>
       </div>
         <div class="col-md-6 mb-3">
           <div class="form-group mt-5 custom">
              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('Verified') }}</span>
                <small class="d-block mt-2">{{ __('Verify this user') }}</small>
              </label>
              <div class="form-control-wrap">
                 <select class="form-select" data-search="off" data-ui="lg" name="verified">
                    <option value="1" {{ ($user->verified == 1) ? "selected" : "" }}> {{ __('Verified') }}</option>
                    <option value="0" {{ ($user->verified == 0) ? "selected" : "" }}> {{ __('Not verified') }}</option>
                </select>
           </div>
         </div>
       </div>
         <div class="col-md-6">
           <div class="form-group mt-5 custom">

              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('Change package') }}</span>
                <small class="d-block mt-2">{{ __('Change user package') }}</small>
              </label>
             <div class="form-control-wrap">
                <select class="form-select" data-search="on" data-ui="lg" name="package">
                <option value="{{settings('package_free.id')}}" {{($user->package == 'free') ? "selected" : ""}}>{{settings('package_free.name')}}</option>
                 @foreach (\App\Model\Packages::where('status', 1)->orWhere('status', 2)->get() as $item)
                   <option value="{{$item->id}}" {{($user->package !== 'free') ? ($user->package == $item->id) ? "selected" : "" : ""}}>{{$item->name}}</option>
                 @endforeach
               </select>
             </div>
           </div>
         </div>
         <div class="col-md-6">
           <div class="form-group mt-5 custom">
            <label class="form-label"><span>{{ __('Change Due (yyyy-mm-dd hh:mm)') }}</span></label>
             <div class="form-control-wrap">
               <input type="text" value="{{ $user->package_due }}" class="form-control" id="datepicker" name="package_due">
             </div>
             <p>{{ __('Leave for unchanged') }}</p>
           </div>
         </div>
       </div>
      @endif
      <div class="row">
        <div class="col-lg-3">
          <div class="profile-avatar text-center ml-4">
            <div class="profile-avatar-inner mx-auto">
              <img src="{{ avatar() }}" alt="">
              <input type="file" name="avatar" class="avatar_custom">
            </div>
            <div>
              <small class="muted-deep fw-normal">{!! __('Select max file size (1mb) <br> jpg, png, jpeg supported ') !!} </small>
            </div>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group custom mb-1 mb-lg-4">
                 <label class="muted-deep fw-normal m-2">{{ __('First Name') }}</label>
                 <input type="text" class="form__input" placeholder="{{ __('John') }}" name="name_first_name" value="{{user('name.first_name')}}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group custom mb-1 mb-lg-4">
                 <label class="muted-deep fw-normal m-2">{{ __('Last Name') }}</label>
                 <input type="text" class="form__input" placeholder="{{ __('Doe') }}" name="name_last_name" value="{{user('name.last_name')}}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group custom mb-1 mb-lg-4">
                 <label class="muted-deep fw-normal m-2">{{ __('Email') }}</label>
                 <input type="text" class="form__input" placeholder="{{ __('johndoe@example.com') }}" name="email" value="{{user('email')}}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group custom mb-1 mb-lg-4">
                 <label class="muted-deep fw-normal m-2">{{ __('Username') }}</label>
                 <input type="text" class="form__input" placeholder="{{ __('johnnydoe') }}" name="username" value="{{user('username')}}">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group custom mb-1 mb-lg-4 mt-md-9 mt-5">
             <label class="muted-deep fw-normal m-2">{{ __('About') }}</label>
             <textarea type="text" class="form__input editor" placeholder="{{ __('About you or your company') }}" name="extra_about">{!! clean(user('extra.about')) !!}</textarea>
          </div>
        </div>
        <div class="col-md-6">
             @if (package('settings.domains'))
             <div class="form-group mt-5">
                <label class="muted-deep fw-normal form-label muted-deep fw-normal ml-2"><span>{{ __('Domains') }}</span></label>
                <div class="form-control-wrap">
                   <select class="form-select" data-search="on" data-ui="lg" name="domain">
                      <option value="main" {{ user('domain') == 'main' ? 'selected' : '' }}>{{ '@' . parse_url(env('APP_URL'))['host'] }}</option>
                      @foreach ($domains as $key => $item)
                        <option value="{{$key}}" {{ $key == user('domain') ? 'selected' : '' }}>{{ '@' . $item->domain }}</option>
                      @endforeach
                  </select>
                </div>
             </div>
             @endif
            <div class="form-group custom mb-1 mb-lg-4">
               <label class="muted-deep fw-normal m-2">{{ __('Tagline') }}</label>
               <input type="text" placeholder="{{ __('Store owner | web developer') }}" name="extra_tagline" value="{{user('extra.tagline')}}">
            </div>
            <div class="form-group custom mb-1 mb-lg-4">
               <label class="muted-deep fw-normal m-2">{{ __('Address') }}</label>
               <input type="text" placeholder="{{ __('Alabama, USA') }}" name="address" value="{{user('address')}}">
            </div>
            <div class="form-group mt-5 mt-lg-2">
              <div class="d-flex">
              <label class="form-label mr-2">{!! __('Choose cover image (Remove banner to disable)') !!}</label>
              </div>
               <div class="image-upload pages {{!empty(user('media.banner')) && file_exists(media_path('user/banner/' . user('media.banner'))) ? "active" : ""}}">
                    <label for="upload">{!! __('Click here or drop an image to upload 1048MB max') !!}</label>
                    <input type="file" id="upload" name="banner" class="upload">
                    <img src="{{url('media/user/banner/' . user('media.banner'))}}" alt=" ">
               </div>
              </div>
              @if(!empty(user('media.banner')) && file_exists(media_path('user/banner/' . user('media.banner')))) 
              <a data-confirm="Are you sure you want to delete this banner?" href="{{ route('delete-banner') }}" class="btn btn-link">{{ __('Remove image') }}</a>
             @endif
             <hr>
              <div class="col-12 mb-3 p-0">
                 <div class="form-group custom">
                    <label class="form-label">{{ __('Media Url') }}</label>
                    <input type="text" name="extra_banner_url" class="form-control form-control-lg" value="{{ user('extra.banner_url') }}" placeholder="{{ __('Banner Url *optional') }}">
                 </div>
              </div>
        </div>
      </div>
        @if (package('settings.google_analytics') || package('settings.facebook_pixel'))
        <div class="data-head d-flex w-100 align-items-center justify-content-between mb-5 mt-5">
           <div>
              <h6 class="overline-title"><span>{{ __('Analytics') }}</span></h6>
           </div>
           <div>
              <button class="btn btn-primary c-save ml-auto d-none d-md-block"><span>{{ __('Save') }}</span> <em class="icon ni ni-edit"></em></button>
           </div>
        </div>
        @endif
        <div class="row">
          @if (package('settings.google_analytics'))
          <div class="col-md-6">
           <div class="form-group mt-5 mt-lg-2 custom">
              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('Google Analytics ID') }}</span>
                <small class="d-block mt-2">{{ __('Enable tracking with Google Analytics by adding your analytics ID. ex: UA-22222222-33') }}</small>
              </label>
              <div class="form-control-wrap">
                  <input type="text" class="form-control form-control-lg" placeholder="{{ __('Enter google analytics id') }}" name="extra_google_analytics" value="{{ user('extra.google_analytics') }}">
               </div>
           </div>
          </div>
          @endif
          @if (package('settings.facebook_pixel'))
          <div class="col-md-6">
           <div class="form-group mt-5 mt-lg-2 custom">
              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('Facebook Pixel') }}</span>
                <small class="d-block mt-2">{{ __('Enable Facebook Pixel by adding only your Facebook Pixel ID') }}</small>
              </label>
              <div class="form-control-wrap">
                  <input type="text" class="form-control form-control-lg" placeholder="{{ __('Enter facebook pixel id') }}" name="extra_facebook_pixel" value="{{ user('extra.facebook_pixel') }}">
               </div>
           </div>
          </div>
          @endif
        </div>
        <div class="data-head d-flex align-items-center justify-content-between mb-5 mt-5">
           <div>
              <h6 class="overline-title"><span>{{ __('Others') }}</span></h6>
           </div>
           <div>
              <button class="btn btn-primary c-save ml-auto d-none d-md-block"><span>{{ __('Save') }}</span> <em class="icon ni ni-edit"></em></button>
           </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="template-div mt-5 mt-lg-2">
              <div class="row">
                <div class="col-sm-8 d-flex flex-column justify-content-center align-items-center">
                    <div class="card card-inner justify-content-center card-shadow bdrs-20 d-flex align-items-center w-100">
                    <h5 class="upper text-white">{{ Theme::has(user('extra.template')) ? Theme::get(user('extra.template'))['title'] : 'Select a template' }}</h5>
                    <p class="tem-des upper fs-14px text-white">{{ Theme::has(user('extra.template')) ? Theme::get(user('extra.template'))['description'] : '' }}</p>
                    <a href="#" data-toggle="modal" data-target="#select-template" class="btn btn-link btn-primary text-white rounded-pill upper">{{ __('change') }}</a>
                    <span class="template">{{ __('Current template') }}</span>
                  <div class="template-img">
                      <div class="d-flex align-items-center">
                        <img src="{{ Theme::has(user('extra.template')) ? url('media/misc/' . Theme::get(user('extra.template'))['banner'] ?? '') : '' }}" alt=" ">
                        <div class="overlay-dark"></div>
                      </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            @if (package('settings.custom_branding'))
            <div class="form-group custom mt-4">
              <label class="muted-deep fw-normal form-label fw-normal ml-2">
                <span>{{ __('Custom footer branding') }}</span>
              </label>
               <input type="text" placeholder="{{ __('input footer text') }}" name="extra_custom_branding" value="{{user('extra.custom_branding')}}">
            </div>
            @endif
           <div class="form-group mt-5 custom">
              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('Shipping') }}</span>
                <small class="d-block mt-2">{{ __('Select checkout shipping types') }}</small>
              </label>
              <div class="form-control-wrap">
                 <select class="form-select" data-search="off" data-ui="lg" name="extra_shipping_types">
                  @foreach (['enable' => 'Enable shipping - (Buyer can still buy without selecting your shipping locations)', 'my_shipping' => 'My shipping - (Buyer cannot buy unless they select one of your shipping locations)', 'disable' => 'Disable shipping - (Shipping option will be disabled on checkout)'] as $key => $value)
                  <option value="{{$key}}" {{ user('extra.shipping_types') == $key ? 'selected' : '' }}> {{ __($value) }}</option>
                  @endforeach
                </select>
           </div>
         </div>
          </div>
        </div>
        <div class="data-head d-flex align-items-center justify-content-between mb-5 mt-5">
           <div>
              <h6 class="overline-title"><span>{{ __('Security') }}</span></h6>
           </div>
           <div>
              <button class="btn btn-primary c-save ml-auto d-none d-md-block"><span>{{ __('Save') }}</span> <em class="icon ni ni-edit"></em></button>
           </div>
        </div>
        <div class="col-md-4 p-0">
          <div class="form-group mt-5 mt-lg-2 custom">
              <label class="muted-deep fw-normal form-label fw-normal ml-2">
                <span>{{ __(' Change Password') }}</span>
              </label>
              <div class="form-control-wrap">
                  <input type="text" class="form-control form-control-lg" placeholder="{{ __('***********') }}" name="password">
               </div>
          </div>
        </div>
    </div>
      <div class="tab-pane" id="socials">
      <div class="row">
        @if ($package->settings->social)
          @foreach ($socials as $key => $items)
            <div class="col-md-4">
              <div class="form-group custom mb-1 mb-lg-4">
                 <label class="muted-deep fw-normal m-2"><em class="icon ni ni-{{$items['icon']}}"></em> <span>{{ ucfirst($key) }}</span></label>
                 <input type="text" value="{{ user('socials.'.$key) ?? '' }}" name="socials[{{$key}}]">
              </div>
            </div>
          @endforeach
        @endif
      </div>
      </div>
      <div class="tab-pane" id="payment">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group mt-5 custom">
              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('Currency') }}</span>
                <small class="d-block mt-2">{{ __('Select currency code') }}</small>
              </label>
              <select name="gateway_currency" class="form-select" data-search="on" data-ui="lg">
                @foreach (Currency::all() as $key => $code)
                 <option value="{{ $key }}" {{ (user('gateway.currency') == $key) ? 'selected' : '' }}>{{ $key }}</option>
                @endforeach
              </select>
           </div>
           @if (has_gateway('paypal', $user->id))
            <div class="form-group mt-5 custom">
              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('Paypal') }}</span>
                <small class="d-block mt-2">{{ __('Enter your paypal client id and secret key or leave empty to disable') }}</small>
              </label>
              <select name="gateway_paypal_mode" class="form-select" data-search="on" data-ui="lg">
                <option value="live" {{ user('gateway.paypal_mode') == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                <option value="sandbox" {{ user('gateway.paypal_mode') == 'sandbox' ? 'selected' : '' }}>{{ __('Sandbox') }}</option>
              </select>
              <div class="form-control-wrap mt-3">
               <input type="text" value="{{ user('gateway.paypal_client_id') }}" class="form-control form-control-lg" placeholder="Paypal client id" name="gateway_paypal_client_id">
              </div>
              <div class="form-control-wrap mt-3">
               <input type="text" value="{{ user('gateway.paypal_secret_key') }}" class="form-control form-control-lg" placeholder="Paypal secret key" name="gateway_paypal_secret_key">
              </div>
           </div>
            @endif
        @if (license('license') == 'Extended License')
           @if (has_gateway('paystack', $user->id))
            <div class="form-group custom mt-5">
              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('Paystack') }}</span>
                <small class="d-block mt-2">{{ __('Enter your paystack secret key or leave empty to disable') }}</small>
              </label>
               <div class="form-control-wrap">
               <input type="text" value="{{ user('gateway.paystack_secret_key') }}" class="form-control form-control-lg" placeholder="your secret key" name="gateway_paystack_secret_key">
               </div>
            </div>
            @endif
           @endif
           @if (has_gateway('bank', $user->id))
            <div class="form-group custom mt-5">
              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('Bank transfer') }}</span>
                <small class="d-block mt-2">{{ __('Input your bank details including bank name. Leave empty to disable') }}</small>
              </label>
               <div class="form-control-wrap">
                <input type="text" value="{{ user('gateway.bank_details') }}" class="form-control form-control-lg" placeholder="Enter details" name="gateway_bank_details">
               </div>
            </div>
            @endif
           @if (has_gateway('cash', $user->id))
            <div class="form-group custom mt-5">
              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('Cash on delivery') }}</span>
                <small class="d-block mt-2">{{ __('Enable or disable cash on delivery.') }}</small>
              </label>
               <div class="form-control-wrap">
                <select name="gateway_cash_status" class="form-select" data-search="on" data-ui="lg">
                  <option value="0" {{ user('gateway.cash_status') == '0' ? 'selected' : '' }}>{{ __('Disable') }}</option>

                  <option value="1" {{ user('gateway.cash_status') == '1' ? 'selected' : '' }}>{{ __('Enable') }}</option>
                </select>
               </div>
            </div>
            @endif
          </div>
        @if (license('license') == 'Extended License')
          <div class="col-md-6">
           @if (has_gateway('stripe', $user->id))
            <div class="form-group custom mt-5">
              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('Stripe') }}</span>
                <small class="d-block mt-2">{{ __('Input your stripe client and secret keys or leave empty to disable') }}</small>
              </label>
               <div class="form-control-wrap">
                <input type="text" value="{{ user('gateway.stripe_client') }}" class="form-control form-control-lg" placeholder="Stripe client key" name="gateway_stripe_client">
               </div>
               <div class="form-control-wrap mt-3">
                <input type="text" value="{{ user('gateway.stripe_secret') }}" class="form-control form-control-lg" placeholder="Stripe secret key" name="gateway_stripe_secret">
               </div>
            </div>
            @endif
           @if (has_gateway('razor', $user->id))
            <div class="form-group custom mt-5">
              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('Razor pay') }}</span>
                <small class="d-block mt-2">{{ __('Input your razor key id and secret keys or leave empty to disable') }}</small>
              </label>
               <div class="form-control-wrap">
                <input type="text" value="{{ user('gateway.razor_key_id') }}" class="form-control form-control-lg" placeholder="Razor client key" name="gateway_razor_key_id">
               </div>
               <div class="form-control-wrap mt-3">
                <input type="text" value="{{ user('gateway.razor_secret_key') }}" class="form-control form-control-lg" placeholder="Razor secret key" name="gateway_razor_secret_key">
               </div>
            </div>
            @endif
           @if (has_gateway('midtrans', $user->id))
            <div class="form-group mt-5 custom">
              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('MidTrans') }}</span>
                <small class="d-block mt-2">{{ __('Enter your midtrans client key and server key or leave empty to disable') }}</small>
              </label>
              <select name="gateway_midtrans_mode" class="form-select" data-search="on" data-ui="lg">
                <option value="live" {{ user('gateway.midtrans_mode') == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                <option value="sandbox" {{ user('gateway.midtrans_mode') == 'sandbox' ? 'selected' : '' }}>{{ __('Sandbox') }}</option>
              </select>
              <div class="form-control-wrap mt-3">
               <input type="text" value="{{ user('gateway.midtrans_client_key') }}" class="form-control form-control-lg" placeholder="MidTrans client id" name="gateway_midtrans_client_key">
              </div>
              <div class="form-control-wrap mt-3">
               <input type="text" value="{{ user('gateway.midtrans_server_key') }}" class="form-control form-control-lg" placeholder="MidTrans secret key" name="gateway_midtrans_server_key">
              </div>
           </div>
           @endif
           @if (has_gateway('mercadopago', $user->id))
            <div class="form-group mt-5 custom">
              <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                <span>{{ __('Mercadopago') }}</span>
                <small class="d-block mt-2">{{ __('Enter your mercadopago access token or leave empty to disable') }}</small>
              </label>
              <div class="form-control-wrap mt-3">
               <input type="text" value="{{ user('gateway.mercadopago_access_token') }}" class="form-control form-control-lg" placeholder="Mercadopago access token" name="gateway_mercadopago_access_token">
              </div>
           </div>
           @endif
          </div>
          @endif
        </div>
      </div>
          <div class="col-12 d-flex">
            <button class="btn btn-primary btn-block w-100 mt-5">{{ __('Save') }}</button>
          </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="select-template" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content bdrs-20">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                <h4 class="mb-4">{{ __('Templates') }}</h4>
                <div class="row">
                @foreach ($templates as $key => $items)
                  <label class="col-md-6 my-2 clov-radio-box">
                      <input type="radio" {{(!empty(user('extra.template')) && $items['name'] == user('extra.template')) ? "checked" : ""}} name="extra_template" value="{{ $items['name'] ?? '' }}" class="custom-control-input">

                      <div class="card">
                          <div class="card-body d-md-flex align-items-center justify-content-between row">
                            <div class="d-flex flex-column col-md-8 order-2">
                              <div>
                              </div>
                            </div>

                              <div class="template-img p-0 pl-3 pl-md-2 order-1">
                                  <h5 class="card-title mb-3 bold text-white fw-bold upper">{{ $items['title'] ?? '' }}</h5>
                                  <p class="upper text-white fs-14px">{{ $items['description'] ?? '' }}</p>
                                  <div class="d-flex align-items-center">
                                    <img src="{{ url('media/misc/' . $items['banner'] ?? '')}}" alt="">
                                    <div class="overlay-dark"></div>
                                  </div>
                              </div>

                          </div>
                      </div>
                  </label>
                @endforeach
                </div>
                <button class="btn btn-primary btn-block mt-5 submit-closest text-white">{{ __('Save') }} <em class="icon ni ni-edit"></em></button>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div>
    </form>
  </div>
@stop