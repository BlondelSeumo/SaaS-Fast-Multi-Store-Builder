@extends('layouts.app')
@section('title', __('Free Plan'))
@section('content')
  <div class="container mt-8">
    <div class="col-sm-8 mx-auto">
      <div class="card card-shadow card-inner bdrs-20">
      <form action="{{ route('user-back-to-free') }}" method="post">
        @csrf
         <h4 class="bold text-danger">{{ __('Type FREE') }}</h4>
         <p class="text-danger">{!! __('Are you sure you want to go back to free? <small>This is not reversible</small>') !!}</p>
         <div class="form-group mt-5">
             <input type="text" class="form-control form-control-lg"  name="free" placeholder="{{ __('FREE') }}" autocomplete="off">
         </div>
        <div class="form-group mt-5">
         <button type="submit" class="btn btn-primary btn-block">{{ __('Submit') }}</button>
        </div>
      </form>
      </div>
    </div>
  </div>
@endsection
