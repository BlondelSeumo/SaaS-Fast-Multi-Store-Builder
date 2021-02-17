@extends('layouts.app')
@section('title', __('Stripe'))
@section('content')
 <script src="https://js.stripe.com/v3/"></script>
 <script>
     let stripe = Stripe("{{config('app.stripe_client')}}");

     stripe.redirectToCheckout({
         sessionId: <?= json_encode(Session::get('stripe')->id) ?>,
     }).then((result) => {
         /* Nothing for the moment */

     });
 </script>
@endsection
