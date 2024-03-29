@extends('layouts.app')

@section('content')

<style>
    html,
    body {
        height: 100%;
    }


    .form-signin {
        width: 100%;
        max-width: 400px;
        padding: 15px;
        margin: 0 auto;
        margin-top: -10px;
    }

    .form-signin .checkbox {
        font-weight: 400;
    }

    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
        letter-spacing: 4px;
    }

    .form-signin .form-control:focus {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>


<div style="margin-top: 0;" class="container">
    <div style="text-align: center; background: #c7c7c73d; padding: 40px" class="form-signin">
        <img class="mb-4 rounded-circle" src="{{ asset('img/user/username.gif') }}" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <a href="{{ route('login_fb') }}">
            <button style="width: 100%" class="btn btn-lg btn-primary btn-block mb-2"><i class="fab fa-facebook-f"></i></button>
        </a>
        <a href="{{ url('auth/google') }}">
            <button style="width: 100%" class="btn btn-lg btn-danger btn-block mb-4" type="submit"><i class="fab fa-google"></i></button>

        </a>
        <form method="post" action="{{ route('login') }}">
            @csrf
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required="">
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <div class="checkbox">
                    <a href="{{ route('register') }}">S'incscrire</a>
            </div>
            <button style="width: 100%" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">© 2017-2018</p>
        </form>
    </div>

</div>
@endsection