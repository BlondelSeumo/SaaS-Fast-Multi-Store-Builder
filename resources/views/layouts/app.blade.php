<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name') }}</title>
    @if(!empty(settings('favicon')))
        <link href="{{ url('media/favicon/' . settings('favicon')) }}" rel="shortcut icon" type="image/png" />
    @endif
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Styles --> 
    @foreach(['bootstrap.css', 'front.css', 'home.css', 'app.css'] as $file)
    <link href="{{ asset('css/' . $file . '?v=' . env('APP_VERSION')) }}" rel="stylesheet">
    @endforeach
    <!-- Scripts -->
    <script src="{{ asset('js/bundle.js') }}"></script>
    @yield('headJS')
    @if (settings('custom_code.enabled'))
      {!! settings('custom_code.head') !!}
    @endif
</head>
<body class="{{ (request()->path() == '/' ? 'index-body bg-white' : '') }}" id="body">
   @if (session()->get('admin_overhead') && user('role') == 0)
    <div class="topbar admin-bar">
            <div class="d-flex align-items-center w-50">
              <h6 class="mr-4 text-white mb-0">{{ __('Admin') }}</h6>
              <form action="{{ route('admin-login-user') }}" method="post" class="d-flex w-100">
                @csrf
                <input type="hidden" name="id" value="{{ user('id') }}">
                <select name="loginasuser" class="form-select" data-search="off" data-ui="sm">
                  @foreach (\App\User::get() as $item)
                    <option value="{{$item->id}}" {{ user('id') == $item->id ? 'selected' : '' }}>{{ $item->username }}</option>
                  @endforeach
                </select>
                <button class="text-white bg-transparent border-0 ml-3">{{ __('Login') }}</button>
              </form>
            </div>
            <div class="">
               <form method="post" action="{{ url('logout') }}">
                 @csrf
                 <input type="hidden" name="returnAdmin" value="nothing here">
                  <button class="btn text-white"><em class="icon ni ni-signout"></em></button>
              </form>
            </div>
    </div>
    @endif
    <!-- Static navbar -->


  @if (Auth::check() && request()->path() !== '/' && request()->path() !== 'pricing')
        <div class="clov-sidebar" data-content="sidebarMenu" data-simplebar>
            <div class="clov-sidebar-inner">
                <ul class="accordion-menu">
                    <li class="sidebar-title">
                        {{ __('Menu') }}
                    </li>
                    <li>
                        <a href="{{ route('user-dashboard') }}"><i class="icon ni ni-dashboard"></i>{{ __('Dashbord') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('user-settings') }}"><i class="icon ni ni-setting"></i>{{ __('Settings') }}</a>
                    </li>
                    <li class="sidebar-title">
                        {{ __('Products') }}
                    </li>
                    <li>
                        <a href="{{ route('user-products') }}"><i class="icon ni ni-package"></i>{{ __('All Products') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('user-add-product') }}"><i class="icon ni ni-package"></i>{{ __('Add Products') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('user-product-category') }}"><i class="icon ni ni-package"></i>{{ __('Categories') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('user-orders') }}"><i class="icon ni ni-bag"></i>{{ __('Orders') }}</a>
                    </li>
                    <li class="sidebar-title">
                        {{ __('Stats') }}
                    </li>
                    <li>
                        <a href="{{ route('stats') }}"><i class="icon ni ni-chart-up"></i>{{ __('Store Visits') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('stats', ['type' => 'links']) }}"><i class="icon ni ni-chart-up"></i>{{ __('Link Clicks') }}</a>
                    </li>
                    <li class="sidebar-title">
                        {{ __('Orders') }}
                    </li>
                    <li>
                        <a href="{{ route('user-shipping') }}"><i class="icon ni ni-package-fill"></i>{{ __('Shipping') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('user-blog') }}"><i class="icon ni ni-briefcase"></i>{{ __('Blog') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('user-domains') }}"><i class="icon ni ni-globe"></i>{{ __('Domains') }}</a>
                    </li>
                    <li>
                        <a href="{{ $profile_url }}"><i class="icon ni ni-template"></i>{{ __('View Store') }}</a>
                    </li>
                </ul>
            </div>
        </div>
        
  <div class="nk-sidebar d-none nk-sidebar-fixed"></div>

  @endif
    <!-- Navbar End -->
    <div class="nk-wrap">
        <div class="container-lg max-1150px">
          <div class="nk-header nk-header-fluid border-0 bg-transparent pt-4">
             @include('layouts.guestMenu')
           </div>
          <div id="ecom">
            @if (Auth::check() && !package('settings.ads') && settings('ads.enabled'))
              <div class="mt-8">{!! settings('ads.site_header') !!}</div>
            @endif
             @yield('content')
            @if (Auth::check() && !package('settings.ads') && settings('ads.enabled'))
              {!! settings('ads.site_footer') !!}
            @endif
          </div>
        </div>
    </div>
    <!-- START FOOTER -->
    <div class="{{ request()->path() !== '/' && request()->path() !== 'pricing' ? 'nk-wrap min-vh-65' : '' }}">
      <div class="{{ request()->path() !== '/' && request()->path() !== 'pricing' ? 'container-lg' : '' }}">
    <footer class="defalut-footer light padding-py-12">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
            <div class="item_about">
              <a class="logo" href="{{ url('/') }}">
                <img src="{{ url('media/logo/' . settings('logo')) }}" alt="">
              </a>
              <p>
                {{ __('Own a simple and elegant storefront with us today.') }}
              </p>
              <div class="address">
                <span>{{settings('location')}}</span>
                <span>{{ __('Email us:') }} <a href="mailto:{{settings('email')}}">{{settings('email')}}</a></span>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-6 col-lg-3">
            <div class="item_links">
              <h4>{{ __('Social') }}</h4>
              @if (!empty(settings('social.facebook')))
              <a class="nav-link" href="{{(!empty(settings('social.facebook')) ? url('https://facebook.com/' . settings('social.facebook')) : "")}}">{{ __('Facebook') }}</a>
              @endif
              @if (!empty(settings('social.whatsapp')))
              <a class="nav-link" href="{{(!empty(settings('social.whatsapp')) ? url('https://wa.me/' . settings('social.whatsapp')) : "")}}">{{ __('Whatsapp') }}</a>
              @endif
              @if (!empty(settings('social.twitter')))
              <a class="nav-link" href="{{(!empty(settings('social.twitter')) ? url('https://twitter.com/' . settings('social.twitter')) : "")}}">{{ __('Twitter') }}</a>
              @endif
              @if (!empty(settings('social.instagram')))
              <a class="nav-link" href="{{(!empty(settings('social.instagram')) ? url('https://instagram.com/' . settings('social.instagram')) : "")}}">{{ __('Instagram') }}</a>
              @endif
              @if (!empty(settings('social.youtube')))
              <a class="nav-link" href="{{(!empty(settings('social.youtube')) ? url('https://youtube.com/channel/' . settings('social.youtube')) : "")}}">{{ __('Youtube') }}</a>
              @endif
            </div>
          </div>
          <div class="col-6 col-md-6 col-lg-3">
            <div class="item_links">
              <h4>{{ __('Pages') }}</h4>
               @foreach ($allPages as $item)
                <a class="nav-link" href="{{$item->type == 'internal' ? url('page/' . $item->url) : $item->url}}" target="{{ $item->type == 'internal' ? '_self' : '_blank' }}">{{ ucfirst($item->title) }}</a>
              @endforeach
            </div>
          </div>
        </div>
        <div class="col-12 text-center padding-t-4">
          <div class="copyright">
            <span>© {{ date('Y') }}
              {{ env('APP_NAME') }}
              {{ __('All Right Reseved') }}</span>
          </div>
        </div>
      </div>
    </footer>
      </div>
    </div>
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
    <!-- END FOOTER -->
    @yield('footerJS')
    @foreach(['custom.js', 'scripts.js'] as $file)
    <script src="{{ asset('js/' .$file. '?v=' . env('APP_VERSION')) }}"></script>
    @endforeach
</body>
</html>
