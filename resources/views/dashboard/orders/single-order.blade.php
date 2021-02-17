@extends('layouts.app')
@section('title', __('Order'))
@section('content')
<div class="container mt-8">
  <div class="row">
  <div class="col-md-6 order-md-2 mt-4">
  <div class="nk-block-head-content mb-4"><h3 class="nk-block-title page-title">{{ __('Products ordered') }}</h3></div>
    @foreach ($products as $key => $items)
    <div class="col-md-12">
      <div class="card card-shadow bdrs-15 p-3 mb-3">
        <div class="d-flex">
          <div class="user-avatar mr-3">
           <img src="{{ getfirstproductimg($key) }}" alt=" ">
          </div>
          <div>
            <h5 class="f-15 m-0">{{$items['name']}}</h5>
            <span>{{ __('Qty') }} - {{$items['qty']}}</span>
            <span class="d-block">{{ __('Options') }} - {{$items['options']}}</span>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
    <div class="card card-shadow mt-4 card-inner col-md-6 order-md-1 bdrs-15">
      <div class="nk-block-head-content mb-4"><h3 class="nk-block-title page-title">{{ __('Buyer details') }}</h3></div>
      <div class="row">
            <div class="col-md-12">
              <div class="card card-bordered mb-3 bdrs-15">
                 <div class="card-inner">
                   <div class="nk-cov-wg1">
                       <div class="card-title">
                           <h5 class="title">{{ __('Gateway') }} - {{ $order->gateway }}</small></h5>
                       </div>
                    </div>
                 </div>
             </div>
            </div>
          @foreach ($order->details as $key => $value)
            <div class="col-md-12">
              <div class="card card-bordered mb-3 bdrs-15">
                 <div class="card-inner">
                   <div class="nk-cov-wg1">
                       <div class="card-title">
                           <h5 class="title">{{ ucwords(str_replace('_', ' ', $key)) }} - <small>{{ $value ?? '' }}</small></h5>
                       </div>
                    </div>
                 </div>
             </div>
            </div>
          @endforeach
      </div>
    </div>
  </div>
</div>
  @stop