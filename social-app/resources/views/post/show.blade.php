@extends('layouts.app')



@section('content')

<?php

use App\Models\User;

function format($datetime)
{
    $now = time();
    $created = strtotime($datetime);
    // La différence est en seconde
    $diff = $now - $created;
    $m = ($diff) / (60); // on obtient des minutes
    $h = ($diff) / (60 * 60); // ici des heures
    $j = ($diff) / (60 * 60 * 24); // jours
    $s = ($diff) / (60 * 60 * 24 * 7); // et semaines
    if ($diff < 60) { // "il y a x secondes"
        return 'Il y a ' . $diff . ' secondes';
    } elseif ($m < 60) { // "il y a x minutes"
        $minute = (floor($m) == 1) ? 'minute' : 'minutes';
        return 'Il y a ' . floor($m) . ' ' . $minute;
    } elseif ($h < 24) { // " il y a x heures, x minutes"
        $heure = (floor($h) <= 1) ? 'heure' : 'heures';
        $dateFormated = 'Il y a ' . floor($h) . ' ' . $heure;
        if (floor($m - (floor($h)) * 60) != 0) {
            $minute = (floor($m) == 1) ? 'minute' : 'minutes';
            $dateFormated .= ', ' . floor($m - (floor($h)) * 60) . ' ' . $minute;
        }
        return $dateFormated;
    } elseif ($j < 7) { // " il y a x jours, x heures"
        $jour = (floor($j) <= 1) ? 'jour' : 'jours';
        $dateFormated = 'Il y a ' . floor($j) . ' ' . $jour;
        if (floor($h - (floor($j)) * 24) != 0) {
            $heure = (floor($h) <= 1) ? 'heure' : 'heures';
            $dateFormated .= ', ' . floor($h - (floor($j)) * 24) . ' ' . $heure;
        }
        return $dateFormated;
    } elseif ($s < 5) { // " il y a x semaines, x jours"
        $semaine = (floor($s) <= 1) ? 'semaine' : 'semaines';
        $dateFormated = 'Il y a ' . floor($s) . ' ' . $semaine;
        if (floor($j - (floor($s)) * 7) != 0) {
            $jour = (floor($j) <= 1) ? 'jour' : 'jours';
            $dateFormated .= ', ' . floor($j - (floor($s)) * 7) . ' ' . $jour;
        }
        return $dateFormated;
    } else { // on affiche la date normalement
        return strftime("%d %B %Y à %H:%M", $created);
    }
}


?>

<div class="container">
    <div class="col-md-8 mx-auto mb-4">
        <div class="card">
            <div class="card-header">
                <div class="row">

                    <div style="display: flex; justify-content: center; align-items: center; padding: 0" class="col-6">
                        <a style="display: flex; text-decoration: none; color: black; justify-content: center; align-items: center; margin-right: auto; margin-left: 8% " href="{{ route('profile', $post->user_id) }}">
                            <img style="height: 44px;" class="rounded-circle" src="{{ asset(User::find($post->user_id)->avatar) }}" alt="">
                            <p class="ml-4" style="text-align: left; margin-top: 15px;">{{ User::find($post->user_id)->name }}</p>
                        </a>

                    </div>


                    @if(Auth::user()->id == $post->user_id)

                    <div style="display:flex; justify-content: center; align-items: center; margin: 0; padding: 0; justify-content:center; margin-left: -15px" class="col-5 mr-2">
                        <p style="text-align: right; margin-left: auto" class="card-text">{{ $post->location }}</p>
                    </div>

                    <div style="display: flex; justify-content: center; align-items: center; ">
                        <a href="{{ route('post.edit', $post->id) }}">
                            <i style="font-size: x-large; margin-top: 5px; color: black" class="fas fa-cog"></i>
                        </a>
                    </div>

                    @else

                    <div style="display:flex; justify-content: center; align-items: center; margin: 0; padding: 0; justify-content:center;" class="col-5">
                        <p style="text-align: right; margin-left: auto" class="card-text">{{ $post->location }}</p>
                    </div>


                    @endif

                </div>

            </div>
            <div id="{{ $post->id }}" class="img-post">
                <img style="width: 100%;" src="{{ file_exists(public_path('uploads/post/' .$post->image)) ? asset('uploads/post/' .$post->image) : 'https://via.placeholder.com/300.png/09f/fff' }}" class="card-img-top" alt="...">
                
                @if($post->products->all() != [])
                    <div style="margin-left: 5%; margin-top: -55px; margin-bottom: 44px">
                        <a style="text-decoration: none; background-color: #000000b5; padding: 10px; border-radius: 30px; border: 1px solid white;" href="{{ route('post.products', $post->id) }}">
                            <i style="color: white" class="fas fa-shopping-bag"></i>
                        </a>
                    </div>

                @endif

            </div>
            <div class="card-body">
                <div style="float:left; left: 0; justify-content: center; align-items: center; width: 100%; text-align: left">
                    <div style="margin-right: auto">

                        <form action="{{ route('posts.like') }}" id="form-js">


                            <input type="hidden" id="post-id-js" value="{{ $post->id }}">

                            @if($post->isLikedByLoggedInUser())
                            <button id="{{ $post->id }}" type="submit" style="padding: 0;" class="btn btn-link like"><i style="color: red; font-size: x-large" class="fas fa-heart"></i> </button>
                            @else
                            <button id="{{ $post->id }}" type="submit" style="padding: 0;" class="btn btn-link like"><i style="color: grey; font-size: x-large" class="fas fa-heart"></i> </button>
                            @endif

                            <div id="count-js">
                                {{ $post->likes->count() }} J'aime
                            </div>

                        </form>


                    </div>

                </div>
                <p class="card-text"><a style="text-decoration: none; color: black" href="{{ route('profile', $post->user_id) }}"><strong>{{ User::find($post->user_id)->name }}</strong> </a>{{ $post->title }}</p>
                <div style="display: flex;">

                    @foreach((array)json_decode($post->hashtags, true) as $hashtag)
                    <p class="card-text mr-2">
                        <a style="text-decoration: none;" href="{{ route('postHashtag', str_replace(' ', '',$hashtag)) }}">
                            #{{ $hashtag }}

                        </a>
                    </p>
                    @endforeach
                </div>


                <p class="card-text" style="color:grey; font-size: 14px;float: left; left: 0">{{ format($post->created_at) }}</p>

            </div>
        </div>

    </div>


</div>




@endsection('content')