@extends('admin.layouts.app')

@section('title', __('Tanslations'))
@section('content')

<div class="nk-block-head">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('Tanslations') }}</h2>
        </div>
    </div>
</div>
<form action="{{ route('admin-translation-post', 'post') }}" class="card card-shadow card-inner bdrs-20" method="post">
    @csrf
    <input type="hidden" name="trans" value="{{request()->get('trans')}}">
    <h5>{{ __('Add new translation') }}</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <textarea name="key" class="form-control c-textarea form-control-lg" placeholder="Key"></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mt-4 mt-lg-0">
                <textarea name="value" class="form-control c-textarea form-control-lg" placeholder="Value"></textarea>
            </div>
        </div>
    </div>
     <button class="button primary btn-block mt-4">{{ __('Submit') }}</button>
</form>

<div class="nk-block mt-5">
   <div class="nk-tb-list is-separate is-medium mb-3">
      <div class="nk-tb-item nk-tb-head">
         <div class="nk-tb-col"><span>{{ __('Key') }}</span></div>
         <div class="nk-tb-col tb-col-md"><span>{{ __('Value') }}</span></div>
         <div class="nk-tb-col"></div>
      </div>
     @foreach ($alltrans as $key => $value)
      <div class="nk-tb-item background-lighter">
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead">{{$key}}</span>
         </div>
         <div class="nk-tb-col tb-col-md background-lighter">
            <span class="tb-sub">{{$value}}</span>
         </div>
         <div class="nk-tb-col nk-tb-col-tools background-lighter">
            <button class="button primary w-100">Edit</button>
         </div>
         <div class="nk-tb-col nk-tb-col-tools background-lighter">
            <form action="{{ route('admin-translation-post', 'delete') }}" method="post">
                @csrf
                <input type="hidden" name="trans" value="{{request()->get('trans')}}">
                <input type="hidden" name="key" value="{{$key}}">
                <h5><button class="ml-3 btn text-danger"><em class="icon ni ni-trash"></em></button></h5>
            </form>
         </div>
      </div>
      @endforeach
   </div>
</div>


@endsection
