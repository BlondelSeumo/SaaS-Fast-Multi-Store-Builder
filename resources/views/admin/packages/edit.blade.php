@extends('admin.layouts.app')

@section('title', __('Edit package'))
@section('content')
<div class="nk-block-head mb-4">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ucfirst($package->name)}}</h2>
        </div>
    </div>
</div>

<form action="{{ route('edit.post.package', $package->id) }}" method="post">
	@csrf
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
	          <label class="mt-2">{{ __('Package name') }}</label>
			   <div class="form-control-wrap">
			       <input type="text" class="form-control form-control-lg" required="" placeholder="{{ __('enter package name') }}" name="package_name" value="{{ $package->name }}">
			   </div>
	        </div>
	     </div>
		<div class="col-md-6">
			<div class="form-group">
	             <label class="mt-2">{{ __('status') }}</label>
	             <select class="form-select" data-search="off" data-ui="lg" name="status">
	                <option value="1" {{ ($package->status == 1) ? "selected" : "" }}> {{ __('Active') }}</option>
	                <option value="2" {{ ($package->status == 2) ? "selected" : "" }}> {{ __('Disable') }}</option>
	    		  @if ($package->id !== "free")
	                <option value="3" {{ ($package->status == 3) ? "selected" : "" }}> {{ __('Hidden') }}</option>
	             @endif
	            </select>
	         </div>
	     </div>
	</div>
	@if ($package->id == 'trial')
		<div class="col-md-4">
		  <div class="form-group mt-5">
		      <label class="mt-2">{{ __('Trial Expiry') }}</label>
		      <div class="form-control-wrap">
		          <input type="text" class="form-control form-control-lg" placeholder="{{ __('In days. Ex: "10" will be 10 days') }}" name="expiry" value="{{ (!empty($package->price->expiry)) ? $package->price->expiry : "" }}">
		      </div>
		  </div>
		</div>
	@endif
    @if ($package->id !== "free" && $package->id !== "trial")
	<div class="data-head mt-5 mb-2">
       <h6 class="overline-title">{{ __('Package price') }}</h6>
    </div>
	<div class="row">
		<div class="col-md-4">
		  <div class="form-group mt-5">
		      <label class="mt-2">{{ __('Monthly price') }}</label>
		      <div class="form-control-wrap">
		          <input type="text" class="form-control form-control-lg" required="" placeholder="{{ __('ex: 10') }}" name="month" value="{{ (!empty($package->price->month)) ? $package->price->month : "" }}">
		      </div>
		  </div>
		</div>
		<div class="col-md-4">
		  <div class="form-group mt-5">
		      <label class="mt-2">{{ __('Quarterly price') }} <small>{{ __('optional') }}</small></label>
		      <div class="form-control-wrap">
		          <input type="text" class="form-control form-control-lg" placeholder="{{ __('ex: 20') }}" name="quarter" value="{{ (!empty($package->price->quarter)) ? $package->price->quarter : "" }}">
		      </div>
		  </div>
		</div>
		<div class="col-md-4">
		  <div class="form-group mt-5">
		      <label class="mt-2">Yearly price</label>
		      <div class="form-control-wrap">
		          <input type="text" class="form-control form-control-lg" required="" placeholder="{{ __('ex: 30') }}" name="annual" value="{{ (!empty($package->price->annual)) ? $package->price->annual : "" }}">
		      </div>
		  </div>
		</div>
	</div>
    @endif

	<div class="data-head mt-5 mb-2">
       <h6 class="overline-title">{{ __('Package Settings') }}</h6>
    </div>

    <div class="row">
    	<div class="col-12 col-md-4 mt-5">
    		<div class="custom-control custom-checkbox custom-control-lg">
			    <input type="hidden" class="custom-control-input" name="ads" value="0">
			    <input type="checkbox" class="custom-control-input" id="ads" name="ads" value="1" {{ (!empty($package->settings) && !empty($package->settings->ads) && ($package->settings->ads)) ? "checked" : "" }}>
			    <label class="custom-control-label" for="ads">{{ __('Ads') }} | </label>
			</div>
			<label class="mt-2">{{ __('People on this package will not have ads.') }}</label>
    	</div>
    	<div class="col-12 col-md-4 mt-5">
    		<div class="custom-control custom-checkbox custom-control-lg">
			    <input type="hidden" class="custom-control-input" name="custom_branding" value="0">
			    <input type="checkbox" class="custom-control-input" id="custom_branding" name="custom_branding" value="1" {{ (!empty($package->settings) && !empty($package->settings->custom_branding) && ($package->settings->custom_branding)) ? "checked" : "" }}>
			    <label class="custom-control-label" for="custom_branding">{{ __('Custom Branding') }} | </label>
			</div>
			<label class="mt-2">{{ __('Users can use custom footer branding') }}</label>
    	</div>
    	<div class="col-12 col-md-4 mt-5">
    		<div class="custom-control custom-checkbox custom-control-lg">
			    <input type="hidden" class="custom-control-input" name="statistics" value="0">
			    <input type="checkbox" class="custom-control-input" id="statistics" name="statistics" value="1" {{ (!empty($package->settings) && !empty($package->settings->statistics) && ($package->settings->statistics)) ? "checked" : "" }}>
			    <label class="custom-control-label" for="statistics">{{ __('Statistics') }} | </label>
			</div>
			<label class="mt-2">{{ __('Users get more statistics') }}</label>
    	</div>
    	<div class="col-12 col-md-4 mt-5">
    		<div class="custom-control custom-checkbox custom-control-lg">
			    <input type="hidden" class="custom-control-input" name="verified" value="0">
			    <input type="checkbox" class="custom-control-input" id="verified" name="verified" value="1" {{ (!empty($package->settings) && !empty($package->settings->verified) && ($package->settings->verified)) ? "checked" : "" }}>
			    <label class="custom-control-label" for="verified">{{ __('Verified badge') }} | </label>
			</div>
			<label class="mt-2">{{ __('Users on this plan get verified badge') }}</label>
    	</div>
    	<div class="col-12 col-md-4 mt-5">
    		<div class="custom-control custom-checkbox custom-control-lg">
			    <input type="hidden" name="social" value="0">
			    <input type="checkbox" class="custom-control-input" id="usersocial" name="social" value="1" {{ (!empty($package->settings) && !empty($package->settings->social) && ($package->settings->social)) ? "checked" : "" }}>
			    <label class="custom-control-label" for="usersocial">{{ __('User social') }} | </label>
			</div>
			<label class="mt-2">{{ __('Users adds social links on their profile') }}</label>
    	</div>
    	<div class="col-12 col-md-4 mt-5">
    		<div class="custom-control custom-checkbox custom-control-lg">
			    <input type="hidden" name="custom_background" value="0">
			    <input type="checkbox" class="custom-control-input" id="custom-background" name="custom_background" value="1" {{ (!empty($package->settings) && !empty($package->settings->custom_background) && ($package->settings->custom_background)) ? "checked" : "" }}>
			    <label class="custom-control-label" for="custom-background">{{ __('Custom background') }} | </label>
			</div>
			<label class="mt-2">{{ __('Users have access to custom backgrounds') }}</label>
    	</div>
    	<div class="col-12 col-md-4 mt-5">
    		<div class="custom-control custom-checkbox custom-control-lg">
			    <input type="hidden" class="custom-control-input" name="domains" value="0">
			    <input type="checkbox" class="custom-control-input" id="domains" name="domains" value="1" {{ (!empty($package->settings->domains) && ($package->settings->domains)) ? "checked" : "" }}>
			    <label class="custom-control-label" for="domains">{{ __('Domains') }} | </label>
			</div>
			<label class="mt-2">{{ __('Users on this plan gets to choose domains if available') }}</label>
    	</div>
    	<div class="col-12 col-md-4 mt-5">
    		<div class="custom-control custom-checkbox custom-control-lg">
			    <input type="hidden" class="custom-control-input" name="google_analytics" value="0">
			    <input type="checkbox" class="custom-control-input" id="google_analytics" name="google_analytics" value="1" {{ (!empty($package->settings->google_analytics) && ($package->settings->google_analytics)) ? "checked" : "" }}>
			    <label class="custom-control-label" for="google_analytics">{{ __('Google analytics') }} | </label>
			</div>
			<label class="mt-2">{{ __('Users on this plan gets to add google analytics tracking to their store') }}</label>
    	</div>
    	<div class="col-12 col-md-4 mt-5">
    		<div class="custom-control custom-checkbox custom-control-lg">
			    <input type="hidden" class="custom-control-input" name="facebook_pixel" value="0">
			    <input type="checkbox" class="custom-control-input" id="facebook_pixel" name="facebook_pixel" value="1" {{ (!empty($package->settings->facebook_pixel) && ($package->settings->facebook_pixel)) ? "checked" : "" }}>
			    <label class="custom-control-label" for="facebook_pixel">{{ __('Facebook analytics') }} | </label>
			</div>
			<label class="mt-2">{{ __('Users on this plan gets to add facebook pixel to their store') }}</label>
    	</div>
    	<div class="col-12 col-md-4 mt-5">
    		<div class="custom-control custom-checkbox custom-control-lg">
			    <input type="hidden" class="custom-control-input" name="blogs" value="0">
			    <input type="checkbox" class="custom-control-input" id="blogs" name="blogs" value="1"{{ (!empty($package->settings->blogs) && ($package->settings->blogs)) ? "checked" : "" }}>
			    <label class="custom-control-label" for="blogs">{{ __('Blog Posts') }} | </label>
			</div>
			<label class="mt-2">{{ __('Users on this plan can create blog posts') }}</label>
    	</div>
    	<div class="col-12 col-md-4 mt-5">
			<div class="form-group">
	             <label class="mt-2">{{ __('Domains') }}</label>
	             <p>{{ __('List of all custom domains users on this plan should access if available') }}</p>
	             <select class="form-select" multiple="" data-search="on" data-ui="lg" name="domains[]">
					@foreach ($domains as $item)
						<option value="{{ $item->id }}" {{ !empty($package->domains) && is_array(json_decode($package->domains, true)) && in_array($item->id, json_decode($package->domains, true)) ? 'selected' : '' }}>{{ $item->host }}</option>
					@endforeach
	            </select>
	         </div>
    	</div>
    	<div class="col-12 col-md-4 mt-5">
			<div class="form-group">
	             <label class="mt-2">{{ __('Gateways') }}</label>
	             <p>{{ __('List of all payment methods users on this plan should access if available') }}</p>
	             <select class="form-select" multiple="" data-search="on" data-ui="lg" name="gateways[]">
					@foreach ($gateways as $key => $item)
						<option value="{{ $key }}" {{ !empty($package->gateways) && is_array(json_decode($package->gateways, true)) && in_array($key, json_decode($package->gateways, true)) ? 'selected' : '' }}>{{ $item['name'] }}</option>
					@endforeach
	            </select>
	         </div>
    	</div>
    </div>
	<div class="data-head mt-5 mb-2">
       <h6 class="overline-title">{{ __('Package limits') }}</h6>
    </div>
	<div class="row">
		<div class="col-md-4">
		  <div class="form-group mt-5">
		      <label class="mt-2">{{ __('Products limits') }}</label>
		      <div class="form-control-wrap">
		          <input type="number" class="form-control form-control-lg" placeholder="{{ __('how many products can be created') }}" value="{{ $package->settings->products_limit ?? '' }}" name="products_limit">
		      </div>
		  </div>
		  <label class="mt-2">{{ __('Amount of products a user can create. -1 for unlimited.') }}</label>
		</div>
		<div class="col-md-4">
		  <div class="form-group mt-5">
		      <label class="mt-2">{{ __('Blogs limits') }}</label>
		      <div class="form-control-wrap">
		          <input type="number" class="form-control form-control-lg" placeholder="{{ __('how many blog posts can be created') }}" name="blogs_limits" value="{{ $package->settings->blogs_limits ?? '' }}">
		      </div>
		  </div>
		  <label class="mt-2">{{ __('Amount of blog posts a user can create. -1 for unlimited.') }}</label>
		</div>
		<div class="col-md-4">
		  <div class="form-group mt-5">
		      <label class="mt-2">{{ __('Custom Domains limits') }}</label>
		      <div class="form-control-wrap">
		          <input type="number" class="form-control form-control-lg" placeholder="{{ __('how many custom domains can be added') }}" name="custom_domain_limit" value="{{ $package->settings->custom_domain_limit ?? '' }}">
		      </div>
		  </div>
		  <label class="mt-2">{{ __('Amount of custom domain a user can add. -1 for unlimited.') }}</label>
		</div>
	</div>
	<div class="form-group mt-5">
		<button type="submit" class="btn btn-primary btn-lg w-50 btn-block"><em class="icon ni ni-save-fill"></em> <span>{{ __('Save') }}</span></button>
	</div>
</form>
@endsection
