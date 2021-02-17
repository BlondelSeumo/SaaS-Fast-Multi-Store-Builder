@extends('layouts.app')
@section('title', __('Bank Transfer'))
@section('content')
<div class="container mt-7">
	<div class="card-shadow p-3 bdrs-20">
	    <div class="bdrs-20 background-lighter p-md-3 p-2">
	        <p>{{ __("Bank Transfer") }}</p>
	    </div>
	    <p class="ml-2 mt-4">{{ config('app.bank_details') }}</p>
	    <hr>
	    <p>{{ __("If paid please fill out this form") }}</p>
	    <form action="{{ route('bank-post', ['duration' => $duration, 'plan' => $plan->slug]) }}" method="post" enctype="multipart/form-data">
	    @csrf
	    <div class="bdrs-20 background-lighter p-md-3 p-2">
	        <div class="row">
	            <div class="col-md-6">
	              <div class="form-group mt-5 mt-lg-5">
	                <label class="form-label"><span>{{ __('Email') }}</span></label>
	                <div class="form-control-wrap">
	                    <input type="text" value="{{ $user->email }}" class="form-control form-control-lg c-input" placeholder="{{ __('Your email') }}" name="email">
	                </div>
	              </div>
	            </div>
	            <div class="col-md-6">
	              <div class="form-group mt-5 mt-lg-5">
	                <label class="form-label"><span>{{ __('Name') }}</span></label>
	                <div class="form-control-wrap">
	                    <input type="text" value="{{ user('name.first_name') }}" class="form-control form-control-lg c-input" placeholder="Your name" name="name">
	                </div>
	              </div>
	            </div>
	            <div class="col-md-6">
	              <div class="form-group mt-5 mt-lg-5">
	                <label class="form-label"><span>{{ __('Bank name') }}</span></label>
	                <div class="form-control-wrap">
	                    <input type="text" class="form-control form-control-lg c-input" placeholder="{{ __('enter bank name used to transfer') }}" name="bank_name">
	                </div>
	              </div>
	            </div>
	            <div class="col-md-6">
	            <div class="form-group mt-5 mt-lg-5">
	               <div class="image-upload pages">
	                    <label for="upload">{!! __('Upload payment proof <small>1mb max</small>') !!}</label>
	                    <input type="file" id="upload" name="proof" class="upload">
	                <img src="" alt=" ">
	               </div>
	              </div>
	            </div>

	            <button class="button primary w-100 mt-5">{{ __('Submit') }}</button>
	        </div>
	    </div>
	 </form>
	</div>
  @if (count($pending) > 0)
  <div class="nk-block mt-6 card card-inner card-shadow bdrs-20">
   <div class="nk-tb-list is-separate is-medium mb-3">
		      <div class="nk-tb-item nk-tb-head">
		         <div class="nk-tb-col"><span>{{ __('Proof') }}</span></div>
		         <div class="nk-tb-col tb-col-md"><span>{{ __('Name | Bank Name') }}</span></div>
		         <div class="nk-tb-col"><span>{{ __('Status') }}</span></div>
		         <div class="nk-tb-col tb-col-md"><span>{{ __('Date') }}</span></div>
		         <div class="nk-tb-col"></div>
		      </div>
		      @foreach ($pending as $item)
		      <div class="nk-tb-item background-lighter">
		         <div class="nk-tb-col background-lighter">
		            <span class="tb-lead"><a href="{{ url('img/user/bankProof/'.$item->proof) }}">{{Str::limit($start = $item->proof,  $limit = 10, $end = '...')}}</a></span>
		         </div>
		         <div class="nk-tb-col tb-col-md background-lighter">
		            <span class="tb-sub">{{ucfirst($item->name)}} | {{ucfirst($item->bankName)}}</span>
		         </div>
		         <div class="nk-tb-col background-lighter">
		            <span class="dot bg-warning d-md-none {{$item->status == 0 ? ' badge-warning' : NULL }} {{$item->status == 1 ? ' badge-success' : NULL }} {{$item->status == 2 ? ' badge-danger' : NULL }}"></span>
		            <span class="badge badge-sm badge-dot has-bg {{$item->status == 0 ? ' badge-warning' : NULL }} {{$item->status == 1 ? ' badge-success' : NULL }} {{$item->status == 2 ? ' badge-danger' : NULL }} d-none d-md-inline-flex">{{$item->status == 0 ? 'Pending' : NULL}} {{$item->status == 1 ? 'Activated' : NULL }} {{$item->status == 2 ? 'Declined' : NULL }}</span>
		         </div>
		         <div class="nk-tb-col tb-col-md background-lighter">
		            <span class="tb-lead">{{ Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span>
		        </div>
                 <div class="nk-tb-col background-lighter">
                 	<form action="{{ route('bank-delete', ['id' => $item->id]) }}" method="POST">
                 		@csrf
		            	<span class="tb-lead"><button type="submit" class="btn btn-danger btn-block"  data-confirm="{{ __('Are you sure you want to delete this?') }}">{{ __('Delete') }}</button></span>
                 	</form>
		        </div>
              </div>
		      @endforeach
		  </div>
		</div>
  @endif
@endsection
