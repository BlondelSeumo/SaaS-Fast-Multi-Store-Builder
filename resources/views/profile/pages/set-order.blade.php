@extends('profile.layouts.app')
@section('content')
<div class="container mt-7">
  <div class="nk-block-head-content mb-4">
    <h3 class="nk-block-title page-title">{{ __('View Products ordered') }}</h3></div>
    <h5>{{ __('Enter order id') }}</h5>
    <form method="get">
     <div class="form__group">
       <label class="">{{ __('ID') }} <abbr class="required" title="required">*</abbr>
       </label>
       <input type="text" class="form-control" name="order_id" required="">
     </div>
     <div class="h-100 mt-5 w-100 d-flex align-center">
       <button class="btn btn-primary btn-lg btn-block">{{ __('Submit') }}</button>
     </div>
    </form>
  </div>
@stop