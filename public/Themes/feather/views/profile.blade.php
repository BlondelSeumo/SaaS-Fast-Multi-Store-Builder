@extends('layouts.app')
@section('content')
      <!-- Hero section -->
      <div class="section-2xl pb-0 {{  !empty(banner($uid)) ? 'bg-image banner' : '' }}" data-bg-src="{{ banner($uid) }}">
      	<div class="{{ !empty(banner($uid)) ? 'bg-dark-05' : '' }}">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-12 col-lg-3">
              <div class="d-inline-block margin-lg-right-40">
                  <img class="avatar-2xl theme-border" src="{{ avatar($uid) }}" alt="">
                </div>
            </div>
            <div class="col-12 col-lg-9">
              <h4 class="theme-name">{{full_name($uid)}}</h4>
              <h4 class="font-weight-bold line-height-140 margin-0 mb-2 tagline mt-1">{{ user('extra.tagline', $uid) }}</h4>
              <p class="header-about">{{ Str::limit(clean(user('extra.about', $uid), 'clean_all'), $limit = 250, $end = '...') }}</p>
              <a href="#products" class="button smoothscroll button-lg mt-3 align-items-center theme-btn d-flex w-250px">{{ __('Start shopping') }} <em class="ni ni-arrow-right-circle fs-17px ml-1"></em></a>
            </div>
          </div><!-- end row -->
        </div><!-- end container -->
      	</div>
      </div>
      <!-- end Hero section -->
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
					  	@include('include.product-item', ['product' => $product])
					  @endforeach
					</div><!-- end row -->
					<div class="text-center margin-top-70 d-flex justify-content-center">
						<a class="button button-md align-items-center theme-btn d-flex w-250px" href="{{ route('user-profile-products', ['profile' => $user->username]) }}">{{ __('See all products') }} <em class="ni ni-arrow-right-circle fs-17px ml-1"></em></a>
					</div>
				</div><!-- end container -->
			</div>
			@endif
			<!-- end New Arrivals -->
			@if (count(store_categories($uid, 4)) > 0)
			<!-- Product Categories -->
			<div class="container mb-5">
					<div class="text-center margin-bottom-70">
						<div class="row">
							<div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
								<h2>{{ __('Product Category') }}</h2>
								<p>{{ __('Explore products by category') }}</p>
							</div>
						</div><!-- end row -->
					</div>
				<div class="row col-spacing-10">
					@foreach (store_categories($uid, 4) as $items)
					<div class="col-12 col-md-6 col-lg-3">
						<a href="{{ route('user-profile-products', ['profile' => $user->username, 'category' => $items->slug]) }}" class="fancy-box-c">
							<img src="{{ url('media/user/categories/'.$items->media) }}" alt="">
							<div class="content">
								<h5 class="font-weight-normal title">{{$items->title}}</h5>
								<p class="subtitle">{{ \App\Model\Products::whereJsonContains('categories', $items->slug)->count() . __(' Products') }}</p>
							</div>
						</a>
					</div>
					@endforeach
				</div><!-- end row -->
			</div><!-- end container-fluid -->
			@endif
			<!-- end Product Categories -->
			@if (count(store_blogs($uid, 3)) > 0)
			<div class="section">
				<div class="container">
				   <div class="mx-auto text-center">
				      <h2>{{ __('Latest Posts') }}</h2>
				      <p>{{ __('See more from our blog') }}</p>
				   </div>
					<div class="portfolio-title-outside row spacing-40 mt-5">
			           @foreach (store_blogs($uid, 3) as $item)
			            	@include('include.blog-item', ['item' => $item])
						@endforeach
					</div>
					<div class="text-center margin-top-70 d-flex justify-content-center">
						<a class="button button-md align-items-center theme-btn d-flex w-250px" href="{{ route('user-profile-blog', ['profile' => $user->username]) }}">{{ __('See all posts') }} <em class="ni ni-arrow-right-circle fs-17px ml-1"></em></a>
					</div>
				</div><!-- end container -->
			</div>
			@endif
@endsection
