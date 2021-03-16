@extends('layouts.app')



@section('content')

<style>
    .image-preview {
        width: 100%;
        min-height: 100px;
        border: 2px solid #dddddd;
        margin-top: 15px;

        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #cccccc;

    }

    .image-preview__image {
        display: none;
        width: 100%;

    }
</style>


<div class="container">
    <div class="row" style="justify-content: center; align-items: center">

        <form action="/post/add/store" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <div class="input-group mb-3">
                    <input type="text" name="title" class="form-control" placeholder="Title" aria-label="Username" aria-describedby="basic-addon1">
                </div>


                <label for="exampleFormControlFile1">Example file input</label>
                <input id="inpFile" name="image" type="file" class="form-control-file" id="exampleFormControlFile1">
                <div class="image-preview" id="imagePreview">
                    <img src="" alt="" class="image-preview__image">
                    <span class="image-preview__default-text">Image Preview</span>
                </div>



            </div>


            <button style="width: 100%;" class="btn btn-success" type="submit">Valider</button>

        </form>







    </div>





</div>



@endsection('content')


@section('js-extra')
<script>
    const inpFile = document.getElementById('inpFile');
    const previewContainer = document.getElementById('imagePreview');
    const previewImage = document.querySelector('.image-preview__image');
    const previewDefaultText = document.querySelector('.image-preview__default-text');


    inpFile.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            previewDefaultText.style.display = "none";
            previewImage.style.display = "block";


            reader.addEventListener('load', function() {
                previewImage.setAttribute("src", this.result);
            });

            reader.readAsDataURL(file);
        }
    })
</script>


@endsection