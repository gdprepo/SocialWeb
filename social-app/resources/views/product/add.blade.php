@extends('layouts.app')



@section('content')

<style>
    @import url('https://fonts.googleapis.com/icon?family=Material+Icons');

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

    .tag-container {
        border: 2px solid #ccc;
        padding: 10px;
        border-radius: 5px;
        display: flex;
        width: 100%;
        max-width: 400px;
    }

    .tag-container span {
        font-size: 14px;
    }

    .tag-container .tag {
        padding: 5px;
        border: 1px solid #ccc;
        margin: 5px;
        display: flex;
        align-items: center;
        border-radius: 3px;
        background: #f2f2f2;
        cursor: default;
    }

    .tag i {
        font: 10px;
        margin-left: 5px;

    }

    .tag-container input {
        flex: 1;
        font-size: 14px;
        padding: 5px;
        outline: none;
        border: 0;
    }

    .fix {
        display: flex;
    }
</style>


<div class="container">
    <h3 class="mb-4" style="text-align: center;">Créer un PRODUIT</h3>

    <div class="row" style="justify-content: center; align-items: center">


        <form action="/product/add/store" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <div class="input-group mb-3">
                    <input type="text" name="title" class="form-control" placeholder="Description *" aria-label="Username" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3">
                    <input type="number" name="price" class="form-control" placeholder="Prix *" aria-label="Price" aria-describedby="basic-addon1" required>
                </div>

                <label for="exampleFormControlFile1">Example file input</label>
                <input id="inpFile" name="image" type="file" class="form-control-file" id="exampleFormControlFile1">
                <div class="image-preview" id="imagePreview">
                    <img src="" alt="" class="image-preview__image">
                    <span class="image-preview__default-text">Image Preview</span>
                </div>

                <div style="margin-top: 30px" class="input-group mb-3">
                    <input name="send" id="send" type="hidden">

                    <div style="margin: 0;" class="tag-container row">

                        <input placeholder="Tags" name="hashtags" type="text">
                    </div>

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

    const tagContainer = document.querySelector('.tag-container');

    const input = document.querySelector('.tag-container input')

    var tags = [];

    function createTag(label) {
        const div = document.createElement('div');
        div.setAttribute('class', 'col-3 fix');
        const div2 = document.createElement('div');
        div2.setAttribute('class', 'tag');
        const span = document.createElement('span');
        span.innerHTML = label;
        const closeBtn = document.createElement('i');
        closeBtn.setAttribute('class', 'material-icons');
        closeBtn.setAttribute('data-item', label);
        closeBtn.innerHTML = "close";

        div.appendChild(span);
        div.appendChild(closeBtn);
        div2.appendChild(div);

        return div2;
    }

    function reset() {
        document.querySelectorAll('.tag').forEach(function(tag) {
            tag.parentElement.removeChild(tag);
        })
    }

    function addTags() {
        const send = document.getElementById('send');

        reset();
        tags.slice().reverse().forEach(function(tag) {
            const input = createTag(tag);
            tagContainer.prepend(input);
        })

        send.value = tags;
        console.log(send.value);
    }

    input.addEventListener('keyup', function(e) {
        if (e.key === ' ') {
            tags.push(input.value);
            addTags();
            input.value = '';
        }
    })

    document.addEventListener('click', function(e) {
        if (e.target.tagName === "I") {
            const value = e.target.getAttribute('data-item');
            const index = tags.indexOf(value);
            tags = [...tags.slice(0, index), ...tags.slice(index + 1)];
            addTags();
        }
    })


</script>


@endsection