@extends('layouts.app')

@section('content')


<div class="container">
    <main>
        @if (Cart::count() > 0)

        <div class="py-5 text-center" style="margin-bottom: 50px; margin-top: -100px">
            <?php if ($vendeur) { ?>
                <img src="{{ $vendeur->avatar }}" style="height: 80px;" class="rounded-circle mb-4" alt="">
            <?php } ?>
            <ul style="margin-top: 50px; margin-bottom: 50px" class="progressbar">
                <li class="active">Informations</li>
                <li>Paiement</li>
                <li>Confirmation</li>
            </ul>
        </div>



        <div class="row g-5">
            <div class="col-md-5 col-lg-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your cart</span>
                    <span class="badge bg-primary rounded-pill">{{ Cart::count() }}</span>
                </h4>
                <ul class="list-group mb-3">
                    @foreach(Cart::content() as $product)

                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">{{ $product->name }}</h6>
                            @if ($product->options)
                            <img style="width: 50%" src="{{ file_exists(public_path('uploads/product/' .$product->options->img)) ? asset('uploads/product/' .$product->options->img) : 'https://via.placeholder.com/300.png/09f/fff' }}" alt="">
                            @endif
                        </div>
                        <form action="{{ route('cart.delete', $product->id) }}">
                            <span style="white-space: nowrap;" class="text-muted">{{ $product->price }} €
                                <button style="font-size: 10px;" type="submit" class="btn btn-danger ml-4">Supprimer</button>
                        </form>

                        </span>
                    </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                            <h6 class="my-0">Promo code</h6>
                            <small>EXAMPLECODE</small>
                        </div>
                        <span class="text-success">−$5</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (EU)</span>
                        <strong>{{ Cart::subtotal() }} €</strong>
                    </li>
                </ul>

            </div>
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Billing address</h4>
                <form class="needs-validation" method="post" action="{{ route('checkout.index') }}">
                @csrf
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">First name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">Last name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
                            <input type="email" class="form-control" id="email" placeholder="you@example.com">
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" id="address" placeholder="1234 Main St" required="">
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
                            <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                        </div>

                        <div class="col-md-5">
                            <label for="country" class="form-label">Country</label>
                            <select class="form-select" id="country" required="">
                                <option value="">Choose...</option>
                                <option>United States</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="state" class="form-label">State</label>
                            <select class="form-select" id="state" required="">
                                <option value="">Choose...</option>
                                <option>California</option>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="zip" class="form-label">Zip</label>
                            <input type="text" class="form-control" id="zip" placeholder="" required="">
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
                </form>
            </div>
        </div>

        @else

        <div style="text-align: center;" class="container">

            <h3>Votre panier est vide. Continuer votre Shopping</h3>

            <a href="{{ route('welcome') }}">Retour a l'accueil</a>

        </div>

        @endif
    </main>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">© 2017–2021 Company Name</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Privacy</a></li>
            <li class="list-inline-item"><a href="#">Terms</a></li>
            <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
    </footer>
</div>

@endsection