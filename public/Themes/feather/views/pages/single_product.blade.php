@extends('layouts.app')
 @section('content')
    <div class="container c-contain pt-8 mb-5">
      <div class="row mt-5">
          <div class="col-lg-5 form__cover">
              <div class="row">
                  <div class="col-12">
                    <div class="container-fluid m-auto">
                      <div class="box-1 align-center flex-column h-100">
                    <div class="col-12">
                      <div class="owl-carousel product-carousel owl-dots-overlay-right w-100">
                        @php
                          $i = 1;
                        @endphp
                        @foreach ($product->media as $image)
                        @php
                          $i++
                        @endphp
                        <div data-hash="{{$i}}">
                          <img src="{{url('media/user/products/' . $image)}}" alt="" class="h-60vh object-center w-100">
                        </div>
                        @endforeach
                      </div>
                    </div>
                      </div>
                    </div>
                    <div class="mt-3 d-flex px-3">
                      <div class="single-social">
                        @foreach (['facebook', 'twitter', 'pinterest', 'whatsapp', 'linkedin'] as $value)
                          <a href="{{ url(share_to_media($value, $product->title)) }}" class="{{ $value }}"><i class="ni ni-{{ ($value == 'facebook') ? 'facebook-f' : $value }}"></i></a>
                        @endforeach
                      </div>
                    </div>
                  </div>
              </div>
          </div>

          <div class="col-lg-7 form__content mt-5">
              <section id="sec1">
                 <div class="container-fluid m-auto">
                  <div class="col-12">
                    <h3 class="font-weight-normal margin-0">{{$product->title}}</h3>
                    <div class="product-price">
                      <h5 class="font-weight-normal">{!! !empty($product->salePrice) ? Currency::symbol($user->gateway['currency'] ?? '') . '<del>'.nf($product->price).'</del>' : '' !!} <ins>{!! Currency::symbol($user->gateway['currency'] ?? '') !!}{{ nf(!empty($product->salePrice) ? $product->salePrice : $product->price) }}</ins></h5>
                    </div>
                      <p>{{ __('Categories') }} - @foreach ($product->categories as $item)
                            @php
                              if($category = \App\Model\Product_Category::where('slug', $item)->first()):
                                echo $category->title . ' , ';
                              endif;
                            @endphp
                            @endforeach</p>
                      <p>{{ __('Stock') }} - {{ number_format($product->stock) }}</p>

                      @if (!empty($product->sku))
                        <p>{{ __('Sku') }} - {{ $product->sku }}</p>
                      @endif
                    <hr>
                    <p>{!! clean($product->description) !!}</p>
                    @if (!empty($product->external_url))
                      <a href="{{ url("$product->external_url") }}" class="rounded-pill btn margin-top-30 btn-primary btn-block w-100"><em class="fz-20px ni ni-globe mr-2"></em> {{ __('Get it on') }} {{ $product->external_url_name }}</a>
                    @else


                    <form class="product-quantity margin-top-30" id="add-to-cart" data-qty="1" data-route="{{ route('add-to-cart', ['user_id' => $user->id, 'product' => $product->id]) }}" data-product-prices="{{ route('user-get-product-prices') }}" data-id="{{$product->id}}">
                      {!! product_options_html($uid, $product->id) !!}

                    <div class="card-shadow p-3 my-4 product-option-prices d-none">
                      <h4>{{ __('Total') }} - {!! Currency::symbol($user->gateway['currency'] ?? '') !!}<span></span></h4>
                    </div>


                      <div class="d-flex between-center align-center mt-5">
                        <div class="qnt">
                          <input type="number" id="quantity" name="quantity" min="1" max="10" value="1">
                          <a class="dec minus nt-button" href="#">-</a>
                          <a class="inc plus qnt-button" href="#">+</a>
                        </div>
                        <button class="button button-md btn-block button-dark ajax_add_to_cart w-250px d-flex align-center" type="submit"><p class="mr-2">{{ __('Add to Cart') }}</p>
                          <i class="fz-20px ni ni-cart zero"></i>
                          <i class="fz-20px ni ni-plus-circle first"></i>
                          <i class="fz-20px ni ni-check-circle second"></i>
                        </button>
                      </div>
                    </form>
                    
                    @endif
                    <div class="margin-top-30">
                        @if (!empty($product->extra->shipping))
                          <p class="d-block">{{ __('Shipping locations') }} : {{ str_replace(',', ' , ', $product->extra->shipping ?? '') }}</p>
                        @endif
                    </div>
                  </div>
                         <div id="respond" class="comment-respond mt-6">
                          <div class="row">
                            <div class="col-md-6">
                              <h3 id="reply-title" class="comment-reply-title text-muted shimmer shimmer-text">{{ __('Add a review') }}</h3>
                            </div> 
                            <div class="col-md-6">
                              <a href="{{ route('user-profile-product-review', ['profile' => $user->username, 'id' => $product->id]) }}" class="mt-0 button primary d-flex justify-center align-center w-100 text-white mb-3">{{ __('Reviews') }} ({{$reviews}})</a>
                            </div> 
                           </div>
                            <form action="{{ route('user-profile-product-review-post', ['profile' => $user->username, 'id' => $product->id]) }}" method="post" class="comment-form">
                               @csrf
                               <div class="row mb-3">
                                    <label class="col-6 text-muted"><h5 class="text-muted">{{ __('Your rating') }}</h5></label>
                                    <div class="rating cols-6">
                                        <span><input type="radio" name="rating" id="str5" value="5"><label for="str5"><i class="fad fa-star"></i></label></span>
                                        <span><input type="radio" name="rating" id="str4" value="4"><label for="str4"><i class="fad fa-star"></i></label></span>
                                        <span><input type="radio" name="rating" id="str3" value="3"><label for="str3"><i class="fad fa-star"></i></label></span>
                                        <span><input type="radio" name="rating" id="str2" value="2"><label for="str2"><i class="fad fa-star"></i></label></span>
                                        <span>
                                          <input type="radio" name="rating" id="str1" value="1"><label for="str1"><i class="fad fa-star"></i></label>
                                        </span>
                                    </div>
                               </div>
                               <div class="form__group">
                                   <textarea class="form-control" name="review" placeholder="Write a description"></textarea>
                               </div>
                               <div class="row">
                                  <div class="col-6">
                                     <div class="form__group">
                                        <input class="form-control" placeholder="Name" name="name" type="text">
                                    </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="form__group">
                                        <input class="form-control" placeholder="Email" name="email" type="text">
                                    </div>
                                  </div>
                               </div>
                            <button name="submit" type="submit" id="submit" class="button primary mt-4 btn-block w-100 text-white"/>{{ __('Add Review') }}</button>
                            </form>
                        </div>
                 </div>
              </section>
          </div>
      </div>
    </div>
@stop