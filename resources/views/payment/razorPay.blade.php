@extends('layouts.app')
@section('title', __('Razorpay'))
@section('content')
  <div class="bdrs-20 background-lighter p-md-3 p-2">
      <p>{{ __("Pay with razorPay") }}</p>
  </div>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
	<form name="form" action="{{ route('razor-verify', ['plan' => $package->slug, 'duration' => $duration]) }}" method="get">
	    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
	</form>
	@section('footerJS')
	<script>
		var options = {!! $data !!};
		options.handler = function (response){
		    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
		    document.form.submit();
		};
		options.theme.image_padding = false;
		options.modal = {
		    ondismiss: function() {
				window.location = "{{ route('pricing') }}";
		    },
		    escape: true,
		    backdropclose: false
		};
		var rzp = new Razorpay(options);
		rzp.open();
	</script>
	@stop
@endsection
