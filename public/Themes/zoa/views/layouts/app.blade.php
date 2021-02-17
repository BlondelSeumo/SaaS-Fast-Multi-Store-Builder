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

<body data-preloader="4" class="{{ profile_body_classes($user->id) }} stm-spacer-left">
 {!! ($user->background_type == "color") ? "<style> $background_color </style>" : "" !!}

<div class="if-is-mobile"></div>
<div class="sidebar-overlay"></div>

@php
  $cart = new \App\Cart;
  $cart = $cart->getAll($uid);
@endphp
<div class="search-form-wrapper header-search-form" id="search-product">
    <div class="container">
        <div class="search-results-wrapper">
            <div class="btn-search-close data-box" data-target="#search-product">
                <i class="ni ni-cross fs-20px"></i>
            </div>
        </div>
        <form method="get" action="{{ route('user-profile-products', ['profile' => $user->username]) }}" role="search" class="mt-8">
                @if (!empty(request()->get('page')))
                <input type="hidden" name="page" value="{{request()->get('page')}}">
                @endif
            <div class="col-md-12 mb-0">
              <div class="form-group">
                <input type="text" class="search-input" name="query" value="{{ request()->get('query') }}" placeholder="{{ __('Search') }}">
              </div>
            </div>
            <div class="col-md-12 row">
              <div class="form-group col-6">
                <label class="m-3">{{ __('Min Price') }}</label>
                <input type="text" class="search-input" name="min-price" value="{{ $min_price }}" placeholder="{{ __('Min Price') }}">
              </div>
              <div class="form-group col-6">
                <label class="m-3">{{ __('Max Price') }}</label>
                <input type="text" class="search-input" name="max-price" value="{{ $max_price }}" placeholder="{{ __('Max Price') }}">
              </div>
            </div>
            <div class="col-md-12">
              <label class="m-3">{{ __('Category') }}</label>
              <select class="custom-select w-100" name="category">
                <option value="">{{ __('None') }}</option>
                @foreach($categories as $category)
                <option value="{{$category->slug}}" {{ request()->get('category') == $category->slug ? 'selected' : '' }}>{{$category->title}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <button class="button smoothscroll justify-center button-lg mt-0 align-items-center theme-btn d-flex w-100">{{ __('Search') }}</button>
            </div>
        </form>
    </div>
</div>

 <div class="page-left-sidebar card-shadow" data-simplebar>
  <div class="navbar-wrapper">
        <div class="sidebar-menu-top">
            <div class="zoa-logo mb-4">
                <a href="{{ route('user-profile', ['profile' => $user->username]) }}">
                  <img src="{{ avatar($uid) }}" alt="" class="img-reponsive">
                </a>
              </div>
            <div class="topbar-left">
                <div class="element element-search hidden-xs hidden-sm">
                    <a href="#" class="search-toggle data-box" data-target="#search-product">
                        <i class="ni ni-search fs-15px"></i>
                    </a>
                </div>
                <div class="element element-cart">
                    <a href="{{ route('user-profile-checkout', ['profile' => $user->username]) }}" class="icon-cart">
                      <i class="ni ni-cart fs-15px"></i>
                      <span class="count cart-count cart-total">{{count($cart)}}</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu-middle">
            <ul class="nav navbar-nav js-menubar hidden-xs hidden-sm">
                 <li><a href="{{ route('user-profile', ['profile' => $user->username]) }}" class="m-link">{{ __('Home') }}</a></li>
                  @if (!empty(user('extra.about', $uid)))
                  <li><a href="{{ route('user-profile-about', ['profile' => $user->username]) }}" class="m-link">{{ __('About') }}</a></li>
                  @endif
                  <li><a href="{{ route('user-profile-products', ['profile' => $user->username]) }}" class="m-link">{{ __('Products') }}</a></li>
                  <li><a href="{{ route('user-profile-categories', ['profile' => $user->username]) }}" class="m-link">{{ __('Categories') }}</a></li>
                  @if (count(store_blogs($uid, 3)) > 0)
                  <li><a href="{{ route('user-profile-blog', ['profile' => $user->username]) }}" class="m-link">{{ __('Blog') }}</a></li>
                  @endif
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="sidebar-menu-bottom">
            <ul class="sidebar-menu-link">
                <li><a href="{{ route('user-profile-orders', $user->username) }}">{{ __('Orders') }}</a></li>
                <li><a href="mailto: {{ $user->email }}">{{ __('Contact') }}</a></li>
            </ul>
            @if (package('settings.social', $uid))
            <div class="social">
                @foreach ($options->socials as $key => $items)
                  @if (!empty($user->socials[$key]))
                  <a href="{{(!empty($user->socials[$key]) ? Linker::url(sprintf($items['address'], $user->socials[$key]), ['ref' => $user->username]) : "")}}"><i class="icon ni ni-{{$items['icon']}}"></i></a>
                  @endif
                @endforeach
            </div>
            @endif

            <div class="sidebar-copyright">
                <p>{{'© ' . date('Y')}} <a href="{{ url('/') }}">{{ ucfirst(config('app.name')) }}</a>. {{ __('All rights reserved') }}. </p>
            </div>
            @if (!package('settings.custom_branding', $uid))
              <ul class="list-inline-dash mt-3">
                <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
              </ul>
            @endif
        </div>
    </div>
</div>





        
    <div class="wrapper pt-lg-4">
      <header id="header" class="d-block d-lg-none header-v1 py-3 border-0 card-shadow mb-4">
            <div class="header-center border-0">
                <div class="container container-content">
                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-md-4 col">
                            <div class="topbar-right">
                                <div class="element">
                                    <a href="#" class="icon-pushmenu js-push-menu">
                                       <i class="ni ni-menu fs-20px"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col d-flex justify-content-center">
                        <div class="zoa-logo">
                            <a href="{{ route('user-profile', ['profile' => $user->username]) }}">
                              <img src="{{ avatar($uid) }}" alt="" class="img-reponsive">
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4 col d-flex justify-content-end">
                            <div class="topbar-left">
                                <div class="element element-search hidden-xs hidden-sm">
                                    <a href="#" class="search-toggle data-box" data-target="#search-product">
                                       <i class="ni ni-search fs-20px"></i>
                                    </a>
                                </div>
                                <div class="element element-cart">
                                    <a href="{{ route('user-profile-checkout', ['profile' => $user->username]) }}" class="icon-cart">
                                       <i class="ni ni-cart fs-20px"></i>
                                        <span class="count cart-count cart-total">{{ count($cart) }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>


      <!-- Scroll to Top -->
      <div class="scrolltotop">
        <a class="button-circle button-circle-sm button-circle-black" href="#"><i class="ti-arrow-up"></i></a>
      </div>
      <!-- end Scroll to Top -->

      @if (!package('settings.ads', $uid) && settings('ads.enabled'))
        {!! settings('ads.store_header') !!}
      @endif
       @yield('content')
      @if (!package('settings.ads', $uid) && settings('ads.enabled'))
        {!! settings('ads.store_footer') !!}
      @endif

      <div class="section" id="footer">
          <div class="container">
            <div class="row text-center">
              <div class="col-12">
                  @if (!package('settings.custom_branding', $uid))
                   <h3>{{'© ' . date('Y')}} <a href="{{ url('/') }}">{{ ucfirst(config('app.name')) }}</a></h3>
                     @else
                     @if (package('settings.custom_branding', $uid))
                      @if (!empty(user('extra.custom_branding', $uid)))
                       <h3>{{'© ' . date('Y') .' '. (!empty(user('extra.custom_branding', $uid)) ? user('extra.custom_branding', $uid) : "")}}</h3>
                      @endif
                     @endif
                  @endif
              </div>
            </div><!-- end row -->
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
    <script src="{{ asset('slick/slick.min.js') }}"></script>
    @foreach(['plugins/plugins', 'js/functions.min', 'js/script'] as $file)
     <script src="{{ themes($file . '.js?v=' . env('APP_VERSION')) }}" type="text/javascript"></script>
    @endforeach
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
