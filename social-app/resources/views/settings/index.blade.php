@extends('layouts.app')



@section('content')

<div style="text-align: center;" class="container">
    <h3>Parametres</h3>

    <p>Private: {{ $user->stripe_private }}</p>
    <p>Public: {{ $user->stripe_public }}</p>

    <form class="mx-auto mt-4" style="width: 50%;" action="{{ route('params.upd') }}" method="POST">
        @csrf
        <label for="">Stripe</label>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Public Key</span>
            <input type="text" name="stripe-public" class="form-control" placeholder="**********" aria-label="Username" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Private Key</span>
            <input type="text" name="stripe-private" class="form-control" placeholder="**********" aria-label="Username" aria-describedby="basic-addon1">
        </div>


        <button type="submit" class="btn btn-success">Sauvegarder</button>

    </form>




</div>





@endsection