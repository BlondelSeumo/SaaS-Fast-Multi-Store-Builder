@extends('layouts.app')
@section('title', __('Orders'))
@section('content')
@section('footerJS')
<script src="{{ url('js/others.js') }}"></script>
@stop
<div class="nk-block-head mt-7">
  <div class="row">
    <div class="col-6 d-flex align-items-center">
      <div class="nk-block-head-content">
         <h3 class="nk-block-title fw-normal">{{ __('Orders') }}</h3>
      </div>
    </div>
    <div class="col-6">
      <div class="nk-block-head-content mb-3">
         <div class="nk-block-tools justify-content-right">
         </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="nk-tb-list is-separate is-medium mb-3 mt-1">
     <div class="nk-tb-item card-shadow nk-tb-head">
        <div class="nk-tb-col nk-tb-col-check">
           <div class="custom-control custom-control-sm custom-checkbox notext select_all">
            <input type="checkbox" class="custom-control-input" id="select_all">
            <label class="custom-control-label" for="select_all"></label>
          </div>
        </div>
        <div class="nk-tb-col"><span>{{ __('Ref') }}</span></div>
        <div class="nk-tb-col tb-col-md"><span>{{ __('Gateway') }}</span></div>
        <div class="nk-tb-col tb-col-md"><span>{{ __('Date') }}</span></div>
        <div class="nk-tb-col"><span class="d-none d-md-block">{{ __('Status') }}</span></div>
        <div class="nk-tb-col tb-col-sm"><span>{{ __('Name') }}</span></div>
        <div class="nk-tb-col tb-col-md"><span>{{ __('Purchased') }}</span></div>
        <div class="nk-tb-col"><span>{{ __('Total') }}</span></div>
        <div class="nk-tb-col nk-tb-col-tools">
           <ul class="nk-tb-actions gx-1 my-n1">
              <li>
                 <div class="drodown">
                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger mr-n1" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                    <div class="dropdown-menu dropdown-menu-right">
                       <ul class="link-list-opt no-bdr">
                          <li><a class="update_all" data-route="{{ route('user-order-status') }}" data-type="mark_as_delivered"><em class="icon ni ni-truck"></em><span>{{ __('Mark as Delivered') }}</span></a></li>
                          <li><a class="update_all" data-route="{{ route('user-order-status') }}" data-type="remove"><em class="icon ni ni-trash"></em><span>{{ __('Remove Orders') }}</span></a></li>
                       </ul>
                    </div>
                 </div>
              </li>
           </ul>
        </div>
     </div>
    @foreach($orders as $order)
     <div class="nk-tb-item card-shadow">
        <div class="nk-tb-col nk-tb-col-check">
           <div class="custom-control custom-control-sm custom-checkbox notext">
            <input type="checkbox" name="action_select[]" value="{{ $order->id }}" class="custom-control-input" id="{{ 'select_'.$order->id }}">
            <label class="custom-control-label" for="{{ 'select_'.$order->id }}"></label>
          </div>
        </div>
        <div class="nk-tb-col"><span class="tb-lead"><a href="#">{{ $order->ref }}</a></span></div>
        <div class="nk-tb-col tb-col-md"><span>{{ $order->gateway }}</span></div>
        <div class="nk-tb-col tb-col-md"><span class="tb-sub">{{ \Carbon\Carbon::parse($order->created_at)->toFormattedDateString() }}</span></div>
        <div class="nk-tb-col">
          <span class="dot bg-{{ ($order->delivered == 1) ? 'success' : 'warning' }} d-md-none"></span>
          <span class="badge badge-sm badge-dot has-bg badge-{{ ($order->delivered == 1) ? 'success' : 'warning' }} d-none d-md-inline-flex">{{ ($order->delivered == 1) ? __('Delivered') : __('Pending') }}</span>
        </div>
        <div class="nk-tb-col tb-col-sm"><span class="tb-sub">{{ $order->details->first_name . ' ' . $order->details->last_name ?? ''  }}</span></div>
        <div class="nk-tb-col tb-col-md"><span class="tb-sub text-primary">{{ count($order->products) }}</span></div>
        <div class="nk-tb-col"><span class="tb-lead">{!! clean(Currency::symbol(user('gateway.currency')), 'titles') .' '. number_format($order->price) !!}</span></div>
        <div class="nk-tb-col nk-tb-col-tools">
           <ul class="nk-tb-actions gx-1">
              <li class="d-none d-lg-block">
                <form action="{{ route('user-order-status') }}" method="post">
                  @csrf
                  <input type="hidden" name="id" value="{{ $order->id }}">
                  <input type="hidden" name="action" value="mark_as_delivered">
                  <button class="btn btn-icon btn-trigger btn-tooltip" title="{{ __('Mark as Delivered') }}" data-confirm="{{ __('Are you sure?') }}">
                    <em class="icon ni ni-truck"></em>
                  </button>
                </form>
              </li>
              <li class="d-none d-lg-block">
                <a href="{{ route('user-single-order', $order->id) }}" class="btn btn-icon btn-trigger btn-tooltip" title="{{ __('Order Details') }}">
                <em class="icon ni ni-eye"></em></a>
              </li>
              <li class="d-none d-lg-block">
                <form action="{{ route('user-order-status') }}" method="post">
                  @csrf
                  <input type="hidden" name="id" value="{{ $order->id }}">
                  <input type="hidden" name="action" value="remove">
                  <button class="btn btn-icon btn-trigger text-danger btn-tooltip" title="{{ __('Remove Order') }}" data-confirm="{{ __('Are you sure you want to remove this order?') }}">
                    <em class="icon ni ni-trash"></em>
                  </button>
                </form>
              </li>
              <li class="d-lg-none">
                 <div class="drodown mr-n1">
                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                    <div class="dropdown-menu dropdown-menu-right">
                       <ul class="link-list-opt no-bdr">
                          <li>
                            <a href="{{ route('user-single-order', $order->id) }}"><em class="icon ni ni-eye"></em><span>{{ __('Order Details') }}</span></a>
                          </li>
                          <li>
                            <form action="{{ route('user-order-status') }}" method="post">
                              @csrf
                              <input type="hidden" name="id" value="{{ $order->id }}">
                              <input type="hidden" name="action" value="mark_as_delivered">
                              <button class="btn" title="{{ __('Remove Order') }}" data-confirm="{{ __('Are you sure?') }}">
                                <em class="icon ni ni-truck"></em>
                                <span>{{ __('Mark as Delivered') }}</span>
                              </button>
                            </form>
                          </li>
                          <li>
                            <form action="{{ route('user-order-status') }}" method="post">
                              @csrf
                              <input type="hidden" name="id" value="{{ $order->id }}">
                              <input type="hidden" name="action" value="remove">
                              <button class="btn" title="{{ __('Remove Order') }}" data-confirm="{{ __('Are you sure you want to remove this order?') }}">
                                <em class="icon ni ni-trash"></em>
                                <span>{{ __('Remove Order') }}</span>
                              </button>
                            </form>
                          </li>
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
          {{ $orders->links() }}
        </div>
        </div>
      </div>
    </div>
</div>
@stop