@extends('layouts.app')


@section('content')

<div class="col-md-12">
    <ul style="margin-top: -50px; margin-bottom: 100px" class="progressbar">
        <li>Informations</li>
        <li>Paiement</li>
        <li class="active">Confirmation</li>
    </ul>
</div>


<div style="box-shadow: 0 2px 8px rgb(0 0 0 / 10%); margin-top: 100px" class="col-md-8 mx-auto">

    <div class="py-5 text-center" style="margin-bottom: -50px; margin-top: 0px">
        <div class="mb-4">
            <img style="width: 16%; margin-top: 0px" src="https://www.flaticon.com/svg/vstatic/svg/190/190411.svg?token=exp=1619378170~hmac=58118f05b1b2a5fff75def318dc64578" alt="">

        </div>

        <div style="text-align: center;" class="mb-4">
            <strong>
                <p>Votre commande à été validé. Vous allez recevoir un mail de confirmation.</p>
            </strong>
        </div>
    </div>

</div>


@endsection