<?php

namespace App\Http\Controllers;

use File;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function welcome()
    {
        $posts = Post::orderBy('id', 'DESC')->get();
        $users = User::all();
    
        return view('welcome', [
            'posts' => $posts,
            'users' => $users
        ]);
    }

    public function postHashtag($hashtag)
    {
        $posts = Post::orderBy('id', 'DESC')->whereJsonContains('hashtags', $hashtag)->get();
        $users = User::all();
    
        return view('welcome', [
            'posts' => $posts,
            'users' => $users
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


        return view('user.profile', [
            'user' => $user,
            'posts' => $posts
        ]);
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
            $post->hashtags = json_encode( explode(',', $request->input('send')));
        }

        if ($request->input('location')) {
            $post->location = $request->input('location');
        }

        $post->save();


        return redirect()->route('welcome')->with('message', 'Vous avez créé un post !');
    }
}
