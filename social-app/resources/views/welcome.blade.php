@extends('layouts.app')



@section('content')

<?php

use App\Models\User; ?>

<div class="container">
    <div style="display:grid;" class="row">

        @foreach($posts as $post)
        <div class="col-md-5 mx-auto mb-4">
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
                            <p style="text-align: right; margin-left: auto" class="card-text">Bordeaux, France</p>
                        </div>

                    </div>

                </div>

                <img style="width: 100%;" src="{{ file_exists(public_path('uploads/post/' .$post->image)) ? asset('uploads/post/' .$post->image) : 'https://via.placeholder.com/300.png/09f/fff' }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">{{ $post->title }}</p>
                </div>
            </div>

        </div>


        @endforeach

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


    </div>


</div>
@endsection