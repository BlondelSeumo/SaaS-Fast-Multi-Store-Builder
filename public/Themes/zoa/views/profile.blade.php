@extends('layouts.app')
@section('content')


        <div class="slide v6">
            <div class="container container-content">
            <div class="js-slider-v4">
              @foreach (store_products($uid, 2) as $key => $item)
                <div class="slide-img">
                    <a href="{{ Linker::url(route('user-profile-single-product', ['profile' => $user->username, 'id' => $item->id]), ['ref' => $user->username]) }}">
                        <img src="{{ getfirstproductimg($item->id) }}" alt="" class="img-responsive">
                    </a>
                    <div class="slide-img-title">
                        <h4>{{ $item->title }}</h4>
                    </div>
                    @if (!empty($item->categories))
                        <div class="tags-label-right">
                        @foreach ($item->categories as $value)
                            @php
                              if($category = \App\Model\Product_Category::where('slug', $value)->first()):
                                echo '<a href="'.route('user-profile-products', ['profile' => $user->username, 'category' => $value]).'">'.$category->title.'</a> ';
                              endif;
                            @endphp
                        @endforeach
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
               <div class="custom">
                    <div class="pagingInfo"></div>
                </div>
            </div>
        </div>

        <div class="trend-product pad" {{ user('extra.top_product', $uid) == 0 ? 'hidden' : '' }}>
            <div class="container container-content">
                <div class="row first">
                    <div class="col-lg-5 col-12">
                        @foreach (user_first_top_products($uid) as $key => $item)
                        <div class="trend-img hover-images">
                            <img class="img-responsive" src="{{ getfirstproductimg($item->id) }}" alt="">
                            <div class="box-center align-items-end">
                                <h3 class="zoa-category-box-title">
                                    <a href="{{ Linker::url(route('user-profile-single-product', ['profile' => $user->username, 'id' => $item->id]), ['ref' => $user->username]) }}">#{{ __('trend') }} </a>
                                </h3>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="col-lg-7 col-12">
                        <div class="row">
                            @foreach (user_top_products($uid, 1, 2) as $key => $item)
                            <div class="col-12 col-md-6">
                                @include('include.product-item', ['product' => $item])
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
			@if (count(store_products($uid, 6)) > 0)
			<div class="section-lg offwhite_bg mb-5" id="products">
				<div class="container">
					<div class="text-center margin-bottom-70">
						<div class="row">
							<div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
								<h2>{{ __('Products') }}</h2>
								<p>{{ __('Here are some of our recent products') }}</p>
							</div>
						</div><!-- end row -->
					</div>
					<div class="row col-spacing-40">
					  @foreach(store_products($uid, 6) as $product)
                        <div class="col-md-4">
					  	    @include('include.product-item', ['product' => $product])
                        </div>
					  @endforeach
					</div><!-- end row -->
					<div class="text-center margin-top-70 d-flex justify-content-center">
						<a class="button button-md align-items-center theme-btn d-flex w-250px" href="{{ route('user-profile-products', ['profile' => $user->username]) }}">{{ __('See all products') }} <em class="ni ni-arrow-right-circle fs-17px ml-1"></em></a>
					</div>
				</div><!-- end container -->
			</div>
			@endif
			@if (count(store_categories($uid, 3)) > 0)
			<!-- Product Categories -->
			<div class="banner container mb-5">
				<div class="row col-spacing-10">
					@foreach (store_categories($uid, 4) as $items)
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="banner-img">
                            <a href="{{ route('user-profile-products', ['profile' => $user->username, 'category' => $items->slug]) }}" class="effect-img3 plus-zoom">
                                <img src="{{ url('media/user/categories/'.$items->media) }}" alt="">
                            </a>
                            <div class="box-center content3">
                            	<a href="" hidden>{{ \App\Model\Products::whereJsonContains('categories', $items->slug)->count() . __(' Products') }}</a>
                                <a href="{{ route('user-profile-products', ['profile' => $user->username, 'category' => $items->slug]) }}">{{$items->title}}</a>
                            </div>
                        </div>
                    </div>
					@endforeach
				</div><!-- end row -->
			</div><!-- end container-fluid -->
			@endif
			<!-- end Product Categories -->
            <div class="container offwhite_bg">
                <div class="about-homepage pad bd-top">
                    <div class="about-img">
                        <a href="" class="hover-images">
                            <img src="{{ banner($uid) }}" alt="" class="img-responsive">
                        </a>
                    </div>
                    <div class="about-homepage-content">
                         <h4 class="font-weight-bold line-height-140 my-4 fs-20px ">{{ user('extra.tagline', $uid) }}</h4>
                        <div class="content-first">
                        <p>{{ Str::limit(clean(user('extra.about', $uid), 'clean_all'), $limit = 250, $end = '...') }}</p>
                        </div>
                        <a href="{{ route('user-profile-about', ['profile' => $user->username]) }}" class="button smoothscroll button-lg mt-5 align-items-center theme-btn d-flex w-250px">{{ __('About') }} <em class="ni ni-arrow-right-circle fs-17px ml-1"></em></a>
                        
                    </div>
                </div>
            </div>
@endsection
