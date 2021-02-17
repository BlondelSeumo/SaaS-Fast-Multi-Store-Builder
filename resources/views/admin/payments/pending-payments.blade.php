@extends('admin.layouts.app')

@section('title', __('Payments'))
@section('content')
<div class="nk-block-head">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('Pending Payments') }}</h2>
        </div>
    </div>
</div>
@if (count($options->payments) > 0)
<div class="nk-block">
   <div class="nk-tb-list is-separate is-medium mb-3">
      <div class="nk-tb-item nk-tb-head">
         <div class="nk-tb-col"><span>{{ __('Proof') }}</span></div>
         <div class="nk-tb-col tb-col-md"><span>{{ __('Name | Bank Name') }}</span></div>
         <div class="nk-tb-col"><span>{{ __('User') }}</span></div>
         <div class="nk-tb-col"><span>{{ __('Status') }}</span></div>
         <div class="nk-tb-col tb-col-sm"><span class="d-none d-md-block">{{ __('Package | Duration') }}</span></div>
         <div class="nk-tb-col"><span>{{ __('Date') }}</span></div>
         <div class="nk-tb-col"></div>
      </div>
      @foreach ($options->payments as $item)
          
      <div class="nk-tb-item background-lighter">
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead"><a href="{{ url('media/user/bankProof/'.$item->proof) }}">{{Str::limit($start = $item->proof,  $limit = 10, $end = '...')}}</a></span>
         </div>
         <div class="nk-tb-col tb-col-md background-lighter">
            <span class="tb-sub">{{ucfirst($item->name)}} | {{ucfirst($item->bankName)}}</span>
         </div>
         <div class="nk-tb-col background-lighter">
            <span class="tb-sub"><a href="">{{$item->username}}</a></span>
         </div>
         <div class="nk-tb-col background-lighter">
            <span class="dot bg-warning d-md-none {{$item->status == 0 ? ' badge-warning' : NULL }} {{$item->status == 1 ? ' badge-success' : NULL }} {{$item->status == 2 ? ' badge-danger' : NULL }}"></span>
            <span class="badge badge-sm badge-dot has-bg {{$item->status == 0 ? ' badge-warning' : NULL }} {{$item->status == 1 ? ' badge-success' : NULL }} {{$item->status == 2 ? ' badge-danger' : NULL }} d-none d-md-inline-flex">{{$item->status == 0 ? 'Pending' : NULL}} {{$item->status == 1 ? 'Activated' : NULL }} {{$item->status == 2 ? 'Declined' : NULL }}</span>
         </div>
         <div class="nk-tb-col tb-col-md background-lighter">
            <span class="tb-sub text-primary">{{ucfirst($item->package_name)}} | {{ucfirst($item->duration)}}</span>
        </div>
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead">{{ Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span>
        </div>
         <div class="nk-tb-col nk-tb-col-tools background-lighter">
            <ul class="nk-tb-actions gx-1">
               <li>
                  <div class="drodown mr-n1">
                     <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                     <div class="dropdown-menu dropdown-menu-right" style="">
                        <ul class="link-list-opt no-bdr">
                           <li><a href="{{ route('admin-activate-pendiing-payments', ['type' => 'approve' , 'id' => $item->id]) }}" data-confirm="{{ __('Are you sure you want to approve this payment?') }}"><em class="icon ni ni-check-round"></em><span>{{ __('Approve') }}</span></a></li>
                           <li><a href="{{ route('admin-activate-pendiing-payments', ['type' => 'decline' , 'id' => $item->id]) }}" data-confirm="{{ __('Are you sure you want to decline this payment?') }}"><em class="icon ni ni-cross-round"></em><span>{{ __('Decline') }}</span></a></li>
                           <li><a href="{{ route('admin-activate-pendiing-payments', ['type' => 'delete' , 'id' => $item->id]) }}" data-confirm="{{ __('Are you sure you want to delete this payment?') }}"><em class="icon ni ni-trash"></em><span>{{ __('Delete') }}</span></a></li>
                        </ul>
                     </div>
                  </div>
               </li>
            </ul>
         </div>
      </div>
    @endforeach
   </div>
   <div class="card">
      <div class="card-inner">
         <div class="nk-block-between-md g-3">
            <div class="g">
               {{$options->payments->withQueryString()->links()}}
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
