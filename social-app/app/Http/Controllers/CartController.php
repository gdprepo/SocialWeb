<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index($id = null)
    {
        $vendeur = User::find($id);

        return view('cart.index', [
            'vendeur' => $vendeur
        ]);
    }

    public function add($id)
    {
        $product = Product::find($id);

        if(strlen($product->price) < 0 || ! is_numeric($product->price)) {
            var_dump('check');
        }

        // add the product to cart
        // $cart = Cart::add($product);

        Cart::add($product->id, $product->title, 1, $product->price, ['img' => $product->image]);

       return redirect()->route('welcome')->with('message', 'Vous avez ajouté un produit a votre panier !');

    }
}
