<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
}
