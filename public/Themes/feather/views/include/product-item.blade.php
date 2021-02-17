
           <div class="col-12 col-md-4">
            <div class="product-box">
              <div class="product-img">
                <a href="{{ Linker::url(route('user-profile-single-product', ['profile' => $user->username, 'id' => $product->id]), ['ref' => $user->username]) }}" class="h-100">
                  <img src="{{ getfirstproductimg($product->id) }}" alt="" class="h-100 w-100">
                </a>
                    @if (!empty($product->salePrice))
                  <div class="product-badge-left">
                    <span class="font-small uppercase font-family-secondary font-weight-medium">{{__('On Sale')}}</span>
                  </div>
                    @endif
              </div>
              <div class="product-title">
                <h6 class="font-weight-medium"><a href="{{ Linker::url(route('user-profile-single-product', ['profile' => $user->username, 'id' => $product->id]), ['ref' => $user->username]) }}">{{ $product->title }}</a></h6>
                <div class="short-description text-white my-3">
                  <p class="text-gray">{{ Str::limit(clean($product->description, 'clean_all'), $limit = 70, $end = '...') }}</p>
                </div>
              <div class="add-to-cart d-flex justify-content-between">
                <h4 class="fs-20px theme-color">{!! Currency::symbol($user->gateway['currency'] ?? '') !!}{{ nf(!empty($product->salePrice) ? $product->salePrice : $product->price) }}</h4>
                @if (!empty($product->external_url))
                  <a target="_blank" href="{{ url("$product->external_url") }}" class="theme-color button-text-1"><em class="fz-20px ni ni-globe"></em></a>
                  @else
                  <form class="product-quantity" id="add-to-cart" data-qty="1" data-route="{{ route('add-to-cart', ['user_id' => $user->id, 'product' => $product->id]) }}" data-id="{{$product->id}}">
                      <input type="hidden" id="quantity" name="quantity" min="1" max="10" value="1">
                      <button class="button-text-1 theme-color ajax_add_to_cart d-flex align-center" type="submit">
                        <i class="fz-20px ni ni-cart zero"></i>
                        <i class="fz-20px ni ni-plus-circle first"></i>
                        <i class="fz-20px ni ni-check-circle second"></i>
                      </button>
                    </form>
                @endif
              </div>
              </div>
            </div>
           </div>