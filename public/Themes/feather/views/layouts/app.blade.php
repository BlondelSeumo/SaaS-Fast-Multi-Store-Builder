<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js one-page-layout" data-click-ripple-animation="yes">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{'@'.$user->username}} - {{ env('APP_NAME') }}</title>
    @if(!empty(settings('favicon')))
        <link href="{!! url('media/favicon/' . settings('favicon')) !!}" rel="shortcut icon" type="image/png" />
    @endif

    <!-- Fonts -->

    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;700&family=Unna:ital,wght@0,400;1,700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css?v=' . env('APP_VERSION')) }}" rel="stylesheet">
    <link href="{{ asset('css/app.css?v=' . env('APP_VERSION')) }}" rel="stylesheet">
    <!-- Styles -->
    @foreach(['plugins/magnific-popup/magnific-popup.min', 'plugins/owl-carousel/owl.carousel.min', 'plugins/owl-carousel/owl.theme.default.min', 'plugins/justified-gallery/justified-gallery.min', 'plugins/sal/sal.min', 'css/main', 'css/custom', 'plugins/themify/themify-icons.min', 'plugins/simple-line-icons/css/simple-line-icons'] as $file)
     <link href="{{ themes($file . '.css?v=' . env('APP_VERSION')) }}" rel="stylesheet">
    @endforeach
     <link href="{{ asset('font/css/all.css?v=' . env('APP_VERSION')) }}" rel="stylesheet">
    @foreach(['bundle'] as $file)
     <script src="{{ asset('js/' . $file . '.js?v=' . env('APP_VERSION')) }}" type="text/javascript"></script>
    @endforeach

   {!! profile_analytics($user->id) !!}
</head>

{{ custom_code() }}

<body data-preloader="3" class="{{ profile_body_classes($user->id) }}">
 {!! ($user->background_type == "color") ? "<style> $background_color </style>" : "" !!}

@php
  $cart = new \App\Cart;
  $cart = $cart->getAll($uid);
@endphp

    <div class="wrapper">
      <!-- Scroll to Top -->
      <div class="scrolltotop">
        <a class="button-circle button-circle-sm button-circle-black" href="#"><i class="ti-arrow-up"></i></a>
      </div>
      <!-- end Scroll to Top -->

      <!-- Header -->
      <div class="header absolute-dark">
        <div class="container">
          <div class="logo">
            <h4 class="uppercase letter-spacing-2"><a href="{{ route('user-profile', ['profile' => $user->username]) }}">{{ user('name.first_name', $uid) }} {!! (!empty($package->settings->verified) && $package->settings->verified || $user->verified) ? '<em class="icon ni ni-check-circle"></em>' : ''!!}</a></h4>
          </div>
          <div class="header-menu-wrapper">
            <!-- Menu -->
            <ul class="header-menu dropdown-dark">
              <li class="m-item mr-3"><a href="{{ route('user-profile', ['profile' => $user->username]) }}" class="m-link">{{ __('Home') }}</a></li>
              @if (!empty(user('extra.about', $uid)))
              <li class="m-item mr-3"><a href="{{ route('user-profile-about', ['profile' => $user->username]) }}" class="m-link">{{ __('About') }}</a></li>
              @endif
              <li class="m-item mr-3"><a href="{{ route('user-profile-products', ['profile' => $user->username]) }}" class="m-link">{{ __('Products') }}</a></li>
              @if (count(store_blogs($uid, 3)) > 0)
              <li class="m-item mr-3"><a href="{{ route('user-profile-blog', ['profile' => $user->username]) }}" class="m-link">{{ __('Blog') }}</a></li>
              @endif
              <li class="m-item mr-3"><a href="#footer" class="m-link smoothscroll">{{ __('Contact') }}</a></li>
            </ul>
            <div class="header-menu-extra d-lg-inline-block d-none">
              <ul class="list-inline">
                <li><a href="{{ route('user-profile-checkout', ['profile' => $user->username]) }}"><i class="fas fa-shopping-cart"></i></a></li>
              </ul>
            </div>
            <!-- Extra -->
            <div class="header-menu-extra d-lg-none">
                  @if (package('settings.social', $uid))
                  <ul class="list-inline">
                    @foreach ($options->socials as $key => $items)
                      @if (!empty($user->socials[$key]))
                      <li><a href="{{(!empty($user->socials[$key]) ? Linker::url(sprintf($items['address'], $user->socials[$key]), ['ref' => $user->username]) : "")}}"><i class="icon ni ni-{{$items['icon']}}"></i></a></li>
                      @endif
                    @endforeach
                  </ul>
                  @endif
            </div>
            <!-- Close Button -->
            <button class="close-button">
              <span></span>
            </button>
          </div><!-- end header-menu-wrapper -->
          <!-- Menu Toggle on Mobile -->
          <button class="m-toggle">
            <span></span>
          </button>
        </div><!-- end container -->
      </div>
      <!-- end Header -->
      @if (!package('settings.ads', $uid) && settings('ads.enabled'))
        {!! settings('ads.store_header') !!}
      @endif
       @yield('content')
      @if (!package('settings.ads', $uid) && settings('ads.enabled'))
        {!! settings('ads.store_footer') !!}
      @endif
      <!-- Footer -->
      <a href="{{ route('user-profile-checkout', ['profile' => $user->username]) }}" class="cart-icon">
        <div class="cart-icon-inner">
          <i class="ni ni-cart"></i>
           <span class="badge cart-total">{{ count($cart) }}</span>
        </div>
      </a>
      <aside class="floaty-bar" hidden>
        <div class="bar-actions">
          <div class="action-list">
            <a class="action-list-item" href="{{ route('user-profile', ['profile' => $user->username]) }}">
              <i class="ni ni-home"></i>
            </a>
          </div>
          <div class="action-list">
            <a class="action-list-item" href="#">
              <i class="ni ni-search"></i>
            </a>
          </div>
          <div class="action-list">
            <a class="action-list-item" href="{{ route('user-profile-checkout', ['profile' => $user->username]) }}">
              <span class="badge cart-total">{{ count($cart) }}</span>
              <i class="ni ni-cart"></i>
            </a>
          </div>
        </div>
      </aside>
      <div class="section offwhite_bg" id="footer">
          <div class="container">
            <div class="row text-center">
              <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
                <h3 class="uppercase letter-spacing-2">{{ full_name($uid) }}</h3>
                <p>{{ user('address', $uid) }}<br>{{ user('email', $uid) }}</p>
                  @if (package('settings.social', $uid))
                  <ul class="list-inline-sm margin-top-20">
                    @foreach ($options->socials as $key => $items)
                      @if (!empty($user->socials[$key]))
                      <li><a class="button-circle button-circle-sm button-circle-black" href="{{(!empty($user->socials[$key]) ? Linker::url(sprintf($items['address'], $user->socials[$key]), ['ref' => $user->username]) : "")}}"><i class="icon ni ni-{{$items['icon']}}"></i></a></li>
                      @endif
                    @endforeach
                  </ul>
                  @endif
              </div>
            </div><!-- end row -->
            <div class="border-top margin-top-40 padding-y-20 padding-bottom-0">
              <div class="row col-spacing-0">
                <div class="col-6">
                  @if (!package('settings.custom_branding', $uid))
                   <p>{{'© ' . date('Y')}} <a href="{{ url('/') }}">{{ ucfirst(config('app.name')) }}</a></p>
                     @else
                     @if (package('settings.custom_branding', $uid))
                      @if (!empty(user('extra.custom_branding', $uid)))
                       <p>{{'© ' . date('Y') .' '. (!empty(user('extra.custom_branding', $uid)) ? user('extra.custom_branding', $uid) : "")}}</p>
                      @endif
                     @endif
                  @endif
                </div>
                <div class="col-6 text-right">
                  @if (!package('settings.custom_branding', $uid))
                    <ul class="list-inline-dash">
                      <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                      <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                      <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    </ul>
                  @endif
                </div>
              </div><!-- end row -->
            </div>
          </div><!-- end container -->
        </div>
      <!-- end Footer -->
    </div><!-- end wrapper -->

    @if (!empty(Session::get('error')))
        <script>
            Swal.fire({
              title: 'Error!',
              text: '{{Session::get('error')}}',
              icon: 'error',
              confirmButtonText: 'OK'
            });
        </script>
    @endif
    @if (!empty(Session::get('success')))
        <script>
            Swal.fire({
              title: '{{Session::get('success')}}',
              icon: 'success',
              confirmButtonText: 'OK'
            });
        </script>
    @endif
    @if (!empty(Session::get('info')))
        <script>
            Swal.fire({
              title: '{{Session::get('info')}}',
              icon: 'info',
              confirmButtonText: 'OK'
            });
        </script>
    @endif
    @if(!$errors->isEmpty())
         @foreach ($errors->all() as $error)
            <script>
                Swal.fire({
                  title: '{{ $error }}',
                  icon: 'error',
                  confirmButtonText: 'OK'
                });
            </script>
         @endforeach
    @endif
    @foreach(['plugins/jquery.min', 'plugins/plugins', 'js/functions.min', 'js/script'] as $file)
     <script src="{{ themes($file . '.js?v=' . env('APP_VERSION')) }}" type="text/javascript"></script>
    @endforeach
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
