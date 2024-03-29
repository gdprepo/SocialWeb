<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\PostLiked;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function like(): JsonResponse
    {



        $post = Post::find(request()->id);

        if ($post->isLikedByLoggedInUser()) {
            $res = Like::where([
                'user_id' => auth()->user()->id,
                'post_id' => request()->id
            ])->delete();

            if ($res) {
                return response()->json([
                    'count' => Post::find(request()->id)->likes->count(),
                    'check' => true
                ]);
            }
        } else {
            // $user_id = Post::find(request()->id)->user_id;

            User::find($post->user_id)->notify(new PostLiked($post));

            
            $like = new Like();
            $like->user_id = auth()->user()->id;
            $like->post_id = request()->id;

            $like->save();

            return response()->json([
                'count' => Post::find(request()->id)->likes->count(),
                'check' => false
            ]);
        }
    }

    public function postShow($id)
    {
        $post = Post::find($id);

        return view('post.show', [
            'post' => $post,
            'hash' => ""
        ]);
    }

    public function productShow($id)
    {
        $product = Product::find($id);

        return view('product.show', [
            'product' => $product,
            'hash' => ""
        ]);
    }

    public function postEdit($id)
    {

        $post = Post::find($id);

        if ($post->user_id != Auth::user()->id) {
            return redirect()->route('welcome')->with('message', 'Vous devez etre connécté avec le bon utilisateur !');

        }

        $products = Product::where('user_id', $post->user_id)->get();

        return view('post.edit', [
            'post' => $post,
            'products' => $products
        ]);
    }

    public function posteditUpd(Request $request, $id)
    {
        $post = Post::find($id);

        if ($request->input('title')) {
            $post->title = $request->input('title');
        }

        if ($request->input('products')) {
            $post->products()->sync([]);

        }

        foreach ($request->input('products') as $value) {
            # code...
            $post->products()->attach($value);

        }

        $post->save();


        return redirect()->route('post.edit', $id)->with('message', 'Vous avez mis à jour le POST !');

    }

    public function postProduct($id)
    {
        $post = Post::find($id);
        $products = $post->products()->get();

        return view('post.products', [
            'post' => $post,
            'products' => $products
        ]);
    }

    public function productDelete($id) {
        $product = Product::find($id);

        if (Auth::user()->id == $product->user_id) {
            $product->delete();
            return redirect()->route('welcome')->with('message', 'Vous bien supprimé votre produit !');
        } else {
            return redirect()->route('welcome')->with('message', 'Vous ne pouvez pas supprimer ce produit !');

        }


    }
}
