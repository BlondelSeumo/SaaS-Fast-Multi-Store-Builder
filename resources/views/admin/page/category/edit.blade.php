@extends('admin.layouts.app')

@section('title', __('Edit category'))
@section('content')
<div class="nk-block-head mb-4">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('New Category') }}</h2>
        </div>
    </div>
</div>

<form action="{{ route('edit.post.category') }}" method="post">
	@csrf
	<input type="hidden" name="category_id" value="{{ $category->id }}">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group mt-5">
                 <label id="url">{{ __('Url') }}</label>
                 <div class="input-group">
                     <div id="url_prepend" class="input-group-prepend">
                         <span class="input-group-text">{{ url('/') }}/{{ __('pages') }}/</span>
                     </div>

                     <input type="text" name="url" class="form-control form-control-lg" placeholder="{{ __('Page url / slug') }}" required="required" value="{{ $category->url }}">
                 </div>
             </div>
		</div>
		<div class="col-md-6">
			<div class="form-group mt-5">
              <label>Status</label>
              <select class="form-select" data-search="off" data-ui="lg" name="status">
                 <option value="1" {{ ($category->status == 1) ? "selected" : "" }}> {{ __('Active') }}</option>
                 <option value="0" {{ ($category->status == 0) ? "selected" : "" }}> {{ __('Hidden') }}</option>
             </select>
          </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
		  <div class="form-group mt-5">
		      <label class="form-label"><em class="icon ni ni-text"></em> <span>{{ __('Title') }}</span></label>
		      <div class="form-control-wrap">
		          <input type="text" class="form-control form-control-lg" placeholder="{{ __('enter your title') }}" name="title" required="" value="{{ $category->title }}">
		      </div>
		  </div>
		</div>
		<div class="col-md-6">
		  <div class="form-group mt-5">
		      <label class="form-label"><em class="icon ni ni-text"></em> <span>{{ __('Short description') }}</span></label>
		      <div class="form-control-wrap">
		          <input type="text" class="form-control form-control-lg" placeholder="{{ __('enter a short description') }}" name="description" value="{{ $category->description }}">
		      </div>
		  </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
		  <div class="form-group mt-5">
		      <label class="form-label"><em class="icon ni ni-text"></em> <span>{{ __('Pick an icon') }}</span></label>
              <div class="input-group link-icon">
                 <span class="input-group-prepend">
                    <button class="btn btn-primary iconpicker dropdown-toggle" data-icon="" data-iconset="fontawesome5" role="iconpicker" data-original-title="" title="" aria-describedby="popover60345"><i class="empty"></i></button>
                </span>
		        <input type="text" class="form-control form-control-lg" placeholder="{{ __('eg: fab fa-instagram') }}" name="icon" value="{{ $category->icon }}">
            </div>
		  </div>
		</div>
		<div class="col-md-6">
		  <div class="form-group mt-5">
		      <label class="form-label"><span>{{ __('Order') }}</span></label>
		      <div class="form-control-wrap">
		          <input type="text" class="form-control form-control-lg" placeholder="{{ __('enter a short description') }}" name="order" value="0" required="" value="{{ $category->order }}">
		      </div>
		  </div>
		</div>
	</div>
	<div class="form-group mt-5">
		<button type="submit" class="btn btn-primary"><em class="icon ni ni-save-fill"></em> <span>{{ __('Save') }}</span></button>
	</div>
</form>
@endsection
