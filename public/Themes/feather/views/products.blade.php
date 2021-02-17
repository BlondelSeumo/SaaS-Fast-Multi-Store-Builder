@extends('layouts.app')
@section('content')
<div class="pt-8 px-3 section-body">
   @if (!empty(request()->get('category')) && $ca_banner = \App\Model\Product_Category::where('slug', request()->get('category'))->first())
	<div class="section-xl bg-image" data-bg-src="{{ url('media/user/categories/'.$ca_banner->media) }}">
		<div class="bg-dark-02">
			<div class="container text-center">
				<div class="row">
					<div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 d-flex align-center flex-column">
						<h6 class="uppercase font-weight-medium margin-bottom-20">{{$ca_banner->title}}</h6>
						<p class="font-weight-semi-bold">{{ $ca_banner->description }}</p>
		   				<a href="#" data-toggle="modal" data-target="#search" class="button smoothscroll mt-5 justify-center button-lg mt-0 align-items-center theme-btn d-flex w-lg-250px">{{ __('Search') }}</a>
					</div>
				</div><!-- end row -->
			</div><!-- end container -->
		</div>
	</div>
     @else
	   <div class="container">
		   <div class="row">
		   	<div class="col-6">
		   		<div>
		   			<h2>{{ __('Products') }}</h2>
		   		</div>
		   	</div>
		   	<div class="col-6 d-flex justify-end align-center">
		   		<div class="justify-right">
		   			<a href="#" data-toggle="modal" data-target="#search" class="button smoothscroll justify-center button-lg mt-0 align-items-center theme-btn d-flex w-lg-250px"><p class="d-none d-lg-block">{{ __('Search') }}</p> <em class="icon ni ni-search d-block d-lg-none"></em></a>
		   		</div>
		   	</div>
		   </div>
	   </div>
   @endif
	<div class="container">
	  <div class="content">
      <!-- Portfolio section -->
      <div class="section">
        <div class="row">
		 @foreach($productPaginate as $product)
		 	@include('include.product-item', ['product' => $product])
		 @endforeach
        </div>
        <div class="d-flex align-center justify-center mt-4">
        	{{ $productPaginate->links() }}
        </div>
      </div>
      <!-- end Portfolio section -->
	  </div>
	</div>
</div>
  <div class="modal fade" tabindex="-1" role="dialog" id="search" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content bdrs-15">
              <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
              <div class="modal-body modal-body-lg">
		         <form method="GET" class="row align-items-center" action="{{ route('user-profile-products', ['profile' => $user->username]) }}">
		         	<div class="w-100 mx-auto text-center mb-4">
		         		<h4 class="text-muted">{{ __('Search For Product') }}</h4>
		         	</div>
		            @php 
		            $page = request()->get('page');
		            @endphp
		            @if (!empty($page))
		            <input type="hidden" name="page" value="{{$page}}">
		            @endif
			  		<div class="col-md-12 mb-0">
			  			<div class="form-group">
			  				<input type="text" name="query" value="{{ request()->get('query') }}" placeholder="{{ __('Search') }}">
			  			</div>
			  		</div>
			  		<div class="col-md-12 row">
			  			<div class="form-group col-6">
		                     <label class="m-3">{{ __('Min Price') }}</label>
			  				<input type="text" name="min-price" value="{{ $min_price }}" placeholder="{{ __('Min Price') }}">
			  			</div>
			  			<div class="form-group col-6">
		                     <label class="m-3">{{ __('Max Price') }}</label>
			  				<input type="text" name="max-price" value="{{ $max_price }}" placeholder="{{ __('Max Price') }}">
			  			</div>
			  		</div>
			  		<div class="col-md-12">
		                <label class="m-3">{{ __('Category') }}</label>
			  			<select class="custom-select w-100" name="category">
		                   <option value="">{{ __('None') }}</option>
		                   @foreach($categories as $category)
		                   <option value="{{$category->slug}}" {{ request()->get('category') == $category->slug ? 'selected' : '' }}>{{$category->title}}</option>
		                   @endforeach
			  			</select>
			  		</div>
			  		<div class="col-12">
			  			<button class="button smoothscroll justify-center button-lg mt-0 align-items-center theme-btn d-flex w-100">{{ __('Search') }}</button>
			  		</div>
			  	</form>
              </div><!-- .modal-body -->
          </div><!-- .modal-content -->
      </div><!-- .modal-dialog -->
  </div>
@endsection
