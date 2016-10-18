@extends('layouts.app')

@section('content')

<div class="column is-4 is-offset-4">

    <div class="box">
        <h1 class="title">Login</h1>

        <form action="{{ url('/login') }}" method="post">
            {{ csrf_field() }}

            <label for="email" class="label">Email</label>
            <p class="control has-icon">
                <input type="text" name="email" id="email" class="input" value="{{old('email')}}" required autofocus>
                <i class="fa fa-envelope"></i>
                @if ($errors->has('email'))
                    <span class="help is-danger">This email is invalid</span>
                @endif
            </p>

            <label for="password" class="label">Password</label>
            <p class="control has-icon">
                <input type="password" name="password" id="password" class="input" required>
                <i class="fa fa-lock"></i>
            </p>
            @if($errors->has('email'))
                <span class="help is-danger">{{ $errors->first('password') }}</span>
            @endif

            <p class="control">
                <label class="checkbox" for="remember">
                    <input type="checkbox" name="remember" id="remember">
                    Remember me
                </label>
            </p>

            <p class="control">
                <button class="button is-success is-fulwidth">
                    Login
                </button>
            </p>
            <a class="btn btn-link" href="{{ url('/password/reset') }}">
                Forgot Your Password?
            </a>
        </form>
    </div>
</div>


@endsection
