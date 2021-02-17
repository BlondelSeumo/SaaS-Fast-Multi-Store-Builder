@extends('admin.layouts.app')
@section('title', __('Admin'))
@section('content')
<div class="nk-block-head-content mb-5">
   <h4 class="nk-block-title fw-normal"><em class="icon ni ni-shield"></em> <span>{{ __('Admin') }}</span></h4>
   <p class="m-0">{{ __('Manage your users, payments, packages from here') }}</p>
</div>
<div class="row">
  <div class="col-lg-8">
   <div class="card card-shadow bdrs-20 h-100">
      <div class="card-inner">
         <div class="card-title-group align-start mb-3">
            <div class="card-title">
               <h6 class="title">{{ __('Brief Stats') }}</h6>
               <p>
                {{ __('In last 30 days sales overview.') }}
                <a href="{{ route('admin-stats') }}" class="link link-sm">{{ __('Detailed Stats') }}</a></p>
            </div>
         </div>
         <div class="nk-order-ovwg">
            <div class="row g-4 align-end">
               <div class="col-xxl-8">
                  <div class="nk-order-ovwg-ck">
                     <canvas class="order-overview-chart" id="orderOverview"></canvas>
                  </div>
               </div>
               <div class="col-xxl-4">
                  <div class="row g-4">
                     <div class="col-sm-6 col-xxl-12">
                        <div class="nk-order-ovwg-data bdrs-20 buy">
                           <div class="amount">{{$payments[0]->payment}}
                            <small class="currenct currency-usd">{{ __('Payments this month') }}</small>
                            </div>
                           <div class="info">{{ __('This month') }}
                            <strong>{{$payments[0]->earnings . settings('currency') }}
                              <span class="currenct currency-usd">{{ __('Earnings') }}</span>
                            </strong>
                           </div>
                           <div class="title"><a href="{{ route('payments') }}">{{ __('All payments') }}</a> <em class="icon ni ni-arrow-right"></em></div>
                        </div>
                     </div>
                     <div class="col-sm-6 col-xxl-12">
                        <div class="nk-order-ovwg-data bdrs-20 sell">
                           <div class="amount">{{$users[0]->all_users}} <small class="currenct currency-usd">{{ __('Users') }}</small></div>
                           <div class="info">{{ __('Active month ') }}
                            <strong>{{$users[0]->active_users_month}} <span class="currenct currency-usd">{{ __('users') }}</span></strong>
                           </div>
                           <div class="title"><a href="{{ route('admin-users') }}">{{ __('All users') }}</a> <em class="icon ni ni-arrow-right"></em></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

  <div class="col-lg-4 mt-5 mt-lg-0">
   <div class="card card-shadow bdrs-20 h-100">
      <div class="card-inner-group">
         <div class="card-inner">
            <div class="card-title-group">
               <div class="card-title">
                  <h6 class="title">{{ __('Action Center') }}</h6>
               </div>
            </div>
         </div>
         <div class="card-inner">
            <div class="nk-wg-action">
               <div class="nk-wg-action-content">
                  <em class="icon ni ni-cc-alt-fill"></em>
                  <div class="title">{{ __('Add package') }}</div>
                  <p>{!! __('You have <strong>'.$sidebarR->countPackages.'</strong> packages. You can check them here!') !!}</p>
               </div>
               <a href="{{ route('admin-packages') }}" class="btn btn-icon btn-trigger mr-n2"><em class="icon ni ni-forward-ios"></em></a>
            </div>
         </div>
         <div class="card-inner">
            <div class="nk-wg-action">
               <div class="nk-wg-action-content">
                  <em class="icon ni ni-help-fill"></em>
                  <div class="title">{{ __('Products') }}</div>
                  <p>{!! __('You have') .' <strong>'.count(\App\Model\Products::get()).'</strong> '. __('Overall products on your platform') !!}</p>
               </div>
            </div>
         </div>
         <div class="card-inner">
            <div class="nk-wg-action">
               <div class="nk-wg-action-content">
                  <em class="icon ni ni-setting"></em>
                  <div class="title">{{ __('Settings') }}</div>
                  <p>{!! __('Update your admin settings here!') !!}</p>
               </div>
               <a href="{{ route('admin-settings') }}" class="btn btn-icon btn-trigger mr-n2"><em class="icon ni ni-forward-ios"></em></a>
            </div>
         </div>
      </div>
   </div>
  </div>
  <div class="col-lg-8 mt-5">
   <div class="card card-shadow bdrs-20 card-full">
      <div class="card-inner">
         <div class="card-title-group">
            <div class="card-title">
               <h6 class="title">
                <span class="mr-2">{{ __('New users') }} 
                  <span class="badge badge-primary rounded">{{count($newusers)}}</span>
                 </span>
                <a href="{{ route('admin-users') }}" class="link d-none d-sm-inline">{{ __('All users') }}</a>
              </h6>
            </div>
         </div>
      </div>
      <div class="card-inner p-0 border-top">
         <div class="nk-tb-list nk-tb-orders">
            <div class="nk-tb-item nk-tb-head">
               <div class="nk-tb-col"><span>{{ __('Avatar') }}</span></div>
               <div class="nk-tb-col"><span>{{ __('Name') }}</span></div>
               <div class="nk-tb-col tb-col-sm"><span>{{ __('Date') }}</span></div>
               <div class="nk-tb-col tb-col-xl"><span>{{ __('Time') }}</span></div>
               <div class="nk-tb-col"><span>{{ __('Action') }}</span></div>
            </div>
         @foreach ($newusers as $item)
            <div class="nk-tb-item">
               <div class="nk-tb-col">
                <div class="user-avatar bg-primary-dim">
                    <img src="{{ avatar($item->id) }}" alt="">
                </div>
               </div>

               <div class="nk-tb-col"><span class="tb-lead">{{full_name($item->id)}}</span></div>

               <div class="nk-tb-col tb-col-sm"><span class="tb-sub">{{ Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span></div>

               <div class="nk-tb-col tb-col-xl"><span class="tb-sub">
                @php
                   $d = new \DateTime($item->created_at);
                   $d = $d->format('H:i:s A');
                   echo $d;
                @endphp
              </span></div>

               <div class="nk-tb-col tb-col-sm">
                <div class="user-action">
                  <div class="drodown">
                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger mr-n1" data-toggle="dropdown" aria-expanded="false">
                      <em class="icon ni ni-more-h">
                      </em>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="">
                      <ul class="link-list-opt no-bdr">
                        <li>
                          <a href="{{ url("$item->username") }}" target="_blank">
                            <em class="icon ni ni-external-alt">
                            </em>
                            <span>{{ __('View profile') }}</span>
                          </a>
                        </li>
                        <li>
                          <a href="{{ url(route('admin-users') . '/' . $item->id) }}">
                            <em class="icon ni ni-edit">
                            </em>
                            <span>{{ __('Edit user') }}</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
               </div>
            </div>
          @endforeach
         </div>
      </div>
      <div class="card-inner-sm border-top text-center d-sm-none"><a href="{{ route('admin-users') }}" class="btn btn-link btn-block">{{ __('View all users') }}</a></div>
   </div>
</div>

  <div class="col-lg-4 mt-5">
    <div>
       <div class="card card-shadow bdrs-20 card-full">
          <div class="card-inner">
             <div class="card-title-group align-start mb-3">
                <div class="card-title">
                   <h6 class="title">{{ __('Top 5 users') }}</h6>
                   <p>{{ __('In last 365 days') }}</p>
                </div>
             </div>
             @foreach ($topusers as $item)
             <div class="user-activity-group g-4">
                <div class="user-activity">
                  <div class="user-avatar bg-primary-dim mr-4">
                      <img src="{{ avatar($item->user_id) }}" alt="">
                  </div>
                   <div class="info">
                    <span class="amount">{{$item->total}}</span>
                    <span class="title">{{full_name($item->user_id)}} <a href="{{url("$item->username")}}" target="_blank" class="btn-link ml-3">{{ __('View store') }}</a></span>
                  </div>
                </div>
             </div>
             @endforeach
          </div>
       </div>
    </div>
</div>
</div>
  @section('footerJS')
    <script>
    var orderOverview = {
        labels: {!! $paymentschart['labels'] ?? '[]' !!},
        dataUnit: "USD",
        datasets: [
            {
              label: "Sales",
              color: "#8feac5",
              data: {!! str_replace('"', '', $paymentschart['sales'] ?? '[]') !!}
            },
            {
              label: "Earnings",
              color: "#9cabff",
              data: {!! str_replace('"', '', $paymentschart['amount'] ?? '[]') !!}
            },
        ],
    };
    </script>
  @stop
@endsection
