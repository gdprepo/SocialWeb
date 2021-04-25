<?php

namespace App\Http\Controllers;

use Exception;
use Stripe\Stripe;
use App\Models\User;
use App\Models\Product;
use Stripe\PaymentIntent;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Cart::count() <= 0 ) {
            return redirect()->route('welcome');
        }

        foreach(Cart::content() as $prod) {    
            $userId = Product::find($prod->id)->user_id;
        }

        $user = User::find($userId);
        $key = $user->stripe_private;
        
        try {
            Stripe::setApiKey($key);

            $intent = PaymentIntent::create([
                'amount' => round(Cart::total()),
                'currency' => 'eur',
                'metadata' => [
                    'userId' => Auth::user()->id
                ]
            ]);


            $clientSecret = Arr::get($intent, 'client_secret');

            return view('checkout.index', [
                'clientSecret' => $clientSecret,
                'key' => $user->stripe_public
            ]);
            
        } catch (Exception $e) {
            dd($key);

            exit;

        }

        // return view('checkout.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Cart::destroy();

        $data = $request->json()->all();

        return $data['paymentIntent'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
