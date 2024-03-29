<?php

namespace App\Http\Controllers;

use File;
use Exception;
use Stripe\Stripe;
use App\Models\Post;
use App\Models\User;
use App\Models\Product;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use App\Notifications\PostLiked;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function notifications()
    {
        $notifs = auth()->user()->unreadNotifications;
        $notifsOld = auth()->user()->readNotifications;

        return view('user.notifications', [
            'notificaitons' => $notifs,
            'notificaitons_old' => $notifsOld
        ]);
    }

    public function welcome()
    {
        $posts = Post::orderBy('id', 'DESC')->get();
        $users = User::all();

        return view('welcome', [
            'posts' => $posts,
            'users' => $users,
            'hash' => ""
        ]);
    }

    public function postHashtag($hashtag)
    {
        $posts = Post::orderBy('id', 'DESC')->where('hashtags', 'like', '%' . $hashtag . '%')->get();
        $users = User::all();

        return view('welcome', [
            'posts' => $posts,
            'users' => $users,
            'hash' => $hashtag
        ]);
    }

    public function profile($id = null)
    {
        if ($id) {
            $user = User::find($id);
        } else {
            $user = Auth::user();
        }

        $posts = Post::where('user_id', '=', $user->id)->orderBy('id', 'DESC')->get();
        $products = Product::where('user_id', '=', $user->id)->orderBy('id', 'DESC')->get();



        return view('user.profile', [
            'user' => $user,
            'posts' => $posts,
            'products' => $products
        ]);
    }

    public function productAdd()
    {
        $user = Auth::user();

        if (!$user->stripe_private && !$user->stripe_public) {
            Session::flash('message', 'Vous devez enregistrer vos Clefs Stripe !');

            return view('settings.index', [
                'user' => $user,
            ]);
        }

        return view('product.add', [
            'user' => $user,
        ]);
    }

    public function productStore(Request $request)
    {
        $user = Auth::user();

        $product = new Product();
        $product->user_id = $user->id;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time() . '.' . $extension;
            $file->move(public_path() . '/uploads/product/', $filename);
            $product->image = $filename;
        }

        $product->title = $request->input('title');

        $product->price = $request->input('price');


        if ($request->input('send')) {
            $product->hashtags = json_encode(explode(',', $request->input('send')));
        }

        $product->save();


        return redirect()->route('profile')->with('message', 'Vous avez créé un Produit !');
    }

    public function postAdd()
    {
        $user = Auth::user();

        return view('post.add', [
            'user' => $user,
        ]);
    }

    public function postStore(Request $request)
    {
        $user = Auth::user();

        $post = new Post();
        $post->user_id = $user->id;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time() . '.' . $extension;
            $file->move(public_path() . '/uploads/post/', $filename);
            $post->image = $filename;
        }

        $post->title = $request->input('title');

        if ($request->input('send')) {
            $post->hashtags = json_encode(explode(',', $request->input('send')));
        }

        if ($request->input('location')) {
            $post->location = $request->input('location');
        }

        $post->save();


        return redirect()->route('welcome')->with('message', 'Vous avez créé un post !');
    }

    public function settings()
    {
        $user = Auth::user();

        return view('settings.index', [
            'user' => $user,
        ]);
    }

    public function settingsStripe(Request $request)
    {


        try {
            Stripe::setApiKey($request->input('stripe-private'));


            $intent = PaymentIntent::create([
                'amount' => "100",
                'currency' => 'eur',
                'metadata' => [
                    'userId' => Auth::user()->id
                ]
            ]);


            $login = Auth::user();

            $user = User::find($login->id);

            $user->stripe_private = $request->input('stripe-private');
            $user->stripe_public = $request->input('stripe-public');

            $user->save();
            return redirect()->route('params')->with('message', 'Vous mis à jours les parametres de Stripe !');

        } catch (Exception $e) {
            return redirect()->route('params')->with('error', "La clef public n'est pas correct !");
        
        }
    }
}
