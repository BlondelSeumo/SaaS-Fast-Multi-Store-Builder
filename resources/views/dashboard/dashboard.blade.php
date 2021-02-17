@extends('layouts.app')
@section('title', __('Dashboard'))
@section('content')
@section('footerJS')
  <script>
        var totalSales = {
            labels: {!! $options->sales_chart['labels'] ?? '[]' !!},
            dataUnit: "Sales",
            lineTension: .3,
            datasets: [{
                label: "Sales",
                color: "#9d72ff",
                background: NioApp.hexRGB("#9d72ff", .25),
                data: {!! $options->sales_chart['sales'] ?? '[]' !!}
            }]
        };
   var storeVisitors = {
         labels: {!! $options->this_month_chart['labels'] ?? '[]' !!},
         dataUnit: "{{ __('Visitors') }}",
         lineTension: .4,
         legend: !0,
       datasets:[{
        label: "{{ __('Impression') }}",
        color:"#c4cefe",
        dash:[5],
        background:"transparent",
        data:{!! $options->this_month_chart['impression'] ?? '[]' !!}},{
        label: "{{ __('Unique') }}",
        color:"#798bff",
        dash:0,
        background:NioApp.hexRGB("#798bff",.15),
        data:{!! $options->this_month_chart['unique'] ?? '[]' !!}}]
     };
  </script>
  <script src="{{ url('js/jqvmap.js') }}"></script>
@stop
@if ($user->role == 1)
<div class="mt-5">
  <div class="card bg-warning text-white">
    <div class="card-inner">
      <div class="dashboard-info row">
          <div class="info-text col-md-6">
              <h5 class="card-title">{{ __('Hey, Admin')}}</h5>
              <p>{{ __("You are currently logged in as admin. Use the right button to access your admin dashboard.") }}</p>
          </div>
          <div class="info-image col-md-6">
            <div class="d-lg-flex justify-content-end">
               <a href="{{ route('admin-home') }}" class="ml-3 btn btn-white mt-3 fs-12px">{{ __('Go to admin Dashboard') }}</a>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
@endif
<div class="row mt-4">
     <div class="col-md-8">
         <div class="card bg-info text-white">
             <div class="card-body">
                 <div class="dashboard-info row">
                     <div class="info-text col-md-6">
                         <h5 class="card-title">{{ __('Welcome back') .' '. full_name($user->id)}}</h5>
                         <p>{{ __('View store statistics from here or copy the link below to share to various platforms/social media\'s') }}</p>
                        <div class="form-control-wrap">
                           <div class="form-clip clipboard-init" data-clipboard-target="#refUrl" data-success="{{ __('copied') }}" data-text="Copy Link"><em class="clipboard-icon icon ni ni-copy"></em> <span class="clipboard-text">{{ __('Copy link') }}</span></div>
                           <div class="form-icon">
                              <em class="icon ni ni-link-alt"></em>
                           </div>
                           <input type="text" class="form-control border-0 copy-text" id="refUrl" readonly="" value="{{ url($profile_url) }}">
                        </div>
                         <a href="{{ url($profile_url) }}" class="btn btn-warning mt-3">{{ __('View Store') }}</a>
                         <a href="{{ url('media/user/qrcode/'.$user->username.'.png') }}" download="Qrcode.png" class="ml-3 btn btn-primary mt-3 fs-12px">{{ __('Download qrcode') }}</a>
                     </div>
                     <div class="info-image col-md-6">
                       <img src="{{ url('media/pixeltrue-data-analyse-1.png') }}" alt="">
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="col-md-4">
         <div class="card  mt-4">
             <div class="card-body">
              <div class="card-inner">
                  <div class="card-title-group align-start mb-0">
                        <div class="card-title">
                            <h6 class="subtitle">{{ __('This Month') }}</h6>
                        </div>
                        <div class="card-tools">
                            <a href="{{ route('user-orders') }}" class="link">{{ __('View Orders') }}</a>
                        </div>
                    </div>
                    <div class="card-amount">
                        <span class="amount"> {!! number_format($options->sales['this_month']) !!} <span class="currency currency-usd">{!! Currency::symbol(user('gateway.currency')) !!}</span>
                        </span>
                        <span class="change {{ !empty($options->sales['last_month_percent']['updown']) && $options->sales['last_month_percent']['updown'] == 'up' ? 'up' : 'down' }} text-danger"><em class="icon ni ni-arrow-long-{{ !empty($options->sales['last_month_percent']['updown']) && $options->sales['last_month_percent']['updown'] == 'up' ? 'up' : 'down' }}"></em>{{  !empty($options->sales['last_month_percent']['percent']) ? number_format($options->sales['last_month_percent']['percent'], 2) : '0' }}%</span>
                    </div>
                    <div class="invest-data">
                        <div class="invest-data-amount g-2">
                            <div class="invest-data-history">
                                <div class="title">{{ __('Total') }}</div>
                                <div class="amount">{!! number_format($options->sales['total'] ?? 0) !!} <span class="currency currency-usd">{!! Currency::symbol(user('gateway.currency')) !!}</span></div>
                            </div>
                            <div class="invest-data-history">
                                <div class="title">{{ __('Last Month') }}</div>
                                <div class="amount">{!! number_format($options->sales['last_month']) !!} <span class="currency currency-usd">{!! Currency::symbol(user('gateway.currency')) !!}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
         </div>
     </div>                   
 </div>
 <div class="row mt-5">
  <div class="col-md-4">
    <div class="card bg-warning radius-10 text-white card-stats mb-4 mb-lg-0">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase mb-0">{{ __('Orders') }}</h5>
            <span class="h2 font-weight-bold mb-0">{{ number_format($options->sales['total_orders']) }}</span>
          </div>
          <div class="col-auto d-flex align-center">
            <div>
              <i class="ni ni-bag fs-20px"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card bg-danger radius-10 text-white card-stats mb-4 mb-lg-0">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase mb-0">{{ __('Products') }}</h5>
            <span class="h2 font-weight-bold mb-0">{{ App\Model\Products::where('user', user('id'))->count() ?? '' }}</span>
          </div>
          <div class="col-auto d-flex align-center">
            <div>
              <i class="ni ni-users fs-20px"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-shadow-2 radius-10 card-stats mb-4 mb-lg-0">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase mb-0">{{ __('Package') }}</h5>
            <span class="h2 font-weight-bold mb-0">{{ package('name') }}</span>
          </div>
          <div class="col-auto d-flex align-center">
            <div>
              <i class="ni ni-box fs-20px"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row mb-4 mt-5">
  <div class="col-12 mt-4">
    <div class="card card-shadow bdrs-20 h-100">
       <div class="card-inner">
          <div class="card-title-group mb-2">
             <div class="card-title">
                <h6 class="title">{{ __('Top products') }}</h6>
             </div>
          </div>
          <ul class="nk-top-products">
            @foreach ($options->topproducts as $key => $items)
             <li class="item">
                <div class="thumb"><img src="{{ getfirstproductimg($key) }}" alt=""></div>
                <div class="info">
                   <div class="title">{{$items['name']}}</div>
                   <div class="price">{!! Currency::symbol(user('gateway.currency')) . number_format($items['price']) !!}</div>
                </div>
                <div class="total">
                   <div class="amount">{!! Currency::symbol(user('gateway.currency')) .  number_format($items['earned']) !!}</div>
                   <div class="count">{!! number_format($items['sold']) !!} {{ __('Sold') }}</div>
                </div>
             </li>
            @endforeach
          </ul>
       </div>
    </div>
  </div>

  @if (package('settings.statistics'))
  <div class="col-md-4">
    <div class="card mt-6">
        <div class="card-body">
         <div class="card-inner">
           <div class="card-title-group align-start mb-0">
                  <div class="card-title">
                      <h6 class="subtitle"></h6>
                  </div>
              </div>
              <div class="card-amount">
                  <span class="amount"> {{ __('Store Visitors') }} </span>
              </div>
              <div class="invest-data">
                  <div class="invest-data-amount g-2">
                      <div class="invest-data-history">
                          <div class="title">{{ __('This Month') }}</div>
                          <div class="amount">{{ __('Visits') }} - {{ nr($options->year['impression'] ?? '0') }} | <span class="currency currency-usd">{{ __('Unique') }} - {{ nr($options->year['unique'] ?? '0') }}</span></div>
                      </div>
                  </div>
              </div>
              <div class="invest-data mt-4">
                  <div class="invest-data-amount g-2">
                      <div class="invest-data-history">
                          <div class="title">{{ __('This Year') }}</div>
                          <div class="amount">{{ __('Vists') }} - {{ nr($options->month['impression'] ?? '0') }} <span class="currency currency-usd">{{ __('Unique') }} - {{ nr($options->month['unique'] ?? '0') }}</span></div>
                      </div>
                  </div>
              </div>
           </div>
        </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card card-shadow-2 card-inner mt-6">
      <div class="nk-ecwg8-ck">
         <canvas class="line-chart" id="storeVisitors"></canvas>
      </div>
    </div>
  </div>
  @endif

  @if (package('settings.statistics'))
  <div class="col-md-12 mt-5">
     <div class="card card-shadow-2 mt-4">
        <div class="card-inner">
           <div class="card-title-group">
              <div class="card-title">
                 <h6 class="title">{{ __('Recent Orders') }}</h6>
              </div>
           </div>
        </div>
        <div class="nk-tb-list mt-n2">
       <div class="nk-tb-item nk-tb-head">
          <div class="nk-tb-col"><span>{{ __('Ref') }}</span></div>
          <div class="nk-tb-col tb-col-md"><span>{{ __('Date') }}</span></div>
          <div class="nk-tb-col"><span class="d-none d-md-block">{{ __('Status') }}</span></div>
          <div class="nk-tb-col tb-col-sm"><span>{{ __('Name') }}</span></div>
          <div class="nk-tb-col tb-col-md"><span>{{ __('Purchased') }}</span></div>
          <div class="nk-tb-col"><span>{{ __('Total') }}</span></div>
          <div class="nk-tb-col nk-tb-col-tools"></div>
       </div>
        @foreach($options->sales['recent_orders'] as $order)
         <div class="nk-tb-item">
            <div class="nk-tb-col"><span class="tb-lead"><a href="#">{{ $order->ref }}</a></span></div>
            <div class="nk-tb-col tb-col-md"><span class="tb-sub">{{ Carbon\Carbon::parse($order->created_at)->toFormattedDateString() }}</span></div>
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
                    <a href="{{ route('user-single-order', $order->id) }}" class="btn btn-icon btn-trigger btn-tooltip" title="{{ __('Order Details') }}">
                    <em class="icon ni ni-eye"></em></a>
                  </li>
                  <li class="d-lg-none">
                     <div class="drodown mr-n1">
                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                        <div class="dropdown-menu dropdown-menu-right">
                           <ul class="link-list-opt no-bdr">
                              <li>
                                <a href="{{ route('user-single-order', $order->id) }}"><em class="icon ni ni-eye"></em><span>{{ __('Order Details') }}</span></a>
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
     </div>
  </div>
  @endif
</div>

@endsection
