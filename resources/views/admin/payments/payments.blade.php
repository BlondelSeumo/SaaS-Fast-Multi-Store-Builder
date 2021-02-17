@extends('admin.layouts.app')

@section('title', __('Payments'))
@section('content')
<div class="nk-block-head">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('Payments') }}</h2>
        </div>
    </div>
</div>

<form class="mb-4">
  <div class="row">
      <div class="col-md-6 mb-3">
        <div class="form-group">
          <input type="text" class="form-control form-control-lg" name="email" placeholder="Search by email" value="{{request()->get('email')}}">
        </div>
        <button class="btn btn-primary btn-block">{{ __('Search') }}</button>
      </div>
      <div class="col-md-6">
        <div class="form-group mb-3">
          <input type="text" class="form-control form-control-lg" name="ref" placeholder="Search by ref" value="{{request()->get('ref')}}">
        </div>
        <button class="btn btn-primary btn-block">Search</button>
      </div>
  </div>
</form>

@if (count($payments) > 0)
<div class="nk-block">
   <div class="nk-tb-list is-separate is-medium mb-3">
      <div class="nk-tb-item nk-tb-head">
         <div class="nk-tb-col"><span>{{ __('User') }}</span></div>
         <div class="nk-tb-col tb-col-md"><span>{{ __('Name') }}</span></div>
         <div class="nk-tb-col"><span>{{ __('Email') }}</span></div>
         <div class="nk-tb-col tb-col-sm"><span class="d-none d-md-block">{{ __('Package | Duration') }}</span></div>
         <div class="nk-tb-col tb-col-sm"><span class="d-none d-md-block">{{ __('Ref') }}</span></div>
         <div class="nk-tb-col"><span>{{ __('Date') }}</span></div>
      </div>
      @foreach ($payments as $item)
      <div class="nk-tb-item background-lighter">
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead"><a href="{{ url(route('admin-users') . '/' . $item->user) }}">{{$item->username}}</a></span>
         </div>
         <div class="nk-tb-col tb-col-md background-lighter">
            <span class="tb-sub">{{ucfirst($item->name)}}</span>
         </div>
         <div class="nk-tb-col background-lighter">
            <span class="tb-sub">{{ucfirst($item->email)}}</span>
         </div>
         <div class="nk-tb-col tb-col-md background-lighter">
            <span class="tb-sub">{{ucfirst(empty($item->packages_name) ? $item->package_name : $item->packages_name)}} | {{ucfirst($item->duration)}}</span>
        </div>
         <div class="nk-tb-col tb-col-md background-lighter">
            <span class="tb-sub">{{$item->ref}}</span>
        </div>
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead">{{ Carbon\Carbon::parse($item->date)->toFormattedDateString() }}</span>
        </div>
      </div>
    @endforeach
   </div>
   <div class="card">
      <div class="card-inner">
         <div class="nk-block-between-md g-3">
            <div class="g">
               {{$payments->withQueryString()->links()}}
            </div>
         </div>
      </div>
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
