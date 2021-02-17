<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="pointer-event-0">
   <head>
      <title>{{ '@'.$user->username ?? '' }} - {{ env('APP_NAME') }}</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="stylesheet" type="text/css" href="{{asset('css/plugins.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('font/css/all.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('css/iziToast.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('profile/css/style.css')}}">
      <script type="text/javascript" src="{{asset('js/iziToast.js')}}"></script>
      <script src="{{ asset('js/bundle.js') }}"></script>
      @yield('headJs')
   </head>
   <body class="light">
      <!-- header -->
      <header class="header">
         <div class="container">
            <div class="row">
               <div class="col-12">
                  <div class="header__content m-0">
                     <span class="header__tagline-m p-1">
                        <div class="h-100">
                           <a class="text-black" href="{{ url($user->username) }}"></a>
                            <img src="{{ url('media/user/avatar/'.user('media.avatar', $uid)) }}" alt=" " class="intro_img shimmer shimmer-product-img-2">
                        </div>
                     </span>
                     <span class="header__tagline ml-3">
                        <a class="text-black" href="{{ url($user->username) }}">
                           <h4 class="shimmer shimmer-text d-block shadow-hh">{{ucfirst($user->name['first_name'] ?? '')}}</h4>
                        </a>
                     </span>
                     <a href="{{ route('user-profile-checkout', ['profile' => $user->username]) }}" class="header__cart shimmer shimmer-cart"><i class="far fa-shopping-basket"></i><span>{{ __('Cart') }} (<span class="cart-total m-0 d-unset">{{ count(!empty(Session::get('cart_'.$user->username)) ? Session::get('cart_'.$user->username) : []) }}</span>)</span></a>
                     <button class="header__search shimmer shimmer-cart" href="#" data-toggle="modal" data-target="#search-modal"><i class="fal fa-search"></i></button>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- end header -->
      @yield('content')
      <!-- footer -->
      <footer class="footer">
         <div class="container">
            <div class="row">
               <div class="col-12">
                  <div class="footer__content">
                     <h6 class="footer__copyright shimmer shimmer-text"><span class="m-0">©{{ __('Created with') }} <a href="{{ url('/') }}" target="_blank"><b>{{ env('APP_NAME') }}</b>.</a></span></h6>
                     <div class="footer__social">
                        <a class="facebook shimmer shimmer-footer-social" target="_blank" href="{{$user->facebook}}"><i class="fab fa-facebook"></i></a>
                        <a class="instagram shimmer shimmer-footer-social" target="_blank" href="{{$user->instagram}}"><i class="fab fa-instagram"></i></a>
                        <a class="twitter shimmer shimmer-footer-social" target="_blank" href="{{$user->twitter}}"><i class="fab fa-twitter"></i></a>
                        <a class="whatsapp mr-1 shimmer shimmer-footer-social" target="_blank" href="{{$user->whatsapp}}"><i class="fab fa-whatsapp"></i></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- end footer -->
  <div class="modal fade" tabindex="-1" role="dialog" id="search-modal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
              <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
              <div class="modal-body modal-body-lg">
                <form method="GET" action="{{ url("$user->username") }}">
                   @php 
                   $page = request()->get('page');
                   @endphp
                   @if (!empty($page))
                   <input type="hidden" name="page" value="{{$page}}">
                   @endif
                   <input class="search-input lg mb-4" type="search" placeholder="Search...." name="query" autofocus=""></input>
                   <div class="container">
                      <label class="m-3">{{ __('Categories') }}</label>
                      <select class="form-select" data-search="off" data-ui="lg" name="category">
                         <option value="">{{ __('None') }}</option>
                         @foreach($categories as $category)
                         <option value="{{$category->slug}}">{{$category->title}}</option>
                         @endforeach
                      </select>
                   </div>
                   <div class="container mt-3 d-flex">
                      <div class="row w-100">
                         <div class="form__group col-6">
                            <label class="m-3">{{ __('Min Price') }}</label>
                            <input type="text" value="{{$min_price}}" name="min-price" placeholder="{{ __('Min Price') }}">
                         </div>
                         <div class="form__group col-6">
                            <label class="m-3">{{ __('Max Price') }}</label>
                            <input type="text" value="{{$max_price}}" name="max-price" placeholder="{{ __('Max Price') }}">
                         </div>
                      </div>
                   </div>
                   <br><br>
                   <div class="container">
                      <button class="btn btn-primary btn-block mt-5" type="submit">{{ __('Search') }}</button>
                   </div>
                </form>
              </div><!-- .modal-body -->
          </div><!-- .modal-content -->
      </div><!-- .modal-dialog -->
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
      @yield('footerJs')
      <script type="text/javascript" src="{{asset('js/scripts.js')}}"></script>
      <script type="text/javascript" src="{{asset('profile/js/shuffle.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('profile/js/script.js')}}"></script>
      <script type="text/javascript" src="{{asset('js/custom.js')}}"></script>
   </body>
</html>