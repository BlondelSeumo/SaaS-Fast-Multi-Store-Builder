
 <script src="https://js.stripe.com/v3/"></script>
 <script>
     let stripe = Stripe("{{ $client_id }}");

     stripe.redirectToCheckout({
         sessionId: <?= json_encode($stripe->id) ?>,
     }).then((result) => {
         /* Nothing for the moment */

     });
 </script>