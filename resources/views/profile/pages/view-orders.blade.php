@extends('profile.layouts.app')
@section('content')
<div class="container mt-7">
  <div class="nk-block-head-content mb-4">
    <h5>{{ __('Hey') }}, {{ $order->details->first_name ?? '' }}</h5>
    <br>
    <h3 class="nk-block-title page-title">{{ __('Products ordered') }} - <small>{{ $order->delivered == 1 ? 
    "Completed" : 'Pending' }}</small></h3></div>
  <div class="row">
    @foreach ($products as $key => $items)
    <div class="col-md-6">
      <div class="card card-shadow bdrs-15 p-3 mb-3">
        <div class="d-flex">
          <div class="user-avatar mr-3">
           <img src="{{ getfirstproductimg($key) }}" alt=" ">
          </div>
          <div>
            <h5 class="f-15 m-0">{{$items['name']}}</h5>
            <span>{{ __('Qty') }} - {{$items['qty']}}</span>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@stop