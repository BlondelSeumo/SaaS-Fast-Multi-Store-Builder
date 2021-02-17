@extends('profile.layouts.app')
@section('content')
<div class="container mt-7">
  @php
    $total = 0;
    $qty = 0;
    foreach($cart as $key => $value){
      $total = $total + ($value->qty * (!empty($value->salePrice) ? $value->salePrice : $value->price));
      $qty = $qty + $value->qty;
    }
  @endphp
  <h5 class="mb-3">{{ __('Cart & Checkout') }}</h5>
  <div class="row">
    @foreach ($cart as $key => $item)
    <div class="col-md-6">
      <div class="product-card p-3 card card-inner bdrs-15 mb-4 flex-row"><div class="product-image mt-1">
        <a href="{{ route('user-profile-single-product', ['profile' => $user->username, 'id' => $key]) }}"><img src="{{ getfirstproductimg($key) }}" class="s-img" alt="placeholder"></a>
      </div>
      <div class="product-details">
          <h2 class="h2"><b><a>{{$item->title}}</a></b></h2>
          <span class="price">{!! Currency::symbol($user->gateway['currency'] ?? '') !!} <span class="main-price">{{ number_format(!empty($item->salePrice) ? $item->salePrice : $item->price) }}</span></span>

          <div class="actions">
            <form action="{{ route('user-add-to-cart', ['profile' => $user->username, 'id' => $key]) }}" method="post">
              @csrf
              <input type="hidden" name="action" value="remove">
              <button class="delete-item delete cursor_pointer">{{ __('Delete') }}</button>
            </form>
            <div class="quantity">
              <label>{{ __('Qty') }}</label>
              <span class="select">{{ $item->qty }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
 <div class="product-card p-3 card card-inner bdrs-15 mb-4 flex-row">
 <div class="product-details">
     <h2 class="h2"><b>{{ __('Total') }}</b> - {{ __('Store address') }} - Lagos, nigeria</h2>
     <span class="price">{!! Currency::symbol($user->gateway['currency'] ?? '') !!} <span class="main-price">{{ number_format($total) }}</span></span>

     <div class="actions">
       <form action="{{-- route('user-add-to-cart', ['profile' => $user->username, 'id' => $key]) --}}" method="post">
         @csrf
         <input type="hidden" name="action" value="remove">
         <button class="delete-item delete text-danger cursor_pointer">{{ __('Remove all') }}</button>
       </form>
       <div class="quantity">
         <label>{{ __('Qty') }}</label>
         <span class="select">{{ $qty }}</span>
       </div>
     </div>
   </div>
 </div>
<form action="{{ route('user-profile-checkout', ['profile' => $user->username]) }}" method="post">
 <div class="checkout">
   <div class="billing-fields w-100">
      <div class="pb-4">
         <h6>{{ __('Billing details') }}</h6>
      </div>
        @csrf
      <div class="container-fluid">
       <div class="row">
         <p class="form__group col-6">
           <label class="">First name <abbr class="required" title="required">*</abbr>
           </label>
           <input type="text" class="form-control" name="first_name" required="">
         </p>
         <p class="form__group col-6">
           <label class="">Last name <abbr class="required" title="required">*</abbr>
           </label>
           <input type="text" class="form-control" name="last_name" required="">
         </p>
       </div>
       <div class="row">
         <p class="form__group col-6">
           <label class="">Address <abbr class="required" title="required">*</abbr>
           </label>
           <input type="text" class="form-control" name="address" required="">
         </p>
         <p class="form__group col-6">
           <label class="">Town / City <abbr class="required" title="required">*</abbr>
           </label>
           <input type="text" class="form-control" name="town_city" required="">
         </p>
       </div>
       <div class="row">
         <p class="form__group col-6">
           <label class="">State<abbr class="required" title="required">*</abbr>
           </label>
           <input type="text" class="form-control" name="state" required="">
         </p>
         <p class="form__group col-6">
           <label class="">Poster Code <abbr class="required" title="required">*</abbr>
           </label>
           <input type="text" class="form-control" name="poster_code" required="">
         </p>
       </div>

         <div class="row">
           <p class="form__group col-6">
             <label class="">Phone <abbr class="required" title="required">*</abbr>
             </label>
             <input type="text" class="form-control" name="phone" required="">
           </p>
           <p class="form__group col-6">
             <label class="" id="email">Email <abbr class="required" title="required">*</abbr>
             </label>
             <input type="text" class="form-control" name="email" required="">
           </p>
         </div>
         </div>
      </div>
      <div class="w-100 my-5">
         <p class="form__group notes">
           <label>{{ __('Additional info') }}</label>
           <textarea name="note" class="form-control" id="order_comments" placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea></p>
      </div>
      <div class="mt-4 row w-100">
        <div class="col-md-6">
          <h6>{{ __('Available gateway') }}</h6>
          <div class="row">
            @foreach (getOtherResourceFile('gateways') as $key => $values)
            @if (user('gateway.'.$key.'_status', $user->id) && $key !== 'bank')
            <div class="custom-control custom-radio custom-control-lg m-3">
              <input type="radio" class="custom-control-input" id="gateway_{{$key}}" name="gateway" value="{{$key}}">
              <label class="custom-control-label" for="gateway_{{$key}}">{{ $values['name'] }}</label>
            </div>
            @endif
            @endforeach
          </div>
          @if (user('gateway.bank_status', $user->id))
            <hr>
            <p>{{ __('For manual payment kindly use this details for payment and contact us for confirmation') }}</p>
            <h5>{{ __('Bank details') }}</h5> <p>{{ user('gateway.bank_details', $user->id) }}</p>
            <hr>
           <div class="text-center d-flex justify-md-center">
            <ul class="socials d-flex">
              @foreach ($options->socials as $key => $items)
                @if (!empty($user->socials[$key]))
                 <li class="mx-2">
                  <a class="text-muted intro-btn social fs-22px" target="_blank" href="{{(!empty($user->socials->{$key}) ? Linker::url(sprintf($items['address'], $user->socials->{$key}), ['ref' => $user->username]) : "")}}"><em class="icon ni ni-{{$items['icon']}}"></em></a>
                </li>
                @endif
              @endforeach
            </ul>
           </div>
          @endif
        </div>
        <div class="col-md-6">
          <div class="h-100 w-100 d-flex align-center">
            <button class="btn btn-primary btn-lg btn-block">{{ __('Proceed to payment') }}</button>
          </div>
        </div>
        </div>
      </div>
    </form>
  </div>
</div>
@stop