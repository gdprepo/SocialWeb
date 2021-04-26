@extends('layouts.app')



@section('content')

<?php

use App\Models\User;

setlocale(LC_MONETARY, 'de_DE');

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
                        <a style="display: flex; text-decoration: none; color: black; justify-content: center; align-items: center; margin-right: auto; margin-left: 8% " href="{{ route('profile', $product->user_id) }}">
                            <img style="height: 44px;" class="rounded-circle" src="{{ User::find($product->user_id)->avatar }}" alt="">
                            <p class="ml-4" style="text-align: left; margin-top: 15px;">{{ User::find($product->user_id)->name }}</p>
                        </a>

                    </div>
                    <div style="display:flex; justify-content: center; align-items: center; margin-left: auto; padding: 0" class="col-5">
                    <a href="{{ route('cart.add', $product->id) }}">
                    <button class="btn btn-success">Ajouter au panier {{ money_format('%!n €', $product->price) }}</button>
                    </a>

                                        
                    @if (Auth::user()->id == $product->user_id)
                    <a href="{{ route('product.delete', $product->id) }}">
                    <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                    </a>
                    @endif
                    </div>

                </div>

            </div>
            <div id="{{ $product->id }}" class="img-post">
                <img style="width: 100%;" src="{{ file_exists(public_path('uploads/product/' .$product->image)) ? asset('uploads/product/' .$product->image) : 'https://via.placeholder.com/300.png/09f/fff' }}" class="card-img-top" alt="...">

            </div>
            <div class="card-body">

                <p class="card-text"><a style="text-decoration: none; color: black" href="{{ route('profile', $product->user_id) }}"><strong>{{ User::find($product->user_id)->name }}</strong> </a>{{ $product->title }}</p>
                <p>{{ money_format('%!n €', $product->price) }}</p>
                <div style="display: flex;">

                    @foreach((array)json_decode($product->hashtags, true) as $hashtag)
                    <p class="card-text mr-2">
                        <a style="text-decoration: none;" href="{{ route('postHashtag', str_replace(' ', '',$hashtag)) }}">
                            #{{ $hashtag }}

                        </a>
                    </p>
                    @endforeach
                </div>


                <p class="card-text" style="color:grey; font-size: 14px;float: left; left: 0">{{ format($product->created_at) }}</p>

            </div>
        </div>

    </div>


</div>




@endsection('content')