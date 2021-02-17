@extends('profile.layouts.app')
 @section('content')
    <div class="container c-contain">
      <div class="row mt-5">
          <div class="col-12 col-md-5 form__cover">
            <div class="container-fluid m-auto">
              <div class="box-1 p-5 h-100">
                  <h3 class="heading-title shimmer shimmer-text">{{ __('Reviews for') }}</h3>
                  <h5 class="heading-title shimmer shimmer-text w-75"><a class="text-transparent" href="{{ url($user->username .'/product/'. $product->id) }}">{{$product->title}}</a></h5>
                  <p class="heading-text shimmer shimmer-text w-100"><?= $user->currency ?>{{number_format($product->price)}}</p> 
                  @php
                    $rating = number_format($reviews->avg('rating'), 1);
                  @endphp
                  @foreach (range(1,5) as $i)
                  <span class="fa-stack m-0" style="width: 1em;">
                    <i class="far fa-star fa-stack-1x"></i>
                    @if ($rating > 0)
                      @if ($rating > 0.5)
                      <i class="fas fa-star fa-stack-1x"></i>
                      @else
                      <i class="fas fa-star-half fa-stack-1x"></i>
                      @endif
                    @endif
                    @php
                      $rating--;
                    @endphp
                  </span>
                  @endforeach
                  <div class="d-flex between-center mt-4">
                      <div class="shop-number-inc mt-0">
                        <span class="minus">-</span>
                        <input type="text" value="1"/>
                        <span class="plus">+</span>
                      </div>
                    <div>
                      <a data-qty="1" data-id="{{$product->id}}" class="ajax_add_to_cart btn btn-primary mt-2">
                          <h6 class="zero text-white mt-1">{{ __('Add to cart') }}</h6>
                          <i class="far fa-times-circle first text-white"></i>
                          <i class="far fa-check-circle second text-white"></i>
                        </a>
                    </div> 
                 </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-7 form__content mt-5">
             <div class="container-fluid m-auto">
               <ul class="table-reviews row">
                @if (empty($reviews))
                <div class="h-100">
                  <h3>Nothing here</h3>
                </div>
                @endif
                @foreach($reviews as $review)
                <div class="col-md-6">
                 <div class="table-reviews-inner">
                   <li class="shimmer-load mb-3">
                      <img src="{{ productReviewImage($review->id) }}" class="product_page-img">
                   </li>
                     <span class="position bold text-left title">{{$review->review->name ?? ''}}</span>
                     <br>
                     <span class="position bold text-left card-rating" data-rating="{{$review->rating}}"> </span><br>
                     <span class="position bold text-left date">{{Carbon\Carbon::parse($review->created_at)->diffForHumans()}}</span>
                   <p>{{$review->review->review ?? ''}}</p>
                  </div>
                </div>
                  @endforeach
               </ul>
             </div>
          </div>
      </div>
    </div>
@stop