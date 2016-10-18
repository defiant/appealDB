@extends('layouts.app')

@section('content')

<div class="column column is-4 is-offset-4">
    <div class="box">
        <h1 class="title">Reset Password</h1>
        <form action="{{ url('/password/reset') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <label for="email" class="label">Email</label>
            <p class="control">
                <input type="email" name="email" id="email" class="input" required autofocus value="{{ $email or old('email') }}">
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

            <label for="password_confirmation" class="label">Confirm Password</label>
            <p class="control">
                <input type="password" name="password_confirmation" id="password_confirmation" class="input" required>
                @if ($errors->has('password_confirmation'))
                    <span class="help is-danger">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </p>

            <p class="control">
                <button class="button is-fulwidth">
                    Reset Password
                </button>
            </p>
        </form>
    </div>
</div>
@endsection
