@extends('layouts.app')

@section('extra-meta')

<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection


@section('extra-script')
<script src="https://js.stripe.com/v3/"></script>
@endsection


@section('content')

<div class="py-5 text-center" style="margin-bottom: 0px; margin-top: -80px">
    <ul style="margin-top: 50px; margin-bottom: 50px" class="progressbar">
        <li>Informations</li>
        <li  class="active">Paiement</li>
        <li>Confirmation</li>
    </ul>
</div>

<div style="box-shadow: 0 2px 8px rgb(0 0 0 / 10%); margin-top: 100px; padding-top: 30px" class="col-md-8 mx-auto">

    <div class="row">
        <div class="col-md-6 mx-auto text-center mb-4">

            <form action="{{ route('checkout.store') }}" method="POST" id="payment-form">
                <div style="border: 1px solid black; padding: 10px" id="card-element"></div>

                <div id="card-errors" role="alert"></div>


                <button class="btn btn-success mt-4" id="submit">Payer ({{ Cart::subtotal() }} €)</button>

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
    const displayError = document.getElementById('card-errors')

    card.addEventListener('change', ({
        error
    }) => {
        if (error) {
            displayError.classList.add('alert', 'alert-warning');
            displayError.textContent = error.message;
        } else {
            displayError.classList.remove('alert', 'alert-warning');
            displayError.textContent = '';
        }
    })

    var submitButton = document.getElementById('submit');

    submitButton.addEventListener('click', function(ev) {
        ev.preventDefault();
        submitButton.disabled = true
        stripe.confirmCardPayment("{{ $clientSecret }}", {
            payment_method: {
                card: card,
            }
        }).then(function(result) {
            if (result.error) {
                submitButton.disabled = false
                console.log(result.error.message)
            } else {
                if (result.paymentIntent.status === 'succeeded') {
                    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    var paymentIntent = result.paymentIntent;
                    var form = document.getElementById('payment-form');
                    var url = form.action
                    var redirect = "/cart/checkout/paiement/merci"

                    fetch(url, {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Request-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                        },
                        method: 'post',
                        body: JSON.stringify({
                            paymentIntent: paymentIntent
                        })
                    }).then((data) => {
                        console.log(data)
                        window.location.href = redirect
                    }).catch((error) => {
                        console.log(error)
                    })
                }
            }
        })
    })
</script>


@endsection