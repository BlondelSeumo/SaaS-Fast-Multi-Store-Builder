@foreach ($users as $user)

@extends('profile.master')
@section('title', ucfirst($user->name))
@section('content')
 @include('profile/menu')
    @include('profile/menu')

<div class="container">
   <div class="roov" style="margin-top: 10em;">
      <div class="shop">
         <div class="row masonry creative offset-three_columns" data-masonry-id="archive-products">
         @if (DB::table('products')->where('user', $user->id)->count() > 0)
           @foreach($products as $product)
             <div class="timeline-wrapper col-sm-6 col-xl-4">
               <div class="timeline-item">
                   <div class="animated-background">
                       <div class="background-masker header-top"></div>
                       <div class="background-masker header-left"></div>
                       <div class="background-masker header-right"></div>
                       <div class="background-masker header-bottom"></div>
                       <div class="background-masker subheader-left"></div>
                       <div class="background-masker subheader-right"></div>
                       <div class="background-masker subheader-bottom"></div>
                       <div class="background-masker content-top"></div>
                       <div class="background-masker content-first-end"></div>
                       <div class="background-masker content-second-line"></div>
                       <div class="background-masker content-second-end"></div>
                       <div class="background-masker content-third-line"></div>
                       <div class="background-masker content-third-end"></div>
                   </div>
               </div>
           </div>
            <div class="selector col-sm-6 col-xl-4 post-61 product type-product status-publish has-post-thumbnail product_cat-fashion product_tag-socks first instock sale shipping-taxable purchasable shimmer-load d-none">
                  <div class="product-holder">
                     <div class="product-inner_holder">
                        <div class="badge shadow on-sale">
                           <div class="badge-inner">
                             @if($product->product_condition == 1) None @endif @if($product->product_condition == 2) New @endif @if($product->product_condition == 3) Used @endif</div>
                        </div>
                        <div class="product-entry_overlay">
                           <a class="soma-link" href="{{url('product/' . $product->id)}}">
                              <div class="calculated-image" style="padding-bottom: 104.166667% !important;">
                                 <img width="1440" height="1500" src="{{url('images/product/'. $product->image)}}" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" sizes="(max-width: 1440px) 100vw, 1440px" />                    
                              </div>
                           </a>
                           <div class="product-overlay"></div>
                        </div>
                        <div class="product-overlay_wrap d-flex flex-column">
                           <h3 class="product-title"><a class="soma-link" href="{{url('product/' . $product->id)}}">{{$product->name}}</a></h3>
                           <div class="d-flex align-items-center mt-auto" style="z-index: 9">
                              <a tabindex="" data-id="{{$product->id}}" data-pio="{{$user->id}}" rel="nofollow" class="ajax_add_to_cart add_to_cart_button product_type_simple" data-qty="1">
                                 <span class="bag-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 18 24">
                                       </metadata> 
                                       <path id="bag" class="cls-1" d="M14,6V5A5,5,0,1,0,4,5V6H0V21a3,3,0,0,0,3,3H15a3,3,0,0,0,3-3V6H14ZM6,5a3,3,0,0,1,6,0V6H6V5ZM16,21a1,1,0,0,1-1,1H3a1,1,0,0,1-1-1V8H16V21Z"/>
                                       <rect x="4" y="14" width="10" height="2"/>
                                       <rect x="8" y="10" width="2" height="10"/>
                                    </svg>
                                 </span>
                                 <span class="checkbox-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="14" viewBox="0 0 20 14">
                                       </metadata> 
                                       <path id="check" class="cls-1" d="M6.992,13.992A1,1,0,0,1,6.285,13.7l-6-6A1,1,0,0,1,1.7,6.285l5.293,5.293L18.285,0.285A1,1,0,0,1,19.7,1.7l-12,12A1,1,0,0,1,6.992,13.992Z"/>
                                    </svg>
                                 </span>
                                 <span class="loader-icon rotating">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20" viewBox="0 0 24 20">
                                       </metadata> 
                                       <path id="repeat" class="cls-1" d="M24,2V8a1,1,0,0,1-1,1H17a1,1,0,0,1,0-2h3.372c-1.346-1.312-2.408-2.35-2.709-2.65l-0.007-.007a7.993,7.993,0,0,0-11.314,0c-0.067.067-.133,0.135-0.2,0.2A7.932,7.932,0,0,0,4.635,6.872c-0.056.157-.125,0.309-0.181,0.466a1,1,0,0,1-1.887-.661c0.076-.219.161-0.435,0.253-0.647A9.959,9.959,0,0,1,4.683,3.184q0.121-.13.246-0.255A9.959,9.959,0,0,1,10.091.183a10.025,10.025,0,0,1,5.672.549,9.935,9.935,0,0,1,3.309,2.2l0.015,0.015c0.321,0.32,1.476,1.449,2.914,2.85V2A1,1,0,0,1,24,2ZM1,19a1,1,0,0,0,1-1V14.206c1.438,1.4,2.594,2.53,2.914,2.85l0.015,0.015a9.959,9.959,0,0,0,5.162,2.746,10.035,10.035,0,0,0,5.672-.549,9.935,9.935,0,0,0,3.309-2.2q0.126-.125.246-0.255a9.959,9.959,0,0,0,1.863-2.845c0.092-.212.178-0.428,0.253-0.647a1,1,0,0,0-1.887-.661c-0.055.157-.125,0.309-0.181,0.466a8.057,8.057,0,0,1-4.355,4.286,7.993,7.993,0,0,1-8.668-1.758L6.336,15.65c-0.3-.3-1.363-1.338-2.708-2.65H7a1,1,0,0,0,0-2H1a1,1,0,0,0-1,1v6A1,1,0,0,0,1,19Z"/>
                                    </svg>
                                 </span>
                              </a>
                              <div class="ml-auto">
                                 <h4 class="price d-flex align-items-center">
                                    <ins><span class="roov-Price-amount amount"><span class="roov-Price-currencySymbol"><?= $user->currency ?></span>{{number_format($product->price)}}</span></ins>                    
                                 </h4>
                              </div>
                           </div>
                        </div>
                        <a class="soma-link" href="{{url('product/' . $product->id)}}"></a>
                     </div>
                  </div>
               </div>
            @endforeach
          @endif
         </div>
         <div class="button-holder load-more_button text-align_center">
          <form method="get" action="{{url($user->store_url . '/products')}}">
            @php 
            $query = request()->get('query');
            $min_price = request()->get('min-price');
            $max_price = request()->get('max-price'); 
            @endphp
            @if (!empty($query))
            <input type="hidden" name="query" value="{{request()->get('query')}}">
            @endif
            @if (!empty($min_price))
            <input type="hidden" name="min-price" value="{{request()->get('min-price')}}">
            @endif

            @if (!empty($max_price))
            <input type="hidden" name="max-price" value="{{request()->get('max-price')}}">
            @endif
            <input type="hidden" name="page" value="2">
            <button class="button normal light-blue shadow load-more-posts" type="submit">
             <span>Show More</span>
            </button>
          </form>
         </div>
      </div>
    </div>
  </div>

@stop
  @endforeach