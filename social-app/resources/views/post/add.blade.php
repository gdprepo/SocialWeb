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
    <div class="row" style="justify-content: center; align-items: center">

        <form action="/post/add/store" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <div class="input-group mb-3">
                    <input type="text" name="title" class="form-control" placeholder="Title *" aria-label="Username" aria-describedby="basic-addon1" required>
                </div>

                <label for="exampleFormControlFile1">Example file input</label>
                <input id="inpFile" name="image" type="file" class="form-control-file" id="exampleFormControlFile1">
                <div class="image-preview" id="imagePreview">
                    <img src="" alt="" class="image-preview__image">
                    <span class="image-preview__default-text">Image Preview</span>
                </div>

                <label class="input-group mb-3 mt-4">
                    <!-- Avoid the word "address" in id, name, or label text to avoid browser autofill from conflicting with Place Autocomplete. Star or comment bug https://crbug.com/587466 to request Chromium to honor autocomplete="off" attribute. -->
             
                    <input class="form-control" id="ship-address" name="location" required autocomplete="off" />
                </label>



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


    // This sample uses the Places Autocomplete widget to:
// 1. Help the user select a place
// 2. Retrieve the address components associated with that place
// 3. Populate the form fields with those address components.
// This sample requires the Places library, Maps JavaScript API.
// Include the libraries=places parameter when you first load the API.
// For example: <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
let autocomplete;
let address1Field;
let address2Field;
let postalField;

function initAutocomplete() {
  address1Field = document.querySelector("#ship-address");
  address2Field = document.querySelector("#address2");
  postalField = document.querySelector("#postcode");
  // Create the autocomplete object, restricting the search predictions to
  // addresses in the US and Canada.
  autocomplete = new google.maps.places.Autocomplete(address1Field, {
    componentRestrictions: { country: ["us", "ca"] },
    fields: ["address_components", "geometry"],
    types: ["address"],
  });
  address1Field.focus();
  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  const place = autocomplete.getPlace();
  let address1 = "";
  let postcode = "";

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  // place.address_components are google.maps.GeocoderAddressComponent objects
  // which are documented at http://goo.gle/3l5i5Mr
  for (const component of place.address_components) {
    const componentType = component.types[0];

    switch (componentType) {
      case "street_number": {
        address1 = `${component.long_name} ${address1}`;
        break;
      }

      case "route": {
        address1 += component.short_name;
        break;
      }

      case "postal_code": {
        postcode = `${component.long_name}${postcode}`;
        break;
      }

      case "postal_code_suffix": {
        postcode = `${postcode}-${component.long_name}`;
        break;
      }
      case "locality":
        document.querySelector("#locality").value = component.long_name;
        break;

      case "administrative_area_level_1": {
        document.querySelector("#state").value = component.short_name;
        break;
      }
      case "country":
        document.querySelector("#country").value = component.long_name;
        break;
    }
  }
  address1Field.value = address1;
  postalField.value = postcode;
  // After filling the form with address components from the Autocomplete
  // prediction, set cursor focus on the second address line to encourage
  // entry of subpremise information such as apartment, unit, or floor number.
  address2Field.focus();
}
</script>


@endsection