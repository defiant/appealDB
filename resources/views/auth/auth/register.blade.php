@extends('layouts.app')

@section('content')

<div class="column is-4 is-offset-4">
    <div class="box">
        <h1 class="title is-1">Register</h1>

        <form action="{{ url('/register') }}" method="post">
            {{ csrf_field() }}

            <label for="name" class="label">Name</label>
            <p class="control">
                <input type="text" name="name" id="name" class="input" value="{{old('name')}}" required autofocus>
                @if ($errors->has('name'))
                    <span class="help is-danger">{{ $errors->first('name') }}</span>
                @endif
            </p>

            <label for="email" class="label">Email</label>
            <p class="control">
                <input type="email" name="email" id="email" class="input" required>
                @if ($errors->has('email'))
                    <span class="help is-danger">{{ $errors->first('email') }}</span>
                @endif
            </p>

            <label for="password" class="label">Password</label>
            <p class="control">
                <input type="password" name="password" id="password" class="input" required>
                @if ($errors->has('password'))
                    <span class="help is-danger">{{ $errors->first('password') }}</span>
                @endif
            </p>

            <label for="password_confirmation" class="label">Password Confirmation</label>
            <p class="control">
                <input type="password" name="password_confirmation" id="password_confirmation" class="input" required>
                @if ($errors->has('password_confirmation'))
                    <span class="help is-danger">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </p>

            <p class="control">
                <button class="button is-success is-fulwidth">
                    Register
                </button>
            </p>
            <a class="btn btn-link" href="{{ url('/login') }}">
                Already Member? Sign In
            </a>
        </form>
    </div>
</div>
@endsection