@extends('admin.layouts.app')

@section('title', __('Domains'))
@section('content')
<div class="nk-block-head">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('Domains Management') }}</h2>
        </div>
        <div class="nk-block-head-content">
            <a href="{{ route('admin-domains-post') }}" class="btn btn-primary"><em class="icon ni ni-plus"></em> {{ __('Add new domain') }}</a>
        </div>
    </div>
</div>


@if (count($domains) > 0)
<div class="nk-block">
   <div class="nk-tb-list is-separate is-medium mb-3">
      <div class="nk-tb-item nk-tb-head">
         <div class="nk-tb-col"><span>{{ __('Domain') }}</span></div>
         <div class="nk-tb-col"><span>{{ __('Status') }}</span></div>
         <div class="nk-tb-col"><span>{{ __('Users') }}</span></div>
         <div class="nk-tb-col"><span>{{ __('Owner') }}</span></div>
         <div class="nk-tb-col"><span>{{ __('Updated on') }}</span></div>
         <div class="nk-tb-col"></div>
         <div class="nk-tb-col"></div>
      </div>
      @foreach ($domains as $item)
          
      <div class="nk-tb-item background-lighter">
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead">{{ ($item->host) }}</span>
         </div>
         <div class="nk-tb-col background-lighter">
            <span class="dot bg-warning d-md-none {{$item->status == 0 ? ' badge-warning' : NULL }} {{$item->status == 1 ? ' badge-success' : NULL }} {{$item->status == 2 ? ' badge-danger' : NULL }}"></span>
            <span class="badge badge-sm badge-dot has-bg {{$item->status == 0 ? ' badge-warning' : NULL }} {{$item->status == 1 ? ' badge-success' : NULL }} d-none d-md-inline-flex">{{$item->status == 0 ? 'In active' : NULL}} {{$item->status == 1 ? 'Active' : NULL }}</span>
         </div>
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead">{{ $item->total_domain }}</span>
         </div>
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead">{!! $item->user == null ? __('Global Domain') : user('username', $item->user) !!}</span>
         </div>
         <div class="nk-tb-col tb-col-md background-lighter">
            <span class="tb-sub text-primary">{{ Carbon\Carbon::parse($item->updated_at)->toFormattedDateString() }}</span>
        </div>
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead"><a href="{{ route('admin-domains-post', ['id' => $item->id]) }}" class="btn btn-primary">{{ __('Edit') }}</a></span>
        </div>
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead"><a href="{{ route('admin-domains-post', ['id' => $item->id, 'delete' => true]) }}" data-confirm="{{ __('Are you sure you want to delete this?') }}" class="btn btn-danger">{{ __('Delete') }}</a></span>
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