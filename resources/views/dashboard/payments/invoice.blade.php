@extends('layouts.app')
@section('title', __('Invoice - ') . strtolower($plan->name))
@section('content')
<div class="container mt-8">
    <div class="col-lg-7 mx-auto">
     <div class="invoice bdrs-20 card-shadow">
       <div class="invoice-header row">
         <div class="logo col-sm-6">
             @if(settings('logo') != '')
                 <img src="{{ url('media/logo/' . settings('logo')) }}" class="logo-img" alt="{{ config('app.name') }}" />
             @else
                 <h1>{{ config('app.name') }}</h1>
             @endif
             <p class="invoice-h-p">{{ __('Hello,') .' '. user('name.first_name') .' '. user('name.last_name') }}. <br> {{ __('You are paying for') .' '. ucfirst($plan->name) .' '. __('on our platform') .' '. config('app.name') }}</b>
             </p>
             <div class="row pl-3">
                 <div class="d-flex mb-2 align-center">
                    <h5 class="mr-2 mb-0">{{ __('Item') }}:</h5>
                    <p class="m-0">{{ucfirst($plan->name)}} - {{$duration}} - {!!$plan->price->{$duration} . Currency::symbol(settings('currency'))!!}</p>
                 </div>
             </div>
         </div>
         <div class="left col-sm-6">
           <div class="heading text-md-right">
               <h5 class="text-danger">{{ __('Unpaid') }}</h5>
               <h6>{{ __('Invoice') }}</h6>
               <p class="invoice-order-p fw-bold">
                  <small class="fw-bold">{{ Carbon\Carbon::now()->toFormattedDateString() }}</small>
               </p>
             <div class="form-group">
              <a href="{{ route(strtolower($gateway).'-create', ['plan' => $plan->slug, 'duration' => $duration]) }}" class="btn btn-primary btn-block">{{ __('Pay now') }} - {{$gateway}}</a>
             </div>
           </div>
         </div>
       </div>
      
      <div class="row p-5">
        <div class="col-sm-6">
           <h6>{{ __('Vendor') }}</h6>
           <small>{{ __('Name') }} - {{settings('business.name')}}</small>
           @if(!empty(settings('business.address')))
            <small class="d-block">{{ __('Address') }} - {{settings('business.address')}}</small>
           @endif
           @if(!empty(settings('business.city')))
            <small class="d-block">{{ __('City') }} - {{settings('business.city')}}</small>
           @endif
           @if(!empty(settings('business.county')))
            <small class="d-block">{{ __('County') }} - {{settings('business.county')}}</small>
           @endif
           @if(!empty(settings('business.zip')))
            <small class="d-block">{{ __('Zip') }} - {{settings('business.zip')}}</small>
           @endif
           @if(!empty(settings('business.country')))
            <small class="d-block">{{ __('Country') }} - {{settings('business.country')}}</small>
           @endif
           @if(!empty(settings('business.email')))
            <small class="d-block">{{ __('Email') }} - {{settings('business.email')}}</small>
           @endif
           @if(!empty(settings('business.phone')))
            <small class="d-block">{{ __('Phone') }} - {{settings('business.phone')}}</small>
           @endif
           @if(!empty(settings('business.tax_type')) && !empty(settings('business.tax_id')))
            <small class="d-block">{{ __('Tax') }} - {{settings('business.tax_id')}}</small>
           @endif
           @if(!empty(settings('business.custom_key_one')) && !empty(settings('business.custom_value_one')))
            <small class="d-block">{{settings('business.custom_key_one')}} - {{settings('business.custom_value_one')}}</small>
           @endif
           @if(!empty(settings('business.custom_key_two')) && !empty(settings('business.custom_value_two')))
            <small class="d-block">{{settings('business.custom_key_two')}} - {{settings('business.custom_value_two')}}</small>
           @endif
        </div>
        <div class="col-sm-6">
            <h6>{{ __('Customer') }}</h6>
            <small>{{ __('Name') }} - {{user('name.first_name') .' '. user('name.last_name')}}</small>
            <small class="d-block">{{ __('Email') }} - {{$user->email}}</small>
        </div>
      </div>
     </div>
    </div>
</div>
@endsection
