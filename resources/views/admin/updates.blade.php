@extends('admin.layouts.app')
@section('title', __('Updates'))
@section('Js')
  <script src="{{ url('js/update.js') }}"></script>
@stop
@section('content')
<div class="nk-block-head">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-bold">{{ __('Software Update') }}</h2>
        </div>
    </div>
</div>
  <div class="settings-card">
    <div class="row">
      <div class="col-md-6">
        <div class="container mb-3 mb-lg-0 h-100">
          <div id="update-stats" class="h-100">
            <h5 class="nk-block-title">{{ __('Update stats') }}</h5>
            <h4 hidden="" >Coming soon....</h4>
          </div>
        </div>
      </div>
      <div class="col-md-6">
         <div class="container">
          <div class="card card-inner card-shadow bdrs-20 mb-4">
          <h4 class="nk-block-title fw-bold text-info">{{ __('Database update') }}
          </h4>
          <p class="mt-2">{{ __('Update your database if available. Please update your database after every ecom update') }}</p>
            <button class="button primary w-100 mt-3" id="migrate-update" route="{{ route('admin-update-migrate') }}">{{ __('Update Database now!') }}</button>
          </div>
          <div class="card card-inner card-shadow bdrs-20 mb-4">
            <form action="{{ route('admin-update-license-code') }}" method="post">
              @csrf
              <div class="form-group">
                <input type="text" name="license_code" class="form-control form-control-lg" placeholder="License key or purchase code" value="{{env('LICENSE_KEY')}}">
              </div>
              <h5>{{env('LICENSE_NAME') .(!empty(env('LICENSE_NAME')) && !empty(env('LICENSE_TYPE')) ? ' | ' : ''). env('LICENSE_TYPE')}}</h5>
              <button class="button primary w-100 mt-3" type="submit">{{ __('Update purchase license') }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
