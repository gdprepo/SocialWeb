@extends('layouts.app')

@section('extra-script')
<script src="https://js.stripe.com/v3/"></script>
@endsection


@section('content')

<div style="box-shadow: 0 2px 8px rgb(0 0 0 / 10%); margin-top: 100px" class="col-md-8 mx-auto">

    <div class="py-5 text-center" style="margin-bottom: -50px; margin-top: 0px">
        <div>
            <img style="width: 35%; margin-top: -50px" src="{{ asset('img/checkout/paiement.png') }}" alt="">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mx-auto text-center mb-4">

            <form action="">
                <div style="border: 1px solid black; padding: 10px" id="card-element"></div>

                <div id="card-errors" role="alert"></div>


                <button class="btn btn-success mt-4" id="submit">Valider</button>

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