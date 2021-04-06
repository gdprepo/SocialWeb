@extends('layouts.app')



@section('content')


<div class="container">
    <div style="display:grid;" class="row">

        <div class="col-md-7 mx-auto mb-4">
            <div style="display: flex;" class="row ml-2">
                <div class="col-4">
                    <img style="height: 100px;" class="rounded-circle" src="{{  $user->avatar }}" alt="">

                </div>
                <div style=" text-align:center; display: flex; margin-left: -40px" class="col-6">
                    <p style="margin: 30px;">{{$posts->count() }} <br> Posts</p>
                    <?php if ($products) { ?>
                    <p style="margin: 30px;">{{ $products->count() }} <br> Products</p>
                    <?php }?>
                    <p style="margin: 30px;">1000 <br> Abonnées</p>

                </div>
            </div>


            <h4 class="mt-4 ml-4" style="font-size: 20px;">{{ $user->name }} <br> description...</h4>
            <div class="card mt-4">
                <div style="width: 100%;" class="card-header">
                    <div class="row">
                        <div id="showPost" style="display: flex; justify-content: center; align-items: center; margin-left: 0; padding-left: 0; border-right: 1px solid black" class="col-6">
                            <p class="ml-4" style="text-align: center; margin-top: 15px; ">Posts</p>
                        </div>
                        <div id="showProduct" style="display:flex; justify-content: center; align-items: center; " class="col-6">
                            <p style="text-align: center;" class="card-text">Products</p>
                        </div>
                    </div>
                </div>
                <div style="text-align: center; width: 100%; margin-left :0" class="row">
                    
                    @foreach($posts as $post)

                    <div id="post" onclick="window.location='{{ route("post.show", $post->id) }}'" style="background-position: center; height: calc(100vw * 0.22); max-height: 315px; min-height: 200px ;background-size: cover; background-repeat: no-repeat ;padding: 0; align-items: center; justify-content: center; min-height: 250px; background-image: url('<?php echo asset('uploads/post/' . $post->image) ?>')" class="col-6">

                    </div>



                    @endforeach

                    @foreach($products as $product)

                    <div id="product" onclick="window.location='{{ route("product.show", $product->id) }}'" style="background-position: center; height: calc(100vw * 0.22); max-height: 315px; min-height: 200px ;background-size: cover; background-repeat: no-repeat ;padding: 0; align-items: center; justify-content: center; min-height: 250px; background-image: url('<?php echo asset('uploads/product/' . $product->image) ?>')" class="col-6">

                    </div>



                    @endforeach






                </div>

            </div>

        </div>




    </div>


</div>
@endsection

@section('js-extra')


<script>
    var products = document.querySelectorAll('#product');
    var posts = document.querySelectorAll('#post');

        products.forEach((e) => {
            e.style.display = "none";
        })


    $('#showProduct').on('click', function () {
        posts.forEach((e) => {
            e.style.display = "none";
        })
        products.forEach((e) => {
            e.style.display = "block";
        })
    })

    $('#showPost').on('click', function () {
        products.forEach((e) => {
            e.style.display = "none";
        })
        posts.forEach((e) => {
            e.style.display = "block";
        })
    })




</script>


@endsection