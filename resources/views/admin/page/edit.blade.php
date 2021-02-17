@extends('admin.layouts.app')

@section('footerJS')
  <script src="{{ url('tinymce/tinymce.min.js') }}"></script>
  <script src="{{ url('tinymce/sr.js') }}"></script>
@stop
@section('title', __('Edit page'))
@section('content')
<div class="nk-block-head mb-4">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal"><small>{{ __('Edit') }}</small> <b>{{ $page->title }}</b></h2>
        </div>
    </div>
</div>

<form action="{{ route('edit.post.page') }}" method="post" enctype="multipart/form-data">
	@csrf
	<input type="hidden" value="{{ $page->id }}" name="page_id">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
              <label id="type">{{ __('Page type') }}</label>
              <select class="form-select" data-search="off" data-ui="lg" name="type">
                 <option value="internal" {{ ($page->type == 'internal') ? "selected" : '' }}> {{ __('Internal') }}</option>
                 <option value="external" {{ ($page->type == 'external') ? "selected" : '' }}> {{ __('External') }}</option>
             </select>
          </div>
         </div>
		<div class="col-md-6">
			<div class="form-group">
                 <label id="url" class="url-label">{{($page->type == 'external') ? 'External Url' : 'Slug'}}</label>
                 <div class="input-group">
                     <div class="url-prepend input-group-prepend {{($page->type == 'external') ? 'hide' : ''}}">
                         <span class="input-group-text">{{ url('/') }}/{{ __('page') }}/</span>
                     </div>

                     <input type="text" value="{{ $page->url }}" name="url" class="form-control form-control-lg" placeholder="{{($page->type == 'external') ? __('ex: https:clovdigtal.com') : __('Page url / slug')}}" required="required">
                 </div>
             </div>
		</div>
		<div class="col-md-6">
			<div class="form-group mt-4">
              <label id="type">{{ __('Status') }}</label>
              <select class="form-select" data-search="off" data-ui="lg" name="status">
                 <option value="1" {{ ($page->status == 1) ? "selected" : '' }}> {{ __('Active') }}</option>
                 <option value="0" {{ ($page->status == 0) ? "selected" : '' }}> {{ __('Not active') }}</option>
             </select>
          </div>
         </div>
	</div>
	<div class="row">
		<div class="col-md-6">
		  <div class="form-group mt-5">
		      <label class="form-label"><em class="icon ni ni-text"></em> <span>{{ __('Title') }}</span></label>
		      <div class="form-control-wrap">
		          <input type="text" value="{{ $page->title }}" class="form-control form-control-lg" placeholder="{{ __('enter your title') }}" name="title">
		      </div>
		  </div>
		  <div class="form-group mt-5">
		      <label class="form-label"><em class="icon ni ni-text"></em> <span>{{ __('Short description') }}</span></label>
		      <div class="form-control-wrap">
		          <input type="text" value="{{ (!empty($page->settings) && !empty($page->settings->sh_description)) ? $page->settings->sh_description : "" }}" class="form-control form-control-lg" placeholder="{{ __('enter a short description') }}" name="sh_description">
		      </div>
		  </div>
		</div>
		<div class="col-md-6">
		  <div class="form-group mt-5">
		   <label class="form-label"><em class="icon ni ni-camera"></em> <span>{{ __('Image') }}</span></label>
			<div class="image-upload pages">
	              <label for="upload">{{ __('Click here or drop an image to upload') }}</label>
	              <input type="file" id="upload" name="image" class="upload">
	              <img src="{{ url('img/pages/' . $page->image) }}" alt=" ">
             </div>
         </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="form-group mt-5">
              <label>{{ __('Category') }}</label>
              <select class="form-select" data-search="on" data-ui="lg" name="category">
              	@foreach ($categories as $item)
                 <option value="{{$item->id}}" {{($item->id == $page->category) ? "selected" : ""}}>{{ucfirst($item->title)}}</option>
              	@endforeach
             </select>
          </div>
		</div>
		<div class="col-md-4">
		  <div class="form-group mt-5">
		      <label class="form-label"><em class="icon ni ni-text"></em> <span>{{ __('Order') }}</span></label>
		      <div class="form-control-wrap">
		          <input type="number" value="{{ $page->order }}" class="form-control form-control-lg" value="0" placeholder="{{ __('order your pages') }}" name="order">
		      </div>
		  </div>
		  <p>{{ __('Easily arrange pages with numbers. Displaying on the website is ascendent.') }}</p>
		</div>
	</div>
	<div class="form-group mt-5 mt-lg-2 content-container {{($page->type == 'external') ? 'hide' : ''}}">
	    <label class="form-label"><em class="icon ni ni-bell-fill"></em> <span> {{ __('Content') }}</span></label>
	    <div class="form-control-wrap">
	        <textarea class="form-control form-control-lg editor" placeholder="enter your page content" name="content">{{ (!empty($page->settings) && !empty($page->settings->content)) ? $page->settings->content : "" }}</textarea>
	    </div>
	</div>
	<div class="form-group mt-5">
		<button type="submit" class="btn btn-primary btn-block"><em class="icon ni ni-save-fill"></em> <span>{{ __('Save') }}</span></button>
	</div>
</form>


<script src="{{ asset('js/admin-pages.js') }}"></script>
@endsection
