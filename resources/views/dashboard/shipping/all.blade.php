@extends('layouts.app')

@section('title', __('Shipping'))
@section('content')
<div class="nk-block-head mt-8">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('Shipping') }}</h2>
        </div>
        <div class="nk-block-head-content">
            <a href="{{ route('user-add-shipping') }}" class="btn btn-primary"><em class="icon ni ni-plus"></em> {{ __('Add new location') }}</a>
        </div>
    </div>
</div>


@if (!empty($user->shipping))
<div class="nk-block">
   <div class="nk-tb-list is-separate is-medium mb-3">
      <div class="nk-tb-item nk-tb-head">
         <div class="nk-tb-col"><span>{{ __('Domain') }}</span></div>
         <div class="nk-tb-col"><span>{{ __('State') }}</span></div>
         <div class="nk-tb-col d-none d-md-inline-flex"><span>{{ __('Updated on') }}</span></div>
         <div class="nk-tb-col"></div>
         <div class="nk-tb-col"></div>
      </div>
      @foreach ($user->shipping as $key => $value)
      <div class="nk-tb-item background-lighter">
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead">{{ $key }}</span>
         </div>
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead">{{ count(user('shipping.'.$key)) }}</span>
         </div>
         <div class="nk-tb-col tb-col-md background-lighter">
            <span class="tb-sub text-primary"></span>
        </div>
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead"><a href="{{ route('user-edit-shipping', $key) }}" class="btn btn-primary">{{ __('Edit') }}</a></span>
        </div>
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead"><a href="" data-confirm="{{ __('Are you sure you want to delete this?') }}" class="btn btn-danger">{{ __('Delete') }}</a></span>
        </div>
      </div>
    @endforeach
   </div>
</div>
@else
<div class="nk-block-head">
   <div class="nk-block-head-content text-center">
       <h5 class="nk-block-title fw-normal">{{ __('Nothing found') }}</h5>
   </div>
</div>
@endif
@endsection