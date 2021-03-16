@extends('layouts.app')



@section('content')


<div class="container">
    <div style="display:grid;" class="row">

        <div class="col-md-7 mx-auto mb-4">
            <div style="display: flex;" class="row">
                <div class="col-4">
                    <img style="height: 100px;" class="rounded-circle" src="{{  Auth::user()->avatar }}" alt="">

                </div>
                <div style=" text-align:center; display: flex; margin-left: -40px" class="col-6">
                <p style="margin: 30px;">1000 <br> Abonnées</p>
                <p style="margin: 30px;">1000 <br> Abonnées</p>
                <p style="margin: 30px;">1000 <br> Abonnées</p>
                
                </div>
            </div>


            <h4 class="mt-4" style="font-size: 20px;">{{ $user->name }} <br> description...</h4>
            <div class="card mt-4">
                <div style="width: 100%;" class="card-header">
                    <div class="row">

                        <div style="display: flex; justify-content: center; align-items: center; margin-left: 0; padding-left: 0; border-right: 1px solid black" class="col-6">


                            <p class="ml-4" style="text-align: center; margin-top: 15px; ">Posts</p>

                        </div>
                        <div style="display:flex; justify-content: center; align-items: center; " class="col-6">
                            <p style="text-align: center;" class="card-text">Products</p>

                        </div>

                    </div>


                </div>
                <div style="text-align: center; width: 100%; margin-left :0" class="row">
                    @foreach($posts as $post)
                    <div style="padding: 0; align-items: center; justify-content: center; height: 315px;" class="col-6">
                    <img style="width: 100%; height: calc(100vw * 0.22);" src="{{ file_exists(public_path('uploads/post/' .$post->image)) ? asset('uploads/post/' .$post->image) : 'https://via.placeholder.com/300.png/09f/fff' }}" class="card-img-top" alt="...">
                    
                    </div>


                    @endforeach
                    <div style="padding: 0;" class="col-6">
                    <img style="width: 100%;" src="https://via.placeholder.com/300.png/09f/fff" class="card-img-top" alt="...">
                    
                    </div>
                    <div style="padding: 0;" class="col-6">
                    <img style="width: 100%;" src="https://via.placeholder.com/300.png/09f/fff" class="card-img-top" alt="...">
                    
                    </div>
                    
                
                
                </div>

            </div>

        </div>




    </div>


</div>
@endsection