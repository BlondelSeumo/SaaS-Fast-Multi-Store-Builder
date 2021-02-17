@extends('admin.layouts.app')

@section('title', __('New page'))
@section('footerJS')
  <script src="{{ url('tinymce/tinymce.min.js') }}"></script>
  <script src="{{ url('tinymce/sr.js') }}"></script>
@stop
@section('content')
<div class="nk-block-head mb-4">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('New page') }}</h2>
        </div>
    </div>
</div>

<form action="{{ route('post.page') }}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
              <label id="type">{{ __('Page type') }}</label>
              <select class="form-select" data-search="off" data-ui="lg" name="type">
                 <option value="internal" selected="">{{ __('Internal') }}</option>
                 <option value="external">{{ __('External') }}</option>
             </select>
          </div>
         </div>
		<div class="col-md-6">
			<div class="form-group">
                 <label id="url" class="url-label">{{ __('Slug') }}</label>
                 <div class="input-group">
                     <div class="url-prepend input-group-prepend">
                         <span class="input-group-text">{{ url('/') }}/{{ __('page') }}/</span>
                     </div>

                     <input type="text" name="url" class="form-control form-control-lg" placeholder="{{ __('Page url / slug') }}" required="required">
                 </div>
             </div>
		</div>
		<div class="col-md-6">
			<div class="form-group mt-4">
              <label id="type">{{ __('Status') }}</label>
	              <select class="form-select" data-search="off" data-ui="lg" name="status">
	                 <option value="1">{{ __('Active') }}</option>
	                 <option value="0">{{ __('Not active') }}</option>
	             </select>
	          </div>
         </div>
	</div>
	<div class="row">
		<div class="col-md-6">
		  <div class="form-group mt-5">
		      <label class="form-label"><em class="icon ni ni-text"></em> <span>{{ __('Title') }}</span></label>
		      <div class="form-control-wrap">
		          <input type="text" class="form-control form-control-lg" placeholder="{{ __('enter your title') }}" name="title">
		      </div>
		  </div>
		  <div class="form-group mt-5">
		      <label class="form-label"><em class="icon ni ni-text"></em> <span>{{ __('Short description') }}</span></label>
		      <div class="form-control-wrap">
		          <input type="text" class="form-control form-control-lg" placeholder="{{ __('enter a short description') }}" name="sh_description">
		      </div>
		  </div>
		</div>
		<div class="col-md-6">
		  <div class="form-group mt-5">
		   <label class="form-label"><em class="icon ni ni-camera"></em> <span>{{ __('Image') }}</span></label>
			<div class="image-upload pages">
	              <label for="upload">{{ __('Click here or drop an image to upload') }}</label>
	              <input type="file" id="upload" name="image" class="upload">
	              <img src="" alt=" ">
             </div>
         </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="form-group mt-5">
              <label>{{ __('Category') }}</label>
              <select class="form-select" data-search="on" data-ui="lg" required="" name="category">
              	@foreach ($categories as $item)
                 <option value="{{$item->id}}">{{ucfirst($item->title)}}</option>
              	@endforeach
             </select>
          </div>
		</div>
		<div class="col-md-4">
		  <div class="form-group mt-5">
		      <label class="form-label"><em class="icon ni ni-text"></em> <span>Order</span></label>
		      <div class="form-control-wrap">
		          <input type="number" class="form-control form-control-lg" value="0" placeholder="{{ __('order your pages') }}" name="order">
		      </div>
		  </div>
		  <p>{{ __('Easily arrange pages with numbers. Displaying on the website is ascendent.') }}</p>
		</div>
	</div>
	<div class="form-group mt-5 mt-lg-2 content-container">
	    <label class="form-label"><em class="icon ni ni-bell-fill"></em> <span> {{ __('Content') }}</span></label>
	    <div class="form-control-wrap">
	        <textarea class="form-control form-control-lg editor" placeholder="{{ __('enter your page content') }}" name="content"></textarea>
	    </div>
	</div>
	<div class="form-group mt-5">
		<button type="submit" class="btn btn-primary btn-block"><em class="icon ni ni-save-fill"></em> <span>{{ __('Save') }}</span></button>
	</div>
</form>

<script src="{{ asset('js/admin-pages.js') }}"></script>
@endsection
