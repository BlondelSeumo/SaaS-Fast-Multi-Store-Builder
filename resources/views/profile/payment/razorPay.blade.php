
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
	<form name="form" action="{{ route('user-razor-verify', ['profile' => $profile]) }}" method="get">
		<input type="hidden" name="details" value="{{ json_encode($details) }}">
		<input type="hidden" name="total" value="{{ $total }}">
		<input type="hidden" name="cart" value="{{ json_encode(session()->get('cart_'.$profile)) }}">
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
