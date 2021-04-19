@extends('layouts.app')

@section('extra-script')
<script src="https://js.stripe.com/v3/"></script>
@endsection


@section('content')

<div class="col-md-12">

    <h1>Page de paiements</h1>


    <div class="row">
        <div class="col-md-6">

            <form action="">
                <div id="card-element"></div>

                <div id="card-errors" role="alert"></div>



                <button class="btn btn-success" id="submit">Checkout</button>


            </form>


        </div>

    </div>



</div>



@endsection

@section('js-extra')

<script>
    const keyStripe = "<?php echo $key ?>";
    var stripe = Stripe(keyStripe);
    var elements = stripe.elements();

    var style = {
        base: {
            // Add your base input styles here. For example:
            fontSize: '16px',
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: "antialiased",
            "::placeholder": {
                color: "#aab7c4"
            }
        },
        invalid: {
            color: "#fa755a",
            iconColor: "#fa755a"
        }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {
        style: style
    });

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');
</script>


@endsection