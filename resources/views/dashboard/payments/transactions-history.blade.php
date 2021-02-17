@extends('layouts.app')

@section('title', __('Transactions History'))
@section('content')
<div class="nk-block-head mt-8">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('Transactions History') }}</h2>
        </div>
    </div>
</div>

<div class="row">
  <div class="col-md-6 d-flex align-center">
     <div class="card card-shadow bdrs-20 w-100">
         <div class="card-inner">
             <div class="nk-wg7">
                 <div class="nk-wg7-stats">
                     <div class="nk-wg7-title">{{ __('Total Transactions') }}</div>
                     <div class="number-lg amount">{{ $payments->total() }}</div>
                 </div>
             </div><!-- .nk-wg7 -->
         </div><!-- .card-inner -->
     </div><!-- .card -->
  </div>
  <div class="col-md-6">
    <div class="nk-ck mt-5 card-shadow card-inner bdrs-20">
        <canvas class="line-chart" id="paymentsvisitschart"></canvas>
    </div>
  </div>
</div>
@if (count($payments) > 0)
<div class="nk-block mt-6 card card-inner card-shadow bdrs-20">
   <div class="nk-tb-list is-separate is-medium mb-3">
      <div class="nk-tb-item nk-tb-head">
         <div class="nk-tb-col"><span>{{ __('Name') }}</span></div>
         <div class="nk-tb-col tb-col-md"><span>{{ __('Email') }}</span></div>
         <div class="nk-tb-col"><span>{{ __('Price') }}</span></div>
         <div class="nk-tb-col tb-col-sm"><span class="d-none d-md-block">{{ __('Package | Duration') }}</span></div>
         <div class="nk-tb-col"><span>{{ __('Date') }}</span></div>
         @if (settings('business.enabled'))
          <div class="nk-tb-col"></div>
         @endif
      </div>
      @foreach ($payments as $item)
          
      <div class="nk-tb-item background-lighter">
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead">{{ $item->name }}</span>
         </div>
         <div class="nk-tb-col tb-col-md background-lighter">
            <span class="tb-sub">{{ucfirst($item->email)}}</span>
         </div>
         <div class="nk-tb-col background-lighter">
            <span class="tb-sub">{{ $item->price }}</span>
         </div>
         <div class="nk-tb-col tb-col-md background-lighter">
            <span class="tb-sub text-primary">{{ucfirst($item->package_name)}} | {{ucfirst($item->duration)}}</span>
        </div>
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead">{{ Carbon\Carbon::parse($item->date)->toFormattedDateString() }}</span>
        </div>
        @if (settings('business.enabled'))
         <div class="nk-tb-col background-lighter">
            <span class="tb-lead"><a href="{{ route('user-transactions', ['invoice_id' => $item->id]) }}" class="btn btn-primary">{{ __('View invoice') }}</a></span>
        </div>
        @endif
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
@section('footerJS')
<script>
   var paymentsvisitschart = {
         labels: {!! !empty($paymentschart['labels']) ? $paymentschart['labels'] : '[0]' !!},
         dataUnit: "",
         lineTension: .4,
         legend: !0,
       datasets:[{
        label: "{{ __('Total payments') }}",
        color:"#000000",
        dash:[5],
        background:"transparent",
        data:{!! !empty($paymentschart['count']) ? $paymentschart['count'] : '[]' !!}},{
        label: "{{ __('Paid') }}",
        color:"#a0aec0",
        dash:0,
        background:NioApp.hexRGB("#798bff",.15),
        data:{!! !empty($paymentschart['amount']) ? $paymentschart['amount'] : '[]' !!}}]
   };
</script>
@stop
@endsection
