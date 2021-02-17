@foreach($single_product as $product)
@php
    $user = DB::table('users')->where([['id', '=', $product->user]])->first();
@endphp

@extends('profile.master')
 @section('title', ucfirst($user->name))
 @section('content')
        @section('content')
    <div class="container">
      <div class="row mt-5">
          <div class="col-12 col-md-5 form__cover">
              <div class="row">
                  <div class="col-12 col-sm-6 col-md-12">
                    <div class="container-fluid m-auto">
                      <div class="box-1 align-center h-100">
                        <div class="p-4">
                          <h4 class="heading-title shimmer shimmer-text">Reviews for </h4>
                          <h2 class="heading-title shimmer shimmer-text w-75"><a class="text-transparent" href="{{ url($user->store_url .'/product/'. $product->id) }}">{{$product->name}}</a></h2>
                          <p class="heading-text shimmer shimmer-text w-100"><?= $user->currency ?>{{number_format($product->price)}}</p> 
                          <div class="uk-child-width-1-2@s uk-grid">
                            <div>
                              <div class="shop-number-inc">
                                <span class="minus">-</span>
                                <input type="text" value="1"/>
                                <span class="plus">+</span>
                              </div>
                            </div> 
                            <div>
                              <a data-qty="1" data-id="{{$product->id}}" data-pio="{{$user->id}}" class="ajax_add_to_cart roov-btn-2">
                                  <h6 class="zero text-white mt-1">Add to cart</h6>
                                  <i class="far fa-times-circle first"></i>
                                  <i class="far fa-check-circle second"></i>
                                </a>
                            </div> 
                           </div>
                        </div>
                        </p>
                      </div>
                    </div>
                  </div>
              </div>
          </div>

          <div class="col-12 col-md-7 form__content mt-5">
              <section id="sec1">
                 
                  <div class="container-fluid m-auto">
                    <ul class="table-reviews">
                     @foreach($reviews as $review)
                     <div class="table-reviews-inner">
                        <li class="shimmer-load mb-3">
                           <img src="{{ url('images/default-avatar.jpg') }}" class="product_page-img">
                        </li>
                          <span class="position bold text-left title">{{ucfirst($review->name)}}</span>
                          <br>
                          <span class="position bold text-left card-rating" data-rating="3"> </span><br>
                          <span class="position bold text-left date">{{Carbon\Carbon::parse($review->date)->diffForHumans()}}</span>
                        <p>{{$review->review}}</p>
                       </div>
                       @endforeach
                    </ul>

                  </div>
              </section>
          </div>
      </div>
    </div>
 @endforeach
@stop