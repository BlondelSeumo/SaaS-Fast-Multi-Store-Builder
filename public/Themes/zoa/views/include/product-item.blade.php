                            <div class="card-producto">
                              <h1><a href="{{ Linker::url(route('user-profile-single-product', ['profile' => $user->username, 'id' => $product->id]), ['ref' => $user->username]) }}">{{ $product->title }}</a></h1>
                                <p>{{ Str::limit(clean($product->description, 'clean_all'), $limit = 50, $end = '...') }}</p>
                                <div class="pic-producto mt-2">
                                  <img src="{{ getfirstproductimg($product->id) }}" alt="">
                                </div>
                                <div class="info-producto mt-3 justify-content-between">
                                    <div class="price-producto">{!! Currency::symbol($user->gateway['currency'] ?? '') !!}{{ nf(!empty($product->salePrice) ? $product->salePrice : $product->price) }}</div>

                                      <form class="product-quantity" id="add-to-cart" data-qty="1" data-route="{{ route('add-to-cart', ['user_id' => $user->id, 'product' => $product->id]) }}" data-id="{{$product->id}}">
                                          <input type="hidden" id="quantity" name="quantity" min="1" max="10" value="1">
                                          <button class="button-producto ajax_add_to_cart d-flex align-center" type="submit">
                                            {{ __('Add to Cart') }}
                                            <i class="fz-20px ni ni-cart zero" hidden></i>
                                            <i class="fz-20px ni ni-plus-circle first"></i>
                                            <i class="fz-20px ni ni-check-circle second"></i>
                                          </button>
                                        </form>
                                  </div>
                                </div>