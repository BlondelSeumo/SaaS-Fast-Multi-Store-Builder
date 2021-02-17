@extends('layouts.app')
@section('title', __('Purchase Plan'))
@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-10 col-lg-10 mt-8 p-0">
                @if (!request()->get('gateway'))
                <h2 class="muted-deep"><span>{{ucfirst($plan->name)}}</span> {{ __('Package') }}</h2>
                <div class="margin-top-6 mb-2">
                    <span class="text-muted">{{ __('Choose your payment plan') }}</span>
                </div>
                @endif
                @if (!request()->get('gateway'))
                <form method="get" action="{{ settings('business.enabled') ? url("dashboard/invoice/$plan->slug") : '' }}" role="form">
                    <div class="row d-flex align-items-stretch mb-4 mb-3 bdrs-20 background-lighter p-md-3 p-2">
                        @foreach ($plan->price as $key => $value)
                            @if ($value !== NULL)
                            <div class="col-md-4 col-6 mb-4 mt-4 pricing-select">
                            <input type="radio" name="payment_plan" value="{{$key}}" class="custom-control-input" required="required" id="{{$key}}_price" data-price="{{ number_format($value) }}">
                                <div class="pricing-select-inner">
                                  <div class="mt-3 text-center mb-1">
                                    <span class="price">{!!Currency::symbol(settings('currency')) . number_format($value) !!}</span>
                                    <div class="muted-deep d-block">{{ __(ucfirst($key)) }}</div>
                                    </div>
                                    <label for="{{$key}}_price">{{ __('Choose') }}</label>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                @if (env('PAYPAL_STATUS') || env('STRIPE_STATUS') || env('RAZOR_STATUS') || env('BANK_STATUS') || env('MIDTRANS_STATUS') || env('PAYSTACK_STATUS'))
                  <div class="row">
                     <div class="col-lg-8 mt-6">
                        <div class="margin-top-6 mb-2">
                           <span class="text-muted">{{ __('Select Payment Gateway') }}</span>
                        </div>
                        <div class="row d-flex align-items-stretch mb-4">
                           @foreach ($gateway as $key => $item)
                               @if (env(strtoupper($key).'_STATUS'))
                               <div class="col-md-4 col-6">
                                  <label class="big-radio">
                                     <input type="radio" name="gateway" value="{{$key}}" class="custom-control-input" data-name="{{ $item['name'] }}" required="required">
                                     <div class="payment h-100 card-shadow">
                                        <img src="{{ url('media/'.$item['banner']) }}" alt=" ">
                                     </div>
                                  </label>
                               </div>
                               @endif
                           @endforeach
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="card card-shadow bdrs-20">
                           <div class="background-lighter p-3 bdrs-20 text-muted font-weight-bold">{{ __('Summary') }}</div>
                           <div class="card-body pb-0">
                              <div>
                                 <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">{{ __('Plan') }}</span>
                                    <span>{{$plan->name}}</span>
                                 </div>
                                 <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">{{ __('Duration') }}</span>
                                    <div id="payment_duration_monthly">
                                       <div class="d-flex flex-column">
                                          <span class="text-right">{{ __('Monthly') }}</span>
                                          <small class="text-right text-muted">{{ __('Every 1 Month') }}</small>
                                       </div>
                                    </div>
                                    <div id="payment_duration_quarterly" style="display: none;">
                                       <div class="d-flex flex-column">
                                          <span class="text-right">{{ __('Quarterly') }}</span>
                                          <small class="text-right text-muted">{{ __('Every 6 Months') }}</small>
                                       </div>
                                    </div>
                                    <div id="payment_duration_annually" style="display: none;">
                                       <div class="d-flex flex-column">
                                          <span class="text-right">{{ __('Annually') }}</span>
                                          <small class="text-right text-muted">{{ __('Every 12 Months') }}</small>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">{{ __('Paying with') }}</span>
                                    <span id="payment_gateway">{{ __('Not selected') }}</span>
                                 </div>
                                 <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">{{ __('Price') }}</span>
                                    <div>
                                       <span id="package_price">{{ __('Not selected') }}</span>
                                       <span class="text-muted">{!!Currency::symbol(settings('currency'))!!}</span>
                                    </div>
                                 </div>
                              </div>
                              <hr>
                           </div>
                           <div class="card-footer pt-0 bg-white">
                              <div class="d-flex justify-content-between font-weight-bold">
                                 <span class="text-muted">{{ __('Total') }}</span>
                                 <div>
                                    <span id="total"></span>
                                    <span class="text-muted">{!! Currency::symbol(settings('currency')) !!}</span>
                                 </div>
                              </div>
                                @if (!empty(settings('privacy')) || !empty(settings('terms')))
                                 <div class="col-12 p-0 mb-2 mt-3 mb-4">
                                   <div class="form-group">
                                     <div class="custom-control custom-control-xs custom-checkbox">
                                       <input type="checkbox" class="custom-control-input" id="checkbox" required="">
                                          <label class="custom-control-label" for="checkbox">{{ __('I agree to ') }}<b>{{env("APP_HOME") }}</b> {!! clean((!empty(settings('privacy')) ? '<a href="' . url(settings('privacy')) . '">'.__('Privacy Policy').'</a>' : "") . (!empty(settings('privacy')) && !empty(settings('terms')) ? ' &amp; ' : "") .(!empty(settings('terms')) ? '<a href="' . url(settings('terms')) . '">'.__('Terms').'</a>' : ""), 'titles') . ' ' . __('of this site') !!}
                                        </label>
                                     </div>
                                   </div>
                                 </div>
                                @endif
                              <div class="mt-2">
                                 <button type="submit" class="btn btn-block btn-primary">{{ __('Generate Payment') }}</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                @endif
            </form>
                @endif
        </div>
    </div>
@section('footerJS')
<script>
    let payment_duration = () => {
        let payment_plan = $('[name="payment_plan"]:checked');
        let $package_price = $('#package_price');
        let $price = payment_plan.data('price');
        let $total = $('#total');
        let $annual = $('#payment_duration_annually');
        let $quarter = $('#payment_duration_quarterly');
        let $month = $('#payment_duration_monthly');

        switch(payment_plan.val()) {
            case 'month':
                $month.show();
                $annual.hide();
                $quarter.hide();
                $package_price.html($price);
                $total.html($price);
                break;

            case 'quarter':
                $quarter.show();
                $month.hide();
                $annual.hide();
                $package_price.html($price);
                $total.html($price);
                break;

            case 'annual':
                $month.hide();
                $annual.show();
                $quarter.hide();
                $package_price.html($price);
                $total.html($price);
                break;
        }
    }
    let payment_gateways = () => {
        let $gateways = $('[name="gateway"]:checked');
        $('#payment_gateway').html($gateways.data('name'));
    }

    $('[name="gateway"]').on('change', event => {
        payment_gateways();
    });
    $('[name="payment_plan"]').on('change', event => {
        payment_duration();
    });
    $(window).on('load', function(){
        payment_duration();
        payment_gateways();
    })
</script>
@stop
@endsection
