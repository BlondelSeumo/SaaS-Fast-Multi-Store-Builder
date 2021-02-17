@extends('profile.layouts.app')
@section('headJs')
<link rel="stylesheet" type="text/css" href="{{ url('slick/slick.css') }}"/>
      <link rel="stylesheet" type="text/css" href="{{ url('slick/slick-theme.css') }}"/>
      <script type="text/javascript" src="{{ url('slick/slick.min.js') }}"></script>
@stop
@section('footerJs')
<script>
  $('.product_image').slick({
    autoplay: true,
    autoplaySpeed: 2000,
  });
</script>
@stop
 @section('content')
    <div class="container c-contain">
      <div class="row mt-5">
          <div class="col-lg-5 form__cover">
              <div class="row">
                  <div class="col-12">
                    <div class="container-fluid m-auto">
                      <div class="box-1 align-center flex-column h-100">
                      <div class="slider product_image w-100">
                        @foreach ($product->media as $image)
                        <div>
                          <img src="{{url('media/user/products/' . $image)}}" class="h-40vh object-center w-100 br-20">
                        </div>
                        @endforeach
                      </div>
                        <div class="p-3 w-100">
                          <h4 class="heading-title shimmer shimmer-text">{{$product->title}}</h4>
                          <p class="heading-text shimmer shimmer-text w-100 mb-2"><?= $user->currency ?>{{number_format($product->price)}}</p> 
                          <p class="heading-text shimmer shimmer-text w-100"> @foreach ($product->categories as $item)
                            @php
                              if($category = \App\Model\Product_Category::where('slug', $item)->first()):
                                echo '<a class="text-transparent" href="'. url( $user->username . '?category=') .'">'. $category->title .'</a> </p> ';
                              endif;
                            @endphp
                            @endforeach
                            @if (!empty($product->external_url))
                              <a href="{{ url("$product->external_url") }}" class="rounded-pill btn btn-primary-w-100">{{ __('Get this on') }} {{ $product->external_url_name }}</a>
                            @else
                          <div class="d-flex between-center mt-4">
                              <div class="shop-number-inc m-0">
                                <span class="minus shimmer shimmer-btn">-</span>
                                <input type="text" class="shimmer shimmer-btn" value="1"/>
                                <span class="plus shimmer shimmer-btn">+</span>
                              </div>
                            <div>
                              <a data-qty="1" data-route="{{ route('user-add-to-cart', ['profile' => $user->username, 'id' => $product->id]) }}" data-id="{{$product->id}}" data-pio="{{$user->id}}" class="ajax_add_to_cart shimmer shimmer-btn btn btn-primary w-250px mt-2">
                                <h6 class="zero text-white mt-1">{{ __('Add to cart') }}</h6>
                                <i class="far fa-times-circle first text-white"></i>
                                <i class="far fa-check-circle second text-white"></i>
                                </a>
                            </div>
                           </div>
                          @endif
                        </div>
                        </p>
                      </div>
                    </div>
                  </div>
              </div>
          </div>

          <div class="col-lg-7 form__content mt-5">
              <section id="sec1">
                 <div class="container-fluid m-auto">
                    <ul class="table-careers">
                       <h4 class="text-muted shimmer shimmer-text">{{ __('Description') }}</h4>
                        <li class="br-20">
                          <span class="position bold shimmer shimmer-about">{!! clean($product->description) !!}</span>
                        </li>
                        @if (!empty($product->extra->shipping))
                        <li class="br-20">
                          <p class="d-block shimmer shimmer-about">{{ __('Shipping locations') }}</p>
                          <span class="d-inline position bold shimmer shimmer-about">{{ str_replace(',', ' , ', $product->extra->shipping ?? '') }}</span>
                        </li>
                        @endif
                        <li class="br-20">
                         <div id="respond" class="comment-respond">
                          <div class="uk-child-width-1-2 uk-grid">
                            <div>
                              <h3 id="reply-title" class="comment-reply-title text-muted shimmer shimmer-text">{{ __('Add a review') }}</h3>
                            </div> 
                            <div>
                              <a href="{{ route('user-profile-product-review', ['profile' => $user->username, 'id' => $product->id]) }}" class="mt-0 btn btn-primary mb-3 btn-block w-100 shimmer shimmer-btn">{{ __('Reviews') }} ({{$reviews}})</a>
                            </div> 
                           </div>
                            <form action="{{ route('user-profile-product-review-post', ['profile' => $user->username, 'id' => $product->id]) }}" method="post" class="comment-form">
                               @csrf
                               <label for="rating text-muted" class="shimmer shimmer-text"><h5 class="text-muted shimmer shimmer-none">{{ __('Your rating') }}</h5></label>
                               <div class="comment-form-rating shimmer shimmer-text mb-6">
                                    <div class="rating shimmer shimmer-none">
                                        <span><input type="radio" name="rating" id="str5" value="5"><label for="str5"><i class="fad fa-star"></i></label></span>
                                        <span><input type="radio" name="rating" id="str4" value="4"><label for="str4"><i class="fad fa-star"></i></label></span>
                                        <span><input type="radio" name="rating" id="str3" value="3"><label for="str3"><i class="fad fa-star"></i></label></span>
                                        <span><input type="radio" name="rating" id="str2" value="2"><label for="str2"><i class="fad fa-star"></i></label></span>
                                        <span class="checked"><input type="radio" name="rating" checked="" id="str1" value="1"><label for="str1"><i class="fad fa-star"></i></label></span>
                                    </div>
                               </div>
                               <div class="form__group">
                                   <textarea class="form-control shimmer shimmer-btn" name="review" placeholder="Write a description"></textarea>
                               </div>
                               <div class="row">
                                  <div class="col-6">
                                     <div class="form__group">
                                        <input class="form-control shimmer shimmer-btn" placeholder="Name" name="name" type="text">
                                    </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="form__group">
                                        <input class="form-control shimmer shimmer-btn" placeholder="Email" name="email" type="text">
                                    </div>
                                  </div>
                               </div>
                            <button name="submit" type="submit" id="submit" class="btn btn-primary btn-block btn-lg mt-4 shimmer shimmer-btn"/>{{ __('Add Reviews') }}</button>
                            </form>
                        </div>
                        </li>
                    </ul>

                 </div>
              </section>
          </div>
      </div>
    </div>
@stop