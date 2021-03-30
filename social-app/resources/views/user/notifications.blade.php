@extends('layouts.app')


@section('content')

<?php

use App\Models\Post;
use App\Models\User;  ?>

<div style="width: 100%;" class="container">
    <h3 style="text-align: center;" class="mb-4">Notifications</h3>
    @foreach($notificaitons as $notif)
    <div style="margin-left: 16%; width: 70%;" class="card mx-auto">

        <?php $post = Post::find($notif->data['post_id']) ?>
        <?php $user = User::find($notif->notifiable_id) ?>
        <div style="display: flex;">
            <img style="width: 22%; max-width: 200px; max-height: 150px" src="{{ asset('uploads/post/' .$post->image) }}" alt="">
            <p style="margin-left: 10%; margin-top: 35px">Ce post à été aimé par <strong>{{ $user->name }}</strong>
            <img style="width: 15%; max-width: 200px; max-height: 150px; margin-left:4%; border-radius: 50px" src="{{ $user->avatar }}" alt="">
            
            
            </p>
        </div>
    </div>

    <?php $notif->markAsRead() ?>
    @endforeach




</div>


@endsection