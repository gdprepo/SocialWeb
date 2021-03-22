const forms = document.querySelectorAll('#form-js');

forms.forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const url = this.getAttribute('action');
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const postId = this.querySelector('#post-id-js').value;
        const count = this.querySelector('#count-js');
        const like = this.querySelector('.fa-heart');


        console.log(like);

        fetch(url, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            method: 'POST',
            body: JSON.stringify({
                id: postId
            })
        }).then(response => {
            response.json().then(data => {
                count.innerHTML = data.count + " J'aime";
                if( data.check == true) {
                    like.style.color = "grey"

                } else {
                    like.style.color = "red"

                }
            })
        }).catch(error => {
            console.log(error)
        })
    })
});