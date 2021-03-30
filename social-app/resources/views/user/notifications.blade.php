@extends('layouts.app')


@section('content')

<?php

use App\Models\Post;
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

<div style="width: 100%;" class="container">
    <h3 style="text-align: center;" class="mb-4">Notifications</h3>

    @foreach($notificaitons as $notif)
    <?php $post = Post::find($notif->data['post_id']) ?>
    <?php $user = User::find($notif->notifiable_id) ?>

    <div style="margin-left: 16%; width: 55%; min-width: 600px" class="card mx-auto">
        <a style="color: black; text-decoration: none; width: auto" href="{{ route('post.show', $post->id) }}" class="link">

            <div style="display: flex; justify-content:center; align-items: center;">
                <img style="width: 30%; max-width: 200px; max-height: 150px; margin-right: auto; min-width: 130px" src="{{ asset('uploads/post/' .$post->image) }}" class="img-fluid" alt="">
                <p style="margin: auto;">Ce post à été aimé par <strong>{{ $user->name }}</strong><br>{{  format($notif->created_at) }}


                </p>
                <img style="width: 10%; max-width: 200px; max-height: 150px; margin-right:4%; border-radius: 50px; margin-top: 10px; margin-bottom: 10px; " src="{{ $user->avatar }}" alt="">

            </div>
        </a>

    </div>
    <?php $notif->markAsRead() ?>
    @endforeach

    <hr>

    <h3 style="text-align: center; font-size: 20px" class="mb-4 mt-4">Anciennes Notifications</h3>
    <?php $index = 0; ?>
    <div style="border-radius: 50px;">

        @foreach($notificaitons_old as $notif)
        @if ($index < 10) 
        <?php $post = Post::find($notif->data['post_id']) ?> 
        <?php $user = User::find($notif->notifiable_id) ?> 
        @if ($index==0) 
        <div style="margin-left: 16%; width: 44%; border-radius: 20px 20px 0px 0px; min-width: 500px" class="card mx-auto">
            <a style="color: black; text-decoration: none; width: auto" href="{{ route('post.show', $post->id) }}" class="link">

                <div style="display: flex; justify-content:center; align-items: center;">
                    <img style="border-radius: 20px 0px 0px 0px; width: 20%; max-width: 200px; max-height: 150px; margin-right: auto; min-width: 130px" class="img-fluid" src="{{ asset('uploads/post/' .$post->image) }}" alt="">
                    <p style="margin: auto; font-size: 14px">Ce post à été aimé par <strong>{{ $user->name }}</strong><br>{{  format($notif->created_at) }}


                    </p>
                    <img style="width: 10%; max-width: 200px; max-height: 150px; margin-right:4%; border-radius: 50px" src="{{ $user->avatar }}" alt="">

                </div>
            </a>

            @else
            <div style="margin-left: 16%; width: 44%; min-width: 500px;  min-width: 500px" class="card mx-auto">
                <a style="color: black; text-decoration: none; width: auto" href="{{ route('post.show', $post->id) }}" class="link">

                    <div style="display: flex; justify-content:center; align-items: center;">
                        <img style="width: 20%; max-width: 200px; max-height: 150px; margin-right: auto; min-width: 130px" src="{{ asset('uploads/post/' .$post->image) }}" class="img-fluid" alt="">
                        <p style="margin: auto; font-size: 14px">Ce post à été aimé par <strong>{{ $user->name }}</strong><br>{{  format($notif->created_at) }}


                        </p>
                        <img style="width: 10%; max-width: 200px; max-height: 150px; margin-right:4%; border-radius: 50px; margin-top: 10px; margin-bottom: 10px; " src="{{ $user->avatar }}" alt="">

                    </div>
                </a>
                @endif

            </div>



            @endif
            <?php $index++ ?>

            @endforeach

    </div>




</div>


@endsection