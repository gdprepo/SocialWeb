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

    public function remove($id)
    {
        $row = null;

        foreach(Cart::content() as $prod) {
            if($prod->id == $id ) {
                $row = $prod->rowId;
            }
        }

        Cart::remove($row);


       return redirect()->route('cart.checkout')->with('message', 'Vous enlevé un produit de votre panier !');

    }

    public function add($id)
    {
        $product = Product::find($id);
        $check = false;

        if(strlen($product->price) < 0 || ! is_numeric($product->price)) {
            var_dump('check');
        }


        foreach(Cart::content() as $prod) {
            if($prod->id == $id ) {
                $check = true;
            }
        }

        if ($check === false) {
            Cart::add($product->id, $product->title, 1, $product->price, ['img' => $product->image]);
        }

       return redirect()->route('welcome')->with('message', 'Vous avez ajouté un produit a votre panier !');

    }
}
