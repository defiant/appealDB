@extends('layouts.clean')

<!-- Main Content -->
@section('content')
    <div class="column column is-4 is-offset-4">
        <div class="box">
            <form action="{{ url('/password/email') }}">
                {{ csrf_field() }}

                <label for="email" class="label">Email</label>
                <p class="control has-icon">
                    <input type="text" name="email" id="email" class="input" value="{{old('email')}}" required autofocus>
                    <i class="fa fa-envelope"></i>
                    @if ($errors->has('email'))
                        <span class="help is-danger">{{ $errors->first('email') }}</span>
                    @endif
                </p>

                <p class="control">
                    <button class="button is-fulwidth">
                        Send Password Reset Link
                    </button>
                </p>
            </form>
        </div>
    </div>@endsection
