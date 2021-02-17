@extends('profile.layouts.app')
@section('content')
  <!-- section -->
  <section class="container banner mx-auto">
    <div class="intro-header">
          <div class="intro_img shimmer shimmer-intro-img-1">
         @if (!empty(request()->get('category')) && $ca_banner = \App\Model\Product_Category::where('slug', request()->get('category'))->first())
            <img src="{{ url('media/user/categories/'.$ca_banner->media) }}" alt=" " class="intro_img shimmer shimmer-product-img-2">
            @else
            <img src="{{ url('media/user/banner/'.user('media.banner', $uid)) }}" alt=" " class="intro_img shimmer shimmer-product-img-2">
          @endif
         </div>
         <div class="d-flex flex-column justify-center align-center flex-md-row intro-inner-footer between-center intro-inner-footer">
         @if (empty(request()->get('category')) && !$ca_banner = \App\Model\Product_Category::where('slug', request()->get('category'))->first())
           <div class="intro-name">
             <h4 class="shimmer shimmer-intro-text ml-md-3 d-block text-center d-md-none">{{ full_name($uid) }}</h4>
             <p class="shimmer shimmer-intro-text ml-md-3">{{user('extra.tagline', $uid)}}</p>
           </div>
           @else
           <div class="intro-name">
             <h5 class="shimmer shimmer-intro-text ml-md-3">{{ $ca_banner->title }}</h5>
           </div>
         @endif
         </div>
     </div>
  </section>
  <!-- end section -->

  <!-- section -->
  <section class="section">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <!-- section title -->
          <h2 class="section__title shimmer-text shimmer">{{ __('Catalog') }}</h2>
          <!-- end section title -->

          <!-- section sort -->
          <div class="section__sort">
            <button class="active shimmer-category shimmer" type="button" data-group="all">{{ __('All') }}</button> 
            @foreach($categories as $category)
              <button type="button" class="shimmer-category shimmer" data-group="{{$category->slug}}">{{ucfirst($category->title)}}</button>
            @endforeach
          </div>
          <!-- end section sort -->
        </div>
      </div>

      <!-- grid -->
      @if (!empty($productPaginate))
      <div class="row row--grid">
        @foreach($productPaginate as $product)
        <div class="col-12 col-md-6 col-lg-4" data-groups='["all", "{!! implode('", "', $product->categories) !!}"]'>
          <div class="product">
            @if (!empty($product->salePrice))
             <div class="tag">{{ __('On Sale') }}</div>
            @endif
          <a href="{{ Linker::url(route('user-profile-single-product', ['profile' => $user->username, 'id' => $product->id]), ['ref' => $user->username]) }}" class="product__img shimmer shimmer-product-img">
            <img src="{{ getfirstproductimg($product->id) }}" alt="" class="product__img shimmer shimmer-product-img-2">
          </a>
            <div class="product__wrap {{ (!empty($product->salePrice) ? 'onsale' : '') }}"> 
              <h3 class="product__title shimmer shimmer-product-text">{{ucfirst($product->title)}}</h3>
              <span class="product__price shimmer shimmer-product-text"><?= $user->currency ?>{{number_format($product->price)}}</span>
              @if (!empty($product->salePrice))
              <span class="product_saleprice d-block shimmer shimmer-product-text"><?= $user->currency ?>{{number_format($product->salePrice)}}</span>
              @endif

              <button class="product__add ajax_add_to_cart shimmer shimmer-product-cart" data-route="{{ route('user-add-to-cart', ['profile' => $user->username, 'id' => $product->id]) }}" data-qty="1" type="button" rel="nofollow">
                <i class="fad fa-shopping-cart zero"></i>
                <i class="far fa-plus-circle first"></i>
                <i class="far fa-check-circle second"></i>
              </button>
            </div>
          </div>
        </div>
        @endforeach
      </div>
        @else
        <div class="m-4">
          <h3 class="text-muted">No Product Found</h3>
        </div>
        @endif
      <!-- grid -->
    </div>
  </section>
  <!-- end section -->
  
  <!-- section -->
  <section class="section">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="shadow-big mb-4 p-3 bdrs-20">
            <!-- section title -->
            <h2 class="section__title shimmer shimmer-text">{{ __('About') }} {{user('name.first_name', $uid)}}</h2>
            <!-- end section title -->

            <!-- section text -->
            <div class="shimmer shimmer-about mt-3">
              <div class="section__text shimmer shimmer-about">{!! user('extra.about', $uid) !!}</div>
            </div>
          </div>
           @if (package('settings.social', $user->id))
          <div class="shadow-big bdrs-20 p-3">
           <div class="text-center d-flex justify-md-center">
            <ul class="socials d-flex">
              @foreach ($options->socials as $key => $items)
                @if (!empty($user->socials[$key]))
                 <li class="mx-2 mr-4">
                  <a class="text-muted intro-btn social fs-30px" target="_blank" href="{{(!empty($user->socials->{$key}) ? Linker::url(sprintf($items['address'], $user->socials->{$key}), ['ref' => $user->username]) : "")}}"><em class="icon ni ni-{{$items['icon']}}"></em></a>
                </li>
                @endif
              @endforeach
            </ul>
           </div>
          </div>
           @endif
        </div>
      </div>
    </div>
  </section>
  @stop