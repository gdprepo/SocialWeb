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
    @if($hash != "")
    <div style="text-align: center; margin-bottom: 40px" class="mx-auto">
        <h4 style="color: grey;">Recherche avec le hashtag : {{ $hash }}</h4>
    </div>
    @endif
    <div class="row">

        <div class="col-7 mx-auto mb-4">

            @foreach($posts as $post)
            <div class="col-md-12  mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row">

                            <div style="display: flex; justify-content: center; align-items: center; padding: 0" class="col-6">
                                <a style="display: flex; text-decoration: none; color: black; justify-content: center; align-items: center; margin-right: auto; margin-left: 8% " href="{{ route('profile', $post->user_id) }}">
                                    <img style="height: 44px;" class="rounded-circle" src="{{ User::find($post->user_id)->avatar }}" alt="">
                                    <p class="ml-4" style="text-align: left; margin-top: 15px;">{{ User::find($post->user_id)->name }}</p>
                                </a>

                            </div>
                            <div style="display:flex; justify-content: center; align-items: center; margin: 0; padding: 0" class="col-5">
                                <p style="text-align: right; margin-left: auto" class="card-text">{{ $post->location }}</p>
                            </div>

                        </div>

                    </div>
                    <div id="{{ $post->id }}" class="img-post">
                        <img style="width: 100%;" src="{{ file_exists(public_path('uploads/post/' .$post->image)) ? asset('uploads/post/' .$post->image) : 'https://via.placeholder.com/300.png/09f/fff' }}" class="card-img-top" alt="...">
                        @if($post->products)
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
                                @if($hash)
                                <form action="{{ route('posts.like', $hash) }}" id="form-js">

                                    @else
                                    <form action="{{ route('posts.like') }}" id="form-js">

                                        @endif
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


            @endforeach



        </div>

        <div style="margin-left: auto;" class="col-5">
            <div style="display:grid; justify-content: start; align-items: center; padding: 0; position: fixed" class="col-6">
                <a style="display: flex; text-decoration: none; color: black; justify-content: center; align-items: center; margin-right: auto; margin-left: 0% " href="{{ route('profile', Auth::user()->id) }}">
                    <img style="height: 50px;" class="rounded-circle" src="{{ Auth::user()->avatar }}" alt="">
                    <p class="ml-4" style="text-align: left; margin-top: 15px; font-size: 20px"><strong>{{ str_replace(' ', '', strtolower(Auth::user()->name)) }}</strong></p>
                </a>

                <div class="mt-4" style="margin-left: 0%">
                    <h4 style="font-size: 15px; color: grey">Suggestions pour vous</h4>
                    <div class="ml-3">
                        <?php $index = 0; ?>
                        @foreach($users as $user)
                        @if($index < 8 && $user->name != Auth::user()->name)
                            <a style="text-decoration: none; color: black;" href="{{ route('profile', $user->id) }}">
                                <div style="display: flex; align-items: center;" class="mt-4">
                                    <img style="height: 45px; margin-right: 30%; padding-right: -20px" class="rounded-circle" src="{{ $user->avatar }}" alt="">
                                    <div style="white-space: nowrap">
                                        <strong>{{ str_replace(' ', '', strtolower($user->name)) }}</strong>

                                    </div>

                                </div>

                            </a>

                            @endif
                            <?php $index++ ?>
                            @endforeach

                    </div>

                </div>

            </div>



        </div>


        <!--

        <div class="col-md-5 mx-auto mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">

                        <div style="display: flex; justify-content: center; align-items: center; margin-left: 20px;" class="col-4">

                            <img style="height: 44px;" class="rounded-circle" src="{{ asset('img/user/username.gif') }}" alt="">

                            <p class="ml-4" style="text-align: left; margin-top: 15px">Username</p>

                        </div>
                        <div style="display:flex; justify-content: center; align-items: center; margin: 0; padding: 0" class="col-7">
                            <p style="text-align: right; margin-left: auto" class="card-text">Bordeaux, France</p>

                        </div>

                    </div>


                </div>

                <img style="width: 100%;" src="https://via.placeholder.com/300.png/09f/fff" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title.</p>
                </div>
            </div>

        </div>

        <div class="col-md-5 mx-auto mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">

                        <div style="display: flex; justify-content: center; align-items: center; margin-left: 20px;" class="col-4">

                            <img style="height: 44px;" class="rounded-circle" src="{{ asset('img/user/username.gif') }}" alt="">

                            <p class="ml-4" style="text-align: left; margin-top: 15px">Username</p>

                        </div>
                        <div style="display:flex; justify-content: center; align-items: center; margin: 0; padding: 0" class="col-7">
                            <p style="text-align: right; margin-left: auto" class="card-text">Bordeaux, France</p>

                        </div>

                    </div>


                </div>

                <img style="width: 100%;" src="https://via.placeholder.com/300.png/09f/fff" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title.</p>
                </div>
            </div>

        </div>

-->
    </div>


</div>
@endsection